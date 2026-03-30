<?php
/**
 * Payment Gateway Settings Tab
 *
 * @package BestBaliTravel
 */

if (!defined('ABSPATH')) {
    exit;
}

$settings = get_option('bbt_settings', array());
?>

<div class="bbt-settings-section">
    <h2><?php esc_html_e('Payment Gateways', 'bestbalitravel'); ?></h2>
    <p class="description"><?php esc_html_e('Configure payment gateway integrations for accepting payments.', 'bestbalitravel'); ?></p>
</div>

<!-- Midtrans -->
<div class="bbt-payment-gateway">
    <div class="bbt-gateway-header">
        <div class="bbt-gateway-logo">
            <img src="<?php echo esc_url(BBT_THEME_ASSETS . '/images/midtrans-logo.png'); ?>" alt="Midtrans" onerror="this.style.display='none'">
            <span class="bbt-gateway-name">Midtrans</span>
        </div>
        <div class="bbt-gateway-toggle">
            <label class="bbt-switch">
                <input type="checkbox" 
                       name="bbt_settings[midtrans_enabled]" 
                       value="1" 
                       <?php checked($settings['midtrans_enabled'] ?? 0, 1); ?>>
                <span class="bbt-slider"></span>
            </label>
        </div>
    </div>
    
    <div class="bbt-gateway-content" style="<?php echo empty($settings['midtrans_enabled']) ? 'display:none;' : ''; ?>">
        <div class="bbt-gateway-description">
            <p><?php esc_html_e('Accept payments via GoPay, OVO, DANA, Credit Card, Bank Transfer, and more.', 'bestbalitravel'); ?></p>
            <span class="bbt-badge bbt-badge-indonesia">🇮🇩 Indonesia</span>
        </div>
        
        <table class="form-table">
            <tr>
                <th scope="row"><?php esc_html_e('Environment', 'bestbalitravel'); ?></th>
                <td>
                    <label class="bbt-radio-card">
                        <input type="radio" 
                               name="bbt_settings[midtrans_sandbox]" 
                               value="1" 
                               <?php checked($settings['midtrans_sandbox'] ?? 1, 1); ?>>
                        <span class="bbt-radio-content">
                            <strong><?php esc_html_e('Sandbox', 'bestbalitravel'); ?></strong>
                            <small><?php esc_html_e('For testing', 'bestbalitravel'); ?></small>
                        </span>
                    </label>
                    <label class="bbt-radio-card">
                        <input type="radio" 
                               name="bbt_settings[midtrans_sandbox]" 
                               value="0" 
                               <?php checked($settings['midtrans_sandbox'] ?? 1, 0); ?>>
                        <span class="bbt-radio-content">
                            <strong><?php esc_html_e('Production', 'bestbalitravel'); ?></strong>
                            <small><?php esc_html_e('Live payments', 'bestbalitravel'); ?></small>
                        </span>
                    </label>
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="bbt_midtrans_server_key"><?php esc_html_e('Server Key', 'bestbalitravel'); ?></label>
                </th>
                <td>
                    <input type="password" 
                           id="bbt_midtrans_server_key" 
                           name="bbt_settings[midtrans_server_key]" 
                           value="<?php echo esc_attr($settings['midtrans_server_key'] ?? ''); ?>" 
                           class="regular-text"
                           placeholder="SB-Mid-server-xxxxx">
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="bbt_midtrans_client_key"><?php esc_html_e('Client Key', 'bestbalitravel'); ?></label>
                </th>
                <td>
                    <input type="text" 
                           id="bbt_midtrans_client_key" 
                           name="bbt_settings[midtrans_client_key]" 
                           value="<?php echo esc_attr($settings['midtrans_client_key'] ?? ''); ?>" 
                           class="regular-text"
                           placeholder="SB-Mid-client-xxxxx">
                    <p class="description">
                        <?php 
                        printf(
                            esc_html__('Get your keys from %s', 'bestbalitravel'),
                            '<a href="https://dashboard.midtrans.com" target="_blank">Midtrans Dashboard</a>'
                        ); 
                        ?>
                    </p>
                </td>
            </tr>
        </table>
        
        <div class="bbt-payment-methods">
            <h4><?php esc_html_e('Supported Payment Methods:', 'bestbalitravel'); ?></h4>
            <div class="bbt-method-icons">
                <span class="bbt-method">💳 Credit Card</span>
                <span class="bbt-method">🏦 BCA</span>
                <span class="bbt-method">🏦 BNI</span>
                <span class="bbt-method">🏦 BRI</span>
                <span class="bbt-method">🏦 Mandiri</span>
                <span class="bbt-method">📱 GoPay</span>
                <span class="bbt-method">📱 OVO</span>
                <span class="bbt-method">📱 DANA</span>
                <span class="bbt-method">📱 ShopeePay</span>
                <span class="bbt-method">🏪 Indomaret</span>
                <span class="bbt-method">🏪 Alfamart</span>
            </div>
        </div>
    </div>
