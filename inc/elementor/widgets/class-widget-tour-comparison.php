<?php
/**
 * Elementor Tour Comparison Table Widget
 * Compare multiple tours side by side
 *
 * @package BestBaliTravel
 */

if (!defined('ABSPATH')) {
    exit;
}

class BBT_Widget_Tour_Comparison extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'bbt-tour-comparison';
    }

    public function get_title()
    {
        return esc_html__('Tour Comparison', 'bestbalitravel');
    }

    public function get_icon()
    {
        return 'eicon-table';
    }

    public function get_categories()
    {
        return ['bbt-widgets'];
    }

    public function get_keywords()
    {
        return ['tour', 'comparison', 'table', 'compare'];
    }

    protected function register_controls()
    {
        // Content Section
        $this->start_controls_section('section_tours', [
            'label' => esc_html__('Tours to Compare', 'bestbalitravel'),
            'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
        ]);

        $repeater = new \Elementor\Repeater();

        $repeater->add_control('tour_id', [
            'label' => esc_html__('Select Tour', 'bestbalitravel'),
            'type' => \Elementor\Controls_Manager::SELECT2,
            'options' => $this->get_tours_list(),
            'label_block' => true,
        ]);

        $this->add_control('tours', [
            'label' => esc_html__('Tours', 'bestbalitravel'),
            'type' => \Elementor\Controls_Manager::REPEATER,
            'fields' => $repeater->get_controls(),
            'default' => [],
            'title_field' => 'Tour #{{{ tour_id }}}',
            'prevent_empty' => false,
        ]);

        $this->end_controls_section();

        // Style Section
        $this->start_controls_section('section_style', [
            'label' => esc_html__('Style', 'bestbalitravel'),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control('header_bg_color', [
            'label' => esc_html__('Header Background', 'bestbalitravel'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#F5A623',
        ]);

        $this->add_control('highlight_tour', [
            'label' => esc_html__('Highlight Column', 'bestbalitravel'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'options' => [
                'none' => esc_html__('None', 'bestbalitravel'),
                '1' => esc_html__('Column 1', 'bestbalitravel'),
                '2' => esc_html__('Column 2', 'bestbalitravel'),
                '3' => esc_html__('Column 3', 'bestbalitravel'),
            ],
            'default' => 'none',
        ]);

        $this->add_control('enable_animation', [
            'label' => esc_html__('Enable Animation', 'bestbalitravel'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'default' => 'yes',
        ]);

        $this->end_controls_section();
    }

    private function get_tours_list()
    {
        $options = [];
        $tours = get_posts([
            'post_type' => 'tour',
            'posts_per_page' => -1,
            'post_status' => 'publish',
            'orderby' => 'title',
            'order' => 'ASC'
        ]);

        foreach ($tours as $tour) {
            $options[$tour->ID] = $tour->post_title;
        }

        return $options;
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $tours = $settings['tours'];
        $highlight = $settings['highlight_tour'];
        $animate = $settings['enable_animation'] === 'yes';

        if (empty($tours)) {
            echo '<p class="bbt-no-tours">' . esc_html__('Please select tours to compare.', 'bestbalitravel') . '</p>';
            return;
        }

        $tour_data = [];
        foreach ($tours as $tour) {
            if (!empty($tour['tour_id'])) {
                $id = $tour['tour_id'];
                $tour_data[] = [
                    'id' => $id,
                    'title' => get_the_title($id),
                    'price' => function_exists('bbt_get_tour_price') ? bbt_get_tour_price($id) : '',
                    'duration' => function_exists('bbt_get_tour_duration') ? bbt_get_tour_duration($id) : '',
                    'rating' => function_exists('bbt_get_tour_rating') ? bbt_get_tour_rating($id) : '',
                    'image' => get_the_post_thumbnail_url($id, 'medium') ?: 'https://images.unsplash.com/photo-1555400038-63f5ba517a47?w=400',
                    'highlights' => function_exists('bbt_get_tour_highlights') ? bbt_get_tour_highlights($id) : [],
                    'link' => get_permalink($id),
                ];
            }
        }

        if (empty($tour_data))
            return;
        ?>
        <div class="bbt-tour-comparison<?php echo $animate ? ' bbt-anim-on' : ''; ?>">
            <div class="bbt-comparison-grid" style="--column-count: <?php echo count($tour_data); ?>">
                <?php foreach ($tour_data as $index => $tour):
                    $is_highlighted = ($highlight !== 'none' && (int) $highlight === $index + 1);
                    ?>
                    <div class="bbt-comparison-column<?php echo $is_highlighted ? ' highlighted' : ''; ?>"
                        data-index="<?php echo $index; ?>">
                        <?php if ($is_highlighted): ?>
                            <div class="bbt-comparison-badge">Most Popular</div>
                        <?php endif; ?>

                        <div class="bbt-comparison-image">
                            <img src="<?php echo esc_url($tour['image']); ?>" alt="<?php echo esc_attr($tour['title']); ?>"
                                loading="lazy">
                        </div>

                        <div class="bbt-comparison-header"
                            style="background: <?php echo esc_attr($settings['header_bg_color']); ?>">
                            <h3>
                                <?php echo esc_html($tour['title']); ?>
                            </h3>
                        </div>

                        <div class="bbt-comparison-body">
                            <div class="bbt-comparison-row">
                                <span class="label">
                                    <?php esc_html_e('Price', 'bestbalitravel'); ?>
                                </span>
                                <span class="value price">
                                    <?php echo esc_html($tour['price']); ?>
                                </span>
                            </div>

                            <div class="bbt-comparison-row">
                                <span class="label">
                                    <?php esc_html_e('Duration', 'bestbalitravel'); ?>
                                </span>
                                <span class="value">
                                    <?php echo esc_html($tour['duration']); ?>
                                </span>
                            </div>

                            <div class="bbt-comparison-row">
                                <span class="label">
                                    <?php esc_html_e('Rating', 'bestbalitravel'); ?>
                                </span>
                                <span class="value rating">
                                    <?php echo str_repeat('★', (int) $tour['rating']); ?>
                                    <?php echo str_repeat('☆', 5 - (int) $tour['rating']); ?>
                                </span>
                            </div>

                            <?php if (!empty($tour['highlights'])): ?>
                                <div class="bbt-comparison-highlights">
                                    <ul>
                                        <?php foreach (array_slice($tour['highlights'], 0, 3) as $h): ?>
                                            <li><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2">
                                                    <polyline points="20 6 9 17 4 12"></polyline>
                                                </svg>
                                                <?php echo esc_html($h); ?>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="bbt-comparison-footer">
                            <a href="<?php echo esc_url($tour['link']); ?>" class="bbt-btn bbt-btn-primary">
                                <?php esc_html_e('View Details', 'bestbalitravel'); ?>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <style>
            .bbt-tour-comparison {
                padding: 20px 0;
            }

            .bbt-comparison-grid {
                display: grid;
                grid-template-columns: repeat(var(--column-count, 3), 1fr);
                gap: 24px;
            }

            .bbt-comparison-column {
                background: #fff;
                border-radius: 16px;
                overflow: hidden;
                box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
                transition: all 0.4s ease;
                position: relative;
            }

            .bbt-comparison-column:hover {
                transform: translateY(-10px);
                box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
            }

            .bbt-comparison-column.highlighted {
                border: 3px solid #F5A623;
                transform: scale(1.05);
                z-index: 2;
            }

            .bbt-comparison-badge {
                position: absolute;
                top: 15px;
                left: 50%;
                transform: translateX(-50%);
                background: linear-gradient(135deg, #F5A623, #FFD93D);
                color: #000;
                padding: 6px 16px;
                border-radius: 20px;
                font-size: 12px;
                font-weight: 700;
                z-index: 10;
            }

            .bbt-comparison-image img {
                width: 100%;
                height: 180px;
                object-fit: cover;
            }

            .bbt-comparison-header {
                padding: 20px;
                text-align: center;
                color: #fff;
            }

            .bbt-comparison-header h3 {
                margin: 0;
                font-size: 18px;
                font-weight: 700;
                color: inherit;
            }

            .bbt-comparison-body {
                padding: 20px;
            }

            .bbt-comparison-row {
                display: flex;
                justify-content: space-between;
                padding: 12px 0;
                border-bottom: 1px solid #eee;
            }

            .bbt-comparison-row:last-child {
                border-bottom: none;
            }

            .bbt-comparison-row .label {
                color: #666;
                font-size: 14px;
            }

            .bbt-comparison-row .value {
                font-weight: 600;
                color: #1a1a1a;
            }

            .bbt-comparison-row .value.price {
                color: #F5A623;
                font-size: 18px;
            }

            .bbt-comparison-row .value.rating {
                color: #F5A623;
            }

            .bbt-comparison-highlights ul {
                list-style: none;
                padding: 0;
                margin: 15px 0 0;
            }

            .bbt-comparison-highlights li {
                display: flex;
                align-items: center;
                gap: 8px;
                padding: 6px 0;
                font-size: 13px;
                color: #4a4a4a;
            }

            .bbt-comparison-highlights svg {
                color: #10B981;
                flex-shrink: 0;
            }

            .bbt-comparison-footer {
                padding: 20px;
                text-align: center;
                background: #f9f9f9;
            }

            .bbt-comparison-footer .bbt-btn {
                width: 100%;
                justify-content: center;
            }

            /* Animation */
            .bbt-anim-on .bbt-comparison-column {
                opacity: 0;
                transform: translateY(30px);
                animation: bbtCompareSlide 0.6s ease forwards;
            }

            .bbt-anim-on .bbt-comparison-column:nth-child(1) {
                animation-delay: 0.1s;
            }

            .bbt-anim-on .bbt-comparison-column:nth-child(2) {
                animation-delay: 0.2s;
            }

            .bbt-anim-on .bbt-comparison-column:nth-child(3) {
                animation-delay: 0.3s;
            }

            .bbt-anim-on .bbt-comparison-column:nth-child(4) {
                animation-delay: 0.4s;
            }

            @keyframes bbtCompareSlide {
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            @media (max-width: 768px) {
                .bbt-comparison-grid {
                    grid-template-columns: 1fr;
                }

                .bbt-comparison-column.highlighted {
                    transform: none;
                }
            }
        </style>
        <?php
    }
}
