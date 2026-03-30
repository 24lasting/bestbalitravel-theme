<?php
/**
 * Admin Menu Configuration
 * Consolidates all theme options under one "Best Bali Travel" menu
 *
 * @package BestBaliTravel
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register Main Admin Menu
 */
function bbt_register_admin_menu()
{
    // Main Menu
    add_menu_page(
        __('Best Bali Travel', 'bestbalitravel'),
        __('Best Bali Travel', 'bestbalitravel'),
        'manage_options',
        'bbt-dashboard',
        'bbt_dashboard_page',
        'dashicons-palmtree',
        5
    );

    // Dashboard submenu
    add_submenu_page(
        'bbt-dashboard',
        __('Dashboard', 'bestbalitravel'),
        __('Dashboard', 'bestbalitravel'),
        'manage_options',
        'bbt-dashboard',
        'bbt_dashboard_page'
    );

    // Currency Settings submenu
    add_submenu_page(
        'bbt-dashboard',
        __('Currency Settings', 'bestbalitravel'),
        __('💰 Currency', 'bestbalitravel'),
        'manage_options',
        'bbt-currency-settings',
        'bbt_currency_settings_page'
    );

    // Language Settings submenu
    add_submenu_page(
        'bbt-dashboard',
        __('Language Settings', 'bestbalitravel'),
        __('🌍 Languages', 'bestbalitravel'),
        'manage_options',
        'bbt-language-settings',
        'bbt_language_settings_page'
    );

    // Payment Settings submenu
    add_submenu_page(
        'bbt-dashboard',
        __('Payment Settings', 'bestbalitravel'),
        __('💳 Payments', 'bestbalitravel'),
        'manage_options',
        'bbt-payment-settings',
        'bbt_payment_settings_page'
    );

    // Settings submenu
    add_submenu_page(
        'bbt-dashboard',
        __('Theme Settings', 'bestbalitravel'),
        __('⚙️ Settings', 'bestbalitravel'),
        'manage_options',
        'bbt-settings',
        'bbt_settings_redirect'
    );
}
add_action('admin_menu', 'bbt_register_admin_menu');

/**
 * Move CPTs to BBT Menu
 */
function bbt_adjust_admin_menu()
{
    global $menu, $submenu;

    // Move Tours menu under BBT
    remove_menu_page('edit.php?post_type=tour');
    add_submenu_page(
        'bbt-dashboard',
        __('Tours', 'bestbalitravel'),
        __('Tours', 'bestbalitravel'),
        'edit_posts',
        'edit.php?post_type=tour'
    );
    add_submenu_page(
        'bbt-dashboard',
        __('Add New Tour', 'bestbalitravel'),
        __('Add New Tour', 'bestbalitravel'),
        'edit_posts',
        'post-new.php?post_type=tour'
    );

    // Move Activities menu under BBT
    remove_menu_page('edit.php?post_type=activity');
    add_submenu_page(
        'bbt-dashboard',
        __('Activities', 'bestbalitravel'),
        __('Activities', 'bestbalitravel'),
        'edit_posts',
        'edit.php?post_type=activity'
    );

    // Move Reviews menu under BBT
    remove_menu_page('edit.php?post_type=review');
    add_submenu_page(
        'bbt-dashboard',
        __('Reviews', 'bestbalitravel'),
        __('Reviews', 'bestbalitravel'),
        'edit_posts',
        'edit.php?post_type=review'
    );

    // Add Locations taxonomy
    add_submenu_page(
        'bbt-dashboard',
        __('Locations', 'bestbalitravel'),
        __('Locations', 'bestbalitravel'),
        'manage_categories',
        'edit-tags.php?taxonomy=tour_location&post_type=tour'
    );

    // Add Tour Types taxonomy
    add_submenu_page(
        'bbt-dashboard',
        __('Tour Types', 'bestbalitravel'),
        __('Tour Types', 'bestbalitravel'),
        'manage_categories',
        'edit-tags.php?taxonomy=tour_type&post_type=tour'
    );
}
add_action('admin_menu', 'bbt_adjust_admin_menu', 999);

/**
 * Fix parent file for taxonomy pages
 */
