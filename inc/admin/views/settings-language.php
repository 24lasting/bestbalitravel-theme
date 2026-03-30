<?php
/**
 * Language Settings Tab
 *
 * @package BestBaliTravel
 */

if (!defined('ABSPATH')) {
    exit;
}

$settings = get_option('bbt_settings', array());
$default_language = $settings['default_language'] ?? 'en';
$enabled_languages = $settings['enabled_languages'] ?? array('en', 'id');

$all_languages = array(
    'en' => array('name' => 'English', 'native' => 'English', 'flag' => '🇬🇧'),
    'id' => array('name' => 'Indonesian', 'native' => 'Bahasa Indonesia', 'flag' => '🇮🇩'),
    'ja' => array('name' => 'Japanese', 'native' => '日本語', 'flag' => '🇯🇵'),
    'zh' => array('name' => 'Chinese', 'native' => '中文', 'flag' => '🇨🇳'),
    'ko' => array('name' => 'Korean', 'native' => '한국어', 'flag' => '🇰🇷'),
    'de' => array('name' => 'German', 'native' => 'Deutsch', 'flag' => '🇩🇪'),
    'fr' => array('name' => 'French', 'native' => 'Français', 'flag' => '🇫🇷'),
    'es' => array('name' => 'Spanish', 'native' => 'Español', 'flag' => '🇪🇸'),
    'ru' => array('name' => 'Russian', 'native' => 'Русский', 'flag' => '🇷🇺'),
    'ar' => array('name' => 'Arabic', 'native' => 'العربية', 'flag' => '🇸🇦', 'rtl' => true),
);
?>

<div class="bbt-settings-section">
    <h2><?php esc_html_e('Language Settings', 'bestbalitravel'); ?></h2>
    <p class="description"><?php esc_html_e('Configure multi-language support for your website.', 'bestbalitravel'); ?></p>
    
    <table class="form-table">
        <tr>
            <th scope="row">
                <label for="bbt_default_language"><?php esc_html_e('Default Language', 'bestbalitravel'); ?></label>
            </th>
            <td>
                <select id="bbt_default_language" name="bbt_settings[default_language]" class="regular-text">
                    <?php foreach ($all_languages as $code => $language) : ?>
                        <option value="<?php echo esc_attr($code); ?>" <?php selected($default_language, $code); ?>>
                            <?php echo esc_html($language['flag'] . ' ' . $language['name'] . ' (' . $language['native'] . ')'); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </td>
        </tr>
    </table>
</div>

<div class="bbt-settings-section">
    <h2><?php esc_html_e('Enabled Languages', 'bestbalitravel'); ?></h2>
    <p class="description"><?php esc_html_e('Select which languages visitors can choose from.', 'bestbalitravel'); ?></p>
    
    <div class="bbt-language-grid">
        <?php foreach ($all_languages as $code => $language) : 
            $is_enabled = in_array($code, $enabled_languages);
            $is_rtl = isset($language['rtl']) && $language['rtl'];
        ?>
            <label class="bbt-language-item <?php echo $is_enabled ? 'checked' : ''; ?>">
                <input type="checkbox" 
                       name="bbt_settings[enabled_languages][]" 
                       value="<?php echo esc_attr($code); ?>"
                       <?php checked($is_enabled); ?>>
                <span class="bbt-language-flag"><?php echo esc_html($language['flag']); ?></span>
                <span class="bbt-language-info">
                    <span class="bbt-language-name"><?php echo esc_html($language['name']); ?></span>
                    <span class="bbt-language-native"><?php echo esc_html($language['native']); ?></span>
                </span>
                <?php if ($is_rtl) : ?>
                    <span class="bbt-rtl-badge">RTL</span>
                <?php endif; ?>
            </label>
        <?php endforeach; ?>
    </div>
</div>

<div class="bbt-settings-section">
    <h2><?php esc_html_e('Language Switcher', 'bestbalitravel'); ?></h2>
    
    <table class="form-table">
        <tr>
            <th scope="row"><?php esc_html_e('Switcher Style', 'bestbalitravel'); ?></th>
            <td>
                <label class="bbt-switcher-option">
                    <input type="radio" 
                           name="bbt_settings[language_switcher_style]" 
                           value="dropdown" 
                           <?php checked($settings['language_switcher_style'] ?? 'dropdown', 'dropdown'); ?>>
                    <span class="bbt-switcher-preview bbt-dropdown-preview">
                        <span class="bbt-preview-label"><?php esc_html_e('Dropdown', 'bestbalitravel'); ?></span>
                        <span class="bbt-preview-example">🇬🇧 EN ▼</span>
                    </span>
                </label>
                
                <label class="bbt-switcher-option">
                    <input type="radio" 
                           name="bbt_settings[language_switcher_style]" 
                           value="flags" 
                           <?php checked($settings['language_switcher_style'] ?? 'dropdown', 'flags'); ?>>
                    <span class="bbt-switcher-preview bbt-flags-preview">
                        <span class="bbt-preview-label"><?php esc_html_e('Flags Only', 'bestbalitravel'); ?></span>
                        <span class="bbt-preview-example">🇬🇧 🇮🇩 🇯🇵</span>
                    </span>
                </label>
                
                <label class="bbt-switcher-option">
                    <input type="radio" 
                           name="bbt_settings[language_switcher_style]" 
                           value="text" 
                           <?php checked($settings['language_switcher_style'] ?? 'dropdown', 'text'); ?>>
                    <span class="bbt-switcher-preview bbt-text-preview">
                        <span class="bbt-preview-label"><?php esc_html_e('Text Only', 'bestbalitravel'); ?></span>
                        <span class="bbt-preview-example">EN | ID | JP</span>
                    </span>
                </label>
            </td>
        </tr>
        
        <tr>
            <th scope="row"><?php esc_html_e('Auto-detect Language', 'bestbalitravel'); ?></th>
            <td>
                <label>
                    <input type="checkbox" 
                           name="bbt_settings[language_auto_detect]" 
                           value="1" 
                           <?php checked($settings['language_auto_detect'] ?? 0, 1); ?>>
                    <?php esc_html_e('Automatically detect visitor language from browser settings', 'bestbalitravel'); ?>
                </label>
            </td>
        </tr>
    </table>
