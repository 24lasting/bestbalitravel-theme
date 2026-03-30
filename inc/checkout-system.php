<?php
/**
 * Custom Checkout System (No WooCommerce)
 * 
 * Handles booking forms, pricing calculations, and order processing
 *
 * @package BestBaliTravel
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register Checkout Settings Admin Menu
 */
function bbt_register_checkout_menu() {
    add_submenu_page(
        'bbt-dashboard',
        __('Checkout Settings', 'bestbalitravel'),
        __('🛒 Checkout', 'bestbalitravel'),
        'manage_options',
        'bbt-checkout-settings',
        'bbt_checkout_settings_page'
    );
}
add_action('admin_menu', 'bbt_register_checkout_menu', 15);

/**
 * Checkout Settings Page
 */
function bbt_checkout_settings_page() {
    // Save settings
    if (isset($_POST['bbt_save_checkout']) && wp_verify_nonce($_POST['bbt_checkout_nonce'], 'bbt_checkout_settings')) {
        update_option('bbt_checkout_base_persons', absint($_POST['bbt_base_persons']));
        update_option('bbt_checkout_additional_percent', floatval($_POST['bbt_additional_percent']));
        update_option('bbt_checkout_whatsapp', sanitize_text_field($_POST['bbt_whatsapp_number']));
        update_option('bbt_checkout_email', sanitize_email($_POST['bbt_booking_email']));
        update_option('bbt_checkout_min_notice', absint($_POST['bbt_min_notice']));
        update_option('bbt_checkout_terms_url', esc_url_raw($_POST['bbt_terms_url']));
        update_option('bbt_checkout_confirmation_msg', sanitize_textarea_field($_POST['bbt_confirmation_msg']));
        update_option('bbt_checkout_enable_email', isset($_POST['bbt_enable_email']) ? 1 : 0);
        
        echo '<div class="notice notice-success"><p>' . esc_html__('Checkout settings saved!', 'bestbalitravel') . '</p></div>';
    }

    // Get current settings
    $base_persons = get_option('bbt_checkout_base_persons', 2);
    $additional_percent = get_option('bbt_checkout_additional_percent', 30);
    $whatsapp = get_option('bbt_checkout_whatsapp', '+6287854806011');
    $booking_email = get_option('bbt_checkout_email', get_option('admin_email'));
    $min_notice = get_option('bbt_checkout_min_notice', 24);
    $terms_url = get_option('bbt_checkout_terms_url', '');
    $confirmation_msg = get_option('bbt_checkout_confirmation_msg', 'Thank you for your booking! We will contact you shortly.');
    $enable_email = get_option('bbt_checkout_enable_email', 1);
    ?>
    <div class="wrap bbt-settings-wrap">
        <h1 style="display:flex;align-items:center;gap:10px;">
            <span style="font-size:32px;">🛒</span>
            <?php esc_html_e('Checkout Settings', 'bestbalitravel'); ?>
        </h1>
        <p style="color:#666;margin-top:-10px;"><?php esc_html_e('Configure booking and checkout options (No WooCommerce required)', 'bestbalitravel'); ?></p>

        <form method="post" class="bbt-settings-form">
            <?php wp_nonce_field('bbt_checkout_settings', 'bbt_checkout_nonce'); ?>

            <!-- Pricing Settings -->
            <div class="bbt-settings-card" style="background:#fff;padding:25px;border-radius:12px;box-shadow:0 2px 8px rgba(0,0,0,0.08);margin-top:20px;">
                <h2 style="margin-top:0;border-bottom:2px solid #f5a623;padding-bottom:10px;display:flex;align-items:center;gap:10px;">
                    💰 <?php esc_html_e('Pricing Configuration', 'bestbalitravel'); ?>
                </h2>
                
                <div style="background:#fef3c7;border-left:4px solid #f5a623;padding:15px;border-radius:8px;margin-bottom:20px;">
                    <strong>📌 <?php esc_html_e('How Pricing Works:', 'bestbalitravel'); ?></strong><br>
                    <?php esc_html_e('Tour price is set per tour. This setting defines how pricing scales with group size.', 'bestbalitravel'); ?>
                </div>

                <table class="form-table" style="margin:0;">
                    <tr>
                        <th style="width:200px;">
                            <label for="bbt_base_persons"><?php esc_html_e('Base Price for', 'bestbalitravel'); ?></label>
                        </th>
                        <td>
                            <div style="display:flex;align-items:center;gap:10px;">
                                <input type="number" id="bbt_base_persons" name="bbt_base_persons" 
                                       value="<?php echo esc_attr($base_persons); ?>" 
                                       min="1" max="10" style="width:80px;padding:10px;font-size:16px;text-align:center;">
                                <span style="font-size:16px;"><?php esc_html_e('Person(s)', 'bestbalitravel'); ?></span>
                            </div>
                            <p class="description"><?php esc_html_e('The displayed price covers this many people.', 'bestbalitravel'); ?></p>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <label for="bbt_additional_percent"><?php esc_html_e('Additional Person', 'bestbalitravel'); ?></label>
                        </th>
                        <td>
                            <div style="display:flex;align-items:center;gap:10px;">
                                <span style="font-size:16px;">+</span>
                                <input type="number" id="bbt_additional_percent" name="bbt_additional_percent" 
                                       value="<?php echo esc_attr($additional_percent); ?>" 
                                       min="0" max="100" step="5" style="width:80px;padding:10px;font-size:16px;text-align:center;">
                                <span style="font-size:16px;">%</span>
                                <span style="color:#666;"><?php esc_html_e('of base price per person', 'bestbalitravel'); ?></span>
                            </div>
                            <p class="description"><?php esc_html_e('Example: If base price is Rp 1,000,000 for 2 persons, 3rd person adds Rp 300,000 (30%)', 'bestbalitravel'); ?></p>
                        </td>
                    </tr>
                </table>

                <!-- Pricing Calculator Preview -->
                <div style="background:#f8fafc;border-radius:12px;padding:20px;margin-top:20px;">
                    <h4 style="margin-top:0;">🧮 <?php esc_html_e('Pricing Calculator Preview', 'bestbalitravel'); ?></h4>
                    <p style="color:#666;margin-bottom:15px;"><?php esc_html_e('Example with base price Rp 1,000,000:', 'bestbalitravel'); ?></p>
                    <div id="pricing-preview" style="display:grid;grid-template-columns:repeat(auto-fill,minmax(150px,1fr));gap:10px;">
                        <?php for ($i = 1; $i <= 6; $i++): ?>
                        <div style="background:white;padding:12px;border-radius:8px;text-align:center;border:1px solid #e5e7eb;">
                            <div style="font-size:24px;margin-bottom:4px;">👥 <?php echo $i; ?></div>
                            <div style="font-weight:600;color:#f5a623;" id="price-<?php echo $i; ?>">
                                <?php
                                $base = 1000000;
                                if ($i <= $base_persons) {
                                    $price = $base;
                                } else {
                                    $extra = $i - $base_persons;
                                    $price = $base + ($base * ($additional_percent / 100) * $extra);
                                }
                                echo 'Rp ' . number_format($price, 0, ',', '.');
                                ?>
                            </div>
                        </div>
                        <?php endfor; ?>
                    </div>
                </div>
            </div>

            <!-- Contact Settings -->
            <div class="bbt-settings-card" style="background:#fff;padding:25px;border-radius:12px;box-shadow:0 2px 8px rgba(0,0,0,0.08);margin-top:20px;">
                <h2 style="margin-top:0;border-bottom:2px solid #25D366;padding-bottom:10px;display:flex;align-items:center;gap:10px;">
                    📞 <?php esc_html_e('Booking Contact', 'bestbalitravel'); ?>
                </h2>
                
                <table class="form-table" style="margin:0;">
                    <tr>
                        <th style="width:200px;">
                            <label for="bbt_whatsapp_number"><?php esc_html_e('WhatsApp Number', 'bestbalitravel'); ?></label>
                        </th>
                        <td>
                            <input type="text" id="bbt_whatsapp_number" name="bbt_whatsapp_number" 
                                   value="<?php echo esc_attr($whatsapp); ?>" 
                                   class="regular-text" placeholder="+6287854806011" style="padding:10px;">
                            <p class="description"><?php esc_html_e('Bookings will be redirected to this WhatsApp number.', 'bestbalitravel'); ?></p>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <label for="bbt_booking_email"><?php esc_html_e('Booking Email', 'bestbalitravel'); ?></label>
                        </th>
                        <td>
                            <input type="email" id="bbt_booking_email" name="bbt_booking_email" 
                                   value="<?php echo esc_attr($booking_email); ?>" 
                                   class="regular-text" style="padding:10px;">
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <label for="bbt_enable_email"><?php esc_html_e('Email Notifications', 'bestbalitravel'); ?></label>
                        </th>
                        <td>
                            <label style="display:flex;align-items:center;gap:10px;">
                                <input type="checkbox" id="bbt_enable_email" name="bbt_enable_email" value="1" 
                                       <?php checked($enable_email, 1); ?> style="width:20px;height:20px;">
                                <?php esc_html_e('Send email notification for new bookings', 'bestbalitravel'); ?>
                            </label>
                        </td>
                    </tr>
                </table>
            </div>

            <!-- Booking Settings -->
            <div class="bbt-settings-card" style="background:#fff;padding:25px;border-radius:12px;box-shadow:0 2px 8px rgba(0,0,0,0.08);margin-top:20px;">
                <h2 style="margin-top:0;border-bottom:2px solid #3b82f6;padding-bottom:10px;display:flex;align-items:center;gap:10px;">
                    📅 <?php esc_html_e('Booking Options', 'bestbalitravel'); ?>
                </h2>
                
                <table class="form-table" style="margin:0;">
                    <tr>
                        <th style="width:200px;">
                            <label for="bbt_min_notice"><?php esc_html_e('Minimum Notice', 'bestbalitravel'); ?></label>
                        </th>
                        <td>
                            <div style="display:flex;align-items:center;gap:10px;">
                                <input type="number" id="bbt_min_notice" name="bbt_min_notice" 
                                       value="<?php echo esc_attr($min_notice); ?>" 
                                       min="0" max="168" style="width:80px;padding:10px;font-size:16px;text-align:center;">
                                <span><?php esc_html_e('Hours', 'bestbalitravel'); ?></span>
                            </div>
                            <p class="description"><?php esc_html_e('Minimum hours before tour date that booking is allowed.', 'bestbalitravel'); ?></p>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <label for="bbt_terms_url"><?php esc_html_e('Terms & Conditions URL', 'bestbalitravel'); ?></label>
                        </th>
                        <td>
                            <input type="url" id="bbt_terms_url" name="bbt_terms_url" 
                                   value="<?php echo esc_url($terms_url); ?>" 
                                   class="regular-text" placeholder="https://yoursite.com/terms" style="padding:10px;">
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <label for="bbt_confirmation_msg"><?php esc_html_e('Confirmation Message', 'bestbalitravel'); ?></label>
                        </th>
                        <td>
                            <textarea id="bbt_confirmation_msg" name="bbt_confirmation_msg" 
                                      rows="3" class="large-text" style="padding:10px;"><?php echo esc_textarea($confirmation_msg); ?></textarea>
                            <p class="description"><?php esc_html_e('Message shown after successful booking.', 'bestbalitravel'); ?></p>
                        </td>
                    </tr>
                </table>
            </div>

            <p style="margin-top:20px;">
                <button type="submit" name="bbt_save_checkout" class="button button-primary button-hero" 
                        style="background:linear-gradient(135deg,#f5a623,#e69316);border:none;padding:12px 40px;font-size:16px;">
                    💾 <?php esc_html_e('Save Checkout Settings', 'bestbalitravel'); ?>
                </button>
            </p>
        </form>
    </div>
    <?php
}

