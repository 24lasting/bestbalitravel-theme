<?php
if (!defined('ABSPATH'))
    exit;

class BBT_Widget_Blog_Posts extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'bbt-blog-posts';
    }
    public function get_title()
    {
        return esc_html__('Blog Posts', 'bestbalitravel');
    }
    public function get_icon()
    {
        return 'eicon-posts-ticker';
    }
    public function get_categories()
    {
        return ['bbt-widgets'];
    }

    protected function register_controls()
    {
        $this->start_controls_section('section_content', ['label' => 'Settings']);
        $this->add_control('posts_per_page', ['label' => 'Posts', 'type' => \Elementor\Controls_Manager::NUMBER, 'default' => 3]);
        $this->add_control('columns', ['label' => 'Columns', 'type' => \Elementor\Controls_Manager::SELECT, 'options' => ['2' => '2', '3' => '3'], 'default' => '3']);
        $this->end_controls_section();
    }

    protected function render()
    {
        $s = $this->get_settings_for_display();
        $query = new \WP_Query(['post_type' => 'post', 'posts_per_page' => $s['posts_per_page']]);
        ?>
        <div class="bbt-blog-posts" style="--cols:<?php echo esc_attr($s['columns']); ?>">
            <?php if ($query->have_posts()):
                while ($query->have_posts()):
                    $query->the_post(); ?>
                    <article class="bbt-bp-card">
                        <div class="bbt-bp-img">
                            <?php if (has_post_thumbnail())
                                the_post_thumbnail('medium_large');
                            else
                                echo '<img src="https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=600">'; ?>
                        </div>
                        <div class="bbt-bp-content">
                            <span class="bbt-bp-date">
                                <?php echo get_the_date(); ?>
                            </span>
                            <h3><a href="<?php the_permalink(); ?>">
                                    <?php the_title(); ?>
                                </a></h3>
                            <p>
                                <?php echo wp_trim_words(get_the_excerpt(), 15); ?>
                            </p>
                            <a href="<?php the_permalink(); ?>" class="bbt-bp-link">Read More →</a>
                        </div>
                    </article>
                <?php endwhile;
                wp_reset_postdata(); endif; ?>
        </div>
        <style>
            .bbt-blog-posts {
                display: grid;
                grid-template-columns: repeat(var(--cols), 1fr);
                gap: 30px
            }

            .bbt-bp-card {
                background: #fff;
                border-radius: 20px;
                overflow: hidden;
                box-shadow: 0 8px 30px rgba(0, 0, 0, .08);
                transition: transform .4s ease
            }

            .bbt-bp-card:hover {
                transform: translateY(-8px)
            }

            .bbt-bp-img {
                height: 200px;
                overflow: hidden
            }

            .bbt-bp-img img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                transition: transform .5s ease
            }

            .bbt-bp-card:hover .bbt-bp-img img {
                transform: scale(1.1)
            }

            .bbt-bp-content {
                padding: 25px
            }

            .bbt-bp-date {
                font-size: 12px;
                color: #F5A623;
                font-weight: 600
            }

            .bbt-bp-content h3 {
                margin: 8px 0 12px;
                font-size: 18px
            }

            .bbt-bp-content h3 a {
                color: inherit;
                text-decoration: none
            }

            .bbt-bp-content p {
                color: #666;
                font-size: 14px;
                line-height: 1.6;
                margin: 0 0 15px
            }

            .bbt-bp-link {
                color: #F5A623;
                text-decoration: none;
                font-weight: 600
            }

            @media(max-width:768px) {
                .bbt-blog-posts {
                    grid-template-columns: 1fr
                }
            }
        </style>
        <?php
    }
}
