<?php
if (!defined('ABSPATH'))
    exit;

class BBT_Widget_Related_Tours extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'bbt-related-tours';
    }
    public function get_title()
    {
        return esc_html__('Related Tours', 'bestbalitravel');
    }
    public function get_icon()
    {
        return 'eicon-posts-group';
    }
    public function get_categories()
    {
        return ['bbt-widgets'];
    }

    protected function register_controls()
    {
        $this->start_controls_section('section_content', ['label' => 'Settings']);
        $this->add_control('title', ['label' => 'Title', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'You May Also Like']);
        $this->add_control('count', ['label' => 'Number of Tours', 'type' => \Elementor\Controls_Manager::NUMBER, 'default' => 4]);
        $this->end_controls_section();
    }

    protected function render()
    {
        $s = $this->get_settings_for_display();
        $query = new \WP_Query(['post_type' => 'tour', 'posts_per_page' => $s['count'], 'orderby' => 'rand', 'post__not_in' => [get_the_ID()]]);
        ?>
        <div class="bbt-related-tours">
            <h3 class="bbt-rt-title">
                <?php echo esc_html($s['title']); ?>
            </h3>
            <div class="bbt-rt-grid">
                <?php if ($query->have_posts()):
                    while ($query->have_posts()):
                        $query->the_post();
                        $price = function_exists('bbt_get_tour_price') ? bbt_get_tour_price() : 'Rp 450,000';
                        ?>
                        <a href="<?php the_permalink(); ?>" class="bbt-rt-card">
                            <div class="bbt-rt-img">
                                <?php if (has_post_thumbnail())
                                    the_post_thumbnail('medium');
                                else
                                    echo '<img src="https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=400">'; ?>
                            </div>
                            <div class="bbt-rt-info">
                                <h4>
                                    <?php the_title(); ?>
                                </h4><span>
                                    <?php echo esc_html($price); ?>
                                </span>
                            </div>
                        </a>
                    <?php endwhile;
                    wp_reset_postdata(); endif; ?>
            </div>
        </div>
        <style>
            .bbt-rt-title {
                font-size: 24px;
                margin: 0 0 25px
            }

            .bbt-rt-grid {
                display: grid;
                grid-template-columns: repeat(4, 1fr);
                gap: 20px
            }

            .bbt-rt-card {
                background: #fff;
                border-radius: 16px;
                overflow: hidden;
                text-decoration: none;
                color: inherit;
                box-shadow: 0 5px 20px rgba(0, 0, 0, .08);
                transition: transform .3s ease
            }

            .bbt-rt-card:hover {
                transform: translateY(-8px)
            }

            .bbt-rt-img {
                height: 150px;
                overflow: hidden
            }

            .bbt-rt-img img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                transition: transform .4s ease
            }

            .bbt-rt-card:hover .bbt-rt-img img {
                transform: scale(1.1)
            }

            .bbt-rt-info {
                padding: 15px
            }

            .bbt-rt-info h4 {
                margin: 0 0 5px;
                font-size: 14px
            }

            .bbt-rt-info span {
                color: #F5A623;
                font-weight: 700;
                font-size: 15px
            }

            @media(max-width:768px) {
                .bbt-rt-grid {
                    grid-template-columns: repeat(2, 1fr)
                }
            }
        </style>
        <?php
    }
}