</div>

<!-- Stripe -->
<div class="bbt-payment-gateway">
    <div class="bbt-gateway-header">
        <div class="bbt-gateway-logo">
            <img src="<?php echo esc_url(BBT_THEME_ASSETS . '/images/stripe-logo.png'); ?>" alt="Stripe" onerror="this.style.display='none'">
            <span class="bbt-gateway-name">Stripe</span>
        </div>
        <div class="bbt-gateway-toggle">
            <label class="bbt-switch">
                <input type="checkbox" 
                       name="bbt_settings[stripe_enabled]" 
                       value="1" 
                       <?php checked($settings['stripe_enabled'] ?? 0, 1); ?>>
                <span class="bbt-slider"></span>
            </label>
        </div>
    </div>
    
    <div class="bbt-gateway-content" style="<?php echo empty($settings['stripe_enabled']) ? 'display:none;' : ''; ?>">
        <div class="bbt-gateway-description">
            <p><?php esc_html_e('Accept international credit card payments with Stripe.', 'bestbalitravel'); ?></p>
            <span class="bbt-badge bbt-badge-global">🌍 International</span>
        </div>
        
        <table class="form-table">
            <tr>
                <th scope="row"><?php esc_html_e('Environment', 'bestbalitravel'); ?></th>
                <td>
                    <label class="bbt-radio-card">
                        <input type="radio" 
                               name="bbt_settings[stripe_test_mode]" 
                               value="1" 
                               <?php checked($settings['stripe_test_mode'] ?? 1, 1); ?>>
                        <span class="bbt-radio-content">
                            <strong><?php esc_html_e('Test Mode', 'bestbalitravel'); ?></strong>
                            <small><?php esc_html_e('For testing', 'bestbalitravel'); ?></small>
                        </span>
                    </label>
                    <label class="bbt-radio-card">
                        <input type="radio" 
                               name="bbt_settings[stripe_test_mode]" 
                               value="0" 
                               <?php checked($settings['stripe_test_mode'] ?? 1, 0); ?>>
                        <span class="bbt-radio-content">
                            <strong><?php esc_html_e('Live Mode', 'bestbalitravel'); ?></strong>
                            <small><?php esc_html_e('Real payments', 'bestbalitravel'); ?></small>
                        </span>
                    </label>
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="bbt_stripe_publishable_key"><?php esc_html_e('Publishable Key', 'bestbalitravel'); ?></label>
                </th>
                <td>
                    <input type="text" 
                           id="bbt_stripe_publishable_key" 
                           name="bbt_settings[stripe_publishable_key]" 
                           value="<?php echo esc_attr($settings['stripe_publishable_key'] ?? ''); ?>" 
                           class="regular-text"
                           placeholder="pk_test_xxxxx">
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="bbt_stripe_secret_key"><?php esc_html_e('Secret Key', 'bestbalitravel'); ?></label>
                </th>
                <td>
                    <input type="password" 
                           id="bbt_stripe_secret_key" 
                           name="bbt_settings[stripe_secret_key]" 
                           value="<?php echo esc_attr($settings['stripe_secret_key'] ?? ''); ?>" 
                           class="regular-text"
                           placeholder="sk_test_xxxxx">
                    <p class="description">
                        <?php 
                        printf(
                            esc_html__('Get your keys from %s', 'bestbalitravel'),
                            '<a href="https://dashboard.stripe.com/apikeys" target="_blank">Stripe Dashboard</a>'
                        ); 
                        ?>
                    </p>
                </td>
            </tr>
        </table>
        
        <div class="bbt-payment-methods">
            <h4><?php esc_html_e('Supported Payment Methods:', 'bestbalitravel'); ?></h4>
            <div class="bbt-method-icons">
                <span class="bbt-method">💳 Visa</span>
                <span class="bbt-method">💳 Mastercard</span>
                <span class="bbt-method">💳 Amex</span>
                <span class="bbt-method">📱 Apple Pay</span>
                <span class="bbt-method">📱 Google Pay</span>
            </div>
        </div>
    </div>
</div>

