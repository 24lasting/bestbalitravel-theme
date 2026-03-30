<?php
if (!defined('ABSPATH'))
    exit;

class BBT_Widget_Progress_Bar extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'bbt-progress-bar';
    }
    public function get_title()
    {
        return esc_html__('Progress Bar', 'bestbalitravel');
    }
    public function get_icon()
    {
        return 'eicon-skill-bar';
    }
    public function get_categories()
    {
        return ['bbt-widgets'];
    }

    protected function register_controls()
    {
        $this->start_controls_section('section_content', ['label' => 'Content']);
        $this->add_control('label', ['label' => 'Label', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Booking Progress']);
        $this->add_control('percentage', ['label' => 'Percentage', 'type' => \Elementor\Controls_Manager::SLIDER, 'range' => ['%' => ['min' => 0, 'max' => 100]], 'default' => ['size' => 75]]);
        $this->add_control('color', ['label' => 'Color', 'type' => \Elementor\Controls_Manager::COLOR, 'default' => '#F5A623']);
        $this->end_controls_section();
    }

    protected function render()
    {
        $s = $this->get_settings_for_display();
        ?>
        <div class="bbt-progress-bar">
            <div class="bbt-pb-header"><span>
                    <?php echo esc_html($s['label']); ?>
                </span><span>
                    <?php echo esc_html($s['percentage']['size']); ?>%
                </span></div>
            <div class="bbt-pb-track">
                <div class="bbt-pb-fill"
                    style="--pct:<?php echo esc_attr($s['percentage']['size']); ?>%;--color:<?php echo esc_attr($s['color']); ?>">
                </div>
            </div>
        </div>
        <style>
            .bbt-pb-header {
                display: flex;
                justify-content: space-between;
                margin-bottom: 10px;
                font-size: 14px;
                font-weight: 600
            }

            .bbt-pb-track {
                height: 12px;
                background: #eee;
                border-radius: 10px;
                overflow: hidden
            }

            .bbt-pb-fill {
                height: 100%;
                width: 0;
                background: linear-gradient(90deg, var(--color), color-mix(in srgb, var(--color) 80%, #fff));
                border-radius: 10px;
                animation: bbtPbGrow 1.5s ease forwards
            }

            @keyframes bbtPbGrow {
                to {
                    width: var(--pct)
                }
            }
        </style>
        <?php
    }
}