function bbt_fix_taxonomy_parent_file($parent_file)
{
    global $current_screen;

    if ($current_screen) {
        $taxonomies = array('tour_location', 'tour_type', 'tour_duration');

        if ($current_screen->taxonomy && in_array($current_screen->taxonomy, $taxonomies)) {
            return 'bbt-dashboard';
        }

        $post_types = array('tour', 'activity', 'review');
        if ($current_screen->post_type && in_array($current_screen->post_type, $post_types)) {
            return 'bbt-dashboard';
        }
    }

    return $parent_file;
}
add_filter('parent_file', 'bbt_fix_taxonomy_parent_file');

/**
 * Fix submenu file for taxonomy pages
 */
function bbt_fix_taxonomy_submenu_file($submenu_file, $parent_file)
{
    global $current_screen;

    if ($current_screen && $current_screen->taxonomy) {
        switch ($current_screen->taxonomy) {
            case 'tour_location':
                return 'edit-tags.php?taxonomy=tour_location&post_type=tour';
            case 'tour_type':
                return 'edit-tags.php?taxonomy=tour_type&post_type=tour';
        }
    }

    return $submenu_file;
}
add_filter('submenu_file', 'bbt_fix_taxonomy_submenu_file', 10, 2);

/**
 * Dashboard Page
 */
function bbt_dashboard_page()
{
    $tour_count = wp_count_posts('tour');
    $activity_count = wp_count_posts('activity');
    $review_count = wp_count_posts('review');
    ?>
        <div class="wrap bbt-dashboard">
            <h1><?php esc_html_e('Best Bali Travel Dashboard', 'bestbalitravel'); ?></h1>

            <div class="bbt-dashboard-cards" style="display: flex; gap: 20px; margin-top: 20px; flex-wrap: wrap;">
                <!-- Tours Card -->
                <div class="bbt-card"
                    style="background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); min-width: 200px;">
                    <h2 style="margin: 0 0 10px; color: #1e3a5f;">
                        <span class="dashicons dashicons-palmtree" style="font-size: 24px;"></span>
                        <?php esc_html_e('Tours', 'bestbalitravel'); ?>
                    </h2>
                    <p style="font-size: 32px; font-weight: bold; color: #f5a623; margin: 0;">
                        <?php echo esc_html($tour_count->publish); ?>
                    </p>
                    <p style="color: #666;"><?php esc_html_e('Published Tours', 'bestbalitravel'); ?></p>
                    <p>
                        <a href="<?php echo esc_url(admin_url('edit.php?post_type=tour')); ?>"
                            class="button"><?php esc_html_e('View All', 'bestbalitravel'); ?></a>
                        <a href="<?php echo esc_url(admin_url('post-new.php?post_type=tour')); ?>"
                            class="button button-primary"><?php esc_html_e('Add New', 'bestbalitravel'); ?></a>
                    </p>
                </div>

                <!-- Activities Card -->
                <div class="bbt-card"
                    style="background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); min-width: 200px;">
                    <h2 style="margin: 0 0 10px; color: #1e3a5f;">
                        <span class="dashicons dashicons-universal-access" style="font-size: 24px;"></span>
                        <?php esc_html_e('Activities', 'bestbalitravel'); ?>
                    </h2>
                    <p style="font-size: 32px; font-weight: bold; color: #48bb78; margin: 0;">
                        <?php echo esc_html($activity_count->publish); ?>
                    </p>
                    <p style="color: #666;"><?php esc_html_e('Published Activities', 'bestbalitravel'); ?></p>
                    <p>
                        <a href="<?php echo esc_url(admin_url('edit.php?post_type=activity')); ?>"
                            class="button"><?php esc_html_e('View All', 'bestbalitravel'); ?></a>
                        <a href="<?php echo esc_url(admin_url('post-new.php?post_type=activity')); ?>"
                            class="button button-primary"><?php esc_html_e('Add New', 'bestbalitravel'); ?></a>
                    </p>
                </div>

                <!-- Reviews Card -->
                <div class="bbt-card"
                    style="background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); min-width: 200px;">
                    <h2 style="margin: 0 0 10px; color: #1e3a5f;">
                        <span class="dashicons dashicons-star-filled" style="font-size: 24px;"></span>
                        <?php esc_html_e('Reviews', 'bestbalitravel'); ?>
                    </h2>
                    <p style="font-size: 32px; font-weight: bold; color: #ed8936; margin: 0;">
                        <?php echo esc_html($review_count->publish); ?>
                    </p>
                    <p style="color: #666;"><?php esc_html_e('Published Reviews', 'bestbalitravel'); ?></p>
                    <p>
                        <a href="<?php echo esc_url(admin_url('edit.php?post_type=review')); ?>"
                            class="button"><?php esc_html_e('View All', 'bestbalitravel'); ?></a>
                    </p>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="bbt-quick-links"
                style="background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); margin-top: 20px;">
                <h2><?php esc_html_e('Quick Links', 'bestbalitravel'); ?></h2>
                <p>
                    <a href="<?php echo esc_url(admin_url('customize.php')); ?>" class="button button-primary">
                        <span class="dashicons dashicons-admin-customizer"></span>
                        <?php esc_html_e('Theme Customizer', 'bestbalitravel'); ?>
                    </a>
                    <a href="<?php echo esc_url(admin_url('themes.php?page=bbt-demo-import')); ?>" class="button">
                        <span class="dashicons dashicons-download"></span>
                        <?php esc_html_e('Import Demo Content', 'bestbalitravel'); ?>
                    </a>
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="button" target="_blank">
                        <span class="dashicons dashicons-external"></span>
                        <?php esc_html_e('View Website', 'bestbalitravel'); ?>
                    </a>
                </p>
            </div>
        </div>
        <?php
}

