<?php
if (!defined('ABSPATH'))
    exit;

class BBT_Widget_Scroll_Reveal extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'bbt-scroll-reveal';
    }
    public function get_title()
    {
        return esc_html__('Scroll Reveal Text', 'bestbalitravel');
    }
    public function get_icon()
    {
        return 'eicon-scroll';
    }
    public function get_categories()
    {
        return ['bbt-widgets'];
    }

    protected function register_controls()
    {
        $this->start_controls_section('section_content', ['label' => 'Content']);
        $this->add_control('text', ['label' => 'Text', 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'Discover the beauty of Bali with our exclusive tours and activities.']);
        $this->add_control('highlight', ['label' => 'Highlight Word', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'beauty']);
        $this->add_control('animation', ['label' => 'Animation', 'type' => \Elementor\Controls_Manager::SELECT, 'options' => ['fade-up' => 'Fade Up', 'fade-left' => 'Fade Left', 'zoom' => 'Zoom'], 'default' => 'fade-up']);
        $this->end_controls_section();
    }

    protected function render()
    {
        $s = $this->get_settings_for_display();
        $text = str_replace($s['highlight'], '<span class="bbt-highlight">' . esc_html($s['highlight']) . '</span>', esc_html($s['text']));
        ?>
        <div class="bbt-scroll-reveal anim-<?php echo esc_attr($s['animation']); ?>">
            <p>
                <?php echo $text; ?>
            </p>
        </div>
        <style>
            .bbt-scroll-reveal {
                opacity: 0;
                transition: all .8s ease
            }

            .bbt-scroll-reveal.visible {
                opacity: 1
            }

            .anim-fade-up {
                transform: translateY(40px)
            }

            .anim-fade-up.visible {
                transform: translateY(0)
            }

            .anim-fade-left {
                transform: translateX(-40px)
            }

            .anim-fade-left.visible {
                transform: translateX(0)
            }

            .anim-zoom {
                transform: scale(.8)
            }

            .anim-zoom.visible {
                transform: scale(1)
            }

            .bbt-scroll-reveal p {
                font-size: 32px;
                font-weight: 600;
                line-height: 1.5;
                margin: 0
            }

            .bbt-highlight {
                color: #F5A623;
                position: relative
            }

            .bbt-highlight::after {
                content: '';
                position: absolute;
                bottom: 0;
                left: 0;
                right: 0;
                height: 8px;
                background: rgba(245, 166, 35, .3);
                z-index: -1
            }
        </style>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var observer = new IntersectionObserver(function (entries) { entries.forEach(function (entry) { if (entry.isIntersecting) entry.target.classList.add('visible') }) }, { threshold: 0.2 });
                document.querySelectorAll('.bbt-scroll-reveal').forEach(function (el) { observer.observe(el) });
            });
        </script>
        <?php
    }
}
