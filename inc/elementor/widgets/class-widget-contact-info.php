<?php
if (!defined('ABSPATH'))
    exit;

class BBT_Widget_Contact_Info extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'bbt-contact-info';
    }
    public function get_title()
    {
        return esc_html__('Contact Info', 'bestbalitravel');
    }
    public function get_icon()
    {
        return 'eicon-mail';
    }
    public function get_categories()
    {
        return ['bbt-widgets'];
    }

    protected function register_controls()
    {
        $this->start_controls_section('section_content', ['label' => 'Info']);
        $this->add_control('phone', ['label' => 'Phone', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '+62 812 3456 7890']);
        $this->add_control('email', ['label' => 'Email', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'hello@bestbalitravel.com']);
        $this->add_control('address', ['label' => 'Address', 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'Jl. Sunset Road No. 123, Kuta, Bali']);
        $this->add_control('hours', ['label' => 'Hours', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Mon-Sun: 8AM - 8PM']);
        $this->end_controls_section();
    }

    protected function render()
    {
        $s = $this->get_settings_for_display();
        ?>
        <div class="bbt-contact-info">
            <?php if ($s['phone']): ?>
                <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $s['phone'])); ?>"
                    class="bbt-ci-item"><span>📞</span>
                    <div><strong>Phone</strong><span>
                            <?php echo esc_html($s['phone']); ?>
                        </span></div>
                </a>
            <?php endif; ?>
            <?php if ($s['email']): ?>
                <a href="mailto:<?php echo esc_attr($s['email']); ?>" class="bbt-ci-item"><span>📧</span>
                    <div><strong>Email</strong><span>
                            <?php echo esc_html($s['email']); ?>
                        </span></div>
                </a>
            <?php endif; ?>
            <?php if ($s['address']): ?>
                <div class="bbt-ci-item"><span>📍</span>
                    <div><strong>Address</strong><span>
                            <?php echo esc_html($s['address']); ?>
                        </span></div>
                </div>
            <?php endif; ?>
            <?php if ($s['hours']): ?>
                <div class="bbt-ci-item"><span>🕐</span>
                    <div><strong>Hours</strong><span>
                            <?php echo esc_html($s['hours']); ?>
                        </span></div>
                </div>
            <?php endif; ?>
        </div>
        <style>
            .bbt-contact-info {
                display: flex;
                flex-direction: column;
                gap: 15px
            }

            .bbt-ci-item {
                display: flex;
                align-items: flex-start;
                gap: 15px;
                padding: 20px;
                background: #fff;
                border-radius: 16px;
                text-decoration: none;
                color: inherit;
                transition: all .3s ease
            }

            a.bbt-ci-item:hover {
                transform: translateX(5px);
                background: #f9f9f9
            }

            .bbt-ci-item>span {
                font-size: 28px
            }

            .bbt-ci-item strong {
                display: block;
                font-size: 14px;
                color: #666;
                margin-bottom: 3px
            }

            .bbt-ci-item div span {
                font-size: 16px;
                color: #1a1a1a
            }
        </style>
        <?php
    }
}