/**
 * Settings Redirect (to Customizer)
 */
function bbt_settings_redirect()
{
    wp_redirect(admin_url('customize.php?autofocus[panel]=bbt_theme_options'));
    exit;
}

/**
 * Currency Settings Page
 */
function bbt_currency_settings_page()
{
    // Save settings
    if (isset($_POST['bbt_save_currency']) && wp_verify_nonce($_POST['bbt_currency_nonce'], 'bbt_currency_settings')) {
        update_option('bbt_default_currency', sanitize_text_field($_POST['bbt_default_currency']));
        update_option('bbt_enabled_currencies', array_map('sanitize_text_field', $_POST['bbt_enabled_currencies'] ?? array()));
        update_option('bbt_currency_api_key', sanitize_text_field($_POST['bbt_currency_api_key']));
        update_option('bbt_auto_detect_currency', isset($_POST['bbt_auto_detect_currency']) ? 1 : 0);
        echo '<div class="notice notice-success"><p>' . esc_html__('Currency settings saved!', 'bestbalitravel') . '</p></div>';
    }

    $currencies = array(
        'IDR' => array('name' => 'Indonesian Rupiah', 'symbol' => 'Rp', 'flag' => '🇮🇩'),
        'USD' => array('name' => 'US Dollar', 'symbol' => '$', 'flag' => '🇺🇸'),
        'EUR' => array('name' => 'Euro', 'symbol' => '€', 'flag' => '🇪🇺'),
        'GBP' => array('name' => 'British Pound', 'symbol' => '£', 'flag' => '🇬🇧'),
        'AUD' => array('name' => 'Australian Dollar', 'symbol' => 'A$', 'flag' => '🇦🇺'),
        'SGD' => array('name' => 'Singapore Dollar', 'symbol' => 'S$', 'flag' => '🇸🇬'),
        'MYR' => array('name' => 'Malaysian Ringgit', 'symbol' => 'RM', 'flag' => '🇲🇾'),
        'JPY' => array('name' => 'Japanese Yen', 'symbol' => '¥', 'flag' => '🇯🇵'),
        'CNY' => array('name' => 'Chinese Yuan', 'symbol' => '¥', 'flag' => '🇨🇳'),
        'KRW' => array('name' => 'Korean Won', 'symbol' => '₩', 'flag' => '🇰🇷'),
        'THB' => array('name' => 'Thai Baht', 'symbol' => '฿', 'flag' => '🇹🇭'),
        'INR' => array('name' => 'Indian Rupee', 'symbol' => '₹', 'flag' => '🇮🇳'),
    );

    $default_currency = get_option('bbt_default_currency', 'IDR');
    $enabled_currencies = get_option('bbt_enabled_currencies', array_keys($currencies));
    $api_key = get_option('bbt_currency_api_key', '');
    $auto_detect = get_option('bbt_auto_detect_currency', 1);
    ?>
        <div class="wrap bbt-settings-wrap">
            <h1 style="display:flex;align-items:center;gap:10px;">
                <span style="font-size:32px;">💰</span>
                <?php esc_html_e('Currency Settings', 'bestbalitravel'); ?>
            </h1>

            <form method="post" class="bbt-settings-form">
                <?php wp_nonce_field('bbt_currency_settings', 'bbt_currency_nonce'); ?>

                <div class="bbt-settings-card" style="background:#fff;padding:25px;border-radius:12px;box-shadow:0 2px 8px rgba(0,0,0,0.08);margin-top:20px;">
                    <h2 style="margin-top:0;border-bottom:2px solid #f5a623;padding-bottom:10px;">
                        <?php esc_html_e('Default Currency', 'bestbalitravel'); ?>
                    </h2>
                    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(180px,1fr));gap:12px;margin-top:15px;">
                        <?php foreach ($currencies as $code => $data): ?>
                                <label style="display:flex;align-items:center;gap:10px;padding:12px 15px;border:2px solid <?php echo $default_currency === $code ? '#f5a623' : '#e0e0e0'; ?>;border-radius:8px;cursor:pointer;transition:all 0.3s;background:<?php echo $default_currency === $code ? 'rgba(245,166,35,0.1)' : '#fff'; ?>;">
                                    <input type="radio" name="bbt_default_currency" value="<?php echo esc_attr($code); ?>" <?php checked($default_currency, $code); ?> style="accent-color:#f5a623;">
                                    <span style="font-size:24px;"><?php echo esc_html($data['flag']); ?></span>
                                    <div>
                                        <strong><?php echo esc_html($code); ?></strong>
                                        <small style="display:block;color:#666;"><?php echo esc_html($data['symbol']); ?></small>
                                    </div>
                                </label>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="bbt-settings-card" style="background:#fff;padding:25px;border-radius:12px;box-shadow:0 2px 8px rgba(0,0,0,0.08);margin-top:20px;">
                    <h2 style="margin-top:0;border-bottom:2px solid #48bb78;padding-bottom:10px;">
                        <?php esc_html_e('Enabled Currencies', 'bestbalitravel'); ?>
                    </h2>
                    <p style="color:#666;"><?php esc_html_e('Select which currencies customers can switch to:', 'bestbalitravel'); ?></p>
                    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:10px;margin-top:15px;">
                        <?php foreach ($currencies as $code => $data): ?>
                                <label style="display:flex;align-items:center;gap:10px;padding:10px 15px;border:1px solid #e0e0e0;border-radius:6px;cursor:pointer;">
                                    <input type="checkbox" name="bbt_enabled_currencies[]" value="<?php echo esc_attr($code); ?>" <?php checked(in_array($code, $enabled_currencies)); ?> style="accent-color:#48bb78;">
                                    <span style="font-size:20px;"><?php echo esc_html($data['flag']); ?></span>
                                    <span><?php echo esc_html($data['name']); ?></span>
                                </label>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="bbt-settings-card" style="background:#fff;padding:25px;border-radius:12px;box-shadow:0 2px 8px rgba(0,0,0,0.08);margin-top:20px;">
                    <h2 style="margin-top:0;border-bottom:2px solid #667eea;padding-bottom:10px;">
                        <?php esc_html_e('Exchange Rate API', 'bestbalitravel'); ?>
                    </h2>
                    <table class="form-table">
                        <tr>
                            <th><?php esc_html_e('API Key (Open Exchange Rates)', 'bestbalitravel'); ?></th>
                            <td>
                                <input type="text" name="bbt_currency_api_key" value="<?php echo esc_attr($api_key); ?>" class="regular-text" placeholder="Your API key">
                                <p class="description"><?php echo sprintf(__('Get your free API key from %s', 'bestbalitravel'), '<a href="https://openexchangerates.org/signup/free" target="_blank">openexchangerates.org</a>'); ?></p>
                            </td>
                        </tr>
                        <tr>
                            <th><?php esc_html_e('Auto-detect Currency', 'bestbalitravel'); ?></th>
                            <td>
                                <label style="display:flex;align-items:center;gap:10px;">
                                    <input type="checkbox" name="bbt_auto_detect_currency" value="1" <?php checked($auto_detect, 1); ?> style="accent-color:#667eea;">
                                    <?php esc_html_e('Automatically detect user currency from browser locale', 'bestbalitravel'); ?>
                                </label>
                            </td>
                        </tr>
                    </table>
                </div>

                <p style="margin-top:20px;">
                    <button type="submit" name="bbt_save_currency" class="button button-primary button-hero" style="background:linear-gradient(135deg,#f5a623,#e69316);border:none;padding:12px 40px;font-size:16px;">
                        💾 <?php esc_html_e('Save Currency Settings', 'bestbalitravel'); ?>
                    </button>
                </p>
            </form>
        </div>
        <?php
}

