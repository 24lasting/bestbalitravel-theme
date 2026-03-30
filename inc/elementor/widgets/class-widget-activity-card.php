<?php
/**
 * Elementor Activity Card Widget
 * @package BestBaliTravel
 */
if (!defined('ABSPATH'))
    exit;

class BBT_Widget_Activity_Card extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'bbt-activity-card';
    }
    public function get_title()
    {
        return esc_html__('Activity Card', 'bestbalitravel');
    }
    public function get_icon()
    {
        return 'eicon-image-box';
    }
    public function get_categories()
    {
        return ['bbt-widgets'];
    }

    protected function register_controls()
    {
        $this->start_controls_section('section_content', ['label' => 'Activity']);
        $this->add_control('activity_id', ['label' => 'Select Activity', 'type' => \Elementor\Controls_Manager::SELECT2, 'options' => $this->get_activities()]);
        $this->add_control('style', ['label' => 'Style', 'type' => \Elementor\Controls_Manager::SELECT, 'options' => ['card' => 'Card', 'horizontal' => 'Horizontal', 'minimal' => 'Minimal', 'featured' => 'Featured'], 'default' => 'card']);
        $this->add_control('show_badge', ['label' => 'Show Badge', 'type' => \Elementor\Controls_Manager::SWITCHER, 'default' => 'yes']);
        $this->end_controls_section();
    }

    private function get_activities()
    {
        $opts = [];
        $posts = get_posts(['post_type' => 'tour', 'posts_per_page' => 50, 'post_status' => 'publish']);
        foreach ($posts as $p)
            $opts[$p->ID] = $p->post_title;
        return $opts;
    }

    protected function render()
    {
        $s = $this->get_settings_for_display();
        $id = $s['activity_id'];
        if (!$id) {
            echo '<p>Select an activity</p>';
            return;
        }

        $title = get_the_title($id);
        $link = get_permalink($id);
        $img = get_the_post_thumbnail_url($id, 'medium_large') ?: 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=600';
        $price = function_exists('bbt_get_tour_price') ? bbt_get_tour_price($id) : 'Rp 450,000';
        $rating = function_exists('bbt_get_tour_rating') ? bbt_get_tour_rating($id) : '4.8';
        $duration = function_exists('bbt_get_tour_duration') ? bbt_get_tour_duration($id) : '8 Hours';
        ?>
        <div class="bbt-activity-widget style-<?php echo esc_attr($s['style']); ?>">
            <div class="bbt-aw-image"><img src="<?php echo esc_url($img); ?>" alt="<?php echo esc_attr($title); ?>">
                <?php if ($s['show_badge'] === 'yes'): ?><span class="bbt-aw-badge">⭐
                        <?php echo esc_html($rating); ?>
                    </span>
                <?php endif; ?>
            </div>
            <div class="bbt-aw-content">
                <span class="bbt-aw-meta">⏱️
                    <?php echo esc_html($duration); ?>
                </span>
                <h3><a href="<?php echo esc_url($link); ?>">
                        <?php echo esc_html($title); ?>
                    </a></h3>
                <div class="bbt-aw-footer"><span class="bbt-aw-price">
                        <?php echo esc_html($price); ?>
                    </span><a href="<?php echo esc_url($link); ?>" class="bbt-aw-btn">Book →</a></div>
            </div>
        </div>
        <style>
            .bbt-activity-widget {
                background: #fff;
                border-radius: 20px;
                overflow: hidden;
                box-shadow: 0 10px 40px rgba(0, 0, 0, .08);
                transition: all .4s ease
            }

            .bbt-activity-widget:hover {
                transform: translateY(-8px);
                box-shadow: 0 20px 50px rgba(0, 0, 0, .12)
            }

            .bbt-aw-image {
                position: relative;
                height: 200px;
                overflow: hidden
            }

            .bbt-aw-image img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                transition: transform .5s ease
            }

            .bbt-activity-widget:hover .bbt-aw-image img {
                transform: scale(1.1)
            }

            .bbt-aw-badge {
                position: absolute;
                top: 12px;
                right: 12px;
                background: rgba(0, 0, 0, .7);
                color: #fff;
                padding: 6px 12px;
                border-radius: 20px;
                font-size: 12px;
                font-weight: 600
            }

            .bbt-aw-content {
                padding: 20px
            }

            .bbt-aw-meta {
                font-size: 12px;
                color: #666
            }

            .bbt-aw-content h3 {
                margin: 8px 0 12px;
                font-size: 17px
            }

            .bbt-aw-content h3 a {
                color: inherit;
                text-decoration: none
            }

            .bbt-aw-footer {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding-top: 12px;
                border-top: 1px solid #eee
            }

            .bbt-aw-price {
                font-size: 18px;
                font-weight: 700;
                color: #F5A623
            }

            .bbt-aw-btn {
                padding: 8px 16px;
                background: #1a1a1a;
                color: #fff;
                text-decoration: none;
                border-radius: 8px;
                font-size: 13px
            }

            .style-horizontal {
                display: flex
            }

            .style-horizontal .bbt-aw-image {
                width: 200px;
                height: auto
            }

            .style-horizontal .bbt-aw-content {
                flex: 1
            }

            .style-featured .bbt-aw-image {
                height: 300px
            }

            .style-minimal {
                box-shadow: none;
                border: 1px solid #eee
            }
        </style>
        <?php
    }
}
