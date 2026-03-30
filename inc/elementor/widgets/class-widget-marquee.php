<?php
if (!defined('ABSPATH'))
    exit;

class BBT_Widget_Marquee extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'bbt-marquee';
    }
    public function get_title()
    {
        return esc_html__('Marquee Text', 'bestbalitravel');
    }
    public function get_icon()
    {
        return 'eicon-post-slider';
    }
    public function get_categories()
    {
        return ['bbt-widgets'];
    }

    protected function register_controls()
    {
        $this->start_controls_section('section_content', ['label' => 'Content']);
        $this->add_control('text', ['label' => 'Text', 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => '🌴 Best Bali Travel • Explore Paradise • Book Now • Adventure Awaits']);
        $this->add_control('speed', ['label' => 'Speed (seconds)', 'type' => \Elementor\Controls_Manager::NUMBER, 'default' => 20]);
        $this->add_control('direction', ['label' => 'Direction', 'type' => \Elementor\Controls_Manager::SELECT, 'options' => ['left' => 'Left', 'right' => 'Right'], 'default' => 'left']);
        $this->add_control('font_size', ['label' => 'Font Size', 'type' => \Elementor\Controls_Manager::SLIDER, 'default' => ['size' => 24]]);
        $this->add_control('bg_color', ['label' => 'Background', 'type' => \Elementor\Controls_Manager::COLOR, 'default' => '#F5A623']);
        $this->end_controls_section();
    }

    protected function render()
    {
        $s = $this->get_settings_for_display();
        $dir = $s['direction'] === 'right' ? 'reverse' : 'normal';
        ?>
        <div class="bbt-marquee" style="background:<?php echo esc_attr($s['bg_color']); ?>">
            <div class="bbt-marquee-track"
                style="--speed:<?php echo esc_attr($s['speed']); ?>s;--dir:<?php echo $dir; ?>;font-size:<?php echo esc_attr($s['font_size']['size']); ?>px">
                <?php for ($i = 0; $i < 4; $i++): ?><span>
                        <?php echo esc_html($s['text']); ?> &nbsp;
                    </span>
                <?php endfor; ?>
            </div>
        </div>
        <style>
            .bbt-marquee {
                overflow: hidden;
                padding: 20px 0;
                white-space: nowrap
            }

            .bbt-marquee-track {
                display: inline-flex;
                animation: bbtMarquee var(--speed) linear infinite;
                animation-direction: var(--dir);
                font-weight: 700
            }

            @keyframes bbtMarquee {
                0% {
                    transform: translateX(0)
                }

                100% {
                    transform: translateX(-50%)
                }
            }
        </style>
        <?php
    }
}
