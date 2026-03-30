<?php
/**
 * Best Bali Travel Theme Functions
 *
 * @package BestBaliTravel
 * @version 1.0.0
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Theme Constants
define('BBT_THEME_VERSION', '1.0.0');
define('BBT_THEME_DIR', get_template_directory());
define('BBT_THEME_URI', get_template_directory_uri());
define('BBT_THEME_ASSETS', BBT_THEME_URI . '/assets');

/**
 * Theme Setup
 */
function bbt_theme_setup()
{
    // Make theme available for translation
    load_theme_textdomain('bestbalitravel', BBT_THEME_DIR . '/languages');

    // Add default posts and comments RSS feed links to head
    add_theme_support('automatic-feed-links');

    // Let WordPress manage the document title
    add_theme_support('title-tag');

    // Enable support for Post Thumbnails
    add_theme_support('post-thumbnails');

    // Custom image sizes
    add_image_size('bbt-tour-card', 400, 250, true);
    add_image_size('bbt-tour-hero', 1200, 600, true);
    add_image_size('bbt-tour-gallery', 800, 600, true);
    add_image_size('bbt-tour-thumb', 150, 100, true);

    // Register navigation menus
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'bestbalitravel'),
        'footer' => __('Footer Menu', 'bestbalitravel'),
        'mobile' => __('Mobile Menu', 'bestbalitravel'),
    ));

    // Switch default core markup to output valid HTML5
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ));

    // Add support for custom logo
    add_theme_support('custom-logo', array(
        'height' => 80,
        'width' => 200,
        'flex-height' => true,
        'flex-width' => true,
    ));

    // Add support for wide alignment
    add_theme_support('align-wide');

    // Add support for responsive embeds
    add_theme_support('responsive-embeds');

    // WooCommerce support
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
}
add_action('after_setup_theme', 'bbt_theme_setup');

/**
 * Enqueue Scripts and Styles
 */
