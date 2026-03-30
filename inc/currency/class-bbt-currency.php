<?php
/**
 * Multi-Currency Manager
 *
 * @package BestBaliTravel
 */

if (!defined('ABSPATH')) {
    exit;
}

class BBT_Currency_Manager
{

    private static $instance = null;

    private $currencies = array();
    private $rates = array();
    private $default_currency = 'IDR';
    private $current_currency = null;

    /**
     * Currency definitions
     */
    private $all_currencies = array(
        'IDR' => array('name' => 'Indonesian Rupiah', 'symbol' => 'Rp', 'position' => 'before', 'decimals' => 0, 'thousand_sep' => '.', 'decimal_sep' => ','),
        'USD' => array('name' => 'US Dollar', 'symbol' => '$', 'position' => 'before', 'decimals' => 2, 'thousand_sep' => ',', 'decimal_sep' => '.'),
        'EUR' => array('name' => 'Euro', 'symbol' => '€', 'position' => 'before', 'decimals' => 2, 'thousand_sep' => '.', 'decimal_sep' => ','),
        'GBP' => array('name' => 'British Pound', 'symbol' => '£', 'position' => 'before', 'decimals' => 2, 'thousand_sep' => ',', 'decimal_sep' => '.'),
        'AUD' => array('name' => 'Australian Dollar', 'symbol' => 'A$', 'position' => 'before', 'decimals' => 2, 'thousand_sep' => ',', 'decimal_sep' => '.'),
        'SGD' => array('name' => 'Singapore Dollar', 'symbol' => 'S$', 'position' => 'before', 'decimals' => 2, 'thousand_sep' => ',', 'decimal_sep' => '.'),
        'JPY' => array('name' => 'Japanese Yen', 'symbol' => '¥', 'position' => 'before', 'decimals' => 0, 'thousand_sep' => ',', 'decimal_sep' => '.'),
        'CNY' => array('name' => 'Chinese Yuan', 'symbol' => '¥', 'position' => 'before', 'decimals' => 2, 'thousand_sep' => ',', 'decimal_sep' => '.'),
        'MYR' => array('name' => 'Malaysian Ringgit', 'symbol' => 'RM', 'position' => 'before', 'decimals' => 2, 'thousand_sep' => ',', 'decimal_sep' => '.'),
        'THB' => array('name' => 'Thai Baht', 'symbol' => '฿', 'position' => 'before', 'decimals' => 2, 'thousand_sep' => ',', 'decimal_sep' => '.'),
        'KRW' => array('name' => 'South Korean Won', 'symbol' => '₩', 'position' => 'before', 'decimals' => 0, 'thousand_sep' => ',', 'decimal_sep' => '.'),
        'INR' => array('name' => 'Indian Rupee', 'symbol' => '₹', 'position' => 'before', 'decimals' => 2, 'thousand_sep' => ',', 'decimal_sep' => '.'),
    );

    public static function get_instance()
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct()
    {
        $settings = get_option('bbt_settings', array());

        $this->default_currency = $settings['default_currency'] ?? 'IDR';
        $this->currencies = $settings['enabled_currencies'] ?? array('IDR', 'USD');

        // Get current currency from cookie or session
        $this->current_currency = $this->get_current_currency();

        // Load exchange rates
        $this->load_exchange_rates();

        // Hooks
        add_action('wp_ajax_bbt_switch_currency', array($this, 'ajax_switch_currency'));
        add_action('wp_ajax_nopriv_bbt_switch_currency', array($this, 'ajax_switch_currency'));
        add_action('wp_footer', array($this, 'render_currency_switcher'));
    }

    /**
     * Get current user currency
     */
    public function get_current_currency()
    {
        if ($this->current_currency) {
            return $this->current_currency;
        }

        // Check cookie
        if (isset($_COOKIE['bbt_currency'])) {
            $currency = sanitize_text_field($_COOKIE['bbt_currency']);
            if (in_array($currency, $this->currencies)) {
                return $currency;
            }
        }

        // Auto-detect from browser
        $settings = get_option('bbt_settings', array());
        if (!empty($settings['currency_auto_detect'])) {
            $detected = $this->detect_currency_from_location();
            if ($detected) {
                return $detected;
            }
        }

        return $this->default_currency;
    }

