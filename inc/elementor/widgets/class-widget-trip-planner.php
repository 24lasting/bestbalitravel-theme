<?php
/**
 * Batch of Travel Widgets
 * @package BestBaliTravel
 */
if (!defined('ABSPATH'))
    exit;

// Trip Planner Widget
class BBT_Widget_Trip_Planner extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'bbt-trip-planner';
    }
    public function get_title()
    {
        return esc_html__('Trip Planner', 'bestbalitravel');
    }
    public function get_icon()
    {
        return 'eicon-calendar';
    }
    public function get_categories()
    {
        return ['bbt-widgets'];
    }

    protected function register_controls()
    {
        $this->start_controls_section('section_content', ['label' => 'Settings']);
        $this->add_control('title', ['label' => 'Title', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Plan Your Trip']);
        $this->end_controls_section();
    }

    protected function render()
    {
        $s = $this->get_settings_for_display();
        ?>
        <div class="bbt-trip-planner">
            <div class="bbt-tp-header">
                <h3>📅
                    <?php echo esc_html($s['title']); ?>
                </h3>
            </div>
            <form class="bbt-tp-form">
                <div class="bbt-tp-field"><label>When?</label><input type="date" name="date" min="<?php echo date('Y-m-d'); ?>">
                </div>
                <div class="bbt-tp-field"><label>How many days?</label><select name="days">
                        <option>1-3 days</option>
                        <option>4-7 days</option>
                        <option>8-14 days</option>
                        <option>15+ days</option>
                    </select></div>
                <div class="bbt-tp-field"><label>Travelers</label><input type="number" name="travelers" value="2" min="1"
                        max="20"></div>
                <div class="bbt-tp-field"><label>Interests</label>
                    <div class="bbt-tp-tags"><span class="bbt-tag" data-active>🏖️ Beach</span><span class="bbt-tag">🏔️
                            Mountain</span><span class="bbt-tag">🛕 Culture</span><span class="bbt-tag">🍜 Food</span><span
                            class="bbt-tag">💆 Wellness</span><span class="bbt-tag">🎢 Adventure</span></div>
                </div>
                <button type="submit" class="bbt-btn bbt-btn-primary">Generate Itinerary</button>
            </form>
        </div>
        <style>
            .bbt-trip-planner {
                background: #fff;
                border-radius: 24px;
                padding: 30px;
                box-shadow: 0 15px 50px rgba(0, 0, 0, .1)
            }

            .bbt-tp-header h3 {
                margin: 0 0 25px;
                font-size: 22px
            }

            .bbt-tp-field {
                margin-bottom: 20px
            }

            .bbt-tp-field label {
                display: block;
                font-size: 13px;
                font-weight: 600;
                color: #666;
                margin-bottom: 8px
            }

            .bbt-tp-field input,
            .bbt-tp-field select {
                width: 100%;
                padding: 14px 16px;
                border: 2px solid #eee;
                border-radius: 12px;
                font-size: 15px;
                transition: border-color .2s ease
            }

            .bbt-tp-field input:focus,
            .bbt-tp-field select:focus {
                outline: none;
                border-color: #F5A623
            }

            .bbt-tp-tags {
                display: flex;
                flex-wrap: wrap;
                gap: 10px
            }

            .bbt-tag {
                padding: 10px 16px;
                background: #f5f5f5;
                border-radius: 25px;
                font-size: 13px;
                cursor: pointer;
                transition: all .2s ease
            }

            .bbt-tag:hover,
            .bbt-tag[data-active] {
                background: #F5A623;
                color: #000
            }

            .bbt-trip-planner .bbt-btn {
                width: 100%;
                padding: 16px;
                margin-top: 10px
            }
        </style>
        <?php
    }
}
