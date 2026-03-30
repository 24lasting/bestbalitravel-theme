<?php
if (!defined('ABSPATH'))
    exit;

class BBT_Widget_Popup_Booking extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'bbt-popup-booking';
    }
    public function get_title()
    {
        return esc_html__('Popup Booking', 'bestbalitravel');
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
        $this->add_control('btn_text', ['label' => 'Button Text', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Book Now']);
        $this->add_control('btn_style', ['label' => 'Style', 'type' => \Elementor\Controls_Manager::SELECT, 'options' => ['primary' => 'Primary', 'outline' => 'Outline', 'floating' => 'Floating'], 'default' => 'primary']);
        $this->end_controls_section();
    }

    protected function render()
    {
        $s = $this->get_settings_for_display();
        $id = 'pb-' . uniqid();
        ?>
        <button class="bbt-popup-booking-btn style-<?php echo esc_attr($s['btn_style']); ?>"
            onclick="document.getElementById('<?php echo $id; ?>').classList.add('active')">
            <?php echo esc_html($s['btn_text']); ?>
        </button>
        <div class="bbt-popup-booking" id="<?php echo $id; ?>">
            <div class="bbt-pb-backdrop" onclick="this.parentElement.classList.remove('active')"></div>
            <div class="bbt-pb-modal">
                <button class="bbt-pb-close"
                    onclick="this.closest('.bbt-popup-booking').classList.remove('active')">&times;</button>
                <h3>📅 Quick Booking</h3>
                <form>
                    <div class="bbt-pb-field"><label>Date</label><input type="date" min="<?php echo date('Y-m-d'); ?>"></div>
                    <div class="bbt-pb-field"><label>Guests</label><input type="number" value="2" min="1" max="20"></div>
                    <div class="bbt-pb-field"><label>Special Requests</label><textarea rows="3"></textarea></div>
                    <button type="submit" class="bbt-pb-submit">Complete Booking</button>
                </form>
            </div>
        </div>
        <style>
            .bbt-popup-booking-btn.style-primary {
                padding: 16px 32px;
                background: #F5A623;
                border: none;
                border-radius: 30px;
                font-size: 16px;
                font-weight: 700;
                cursor: pointer
            }

            .bbt-popup-booking-btn.style-outline {
                padding: 14px 30px;
                background: transparent;
                border: 2px solid #F5A623;
                color: #F5A623;
                border-radius: 30px;
                font-weight: 700;
                cursor: pointer
            }

            .bbt-popup-booking-btn.style-floating {
                position: fixed;
                bottom: 30px;
                left: 30px;
                padding: 16px 32px;
                background: #F5A623;
                border: none;
                border-radius: 30px;
                font-weight: 700;
                cursor: pointer;
                z-index: 999;
                box-shadow: 0 10px 30px rgba(0, 0, 0, .2)
            }

            .bbt-popup-booking {
                position: fixed;
                inset: 0;
                z-index: 9999;
                display: none;
                align-items: center;
                justify-content: center
            }

            .bbt-popup-booking.active {
                display: flex
            }

            .bbt-pb-backdrop {
                position: absolute;
                inset: 0;
                background: rgba(0, 0, 0, .8)
            }

            .bbt-pb-modal {
                position: relative;
                background: #fff;
                padding: 40px;
                border-radius: 24px;
                width: 90%;
                max-width: 400px
            }

            .bbt-pb-close {
                position: absolute;
                top: 15px;
                right: 15px;
                width: 40px;
                height: 40px;
                background: #f5f5f5;
                border: none;
                border-radius: 50%;
                font-size: 24px;
                cursor: pointer
            }

            .bbt-pb-modal h3 {
                margin: 0 0 25px
            }

            .bbt-pb-field {
                margin-bottom: 18px
            }

            .bbt-pb-field label {
                display: block;
                font-size: 14px;
                font-weight: 600;
                margin-bottom: 8px
            }

            .bbt-pb-field input,
            .bbt-pb-field textarea {
                width: 100%;
                padding: 14px;
                border: 2px solid #eee;
                border-radius: 12px
            }

            .bbt-pb-submit {
                width: 100%;
                padding: 16px;
                background: #F5A623;
                border: none;
                border-radius: 12px;
                font-weight: 700;
                cursor: pointer
            }
        </style>
        <?php
    }
}
