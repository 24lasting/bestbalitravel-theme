<?php
if (!defined('ABSPATH'))
    exit;

class BBT_Widget_Partner_Logos extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'bbt-partner-logos';
    }
    public function get_title()
    {
        return esc_html__('Partner Logos', 'bestbalitravel');
    }
    public function get_icon()
    {
        return 'eicon-logo';
    }
    public function get_categories()
    {
        return ['bbt-widgets'];
    }

    protected function register_controls()
    {
        $this->start_controls_section('section_content', ['label' => 'Logos']);
        $this->add_control('logos', ['label' => 'Logos', 'type' => \Elementor\Controls_Manager::GALLERY]);
        $this->add_control('autoplay', ['label' => 'Auto Scroll', 'type' => \Elementor\Controls_Manager::SWITCHER, 'default' => 'yes']);
        $this->end_controls_section();
    }

    protected function render()
    {
        $s = $this->get_settings_for_display();
        $logos = $s['logos'] ?: [['url' => 'https://via.placeholder.com/150x50?text=Partner+1'], ['url' => 'https://via.placeholder.com/150x50?text=Partner+2'], ['url' => 'https://via.placeholder.com/150x50?text=Partner+3'], ['url' => 'https://via.placeholder.com/150x50?text=Partner+4'], ['url' => 'https://via.placeholder.com/150x50?text=Partner+5']];
        ?>
        <div class="bbt-partner-logos <?php echo $s['autoplay'] === 'yes' ? 'auto-scroll' : ''; ?>">
            <div class="bbt-logos-track">
                <?php foreach ($logos as $logo): ?>
                    <div class="bbt-logo-item"><img src="<?php echo esc_url($logo['url']); ?>" alt="Partner"></div>
                <?php endforeach; ?>
                <?php if ($s['autoplay'] === 'yes'):
                    foreach ($logos as $logo): ?>
                        <div class="bbt-logo-item"><img src="<?php echo esc_url($logo['url']); ?>" alt="Partner"></div>
                    <?php endforeach; endif; ?>
            </div>
        </div>
        <style>
            .bbt-partner-logos {
                overflow: hidden;
                padding: 30px 0
            }

            .bbt-logos-track {
                display: flex;
                align-items: center;
                gap: 60px
            }

            .auto-scroll .bbt-logos-track {
                animation: bbtLogoScroll 20s linear infinite
            }

            @keyframes bbtLogoScroll {
                0% {
                    transform: translateX(0)
                }

                100% {
                    transform: translateX(-50%)
                }
            }

            .bbt-logo-item {
                flex: 0 0 auto
            }

            .bbt-logo-item img {
                height: 50px;
                filter: grayscale(100%);
                opacity: .6;
                transition: all .3s ease
            }

            .bbt-logo-item:hover img {
                filter: grayscale(0);
                opacity: 1
            }
        </style>
        <?php
    }
}
