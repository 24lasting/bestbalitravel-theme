<?php
/**
 * Currency Settings Tab
 *
 * @package BestBaliTravel
 */

if (!defined('ABSPATH')) {
    exit;
}

$settings = get_option('bbt_settings', array());
$default_currency = $settings['default_currency'] ?? 'IDR';
$enabled_currencies = $settings['enabled_currencies'] ?? array('IDR', 'USD');

$all_currencies = array(
    'IDR' => array('name' => 'Indonesian Rupiah', 'symbol' => 'Rp', 'flag' => '🇮🇩'),
    'USD' => array('name' => 'US Dollar', 'symbol' => '$', 'flag' => '🇺🇸'),
    'EUR' => array('name' => 'Euro', 'symbol' => '€', 'flag' => '🇪🇺'),
    'GBP' => array('name' => 'British Pound', 'symbol' => '£', 'flag' => '🇬🇧'),
    'AUD' => array('name' => 'Australian Dollar', 'symbol' => 'A$', 'flag' => '🇦🇺'),
    'SGD' => array('name' => 'Singapore Dollar', 'symbol' => 'S$', 'flag' => '🇸🇬'),
    'JPY' => array('name' => 'Japanese Yen', 'symbol' => '¥', 'flag' => '🇯🇵'),
    'CNY' => array('name' => 'Chinese Yuan', 'symbol' => '¥', 'flag' => '🇨🇳'),
    'MYR' => array('name' => 'Malaysian Ringgit', 'symbol' => 'RM', 'flag' => '🇲🇾'),
    'THB' => array('name' => 'Thai Baht', 'symbol' => '฿', 'flag' => '🇹🇭'),
    'KRW' => array('name' => 'South Korean Won', 'symbol' => '₩', 'flag' => '🇰🇷'),
    'INR' => array('name' => 'Indian Rupee', 'symbol' => '₹', 'flag' => '🇮🇳'),
);
?>

<div class="bbt-settings-section">
    <h2>
        <?php esc_html_e('Currency Settings', 'bestbalitravel'); ?>
    </h2>
    <p class="description">
        <?php esc_html_e('Configure multi-currency support for your tours.', 'bestbalitravel'); ?>
    </p>

    <table class="form-table">
        <tr>
            <th scope="row">
                <label for="bbt_default_currency">
                    <?php esc_html_e('Default Currency', 'bestbalitravel'); ?>
                </label>
            </th>
            <td>
                <select id="bbt_default_currency" name="bbt_settings[default_currency]" class="regular-text">
                    <?php foreach ($all_currencies as $code => $currency): ?>
                        <option value="<?php echo esc_attr($code); ?>" <?php selected($default_currency, $code); ?>>
                            <?php echo esc_html($currency['flag'] . ' ' . $code . ' - ' . $currency['name'] . ' (' . $currency['symbol'] . ')'); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <p class="description">
                    <?php esc_html_e('This is the base currency for all tour prices.', 'bestbalitravel'); ?>
                </p>
            </td>
        </tr>
    </table>
</div>

<div class="bbt-settings-section">
    <h2>
        <?php esc_html_e('Enabled Currencies', 'bestbalitravel'); ?>
    </h2>
    <p class="description">
        <?php esc_html_e('Select which currencies visitors can choose from.', 'bestbalitravel'); ?>
    </p>

    <div class="bbt-currency-grid">
        <?php foreach ($all_currencies as $code => $currency):
            $is_enabled = in_array($code, $enabled_currencies);
            ?>
            <label class="bbt-currency-item <?php echo $is_enabled ? 'checked' : ''; ?>">
                <input type="checkbox" name="bbt_settings[enabled_currencies][]" value="<?php echo esc_attr($code); ?>"
                    <?php checked($is_enabled); ?>>
                <span class="bbt-currency-flag">
                    <?php echo esc_html($currency['flag']); ?>
                </span>
                <span class="bbt-currency-code">
                    <?php echo esc_html($code); ?>
                </span>
                <span class="bbt-currency-name">
                    <?php echo esc_html($currency['name']); ?>
                </span>
                <span class="bbt-currency-symbol">
                    <?php echo esc_html($currency['symbol']); ?>
                </span>
            </label>
        <?php endforeach; ?>
    </div>
</div>

<div class="bbt-settings-section">
    <h2>
        <?php esc_html_e('Exchange Rate Settings', 'bestbalitravel'); ?>
    </h2>

    <table class="form-table">
        <tr>
            <th scope="row">
                <label for="bbt_exchange_rate_source">
                    <?php esc_html_e('Exchange Rate Source', 'bestbalitravel'); ?>
                </label>
            </th>
            <td>
                <select id="bbt_exchange_rate_source" name="bbt_settings[exchange_rate_source]" class="regular-text">
                    <option value="manual" <?php selected($settings['exchange_rate_source'] ?? 'manual', 'manual'); ?>
                        >
                        <?php esc_html_e('Manual (Set rates manually)', 'bestbalitravel'); ?>
                    </option>
                    <option value="api" <?php selected($settings['exchange_rate_source'] ?? 'manual', 'api'); ?>>
                        <?php esc_html_e('API (Automatic updates)', 'bestbalitravel'); ?>
                    </option>
                </select>
            </td>
        </tr>

        <tr class="bbt-api-key-row"
            style="<?php echo ($settings['exchange_rate_source'] ?? 'manual') === 'manual' ? 'display:none;' : ''; ?>">
            <th scope="row">
                <label for="bbt_exchange_rate_api">
                    <?php esc_html_e('Exchange Rate API Key', 'bestbalitravel'); ?>
                </label>
            </th>
            <td>
                <input type="text" id="bbt_exchange_rate_api" name="bbt_settings[exchange_rate_api]"
                    value="<?php echo esc_attr($settings['exchange_rate_api'] ?? ''); ?>" class="regular-text">
                <p class="description">
                    <?php
                    printf(
                        esc_html__('Get your free API key from %s', 'bestbalitravel'),
                        '<a href="https://openexchangerates.org/signup/free" target="_blank">Open Exchange Rates</a>'
                    );
                    ?>
                </p>
            </td>
        </tr>
    </table>
</div>

<style>
    .bbt-currency-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 10px;
        margin-top: 15px;
    }

    .bbt-currency-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 12px 15px;
        background: #fff;
        border: 2px solid #ddd;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .bbt-currency-item:hover {
        border-color: #f5a623;
    }

    .bbt-currency-item.checked {
        border-color: #f5a623;
        background: #fffbf5;
    }

    .bbt-currency-item input[type="checkbox"] {
        margin: 0;
    }

    .bbt-currency-flag {
        font-size: 24px;
    }

    .bbt-currency-code {
        font-weight: 600;
        min-width: 40px;
    }

    .bbt-currency-name {
        flex: 1;
        color: #666;
    }

    .bbt-currency-symbol {
        font-weight: 500;
        color: #f5a623;
    }
</style>

<script>
    jQuery(document).ready(function ($) {
        // Toggle API key field
        $('#bbt_exchange_rate_source').on('change', function () {
            if ($(this).val() === 'api') {
                $('.bbt-api-key-row').show();
            } else {
                $('.bbt-api-key-row').hide();
            }
        });

        // Toggle checkbox styling
        $('.bbt-currency-item input[type="checkbox"]').on('change', function () {
            $(this).closest('.bbt-currency-item').toggleClass('checked', this.checked);
        });
    });
</script>