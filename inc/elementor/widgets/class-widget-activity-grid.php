<?php
/**
 * Elementor Activity Grid Widget
 * @package BestBaliTravel
 */
if (!defined('ABSPATH'))
    exit;

class BBT_Widget_Activity_Grid extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'bbt-activity-grid';
    }
    public function get_title()
    {
        return esc_html__('Activity Grid', 'bestbalitravel');
    }
    public function get_icon()
    {
        return 'eicon-posts-grid';
    }
    public function get_categories()
    {
        return ['bbt-widgets'];
    }

    protected function register_controls()
    {
        $this->start_controls_section('section_content', ['label' => 'Settings']);
        $this->add_control('posts_per_page', ['label' => 'Number of Activities', 'type' => \Elementor\Controls_Manager::NUMBER, 'default' => 6]);
        $this->add_control('columns', ['label' => 'Columns', 'type' => \Elementor\Controls_Manager::SELECT, 'options' => ['2' => '2', '3' => '3', '4' => '4'], 'default' => '3']);
        $this->add_control('orderby', ['label' => 'Order By', 'type' => \Elementor\Controls_Manager::SELECT, 'options' => ['date' => 'Newest', 'title' => 'Title', 'rand' => 'Random', 'meta_value_num' => 'Rating'], 'default' => 'date']);
        $this->end_controls_section();
    }

    protected function render()
    {
        $s = $this->get_settings_for_display();
        $args = ['post_type' => 'tour', 'posts_per_page' => $s['posts_per_page'], 'orderby' => $s['orderby'], 'order' => 'DESC'];
        if ($s['orderby'] === 'meta_value_num')
            $args['meta_key'] = '_bbt_tour_rating';
        $query = new \WP_Query($args);
        ?>
        <div class="bbt-activity-grid" style="--cols:<?php echo esc_attr($s['columns']); ?>">
            <?php if ($query->have_posts()):
                $i = 0;
                while ($query->have_posts()):
                    $query->the_post();
                    $price = function_exists('bbt_get_tour_price') ? bbt_get_tour_price() : 'Rp 450,000';
                    $rating = function_exists('bbt_get_tour_rating') ? bbt_get_tour_rating() : '4.8';
                    ?>
                    <article class="bbt-ag-card" style="--d:<?php echo $i * 0.1; ?>s">
                        <div class="bbt-ag-img">
                            <?php if (has_post_thumbnail())
                                the_post_thumbnail('medium_large');
                            else
                                echo '<img src="https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=600" alt="">'; ?>
                            <span class="bbt-ag-badge">⭐
                                <?php echo esc_html($rating); ?>
                            </span>
                            <div class="bbt-ag-overlay"><a href="<?php the_permalink(); ?>">View Details</a></div>
                        </div>
                        <div class="bbt-ag-content">
                            <h3><a href="<?php the_permalink(); ?>">
                                    <?php the_title(); ?>
                                </a></h3>
                            <div class="bbt-ag-footer"><span class="bbt-ag-price">
                                    <?php echo esc_html($price); ?>
                                </span></div>
                        </div>
                    </article>
                    <?php $i++; endwhile;
                wp_reset_postdata(); endif; ?>
        </div>
        <style>
            .bbt-activity-grid {
                display: grid;
                grid-template-columns: repeat(var(--cols), 1fr);
                gap: 25px
            }

            .bbt-ag-card {
                background: #fff;
                border-radius: 20px;
                overflow: hidden;
                box-shadow: 0 8px 30px rgba(0, 0, 0, .08);
                opacity: 0;
                animation: bbtAgFade .5s ease forwards;
                animation-delay: var(--d);
                transition: transform .4s ease
            }

            @keyframes bbtAgFade {
                to {
                    opacity: 1
                }
            }

            .bbt-ag-card:hover {
                transform: translateY(-10px)
            }

            .bbt-ag-img {
                position: relative;
                height: 200px;
                overflow: hidden
            }

            .bbt-ag-img img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                transition: transform .5s ease
            }

            .bbt-ag-card:hover .bbt-ag-img img {
                transform: scale(1.1)
            }

            .bbt-ag-badge {
                position: absolute;
                top: 12px;
                right: 12px;
                background: rgba(0, 0, 0, .7);
                color: #fff;
                padding: 5px 10px;
                border-radius: 15px;
                font-size: 12px
            }

            .bbt-ag-overlay {
                position: absolute;
                inset: 0;
                background: rgba(0, 0, 0, .6);
                display: flex;
                align-items: center;
                justify-content: center;
                opacity: 0;
                transition: opacity .3s ease
            }

            .bbt-ag-card:hover .bbt-ag-overlay {
                opacity: 1
            }

            .bbt-ag-overlay a {
                padding: 12px 25px;
                background: #F5A623;
                color: #000;
                text-decoration: none;
                border-radius: 8px;
                font-weight: 600
            }

            .bbt-ag-content {
                padding: 20px
            }

            .bbt-ag-content h3 {
                margin: 0 0 10px;
                font-size: 16px
            }

            .bbt-ag-content h3 a {
                color: inherit;
                text-decoration: none
            }

            .bbt-ag-price {
                font-size: 18px;
                font-weight: 700;
                color: #F5A623
            }

            @media(max-width:768px) {
                .bbt-activity-grid {
                    grid-template-columns: 1fr
                }
            }
        </style>
        <?php
    }
}
