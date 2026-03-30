<?php
if (!defined('ABSPATH'))
    exit;

class BBT_Widget_Parallax_Section extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'bbt-parallax-section';
    }
    public function get_title()
    {
        return esc_html__('Parallax Section', 'bestbalitravel');
    }
    public function get_icon()
    {
        return 'eicon-parallax';
    }
    public function get_categories()
    {
        return ['bbt-widgets'];
    }

    protected function register_controls()
    {
        $this->start_controls_section('section_content', ['label' => 'Content']);
        $this->add_control('image', ['label' => 'Image', 'type' => \Elementor\Controls_Manager::MEDIA, 'default' => ['url' => 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=1920']]);
        $this->add_control('title', ['label' => 'Title', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Explore Paradise']);
        $this->add_control('subtitle', ['label' => 'Subtitle', 'type' => \Elementor\Controls_Manager::TEXTAREA]);
        $this->add_control('height', ['label' => 'Height', 'type' => \Elementor\Controls_Manager::SLIDER, 'range' => ['px' => ['min' => 300, 'max' => 800]], 'default' => ['size' => 500]]);
        $this->end_controls_section();
    }

    protected function render()
    {
        $s = $this->get_settings_for_display();
        $img = $s['image']['url'] ?: 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=1920';
        ?>
        <div class="bbt-parallax-section"
            style="height:<?php echo esc_attr($s['height']['size']); ?>px;background-image:url('<?php echo esc_url($img); ?>')">
            <div class="bbt-px-overlay"></div>
            <div class="bbt-px-content">
                <h2>
                    <?php echo esc_html($s['title']); ?>
                </h2>
                <?php if ($s['subtitle']): ?>
                    <p>
                        <?php echo esc_html($s['subtitle']); ?>
                    </p>
                <?php endif; ?>
            </div>
        </div>
        <style>
            .bbt-parallax-section {
                background-attachment: fixed;
                background-size: cover;
                background-position: center;
                position: relative;
                display: flex;
                align-items: center;
                justify-content: center
            }

            .bbt-px-overlay {
                position: absolute;
                inset: 0;
                background: rgba(0, 0, 0, .5)
            }

            .bbt-px-content {
                position: relative;
                z-index: 2;
                text-align: center;
                color: #fff;
                padding: 40px
            }

            .bbt-px-content h2 {
                font-size: 48px;
                font-weight: 700;
                margin: 0 0 15px
            }

            .bbt-px-content p {
                font-size: 18px;
                opacity: .9;
                margin: 0;
                max-width: 600px
            }
        </style>
        <?php
    }
}
