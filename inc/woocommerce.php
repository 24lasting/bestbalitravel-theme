<?php
/**
 * WooCommerce Integration
 *
 * @package BestBaliTravel
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * WooCommerce Setup
 */
function bbt_woocommerce_setup()
{
    add_theme_support('woocommerce', array(
        'thumbnail_image_width' => 400,
        'gallery_thumbnail_image_width' => 150,
        'single_image_width' => 800,
    ));
}
add_action('after_setup_theme', 'bbt_woocommerce_setup');

/**
 * Disable WooCommerce Default Styles
 */
add_filter('woocommerce_enqueue_styles', '__return_empty_array');

/**
 * Enqueue WooCommerce Custom Styles
 */
function bbt_woocommerce_styles()
{
    wp_enqueue_style(
        'bbt-woocommerce',
        BBT_THEME_ASSETS . '/css/woocommerce.css',
        array('bbt-theme'),
        BBT_THEME_VERSION
    );
}
add_action('wp_enqueue_scripts', 'bbt_woocommerce_styles', 20);

/**
 * Change Add to Cart Text
 */
function bbt_woocommerce_add_to_cart_text()
{
    return __('Book Now', 'bestbalitravel');
}
add_filter('woocommerce_product_add_to_cart_text', 'bbt_woocommerce_add_to_cart_text');
add_filter('woocommerce_product_single_add_to_cart_text', 'bbt_woocommerce_add_to_cart_text');

/**
 * Cart Fragment Update
 */
function bbt_woocommerce_cart_fragment($fragments)
{
    ob_start();
    ?>
    <span class="cart-count">
        <?php echo WC()->cart->get_cart_contents_count(); ?>
    </span>
    <?php
    $fragments['.cart-count'] = ob_get_clean();

    return $fragments;
}
add_filter('woocommerce_add_to_cart_fragments', 'bbt_woocommerce_cart_fragment');

/**
 * Remove Breadcrumbs
 */
remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);

/**
 * Custom Breadcrumbs
 */
function bbt_woocommerce_breadcrumbs()
{
    if (is_woocommerce() || is_cart() || is_checkout()) {
        bbt_breadcrumbs();
    }
}
add_action('woocommerce_before_main_content', 'bbt_woocommerce_breadcrumbs', 20);

/**
 * Products Per Page
 */
function bbt_woocommerce_products_per_page()
{
    return 12;
}
add_filter('loop_shop_per_page', 'bbt_woocommerce_products_per_page');

/**
 * Remove Sidebar on Product Pages
 */
function bbt_woocommerce_remove_sidebar()
{
    if (is_product()) {
        remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar', 10);
    }
}
add_action('template_redirect', 'bbt_woocommerce_remove_sidebar');

/**
 * Modify Checkout Fields
 */
function bbt_woocommerce_checkout_fields($fields)
{
    // Remove company field
    unset($fields['billing']['billing_company']);

    // Add hotel/pickup field
    $fields['order']['order_hotel'] = array(
        'type' => 'text',
        'label' => __('Hotel Name (for pickup)', 'bestbalitravel'),
        'placeholder' => __('Enter your hotel name', 'bestbalitravel'),
        'required' => true,
        'priority' => 5,
    );

    // Add special requests
    $fields['order']['order_special_requests'] = array(
        'type' => 'textarea',
        'label' => __('Special Requests', 'bestbalitravel'),
        'placeholder' => __('Any dietary requirements, accessibility needs, etc.', 'bestbalitravel'),
        'required' => false,
        'priority' => 10,
    );

    // Set phone as required
    $fields['billing']['billing_phone']['required'] = true;

    return $fields;
}
add_filter('woocommerce_checkout_fields', 'bbt_woocommerce_checkout_fields');

/**
 * Save Custom Checkout Fields
 */
function bbt_woocommerce_save_checkout_fields($order_id)
{
    if (!empty($_POST['order_hotel'])) {
        update_post_meta($order_id, '_order_hotel', sanitize_text_field($_POST['order_hotel']));
    }

    if (!empty($_POST['order_special_requests'])) {
        update_post_meta($order_id, '_order_special_requests', sanitize_textarea_field($_POST['order_special_requests']));
    }
}
add_action('woocommerce_checkout_update_order_meta', 'bbt_woocommerce_save_checkout_fields');

