<?php
if (!defined('ABSPATH'))
    exit;

class BBT_Widget_Floating_Buttons extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'bbt-floating-buttons';
    }
    public function get_title()
    {
        return esc_html__('Floating Buttons', 'bestbalitravel');
    }
    public function get_icon()
    {
        return 'eicon-button';
    }
    public function get_categories()
    {
        return ['bbt-widgets'];
    }

    protected function register_controls()
    {
        $this->start_controls_section('section_buttons', ['label' => 'Buttons']);
        $this->add_control('show_whatsapp', ['label' => 'WhatsApp', 'type' => \Elementor\Controls_Manager::SWITCHER, 'default' => 'yes']);
        $this->add_control('whatsapp_number', ['label' => 'WhatsApp Number', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '6281234567890', 'condition' => ['show_whatsapp' => 'yes']]);
        $this->add_control('show_scroll_top', ['label' => 'Scroll to Top', 'type' => \Elementor\Controls_Manager::SWITCHER, 'default' => 'yes']);
        $this->add_control('show_call', ['label' => 'Call Button', 'type' => \Elementor\Controls_Manager::SWITCHER]);
        $this->add_control('phone_number', ['label' => 'Phone', 'type' => \Elementor\Controls_Manager::TEXT, 'condition' => ['show_call' => 'yes']]);
        $this->end_controls_section();
    }

    protected function render()
    {
        $s = $this->get_settings_for_display();
        ?>
        <div class="bbt-floating-buttons">
            <?php if ($s['show_whatsapp'] === 'yes'): ?>
                <a href="https://wa.me/<?php echo esc_attr($s['whatsapp_number']); ?>" target="_blank"
                    class="bbt-float-btn whatsapp"><span>💬</span></a>
            <?php endif; ?>
            <?php if ($s['show_call'] === 'yes' && $s['phone_number']): ?>
                <a href="tel:<?php echo esc_attr($s['phone_number']); ?>" class="bbt-float-btn call"><span>📞</span></a>
            <?php endif; ?>
            <?php if ($s['show_scroll_top'] === 'yes'): ?>
                <button class="bbt-float-btn scroll-top"
                    onclick="window.scrollTo({top:0,behavior:'smooth'})"><span>⬆️</span></button>
            <?php endif; ?>
        </div>
        <style>
            .bbt-floating-buttons {
                position: fixed;
                bottom: 30px;
                right: 30px;
                display: flex;
                flex-direction: column;
                gap: 12px;
                z-index: 999
            }

            .bbt-float-btn {
                width: 56px;
                height: 56px;
                border-radius: 50%;
                border: none;
                cursor: pointer;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 24px;
                box-shadow: 0 4px 20px rgba(0, 0, 0, .2);
                transition: all .3s ease;
                text-decoration: none
            }

            .bbt-float-btn:hover {
                transform: scale(1.1)
            }

            .bbt-float-btn.whatsapp {
                background: #25D366;
                color: #fff
            }

            .bbt-float-btn.call {
                background: #F5A623;
                color: #fff
            }

            .bbt-float-btn.scroll-top {
                background: #1a1a1a;
                color: #fff
            }
        </style>
        <?php
    }
}
