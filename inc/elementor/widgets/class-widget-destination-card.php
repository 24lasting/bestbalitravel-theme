<?php
if (!defined('ABSPATH'))
    exit;

class BBT_Widget_Destination_Card extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'bbt-destination-card';
    }
    public function get_title()
    {
        return esc_html__('Destination Card', 'bestbalitravel');
    }
    public function get_icon()
    {
        return 'eicon-globe';
    }
    public function get_categories()
    {
        return ['bbt-widgets'];
    }

    protected function register_controls()
    {
        $this->start_controls_section('section_content', ['label' => 'Content']);
        $this->add_control('image', ['label' => 'Image', 'type' => \Elementor\Controls_Manager::MEDIA]);
        $this->add_control('name', ['label' => 'Name', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Ubud']);
        $this->add_control('subtitle', ['label' => 'Subtitle', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Cultural Heart of Bali']);
        $this->add_control('tours_count', ['label' => 'Tours Count', 'type' => \Elementor\Controls_Manager::NUMBER, 'default' => 25]);
        $this->add_control('link', ['label' => 'Link', 'type' => \Elementor\Controls_Manager::URL]);
        $this->end_controls_section();
    }

    protected function render()
    {
        $s = $this->get_settings_for_display();
        $img = !empty($s['image']['url']) ? $s['image']['url'] : 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=600';
        $link = $s['link']['url'] ?? '#';
        ?>
        <a href="<?php echo esc_url($link); ?>" class="bbt-destination-card">
            <div class="bbt-dc-img"><img src="<?php echo esc_url($img); ?>" alt="<?php echo esc_attr($s['name']); ?>"></div>
            <div class="bbt-dc-overlay"></div>
            <div class="bbt-dc-content">
                <span class="bbt-dc-count">
                    <?php echo esc_html($s['tours_count']); ?> Tours
                </span>
                <h3>
                    <?php echo esc_html($s['name']); ?>
                </h3>
                <p>
                    <?php echo esc_html($s['subtitle']); ?>
                </p>
            </div>
        </a>
        <style>
            .bbt-destination-card {
                display: block;
                position: relative;
                height: 400px;
                border-radius: 24px;
                overflow: hidden;
                text-decoration: none
            }

            .bbt-dc-img {
                position: absolute;
                inset: 0
            }

            .bbt-dc-img img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                transition: transform .6s ease
            }

            .bbt-destination-card:hover .bbt-dc-img img {
                transform: scale(1.1)
            }

            .bbt-dc-overlay {
                position: absolute;
                inset: 0;
                background: linear-gradient(180deg, transparent 30%, rgba(0, 0, 0, .8) 100%)
            }

            .bbt-dc-content {
                position: absolute;
                bottom: 0;
                left: 0;
                right: 0;
                padding: 30px;
                color: #fff
            }

            .bbt-dc-count {
                display: inline-block;
                background: #F5A623;
                color: #000;
                padding: 6px 14px;
                border-radius: 20px;
                font-size: 12px;
                font-weight: 700;
                margin-bottom: 12px
            }

            .bbt-dc-content h3 {
                margin: 0 0 8px;
                font-size: 28px;
                font-weight: 700
            }

            .bbt-dc-content p {
                margin: 0;
                font-size: 14px;
                opacity: .9
            }
        </style>
        <?php
    }
}