<!-- Wise -->
<div class="bbt-payment-gateway">
    <div class="bbt-gateway-header">
        <div class="bbt-gateway-logo">
            <img src="<?php echo esc_url(BBT_THEME_ASSETS . '/images/wise-logo.png'); ?>" alt="Wise" onerror="this.style.display='none'">
            <span class="bbt-gateway-name">Wise (TransferWise)</span>
        </div>
        <div class="bbt-gateway-toggle">
            <label class="bbt-switch">
                <input type="checkbox" 
                       name="bbt_settings[wise_enabled]" 
                       value="1" 
                       <?php checked($settings['wise_enabled'] ?? 0, 1); ?>>
                <span class="bbt-slider"></span>
            </label>
        </div>
    </div>
    
    <div class="bbt-gateway-content" style="<?php echo empty($settings['wise_enabled']) ? 'display:none;' : ''; ?>">
        <div class="bbt-gateway-description">
            <p><?php esc_html_e('Accept international bank transfers with low fees.', 'bestbalitravel'); ?></p>
            <span class="bbt-badge bbt-badge-global">🌍 International</span>
        </div>
        
        <table class="form-table">
            <tr>
                <th scope="row">
                    <label for="bbt_wise_email"><?php esc_html_e('Wise Email', 'bestbalitravel'); ?></label>
                </th>
                <td>
                    <input type="email" 
                           id="bbt_wise_email" 
                           name="bbt_settings[wise_email]" 
                           value="<?php echo esc_attr($settings['wise_email'] ?? ''); ?>" 
                           class="regular-text"
                           placeholder="your@email.com">
                    <p class="description"><?php esc_html_e('Your Wise account email for receiving payments.', 'bestbalitravel'); ?></p>
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="bbt_wise_api_key"><?php esc_html_e('API Key (Optional)', 'bestbalitravel'); ?></label>
                </th>
                <td>
                    <input type="password" 
                           id="bbt_wise_api_key" 
                           name="bbt_settings[wise_api_key]" 
                           value="<?php echo esc_attr($settings['wise_api_key'] ?? ''); ?>" 
                           class="regular-text">
                    <p class="description"><?php esc_html_e('For automatic quote generation. Leave empty for manual bank details display.', 'bestbalitravel'); ?></p>
                </td>
            </tr>
        </table>
    </div>
</div>

<style>
.bbt-payment-gateway {
    background: #fff;
    border: 1px solid #e0e0e0;
    border-radius: 10px;
    margin-bottom: 20px;
    overflow: hidden;
}

.bbt-gateway-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px;
    background: #f9f9f9;
    border-bottom: 1px solid #e0e0e0;
}

.bbt-gateway-logo {
    display: flex;
    align-items: center;
    gap: 12px;
}

.bbt-gateway-logo img {
    height: 30px;
    width: auto;
}

.bbt-gateway-name {
    font-size: 18px;
    font-weight: 600;
    color: #1e3a5f;
}

.bbt-gateway-content {
    padding: 20px;
}

.bbt-gateway-description {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
}

.bbt-badge {
    padding: 4px 10px;
    border-radius: 12px;
    font-size: 12px;
    font-weight: 500;
}

.bbt-badge-indonesia {
    background: #fee2e2;
    color: #dc2626;
}

.bbt-badge-global {
    background: #dbeafe;
    color: #2563eb;
}

/* Toggle Switch */
.bbt-switch {
    position: relative;
    display: inline-block;
    width: 50px;
    height: 26px;
}

.bbt-switch input {
    opacity: 0;
    width: 0;
    height: 0;
}

.bbt-slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    transition: .3s;
    border-radius: 26px;
}

.bbt-slider:before {
    position: absolute;
    content: "";
    height: 20px;
    width: 20px;
    left: 3px;
    bottom: 3px;
    background-color: white;
    transition: .3s;
    border-radius: 50%;
}

.bbt-switch input:checked + .bbt-slider {
    background-color: #10b981;
}

.bbt-switch input:checked + .bbt-slider:before {
    transform: translateX(24px);
}

/* Radio Cards */
.bbt-radio-card {
    display: inline-flex;
    align-items: center;
    padding: 10px 15px;
    margin-right: 10px;
    background: #f9f9f9;
    border: 2px solid #e0e0e0;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.2s;
}

.bbt-radio-card:has(input:checked) {
    border-color: #10b981;
    background: #f0fdf4;
}

.bbt-radio-card input {
    margin-right: 8px;
}

.bbt-radio-content {
    display: flex;
    flex-direction: column;
}

.bbt-radio-content small {
    color: #666;
    font-size: 11px;
}

/* Payment Methods */
.bbt-payment-methods {
    margin-top: 20px;
    padding-top: 15px;
    border-top: 1px dashed #e0e0e0;
}

.bbt-payment-methods h4 {
    margin: 0 0 10px;
    font-size: 13px;
    color: #666;
}

.bbt-method-icons {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}

.bbt-method {
    padding: 5px 10px;
    background: #f5f5f5;
    border-radius: 5px;
    font-size: 12px;
}
</style>

<script>
jQuery(document).ready(function($) {
    // Toggle gateway content
    $('.bbt-switch input').on('change', function() {
        $(this).closest('.bbt-payment-gateway').find('.bbt-gateway-content').slideToggle(200);
    });
});
</script>
