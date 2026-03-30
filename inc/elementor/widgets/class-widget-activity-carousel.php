<?php
/**
 * Elementor Activity Carousel Widget
 * @package BestBaliTravel
 */
if (!defined('ABSPATH'))
    exit;

class BBT_Widget_Activity_Carousel extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'bbt-activity-carousel';
    }
    public function get_title()
    {
        return esc_html__('Activity Carousel', 'bestbalitravel');
    }
    public function get_icon()
    {
        return 'eicon-slider-push';
    }
    public function get_categories()
    {
        return ['bbt-widgets'];
    }

    protected function register_controls()
    {
        $this->start_controls_section('section_content', ['label' => 'Settings']);
        $this->add_control('posts_per_page', ['label' => 'Number', 'type' => \Elementor\Controls_Manager::NUMBER, 'default' => 6]);
        $this->add_control('autoplay', ['label' => 'Autoplay', 'type' => \Elementor\Controls_Manager::SWITCHER, 'default' => 'yes']);
        $this->add_control('show_nav', ['label' => 'Show Navigation', 'type' => \Elementor\Controls_Manager::SWITCHER, 'default' => 'yes']);
        $this->end_controls_section();
    }

    protected function render()
    {
        $s = $this->get_settings_for_display();
        $query = new \WP_Query(['post_type' => 'tour', 'posts_per_page' => $s['posts_per_page']]);
        $id = 'ac-' . uniqid();
        ?>
        <div class="bbt-activity-carousel" id="<?php echo $id; ?>">
            <div class="bbt-ac-track">
                <?php if ($query->have_posts()):
                    while ($query->have_posts()):
                        $query->the_post();
                        $price = function_exists('bbt_get_tour_price') ? bbt_get_tour_price() : 'Rp 450,000';
                        $rating = function_exists('bbt_get_tour_rating') ? bbt_get_tour_rating() : '4.8';
                        ?>
                        <div class="bbt-ac-slide">
                            <div class="bbt-ac-img">
                                <?php if (has_post_thumbnail())
                                    the_post_thumbnail('medium_large');
                                else
                                    echo '<img src="https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=600">'; ?>
                                <span class="bbt-ac-rating">⭐
                                    <?php echo esc_html($rating); ?>
                                </span>
                            </div>
                            <div class="bbt-ac-info">
                                <h4><a href="<?php the_permalink(); ?>">
                                        <?php the_title(); ?>
                                    </a></h4>
                                <span class="bbt-ac-price">
                                    <?php echo esc_html($price); ?>
                                </span>
                            </div>
                        </div>
                    <?php endwhile;
                    wp_reset_postdata(); endif; ?>
            </div>
            <?php if ($s['show_nav'] === 'yes'): ?>
                <button class="bbt-ac-prev"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M15 18l-6-6 6-6" />
                    </svg></button>
                <button class="bbt-ac-next"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M9 18l6-6-6-6" />
                    </svg></button>
            <?php endif; ?>
        </div>
        <style>
            .bbt-activity-carousel {
                position: relative;
                overflow: hidden;
                padding: 20px 0
            }

            .bbt-ac-track {
                display: flex;
                gap: 25px;
                overflow-x: auto;
                scroll-snap-type: x mandatory;
                scrollbar-width: none;
                padding: 10px
            }

            .bbt-ac-track::-webkit-scrollbar {
                display: none
            }

            .bbt-ac-slide {
                flex: 0 0 320px;
                background: #fff;
                border-radius: 20px;
                overflow: hidden;
                box-shadow: 0 10px 40px rgba(0, 0, 0, .08);
                scroll-snap-align: start;
                transition: transform .3s ease
            }

            .bbt-ac-slide:hover {
                transform: translateY(-8px)
            }

            .bbt-ac-img {
                position: relative;
                height: 200px
            }

            .bbt-ac-img img {
                width: 100%;
                height: 100%;
                object-fit: cover
            }

            .bbt-ac-rating {
                position: absolute;
                top: 12px;
                right: 12px;
                background: rgba(0, 0, 0, .7);
                color: #fff;
                padding: 5px 12px;
                border-radius: 20px;
                font-size: 12px;
                font-weight: 600
            }

            .bbt-ac-info {
                padding: 18px
            }

            .bbt-ac-info h4 {
                margin: 0 0 8px;
                font-size: 16px
            }

            .bbt-ac-info h4 a {
                color: inherit;
                text-decoration: none
            }

            .bbt-ac-price {
                font-size: 18px;
                font-weight: 700;
                color: #F5A623
            }

            .bbt-ac-prev,
            .bbt-ac-next {
                position: absolute;
                top: 50%;
                transform: translateY(-50%);
                width: 44px;
                height: 44px;
                background: #fff;
                border: none;
                border-radius: 50%;
                box-shadow: 0 4px 15px rgba(0, 0, 0, .1);
                cursor: pointer;
                display: flex;
                align-items: center;
                justify-content: center;
                z-index: 10;
                transition: all .3s ease
            }

            .bbt-ac-prev {
                left: 10px
            }

            .bbt-ac-next {
                right: 10px
            }

            .bbt-ac-prev:hover,
            .bbt-ac-next:hover {
                background: #F5A623;
                color: #fff
            }
        </style>
        <?php
    }
}
