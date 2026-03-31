<?php
/**
 * Elementor Integration
 * Main class for Elementor Pro compatibility
 *
 * @package BestBaliTravel
 */

if (!defined('ABSPATH')) {
    exit;
}

class BBT_Elementor
{

    /**
     * Instance
     */
    private static $instance = null;

    /**
     * Minimum Elementor Version
     */
    const MINIMUM_ELEMENTOR_VERSION = '3.0.0';

    /**
     * Get instance
     */
    public static function get_instance()
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Constructor
     */
    private function __construct()
    {
        // Check if Elementor is installed and activated
        if (!did_action('elementor/loaded')) {
            add_action('admin_notices', array($this, 'admin_notice_missing_elementor'));
            return;
        }

        // Check Elementor version
        if (!version_compare(ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=')) {
            add_action('admin_notices', array($this, 'admin_notice_minimum_elementor_version'));
            return;
        }

        // Register widgets
        add_action('elementor/widgets/register', array($this, 'register_widgets'));

        // Register widget category
        add_action('elementor/elements/categories_registered', array($this, 'register_categories'));

        // Register theme locations for Elementor Pro Theme Builder
        add_action('elementor/theme/register_locations', array($this, 'register_theme_locations'));

        // Enqueue editor styles
        add_action('elementor/editor/after_enqueue_styles', array($this, 'enqueue_editor_styles'));

        // Enqueue frontend styles
        add_action('elementor/frontend/after_enqueue_styles', array($this, 'enqueue_frontend_styles'));

        // Register dynamic tags
        add_action('elementor/dynamic_tags/register', array($this, 'register_dynamic_tags'));

        // Register controls
        add_action('elementor/controls/register', array($this, 'register_controls'));
    }

    /**
     * Admin notice - Missing Elementor
     */
    public function admin_notice_missing_elementor()
    {
        if (isset($_GET['activate'])) {
            unset($_GET['activate']);
        }

        $message = sprintf(
            esc_html__('"%1$s" requires "%2$s" to be installed and activated for full functionality.', 'bestbalitravel'),
            '<strong>' . esc_html__('Best Bali Travel Theme', 'bestbalitravel') . '</strong>',
            '<strong>' . esc_html__('Elementor', 'bestbalitravel') . '</strong>'
        );

        printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
    }

    /**
     * Admin notice - Minimum Elementor version
     */
    public function admin_notice_minimum_elementor_version()
    {
        $message = sprintf(
            esc_html__('"%1$s" requires "%2$s" version %3$s or greater.', 'bestbalitravel'),
            '<strong>' . esc_html__('Best Bali Travel Theme', 'bestbalitravel') . '</strong>',
            '<strong>' . esc_html__('Elementor', 'bestbalitravel') . '</strong>',
            self::MINIMUM_ELEMENTOR_VERSION
        );

        printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
    }

    /**
     * Register widget category
     */
    public function register_categories($elements_manager)
    {
        $elements_manager->add_category(
            'bbt-widgets',
            array(
                'title' => esc_html__('🌴 Best Bali Travel', 'bestbalitravel'),
                'icon' => 'fa fa-palm-tree',
            )
        );
    }

    /**
     * Register theme locations for Elementor Pro Theme Builder
     * This allows users to create custom headers/footers via Elementor
     */
    public function register_theme_locations($elementor_theme_manager)
    {
        // Register header location
        $elementor_theme_manager->register_location(
            'header',
            array(
                'label' => esc_html__('Header', 'bestbalitravel'),
                'multiple' => false,
                'edit_in_content' => true,
            )
        );

        // Register footer location
        $elementor_theme_manager->register_location(
            'footer',
            array(
                'label' => esc_html__('Footer', 'bestbalitravel'),
                'multiple' => false,
                'edit_in_content' => true,
            )
        );
    }

    /**
     * Register widgets
     */
    public function register_widgets($widgets_manager)
    {
        // Widget file => class name mapping (100 Widgets Total)
        $widgets = array(
            // ===== CORE WIDGETS (15) =====
            'hero-slider' => 'BBT_Widget_Hero_Slider',
            'tour-card' => 'BBT_Widget_Tour_Card',
            'tour-grid' => 'BBT_Widget_Tour_Grid',
            'tour-carousel' => 'BBT_Widget_Tour_Carousel',
            'single-tour-mega' => 'BBT_Widget_Single_Tour_Mega',
            'booking' => 'BBT_Widget_Booking',
            'search-box' => 'BBT_Widget_Search_Box',
            'testimonials' => 'BBT_Widget_Testimonials',
            'locations' => 'BBT_Widget_Locations',
            'countdown' => 'BBT_Widget_Countdown',
            'whatsapp-cta' => 'BBT_Widget_Whatsapp_Cta',
            'pricing-table' => 'BBT_Widget_Pricing_Table',
            'gallery' => 'BBT_Widget_Gallery',
            'stats-counter' => 'BBT_Widget_Stats_Counter',
            'newsletter' => 'BBT_Widget_Newsletter',

            // ===== TOUR & TRAVEL WIDGETS (20) =====
            'tour-comparison' => 'BBT_Widget_Tour_Comparison',
            'activity-timeline' => 'BBT_Widget_Activity_Timeline',
            'weather' => 'BBT_Widget_Weather',
            'currency-converter' => 'BBT_Widget_Currency_Converter',
            'video-showcase' => 'BBT_Widget_Video_Showcase',
            'featured-destinations' => 'BBT_Widget_Featured_Destinations',
            'tour-categories' => 'BBT_Widget_Tour_Categories',
            'quick-booking' => 'BBT_Widget_Quick_Booking',
            'reviews-carousel' => 'BBT_Widget_Reviews_Carousel',
            'social-proof' => 'BBT_Widget_Social_Proof',
            'tour-features' => 'BBT_Widget_Tour_Features',
            'before-after' => 'BBT_Widget_Before_After',
            'tour-map' => 'BBT_Widget_Tour_Map',
            'team-guides' => 'BBT_Widget_Team_Guides',
            'trust-badges' => 'BBT_Widget_Trust_Badges',
            'tour-packages' => 'BBT_Widget_Tour_Packages',
            'photo-mosaic' => 'BBT_Widget_Photo_Mosaic',
            'experience-highlights' => 'BBT_Widget_Experience_Highlights',
            'cta-banner' => 'BBT_Widget_CTA_Banner',
            'availability-calendar' => 'BBT_Widget_Availability_Calendar',

            // ===== ACTIVITY WIDGETS (12) =====
            'activity-card' => 'BBT_Widget_Activity_Card',
            'activity-grid' => 'BBT_Widget_Activity_Grid',
            'activity-carousel' => 'BBT_Widget_Activity_Carousel',
            'activity-hero' => 'BBT_Widget_Activity_Hero',
            'activity-pricing' => 'BBT_Widget_Activity_Pricing',
            'activity-stats' => 'BBT_Widget_Activity_Stats',
            'activity-details' => 'BBT_Widget_Activity_Details',
            'activity-gallery' => 'BBT_Widget_Activity_Gallery',
            'whats-included' => 'BBT_Widget_Whats_Included',
            'tour-itinerary' => 'BBT_Widget_Tour_Itinerary',
            'tour-highlights' => 'BBT_Widget_Tour_Highlights',
            'important-info' => 'BBT_Widget_Important_Info',

            // ===== BOOKING & FORMS (8) =====
            'trip-planner' => 'BBT_Widget_Trip_Planner',
            'booking-steps' => 'BBT_Widget_Booking_Steps',
            'tour-booking-box' => 'BBT_Widget_Tour_Booking_Box',
            'popup-booking' => 'BBT_Widget_Popup_Booking',
            'contact-form' => 'BBT_Widget_Contact_Form',
            'login-form' => 'BBT_Widget_Login_Form',
            'filter-bar' => 'BBT_Widget_Filter_Bar',
            'countdown-timer' => 'BBT_Widget_Countdown_Timer',

            // ===== HERO & BANNER WIDGETS (6) =====
            'hero-section' => 'BBT_Widget_Hero_Section',
            'banner-slider' => 'BBT_Widget_Banner_Slider',
            'parallax-section' => 'BBT_Widget_Parallax_Section',
            'video-background' => 'BBT_Widget_Video_Background',
            'page-header' => 'BBT_Widget_Page_Header',
            'special-offer' => 'BBT_Widget_Special_Offer',

            // ===== CONTENT WIDGETS (18) =====
            'about-section' => 'BBT_Widget_About_Section',
            'services-grid' => 'BBT_Widget_Services_Grid',
            'feature-box' => 'BBT_Widget_Feature_Box',
            'icon-list' => 'BBT_Widget_Icon_List',
            'price-card' => 'BBT_Widget_Price_Card',
            'faq-accordion' => 'BBT_Widget_FAQ_Accordion',
            'accordion-simple' => 'BBT_Widget_Accordion_Simple',
            'tab-content' => 'BBT_Widget_Tab_Content',
            'tour-tabs' => 'BBT_Widget_Tour_Tabs',
            'flip-card' => 'BBT_Widget_Flip_Card',
            'quote-box' => 'BBT_Widget_Quote_Box',
            'alert-box' => 'BBT_Widget_Alert_Box',
            'divider' => 'BBT_Widget_Divider',
            'progress-bar' => 'BBT_Widget_Progress_Bar',
            'breadcrumbs' => 'BBT_Widget_Breadcrumbs',
            'scroll-reveal' => 'BBT_Widget_Scroll_Reveal',
            'typewriter' => 'BBT_Widget_Typewriter',
            'marquee' => 'BBT_Widget_Marquee',

            // ===== IMAGE & GALLERY WIDGETS (5) =====
            'image-gallery' => 'BBT_Widget_Image_Gallery',
            'image-hotspot' => 'BBT_Widget_Image_Hotspot',
            'destination-card' => 'BBT_Widget_Destination_Card',
            'animated-counter' => 'BBT_Widget_Animated_Counter',
            'map-embed' => 'BBT_Widget_Map_Embed',

            // ===== TESTIMONIALS & REVIEWS (4) =====
            'testimonial-single' => 'BBT_Widget_Testimonial_Single',
            'tour-reviews' => 'BBT_Widget_Tour_Reviews',
            'rating-display' => 'BBT_Widget_Rating_Display',
            'related-tours' => 'BBT_Widget_Related_Tours',

            // ===== SOCIAL & ENGAGEMENT (7) =====
            'instagram-feed' => 'BBT_Widget_Instagram_Feed',
            'tiktok-feed' => 'BBT_Widget_Tiktok_Feed',
            'blog-posts' => 'BBT_Widget_Blog_Posts',
            'social-icons' => 'BBT_Widget_Social_Icons',
            'share-buttons' => 'BBT_Widget_Share_Buttons',
            'partner-logos' => 'BBT_Widget_Partner_Logos',
            'logo-carousel' => 'BBT_Widget_Logo_Carousel',

            // ===== UI COMPONENTS (6) =====
            'team-member' => 'BBT_Widget_Team_Member',
            'info-card' => 'BBT_Widget_Info_Card',
            'contact-info' => 'BBT_Widget_Contact_Info',
            'notification-bar' => 'BBT_Widget_Notification_Bar',
            'floating-buttons' => 'BBT_Widget_Floating_Buttons',
            'modal-popup' => 'BBT_Widget_Modal_Popup',

            // ===== HEADER & FOOTER (2) =====
            'premium-header' => 'BBT_Widget_Premium_Header',
            'premium-footer' => 'BBT_Widget_Premium_Footer',
        );

        foreach ($widgets as $file_name => $class_name) {
            $widget_file = BBT_THEME_DIR . '/inc/elementor/widgets/class-widget-' . $file_name . '.php';

            if (file_exists($widget_file)) {
                require_once $widget_file;

                if (class_exists($class_name)) {
                    $widgets_manager->register(new $class_name());
                }
            }
        }
    }

    /**
     * Register dynamic tags
     */
    public function register_dynamic_tags($dynamic_tags_manager)
    {
        // Tour dynamic tags
        $dynamic_tags_manager->register_group('bbt-tours', array(
            'title' => esc_html__('Tour Data', 'bestbalitravel'),
        ));

        // Include dynamic tag files
        $tags_dir = BBT_THEME_DIR . '/inc/elementor/tags/';

        if (is_dir($tags_dir)) {
            foreach (glob($tags_dir . '*.php') as $file) {
                require_once $file;
            }
        }
    }

    /**
     * Register controls
     */
    public function register_controls($controls_manager)
    {
        // Custom controls can be added here
    }

    /**
     * Enqueue editor styles
     */
    public function enqueue_editor_styles()
    {
        wp_enqueue_style(
            'bbt-elementor-editor',
            BBT_THEME_ASSETS . '/css/elementor-editor.css',
            array(),
            BBT_THEME_VERSION
        );
    }

    /**
     * Enqueue frontend styles
     */
    public function enqueue_frontend_styles()
    {
        wp_enqueue_style(
            'bbt-elementor-widgets',
            BBT_THEME_ASSETS . '/css/elementor-widgets.css',
            array(),
            BBT_THEME_VERSION
        );
    }
}

// Initialize Elementor integration
add_action('init', function () {
    BBT_Elementor::get_instance();
});
