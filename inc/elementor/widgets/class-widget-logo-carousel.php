<?php
if (!defined('ABSPATH'))
    exit;

class BBT_Widget_Logo_Carousel extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'bbt-logo-carousel';
    }
    public function get_title()
    {
        return esc_html__('Logo Carousel', 'bestbalitravel');
    }
    public function get_icon()
    {
        return 'eicon-carousel-loop';
    }
    public function get_categories()
    {
        return ['bbt-widgets'];
    }

    protected function register_controls()
    {
        $this->start_controls_section('section_logos', ['label' => 'Logos']);
        $this->add_control('logos', ['label' => 'Logos', 'type' => \Elementor\Controls_Manager::GALLERY]);
        $this->add_control('speed', ['label' => 'Speed', 'type' => \Elementor\Controls_Manager::NUMBER, 'default' => 30]);
        $this->add_control('grayscale', ['label' => 'Grayscale', 'type' => \Elementor\Controls_Manager::SWITCHER, 'default' => 'yes']);
        $this->end_controls_section();
    }

    protected function render()
    {
        $s = $this->get_settings_for_display();
        $logos = $s['logos'] ?: [];
        for ($i = 0; $i < 6 && count($logos) < 6; $i++)
            $logos[] = ['url' => 'https://via.placeholder.com/150x60?text=Logo' . ($i + 1)];
        ?>
        <div class="bbt-logo-carousel <?php echo $s['grayscale'] === 'yes' ? 'grayscale' : ''; ?>">
            <div class="bbt-lc-track" style="--speed:<?php echo esc_attr($s['speed']); ?>s">
                <?php for ($i = 0; $i < 2; $i++):
                    foreach ($logos as $logo): ?>
                        <div class="bbt-lc-item"><img src="<?php echo esc_url($logo['url']); ?>" alt=""></div>
                    <?php endforeach; endfor; ?>
            </div>
        </div>
        <style>
            .bbt-logo-carousel {
                overflow: hidden;
                padding: 30px 0
            }

            .bbt-lc-track {
                display: flex;
                gap: 60px;
                animation: bbtLcScroll var(--speed) linear infinite
            }

            @keyframes bbtLcScroll {
                0% {
                    transform: translateX(0)
                }

                100% {
                    transform: translateX(-50%)
                }
            }

            .bbt-lc-item img {
                height: 50px;
                width: auto
            }

            .grayscale .bbt-lc-item img {
                filter: grayscale(100%);
                opacity: .6;
                transition: all .3s ease
            }

            .grayscale .bbt-lc-item:hover img {
                filter: grayscale(0);
                opacity: 1
            }
        </style>
        <?php
    }
}
