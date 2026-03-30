<?php
/**
 * Theme Customizer
 *
 * @package BestBaliTravel
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add Theme Customizer Options
 */
function bbt_customize_register($wp_customize)
{

    // ========================================
    // BBT Settings Panel
    // ========================================
    $wp_customize->add_panel('bbt_theme_options', array(
        'title' => __('Best Bali Travel Settings', 'bestbalitravel'),
        'priority' => 30,
    ));

    // ========================================
    // Contact Information Section
    // ========================================
    $wp_customize->add_section('bbt_contact_info', array(
        'title' => __('Contact Information', 'bestbalitravel'),
        'panel' => 'bbt_theme_options',
        'priority' => 10,
    ));

    // WhatsApp Number
    $wp_customize->add_setting('bbt_whatsapp_number', array(
        'default' => '+6287854806011',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('bbt_whatsapp_number', array(
        'label' => __('WhatsApp Number', 'bestbalitravel'),
        'section' => 'bbt_contact_info',
        'type' => 'text',
        'description' => __('Include country code, e.g., +6287854806011', 'bestbalitravel'),
    ));

    // Email
    $wp_customize->add_setting('bbt_email', array(
        'default' => 'info@bestbalitravel.com',
        'sanitize_callback' => 'sanitize_email',
    ));

    $wp_customize->add_control('bbt_email', array(
        'label' => __('Email Address', 'bestbalitravel'),
        'section' => 'bbt_contact_info',
        'type' => 'email',
    ));

    // Phone
    $wp_customize->add_setting('bbt_phone', array(
        'default' => '+62 878 5480 6011',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('bbt_phone', array(
        'label' => __('Phone Number', 'bestbalitravel'),
        'section' => 'bbt_contact_info',
        'type' => 'text',
    ));

    // Address
    $wp_customize->add_setting('bbt_address', array(
        'default' => 'Bali, Indonesia',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('bbt_address', array(
        'label' => __('Address', 'bestbalitravel'),
        'section' => 'bbt_contact_info',
        'type' => 'text',
    ));

    // ========================================
    // Social Media Section
    // ========================================
    $wp_customize->add_section('bbt_social_media', array(
        'title' => __('Social Media', 'bestbalitravel'),
        'panel' => 'bbt_theme_options',
        'priority' => 20,
    ));

    $social_networks = array(
        'instagram' => 'Instagram URL',
        'facebook' => 'Facebook URL',
        'tiktok' => 'TikTok URL',
        'youtube' => 'YouTube URL',
        'twitter' => 'Twitter/X URL',
    );

    foreach ($social_networks as $network => $label) {
        $wp_customize->add_setting('bbt_' . $network, array(
            'default' => '',
            'sanitize_callback' => 'esc_url_raw',
        ));

        $wp_customize->add_control('bbt_' . $network, array(
            'label' => __($label, 'bestbalitravel'),
            'section' => 'bbt_social_media',
            'type' => 'url',
        ));
    }

    // ========================================
    // Homepage Section
    // ========================================
    $wp_customize->add_section('bbt_homepage', array(
        'title' => __('Homepage Settings', 'bestbalitravel'),
        'panel' => 'bbt_theme_options',
        'priority' => 30,
    ));

    // Hero Title
    $wp_customize->add_setting('bbt_hero_title', array(
        'default' => 'BEST BALI TRAVEL',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('bbt_hero_title', array(
        'label' => __('Hero Title', 'bestbalitravel'),
        'section' => 'bbt_homepage',
        'type' => 'text',
    ));

    // Hero Subtitle
    $wp_customize->add_setting('bbt_hero_subtitle', array(
        'default' => 'Explore Bali the Right Way',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('bbt_hero_subtitle', array(
        'label' => __('Hero Subtitle', 'bestbalitravel'),
        'section' => 'bbt_homepage',
        'type' => 'text',
    ));

    // Hero Background
    $wp_customize->add_setting('bbt_hero_bg', array(
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'bbt_hero_bg', array(
        'label' => __('Hero Background Image', 'bestbalitravel'),
        'section' => 'bbt_homepage',
        'mime_type' => 'image',
    )));

    // Featured Tours Count
    $wp_customize->add_setting('bbt_featured_count', array(
        'default' => 6,
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control('bbt_featured_count', array(
        'label' => __('Featured Tours Count', 'bestbalitravel'),
        'section' => 'bbt_homepage',
        'type' => 'number',
        'input_attrs' => array(
            'min' => 3,
            'max' => 12,
        ),
    ));

    // ========================================
    // Footer Section
    // ========================================
    $wp_customize->add_section('bbt_footer', array(
        'title' => __('Footer Settings', 'bestbalitravel'),
        'panel' => 'bbt_theme_options',
        'priority' => 40,
    ));

    // Footer Description
    $wp_customize->add_setting('bbt_footer_description', array(
        'default' => 'Explore Bali the Right Way. We provide the best tour experiences with local guides, personalized service, and unforgettable memories.',
        'sanitize_callback' => 'sanitize_textarea_field',
    ));

    $wp_customize->add_control('bbt_footer_description', array(
        'label' => __('Footer Description', 'bestbalitravel'),
        'section' => 'bbt_footer',
        'type' => 'textarea',
    ));

    // Copyright Text
    $wp_customize->add_setting('bbt_copyright_text', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('bbt_copyright_text', array(
        'label' => __('Copyright Text (optional)', 'bestbalitravel'),
        'section' => 'bbt_footer',
        'type' => 'text',
        'description' => __('Leave empty to use default', 'bestbalitravel'),
    ));

    // ========================================
    // Booking Section
    // ========================================
    $wp_customize->add_section('bbt_booking', array(
        'title' => __('Booking Settings', 'bestbalitravel'),
        'panel' => 'bbt_theme_options',
        'priority' => 50,
    ));

    // Default Currency
    $wp_customize->add_setting('bbt_default_currency', array(
        'default' => 'IDR',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('bbt_default_currency', array(
        'label' => __('Default Currency', 'bestbalitravel'),
        'section' => 'bbt_booking',
        'type' => 'select',
        'choices' => array(
            'IDR' => 'IDR (Indonesian Rupiah)',
            'USD' => 'USD (US Dollar)',
            'EUR' => 'EUR (Euro)',
            'AUD' => 'AUD (Australian Dollar)',
            'SGD' => 'SGD (Singapore Dollar)',
        ),
    ));

    // Enable WhatsApp Booking
    $wp_customize->add_setting('bbt_whatsapp_booking', array(
        'default' => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));

    $wp_customize->add_control('bbt_whatsapp_booking', array(
        'label' => __('Enable WhatsApp Booking Button', 'bestbalitravel'),
        'section' => 'bbt_booking',
        'type' => 'checkbox',
    ));

    // Cancellation Policy
    $wp_customize->add_setting('bbt_cancellation_policy', array(
        'default' => 'Free cancellation up to 24 hours before start time. 50% refund if cancelled 12-24 hours before. No refund if cancelled less than 12 hours before.',
        'sanitize_callback' => 'sanitize_textarea_field',
    ));

    $wp_customize->add_control('bbt_cancellation_policy', array(
        'label' => __('Cancellation Policy', 'bestbalitravel'),
        'section' => 'bbt_booking',
        'type' => 'textarea',
    ));

    // ========================================
    // Google Maps Section
    // ========================================
    $wp_customize->add_section('bbt_maps', array(
        'title' => __('Google Maps', 'bestbalitravel'),
        'panel' => 'bbt_theme_options',
        'priority' => 60,
    ));

    // Google Maps Embed Code
    $wp_customize->add_setting('bbt_google_maps_embed', array(
        'default' => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d252621.38841455846!2d115.08826024843752!3d-8.455553249999991!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd23d739f22c9c3%3A0x54a1ec47a6e5fa2!2sBali%2C%20Indonesia!5e0!3m2!1sen!2sus!4v1695000000000!5m2!1sen!2sus" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>',
        'sanitize_callback' => 'bbt_sanitize_iframe',
    ));

    $wp_customize->add_control('bbt_google_maps_embed', array(
        'label' => __('Google Maps Embed Code', 'bestbalitravel'),
        'section' => 'bbt_maps',
        'type' => 'textarea',
        'description' => __('Paste the full iframe embed code from Google Maps. Go to Google Maps → Share → Embed a map.', 'bestbalitravel'),
    ));
}
add_action('customize_register', 'bbt_customize_register');

/**
 * Customizer Live Preview
 */
function bbt_customize_preview_js()
{
    wp_enqueue_script(
        'bbt-customizer',
        BBT_THEME_ASSETS . '/js/customizer.js',
        array('customize-preview'),
        BBT_THEME_VERSION,
        true
    );
}
add_action('customize_preview_init', 'bbt_customize_preview_js');