/**
 * Language Settings Page
 */
function bbt_language_settings_page()
{
    // Save settings
    if (isset($_POST['bbt_save_language']) && wp_verify_nonce($_POST['bbt_language_nonce'], 'bbt_language_settings')) {
        update_option('bbt_default_language', sanitize_text_field($_POST['bbt_default_language']));
        update_option('bbt_enabled_languages', array_map('sanitize_text_field', $_POST['bbt_enabled_languages'] ?? array()));
        update_option('bbt_language_switcher_style', sanitize_text_field($_POST['bbt_language_switcher_style']));
        echo '<div class="notice notice-success"><p>' . esc_html__('Language settings saved!', 'bestbalitravel') . '</p></div>';
    }

    $languages = array(
        'en' => array('name' => 'English', 'native' => 'English', 'flag' => '🇬🇧'),
        'id' => array('name' => 'Indonesian', 'native' => 'Bahasa Indonesia', 'flag' => '🇮🇩'),
        'zh' => array('name' => 'Chinese', 'native' => '中文', 'flag' => '🇨🇳'),
        'ja' => array('name' => 'Japanese', 'native' => '日本語', 'flag' => '🇯🇵'),
        'ko' => array('name' => 'Korean', 'native' => '한국어', 'flag' => '🇰🇷'),
        'de' => array('name' => 'German', 'native' => 'Deutsch', 'flag' => '🇩🇪'),
        'fr' => array('name' => 'French', 'native' => 'Français', 'flag' => '🇫🇷'),
        'es' => array('name' => 'Spanish', 'native' => 'Español', 'flag' => '🇪🇸'),
        'ru' => array('name' => 'Russian', 'native' => 'Русский', 'flag' => '🇷🇺'),
        'ar' => array('name' => 'Arabic', 'native' => 'العربية', 'flag' => '🇸🇦'),
    );

    $default_language = get_option('bbt_default_language', 'en');
    $enabled_languages = get_option('bbt_enabled_languages', array('en', 'id'));
    $switcher_style = get_option('bbt_language_switcher_style', 'dropdown');
    ?>
        <div class="wrap bbt-settings-wrap">
            <h1 style="display:flex;align-items:center;gap:10px;">
                <span style="font-size:32px;">🌍</span>
                <?php esc_html_e('Language Settings', 'bestbalitravel'); ?>
            </h1>

            <form method="post" class="bbt-settings-form">
                <?php wp_nonce_field('bbt_language_settings', 'bbt_language_nonce'); ?>

                <div class="bbt-settings-card" style="background:#fff;padding:25px;border-radius:12px;box-shadow:0 2px 8px rgba(0,0,0,0.08);margin-top:20px;">
                    <h2 style="margin-top:0;border-bottom:2px solid #667eea;padding-bottom:10px;">
                        <?php esc_html_e('Default Language', 'bestbalitravel'); ?>
                    </h2>
                    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:12px;margin-top:15px;">
                        <?php foreach ($languages as $code => $data): ?>
                                <label style="display:flex;align-items:center;gap:10px;padding:12px 15px;border:2px solid <?php echo $default_language === $code ? '#667eea' : '#e0e0e0'; ?>;border-radius:8px;cursor:pointer;transition:all 0.3s;background:<?php echo $default_language === $code ? 'rgba(102,126,234,0.1)' : '#fff'; ?>;">
                                    <input type="radio" name="bbt_default_language" value="<?php echo esc_attr($code); ?>" <?php checked($default_language, $code); ?> style="accent-color:#667eea;">
                                    <span style="font-size:24px;"><?php echo esc_html($data['flag']); ?></span>
                                    <div>
                                        <strong><?php echo esc_html($data['name']); ?></strong>
                                        <small style="display:block;color:#666;"><?php echo esc_html($data['native']); ?></small>
                                    </div>
                                </label>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="bbt-settings-card" style="background:#fff;padding:25px;border-radius:12px;box-shadow:0 2px 8px rgba(0,0,0,0.08);margin-top:20px;">
                    <h2 style="margin-top:0;border-bottom:2px solid #48bb78;padding-bottom:10px;">
                        <?php esc_html_e('Enabled Languages', 'bestbalitravel'); ?>
                    </h2>
                    <p style="color:#666;"><?php esc_html_e('Select which languages should be available in the language switcher:', 'bestbalitravel'); ?></p>
                    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(220px,1fr));gap:10px;margin-top:15px;">
                        <?php foreach ($languages as $code => $data): ?>
                                <label style="display:flex;align-items:center;gap:10px;padding:10px 15px;border:1px solid #e0e0e0;border-radius:6px;cursor:pointer;">
                                    <input type="checkbox" name="bbt_enabled_languages[]" value="<?php echo esc_attr($code); ?>" <?php checked(in_array($code, $enabled_languages)); ?> style="accent-color:#48bb78;">
                                    <span style="font-size:20px;"><?php echo esc_html($data['flag']); ?></span>
                                    <span><?php echo esc_html($data['native']); ?> (<?php echo esc_html($data['name']); ?>)</span>
                                </label>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="bbt-settings-card" style="background:#fff;padding:25px;border-radius:12px;box-shadow:0 2px 8px rgba(0,0,0,0.08);margin-top:20px;">
                    <h2 style="margin-top:0;border-bottom:2px solid #f5a623;padding-bottom:10px;">
                        <?php esc_html_e('Switcher Style', 'bestbalitravel'); ?>
                    </h2>
                    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:15px;margin-top:15px;">
                        <label style="text-align:center;padding:20px;border:2px solid <?php echo $switcher_style === 'dropdown' ? '#f5a623' : '#e0e0e0'; ?>;border-radius:8px;cursor:pointer;">
                            <input type="radio" name="bbt_language_switcher_style" value="dropdown" <?php checked($switcher_style, 'dropdown'); ?> style="display:block;margin:0 auto 10px;">
                            <span style="font-size:24px;">📋</span>
                            <div style="margin-top:5px;"><?php esc_html_e('Dropdown', 'bestbalitravel'); ?></div>
                        </label>
                        <label style="text-align:center;padding:20px;border:2px solid <?php echo $switcher_style === 'flags' ? '#f5a623' : '#e0e0e0'; ?>;border-radius:8px;cursor:pointer;">
                            <input type="radio" name="bbt_language_switcher_style" value="flags" <?php checked($switcher_style, 'flags'); ?> style="display:block;margin:0 auto 10px;">
                            <span style="font-size:24px;">🏳️</span>
                            <div style="margin-top:5px;"><?php esc_html_e('Flags Only', 'bestbalitravel'); ?></div>
                        </label>
                        <label style="text-align:center;padding:20px;border:2px solid <?php echo $switcher_style === 'names' ? '#f5a623' : '#e0e0e0'; ?>;border-radius:8px;cursor:pointer;">
                            <input type="radio" name="bbt_language_switcher_style" value="names" <?php checked($switcher_style, 'names'); ?> style="display:block;margin:0 auto 10px;">
                            <span style="font-size:24px;">🔤</span>
                            <div style="margin-top:5px;"><?php esc_html_e('Names Only', 'bestbalitravel'); ?></div>
                        </label>
                    </div>
                </div>

                <div class="bbt-settings-card" style="background:linear-gradient(135deg,#667eea20,#764ba220);padding:20px;border-radius:12px;border:1px solid #667eea40;margin-top:20px;">
                    <h3 style="margin:0 0 10px;color:#667eea;">💡 <?php esc_html_e('Translation Plugins', 'bestbalitravel'); ?></h3>
                    <p style="margin:0;color:#555;"><?php esc_html_e('For full translation support, we recommend using:', 'bestbalitravel'); ?></p>
                    <ul style="margin:10px 0 0 20px;color:#666;">
                        <li><a href="https://wpml.org/" target="_blank">WPML</a> - <?php esc_html_e('Premium multi-language solution', 'bestbalitravel'); ?></li>
                        <li><a href="https://polylang.pro/" target="_blank">Polylang</a> - <?php esc_html_e('Popular free translation plugin', 'bestbalitravel'); ?></li>
                        <li><a href="https://translatepress.com/" target="_blank">TranslatePress</a> - <?php esc_html_e('Visual translation editor', 'bestbalitravel'); ?></li>
                    </ul>
                </div>

                <p style="margin-top:20px;">
                    <button type="submit" name="bbt_save_language" class="button button-primary button-hero" style="background:linear-gradient(135deg,#667eea,#764ba2);border:none;padding:12px 40px;font-size:16px;">
                        💾 <?php esc_html_e('Save Language Settings', 'bestbalitravel'); ?>
                    </button>
                </p>
            </form>
        </div>
        <?php
}

