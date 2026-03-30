<?php
/**
 * BBT Admin Class
 * Main admin dashboard and settings for Best Bali Travel Super Theme
 *
 * @package BestBaliTravel
 */

if (!defined('ABSPATH')) {
    exit;
}

class BBT_Admin
{

    /**
     * Instance
     */
    private static $instance = null;

    /**
     * Settings options
     */
    private $settings = array();

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
        $this->settings = get_option('bbt_settings', array());

        add_action('admin_menu', array($this, 'register_admin_menu'));
        add_action('admin_init', array($this, 'register_settings'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_assets'));
    }

    /**
     * Register Admin Menu
     */
    public function register_admin_menu()
    {
        // Remove the old admin menus (they're in admin-menus.php)
        // This class adds the settings pages

        // Add Settings submenu
        add_submenu_page(
            'bbt-dashboard',
            __('Theme Settings', 'bestbalitravel'),
            __('⚙️ Settings', 'bestbalitravel'),
            'manage_options',
            'bbt-settings',
            array($this, 'render_settings_page')
        );

        // Add Demo Import submenu (moved from Appearance)
        add_submenu_page(
            'bbt-dashboard',
            __('Demo Import', 'bestbalitravel'),
            __('🎨 Demo Themes', 'bestbalitravel'),
            'manage_options',
            'bbt-demos',
            array($this, 'render_demos_page')
        );
    }

    /**
     * Register Settings
     */
    public function register_settings()
    {
        register_setting('bbt_settings_group', 'bbt_settings', array($this, 'sanitize_settings'));

        // General Section
        add_settings_section(
            'bbt_general_section',
            __('General Settings', 'bestbalitravel'),
            null,
            'bbt-settings-general'
        );

        // Currency Section
        add_settings_section(
            'bbt_currency_section',
            __('Currency Settings', 'bestbalitravel'),
            null,
            'bbt-settings-currency'
        );

        // Payment Section
        add_settings_section(
            'bbt_payment_section',
            __('Payment Gateways', 'bestbalitravel'),
            null,
            'bbt-settings-payments'
        );

        // Email Section
        add_settings_section(
            'bbt_email_section',
            __('Email Settings', 'bestbalitravel'),
            null,
            'bbt-settings-email'
        );
    }

    /**
     * Sanitize Settings
     */
    public function sanitize_settings($input)
    {
        $sanitized = array();

        // General
        $sanitized['admin_email'] = sanitize_email($input['admin_email'] ?? '');
        $sanitized['whatsapp'] = sanitize_text_field($input['whatsapp'] ?? '');
        $sanitized['company_name'] = sanitize_text_field($input['company_name'] ?? '');

        // Currency
        $sanitized['default_currency'] = sanitize_text_field($input['default_currency'] ?? 'IDR');
        $sanitized['enabled_currencies'] = isset($input['enabled_currencies']) ? array_map('sanitize_text_field', $input['enabled_currencies']) : array('IDR', 'USD');
        $sanitized['exchange_rate_api'] = sanitize_text_field($input['exchange_rate_api'] ?? '');

        // Payments
        $sanitized['midtrans_enabled'] = isset($input['midtrans_enabled']) ? 1 : 0;
        $sanitized['midtrans_sandbox'] = isset($input['midtrans_sandbox']) ? 1 : 0;
        $sanitized['midtrans_server_key'] = sanitize_text_field($input['midtrans_server_key'] ?? '');
        $sanitized['midtrans_client_key'] = sanitize_text_field($input['midtrans_client_key'] ?? '');

        $sanitized['stripe_enabled'] = isset($input['stripe_enabled']) ? 1 : 0;
        $sanitized['stripe_test_mode'] = isset($input['stripe_test_mode']) ? 1 : 0;
        $sanitized['stripe_publishable_key'] = sanitize_text_field($input['stripe_publishable_key'] ?? '');
        $sanitized['stripe_secret_key'] = sanitize_text_field($input['stripe_secret_key'] ?? '');

        $sanitized['wise_enabled'] = isset($input['wise_enabled']) ? 1 : 0;
        $sanitized['wise_api_key'] = sanitize_text_field($input['wise_api_key'] ?? '');

        // Email
        $sanitized['email_from_name'] = sanitize_text_field($input['email_from_name'] ?? 'Best Bali Travel');
        $sanitized['email_from_address'] = sanitize_email($input['email_from_address'] ?? '');
        $sanitized['booking_notification_email'] = sanitize_email($input['booking_notification_email'] ?? 'info@bestbalitravel.com');

        // Demo Theme
        $sanitized['active_demo'] = sanitize_text_field($input['active_demo'] ?? 'tropical-paradise');

        return $sanitized;
    }

    /**
     * Enqueue Admin Assets
     */
    public function enqueue_admin_assets($hook)
    {
        // Only load on our pages
        if (strpos($hook, 'bbt-') === false && strpos($hook, 'bbt_') === false) {
            return;
        }

        wp_enqueue_style(
            'bbt-admin',
            BBT_THEME_ASSETS . '/css/admin.css',
            array(),
            BBT_THEME_VERSION
        );

        wp_enqueue_script(
            'bbt-admin',
            BBT_THEME_ASSETS . '/js/admin.js',
            array('jquery'),
            BBT_THEME_VERSION,
            true
        );

        wp_localize_script('bbt-admin', 'bbtAdmin', array(
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('bbt_admin_nonce'),
        ));
    }

    /**
     * Render Settings Page
     */
    public function render_settings_page()
    {
        $active_tab = isset($_GET['tab']) ? sanitize_text_field($_GET['tab']) : 'general';
        ?>
        <div class="wrap bbt-settings-wrap">
            <h1 class="bbt-settings-title">
                <span class="dashicons dashicons-palmtree"></span>
                <?php esc_html_e('Best Bali Travel Settings', 'bestbalitravel'); ?>
            </h1>

            <nav class="bbt-settings-tabs nav-tab-wrapper">
                <a href="?page=bbt-settings&tab=general"
                    class="nav-tab <?php echo $active_tab === 'general' ? 'nav-tab-active' : ''; ?>">
                    <span class="dashicons dashicons-admin-settings"></span>
                    <?php esc_html_e('General', 'bestbalitravel'); ?>
                </a>
                <a href="?page=bbt-settings&tab=currency"
                    class="nav-tab <?php echo $active_tab === 'currency' ? 'nav-tab-active' : ''; ?>">
                    <span class="dashicons dashicons-money-alt"></span>
                    <?php esc_html_e('Currency', 'bestbalitravel'); ?>
                </a>
                <a href="?page=bbt-settings&tab=payments"
                    class="nav-tab <?php echo $active_tab === 'payments' ? 'nav-tab-active' : ''; ?>">
                    <span class="dashicons dashicons-credit-card"></span>
                    <?php esc_html_e('Payments', 'bestbalitravel'); ?>
                </a>
                <a href="?page=bbt-settings&tab=email"
                    class="nav-tab <?php echo $active_tab === 'email' ? 'nav-tab-active' : ''; ?>">
                    <span class="dashicons dashicons-email"></span>
                    <?php esc_html_e('Email', 'bestbalitravel'); ?>
                </a>
                <a href="?page=bbt-settings&tab=language"
                    class="nav-tab <?php echo $active_tab === 'language' ? 'nav-tab-active' : ''; ?>">
                    <span class="dashicons dashicons-translation"></span>
                    <?php esc_html_e('Language', 'bestbalitravel'); ?>
                </a>
            </nav>

            <form method="post" action="options.php" class="bbt-settings-form">
                <?php settings_fields('bbt_settings_group'); ?>

                <div class="bbt-tab-content">
                    <?php
                    switch ($active_tab) {
                        case 'currency':
                            include BBT_THEME_DIR . '/inc/admin/views/settings-currency.php';
                            break;
                        case 'payments':
                            include BBT_THEME_DIR . '/inc/admin/views/settings-payments.php';
                            break;
                        case 'email':
                            include BBT_THEME_DIR . '/inc/admin/views/settings-email.php';
                            break;
                        case 'language':
                            include BBT_THEME_DIR . '/inc/admin/views/settings-language.php';
                            break;
                        default:
                            include BBT_THEME_DIR . '/inc/admin/views/settings-general.php';
                            break;
                    }
                    ?>
                </div>

                <?php submit_button(__('Save Settings', 'bestbalitravel'), 'primary bbt-save-btn'); ?>
            </form>
        </div>
        <?php
    }

    /**
     * Render Demos Page
     */
    public function render_demos_page()
    {
        include BBT_THEME_DIR . '/inc/admin/views/settings-demos.php';
    }

    /**
     * Get Setting
     */
    public function get_setting($key, $default = '')
    {
        return isset($this->settings[$key]) ? $this->settings[$key] : $default;
    }

    /**
     * Get All Settings
     */
    public function get_all_settings()
    {
        return $this->settings;
    }
}

// Initialize
BBT_Admin::get_instance();
