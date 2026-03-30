<?php
/**
 * Elementor Currency Converter Widget
 * Live currency conversion for travelers
 *
 * @package BestBaliTravel
 */

if (!defined('ABSPATH')) {
    exit;
}

class BBT_Widget_Currency_Converter extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'bbt-currency-converter';
    }
    public function get_title()
    {
        return esc_html__('Currency Converter', 'bestbalitravel');
    }
    public function get_icon()
    {
        return 'eicon-exchange';
    }
    public function get_categories()
    {
        return ['bbt-widgets'];
    }

    protected function register_controls()
    {
        $this->start_controls_section('section_content', [
            'label' => esc_html__('Settings', 'bestbalitravel'),
        ]);

        $this->add_control('default_amount', [
            'label' => esc_html__('Default Amount', 'bestbalitravel'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'default' => 100,
        ]);

        $this->add_control('theme', [
            'label' => esc_html__('Theme', 'bestbalitravel'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'options' => ['light' => 'Light', 'dark' => 'Dark', 'gradient' => 'Gradient'],
            'default' => 'gradient',
        ]);

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $id = 'bbt-converter-' . uniqid();
        ?>
        <div class="bbt-currency-converter theme-<?php echo esc_attr($settings['theme']); ?>" id="<?php echo $id; ?>">
            <div class="bbt-converter-header">
                <span class="bbt-converter-icon">💱</span>
                <h3>
                    <?php esc_html_e('Currency Converter', 'bestbalitravel'); ?>
                </h3>
            </div>

            <div class="bbt-converter-body">
                <div class="bbt-converter-input-group">
                    <select class="bbt-currency-from">
                        <option value="USD">🇺🇸 USD</option>
                        <option value="EUR">🇪🇺 EUR</option>
                        <option value="GBP">🇬🇧 GBP</option>
                        <option value="AUD">🇦🇺 AUD</option>
                        <option value="SGD">🇸🇬 SGD</option>
                        <option value="MYR">🇲🇾 MYR</option>
                    </select>
                    <input type="number" class="bbt-amount-from" value="<?php echo esc_attr($settings['default_amount']); ?>"
                        min="0">
                </div>

                <div class="bbt-converter-arrow">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M7 16l5 5 5-5M7 8l5-5 5 5" />
                    </svg>
                </div>

                <div class="bbt-converter-input-group">
                    <div class="bbt-currency-to">🇮🇩 IDR</div>
                    <div class="bbt-amount-to">Rp 1,575,000</div>
                </div>
            </div>

            <div class="bbt-converter-rate">
                <span>1 USD = Rp 15,750</span>
                <small>Updated: Today</small>
            </div>

            <div class="bbt-quick-amounts">
                <button data-amount="50">$50</button>
                <button data-amount="100">$100</button>
                <button data-amount="500">$500</button>
                <button data-amount="1000">$1000</button>
            </div>
        </div>

        <style>
            .bbt-currency-converter {
                padding: 30px;
                border-radius: 24px;
                box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
            }

            .theme-gradient {
                background: linear-gradient(135deg, #1A1A2E 0%, #2D2D4D 100%);
                color: #fff;
            }

            .theme-light {
                background: #fff;
                color: #1a1a1a;
            }

            .theme-dark {
                background: #1a1a1a;
                color: #fff;
            }

            .bbt-converter-header {
                display: flex;
                align-items: center;
                gap: 12px;
                margin-bottom: 25px;
            }

            .bbt-converter-icon {
                font-size: 32px;
                animation: bbtConverterBounce 2s ease infinite;
            }

            @keyframes bbtConverterBounce {

                0%,
                100% {
                    transform: translateY(0) rotate(0);
                }

                50% {
                    transform: translateY(-5px) rotate(10deg);
                }
            }

            .bbt-converter-header h3 {
                margin: 0;
                font-size: 20px;
                font-weight: 700;
            }

            .bbt-converter-body {
                display: flex;
                flex-direction: column;
                gap: 15px;
            }

            .bbt-converter-input-group {
                display: flex;
                gap: 10px;
                align-items: center;
            }

            .bbt-converter-input-group select,
            .bbt-converter-input-group input {
                padding: 15px;
                border-radius: 12px;
                border: 2px solid rgba(255, 255, 255, 0.1);
                background: rgba(255, 255, 255, 0.1);
                color: inherit;
                font-size: 16px;
                flex: 1;
            }

            .theme-light .bbt-converter-input-group select,
            .theme-light .bbt-converter-input-group input {
                border-color: #eee;
                background: #f9f9f9;
            }

            .bbt-currency-to {
                padding: 15px;
                background: rgba(255, 255, 255, 0.1);
                border-radius: 12px;
                font-weight: 600;
            }

            .bbt-amount-to {
                padding: 15px;
                background: linear-gradient(135deg, #F5A623, #FFD93D);
                color: #000;
                border-radius: 12px;
                font-size: 20px;
                font-weight: 700;
                flex: 1;
                text-align: center;
            }

            .bbt-converter-arrow {
                text-align: center;
                color: #F5A623;
                animation: bbtArrowPulse 1.5s ease infinite;
            }

            @keyframes bbtArrowPulse {

                0%,
                100% {
                    opacity: 1;
                }

                50% {
                    opacity: 0.5;
                }
            }

            .bbt-converter-rate {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-top: 20px;
                padding-top: 20px;
                border-top: 1px solid rgba(255, 255, 255, 0.1);
                font-size: 14px;
                opacity: 0.8;
            }

            .bbt-quick-amounts {
                display: flex;
                gap: 10px;
                margin-top: 20px;
            }

            .bbt-quick-amounts button {
                flex: 1;
                padding: 10px;
                border: 2px solid #F5A623;
                background: transparent;
                color: #F5A623;
                border-radius: 8px;
                font-weight: 600;
                cursor: pointer;
                transition: all 0.3s ease;
            }

            .bbt-quick-amounts button:hover {
                background: #F5A623;
                color: #000;
                transform: translateY(-2px);
            }
        </style>
        <?php
    }
}
