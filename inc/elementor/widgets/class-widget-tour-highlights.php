<?php
if (!defined('ABSPATH'))
    exit;

class BBT_Widget_Tour_Highlights extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'bbt-tour-highlights';
    }
    public function get_title()
    {
        return esc_html__('Tour Highlights', 'bestbalitravel');
    }
    public function get_icon()
    {
        return 'eicon-check-circle-o';
    }
    public function get_categories()
    {
        return ['bbt-widgets'];
    }

    protected function register_controls()
    {
        $this->start_controls_section('section_highlights', ['label' => 'Highlights']);
        $repeater = new \Elementor\Repeater();
        $repeater->add_control('icon', ['label' => 'Icon', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '✨']);
        $repeater->add_control('text', ['label' => 'Text', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Highlight']);
        $this->add_control('highlights', [
            'type' => \Elementor\Controls_Manager::REPEATER,
            'fields' => $repeater->get_controls(),
            'default' => [
                ['icon' => '🌅', 'text' => 'Stunning sunrise views'],
                ['icon' => '📸', 'text' => 'Instagram-worthy spots'],
                ['icon' => '🍜', 'text' => 'Local lunch included'],
                ['icon' => '🚐', 'text' => 'Air-conditioned transport'],
            ]
        ]);
        $this->end_controls_section();
    }

    protected function render()
    {
        $highlights = $this->get_settings_for_display()['highlights'];
        ?>
        <div class="bbt-tour-highlights">
            <?php foreach ($highlights as $i => $h): ?>
                <div class="bbt-th-item" style="--d:<?php echo $i * 0.1; ?>s"><span>
                        <?php echo $h['icon']; ?>
                    </span><span>
                        <?php echo esc_html($h['text']); ?>
                    </span></div>
            <?php endforeach; ?>
        </div>
        <style>
            .bbt-tour-highlights {
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                gap: 15px
            }

            .bbt-th-item {
                display: flex;
                align-items: center;
                gap: 12px;
                padding: 18px 20px;
                background: #f9f9f9;
                border-radius: 14px;
                font-size: 15px;
                opacity: 0;
                animation: bbtThFade .4s ease forwards;
                animation-delay: var(--d)
            }

            @keyframes bbtThFade {
                to {
                    opacity: 1
                }
            }

            .bbt-th-item span:first-child {
                font-size: 24px
            }

            @media(max-width:640px) {
                .bbt-tour-highlights {
                    grid-template-columns: 1fr
                }
            }
        </style>
        <?php
    }
}
