<?php
if (!defined('ABSPATH'))
    exit;

class BBT_Widget_Banner_Slider extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'bbt-banner-slider';
    }
    public function get_title()
    {
        return esc_html__('Banner Slider', 'bestbalitravel');
    }
    public function get_icon()
    {
        return 'eicon-slider-full-screen';
    }
    public function get_categories()
    {
        return ['bbt-widgets'];
    }

    protected function register_controls()
    {
        $this->start_controls_section('section_slides', ['label' => 'Slides']);
        $repeater = new \Elementor\Repeater();
        $repeater->add_control('image', ['label' => 'Image', 'type' => \Elementor\Controls_Manager::MEDIA]);
        $repeater->add_control('title', ['label' => 'Title', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Slide Title']);
        $repeater->add_control('subtitle', ['label' => 'Subtitle', 'type' => \Elementor\Controls_Manager::TEXT]);
        $repeater->add_control('btn_text', ['label' => 'Button', 'type' => \Elementor\Controls_Manager::TEXT]);
        $repeater->add_control('btn_link', ['label' => 'Link', 'type' => \Elementor\Controls_Manager::URL]);
        $this->add_control('slides', [
            'type' => \Elementor\Controls_Manager::REPEATER,
            'fields' => $repeater->get_controls(),
            'default' => [
                ['title' => 'Explore Bali', 'subtitle' => 'Adventure awaits', 'btn_text' => 'View Tours'],
                ['title' => 'Temple Tours', 'subtitle' => 'Discover ancient wonders', 'btn_text' => 'Learn More'],
            ]
        ]);
        $this->add_control('autoplay', ['label' => 'Autoplay', 'type' => \Elementor\Controls_Manager::SWITCHER, 'default' => 'yes']);
        $this->end_controls_section();
    }

    protected function render()
    {
        $s = $this->get_settings_for_display();
        $id = 'bs-' . uniqid();
        $defaults = ['https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=1920', 'https://images.unsplash.com/photo-1555400038-63f5ba517a47?w=1920'];
        ?>
        <div class="bbt-banner-slider" id="<?php echo $id; ?>">
            <?php foreach ($s['slides'] as $i => $slide):
                $img = !empty($slide['image']['url']) ? $slide['image']['url'] : $defaults[$i % 2];
                ?>
                <div class="bbt-bs-slide <?php echo $i === 0 ? 'active' : ''; ?>"
                    style="background-image:url('<?php echo esc_url($img); ?>')">
                    <div class="bbt-bs-overlay"></div>
                    <div class="bbt-bs-content">
                        <h2>
                            <?php echo esc_html($slide['title']); ?>
                        </h2>
                        <?php if ($slide['subtitle']): ?>
                            <p>
                                <?php echo esc_html($slide['subtitle']); ?>
                            </p>
                        <?php endif; ?>
                        <?php if ($slide['btn_text']): ?><a href="<?php echo esc_url($slide['btn_link']['url'] ?? '#'); ?>"
                                class="bbt-bs-btn">
                                <?php echo esc_html($slide['btn_text']); ?>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
            <div class="bbt-bs-nav"><button class="prev">‹</button><button class="next">›</button></div>
            <div class="bbt-bs-dots">
                <?php foreach ($s['slides'] as $i => $s): ?><span class="<?php echo $i === 0 ? 'active' : ''; ?>"
                        data-slide="<?php echo $i; ?>"></span>
                <?php endforeach; ?>
            </div>
        </div>
        <style>
            .bbt-banner-slider {
                position: relative;
                height: 600px;
                overflow: hidden;
                border-radius: 24px
            }

            .bbt-bs-slide {
                position: absolute;
                inset: 0;
                background-size: cover;
                background-position: center;
                opacity: 0;
                transition: opacity .8s ease
            }

            .bbt-bs-slide.active {
                opacity: 1
            }

            .bbt-bs-overlay {
                position: absolute;
                inset: 0;
                background: rgba(0, 0, 0, .5)
            }

            .bbt-bs-content {
                position: relative;
                z-index: 2;
                height: 100%;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                text-align: center;
                color: #fff;
                padding: 40px
            }

            .bbt-bs-content h2 {
                font-size: 48px;
                font-weight: 700;
                margin: 0 0 15px
            }

            .bbt-bs-content p {
                font-size: 18px;
                opacity: .9;
                margin: 0 0 25px
            }

            .bbt-bs-btn {
                padding: 15px 35px;
                background: #F5A623;
                color: #000;
                text-decoration: none;
                border-radius: 30px;
                font-weight: 600
            }

            .bbt-bs-nav button {
                position: absolute;
                top: 50%;
                transform: translateY(-50%);
                width: 50px;
                height: 50px;
                background: rgba(255, 255, 255, .2);
                border: none;
                color: #fff;
                font-size: 24px;
                border-radius: 50%;
                cursor: pointer
            }

            .bbt-bs-nav .prev {
                left: 20px
            }

            .bbt-bs-nav .next {
                right: 20px
            }

            .bbt-bs-dots {
                position: absolute;
                bottom: 25px;
                left: 50%;
                transform: translateX(-50%);
                display: flex;
                gap: 10px
            }

            .bbt-bs-dots span {
                width: 12px;
                height: 12px;
                background: rgba(255, 255, 255, .5);
                border-radius: 50%;
                cursor: pointer
            }

            .bbt-bs-dots span.active {
                background: #F5A623
            }
        </style>
        <script>
            (function () {
                var el = document.getElementById('<?php echo $id; ?>'), slides = el.querySelectorAll('.bbt-bs-slide'), dots = el.querySelectorAll('.bbt-bs-dots span'), curr = 0, total = slides.length;
                function show(n) { slides.forEach(function (s, i) { s.classList.toggle('active', i === n) }); dots.forEach(function (d, i) { d.classList.toggle('active', i === n) }); curr = n }
                el.querySelector('.next').onclick = function () { show((curr + 1) % total) };
                el.querySelector('.prev').onclick = function () { show((curr - 1 + total) % total) };
                dots.forEach(function (d, i) { d.onclick = function () { show(i) } });
                <?php if ($s['autoplay'] === 'yes'): ?> setInterval(function () { show((curr + 1) % total) }, 5000);<?php endif; ?>
                })();
        </script>
        <?php
    }
}