/**
 * Calculate price based on number of persons
 */
function bbt_calculate_price($base_price, $num_persons) {
    $base_persons = get_option('bbt_checkout_base_persons', 2);
    $additional_percent = get_option('bbt_checkout_additional_percent', 30);
    
    if ($num_persons <= $base_persons) {
        return $base_price;
    }
    
    $extra_persons = $num_persons - $base_persons;
    $additional_per_person = $base_price * ($additional_percent / 100);
    
    return $base_price + ($additional_per_person * $extra_persons);
}

/**
 * Format price in IDR (only if not already defined in template-functions.php)
 */
if (!function_exists('bbt_format_price')) {
    function bbt_format_price($amount) {
        return 'Rp ' . number_format($amount, 0, ',', '.');
    }
}

/**
 * AJAX: Calculate Price
 */
function bbt_ajax_calculate_price() {
    check_ajax_referer('bbt_nonce', 'nonce');
    
    $base_price = floatval($_POST['base_price']);
    $num_persons = absint($_POST['num_persons']);
    
    $total = bbt_calculate_price($base_price, $num_persons);
    
    wp_send_json_success(array(
        'total' => $total,
        'formatted' => bbt_format_price($total),
        'per_person' => bbt_format_price($total / $num_persons),
    ));
}
add_action('wp_ajax_bbt_calculate_price', 'bbt_ajax_calculate_price');
add_action('wp_ajax_nopriv_bbt_calculate_price', 'bbt_ajax_calculate_price');

