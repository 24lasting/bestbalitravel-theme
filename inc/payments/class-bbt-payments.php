<?php
/**
 * Payment Gateway Manager
 * Handles Midtrans, Stripe, and Wise integrations
 *
 * @package BestBaliTravel
 */

if (!defined('ABSPATH')) {
    exit;
}

class BBT_Payment_Manager
{

    private static $instance = null;

    private $settings = array();
    private $active_gateways = array();

    public static function get_instance()
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct()
    {
        $this->settings = get_option('bbt_settings', array());
        $this->init_gateways();

        // Enqueue payment scripts
        add_action('wp_enqueue_scripts', array($this, 'enqueue_payment_scripts'));

        // AJAX handlers
        add_action('wp_ajax_bbt_process_payment', array($this, 'ajax_process_payment'));
        add_action('wp_ajax_nopriv_bbt_process_payment', array($this, 'ajax_process_payment'));

        // Payment callbacks/webhooks
        add_action('wp_ajax_nopriv_bbt_midtrans_callback', array($this, 'midtrans_callback'));
        add_action('wp_ajax_nopriv_bbt_stripe_webhook', array($this, 'stripe_webhook'));
    }

    /**
     * Initialize active payment gateways
     */
    private function init_gateways()
    {
        if (!empty($this->settings['midtrans_enabled'])) {
            $this->active_gateways['midtrans'] = array(
                'name' => 'Midtrans',
                'description' => 'Pay with GoPay, OVO, DANA, Bank Transfer, or Credit Card',
                'icon' => BBT_THEME_ASSETS . '/images/midtrans-methods.png',
            );
        }

        if (!empty($this->settings['stripe_enabled'])) {
            $this->active_gateways['stripe'] = array(
                'name' => 'Stripe',
                'description' => 'Pay with Credit Card, Apple Pay, or Google Pay',
                'icon' => BBT_THEME_ASSETS . '/images/stripe-methods.png',
            );
        }

        if (!empty($this->settings['wise_enabled'])) {
            $this->active_gateways['wise'] = array(
                'name' => 'Wise',
                'description' => 'International bank transfer with low fees',
                'icon' => BBT_THEME_ASSETS . '/images/wise-logo.png',
            );
        }
    }

    /**
     * Enqueue payment scripts
     */
    public function enqueue_payment_scripts()
    {
        if (!is_singular('tour') && !is_page('checkout')) {
            return;
        }

        // Midtrans Snap
        if (!empty($this->settings['midtrans_enabled'])) {
            $is_sandbox = !empty($this->settings['midtrans_sandbox']);
            $snap_url = $is_sandbox
                ? 'https://app.sandbox.midtrans.com/snap/snap.js'
                : 'https://app.midtrans.com/snap/snap.js';

            wp_enqueue_script(
                'midtrans-snap',
                $snap_url,
                array(),
                null,
                true
            );

            wp_add_inline_script(
                'midtrans-snap',
                'window.midtransClientKey = "' . esc_js($this->settings['midtrans_client_key'] ?? '') . '";',
                'before'
            );
        }

        // Stripe
        if (!empty($this->settings['stripe_enabled'])) {
            wp_enqueue_script(
                'stripe-js',
                'https://js.stripe.com/v3/',
                array(),
                null,
                true
            );

            wp_add_inline_script(
                'stripe-js',
                'window.stripePublishableKey = "' . esc_js($this->settings['stripe_publishable_key'] ?? '') . '";',
                'before'
            );
        }

        // Payment handler script
        wp_enqueue_script(
            'bbt-payments',
            BBT_THEME_ASSETS . '/js/payments.js',
            array('jquery'),
            BBT_THEME_VERSION,
            true
        );

        wp_localize_script('bbt-payments', 'bbtPayments', array(
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('bbt_payment_nonce'),
            'gateways' => $this->active_gateways,
        ));
    }

    /**
     * Get available payment methods
     */
    public function get_available_gateways()
    {
        return $this->active_gateways;
    }

