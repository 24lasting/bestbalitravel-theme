<?php
/**
 * Elementor Tour Carousel Widget
 *
 * @package BestBaliTravel
 */

if (!defined('ABSPATH')) {
    exit;
}

class BBT_Widget_Tour_Carousel extends \Elementor\Widget_Base
{

    public function get_name()
    {
        return 'bbt-tour-carousel';
    }

    public function get_title()
    {
        return esc_html__('BBT Tour Carousel', 'bestbalitravel');
    }

    public function get_icon()
    {
        return 'eicon-slider-push';
    }

    public function get_categories()
    {
        return array('bbt-widgets');
    }

    public function get_script_depends()
    {
        return array('swiper');
    }

    protected function register_controls()
    {
        // Query Section
        $this->start_controls_section(
            'section_query',
            array(
                'label' => esc_html__('Query', 'bestbalitravel'),
            )
        );

        $this->add_control(
            'posts_per_page',
            array(
                'label' => esc_html__('Number of Tours', 'bestbalitravel'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 8,
                'min' => 1,
                'max' => 20,
            )
        );

        $this->add_control(
            'orderby',
            array(
                'label' => esc_html__('Order By', 'bestbalitravel'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'date',
                'options' => array(
                    'date' => esc_html__('Date', 'bestbalitravel'),
                    'title' => esc_html__('Title', 'bestbalitravel'),
                    'rand' => esc_html__('Random', 'bestbalitravel'),
                    'menu_order' => esc_html__('Menu Order', 'bestbalitravel'),
                ),
            )
        );

        $this->add_control(
            'featured_only',
            array(
                'label' => esc_html__('Featured Only', 'bestbalitravel'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'no',
            )
        );

        $this->end_controls_section();

        // Carousel Section
        $this->start_controls_section(
            'section_carousel',
            array(
                'label' => esc_html__('Carousel Settings', 'bestbalitravel'),
            )
        );

        $this->add_control(
            'slides_per_view',
            array(
                'label' => esc_html__('Slides Per View', 'bestbalitravel'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 3,
                'min' => 1,
                'max' => 6,
            )
        );

        $this->add_control(
            'slides_per_view_tablet',
            array(
                'label' => esc_html__('Slides Per View (Tablet)', 'bestbalitravel'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 2,
            )
        );

        $this->add_control(
            'slides_per_view_mobile',
            array(
                'label' => esc_html__('Slides Per View (Mobile)', 'bestbalitravel'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 1,
            )
        );

        $this->add_control(
            'space_between',
            array(
                'label' => esc_html__('Space Between (px)', 'bestbalitravel'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 30,
            )
        );

        $this->add_control(
            'autoplay',
            array(
                'label' => esc_html__('Autoplay', 'bestbalitravel'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
            )
        );

        $this->add_control(
            'autoplay_speed',
            array(
                'label' => esc_html__('Autoplay Speed (ms)', 'bestbalitravel'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 5000,
                'condition' => array('autoplay' => 'yes'),
            )
        );

        $this->add_control(
            'loop',
            array(
                'label' => esc_html__('Infinite Loop', 'bestbalitravel'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
            )
        );

        $this->add_control(
            'show_navigation',
            array(
                'label' => esc_html__('Show Navigation', 'bestbalitravel'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
            )
        );

        $this->add_control(
            'show_pagination',
            array(
                'label' => esc_html__('Show Pagination', 'bestbalitravel'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
            )
        );

        $this->add_control(
            'center_slides',
            array(
                'label' => esc_html__('Centered Slides', 'bestbalitravel'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'no',
            )
        );

        $this->end_controls_section();

        // Card Style Section
        $this->start_controls_section(
            'section_card_style',
            array(
                'label' => esc_html__('Card Style', 'bestbalitravel'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
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
                    'minimal' => esc_html__('Minimal', 'bestbalitravel'),
                ),
            )
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $args = array(
            'post_type' => 'tour',
            'posts_per_page' => $settings['posts_per_page'],
            'orderby' => $settings['orderby'],
            'order' => 'DESC',
        );

        if ('yes' === $settings['featured_only']) {
            $args['meta_query'] = array(
                array(
                    'key' => '_bbt_featured',
                    'value' => '1',
                ),
            );
        }

        $tours = new WP_Query($args);

        if (!$tours->have_posts()) {
            return;
        }

        $carousel_id = 'bbt-carousel-' . $this->get_id();
        $carousel_settings = array(
            'slidesPerView' => intval($settings['slides_per_view']),
            'spaceBetween' => intval($settings['space_between']),
            'loop' => 'yes' === $settings['loop'],
            'centeredSlides' => 'yes' === $settings['center_slides'],
            'breakpoints' => array(
                320 => array('slidesPerView' => intval($settings['slides_per_view_mobile'])),
                768 => array('slidesPerView' => intval($settings['slides_per_view_tablet'])),
                1024 => array('slidesPerView' => intval($settings['slides_per_view'])),
            ),
        );

        if ('yes' === $settings['autoplay']) {
            $carousel_settings['autoplay'] = array(
                'delay' => intval($settings['autoplay_speed']),
                'disableOnInteraction' => false,
            );
        }

        if ('yes' === $settings['show_navigation']) {
            $carousel_settings['navigation'] = array(
                'nextEl' => '#' . $carousel_id . ' .swiper-button-next',
                'prevEl' => '#' . $carousel_id . ' .swiper-button-prev',
            );
        }

        if ('yes' === $settings['show_pagination']) {
            $carousel_settings['pagination'] = array(
                'el' => '#' . $carousel_id . ' .swiper-pagination',
                'clickable' => true,
            );
        }
        ?>

        <div id="<?php echo esc_attr($carousel_id); ?>" class="bbt-tour-carousel">
            <div class="swiper" data-swiper='<?php echo wp_json_encode($carousel_settings); ?>'>
                <div class="swiper-wrapper">
                    <?php while ($tours->have_posts()):
                        $tours->the_post(); ?>
                        <div class="swiper-slide">
                            <?php $this->render_tour_card($settings['card_style']); ?>
                        </div>
                    <?php endwhile;
                    wp_reset_postdata(); ?>
                </div>

                <?php if ('yes' === $settings['show_pagination']): ?>
                    <div class="swiper-pagination"></div>
                <?php endif; ?>
            </div>

            <?php if ('yes' === $settings['show_navigation']): ?>
                <button class="swiper-button-prev bbt-nav-btn" aria-label="Previous">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="15 18 9 12 15 6" />
                    </svg>
                </button>
                <button class="swiper-button-next bbt-nav-btn" aria-label="Next">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="9 18 15 12 9 6" />
                    </svg>
                </button>
            <?php endif; ?>
        </div>

        <?php
    }

    private function render_tour_card($style = 'default')
    {
        $tour_id = get_the_ID();
        $price = get_post_meta($tour_id, '_bbt_tour_price', true);
        $sale_price = get_post_meta($tour_id, '_bbt_tour_sale_price', true);
        $duration = get_post_meta($tour_id, '_bbt_tour_duration', true);
        $rating = get_post_meta($tour_id, '_bbt_tour_rating', true);
        $locations = get_the_terms($tour_id, 'tour_location');
        ?>

        <article class="bbt-tour-card bbt-card-style-<?php echo esc_attr($style); ?>">
            <a href="<?php the_permalink(); ?>" class="bbt-card-link">
                <div class="bbt-card-image">
                    <?php if (has_post_thumbnail()): ?>
                        <?php the_post_thumbnail('bbt-tour-card'); ?>
                    <?php endif; ?>

                    <?php if ($sale_price && $price):
                        $discount = round((($price - $sale_price) / $price) * 100);
                        ?>
                        <span class="bbt-card-badge">-
                            <?php echo esc_html($discount); ?>%
                        </span>
                    <?php endif; ?>
                </div>

                <div class="bbt-card-content">
                    <?php if ($locations && !is_wp_error($locations)): ?>
                        <span class="bbt-card-location">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" />
                                <circle cx="12" cy="10" r="3" />
                            </svg>
                            <?php echo esc_html($locations[0]->name); ?>
                        </span>
                    <?php endif; ?>

                    <h3 class="bbt-card-title">
                        <?php the_title(); ?>
                    </h3>

                    <div class="bbt-card-meta">
                        <?php if ($duration): ?>
                            <span class="bbt-meta-duration">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="12" cy="12" r="10" />
                                    <polyline points="12 6 12 12 16 14" />
                                </svg>
                                <?php echo esc_html($duration); ?>
                            </span>
                        <?php endif; ?>

                        <?php if ($rating): ?>
                            <span class="bbt-meta-rating">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                                    <polygon
                                        points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" />
                                </svg>
                                <?php echo esc_html($rating); ?>
                            </span>
                        <?php endif; ?>
                    </div>

                    <div class="bbt-card-footer">
                        <div class="bbt-card-price">
                            <?php if ($sale_price): ?>
                                <span class="bbt-price-original">
                                    <?php echo esc_html(bbt_format_price($price)); ?>
                                </span>
                            <?php endif; ?>
                            <span class="bbt-price-current">
                                <?php echo esc_html(bbt_format_price($sale_price ?: $price)); ?>
                            </span>
                        </div>
                    </div>
                </div>
            </a>
        </article>

        <?php
    }
}