/**
 * AJAX: Process Booking
 */
function bbt_ajax_process_booking() {
    check_ajax_referer('bbt_nonce', 'nonce');
    
    $tour_id = absint($_POST['tour_id']);
    $tour_name = get_the_title($tour_id);
    $name = sanitize_text_field($_POST['customer_name']);
    $email = sanitize_email($_POST['customer_email']);
    $phone = sanitize_text_field($_POST['customer_phone']);
    $date = sanitize_text_field($_POST['booking_date']);
    $persons = absint($_POST['num_persons']);
    $notes = sanitize_textarea_field($_POST['notes']);
    
    $base_price = floatval(get_post_meta($tour_id, '_tour_price', true));
    $total = bbt_calculate_price($base_price, $persons);
    
    // Store booking in database (custom table or post type)
    $booking_data = array(
        'tour_id' => $tour_id,
        'tour_name' => $tour_name,
        'customer_name' => $name,
        'customer_email' => $email,
        'customer_phone' => $phone,
        'booking_date' => $date,
        'num_persons' => $persons,
        'total_price' => $total,
        'notes' => $notes,
        'status' => 'pending',
        'created_at' => current_time('mysql'),
    );
    
    // Save as post meta or custom table (simplified: use transient for demo)
    $booking_id = 'BBT-' . time() . '-' . wp_rand(1000, 9999);
    set_transient('bbt_booking_' . $booking_id, $booking_data, DAY_IN_SECONDS * 30);
    
    // Send email notification
    if (get_option('bbt_checkout_enable_email', 1)) {
        bbt_send_booking_email($booking_data, $booking_id);
    }
    
    // Generate WhatsApp message
    $whatsapp_number = get_option('bbt_checkout_whatsapp', '+6287854806011');
    $whatsapp_number = preg_replace('/[^0-9]/', '', $whatsapp_number);
    
    $wa_message = sprintf(
        "🌴 *New Booking Request*\n\n" .
        "📋 *Booking ID:* %s\n" .
        "🎯 *Tour:* %s\n" .
        "👤 *Name:* %s\n" .
        "📧 *Email:* %s\n" .
        "📱 *Phone:* %s\n" .
        "📅 *Date:* %s\n" .
        "👥 *Persons:* %d\n" .
        "💰 *Total:* %s\n\n" .
        "📝 *Notes:* %s",
        $booking_id,
        $tour_name,
        $name,
        $email,
        $phone,
        $date,
        $persons,
        bbt_format_price($total),
        $notes ?: '-'
    );
    
    $whatsapp_url = 'https://wa.me/' . $whatsapp_number . '?text=' . urlencode($wa_message);
    
    wp_send_json_success(array(
        'booking_id' => $booking_id,
        'message' => get_option('bbt_checkout_confirmation_msg', 'Thank you for your booking!'),
        'whatsapp_url' => $whatsapp_url,
        'total' => bbt_format_price($total),
    ));
}
add_action('wp_ajax_bbt_process_booking', 'bbt_ajax_process_booking');
add_action('wp_ajax_nopriv_bbt_process_booking', 'bbt_ajax_process_booking');

