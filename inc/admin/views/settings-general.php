<?php
/**
 * General Settings Tab
 *
 * @package BestBaliTravel
 */

if (!defined('ABSPATH')) {
    exit;
}

$settings = get_option('bbt_settings', array());
?>

<div class="bbt-settings-section">
    <h2>
        <?php esc_html_e('General Settings', 'bestbalitravel'); ?>
    </h2>
    <p class="description">
        <?php esc_html_e('Configure basic theme settings.', 'bestbalitravel'); ?>
    </p>

    <table class="form-table">
        <tr>
            <th scope="row">
                <label for="bbt_company_name">
                    <?php esc_html_e('Company Name', 'bestbalitravel'); ?>
                </label>
            </th>
            <td>
                <input type="text" id="bbt_company_name" name="bbt_settings[company_name]"
                    value="<?php echo esc_attr($settings['company_name'] ?? 'Best Bali Travel'); ?>"
                    class="regular-text">
            </td>
        </tr>

        <tr>
            <th scope="row">
                <label for="bbt_admin_email">
                    <?php esc_html_e('Admin Email', 'bestbalitravel'); ?>
                </label>
            </th>
            <td>
                <input type="email" id="bbt_admin_email" name="bbt_settings[admin_email]"
                    value="<?php echo esc_attr($settings['admin_email'] ?? get_option('admin_email')); ?>"
                    class="regular-text">
                <p class="description">
                    <?php esc_html_e('Main admin email for notifications.', 'bestbalitravel'); ?>
                </p>
            </td>
        </tr>

        <tr>
            <th scope="row">
                <label for="bbt_whatsapp">
                    <?php esc_html_e('WhatsApp Number', 'bestbalitravel'); ?>
                </label>
            </th>
            <td>
                <input type="text" id="bbt_whatsapp" name="bbt_settings[whatsapp]"
                    value="<?php echo esc_attr($settings['whatsapp'] ?? '+6287854806011'); ?>" class="regular-text"
                    placeholder="+6287854806011">
                <p class="description">
                    <?php esc_html_e('Include country code (e.g., +62 for Indonesia).', 'bestbalitravel'); ?>
                </p>
            </td>
        </tr>
    </table>
</div>

<div class="bbt-settings-section">
    <h2>
        <?php esc_html_e('Contact Information', 'bestbalitravel'); ?>
    </h2>

    <table class="form-table">
        <tr>
            <th scope="row">
                <label for="bbt_phone">
                    <?php esc_html_e('Phone Number', 'bestbalitravel'); ?>
                </label>
            </th>
            <td>
                <input type="text" id="bbt_phone" name="bbt_settings[phone]"
                    value="<?php echo esc_attr($settings['phone'] ?? ''); ?>" class="regular-text">
            </td>
        </tr>

        <tr>
            <th scope="row">
                <label for="bbt_address">
                    <?php esc_html_e('Address', 'bestbalitravel'); ?>
                </label>
            </th>
            <td>
                <textarea id="bbt_address" name="bbt_settings[address]" rows="3"
                    class="large-text"><?php echo esc_textarea($settings['address'] ?? ''); ?></textarea>
            </td>
        </tr>
    </table>
</div>

<div class="bbt-settings-section">
    <h2>
        <?php esc_html_e('Social Media', 'bestbalitravel'); ?>
    </h2>

    <table class="form-table">
        <?php
        $social_networks = array(
            'instagram' => array('label' => 'Instagram', 'icon' => 'dashicons-instagram'),
            'facebook' => array('label' => 'Facebook', 'icon' => 'dashicons-facebook'),
            'tiktok' => array('label' => 'TikTok', 'icon' => 'dashicons-video-alt3'),
            'youtube' => array('label' => 'YouTube', 'icon' => 'dashicons-youtube'),
            'twitter' => array('label' => 'Twitter/X', 'icon' => 'dashicons-twitter'),
        );

        foreach ($social_networks as $key => $network): ?>
            <tr>
                <th scope="row">
                    <label for="bbt_<?php echo esc_attr($key); ?>">
                        <span class="dashicons <?php echo esc_attr($network['icon']); ?>"></span>
                        <?php echo esc_html($network['label']); ?>
                    </label>
                </th>
                <td>
                    <input type="url" id="bbt_<?php echo esc_attr($key); ?>"
                        name="bbt_settings[<?php echo esc_attr($key); ?>]"
                        value="<?php echo esc_url($settings[$key] ?? ''); ?>" class="regular-text" placeholder="https://">
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>