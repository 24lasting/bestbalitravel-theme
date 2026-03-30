<?php
if (!defined('ABSPATH'))
    exit;

class BBT_Widget_Tour_Booking_Box extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'bbt-tour-booking-box';
    }
    public function get_title()
    {
        return esc_html__('Tour Booking Box', 'bestbalitravel');
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
        $this->start_controls_section('section_content', ['label' => 'Settings']);
        $this->add_control('price', ['label' => 'Price', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Rp 450,000']);
        $this->add_control('original_price', ['label' => 'Original Price', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Rp 600,000']);
        $this->add_control('rating', ['label' => 'Rating', 'type' => \Elementor\Controls_Manager::NUMBER, 'default' => 4.9]);
        $this->add_control('reviews', ['label' => 'Reviews', 'type' => \Elementor\Controls_Manager::NUMBER, 'default' => 128]);
        $this->end_controls_section();
    }

    protected function render()
    {
        $s = $this->get_settings_for_display();
        ?>
        <div class="bbt-tour-booking-box">
            <div class="bbt-tbb-header">
                <?php if ($s['original_price']): ?><span class="bbt-tbb-original">
                        <?php echo esc_html($s['original_price']); ?>
                    </span>
                <?php endif; ?>
                <span class="bbt-tbb-price">
                    <?php echo esc_html($s['price']); ?>
                </span><span class="bbt-tbb-person">/ person</span>
            </div>
            <div class="bbt-tbb-rating">⭐
                <?php echo esc_html($s['rating']); ?> <span>(
                    <?php echo esc_html($s['reviews']); ?> reviews)
                </span>
            </div>
            <form class="bbt-tbb-form">
                <div class="bbt-tbb-field"><label>📅 Date</label><input type="date" min="<?php echo date('Y-m-d'); ?>"></div>
                <div class="bbt-tbb-field"><label>👥 Guests</label>
                    <div class="bbt-tbb-counter"><button type="button"
                            onclick="this.nextElementSibling.stepDown()">−</button><input type="number" value="2" min="1"
                            max="20"><button type="button" onclick="this.previousElementSibling.stepUp()">+</button></div>
                </div>
                <button type="submit" class="bbt-tbb-submit">Book Now</button>
            </form>
            <div class="bbt-tbb-extras"><span>✅ Free cancellation</span><span>⚡ Instant confirmation</span><span>💳 Secure
                    payment</span></div>
        </div>
        <style>
            .bbt-tour-booking-box {
                background: #fff;
                padding: 30px;
                border-radius: 24px;
                box-shadow: 0 15px 50px rgba(0, 0, 0, .12);
                position: sticky;
                top: 100px
            }

            .bbt-tbb-header {
                margin-bottom: 10px
            }

            .bbt-tbb-original {
                color: #999;
                text-decoration: line-through;
                font-size: 16px;
                margin-right: 10px
            }

            .bbt-tbb-price {
                font-size: 32px;
                font-weight: 800;
                color: #F5A623
            }

            .bbt-tbb-person {
                color: #666;
                font-size: 14px
            }

            .bbt-tbb-rating {
                margin-bottom: 20px;
                font-size: 15px
            }

            .bbt-tbb-rating span {
                color: #666
            }

            .bbt-tbb-field {
                margin-bottom: 18px
            }

            .bbt-tbb-field label {
                display: block;
                font-size: 14px;
                font-weight: 600;
                margin-bottom: 8px
            }

            .bbt-tbb-field input[type="date"] {
                width: 100%;
                padding: 14px;
                border: 2px solid #eee;
                border-radius: 12px;
                font-size: 15px
            }

            .bbt-tbb-counter {
                display: flex;
                border: 2px solid #eee;
                border-radius: 12px;
                overflow: hidden
            }

            .bbt-tbb-counter button {
                width: 50px;
                background: #f5f5f5;
                border: none;
                font-size: 20px;
                cursor: pointer
            }

            .bbt-tbb-counter input {
                flex: 1;
                text-align: center;
                border: none;
                font-size: 16px;
                font-weight: 600
            }

            .bbt-tbb-submit {
                width: 100%;
                padding: 18px;
                background: linear-gradient(135deg, #F5A623, #FFD93D);
                border: none;
                border-radius: 12px;
                font-size: 18px;
                font-weight: 700;
                cursor: pointer;
                margin-bottom: 20px;
                transition: all .3s ease
            }

            .bbt-tbb-submit:hover {
                transform: translateY(-2px);
                box-shadow: 0 10px 30px rgba(245, 166, 35, .4)
            }

            .bbt-tbb-extras {
                display: flex;
                flex-direction: column;
                gap: 8px;
                font-size: 13px;
                color: #666
            }
        </style>
        <?php
    }
}
