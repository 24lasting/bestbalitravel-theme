<?php
/**
 * Elementor Tour Card Widget
 *
 * @package BestBaliTravel
 */

if (!defined('ABSPATH')) {
    exit;
}

class BBT_Widget_Tour_Card extends \Elementor\Widget_Base
{

    public function get_name()
    {
        return 'bbt-tour-card';
    }

    public function get_title()
    {
        return esc_html__('BBT Tour Card', 'bestbalitravel');
    }

    public function get_icon()
    {
        return 'eicon-image-box';
    }

    public function get_categories()
    {
        return array('bbt-widgets');
    }

    public function get_keywords()
    {
        return array('tour', 'card', 'package', 'travel', 'bali');
    }

    protected function register_controls()
    {
        // Content Section
        $this->start_controls_section(
            'section_tour',
            array(
                'label' => esc_html__('Tour Selection', 'bestbalitravel'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            )
        );

        $this->add_control(
            'tour_source',
            array(
                'label' => esc_html__('Source', 'bestbalitravel'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'select',
                'options' => array(
                    'select' => esc_html__('Select Tour', 'bestbalitravel'),
                    'current' => esc_html__('Current Post (for templates)', 'bestbalitravel'),
                ),
            )
        );

        // Get tours for dropdown
        $tours = get_posts(array(
            'post_type' => 'tour',
            'posts_per_page' => -1,
            'post_status' => 'publish',
        ));

        $tour_options = array('' => esc_html__('Select a tour', 'bestbalitravel'));
        foreach ($tours as $tour) {
            $tour_options[$tour->ID] = $tour->post_title;
        }

        $this->add_control(
            'tour_id',
            array(
                'label' => esc_html__('Select Tour', 'bestbalitravel'),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'options' => $tour_options,
                'condition' => array('tour_source' => 'select'),
            )
        );

        $this->end_controls_section();

        // Card Style
        $this->start_controls_section(
            'section_card_style',
            array(
                'label' => esc_html__('Card Style', 'bestbalitravel'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            )
        );

        $this->add_control(
            'card_style',
            array(
                'label' => esc_html__('Style', 'bestbalitravel'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'default',
                'options' => array(
                    'default' => esc_html__('Default', 'bestbalitravel'),
                    'overlay' => esc_html__('Overlay', 'bestbalitravel'),
                    'horizontal' => esc_html__('Horizontal', 'bestbalitravel'),
                    'minimal' => esc_html__('Minimal', 'bestbalitravel'),
                ),
            )
        );

        $this->add_control(
            'show_badge',
            array(
                'label' => esc_html__('Show Badge', 'bestbalitravel'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
            )
        );

        $this->add_control(
            'show_wishlist',
            array(
                'label' => esc_html__('Show Wishlist', 'bestbalitravel'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
            )
        );

        $this->add_control(
            'show_rating',
            array(
                'label' => esc_html__('Show Rating', 'bestbalitravel'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
            )
        );

        $this->add_control(
            'show_duration',
            array(
                'label' => esc_html__('Show Duration', 'bestbalitravel'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
            )
        );

        $this->add_control(
            'show_location',
            array(
                'label' => esc_html__('Show Location', 'bestbalitravel'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
            )
        );

        $this->end_controls_section();

        // Animation
        $this->start_controls_section(
            'section_animation',
            array(
                'label' => esc_html__('Animation', 'bestbalitravel'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            )
        );

        $this->add_control(
            'hover_animation',
            array(
                'label' => esc_html__('Hover Effect', 'bestbalitravel'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '3d-tilt',
                'options' => array(
                    'none' => esc_html__('None', 'bestbalitravel'),
                    'lift' => esc_html__('Lift Up', 'bestbalitravel'),
                    'zoom' => esc_html__('Zoom Image', 'bestbalitravel'),
                    '3d-tilt' => esc_html__('3D Tilt', 'bestbalitravel'),
                    'glow' => esc_html__('Glow', 'bestbalitravel'),
                ),
            )
        );

        $this->end_controls_section();

        // Style Tab
        $this->start_controls_section(
            'section_style',
            array(
                'label' => esc_html__('Card Style', 'bestbalitravel'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_control(
            'card_border_radius',
            array(
                'label' => esc_html__('Border Radius', 'bestbalitravel'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => array('px', '%'),
                'default' => array(
                    'top' => 16,
                    'right' => 16,
                    'bottom' => 16,
                    'left' => 16,
                    'unit' => 'px',
                ),
                'selectors' => array(
                    '{{WRAPPER}} .bbt-tour-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            array(
                'name' => 'card_shadow',
                'selector' => '{{WRAPPER}} .bbt-tour-card',
            )
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        // Get tour ID
        if ('current' === $settings['tour_source']) {
            $tour_id = get_the_ID();
        } else {
            $tour_id = $settings['tour_id'];
        }

        if (empty($tour_id)) {
            echo '<p>' . esc_html__('Please select a tour.', 'bestbalitravel') . '</p>';
            return;
        }

        $tour = get_post($tour_id);
        if (!$tour || 'tour' !== $tour->post_type) {
            return;
        }

        // Get tour data
        $price = get_post_meta($tour_id, '_bbt_tour_price', true);
        $sale_price = get_post_meta($tour_id, '_bbt_tour_sale_price', true);
        $duration = get_post_meta($tour_id, '_bbt_tour_duration', true);
        $duration_unit = get_post_meta($tour_id, '_bbt_tour_duration_unit', true);
        $locations = wp_get_post_terms($tour_id, 'tour_location');
        $types = wp_get_post_terms($tour_id, 'tour_type');

        $hover_class = 'bbt-hover-' . $settings['hover_animation'];
        $card_style = 'bbt-card-' . $settings['card_style'];
        ?>

        <div class="bbt-tour-card <?php echo esc_attr($card_style . ' ' . $hover_class); ?>"
            data-tour-id="<?php echo esc_attr($tour_id); ?>">
            <!-- Image Section -->
            <div class="bbt-card-image">
                <?php if (has_post_thumbnail($tour_id)): ?>
                    <img src="<?php echo esc_url(get_the_post_thumbnail_url($tour_id, 'bbt-tour-card')); ?>"
                        alt="<?php echo esc_attr($tour->post_title); ?>" loading="lazy">
                <?php else: ?>
                    <img src="<?php echo esc_url(BBT_THEME_ASSETS . '/images/placeholder-tour.jpg'); ?>"
                        alt="<?php echo esc_attr($tour->post_title); ?>">
                <?php endif; ?>

                <?php if ('yes' === $settings['show_badge'] && $sale_price): ?>
                    <span class="bbt-card-badge bbt-badge-sale">
                        <?php
                        $discount = round((($price - $sale_price) / $price) * 100);
                        echo esc_html($discount . '% OFF');
                        ?>
                    </span>
                <?php endif; ?>

                <?php if ('yes' === $settings['show_wishlist']): ?>
                    <button class="bbt-wishlist-btn" data-tour-id="<?php echo esc_attr($tour_id); ?>">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path
                                d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z" />
                        </svg>
                    </button>
                <?php endif; ?>

                <a href="<?php echo esc_url(get_permalink($tour_id)); ?>" class="bbt-card-overlay-link"
                    aria-label="<?php echo esc_attr($tour->post_title); ?>"></a>
            </div>

            <!-- Content Section -->
            <div class="bbt-card-content">
                <!-- Meta -->
                <div class="bbt-card-meta">
                    <?php if ('yes' === $settings['show_location'] && !empty($locations)): ?>
                        <span class="bbt-card-location">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" />
                                <circle cx="12" cy="10" r="3" />
                            </svg>
                            <?php echo esc_html($locations[0]->name); ?>
                        </span>
                    <?php endif; ?>

                    <?php if ('yes' === $settings['show_duration'] && $duration): ?>
                        <span class="bbt-card-duration">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10" />
                                <polyline points="12 6 12 12 16 14" />
                            </svg>
                            <?php echo esc_html($duration . ' ' . ucfirst($duration_unit)); ?>
                        </span>
                    <?php endif; ?>
                </div>

                <!-- Title -->
                <h3 class="bbt-card-title">
                    <a href="<?php echo esc_url(get_permalink($tour_id)); ?>">
                        <?php echo esc_html($tour->post_title); ?>
                    </a>
                </h3>

                <?php if ('yes' === $settings['show_rating']): ?>
                    <div class="bbt-card-rating">
                        <div class="bbt-stars">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <svg class="bbt-star <?php echo $i <= 5 ? 'filled' : ''; ?>" width="14" height="14" viewBox="0 0 24 24">
                                    <polygon fill="currentColor"
                                        points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" />
                                </svg>
                            <?php endfor; ?>
                        </div>
                        <span class="bbt-rating-count">(128 reviews)</span>
                    </div>
                <?php endif; ?>

                <!-- Price -->
                <div class="bbt-card-footer">
                    <div class="bbt-card-price">
                        <?php if ($sale_price): ?>
                            <span class="bbt-price-original">
                                <?php echo esc_html(bbt_format_price($price)); ?>
                            </span>
                            <span class="bbt-price-current">
                                <?php echo esc_html(bbt_format_price($sale_price)); ?>
                            </span>
                        <?php else: ?>
                            <span class="bbt-price-current">
                                <?php echo esc_html(bbt_format_price($price)); ?>
                            </span>
                        <?php endif; ?>
                        <span class="bbt-price-suffix">/person</span>
                    </div>

                    <a href="<?php echo esc_url(get_permalink($tour_id)); ?>" class="bbt-card-btn">
                        <?php esc_html_e('View Details', 'bestbalitravel'); ?>
                    </a>
                </div>
            </div>
        </div>

        <?php
    }
}
