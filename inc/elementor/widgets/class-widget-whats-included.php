<?php
if (!defined('ABSPATH'))
    exit;

class BBT_Widget_Whats_Included extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'bbt-whats-included';
    }
    public function get_title()
    {
        return esc_html__("What's Included", 'bestbalitravel');
    }
    public function get_icon()
    {
        return 'eicon-check-circle';
    }
    public function get_categories()
    {
        return ['bbt-widgets'];
    }

    protected function register_controls()
    {
        $this->start_controls_section('section_included', ['label' => 'Included']);
        $this->add_control('included', ['label' => 'Included (one per line)', 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => "Hotel pickup & drop-off\nEnglish-speaking guide\nLunch & drinks\nEntrance fees\nTravel insurance"]);
        $this->add_control('excluded', ['label' => 'Not Included', 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => "Personal expenses\nTips"]);
        $this->end_controls_section();
    }

    protected function render()
    {
        $s = $this->get_settings_for_display();
        $included = array_filter(array_map('trim', explode("\n", $s['included'])));
        $excluded = array_filter(array_map('trim', explode("\n", $s['excluded'])));
        ?>
        <div class="bbt-whats-included">
            <div class="bbt-wi-section included">
                <h4>✅ Included</h4>
                <ul>
                    <?php foreach ($included as $item): ?>
                        <li>
                            <?php echo esc_html($item); ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="bbt-wi-section excluded">
                <h4>❌ Not Included</h4>
                <ul>
                    <?php foreach ($excluded as $item): ?>
                        <li>
                            <?php echo esc_html($item); ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
        <style>
            .bbt-whats-included {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 30px
            }

            .bbt-wi-section {
                background: #fff;
                padding: 25px;
                border-radius: 16px;
                box-shadow: 0 5px 20px rgba(0, 0, 0, .06)
            }

            .bbt-wi-section h4 {
                margin: 0 0 15px;
                font-size: 16px
            }

            .bbt-wi-section ul {
                list-style: none;
                padding: 0;
                margin: 0
            }

            .bbt-wi-section li {
                padding: 10px 0;
                border-bottom: 1px solid #eee;
                font-size: 14px
            }

            .included li::before {
                content: '✓';
                margin-right: 10px;
                color: #10B981
            }

            .excluded li::before {
                content: '✕';
                margin-right: 10px;
                color: #EF4444
            }

            @media(max-width:640px) {
                .bbt-whats-included {
                    grid-template-columns: 1fr
                }
            }
        </style>
        <?php
    }
}
