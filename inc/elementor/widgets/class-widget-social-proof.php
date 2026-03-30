<?php
/**
 * Elementor Social Proof Bar Widget
 * "X people booked today" counter
 *
 * @package BestBaliTravel
 */

if (!defined('ABSPATH')) {
    exit;
}

class BBT_Widget_Social_Proof extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'bbt-social-proof';
    }
    public function get_title()
    {
        return esc_html__('Social Proof Bar', 'bestbalitravel');
    }
    public function get_icon()
    {
        return 'eicon-user-circle-o';
    }
    public function get_categories()
    {
        return ['bbt-widgets'];
    }

    protected function register_controls()
    {
        $this->start_controls_section('section_content', [
            'label' => esc_html__('Content', 'bestbalitravel'),
        ]);

        $this->add_control('bookings_today', ['label' => 'Bookings Today', 'type' => \Elementor\Controls_Manager::NUMBER, 'default' => 127]);
        $this->add_control('viewing_now', ['label' => 'Viewing Now', 'type' => \Elementor\Controls_Manager::NUMBER, 'default' => 23]);
        $this->add_control('total_reviews', ['label' => 'Total Reviews', 'type' => \Elementor\Controls_Manager::NUMBER, 'default' => 4850]);
        $this->add_control('average_rating', ['label' => 'Average Rating', 'type' => \Elementor\Controls_Manager::NUMBER, 'default' => 4.9, 'step' => 0.1]);
        $this->add_control('style', [
            'label' => 'Style',
            'type' => \Elementor\Controls_Manager::SELECT,
            'options' => ['bar' => 'Horizontal Bar', 'floating' => 'Floating Badges', 'minimal' => 'Minimal'],
            'default' => 'bar'
        ]);

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $style = $settings['style'];
        ?>
        <div class="bbt-social-proof style-<?php echo esc_attr($style); ?>">
            <div class="bbt-proof-item bookings">
                <span class="bbt-proof-icon">🔥</span>
                <div class="bbt-proof-content">
                    <span class="bbt-proof-number" data-count="<?php echo esc_attr($settings['bookings_today']); ?>">0</span>
                    <span class="bbt-proof-label">Bookings Today</span>
                </div>
            </div>

            <div class="bbt-proof-item viewing">
                <span class="bbt-proof-icon pulse">👀</span>
                <div class="bbt-proof-content">
                    <span class="bbt-proof-number" data-count="<?php echo esc_attr($settings['viewing_now']); ?>">0</span>
                    <span class="bbt-proof-label">Viewing Now</span>
                </div>
            </div>

            <div class="bbt-proof-item reviews">
                <span class="bbt-proof-icon">⭐</span>
                <div class="bbt-proof-content">
                    <span class="bbt-proof-number">
                        <?php echo esc_html($settings['average_rating']); ?>
                    </span>
                    <span class="bbt-proof-label">
                        <?php echo number_format($settings['total_reviews']); ?> Reviews
                    </span>
                </div>
            </div>

            <div class="bbt-proof-item trusted">
                <span class="bbt-proof-icon">✅</span>
                <div class="bbt-proof-content">
                    <span class="bbt-proof-text">Trusted by 50,000+ travelers</span>
                </div>
            </div>
        </div>

        <style>
            .bbt-social-proof {
                display: flex;
                gap: 20px;
            }

            .style-bar {
                background: linear-gradient(135deg, #1A1A2E, #2D2D4D);
                padding: 20px 30px;
                border-radius: 16px;
                justify-content: space-around;
                color: #fff;
            }

            .style-floating {
                position: fixed;
                bottom: 100px;
                right: 30px;
                flex-direction: column;
                z-index: 100;
            }

            .style-floating .bbt-proof-item {
                background: #fff;
                padding: 12px 20px;
                border-radius: 50px;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
                animation: bbtProofSlide 0.5s ease;
            }

            @keyframes bbtProofSlide {
                from {
                    opacity: 0;
                    transform: translateX(30px);
                }

                to {
                    opacity: 1;
                    transform: translateX(0);
                }
            }

            .style-minimal {
                gap: 40px;
                justify-content: center;
            }

            .bbt-proof-item {
                display: flex;
                align-items: center;
                gap: 12px;
            }

            .bbt-proof-icon {
                font-size: 28px;
            }

            .bbt-proof-icon.pulse {
                animation: bbtIconPulse 2s ease infinite;
            }

            @keyframes bbtIconPulse {

                0%,
                100% {
                    transform: scale(1);
                }

                50% {
                    transform: scale(1.2);
                }
            }

            .bbt-proof-content {
                display: flex;
                flex-direction: column;
            }

            .bbt-proof-number {
                font-size: 24px;
                font-weight: 700;
                color: #F5A623;
            }

            .style-bar .bbt-proof-number {
                color: #F5A623;
            }

            .bbt-proof-label {
                font-size: 12px;
                opacity: 0.8;
            }

            .bbt-proof-text {
                font-size: 14px;
                font-weight: 600;
            }

            @media (max-width: 768px) {
                .style-bar {
                    flex-wrap: wrap;
                    gap: 20px;
                    padding: 20px;
                }

                .bbt-proof-item {
                    flex: 1 1 45%;
                }
            }
        </style>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                document.querySelectorAll('.bbt-proof-number[data-count]').forEach(function (el) {
                    var target = parseInt(el.dataset.count);
                    var count = 0;
                    var duration = 2000;
                    var increment = target / (duration / 16);
                    function updateCount() {
                        count += increment;
                        if (count < target) {
                            el.textContent = Math.floor(count);
                            requestAnimationFrame(updateCount);
                        } else {
                            el.textContent = target;
                        }
                    }
                    updateCount();
                });
            });
        </script>
        <?php
    }
}
