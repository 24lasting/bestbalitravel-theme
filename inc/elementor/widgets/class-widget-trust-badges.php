<?php
/**
 * Elementor Trust Badges Widget
 *
 * @package BestBaliTravel
 */

if (!defined('ABSPATH'))
    exit;

class BBT_Widget_Trust_Badges extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'bbt-trust-badges';
    }
    public function get_title()
    {
        return esc_html__('Trust Badges', 'bestbalitravel');
    }
    public function get_icon()
    {
        return 'eicon-lock-user';
    }
    public function get_categories()
    {
        return ['bbt-widgets'];
    }

    protected function register_controls()
    {
        $this->start_controls_section('section_badges', ['label' => 'Badges']);

        $this->add_control('show_payment', ['label' => 'Show Payment Icons', 'type' => \Elementor\Controls_Manager::SWITCHER, 'default' => 'yes']);
        $this->add_control('show_security', ['label' => 'Show Security Badges', 'type' => \Elementor\Controls_Manager::SWITCHER, 'default' => 'yes']);
        $this->add_control('show_guarantee', ['label' => 'Show Guarantee', 'type' => \Elementor\Controls_Manager::SWITCHER, 'default' => 'yes']);
        $this->add_control('layout', ['label' => 'Layout', 'type' => \Elementor\Controls_Manager::SELECT, 'options' => ['horizontal' => 'Horizontal', 'grid' => 'Grid'], 'default' => 'horizontal']);

        $this->end_controls_section();
    }

    protected function render()
    {
        $s = $this->get_settings_for_display();
        ?>
        <div class="bbt-trust-badges layout-<?php echo esc_attr($s['layout']); ?>">
            <?php if ($s['show_payment'] === 'yes'): ?>
                <div class="bbt-badge-group payment">
                    <span class="bbt-badge-title">Secure Payment</span>
                    <div class="bbt-badges">
                        <span class="bbt-badge">💳 Visa</span>
                        <span class="bbt-badge">💳 Mastercard</span>
                        <span class="bbt-badge">📱 GoPay</span>
                        <span class="bbt-badge">📱 Dana</span>
                    </div>
                </div>
            <?php endif; ?>

            <?php if ($s['show_security'] === 'yes'): ?>
                <div class="bbt-badge-group security">
                    <span class="bbt-badge-title">Your Safety</span>
                    <div class="bbt-badges">
                        <span class="bbt-badge">🔒 SSL Secured</span>
                        <span class="bbt-badge">✅ Verified</span>
                        <span class="bbt-badge">🛡️ Protected</span>
                    </div>
                </div>
            <?php endif; ?>

            <?php if ($s['show_guarantee'] === 'yes'): ?>
                <div class="bbt-badge-group guarantee">
                    <span class="bbt-badge-title">Our Promise</span>
                    <div class="bbt-badges">
                        <span class="bbt-badge highlight">💯 Best Price Guarantee</span>
                        <span class="bbt-badge highlight">↩️ Free Cancellation</span>
                        <span class="bbt-badge highlight">⚡ Instant Confirmation</span>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <style>
            .bbt-trust-badges {
                display: flex;
                gap: 30px;
                padding: 25px;
                background: #f9fafb;
                border-radius: 16px
            }

            .layout-grid {
                flex-wrap: wrap
            }

            .layout-grid .bbt-badge-group {
                flex: 1 1 45%
            }

            .bbt-badge-group {
                display: flex;
                flex-direction: column;
                gap: 10px
            }

            .bbt-badge-title {
                font-size: 12px;
                font-weight: 700;
                color: #666;
                text-transform: uppercase
            }

            .bbt-badges {
                display: flex;
                flex-wrap: wrap;
                gap: 8px
            }

            .bbt-badge {
                display: inline-flex;
                align-items: center;
                gap: 6px;
                padding: 8px 14px;
                background: #fff;
                border-radius: 8px;
                font-size: 12px;
                font-weight: 600;
                color: #4a4a4a;
                box-shadow: 0 2px 8px rgba(0, 0, 0, .05);
                transition: all .3s ease
            }

            .bbt-badge:hover {
                transform: translateY(-2px);
                box-shadow: 0 4px 12px rgba(0, 0, 0, .1)
            }

            .bbt-badge.highlight {
                background: linear-gradient(135deg, #F5A623, #FFD93D);
                color: #000
            }

            @media(max-width:768px) {
                .bbt-trust-badges {
                    flex-direction: column
                }
            }
        </style>
        <?php
    }
}
