<?php
if (!defined('ABSPATH'))
    exit;

class BBT_Widget_Feature_Box extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'bbt-feature-box';
    }
    public function get_title()
    {
        return esc_html__('Feature Box', 'bestbalitravel');
    }
    public function get_icon()
    {
        return 'eicon-featured-image';
    }
    public function get_categories()
    {
        return ['bbt-widgets'];
    }

    protected function register_controls()
    {
        $this->start_controls_section('section_content', ['label' => 'Content']);
        $this->add_control('icon', ['label' => 'Icon', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '✨']);
        $this->add_control('title', ['label' => 'Title', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Feature Title']);
        $this->add_control('description', ['label' => 'Description', 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'Description text here']);
        $this->add_control('style', ['label' => 'Style', 'type' => \Elementor\Controls_Manager::SELECT, 'options' => ['default' => 'Default', 'gradient' => 'Gradient', 'outline' => 'Outline'], 'default' => 'default']);
        $this->add_control('color', ['label' => 'Accent Color', 'type' => \Elementor\Controls_Manager::COLOR, 'default' => '#F5A623']);
        $this->end_controls_section();
    }

    protected function render()
    {
        $s = $this->get_settings_for_display();
        ?>
        <div class="bbt-feature-box style-<?php echo esc_attr($s['style']); ?>"
            style="--accent:<?php echo esc_attr($s['color']); ?>">
            <div class="bbt-fb-icon">
                <?php echo $s['icon']; ?>
            </div>
            <h3>
                <?php echo esc_html($s['title']); ?>
            </h3>
            <p>
                <?php echo esc_html($s['description']); ?>
            </p>
        </div>
        <style>
            .bbt-feature-box {
                padding: 35px;
                border-radius: 20px;
                text-align: center;
                transition: all .4s ease
            }

            .bbt-feature-box:hover {
                transform: translateY(-8px)
            }

            .style-default {
                background: #fff;
                box-shadow: 0 8px 30px rgba(0, 0, 0, .08)
            }

            .style-gradient {
                background: linear-gradient(135deg, var(--accent), color-mix(in srgb, var(--accent) 80%, #fff));
                color: #fff
            }

            .style-outline {
                border: 2px solid var(--accent);
                background: transparent
            }

            .bbt-fb-icon {
                width: 80px;
                height: 80px;
                background: var(--accent);
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 36px;
                margin: 0 auto 20px;
                transition: transform .3s ease
            }

            .style-gradient .bbt-fb-icon {
                background: rgba(255, 255, 255, .2)
            }

            .bbt-feature-box:hover .bbt-fb-icon {
                transform: scale(1.1) rotate(10deg)
            }

            .bbt-feature-box h3 {
                margin: 0 0 12px;
                font-size: 20px
            }

            .bbt-feature-box p {
                margin: 0;
                font-size: 14px;
                opacity: .85;
                line-height: 1.6
            }
        </style>
        <?php
    }
}