/**
 * Payment Settings Page
 */
function bbt_payment_settings_page()
{
    // Save settings
    if (isset($_POST['bbt_save_payment']) && wp_verify_nonce($_POST['bbt_payment_nonce'], 'bbt_payment_settings')) {
        // Midtrans
        update_option('bbt_midtrans_enabled', isset($_POST['bbt_midtrans_enabled']) ? 1 : 0);
        update_option('bbt_midtrans_server_key', sanitize_text_field($_POST['bbt_midtrans_server_key']));
        update_option('bbt_midtrans_client_key', sanitize_text_field($_POST['bbt_midtrans_client_key']));
        update_option('bbt_midtrans_sandbox', isset($_POST['bbt_midtrans_sandbox']) ? 1 : 0);

        // Stripe
        update_option('bbt_stripe_enabled', isset($_POST['bbt_stripe_enabled']) ? 1 : 0);
        update_option('bbt_stripe_public_key', sanitize_text_field($_POST['bbt_stripe_public_key']));
        update_option('bbt_stripe_secret_key', sanitize_text_field($_POST['bbt_stripe_secret_key']));

        // Wise
        update_option('bbt_wise_enabled', isset($_POST['bbt_wise_enabled']) ? 1 : 0);
        update_option('bbt_wise_api_key', sanitize_text_field($_POST['bbt_wise_api_key']));
        update_option('bbt_wise_profile_id', sanitize_text_field($_POST['bbt_wise_profile_id']));

        echo '<div class="notice notice-success"><p>' . esc_html__('Payment settings saved!', 'bestbalitravel') . '</p></div>';
    }
    ?>
        <div class="wrap bbt-settings-wrap">
            <h1 style="display:flex;align-items:center;gap:10px;">
                <span style="font-size:32px;">💳</span>
                <?php esc_html_e('Payment Settings', 'bestbalitravel'); ?>
            </h1>

            <form method="post" class="bbt-settings-form">
                <?php wp_nonce_field('bbt_payment_settings', 'bbt_payment_nonce'); ?>

                <!-- Midtrans -->
                <div class="bbt-settings-card" style="background:#fff;padding:25px;border-radius:12px;box-shadow:0 2px 8px rgba(0,0,0,0.08);margin-top:20px;">
                    <div style="display:flex;align-items:center;justify-content:space-between;border-bottom:2px solid #00a2e8;padding-bottom:10px;margin-bottom:15px;">
                        <h2 style="margin:0;display:flex;align-items:center;gap:10px;">
                            <img src="https://midtrans.com/assets/img/og-image.png" alt="Midtrans" style="height:25px;border-radius:4px;">
                            Midtrans
                        </h2>
                        <label style="display:flex;align-items:center;gap:8px;cursor:pointer;">
                            <input type="checkbox" name="bbt_midtrans_enabled" value="1" <?php checked(get_option('bbt_midtrans_enabled', 0), 1); ?> style="accent-color:#00a2e8;width:18px;height:18px;">
                            <span style="font-weight:600;color:#00a2e8;"><?php esc_html_e('Enable', 'bestbalitravel'); ?></span>
                        </label>
                    </div>
                    <table class="form-table">
                        <tr>
                            <th><?php esc_html_e('Server Key', 'bestbalitravel'); ?></th>
                            <td><input type="password" name="bbt_midtrans_server_key" value="<?php echo esc_attr(get_option('bbt_midtrans_server_key', '')); ?>" class="regular-text"></td>
                        </tr>
                        <tr>
                            <th><?php esc_html_e('Client Key', 'bestbalitravel'); ?></th>
                            <td><input type="text" name="bbt_midtrans_client_key" value="<?php echo esc_attr(get_option('bbt_midtrans_client_key', '')); ?>" class="regular-text"></td>
                        </tr>
                        <tr>
                            <th><?php esc_html_e('Sandbox Mode', 'bestbalitravel'); ?></th>
                            <td>
                                <label><input type="checkbox" name="bbt_midtrans_sandbox" value="1" <?php checked(get_option('bbt_midtrans_sandbox', 1), 1); ?>> <?php esc_html_e('Enable sandbox/test mode', 'bestbalitravel'); ?></label>
                            </td>
                        </tr>
                    </table>
                </div>

                <!-- Stripe -->
                <div class="bbt-settings-card" style="background:#fff;padding:25px;border-radius:12px;box-shadow:0 2px 8px rgba(0,0,0,0.08);margin-top:20px;">
                    <div style="display:flex;align-items:center;justify-content:space-between;border-bottom:2px solid #635bff;padding-bottom:10px;margin-bottom:15px;">
                        <h2 style="margin:0;display:flex;align-items:center;gap:10px;">
                            <span style="font-size:24px;">💎</span>
                            Stripe
                        </h2>
                        <label style="display:flex;align-items:center;gap:8px;cursor:pointer;">
                            <input type="checkbox" name="bbt_stripe_enabled" value="1" <?php checked(get_option('bbt_stripe_enabled', 0), 1); ?> style="accent-color:#635bff;width:18px;height:18px;">
                            <span style="font-weight:600;color:#635bff;"><?php esc_html_e('Enable', 'bestbalitravel'); ?></span>
                        </label>
                    </div>
                    <table class="form-table">
                        <tr>
                            <th><?php esc_html_e('Publishable Key', 'bestbalitravel'); ?></th>
                            <td><input type="text" name="bbt_stripe_public_key" value="<?php echo esc_attr(get_option('bbt_stripe_public_key', '')); ?>" class="regular-text" placeholder="pk_..."></td>
                        </tr>
                        <tr>
                            <th><?php esc_html_e('Secret Key', 'bestbalitravel'); ?></th>
                            <td><input type="password" name="bbt_stripe_secret_key" value="<?php echo esc_attr(get_option('bbt_stripe_secret_key', '')); ?>" class="regular-text" placeholder="sk_..."></td>
                        </tr>
                    </table>
                </div>

                <!-- Wise -->
                <div class="bbt-settings-card" style="background:#fff;padding:25px;border-radius:12px;box-shadow:0 2px 8px rgba(0,0,0,0.08);margin-top:20px;">
                    <div style="display:flex;align-items:center;justify-content:space-between;border-bottom:2px solid #00b9a5;padding-bottom:10px;margin-bottom:15px;">
                        <h2 style="margin:0;display:flex;align-items:center;gap:10px;">
                            <span style="font-size:24px;">🌐</span>
                            Wise (TransferWise)
                        </h2>
                        <label style="display:flex;align-items:center;gap:8px;cursor:pointer;">
                            <input type="checkbox" name="bbt_wise_enabled" value="1" <?php checked(get_option('bbt_wise_enabled', 0), 1); ?> style="accent-color:#00b9a5;width:18px;height:18px;">
                            <span style="font-weight:600;color:#00b9a5;"><?php esc_html_e('Enable', 'bestbalitravel'); ?></span>
                        </label>
                    </div>
                    <table class="form-table">
                        <tr>
                            <th><?php esc_html_e('API Key', 'bestbalitravel'); ?></th>
                            <td><input type="password" name="bbt_wise_api_key" value="<?php echo esc_attr(get_option('bbt_wise_api_key', '')); ?>" class="regular-text"></td>
                        </tr>
                        <tr>
                            <th><?php esc_html_e('Profile ID', 'bestbalitravel'); ?></th>
                            <td><input type="text" name="bbt_wise_profile_id" value="<?php echo esc_attr(get_option('bbt_wise_profile_id', '')); ?>" class="regular-text"></td>
                        </tr>
                    </table>
                </div>

                <p style="margin-top:20px;">
                    <button type="submit" name="bbt_save_payment" class="button button-primary button-hero" style="background:linear-gradient(135deg,#48bb78,#38a169);border:none;padding:12px 40px;font-size:16px;">
                        💾 <?php esc_html_e('Save Payment Settings', 'bestbalitravel'); ?>
                    </button>
                </p>
            </form>
        </div>
        <?php
}

