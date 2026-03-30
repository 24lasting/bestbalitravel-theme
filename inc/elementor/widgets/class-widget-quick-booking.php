<?php
/**
 * Elementor Quick Booking Form Widget
 * Compact inline booking widget
 *
 * @package BestBaliTravel
 */

if (!defined('ABSPATH')) {
    exit;
}

class BBT_Widget_Quick_Booking extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'bbt-quick-booking';
    }
    public function get_title()
    {
        return esc_html__('Quick Booking Form', 'bestbalitravel');
    }
    public function get_icon()
    {
        return 'eicon-form-horizontal';
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

        $this->add_control('style', [
            'label' => 'Style',
            'type' => \Elementor\Controls_Manager::SELECT,
            'options' => ['horizontal' => 'Horizontal', 'vertical' => 'Vertical', 'floating' => 'Floating'],
            'default' => 'horizontal',
        ]);

        $this->add_control('show_tour_select', [
            'label' => 'Show Tour Dropdown',
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'default' => 'yes',
        ]);

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $style = $settings['style'];
        ?>
        <div class="bbt-quick-booking style-<?php echo esc_attr($style); ?>">
            <form class="bbt-booking-form" action="<?php echo esc_url(home_url('/checkout')); ?>" method="GET">
                <?php if ($settings['show_tour_select'] === 'yes'): ?>
                    <div class="bbt-form-field">
                        <label>🗺️ Tour</label>
                        <select name="tour_id" required>
                            <option value="">Select Tour</option>
                            <?php
                            $tours = get_posts(['post_type' => 'tour', 'posts_per_page' => 20, 'post_status' => 'publish']);
                            foreach ($tours as $tour) {
                                echo '<option value="' . $tour->ID . '">' . esc_html($tour->post_title) . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                <?php endif; ?>

                <div class="bbt-form-field">
                    <label>📅 Date</label>
                    <input type="date" name="date" required min="<?php echo date('Y-m-d'); ?>">
                </div>

                <div class="bbt-form-field">
                    <label>👥 Guests</label>
                    <select name="guests">
                        <?php for ($i = 1; $i <= 10; $i++): ?>
                            <option value="<?php echo $i; ?>" <?php echo $i === 2 ? 'selected' : ''; ?>>
                                <?php echo $i; ?> Guest
                                <?php echo $i > 1 ? 's' : ''; ?>
                            </option>
                        <?php endfor; ?>
                    </select>
                </div>

                <div class="bbt-form-submit">
                    <button type="submit" class="bbt-btn bbt-btn-primary">
                        <span>Book Now</span>
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M5 12h14M12 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>
            </form>
        </div>

        <style>
            .bbt-quick-booking {
                background: #fff;
                border-radius: 20px;
                box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
                overflow: hidden;
            }

            .style-horizontal .bbt-booking-form {
                display: flex;
                align-items: stretch;
            }

            .style-horizontal .bbt-form-field {
                flex: 1;
                padding: 20px 25px;
                border-right: 1px solid #eee;
            }

            .style-horizontal .bbt-form-submit {
                padding: 15px;
                display: flex;
                align-items: center;
            }

            .style-vertical .bbt-booking-form {
                padding: 30px;
            }

            .style-vertical .bbt-form-field {
                margin-bottom: 20px;
            }

            .style-floating {
                position: fixed;
                bottom: 30px;
                left: 50%;
                transform: translateX(-50%);
                z-index: 100;
                animation: bbtFloatUp 0.5s ease;
            }

            @keyframes bbtFloatUp {
                from {
                    opacity: 0;
                    transform: translateX(-50%) translateY(30px);
                }

                to {
                    opacity: 1;
                    transform: translateX(-50%) translateY(0);
                }
            }

            .bbt-form-field label {
                display: block;
                font-size: 12px;
                font-weight: 600;
                color: #666;
                margin-bottom: 8px;
            }

            .bbt-form-field select,
            .bbt-form-field input {
                width: 100%;
                padding: 12px 0;
                border: none;
                font-size: 16px;
                font-weight: 600;
                color: #1a1a1a;
                background: transparent;
                cursor: pointer;
            }

            .bbt-form-field select:focus,
            .bbt-form-field input:focus {
                outline: none;
            }

            .bbt-form-submit .bbt-btn {
                display: flex;
                align-items: center;
                gap: 10px;
                padding: 16px 30px;
                white-space: nowrap;
            }

            .bbt-form-submit .bbt-btn svg {
                transition: transform 0.3s ease;
            }

            .bbt-form-submit .bbt-btn:hover svg {
                transform: translateX(5px);
            }

            @media (max-width: 1024px) {
                .style-horizontal .bbt-booking-form {
                    flex-wrap: wrap;
                }

                .style-horizontal .bbt-form-field {
                    flex: 1 1 45%;
                    border-bottom: 1px solid #eee;
                }

                .style-horizontal .bbt-form-submit {
                    flex: 1 1 100%;
                    justify-content: center;
                }
            }
        </style>
        <?php
    }
}
