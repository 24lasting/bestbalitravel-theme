<?php
/**
 * Elementor Tour Features Icons Widget
 *
 * @package BestBaliTravel
 */

if (!defined('ABSPATH'))
    exit;

class BBT_Widget_Tour_Features extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'bbt-tour-features';
    }
    public function get_title()
    {
        return esc_html__('Tour Features Icons', 'bestbalitravel');
    }
    public function get_icon()
    {
        return 'eicon-icon-box';
    }
    public function get_categories()
    {
        return ['bbt-widgets'];
    }

    protected function register_controls()
    {
        $this->start_controls_section('section_features', ['label' => 'Features']);

        $repeater = new \Elementor\Repeater();
        $repeater->add_control('icon', ['label' => 'Icon', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '⏱️']);
        $repeater->add_control('title', ['label' => 'Title', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Duration']);
        $repeater->add_control('value', ['label' => 'Value', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '8 Hours']);

        $this->add_control('features', [
            'type' => \Elementor\Controls_Manager::REPEATER,
            'fields' => $repeater->get_controls(),
            'default' => [
                ['icon' => '⏱️', 'title' => 'Duration', 'value' => '8 Hours'],
                ['icon' => '👥', 'title' => 'Group Size', 'value' => 'Max 10'],
                ['icon' => '🗣️', 'title' => 'Language', 'value' => 'English'],
                ['icon' => '📍', 'title' => 'Pickup', 'value' => 'Hotel'],
                ['icon' => '🍽️', 'title' => 'Meals', 'value' => 'Included'],
                ['icon' => '📷', 'title' => 'Photos', 'value' => 'Free'],
            ],
        ]);

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        ?>
        <div class="bbt-tour-features">
            <?php foreach ($settings['features'] as $i => $f): ?>
                <div class="bbt-feature-item" style="--d:<?php echo $i * 0.1; ?>s">
                    <span class="bbt-feature-icon">
                        <?php echo $f['icon']; ?>
                    </span>
                    <span class="bbt-feature-title">
                        <?php echo esc_html($f['title']); ?>
                    </span>
                    <span class="bbt-feature-value">
                        <?php echo esc_html($f['value']); ?>
                    </span>
                </div>
            <?php endforeach; ?>
        </div>
        <style>
            .bbt-tour-features {
                display: grid;
                grid-template-columns: repeat(6, 1fr);
                gap: 15px
            }

            .bbt-feature-item {
                display: flex;
                flex-direction: column;
                align-items: center;
                text-align: center;
                padding: 20px 15px;
                background: #fff;
                border-radius: 16px;
                box-shadow: 0 4px 20px rgba(0, 0, 0, .06);
                transition: all .3s ease;
                opacity: 0;
                animation: bbtFeatureFade .5s ease forwards;
                animation-delay: var(--d)
            }

            @keyframes bbtFeatureFade {
                to {
                    opacity: 1
                }
            }

            .bbt-feature-item:hover {
                transform: translateY(-5px);
                box-shadow: 0 10px 30px rgba(0, 0, 0, .1)
            }

            .bbt-feature-icon {
                font-size: 32px;
                margin-bottom: 10px;
                transition: transform .3s ease
            }

            .bbt-feature-item:hover .bbt-feature-icon {
                transform: scale(1.2)
            }

            .bbt-feature-title {
                font-size: 12px;
                color: #666;
                margin-bottom: 4px
            }

            .bbt-feature-value {
                font-size: 14px;
                font-weight: 700;
                color: #1a1a1a
            }

            @media(max-width:768px) {
                .bbt-tour-features {
                    grid-template-columns: repeat(3, 1fr)
                }
            }
        </style>
        <?php
    }
}