    /**
     * AJAX: Process payment
     */
    public function ajax_process_payment()
    {
        check_ajax_referer('bbt_payment_nonce', 'nonce');

        $gateway = sanitize_text_field($_POST['gateway'] ?? '');
        $booking_data = array(
            'tour_id' => intval($_POST['tour_id'] ?? 0),
            'tour_name' => sanitize_text_field($_POST['tour_name'] ?? ''),
            'tour_date' => sanitize_text_field($_POST['tour_date'] ?? ''),
            'adults' => intval($_POST['adults'] ?? 1),
            'children' => intval($_POST['children'] ?? 0),
            'total' => floatval($_POST['total'] ?? 0),
            'customer_name' => sanitize_text_field($_POST['customer_name'] ?? ''),
            'customer_email' => sanitize_email($_POST['customer_email'] ?? ''),
            'customer_phone' => sanitize_text_field($_POST['customer_phone'] ?? ''),
        );

        switch ($gateway) {
            case 'midtrans':
                $result = $this->process_midtrans_payment($booking_data);
                break;
            case 'stripe':
                $result = $this->process_stripe_payment($booking_data);
                break;
            case 'wise':
                $result = $this->process_wise_payment($booking_data);
                break;
            default:
                wp_send_json_error(array('message' => 'Invalid payment gateway'));
        }

        if ($result['success']) {
            wp_send_json_success($result['data']);
        } else {
            wp_send_json_error($result['data']);
        }
    }

    /**
     * Process Midtrans payment
     */
    private function process_midtrans_payment($booking_data)
    {
        $is_sandbox = !empty($this->settings['midtrans_sandbox']);
        $server_key = $this->settings['midtrans_server_key'] ?? '';

        if (empty($server_key)) {
            return array('success' => false, 'data' => array('message' => 'Midtrans not configured'));
        }

        $order_id = 'BBT-' . time() . '-' . wp_rand(1000, 9999);

        $transaction_details = array(
            'order_id' => $order_id,
            'gross_amount' => intval($booking_data['total']),
        );

        $customer_details = array(
            'first_name' => $booking_data['customer_name'],
            'email' => $booking_data['customer_email'],
            'phone' => $booking_data['customer_phone'],
        );

        $item_details = array(
            array(
                'id' => 'TOUR-' . $booking_data['tour_id'],
                'price' => intval($booking_data['total']),
                'quantity' => 1,
                'name' => substr($booking_data['tour_name'], 0, 50),
            ),
        );

        $params = array(
            'transaction_details' => $transaction_details,
            'customer_details' => $customer_details,
            'item_details' => $item_details,
        );

        $api_url = $is_sandbox
            ? 'https://app.sandbox.midtrans.com/snap/v1/transactions'
            : 'https://app.midtrans.com/snap/v1/transactions';

        $response = wp_remote_post($api_url, array(
            'headers' => array(
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'Authorization' => 'Basic ' . base64_encode($server_key . ':'),
            ),
            'body' => json_encode($params),
            'timeout' => 30,
        ));

        if (is_wp_error($response)) {
            return array('success' => false, 'data' => array('message' => 'Connection error'));
        }

        $body = json_decode(wp_remote_retrieve_body($response), true);

        if (!empty($body['token'])) {
            // Store booking in database
            $this->save_booking($order_id, $booking_data, 'pending');

            return array(
                'success' => true,
                'data' => array(
                    'snap_token' => $body['token'],
                    'redirect_url' => $body['redirect_url'] ?? '',
                    'order_id' => $order_id,
                ),
            );
        }

        return array('success' => false, 'data' => array('message' => $body['error_messages'][0] ?? 'Payment error'));
    }

