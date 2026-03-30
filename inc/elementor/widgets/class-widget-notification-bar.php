<?php
if (!defined('ABSPATH'))
    exit;

class BBT_Widget_Notification_Bar extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'bbt-notification-bar';
    }
    public function get_title()
    {
        return esc_html__('Notification Bar', 'bestbalitravel');
    }
    public function get_icon()
    {
        return 'eicon-alert';
    }
    public function get_categories()
    {
        return ['bbt-widgets'];
    }

    protected function register_controls()
    {
        $this->start_controls_section('section_content', ['label' => 'Content']);
        $this->add_control('icon', ['label' => 'Icon', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '🎉']);
        $this->add_control('text', ['label' => 'Text', 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'Limited offer! Get 20% off on all tours - Use code BALI20']);
        $this->add_control('btn_text', ['label' => 'Button', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Book Now']);
        $this->add_control('btn_link', ['label' => 'Link', 'type' => \Elementor\Controls_Manager::URL]);
        $this->add_control('dismissible', ['label' => 'Dismissible', 'type' => \Elementor\Controls_Manager::SWITCHER, 'default' => 'yes']);
        $this->add_control('bg_color', ['label' => 'Background', 'type' => \Elementor\Controls_Manager::COLOR, 'default' => '#1a1a1a']);
        $this->end_controls_section();
    }

    protected function render()
    {
        $s = $this->get_settings_for_display();
        ?>
        <div class="bbt-notification-bar" style="background:<?php echo esc_attr($s['bg_color']); ?>">
            <div class="bbt-nb-content">
                <span class="bbt-nb-icon">
                    <?php echo $s['icon']; ?>
                </span>
                <span class="bbt-nb-text">
                    <?php echo esc_html($s['text']); ?>
                </span>
                <?php if ($s['btn_text']): ?><a href="<?php echo esc_url($s['btn_link']['url'] ?? '#'); ?>" class="bbt-nb-btn">
                        <?php echo esc_html($s['btn_text']); ?>
                    </a>
                <?php endif; ?>
            </div>
            <?php if ($s['dismissible'] === 'yes'): ?><button class="bbt-nb-close"
                    onclick="this.parentElement.remove()">&times;</button>
            <?php endif; ?>
        </div>
        <style>
            .bbt-notification-bar {
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 15px 25px;
                color: #fff
            }

            .bbt-nb-content {
                display: flex;
                align-items: center;
                gap: 15px;
                flex-wrap: wrap
            }

            .bbt-nb-icon {
                font-size: 24px
            }

            .bbt-nb-text {
                font-size: 14px
            }

            .bbt-nb-btn {
                padding: 8px 20px;
                background: #F5A623;
                color: #000;
                text-decoration: none;
                border-radius: 20px;
                font-size: 13px;
                font-weight: 600
            }

            .bbt-nb-close {
                background: none;
                border: none;
                color: #fff;
                font-size: 24px;
                cursor: pointer;
                opacity: .7
            }
        </style>
        <?php
    }
}