    /**
     * Detect currency from location/language
     */
    private function detect_currency_from_location()
    {
        $accept_language = isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) ? $_SERVER['HTTP_ACCEPT_LANGUAGE'] : '';

        $country_currency = array(
            'id' => 'IDR',
            'us' => 'USD',
            'gb' => 'GBP',
            'au' => 'AUD',
            'sg' => 'SGD',
            'jp' => 'JPY',
            'cn' => 'CNY',
            'my' => 'MYR',
            'th' => 'THB',
            'kr' => 'KRW',
            'in' => 'INR',
            'de' => 'EUR',
            'fr' => 'EUR',
            'it' => 'EUR',
            'es' => 'EUR',
        );

        foreach ($country_currency as $country => $currency) {
            if (stripos($accept_language, $country) !== false && in_array($currency, $this->currencies)) {
                return $currency;
            }
        }

        return null;
    }

    /**
     * Load exchange rates
     */
    private function load_exchange_rates()
    {
        // Try to get cached rates
        $cached_rates = get_transient('bbt_exchange_rates');

        if ($cached_rates) {
            $this->rates = $cached_rates;
            return;
        }

        // Default rates (fallback)
        $this->rates = array(
            'IDR' => 1,
            'USD' => 0.000063,
            'EUR' => 0.000058,
            'GBP' => 0.000050,
            'AUD' => 0.000097,
            'SGD' => 0.000085,
            'JPY' => 0.0094,
            'CNY' => 0.00046,
            'MYR' => 0.00030,
            'THB' => 0.0023,
            'KRW' => 0.084,
            'INR' => 0.0053,
        );

        // Try to fetch from API
        $settings = get_option('bbt_settings', array());
        if (!empty($settings['exchange_rate_api']) && $settings['exchange_rate_source'] === 'api') {
            $this->fetch_exchange_rates($settings['exchange_rate_api']);
        }
    }

    /**
     * Fetch exchange rates from API
     */
    private function fetch_exchange_rates($api_key)
    {
        $base = $this->default_currency;
        $url = "https://openexchangerates.org/api/latest.json?app_id={$api_key}&base=USD";

        $response = wp_remote_get($url, array('timeout' => 10));

        if (is_wp_error($response)) {
            return;
        }

        $body = wp_remote_retrieve_body($response);
        $data = json_decode($body, true);

        if (!empty($data['rates'])) {
            // Convert to rates relative to default currency
            $usd_to_default = $data['rates'][$this->default_currency] ?? 1;

            foreach ($this->currencies as $currency) {
                if (isset($data['rates'][$currency])) {
                    $this->rates[$currency] = $data['rates'][$currency] / $usd_to_default;
                }
            }

            // Cache for 6 hours
            set_transient('bbt_exchange_rates', $this->rates, 6 * HOUR_IN_SECONDS);
        }
    }

    /**
     * Convert price to current currency
     */
    public function convert($amount, $from = null, $to = null)
    {
        if (null === $from) {
            $from = $this->default_currency;
        }
        if (null === $to) {
            $to = $this->current_currency;
        }

        if ($from === $to) {
            return $amount;
        }

        // Convert through base currency (IDR)
        $from_rate = $this->rates[$from] ?? 1;
        $to_rate = $this->rates[$to] ?? 1;

        return $amount * ($to_rate / $from_rate);
    }

    /**
     * Format price in current currency
     */
    public function format($amount, $currency = null)
    {
        if (null === $currency) {
            $currency = $this->current_currency;
        }

        $config = $this->all_currencies[$currency] ?? $this->all_currencies['IDR'];

        $formatted = number_format(
            $amount,
            $config['decimals'],
            $config['decimal_sep'],
            $config['thousand_sep']
        );

        if ($config['position'] === 'before') {
            return $config['symbol'] . ' ' . $formatted;
        } else {
            return $formatted . ' ' . $config['symbol'];
        }
    }

    /**
     * AJAX: Switch currency
     */
    public function ajax_switch_currency()
    {
        check_ajax_referer('bbt_nonce', 'nonce');

        $currency = sanitize_text_field($_POST['currency'] ?? '');

        if (!in_array($currency, $this->currencies)) {
            wp_send_json_error(array('message' => 'Invalid currency'));
        }

        // Set cookie for 30 days
        setcookie('bbt_currency', $currency, time() + (30 * DAY_IN_SECONDS), '/');

        $this->current_currency = $currency;

        wp_send_json_success(array(
            'currency' => $currency,
            'symbol' => $this->all_currencies[$currency]['symbol'],
        ));
    }

    /**
     * Render currency switcher in footer
     */
    public function render_currency_switcher()
    {
        if (count($this->currencies) < 2) {
            return;
        }
        ?>
        <div class="bbt-currency-switcher">
            <button class="bbt-currency-toggle" aria-expanded="false">
                <span class="bbt-currency-flag">
                    <?php echo esc_html($this->get_flag($this->current_currency)); ?>
                </span>
                <span class="bbt-currency-code">
                    <?php echo esc_html($this->current_currency); ?>
                </span>
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="6 9 12 15 18 9" />
                </svg>
            </button>
            <div class="bbt-currency-dropdown">
                <?php foreach ($this->currencies as $code):
                    $currency = $this->all_currencies[$code];
                    $is_active = $code === $this->current_currency;
                    ?>
                    <button class="bbt-currency-option <?php echo $is_active ? 'active' : ''; ?>"
                        data-currency="<?php echo esc_attr($code); ?>">
                        <span class="bbt-option-flag">
                            <?php echo esc_html($this->get_flag($code)); ?>
                        </span>
                        <span class="bbt-option-code">
                            <?php echo esc_html($code); ?>
                        </span>
                        <span class="bbt-option-name">
                            <?php echo esc_html($currency['name']); ?>
                        </span>
                        <?php if ($is_active): ?>
                            <svg class="bbt-check" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="3">
                                <polyline points="20 6 9 17 4 12" />
                            </svg>
                        <?php endif; ?>
                    </button>
                <?php endforeach; ?>
            </div>
        </div>
        <?php
    }

    /**
     * Get flag emoji for currency
     */
    private function get_flag($code)
    {
        $flags = array(
            'IDR' => '🇮🇩',
            'USD' => '🇺🇸',
            'EUR' => '🇪🇺',
            'GBP' => '🇬🇧',
            'AUD' => '🇦🇺',
            'SGD' => '🇸🇬',
            'JPY' => '🇯🇵',
            'CNY' => '🇨🇳',
            'MYR' => '🇲🇾',
            'THB' => '🇹🇭',
            'KRW' => '🇰🇷',
            'INR' => '🇮🇳',
        );

        return $flags[$code] ?? '💰';
    }

    /**
     * Get all enabled currencies
     */
    public function get_currencies()
    {
        return $this->currencies;
    }

    /**
     * Get currency info
     */
    public function get_currency_info($code)
    {
        return $this->all_currencies[$code] ?? null;
    }
}

// Initialize
BBT_Currency_Manager::get_instance();

/**
 * Helper function - Format price with current currency
 */
if (!function_exists('bbt_format_price')) {
    function bbt_format_price($amount, $currency = null)
    {
        return BBT_Currency_Manager::get_instance()->format($amount, $currency);
    }
}

/**
 * Helper function - Convert price to current currency
 */
if (!function_exists('bbt_convert_price')) {
    function bbt_convert_price($amount, $from = null, $to = null)
    {
        return BBT_Currency_Manager::get_instance()->convert($amount, $from, $to);
    }
}