    /**
     * Process Stripe payment
     */
    private function process_stripe_payment($booking_data)
    {
        $secret_key = $this->settings['stripe_secret_key'] ?? '';

        if (empty($secret_key)) {
            return array('success' => false, 'data' => array('message' => 'Stripe not configured'));
        }

        $order_id = 'BBT-' . time() . '-' . wp_rand(1000, 9999);

        // Convert to smallest currency unit (cents)
        $amount = intval($booking_data['total'] * 100);

        $response = wp_remote_post('https://api.stripe.com/v1/payment_intents', array(
            'headers' => array(
                'Authorization' => 'Bearer ' . $secret_key,
                'Content-Type' => 'application/x-www-form-urlencoded',
            ),
            'body' => array(
                'amount' => $amount,
                'currency' => 'usd',
                'description' => $booking_data['tour_name'],
                'metadata[order_id]' => $order_id,
                'metadata[tour_id]' => $booking_data['tour_id'],
                'metadata[customer_email]' => $booking_data['customer_email'],
            ),
            'timeout' => 30,
        ));

        if (is_wp_error($response)) {
            return array('success' => false, 'data' => array('message' => 'Connection error'));
        }

        $body = json_decode(wp_remote_retrieve_body($response), true);

        if (!empty($body['client_secret'])) {
            // Store booking in database
            $this->save_booking($order_id, $booking_data, 'pending');

            return array(
                'success' => true,
                'data' => array(
                    'client_secret' => $body['client_secret'],
                    'order_id' => $order_id,
                ),
            );
        }

        return array('success' => false, 'data' => array('message' => $body['error']['message'] ?? 'Payment error'));
    }

    /**
     * Process Wise payment (bank transfer)
     */
    private function process_wise_payment($booking_data)
    {
        $wise_email = $this->settings['wise_email'] ?? '';

        if (empty($wise_email)) {
            return array('success' => false, 'data' => array('message' => 'Wise not configured'));
        }

        $order_id = 'BBT-' . time() . '-' . wp_rand(1000, 9999);

        // Store booking in database
        $this->save_booking($order_id, $booking_data, 'awaiting_payment');

        // Return bank transfer instructions
        return array(
            'success' => true,
            'data' => array(
                'type' => 'bank_transfer',
                'order_id' => $order_id,
                'amount' => $booking_data['total'],
                'wise_email' => $wise_email,
                'instructions' => sprintf(
                    __('Please send payment to our Wise account: %s. Use order ID %s as reference.', 'bestbalitravel'),
                    $wise_email,
                    $order_id
                ),
            ),
        );
    }

    /**
     * Save booking to database
     */
    private function save_booking($order_id, $booking_data, $status)
    {
        $booking_post = array(
            'post_title' => $order_id,
            'post_type' => 'bbt_booking',
            'post_status' => 'publish',
        );

        $post_id = wp_insert_post($booking_post);

        if ($post_id) {
            update_post_meta($post_id, '_bbt_order_id', $order_id);
            update_post_meta($post_id, '_bbt_tour_id', $booking_data['tour_id']);
            update_post_meta($post_id, '_bbt_tour_name', $booking_data['tour_name']);
            update_post_meta($post_id, '_bbt_tour_date', $booking_data['tour_date']);
            update_post_meta($post_id, '_bbt_adults', $booking_data['adults']);
            update_post_meta($post_id, '_bbt_children', $booking_data['children']);
            update_post_meta($post_id, '_bbt_total', $booking_data['total']);
            update_post_meta($post_id, '_bbt_customer_name', $booking_data['customer_name']);
            update_post_meta($post_id, '_bbt_customer_email', $booking_data['customer_email']);
            update_post_meta($post_id, '_bbt_customer_phone', $booking_data['customer_phone']);
            update_post_meta($post_id, '_bbt_payment_status', $status);
            update_post_meta($post_id, '_bbt_created_at', current_time('mysql'));
        }

        return $post_id;
    }

