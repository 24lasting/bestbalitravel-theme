<?php
if (!defined('ABSPATH'))
    exit;

class BBT_Widget_Hero_Section extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'bbt-hero-section';
    }
    public function get_title()
    {
        return esc_html__('Hero Section', 'bestbalitravel');
    }
    public function get_icon()
    {
        return 'eicon-banner';
    }
    public function get_categories()
    {
        return ['bbt-widgets'];
    }

    protected function register_controls()
    {
        $this->start_controls_section('section_content', ['label' => 'Content']);
        $this->add_control('bg_image', ['label' => 'Background', 'type' => \Elementor\Controls_Manager::MEDIA, 'default' => ['url' => 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=1920']]);
        $this->add_control('subtitle', ['label' => 'Subtitle', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '✨ Welcome to Paradise']);
        $this->add_control('title', ['label' => 'Title', 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'Discover the Magic of Bali']);
        $this->add_control('description', ['label' => 'Description', 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'Experience unforgettable adventures in the Island of Gods']);
        $this->add_control('btn_text', ['label' => 'Button Text', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Explore Tours']);
        $this->add_control('btn_link', ['label' => 'Button Link', 'type' => \Elementor\Controls_Manager::URL]);
        $this->add_control('height', ['label' => 'Height', 'type' => \Elementor\Controls_Manager::SLIDER, 'range' => ['vh' => ['min' => 50, 'max' => 100]], 'default' => ['size' => 90, 'unit' => 'vh']]);
        $this->end_controls_section();
    }

    protected function render()
    {
        $s = $this->get_settings_for_display();
        $bg = $s['bg_image']['url'] ?: 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=1920';
        ?>
        <section class="bbt-hero-section"
            style="min-height:<?php echo esc_attr($s['height']['size'] . $s['height']['unit']); ?>">
            <div class="bbt-hero-bg" style="background-image:url('<?php echo esc_url($bg); ?>')"></div>
            <div class="bbt-hero-overlay"></div>
            <div class="bbt-hero-inner">
                <span class="bbt-hero-subtitle">
                    <?php echo esc_html($s['subtitle']); ?>
                </span>
                <h1 class="bbt-hero-title">
                    <?php echo nl2br(esc_html($s['title'])); ?>
                </h1>
                <p class="bbt-hero-desc">
                    <?php echo esc_html($s['description']); ?>
                </p>
                <?php if ($s['btn_text']): ?><a href="<?php echo esc_url($s['btn_link']['url'] ?? '#'); ?>"
                        class="bbt-hero-btn">
                        <?php echo esc_html($s['btn_text']); ?> →
                    </a>
                <?php endif; ?>
            </div>
        </section>
        <style>
            .bbt-hero-section {
                position: relative;
                display: flex;
                align-items: center;
                justify-content: center;
                text-align: center;
                overflow: hidden
            }

            .bbt-hero-bg {
                position: absolute;
                inset: 0;
                background-size: cover;
                background-position: center;
                animation: bbtHeroBgZoom 30s ease infinite alternate
            }

            @keyframes bbtHeroBgZoom {
                0% {
                    transform: scale(1)
                }

                100% {
                    transform: scale(1.1)
                }
            }

            .bbt-hero-overlay {
                position: absolute;
                inset: 0;
                background: linear-gradient(180deg, rgba(0, 0, 0, .5) 0%, rgba(0, 0, 0, .7) 100%)
            }

            .bbt-hero-inner {
                position: relative;
                z-index: 2;
                color: #fff;
                max-width: 900px;
                padding: 40px
            }

            .bbt-hero-subtitle {
                display: inline-block;
                background: rgba(245, 166, 35, .2);
                border: 1px solid rgba(245, 166, 35, .4);
                padding: 10px 25px;
                border-radius: 30px;
                font-size: 14px;
                margin-bottom: 25px;
                animation: bbtHeroFade .8s ease
            }

            .bbt-hero-title {
                font-size: clamp(36px, 7vw, 72px);
                font-weight: 800;
                line-height: 1.1;
                margin: 0 0 20px;
                animation: bbtHeroFade .8s ease .2s both
            }

            .bbt-hero-desc {
                font-size: 20px;
                opacity: .9;
                margin: 0 0 35px;
                max-width: 600px;
                margin-left: auto;
                margin-right: auto;
                animation: bbtHeroFade .8s ease .4s both
            }

            @keyframes bbtHeroFade {
                from {
                    opacity: 0;
                    transform: translateY(30px)
                }

                to {
                    opacity: 1;
                    transform: translateY(0)
                }
            }

            .bbt-hero-btn {
                display: inline-block;
                padding: 18px 40px;
                background: linear-gradient(135deg, #F5A623, #FFD93D);
                color: #000;
                text-decoration: none;
                border-radius: 50px;
                font-size: 18px;
                font-weight: 700;
                animation: bbtHeroFade .8s ease .6s both;
                transition: all .3s ease
            }

            .bbt-hero-btn:hover {
                transform: translateY(-3px);
                box-shadow: 0 15px 40px rgba(245, 166, 35, .4)
            }
        </style>
        <?php
    }
}
