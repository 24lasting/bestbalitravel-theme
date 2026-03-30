<?php
if (!defined('ABSPATH'))
    exit;

class BBT_Widget_Icon_List extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'bbt-icon-list';
    }
    public function get_title()
    {
        return esc_html__('Icon List', 'bestbalitravel');
    }
    public function get_icon()
    {
        return 'eicon-bullet-list';
    }
    public function get_categories()
    {
        return ['bbt-widgets'];
    }

    protected function register_controls()
    {
        $this->start_controls_section('section_items', ['label' => 'Items']);
        $repeater = new \Elementor\Repeater();
        $repeater->add_control('icon', ['label' => 'Icon', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '✓']);
        $repeater->add_control('text', ['label' => 'Text', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'List item']);
        $this->add_control('items', [
            'type' => \Elementor\Controls_Manager::REPEATER,
            'fields' => $repeater->get_controls(),
            'default' => [
                ['icon' => '✓', 'text' => 'Professional tour guides'],
                ['icon' => '✓', 'text' => 'Comfortable transportation'],
                ['icon' => '✓', 'text' => 'Free hotel pickup'],
                ['icon' => '✓', 'text' => 'Lunch included'],
            ]
        ]);
        $this->add_control('icon_color', ['label' => 'Icon Color', 'type' => \Elementor\Controls_Manager::COLOR, 'default' => '#10B981']);
        $this->end_controls_section();
    }

    protected function render()
    {
        $s = $this->get_settings_for_display();
        ?>
        <ul class="bbt-icon-list" style="--icon-color:<?php echo esc_attr($s['icon_color']); ?>">
            <?php foreach ($s['items'] as $i => $item): ?>
                <li style="--d:<?php echo $i * 0.1; ?>s"><span class="bbt-il-icon">
                        <?php echo $item['icon']; ?>
                    </span><span>
                        <?php echo esc_html($item['text']); ?>
                    </span></li>
            <?php endforeach; ?>
        </ul>
        <style>
            .bbt-icon-list {
                list-style: none;
                padding: 0;
                margin: 0
            }

            .bbt-icon-list li {
                display: flex;
                align-items: center;
                gap: 12px;
                padding: 12px 0;
                border-bottom: 1px solid #eee;
                opacity: 0;
                animation: bbtIlFade .4s ease forwards;
                animation-delay: var(--d)
            }

            @keyframes bbtIlFade {
                to {
                    opacity: 1
                }
            }

            .bbt-icon-list li:last-child {
                border-bottom: none
            }

            .bbt-il-icon {
                width: 28px;
                height: 28px;
                background: var(--icon-color);
                color: #fff;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 14px;
                flex-shrink: 0
            }
        </style>
        <?php
    }
}
