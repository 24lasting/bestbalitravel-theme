<?php
/**
 * Elementor Testimonials Widget
 *
 * @package BestBaliTravel
 */

if (!defined('ABSPATH')) {
    exit;
}

class BBT_Widget_Testimonials extends \Elementor\Widget_Base
{

    public function get_name()
    {
        return 'bbt-testimonials';
    }

    public function get_title()
    {
        return esc_html__('BBT Testimonials', 'bestbalitravel');
    }

    public function get_icon()
    {
        return 'eicon-testimonial';
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
                'label' => esc_html__('Testimonials', 'bestbalitravel'),
            )
        );

        $this->add_control(
            'source',
            array(
                'label' => esc_html__('Source', 'bestbalitravel'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'reviews',
                'options' => array(
                    'reviews' => esc_html__('From Reviews', 'bestbalitravel'),
                    'manual' => esc_html__('Manual Entry', 'bestbalitravel'),
                ),
            )
        );

        $this->add_control(
            'limit',
            array(
                'label' => esc_html__('Number of Testimonials', 'bestbalitravel'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 5,
                'condition' => array('source' => 'reviews'),
            )
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'name',
            array(
                'label' => esc_html__('Name', 'bestbalitravel'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => 'John Doe',
            )
        );

        $repeater->add_control(
            'location',
            array(
                'label' => esc_html__('Location', 'bestbalitravel'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => 'Australia',
            )
        );

        $repeater->add_control(
            'content',
            array(
                'label' => esc_html__('Review', 'bestbalitravel'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => 'Amazing experience! The tour was well organized and our guide was fantastic.',
            )
        );

        $repeater->add_control(
            'rating',
            array(
                'label' => esc_html__('Rating', 'bestbalitravel'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '5',
                'options' => array(
                    '5' => '★★★★★ (5)',
                    '4' => '★★★★☆ (4)',
                    '3' => '★★★☆☆ (3)',
                ),
            )
        );

        $repeater->add_control(
            'image',
            array(
                'label' => esc_html__('Photo', 'bestbalitravel'),
                'type' => \Elementor\Controls_Manager::MEDIA,
            )
        );

        $this->add_control(
            'testimonials',
            array(
                'label' => esc_html__('Testimonials', 'bestbalitravel'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => array(
                    array(
                        'name' => 'Sarah Johnson',
                        'location' => 'United States',
                        'content' => 'Best tour experience ever! The sunrise at Mount Batur was absolutely breathtaking.',
                        'rating' => '5',
                    ),
                ),
                'condition' => array('source' => 'manual'),
            )
        );

        $this->add_control(
            'style',
            array(
                'label' => esc_html__('Style', 'bestbalitravel'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'slider',
                'options' => array(
                    'slider' => esc_html__('Slider', 'bestbalitravel'),
                    'grid' => esc_html__('Grid', 'bestbalitravel'),
                    'masonry' => esc_html__('Masonry', 'bestbalitravel'),
                ),
            )
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $testimonials = array();

        if ('reviews' === $settings['source']) {
            $reviews = get_posts(array(
                'post_type' => 'review',
                'posts_per_page' => $settings['limit'],
                'orderby' => 'date',
                'order' => 'DESC',
            ));

            foreach ($reviews as $review) {
                $testimonials[] = array(
                    'name' => get_post_meta($review->ID, '_bbt_reviewer_name', true),
                    'location' => get_post_meta($review->ID, '_bbt_reviewer_location', true),
                    'content' => $review->post_content,
                    'rating' => get_post_meta($review->ID, '_bbt_review_rating', true),
                    'image' => get_the_post_thumbnail_url($review->ID, 'thumbnail'),
                );
            }
        } else {
            $testimonials = $settings['testimonials'];
        }

        if (empty($testimonials)) {
            return;
        }
        ?>

        <div class="bbt-testimonials bbt-testimonials-<?php echo esc_attr($settings['style']); ?>">
            <?php if ('slider' === $settings['style']): ?>
                <div class="bbt-testimonial-slider swiper">
                    <div class="swiper-wrapper">
                        <?php foreach ($testimonials as $testimonial): ?>
                            <div class="swiper-slide bbt-testimonial-slide">
                                <?php $this->render_testimonial($testimonial); ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            <?php else: ?>
                <div class="bbt-testimonial-grid">
                    <?php foreach ($testimonials as $testimonial): ?>
                        <?php $this->render_testimonial($testimonial); ?>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <?php
    }

    private function render_testimonial($testimonial)
    {
        ?>
        <div class="bbt-testimonial-card">
            <div class="bbt-testimonial-quote">
                <svg width="40" height="40" viewBox="0 0 24 24" fill="currentColor" opacity="0.2">
                    <path d="M6 17h3l2-4V7H5v6h3zm8 0h3l2-4V7h-6v6h3z" />
                </svg>
            </div>

            <div class="bbt-testimonial-rating">
                <?php for ($i = 1; $i <= 5; $i++): ?>
                    <span class="bbt-star <?php echo $i <= intval($testimonial['rating']) ? 'filled' : ''; ?>">★</span>
                <?php endfor; ?>
            </div>

            <p class="bbt-testimonial-content">
                "
                <?php echo esc_html($testimonial['content']); ?>"
            </p>

            <div class="bbt-testimonial-author">
                <?php if (!empty($testimonial['image'])):
                    $image_url = is_array($testimonial['image']) ? $testimonial['image']['url'] : $testimonial['image'];
                    ?>
                    <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($testimonial['name']); ?>"
                        class="bbt-author-image">
                <?php else: ?>
                    <div class="bbt-author-initials">
                        <?php echo esc_html(strtoupper(substr($testimonial['name'], 0, 1))); ?>
                    </div>
                <?php endif; ?>

                <div class="bbt-author-info">
                    <strong class="bbt-author-name">
                        <?php echo esc_html($testimonial['name']); ?>
                    </strong>
                    <?php if (!empty($testimonial['location'])): ?>
                        <span class="bbt-author-location">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" />
                                <circle cx="12" cy="10" r="3" />
                            </svg>
                            <?php echo esc_html($testimonial['location']); ?>
                        </span>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php
    }
}