/**
 * Send booking email
 */
function bbt_send_booking_email($booking, $booking_id) {
    $to = get_option('bbt_checkout_email', get_option('admin_email'));
    $subject = sprintf('[New Booking] %s - %s', $booking['tour_name'], $booking_id);
    
    $message = sprintf(
        "New booking received!\n\n" .
        "Booking ID: %s\n" .
        "Tour: %s\n" .
        "Customer: %s\n" .
        "Email: %s\n" .
        "Phone: %s\n" .
        "Date: %s\n" .
        "Persons: %d\n" .
        "Total: %s\n" .
        "Notes: %s\n",
        $booking_id,
        $booking['tour_name'],
        $booking['customer_name'],
        $booking['customer_email'],
        $booking['customer_phone'],
        $booking['booking_date'],
        $booking['num_persons'],
        bbt_format_price($booking['total_price']),
        $booking['notes'] ?: '-'
    );
    
    wp_mail($to, $subject, $message);
}

/**
 * Render Floating Checkout Bar (for single tour pages)
 */
function bbt_render_floating_checkout() {
    if (!is_singular('tour')) {
        return;
    }
    
    $tour_id = get_the_ID();
    $price = get_post_meta($tour_id, '_tour_price', true);
    $duration = get_post_meta($tour_id, '_tour_duration', true);
    $rating = get_post_meta($tour_id, '_tour_rating', true) ?: 4.8;
    $base_persons = get_option('bbt_checkout_base_persons', 2);
    $additional_percent = get_option('bbt_checkout_additional_percent', 30);
    ?>
    <!-- Floating Checkout Bar -->
    <div class="floating-checkout" 
         x-data="floatingCheckout({
             tourId: <?php echo esc_js($tour_id); ?>,
             tourName: '<?php echo esc_js(get_the_title()); ?>',
             basePrice: <?php echo floatval($price); ?>,
             basePersons: <?php echo esc_js($base_persons); ?>,
             additionalPercent: <?php echo esc_js($additional_percent); ?>
         })"
         x-show="visible"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="translate-y-full opacity-0"
         x-transition:enter-end="translate-y-0 opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="translate-y-0 opacity-100"
         x-transition:leave-end="translate-y-full opacity-0"
         @scroll.window="checkScroll()"
         x-cloak>
        
        <div class="floating-checkout-inner">
            <div class="checkout-info">
                <div class="checkout-title"><?php the_title(); ?></div>
                <div class="checkout-meta">
                    <?php if ($duration): ?>
                        <span>⏱️ <?php echo esc_html($duration); ?></span>
                    <?php endif; ?>
                    <span>⭐ <?php echo esc_html(number_format((float)$rating, 1)); ?></span>
                </div>
            </div>
            
            <div class="checkout-price">
                <span class="price-label"><?php esc_html_e('From', 'bestbalitravel'); ?></span>
                <span class="price-amount" x-text="formattedPrice"><?php echo bbt_format_price($price); ?></span>
                <span class="price-per">/<?php echo $base_persons; ?> <?php esc_html_e('pax', 'bestbalitravel'); ?></span>
            </div>
            
            <button type="button" class="checkout-btn" @click="openModal()">
                <?php esc_html_e('Book Now', 'bestbalitravel'); ?>
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M5 12h14M12 5l7 7-7 7"/>
                </svg>
            </button>
        </div>
    </div>
    
    <!-- Booking Modal -->
    <div class="booking-modal-overlay" 
         x-show="modalOpen" 
         @click.self="closeModal()"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-cloak>
        
        <div class="booking-modal"
             x-show="modalOpen"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="scale-95 opacity-0"
             x-transition:enter-end="scale-100 opacity-100">
            
            <button type="button" class="modal-close" @click="closeModal()">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M18 6L6 18M6 6l12 12"/>
                </svg>
            </button>
            
            <div class="modal-header">
                <h3><?php esc_html_e('Book This Tour', 'bestbalitravel'); ?></h3>
                <p class="tour-name"><?php the_title(); ?></p>
            </div>
            
            <form @submit.prevent="submitBooking()" class="booking-form">
                <!-- Step 1: Date & Persons -->
                <div class="form-step" x-show="step === 1">
                    <div class="form-group">
                        <label><?php esc_html_e('Select Date', 'bestbalitravel'); ?></label>
                        <input type="date" x-model="form.date" required 
                               min="<?php echo date('Y-m-d', strtotime('+' . get_option('bbt_checkout_min_notice', 24) . ' hours')); ?>">
                    </div>
                    
                    <div class="form-group">
                        <label><?php esc_html_e('Number of Persons', 'bestbalitravel'); ?></label>
                        <div class="persons-selector">
                            <button type="button" @click="decrementPersons()" :disabled="form.persons <= 1">−</button>
                            <span x-text="form.persons"></span>
                            <button type="button" @click="incrementPersons()">+</button>
                        </div>
                    </div>
                    
                    <div class="price-summary">
                        <div class="price-row">
                            <span><?php esc_html_e('Base Price', 'bestbalitravel'); ?> (<span x-text="basePersons"></span> <?php esc_html_e('pax', 'bestbalitravel'); ?>)</span>
                            <span x-text="formatPrice(basePrice)"></span>
                        </div>
                        <div class="price-row" x-show="form.persons > basePersons">
                            <span><?php esc_html_e('Additional', 'bestbalitravel'); ?> (<span x-text="form.persons - basePersons"></span> <?php esc_html_e('pax', 'bestbalitravel'); ?>)</span>
                            <span x-text="formatPrice(additionalCost)"></span>
                        </div>
                        <div class="price-row total">
                            <span><?php esc_html_e('Total', 'bestbalitravel'); ?></span>
                            <span x-text="formatPrice(totalPrice)"></span>
                        </div>
                    </div>
                    
                    <button type="button" class="btn-next" @click="nextStep()" :disabled="!form.date">
                        <?php esc_html_e('Continue', 'bestbalitravel'); ?> →
                    </button>
                </div>
                
                <!-- Step 2: Contact Info -->
                <div class="form-step" x-show="step === 2">
                    <div class="form-group">
                        <label><?php esc_html_e('Full Name', 'bestbalitravel'); ?></label>
                        <input type="text" x-model="form.name" required placeholder="<?php esc_attr_e('Enter your name', 'bestbalitravel'); ?>">
                    </div>
                    
                    <div class="form-group">
                        <label><?php esc_html_e('Email', 'bestbalitravel'); ?></label>
                        <input type="email" x-model="form.email" required placeholder="<?php esc_attr_e('your@email.com', 'bestbalitravel'); ?>">
                    </div>
                    
                    <div class="form-group">
                        <label><?php esc_html_e('WhatsApp Number', 'bestbalitravel'); ?></label>
                        <input type="tel" x-model="form.phone" required placeholder="<?php esc_attr_e('+62 xxx xxx xxx', 'bestbalitravel'); ?>">
                    </div>
                    
                    <div class="form-group">
                        <label><?php esc_html_e('Special Requests (Optional)', 'bestbalitravel'); ?></label>
                        <textarea x-model="form.notes" rows="2" placeholder="<?php esc_attr_e('Any special requests...', 'bestbalitravel'); ?>"></textarea>
                    </div>
                    
                    <div class="form-buttons">
                        <button type="button" class="btn-back" @click="prevStep()">← <?php esc_html_e('Back', 'bestbalitravel'); ?></button>
                        <button type="submit" class="btn-submit" :disabled="loading">
                            <span x-show="!loading"><?php esc_html_e('Confirm Booking', 'bestbalitravel'); ?></span>
                            <span x-show="loading"><?php esc_html_e('Processing...', 'bestbalitravel'); ?></span>
                        </button>
                    </div>
                </div>
                
                <!-- Step 3: Success -->
                <div class="form-step success-step" x-show="step === 3">
                    <div class="success-icon">✅</div>
                    <h4><?php esc_html_e('Booking Confirmed!', 'bestbalitravel'); ?></h4>
                    <p x-text="successMessage"></p>
                    <p class="booking-id"><?php esc_html_e('Booking ID:', 'bestbalitravel'); ?> <strong x-text="bookingId"></strong></p>
                    
                    <a :href="whatsappUrl" target="_blank" class="btn-whatsapp">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                        </svg>
                        <?php esc_html_e('Continue on WhatsApp', 'bestbalitravel'); ?>
                    </a>
                </div>
            </form>
        </div>
    </div>
    <?php
}
add_action('wp_footer', 'bbt_render_floating_checkout');
