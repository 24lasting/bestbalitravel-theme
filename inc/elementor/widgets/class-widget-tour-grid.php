<?php
/**
 * Elementor Tour Grid Widget
 *
 * @package BestBaliTravel
 */

if (!defined('ABSPATH')) {
    exit;
}

class BBT_Widget_Tour_Grid extends \Elementor\Widget_Base
{

    public function get_name()
    {
        return 'bbt-tour-grid';
    }

    public function get_title()
    {
        return esc_html__('BBT Tour Grid', 'bestbalitravel');
    }

    public function get_icon()
    {
        return 'eicon-gallery-grid';
    }

    public function get_categories()
    {
        return array('bbt-widgets');
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
                'label' => esc_html__('Tours to Show', 'bestbalitravel'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 6,
                'min' => 1,
                'max' => 24,
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
                    'price' => esc_html__('Price', 'bestbalitravel'),
                    'popularity' => esc_html__('Popularity', 'bestbalitravel'),
                    'rand' => esc_html__('Random', 'bestbalitravel'),
                ),
            )
        );

        $this->add_control(
            'order',
            array(
                'label' => esc_html__('Order', 'bestbalitravel'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'DESC',
                'options' => array(
                    'ASC' => esc_html__('Ascending', 'bestbalitravel'),
                    'DESC' => esc_html__('Descending', 'bestbalitravel'),
                ),
            )
        );

        // Get locations
        $locations = get_terms(array('taxonomy' => 'tour_location', 'hide_empty' => false));
        $location_options = array('' => esc_html__('All Locations', 'bestbalitravel'));
        foreach ($locations as $location) {
            $location_options[$location->slug] = $location->name;
        }

        $this->add_control(
            'filter_location',
            array(
                'label' => esc_html__('Filter by Location', 'bestbalitravel'),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'multiple' => true,
                'options' => $location_options,
            )
        );

        // Get types
        $types = get_terms(array('taxonomy' => 'tour_type', 'hide_empty' => false));
        $type_options = array('' => esc_html__('All Types', 'bestbalitravel'));
        foreach ($types as $type) {
            $type_options[$type->slug] = $type->name;
        }

        $this->add_control(
            'filter_type',
            array(
                'label' => esc_html__('Filter by Type', 'bestbalitravel'),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'multiple' => true,
                'options' => $type_options,
            )
        );

        $this->add_control(
            'show_featured_only',
            array(
                'label' => esc_html__('Featured Tours Only', 'bestbalitravel'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
            )
        );

        $this->end_controls_section();

        // Layout Section
        $this->start_controls_section(
            'section_layout',
            array(
                'label' => esc_html__('Layout', 'bestbalitravel'),
            )
        );

        $this->add_control(
            'layout',
            array(
                'label' => esc_html__('Layout', 'bestbalitravel'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'grid',
                'options' => array(
                    'grid' => esc_html__('Grid', 'bestbalitravel'),
                    'masonry' => esc_html__('Masonry', 'bestbalitravel'),
                    'list' => esc_html__('List', 'bestbalitravel'),
                ),
            )
        );

        $this->add_responsive_control(
            'columns',
            array(
                'label' => esc_html__('Columns', 'bestbalitravel'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '3',
                'tablet_default' => '2',
                'mobile_default' => '1',
                'options' => array(
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                ),
                'selectors' => array(
                    '{{WRAPPER}} .bbt-tour-grid' => 'grid-template-columns: repeat({{VALUE}}, 1fr);',
                ),
                'condition' => array('layout!' => 'list'),
            )
        );

        $this->add_control(
            'gap',
            array(
                'label' => esc_html__('Gap', 'bestbalitravel'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'default' => array('size' => 30),
                'range' => array('px' => array('min' => 0, 'max' => 60)),
                'selectors' => array(
                    '{{WRAPPER}} .bbt-tour-grid' => 'gap: {{SIZE}}px;',
                ),
            )
        );

        $this->end_controls_section();

        // Filter Bar
        $this->start_controls_section(
            'section_filter',
            array(
                'label' => esc_html__('Filter Bar', 'bestbalitravel'),
            )
        );

        $this->add_control(
            'show_filter',
            array(
                'label' => esc_html__('Show Filter Bar', 'bestbalitravel'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
            )
        );

        $this->add_control(
            'filter_style',
            array(
                'label' => esc_html__('Filter Style', 'bestbalitravel'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'tabs',
                'options' => array(
                    'tabs' => esc_html__('Tabs', 'bestbalitravel'),
                    'dropdown' => esc_html__('Dropdown', 'bestbalitravel'),
                    'pills' => esc_html__('Pills', 'bestbalitravel'),
                ),
                'condition' => array('show_filter' => 'yes'),
            )
        );

        $this->add_control(
            'ajax_filter',
            array(
                'label' => esc_html__('AJAX Filtering', 'bestbalitravel'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
                'description' => esc_html__('Filter without page reload', 'bestbalitravel'),
                'condition' => array('show_filter' => 'yes'),
            )
        );

        $this->end_controls_section();

        // Pagination
        $this->start_controls_section(
            'section_pagination',
            array(
                'label' => esc_html__('Pagination', 'bestbalitravel'),
            )
        );

        $this->add_control(
            'pagination',
            array(
                'label' => esc_html__('Pagination', 'bestbalitravel'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'load_more',
                'options' => array(
                    'none' => esc_html__('None', 'bestbalitravel'),
                    'numbers' => esc_html__('Numbers', 'bestbalitravel'),
                    'load_more' => esc_html__('Load More Button', 'bestbalitravel'),
                    'infinite' => esc_html__('Infinite Scroll', 'bestbalitravel'),
                ),
            )
        );

        $this->end_controls_section();

        // Animation
        $this->start_controls_section(
            'section_animation',
            array(
                'label' => esc_html__('Animation', 'bestbalitravel'),
            )
        );

        $this->add_control(
            'entrance_animation',
            array(
                'label' => esc_html__('Entrance Animation', 'bestbalitravel'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'fade-up',
                'options' => array(
                    'none' => esc_html__('None', 'bestbalitravel'),
                    'fade' => esc_html__('Fade', 'bestbalitravel'),
                    'fade-up' => esc_html__('Fade Up', 'bestbalitravel'),
                    'fade-down' => esc_html__('Fade Down', 'bestbalitravel'),
                    'zoom-in' => esc_html__('Zoom In', 'bestbalitravel'),
                    'flip' => esc_html__('Flip', 'bestbalitravel'),
                ),
            )
        );

        $this->add_control(
            'stagger_delay',
            array(
                'label' => esc_html__('Stagger Delay (ms)', 'bestbalitravel'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 100,
                'condition' => array('entrance_animation!' => 'none'),
            )
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        // Build query
        $args = array(
            'post_type' => 'tour',
            'posts_per_page' => $settings['posts_per_page'],
            'post_status' => 'publish',
            'order' => $settings['order'],
        );

        // Order by
        switch ($settings['orderby']) {
            case 'price':
                $args['meta_key'] = '_bbt_tour_price';
                $args['orderby'] = 'meta_value_num';
                break;
            case 'popularity':
                $args['meta_key'] = '_bbt_tour_views';
                $args['orderby'] = 'meta_value_num';
                break;
            default:
                $args['orderby'] = $settings['orderby'];
        }

        // Location filter
        if (!empty($settings['filter_location'])) {
            $args['tax_query'][] = array(
                'taxonomy' => 'tour_location',
                'field' => 'slug',
                'terms' => $settings['filter_location'],
            );
        }

        // Type filter
        if (!empty($settings['filter_type'])) {
            $args['tax_query'][] = array(
                'taxonomy' => 'tour_type',
                'field' => 'slug',
                'terms' => $settings['filter_type'],
            );
        }

        // Featured only
        if ('yes' === $settings['show_featured_only']) {
            $args['meta_query'][] = array(
                'key' => '_bbt_tour_featured',
                'value' => '1',
            );
        }

        $query = new WP_Query($args);

        $layout_class = 'bbt-layout-' . $settings['layout'];
        $animation_class = 'bbt-anim-' . $settings['entrance_animation'];
        ?>

        <div class="bbt-tour-grid-wrapper" data-stagger="<?php echo esc_attr($settings['stagger_delay']); ?>">

            <?php if ('yes' === $settings['show_filter']): ?>
                <div class="bbt-grid-filter bbt-filter-<?php echo esc_attr($settings['filter_style']); ?>">
                    <?php
                    $filter_terms = get_terms(array('taxonomy' => 'tour_type', 'hide_empty' => true));
                    ?>
                    <button class="bbt-filter-btn active" data-filter="*">
                        <?php esc_html_e('All', 'bestbalitravel'); ?>
                    </button>
                    <?php foreach ($filter_terms as $term): ?>
                        <button class="bbt-filter-btn" data-filter="<?php echo esc_attr($term->slug); ?>">
                            <?php echo esc_html($term->name); ?>
                        </button>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <div class="bbt-tour-grid <?php echo esc_attr($layout_class . ' ' . $animation_class); ?>">
                <?php
                if ($query->have_posts()):
                    $index = 0;
                    while ($query->have_posts()):
                        $query->the_post();
                        $delay = $index * intval($settings['stagger_delay']);
                        ?>
                        <div class="bbt-grid-item" style="animation-delay: <?php echo esc_attr($delay); ?>ms;">
                            <?php bbt_tour_card(); ?>
                        </div>
                        <?php
                        $index++;
                    endwhile;
                    wp_reset_postdata();
                else:
                    ?>
                    <div class="bbt-no-tours">
                        <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1">
                            <circle cx="12" cy="12" r="10" />
                            <path d="M16 16s-1.5-2-4-2-4 2-4 2" />
                            <line x1="9" y1="9" x2="9.01" y2="9" />
                            <line x1="15" y1="9" x2="15.01" y2="9" />
                        </svg>
                        <p>
                            <?php esc_html_e('No tours found matching your criteria.', 'bestbalitravel'); ?>
                        </p>
                    </div>
                <?php endif; ?>
            </div>

            <?php if ('load_more' === $settings['pagination'] && $query->max_num_pages > 1): ?>
                <div class="bbt-load-more-wrap">
                    <button class="bbt-load-more-btn" data-page="1" data-max="<?php echo esc_attr($query->max_num_pages); ?>">
                        <span class="bbt-btn-text">
                            <?php esc_html_e('Load More Tours', 'bestbalitravel'); ?>
                        </span>
                        <span class="bbt-btn-loading">
                            <svg class="bbt-spinner" width="20" height="20" viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3" fill="none"
                                    stroke-dasharray="30 70" />
                            </svg>
                        </span>
                    </button>
                </div>
            <?php endif; ?>

        </div>

        <?php
    }
}