    /**
     * Midtrans callback handler
     */
    public function midtrans_callback()
    {
        $input = file_get_contents('php://input');
        $notification = json_decode($input, true);

        if (!$notification) {
            http_response_code(400);
            exit;
        }

        $order_id = $notification['order_id'] ?? '';
        $transaction_status = $notification['transaction_status'] ?? '';
        $fraud_status = $notification['fraud_status'] ?? '';

        // Validate signature
        $server_key = $this->settings['midtrans_server_key'] ?? '';
        $signature_key = hash(
            'sha512',
            $notification['order_id'] .
            $notification['status_code'] .
            $notification['gross_amount'] .
            $server_key
        );

        if ($signature_key !== $notification['signature_key']) {
            http_response_code(403);
            exit;
        }

        // Update booking status
        $this->update_booking_status($order_id, $transaction_status);

        http_response_code(200);
        exit;
    }

    /**
     * Update booking status
     */
    private function update_booking_status($order_id, $status)
    {
        $args = array(
            'post_type' => 'bbt_booking',
            'meta_query' => array(
                array(
                    'key' => '_bbt_order_id',
                    'value' => $order_id,
                ),
            ),
        );

        $bookings = get_posts($args);

        if (!empty($bookings)) {
            $booking_id = $bookings[0]->ID;
            update_post_meta($booking_id, '_bbt_payment_status', $status);

            // Send notifications if payment is successful
            if (in_array($status, array('capture', 'settlement', 'succeeded'))) {
                $this->trigger_booking_notifications($booking_id);
            }
        }
    }

    /**
     * Trigger booking notifications
     */
    private function trigger_booking_notifications($booking_id)
    {
        $booking_data = array(
            'booking_id' => get_post_meta($booking_id, '_bbt_order_id', true),
            'tour_name' => get_post_meta($booking_id, '_bbt_tour_name', true),
            'tour_date' => get_post_meta($booking_id, '_bbt_tour_date', true),
            'customer_name' => get_post_meta($booking_id, '_bbt_customer_name', true),
            'customer_email' => get_post_meta($booking_id, '_bbt_customer_email', true),
            'guests' => get_post_meta($booking_id, '_bbt_adults', true) . ' Adults, ' . get_post_meta($booking_id, '_bbt_children', true) . ' Children',
            'total_price' => bbt_format_price(get_post_meta($booking_id, '_bbt_total', true)),
        );

        // Send customer confirmation
        if (class_exists('BBT_Email_Manager')) {
            BBT_Email_Manager::get_instance()->send_booking_confirmation($booking_data);
            BBT_Email_Manager::get_instance()->send_admin_notification($booking_data);
        }
    }

    /**
     * Render payment methods selector
     */
    public function render_payment_selector()
    {
        if (empty($this->active_gateways)) {
            echo '<p>' . esc_html__('No payment methods available.', 'bestbalitravel') . '</p>';
            return;
        }
        ?>
        <div class="bbt-payment-methods">
            <h4>
                <?php esc_html_e('Select Payment Method', 'bestbalitravel'); ?>
            </h4>

            <?php foreach ($this->active_gateways as $id => $gateway): ?>
                <label class="bbt-payment-option">
                    <input type="radio" name="payment_gateway" value="<?php echo esc_attr($id); ?>" <?php checked($id, array_key_first($this->active_gateways)); ?>>
                    <span class="bbt-payment-content">
                        <span class="bbt-payment-name">
                            <?php echo esc_html($gateway['name']); ?>
                        </span>
                        <span class="bbt-payment-desc">
                            <?php echo esc_html($gateway['description']); ?>
                        </span>
                    </span>
                </label>
            <?php endforeach; ?>
        </div>
        <?php
    }
}

// Initialize
BBT_Payment_Manager::get_instance();

/**
 * Register booking post type
 */
function bbt_register_booking_post_type()
{
    register_post_type('bbt_booking', array(
        'labels' => array(
            'name' => __('Bookings', 'bestbalitravel'),
            'singular_name' => __('Booking', 'bestbalitravel'),
        ),
        'public' => false,
        'show_ui' => true,
        'show_in_menu' => 'bbt-dashboard',
        'supports' => array('title'),
        'capability_type' => 'post',
    ));
}
add_action('init', 'bbt_register_booking_post_type');
