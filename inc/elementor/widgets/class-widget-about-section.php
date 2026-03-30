<?php
if (!defined('ABSPATH'))
    exit;

class BBT_Widget_About_Section extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'bbt-about-section';
    }
    public function get_title()
    {
        return esc_html__('About Section', 'bestbalitravel');
    }
    public function get_icon()
    {
        return 'eicon-info-circle';
    }
    public function get_categories()
    {
        return ['bbt-widgets'];
    }

    protected function register_controls()
    {
        $this->start_controls_section('section_content', ['label' => 'Content']);
        $this->add_control('image', ['label' => 'Image', 'type' => \Elementor\Controls_Manager::MEDIA]);
        $this->add_control('subtitle', ['label' => 'Subtitle', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'About Us']);
        $this->add_control('title', ['label' => 'Title', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Your Trusted Bali Travel Partner']);
        $this->add_control('content', ['label' => 'Content', 'type' => \Elementor\Controls_Manager::WYSIWYG, 'default' => 'With over 10 years of experience, we provide the best travel experiences in Bali.']);
        $this->add_control('experience_years', ['label' => 'Years Experience', 'type' => \Elementor\Controls_Manager::NUMBER, 'default' => 10]);
        $this->end_controls_section();
    }

    protected function render()
    {
        $s = $this->get_settings_for_display();
        $img = !empty($s['image']['url']) ? $s['image']['url'] : 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=800';
        ?>
        <div class="bbt-about-section">
            <div class="bbt-about-image">
                <img src="<?php echo esc_url($img); ?>" alt="">
                <div class="bbt-about-badge"><span class="bbt-badge-number">
                        <?php echo esc_html($s['experience_years']); ?>
                    </span><span class="bbt-badge-text">Years Experience</span></div>
            </div>
            <div class="bbt-about-content">
                <span class="bbt-about-subtitle">
                    <?php echo esc_html($s['subtitle']); ?>
                </span>
                <h2>
                    <?php echo esc_html($s['title']); ?>
                </h2>
                <div class="bbt-about-text">
                    <?php echo $s['content']; ?>
                </div>
            </div>
        </div>
        <style>
            .bbt-about-section {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 60px;
                align-items: center
            }

            .bbt-about-image {
                position: relative
            }

            .bbt-about-image img {
                width: 100%;
                border-radius: 24px;
                box-shadow: 0 20px 60px rgba(0, 0, 0, .15)
            }

            .bbt-about-badge {
                position: absolute;
                bottom: -20px;
                right: -20px;
                background: linear-gradient(135deg, #F5A623, #FFD93D);
                padding: 25px;
                border-radius: 20px;
                text-align: center;
                box-shadow: 0 15px 40px rgba(245, 166, 35, .3)
            }

            .bbt-badge-number {
                display: block;
                font-size: 48px;
                font-weight: 800;
                color: #000
            }

            .bbt-badge-text {
                font-size: 12px;
                font-weight: 600;
                color: #000
            }

            .bbt-about-subtitle {
                display: inline-block;
                color: #F5A623;
                font-weight: 600;
                font-size: 14px;
                margin-bottom: 10px;
                text-transform: uppercase;
                letter-spacing: 2px
            }

            .bbt-about-content h2 {
                font-size: 36px;
                font-weight: 700;
                margin: 0 0 20px;
                line-height: 1.3
            }

            .bbt-about-text {
                color: #666;
                line-height: 1.8
            }

            @media(max-width:768px) {
                .bbt-about-section {
                    grid-template-columns: 1fr;
                    gap: 40px
                }
            }
        </style>
        <?php
    }
}
