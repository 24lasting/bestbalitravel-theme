<?php
if (!defined('ABSPATH'))
    exit;

class BBT_Widget_Page_Header extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'bbt-page-header';
    }
    public function get_title()
    {
        return esc_html__('Page Header', 'bestbalitravel');
    }
    public function get_icon()
    {
        return 'eicon-heading';
    }
    public function get_categories()
    {
        return ['bbt-widgets'];
    }

    protected function register_controls()
    {
        $this->start_controls_section('section_content', ['label' => 'Content']);
        $this->add_control('title', ['label' => 'Title', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Page Title']);
        $this->add_control('subtitle', ['label' => 'Subtitle', 'type' => \Elementor\Controls_Manager::TEXTAREA]);
        $this->add_control('bg_image', ['label' => 'Background', 'type' => \Elementor\Controls_Manager::MEDIA]);
        $this->add_control('show_breadcrumbs', ['label' => 'Breadcrumbs', 'type' => \Elementor\Controls_Manager::SWITCHER, 'default' => 'yes']);
        $this->end_controls_section();
    }

    protected function render()
    {
        $s = $this->get_settings_for_display();
        $bg = !empty($s['bg_image']['url']) ? $s['bg_image']['url'] : 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=1920';
        ?>
        <div class="bbt-page-header" style="background-image:url('<?php echo esc_url($bg); ?>')">
            <div class="bbt-ph-overlay"></div>
            <div class="bbt-ph-content">
                <h1>
                    <?php echo esc_html($s['title']); ?>
                </h1>
                <?php if ($s['subtitle']): ?>
                    <p>
                        <?php echo esc_html($s['subtitle']); ?>
                    </p>
                <?php endif; ?>
                <?php if ($s['show_breadcrumbs'] === 'yes'): ?>
                    <nav class="bbt-ph-breadcrumbs"><a href="<?php echo home_url('/'); ?>">Home</a><span>›</span><span>
                            <?php echo esc_html($s['title']); ?>
                        </span></nav>
                <?php endif; ?>
            </div>
        </div>
        <style>
            .bbt-page-header {
                position: relative;
                height: 300px;
                background-size: cover;
                background-position: center;
                display: flex;
                align-items: center;
                justify-content: center
            }

            .bbt-ph-overlay {
                position: absolute;
                inset: 0;
                background: rgba(0, 0, 0, .6)
            }

            .bbt-ph-content {
                position: relative;
                z-index: 2;
                text-align: center;
                color: #fff
            }

            .bbt-ph-content h1 {
                font-size: 48px;
                font-weight: 800;
                margin: 0 0 10px
            }

            .bbt-ph-content p {
                font-size: 18px;
                opacity: .9;
                margin: 0 0 20px
            }

            .bbt-ph-breadcrumbs {
                display: flex;
                justify-content: center;
                gap: 12px;
                font-size: 14px
            }

            .bbt-ph-breadcrumbs a {
                color: #F5A623;
                text-decoration: none
            }

            .bbt-ph-breadcrumbs span {
                opacity: .7
            }
        </style>
        <?php
    }
}
