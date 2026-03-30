<?php
if (!defined('ABSPATH'))
    exit;

class BBT_Widget_Testimonial_Single extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'bbt-testimonial-single';
    }
    public function get_title()
    {
        return esc_html__('Testimonial Single', 'bestbalitravel');
    }
    public function get_icon()
    {
        return 'eicon-testimonial';
    }
    public function get_categories()
    {
        return ['bbt-widgets'];
    }

    protected function register_controls()
    {
        $this->start_controls_section('section_content', ['label' => 'Content']);
        $this->add_control('content', ['label' => 'Content', 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'This was the best vacation of our lives! The tour guides were amazing and every moment was magical.']);
        $this->add_control('name', ['label' => 'Name', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Sarah Johnson']);
        $this->add_control('location', ['label' => 'Location', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'California, USA']);
        $this->add_control('rating', ['label' => 'Rating', 'type' => \Elementor\Controls_Manager::NUMBER, 'default' => 5, 'min' => 1, 'max' => 5]);
        $this->add_control('avatar', ['label' => 'Avatar', 'type' => \Elementor\Controls_Manager::MEDIA]);
        $this->add_control('style', ['label' => 'Style', 'type' => \Elementor\Controls_Manager::SELECT, 'options' => ['card' => 'Card', 'minimal' => 'Minimal', 'quote' => 'Big Quote'], 'default' => 'card']);
        $this->end_controls_section();
    }

    protected function render()
    {
        $s = $this->get_settings_for_display();
        $avatar = !empty($s['avatar']['url']) ? $s['avatar']['url'] : 'https://ui-avatars.com/api/?name=' . urlencode($s['name']) . '&background=F5A623&color=fff&size=100';
        ?>
        <div class="bbt-testimonial-single style-<?php echo esc_attr($s['style']); ?>">
            <div class="bbt-ts-quote">❝</div>
            <p class="bbt-ts-content">
                <?php echo esc_html($s['content']); ?>
            </p>
            <div class="bbt-ts-rating">
                <?php echo str_repeat('⭐', (int) $s['rating']); ?>
            </div>
            <div class="bbt-ts-author">
                <img src="<?php echo esc_url($avatar); ?>" alt="<?php echo esc_attr($s['name']); ?>">
                <div><strong>
                        <?php echo esc_html($s['name']); ?>
                    </strong><span>
                        <?php echo esc_html($s['location']); ?>
                    </span></div>
            </div>
        </div>
        <style>
            .bbt-testimonial-single {
                background: #fff;
                border-radius: 24px;
                padding: 40px;
                text-align: center;
                box-shadow: 0 15px 50px rgba(0, 0, 0, .08)
            }

            .bbt-ts-quote {
                font-size: 80px;
                color: #F5A623;
                line-height: 1;
                margin-bottom: -20px;
                opacity: .3
            }

            .bbt-ts-content {
                font-size: 20px;
                line-height: 1.7;
                color: #333;
                margin: 0 0 20px;
                font-style: italic
            }

            .bbt-ts-rating {
                margin-bottom: 20px
            }

            .bbt-ts-author {
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 15px
            }

            .bbt-ts-author img {
                width: 60px;
                height: 60px;
                border-radius: 50%;
                object-fit: cover
            }

            .bbt-ts-author strong {
                display: block;
                font-size: 16px
            }

            .bbt-ts-author span {
                font-size: 13px;
                color: #666
            }

            .style-minimal {
                box-shadow: none;
                border: 2px solid #eee
            }

            .style-quote .bbt-ts-quote {
                font-size: 120px
            }
        </style>
        <?php
    }
}
