<?php
if (!defined('ABSPATH'))
    exit;

class BBT_Widget_Activity_Hero extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'bbt-activity-hero';
    }
    public function get_title()
    {
        return esc_html__('Activity Hero', 'bestbalitravel');
    }
    public function get_icon()
    {
        return 'eicon-single-page';
    }
    public function get_categories()
    {
        return ['bbt-widgets'];
    }

    protected function register_controls()
    {
        $this->start_controls_section('section_content', ['label' => 'Content']);
        $this->add_control('bg_image', ['label' => 'Background', 'type' => \Elementor\Controls_Manager::MEDIA]);
        $this->add_control('category', ['label' => 'Category', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Adventure']);
        $this->add_control('title', ['label' => 'Title', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'White Water Rafting']);
        $this->add_control('rating', ['label' => 'Rating', 'type' => \Elementor\Controls_Manager::NUMBER, 'default' => 4.9]);
        $this->add_control('reviews', ['label' => 'Reviews', 'type' => \Elementor\Controls_Manager::NUMBER, 'default' => 256]);
        $this->add_control('duration', ['label' => 'Duration', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '4 Hours']);
        $this->end_controls_section();
    }

    protected function render()
    {
        $s = $this->get_settings_for_display();
        $bg = !empty($s['bg_image']['url']) ? $s['bg_image']['url'] : 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=1920';
        ?>
        <div class="bbt-activity-hero" style="background-image:url('<?php echo esc_url($bg); ?>')">
            <div class="bbt-ah-overlay"></div>
            <div class="bbt-ah-content">
                <span class="bbt-ah-cat">
                    <?php echo esc_html($s['category']); ?>
                </span>
                <h1>
                    <?php echo esc_html($s['title']); ?>
                </h1>
                <div class="bbt-ah-meta">
                    <span>⭐
                        <?php echo esc_html($s['rating']); ?> (
                        <?php echo esc_html($s['reviews']); ?> reviews)
                    </span>
                    <span>⏱️
                        <?php echo esc_html($s['duration']); ?>
                    </span>
                </div>
            </div>
        </div>
        <style>
            .bbt-activity-hero {
                height: 500px;
                background-size: cover;
                background-position: center;
                position: relative;
                display: flex;
                align-items: flex-end;
                border-radius: 24px;
                overflow: hidden
            }

            .bbt-ah-overlay {
                position: absolute;
                inset: 0;
                background: linear-gradient(180deg, transparent 30%, rgba(0, 0, 0, .85) 100%)
            }

            .bbt-ah-content {
                position: relative;
                z-index: 2;
                padding: 50px;
                color: #fff;
                width: 100%
            }

            .bbt-ah-cat {
                display: inline-block;
                background: #F5A623;
                color: #000;
                padding: 8px 20px;
                border-radius: 20px;
                font-size: 13px;
                font-weight: 700;
                margin-bottom: 15px
            }

            .bbt-ah-content h1 {
                font-size: 42px;
                font-weight: 800;
                margin: 0 0 15px
            }

            .bbt-ah-meta {
                display: flex;
                gap: 25px;
                font-size: 15px;
                opacity: .9
            }
        </style>
        <?php
    }
}