</div>

<div class="bbt-settings-section">
    <h2><?php esc_html_e('Translation Plugin Compatibility', 'bestbalitravel'); ?></h2>
    
    <div class="bbt-plugin-compatibility">
        <?php 
        $plugins = array(
            'wpml' => array(
                'name' => 'WPML',
                'active' => class_exists('SitePress'),
                'url' => 'https://wpml.org/'
            ),
            'polylang' => array(
                'name' => 'Polylang',
                'active' => function_exists('pll_the_languages'),
                'url' => 'https://polylang.pro/'
            ),
            'translatepress' => array(
                'name' => 'TranslatePress',
                'active' => class_exists('TRP_Translate_Press'),
                'url' => 'https://translatepress.com/'
            ),
        );
        
        foreach ($plugins as $key => $plugin) : ?>
            <div class="bbt-plugin-item <?php echo $plugin['active'] ? 'active' : ''; ?>">
                <span class="bbt-plugin-status">
                    <?php if ($plugin['active']) : ?>
                        <span class="dashicons dashicons-yes-alt" style="color: #10b981;"></span>
                    <?php else : ?>
                        <span class="dashicons dashicons-marker" style="color: #ccc;"></span>
                    <?php endif; ?>
                </span>
                <span class="bbt-plugin-name"><?php echo esc_html($plugin['name']); ?></span>
                <span class="bbt-plugin-label">
                    <?php if ($plugin['active']) : ?>
                        <span style="color: #10b981;"><?php esc_html_e('Active', 'bestbalitravel'); ?></span>
                    <?php else : ?>
                        <a href="<?php echo esc_url($plugin['url']); ?>" target="_blank"><?php esc_html_e('Learn More', 'bestbalitravel'); ?></a>
                    <?php endif; ?>
                </span>
            </div>
        <?php endforeach; ?>
    </div>
    
    <p class="description" style="margin-top: 15px;">
        <?php esc_html_e('This theme is fully compatible with major translation plugins. Install one of the above plugins for advanced multilingual features.', 'bestbalitravel'); ?>
    </p>
</div>

<style>
.bbt-language-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 10px;
    margin-top: 15px;
}

.bbt-language-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 15px;
    background: #fff;
    border: 2px solid #ddd;
    border-radius: 10px;
    cursor: pointer;
    transition: all 0.2s ease;
}

.bbt-language-item:hover {
    border-color: #f5a623;
}

.bbt-language-item.checked {
    border-color: #f5a623;
    background: #fffbf5;
}

.bbt-language-item input[type="checkbox"] {
    margin: 0;
}

.bbt-language-flag {
    font-size: 28px;
}

.bbt-language-info {
    display: flex;
    flex-direction: column;
    flex: 1;
}

.bbt-language-name {
    font-weight: 600;
    color: #1e3a5f;
}

.bbt-language-native {
    font-size: 13px;
    color: #666;
}

.bbt-rtl-badge {
    padding: 2px 6px;
    background: #fef3c7;
    color: #d97706;
    font-size: 10px;
    font-weight: 600;
    border-radius: 4px;
}

/* Switcher Options */
.bbt-switcher-option {
    display: inline-flex;
    margin-right: 15px;
    margin-bottom: 10px;
    cursor: pointer;
}

.bbt-switcher-option input {
    display: none;
}

.bbt-switcher-preview {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 15px 25px;
    background: #f9f9f9;
    border: 2px solid #ddd;
    border-radius: 10px;
    transition: all 0.2s;
}

.bbt-switcher-option input:checked + .bbt-switcher-preview {
    border-color: #f5a623;
    background: #fffbf5;
}

.bbt-preview-label {
    font-weight: 500;
    margin-bottom: 8px;
}

.bbt-preview-example {
    font-size: 14px;
    color: #666;
}

/* Plugin Compatibility */
.bbt-plugin-compatibility {
    display: flex;
    gap: 15px;
    flex-wrap: wrap;
    margin-top: 15px;
}

.bbt-plugin-item {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 12px 20px;
    background: #f9f9f9;
    border-radius: 8px;
}

.bbt-plugin-item.active {
    background: #f0fdf4;
}

.bbt-plugin-name {
    font-weight: 500;
}
</style>

<script>
jQuery(document).ready(function($) {
    // Toggle checkbox styling
    $('.bbt-language-item input[type="checkbox"]').on('change', function() {
        $(this).closest('.bbt-language-item').toggleClass('checked', this.checked);
    });
});
</script>
