<?php
/**
 * Elementor Tour Categories Widget
 * Icon-based category grid
 *
 * @package BestBaliTravel
 */

if (!defined('ABSPATH')) {
    exit;
}

class BBT_Widget_Tour_Categories extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'bbt-tour-categories';
    }
    public function get_title()
    {
        return esc_html__('Tour Categories', 'bestbalitravel');
    }
    public function get_icon()
    {
        return 'eicon-gallery-grid';
    }
    public function get_categories()
    {
        return ['bbt-widgets'];
    }

    protected function register_controls()
    {
        $this->start_controls_section('section_categories', [
            'label' => esc_html__('Categories', 'bestbalitravel'),
        ]);

        $repeater = new \Elementor\Repeater();

        $repeater->add_control('icon', ['label' => 'Icon', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '🏝️']);
        $repeater->add_control('title', ['label' => 'Title', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Beach']);
        $repeater->add_control('count', ['label' => 'Tours Count', 'type' => \Elementor\Controls_Manager::NUMBER, 'default' => 10]);
        $repeater->add_control('link', ['label' => 'Link', 'type' => \Elementor\Controls_Manager::URL]);
        $repeater->add_control('color', ['label' => 'Color', 'type' => \Elementor\Controls_Manager::COLOR, 'default' => '#0EA5E9']);

        $this->add_control('categories', [
            'type' => \Elementor\Controls_Manager::REPEATER,
            'fields' => $repeater->get_controls(),
            'default' => [
                ['icon' => '🏝️', 'title' => 'Beach Tours', 'count' => 15, 'color' => '#0EA5E9'],
                ['icon' => '🏔️', 'title' => 'Mountain', 'count' => 12, 'color' => '#10B981'],
                ['icon' => '🛕', 'title' => 'Temple', 'count' => 18, 'color' => '#F5A623'],
                ['icon' => '🎢', 'title' => 'Adventure', 'count' => 10, 'color' => '#FF6B6B'],
                ['icon' => '🍜', 'title' => 'Food Tours', 'count' => 8, 'color' => '#8B5CF6'],
                ['icon' => '💆', 'title' => 'Wellness', 'count' => 6, 'color' => '#EC4899'],
            ],
            'title_field' => '{{{ title }}}',
        ]);

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        ?>
        <div class="bbt-tour-categories">
            <?php foreach ($settings['categories'] as $i => $cat):
                $link = $cat['link']['url'] ?? '#';
                ?>
                <a href="<?php echo esc_url($link); ?>" class="bbt-category-card"
                    style="--accent: <?php echo esc_attr($cat['color']); ?>; --delay: <?php echo $i * 0.1; ?>s">
                    <span class="bbt-cat-icon">
                        <?php echo $cat['icon']; ?>
                    </span>
                    <h4 class="bbt-cat-title">
                        <?php echo esc_html($cat['title']); ?>
                    </h4>
                    <span class="bbt-cat-count">
                        <?php echo esc_html($cat['count']); ?> Tours
                    </span>
                </a>
            <?php endforeach; ?>
        </div>
        <style>
            .bbt-tour-categories {
                display: grid;
                grid-template-columns: repeat(6, 1fr);
                gap: 20px;
            }

            .bbt-category-card {
                display: flex;
                flex-direction: column;
                align-items: center;
                text-align: center;
                padding: 30px 20px;
                background: #fff;
                border-radius: 20px;
                box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
                text-decoration: none;
                color: inherit;
                transition: all 0.4s ease;
                opacity: 0;
                animation: bbtCatSlide 0.5s ease forwards;
                animation-delay: var(--delay);
            }

            @keyframes bbtCatSlide {
                to {
                    opacity: 1;
                }
            }

            .bbt-category-card:hover {
                transform: translateY(-10px);
                box-shadow: 0 20px 50px rgba(0, 0, 0, 0.15);
            }

            .bbt-cat-icon {
                font-size: 48px;
                margin-bottom: 15px;
                transition: transform 0.3s ease;
            }

            .bbt-category-card:hover .bbt-cat-icon {
                transform: scale(1.2) rotate(10deg);
            }

            .bbt-cat-title {
                margin: 0 0 8px;
                font-size: 16px;
                font-weight: 700;
                color: #1a1a1a;
            }

            .bbt-cat-count {
                font-size: 13px;
                color: var(--accent);
                font-weight: 600;
                padding: 4px 12px;
                background: color-mix(in srgb, var(--accent) 15%, white);
                border-radius: 20px;
            }

            @media (max-width: 1024px) {
                .bbt-tour-categories {
                    grid-template-columns: repeat(3, 1fr);
                }
            }

            @media (max-width: 640px) {
                .bbt-tour-categories {
                    grid-template-columns: repeat(2, 1fr);
                }
            }
        </style>
        <?php
    }
}