function bbt_enqueue_assets()
{
    // Premium Google Fonts
    wp_enqueue_style(
        'bbt-google-fonts',
        'https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;0,700;1,400&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Outfit:wght@300;400;500;600;700&display=swap',
        array(),
        null
    );

    // Main stylesheet
    wp_enqueue_style(
        'bbt-style',
        get_stylesheet_uri(),
        array(),
        BBT_THEME_VERSION
    );

    // Design System CSS
    wp_enqueue_style(
        'bbt-design-system',
        BBT_THEME_ASSETS . '/css/design-system.css',
        array('bbt-style'),
        BBT_THEME_VERSION
    );

    // Responsive CSS (Global)
    wp_enqueue_style(
        'bbt-responsive',
        BBT_THEME_ASSETS . '/css/responsive.css',
        array('bbt-style'),
        BBT_THEME_VERSION
    );

    // Theme CSS
    wp_enqueue_style(
        'bbt-theme',
        BBT_THEME_ASSETS . '/css/theme.css',
        array('bbt-design-system'),
        BBT_THEME_VERSION
    );

    // Header CSS
    wp_enqueue_style(
        'bbt-header',
        BBT_THEME_ASSETS . '/css/header.css',
        array('bbt-theme'),
        BBT_THEME_VERSION
    );

    // Footer CSS
    wp_enqueue_style(
        'bbt-footer',
        BBT_THEME_ASSETS . '/css/footer.css',
        array('bbt-theme'),
        BBT_THEME_VERSION
    );

    // Mega Navigation CSS
    wp_enqueue_style(
        'bbt-mega-navigation',
        BBT_THEME_ASSETS . '/css/mega-navigation.css',
        array('bbt-header'),
        BBT_THEME_VERSION
    );

    // Mobile Navigation CSS
    wp_enqueue_style(
        'bbt-mobile-navigation',
        BBT_THEME_ASSETS . '/css/mobile-navigation.css',
        array('bbt-footer'),
        BBT_THEME_VERSION
    );

    // Swiper CSS (for carousels)
    wp_enqueue_style(
        'swiper',
        'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css',
        array(),
        '11.0.0'
    );

    // Flatpickr CSS (for date picker)
    wp_enqueue_style(
        'flatpickr',
        'https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css',
        array(),
        '4.6.13'
    );

    // Archive CSS (for tour listing pages)
    if (is_post_type_archive('tour') || is_tax('tour_location') || is_tax('tour_type') || is_tax('tour_duration')) {
        wp_enqueue_style(
            'bbt-archive',
            BBT_THEME_ASSETS . '/css/archive.css',
            array('bbt-theme'),
            BBT_THEME_VERSION
        );
    }

    // Checkout CSS (for single tour and booking pages)
    if (is_singular('tour') || is_page_template('page-tour-packages.php')) {
        wp_enqueue_style(
            'bbt-checkout',
            BBT_THEME_ASSETS . '/css/checkout.css',
            array('bbt-theme'),
            BBT_THEME_VERSION
        );
    }

    // Single Tour CSS
    if (is_singular('tour') || is_singular('activity')) {
        wp_enqueue_style(
            'bbt-single-tour',
            BBT_THEME_ASSETS . '/css/single-tour.css',
            array('bbt-theme'),
            BBT_THEME_VERSION
        );
    }

    // WooCommerce CSS
    if (class_exists('WooCommerce') && function_exists('is_woocommerce')) {
        if (is_woocommerce() || is_cart() || is_checkout() || is_account_page()) {
            wp_enqueue_style(
                'bbt-woocommerce',
                BBT_THEME_ASSETS . '/css/woocommerce.css',
                array('bbt-theme'),
                BBT_THEME_VERSION
            );
        }
    }

    // Main JavaScript
    wp_enqueue_script(
        'bbt-main',
        BBT_THEME_ASSETS . '/js/main.js',
        array('jquery'),
        BBT_THEME_VERSION,
        true
    );

    // Swiper JS
    wp_enqueue_script(
        'swiper',
        'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js',
        array(),
        '11.0.0',
        true
    );

    // Flatpickr JS
    wp_enqueue_script(
        'flatpickr',
        'https://cdn.jsdelivr.net/npm/flatpickr',
        array(),
        '4.6.13',
        true
    );

    // Alpine.js CDN
    wp_enqueue_script(
        'alpinejs',
        'https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js',
        array(),
        '3.13.0',
        true
    );
    // Add defer attribute for Alpine.js
    add_filter('script_loader_tag', function ($tag, $handle) {
        if ($handle === 'alpinejs') {
            return str_replace(' src', ' defer src', $tag);
        }
        return $tag;
    }, 10, 2);

    // GSAP for premium animations
    wp_enqueue_script(
        'gsap',
        'https://cdn.jsdelivr.net/npm/gsap@3.12.2/dist/gsap.min.js',
        array(),
        '3.12.2',
        true
    );

    // GSAP ScrollTrigger
    wp_enqueue_script(
        'gsap-scrolltrigger',
        'https://cdn.jsdelivr.net/npm/gsap@3.12.2/dist/ScrollTrigger.min.js',
        array('gsap'),
        '3.12.2',
        true
    );

    // Alpine.js Components
    wp_enqueue_script(
        'bbt-alpine-components',
        BBT_THEME_ASSETS . '/js/alpine-components.js',
        array('alpinejs'),
        BBT_THEME_VERSION,
        true
    );

    // Single Tour JavaScript (for tabs, FAQ accordion, gallery)
    if (is_singular('tour') || is_singular('activity')) {
        wp_enqueue_script(
            'bbt-single-tour',
            BBT_THEME_ASSETS . '/js/single-tour.js',
            array('jquery', 'swiper'),
            BBT_THEME_VERSION,
            true
        );
    }

    // Localize script
    wp_localize_script('bbt-main', 'bbtAjax', array(
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('bbt_nonce'),
        'currencySymbol' => function_exists('get_woocommerce_currency_symbol') ? get_woocommerce_currency_symbol() : 'Rp',
        'whatsappNumber' => get_theme_mod('bbt_whatsapp_number', '+6287854806011'),
    ));
}
add_action('wp_enqueue_scripts', 'bbt_enqueue_assets');

/**
 * Register Sidebars/Widget Areas
 */