/**
 * Display Custom Fields in Admin
 */
function bbt_woocommerce_admin_order_data($order)
{
    $hotel = get_post_meta($order->get_id(), '_order_hotel', true);
    $special = get_post_meta($order->get_id(), '_order_special_requests', true);

    if ($hotel) {
        echo '<p><strong>' . __('Hotel:', 'bestbalitravel') . '</strong> ' . esc_html($hotel) . '</p>';
    }

    if ($special) {
        echo '<p><strong>' . __('Special Requests:', 'bestbalitravel') . '</strong><br>' . esc_html($special) . '</p>';
    }
}
add_action('woocommerce_admin_order_data_after_billing_address', 'bbt_woocommerce_admin_order_data');

/**
 * Add WhatsApp Button to Thank You Page
 */
function bbt_woocommerce_thankyou_whatsapp($order_id)
{
    $order = wc_get_order($order_id);
    $whatsapp = get_theme_mod('bbt_whatsapp_number', '+6287854806011');
    $message = urlencode(sprintf(
        __('Hi! I just booked tour #%s on Best Bali Travel. Looking forward to my trip!', 'bestbalitravel'),
        $order->get_order_number()
    ));
    ?>
    <div class="bbt-thankyou-whatsapp">
        <h3>
            <?php esc_html_e('Connect With Us', 'bestbalitravel'); ?>
        </h3>
        <p>
            <?php esc_html_e('Join our WhatsApp group for 24/7 support during your tour', 'bestbalitravel'); ?>
        </p>
        <a href="https://wa.me/<?php echo preg_replace('/[^0-9]/', '', $whatsapp); ?>?text=<?php echo $message; ?>"
            class="bbt-btn bbt-btn-success" target="_blank">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                <path
                    d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
            </svg>
            <?php esc_html_e('Chat on WhatsApp', 'bestbalitravel'); ?>
        </a>
    </div>
    <?php
}
add_action('woocommerce_thankyou', 'bbt_woocommerce_thankyou_whatsapp', 5);

/**
 * Add Tour Date to Cart Item
 */
function bbt_woocommerce_add_cart_item_data($cart_item_data, $product_id)
{
    if (isset($_POST['tour_date'])) {
        $cart_item_data['tour_date'] = sanitize_text_field($_POST['tour_date']);
    }

    if (isset($_POST['adults'])) {
        $cart_item_data['adults'] = absint($_POST['adults']);
    }

    if (isset($_POST['children'])) {
        $cart_item_data['children'] = absint($_POST['children']);
    }

    return $cart_item_data;
}
add_filter('woocommerce_add_cart_item_data', 'bbt_woocommerce_add_cart_item_data', 10, 2);

/**
 * Display Tour Date in Cart
 */
function bbt_woocommerce_cart_item_name($name, $cart_item, $cart_item_key)
{
    if (isset($cart_item['tour_date'])) {
        $name .= '<br><small><strong>' . __('Date:', 'bestbalitravel') . '</strong> ' . esc_html($cart_item['tour_date']) . '</small>';
    }

    if (isset($cart_item['adults'])) {
        $name .= '<br><small><strong>' . __('Adults:', 'bestbalitravel') . '</strong> ' . esc_html($cart_item['adults']) . '</small>';
    }

    if (isset($cart_item['children']) && $cart_item['children'] > 0) {
        $name .= '<br><small><strong>' . __('Children:', 'bestbalitravel') . '</strong> ' . esc_html($cart_item['children']) . '</small>';
    }

    return $name;
}
add_filter('woocommerce_cart_item_name', 'bbt_woocommerce_cart_item_name', 10, 3);

/**
 * Save Tour Date to Order
 */
function bbt_woocommerce_checkout_create_order_line_item($item, $cart_item_key, $values, $order)
{
    if (isset($values['tour_date'])) {
        $item->add_meta_data(__('Tour Date', 'bestbalitravel'), $values['tour_date']);
    }

    if (isset($values['adults'])) {
        $item->add_meta_data(__('Adults', 'bestbalitravel'), $values['adults']);
    }

    if (isset($values['children'])) {
        $item->add_meta_data(__('Children', 'bestbalitravel'), $values['children']);
    }
}
add_action('woocommerce_checkout_create_order_line_item', 'bbt_woocommerce_checkout_create_order_line_item', 10, 4);
