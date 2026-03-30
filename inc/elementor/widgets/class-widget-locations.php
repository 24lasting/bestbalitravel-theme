<?php
/**
 * Elementor Location Cards Widget
 *
 * @package BestBaliTravel
 */

if (!defined('ABSPATH')) {
    exit;
}

class BBT_Widget_Locations extends \Elementor\Widget_Base
{

    public function get_name()
    {
        return 'bbt-locations';
    }

    public function get_title()
    {
        return esc_html__('BBT Location Cards', 'bestbalitravel');
    }

    public function get_icon()
    {
        return 'eicon-google-maps';
    }

    public function get_categories()
    {
        return array('bbt-widgets');
    }

    protected function register_controls()
    {
        $this->start_controls_section(
            'section_content',
            array(
                'label' => esc_html__('Locations', 'bestbalitravel'),
            )
        );

        $this->add_control(
            'source',
            array(
                'label' => esc_html__('Source', 'bestbalitravel'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'taxonomy',
                'options' => array(
                    'taxonomy' => esc_html__('From Taxonomy', 'bestbalitravel'),
                    'manual' => esc_html__('Manual Entry', 'bestbalitravel'),
                ),
            )
        );

        $this->add_control(
            'limit',
            array(
                'label' => esc_html__('Number of Locations', 'bestbalitravel'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 6,
                'condition' => array('source' => 'taxonomy'),
            )
        );

        $this->add_control(
            'orderby',
            array(
                'label' => esc_html__('Order By', 'bestbalitravel'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'count',
                'options' => array(
                    'name' => esc_html__('Name', 'bestbalitravel'),
                    'count' => esc_html__('Tour Count', 'bestbalitravel'),
                    'rand' => esc_html__('Random', 'bestbalitravel'),
                ),
                'condition' => array('source' => 'taxonomy'),
            )
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'name',
            array(
                'label' => esc_html__('Location Name', 'bestbalitravel'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => 'Ubud',
            )
        );

        $repeater->add_control(
            'description',
            array(
                'label' => esc_html__('Description', 'bestbalitravel'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => 'Cultural Heart of Bali',
            )
        );

        $repeater->add_control(
            'tour_count',
            array(
                'label' => esc_html__('Tour Count', 'bestbalitravel'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 25,
            )
        );

        $repeater->add_control(
            'image',
            array(
                'label' => esc_html__('Image', 'bestbalitravel'),
                'type' => \Elementor\Controls_Manager::MEDIA,
            )
        );

        $repeater->add_control(
            'link',
            array(
                'label' => esc_html__('Link', 'bestbalitravel'),
                'type' => \Elementor\Controls_Manager::URL,
            )
        );

        $this->add_control(
            'locations',
            array(
                'label' => esc_html__('Locations', 'bestbalitravel'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => array(
                    array('name' => 'Ubud', 'description' => 'Cultural Heart', 'tour_count' => 25),
                    array('name' => 'Seminyak', 'description' => 'Beach & Lifestyle', 'tour_count' => 18),
                    array('name' => 'Uluwatu', 'description' => 'Cliff & Temples', 'tour_count' => 12),
                ),
                'condition' => array('source' => 'manual'),
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
            'style',
            array(
                'label' => esc_html__('Style', 'bestbalitravel'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'grid',
                'options' => array(
                    'grid' => esc_html__('Grid', 'bestbalitravel'),
                    'masonry' => esc_html__('Masonry', 'bestbalitravel'),
                    'carousel' => esc_html__('Carousel', 'bestbalitravel'),
                ),
            )
        );

        $this->add_responsive_control(
            'columns',
            array(
                'label' => esc_html__('Columns', 'bestbalitravel'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '3',
                'options' => array(
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                    '6' => '6',
                ),
                'condition' => array('style!' => 'carousel'),
            )
        );

        $this->add_control(
            'card_style',
            array(
                'label' => esc_html__('Card Style', 'bestbalitravel'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'overlay',
                'options' => array(
                    'overlay' => esc_html__('Overlay', 'bestbalitravel'),
                    'below' => esc_html__('Content Below', 'bestbalitravel'),
                    'minimal' => esc_html__('Minimal', 'bestbalitravel'),
                ),
            )
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $locations = array();

        if ('taxonomy' === $settings['source']) {
            $terms = get_terms(array(
                'taxonomy' => 'tour_location',
                'hide_empty' => false,
                'number' => $settings['limit'],
                'orderby' => $settings['orderby'] === 'rand' ? 'rand' : $settings['orderby'],
                'order' => 'DESC',
            ));

            if (!is_wp_error($terms)) {
                foreach ($terms as $term) {
                    $image_id = get_term_meta($term->term_id, 'bbt_location_image', true);
                    $locations[] = array(
                        'name' => $term->name,
                        'description' => $term->description,
                        'tour_count' => $term->count,
                        'image' => $image_id ? wp_get_attachment_image_url($image_id, 'medium_large') : '',
                        'link' => get_term_link($term),
                    );
                }
            }
        } else {
            $locations = $settings['locations'];
        }

        if (empty($locations)) {
            return;
        }

        $columns = $settings['columns'] ?? '3';
        ?>

        <div
            class="bbt-locations bbt-locations-<?php echo esc_attr($settings['style']); ?> bbt-cols-<?php echo esc_attr($columns); ?>">
            <?php foreach ($locations as $location):
                $this->render_location_card($location, $settings['card_style']);
            endforeach; ?>
        </div>

        <?php
    }

    private function render_location_card($location, $style)
    {
        $image_url = is_array($location['image'] ?? null) ? $location['image']['url'] : ($location['image'] ?? '');
        $link = is_array($location['link'] ?? null) ? ($location['link']['url'] ?? '#') : ($location['link'] ?? '#');
        $tour_count = $location['tour_count'] ?? 0;
        ?>

        <a href="<?php echo esc_url($link); ?>" class="bbt-location-card bbt-card-<?php echo esc_attr($style); ?>">
            <div class="bbt-location-image">
                <?php if ($image_url): ?>
                    <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($location['name']); ?>">
                <?php else: ?>
                    <div class="bbt-location-placeholder">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" />
                            <circle cx="12" cy="10" r="3" />
                        </svg>
                    </div>
                <?php endif; ?>
                <div class="bbt-location-overlay"></div>
            </div>

            <div class="bbt-location-content">
                <h3 class="bbt-location-name">
                    <?php echo esc_html($location['name']); ?>
                </h3>

                <?php if (!empty($location['description'])): ?>
                    <p class="bbt-location-desc">
                        <?php echo esc_html($location['description']); ?>
                    </p>
                <?php endif; ?>

                <span class="bbt-location-count">
                    <?php echo esc_html($tour_count); ?>
                    <?php echo esc_html(_n('Tour', 'Tours', $tour_count, 'bestbalitravel')); ?>
                </span>
            </div>

            <span class="bbt-location-arrow">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="5" y1="12" x2="19" y2="12" />
                    <polyline points="12 5 19 12 12 19" />
                </svg>
            </span>
        </a>

        <?php
    }
}