function bbt_widgets_init()
{
    register_sidebar(array(
        'name' => __('Footer Widget 1', 'bestbalitravel'),
        'id' => 'footer-1',
        'description' => __('Footer widget area 1', 'bestbalitravel'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>',
    ));

    register_sidebar(array(
        'name' => __('Footer Widget 2', 'bestbalitravel'),
        'id' => 'footer-2',
        'description' => __('Footer widget area 2', 'bestbalitravel'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>',
    ));

    register_sidebar(array(
        'name' => __('Footer Widget 3', 'bestbalitravel'),
        'id' => 'footer-3',
        'description' => __('Footer widget area 3', 'bestbalitravel'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>',
    ));

    register_sidebar(array(
        'name' => __('Tour Sidebar', 'bestbalitravel'),
        'id' => 'tour-sidebar',
        'description' => __('Sidebar for tour pages', 'bestbalitravel'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>',
    ));
}
add_action('widgets_init', 'bbt_widgets_init');

/**
 * Include Required Files
 */
// Custom Post Types
require_once BBT_THEME_DIR . '/inc/post-types.php';

// Custom Taxonomies
require_once BBT_THEME_DIR . '/inc/taxonomies.php';

// Theme Customizer
require_once BBT_THEME_DIR . '/inc/customizer.php';

// Template Functions
require_once BBT_THEME_DIR . '/inc/template-functions.php';

// Template Tags
require_once BBT_THEME_DIR . '/inc/template-tags.php';

// WooCommerce Integration
if (class_exists('WooCommerce')) {
    require_once BBT_THEME_DIR . '/inc/woocommerce.php';
}

// AJAX Handlers
require_once BBT_THEME_DIR . '/inc/ajax-handlers.php';

// Demo Content Importer
require_once BBT_THEME_DIR . '/inc/demo-import.php';

// Admin Menus (Consolidated under Best Bali Travel)
require_once BBT_THEME_DIR . '/inc/admin-menus.php';

// Custom Checkout System (No WooCommerce)
require_once BBT_THEME_DIR . '/inc/checkout-system.php';

// Super Theme Admin Dashboard
require_once BBT_THEME_DIR . '/inc/admin/class-bbt-admin.php';

// Elementor Integration
require_once BBT_THEME_DIR . '/inc/elementor/class-bbt-elementor.php';

// Currency Manager (Multi-Currency Support)
if (file_exists(BBT_THEME_DIR . '/inc/currency/class-bbt-currency.php')) {
    require_once BBT_THEME_DIR . '/inc/currency/class-bbt-currency.php';
}

// Payment Gateways
if (file_exists(BBT_THEME_DIR . '/inc/payments/class-bbt-payments.php')) {
    require_once BBT_THEME_DIR . '/inc/payments/class-bbt-payments.php';
}

// Email Manager
if (file_exists(BBT_THEME_DIR . '/inc/email/class-bbt-email.php')) {
    require_once BBT_THEME_DIR . '/inc/email/class-bbt-email.php';
}

/**
 * Custom Excerpt Length
 */
function bbt_excerpt_length($length)
{
    return 20;
}
add_filter('excerpt_length', 'bbt_excerpt_length');

/**
 * Custom Excerpt More
 */
function bbt_excerpt_more($more)
{
    return '...';
}
add_filter('excerpt_more', 'bbt_excerpt_more');

/**
 * Add body classes
 */
function bbt_body_classes($classes)
{
    // Add class for singular pages
    if (is_singular()) {
        $classes[] = 'singular';
    }

    // Add class for tour pages
    if (is_singular('tour')) {
        $classes[] = 'single-tour-page';
    }

    // Add class for WooCommerce pages
    if (class_exists('WooCommerce')) {
        if (is_cart()) {
            $classes[] = 'wc-cart-page';
        }
        if (is_checkout()) {
            $classes[] = 'wc-checkout-page';
        }
    }

    return $classes;
}
add_filter('body_class', 'bbt_body_classes');

/**
 * Disable Gutenberg for Tours
 */
function bbt_disable_gutenberg_for_tours($can_edit, $post_type)
{
    if ($post_type === 'tour' || $post_type === 'activity') {
        return false;
    }
    return $can_edit;
}
add_filter('use_block_editor_for_post_type', 'bbt_disable_gutenberg_for_tours', 10, 2);

/**
 * Add SVG support
 */
function bbt_mime_types($mimes)
{
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'bbt_mime_types');

/**
 * Theme activation
 */
function bbt_theme_activation()
{
    // Flush rewrite rules on activation
    flush_rewrite_rules();
}
add_action('after_switch_theme', 'bbt_theme_activation');
