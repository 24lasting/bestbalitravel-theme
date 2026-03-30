<?php
if (!defined('ABSPATH'))
    exit;

class BBT_Widget_Video_Background extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'bbt-video-background';
    }
    public function get_title()
    {
        return esc_html__('Video Background Section', 'bestbalitravel');
    }
    public function get_icon()
    {
        return 'eicon-video-camera';
    }
    public function get_categories()
    {
        return ['bbt-widgets'];
    }

    protected function register_controls()
    {
        $this->start_controls_section('section_content', ['label' => 'Content']);
        $this->add_control('video_url', ['label' => 'Video URL (YouTube/MP4)', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ']);
        $this->add_control('title', ['label' => 'Title', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Explore Bali']);
        $this->add_control('subtitle', ['label' => 'Subtitle', 'type' => \Elementor\Controls_Manager::TEXTAREA]);
        $this->add_control('btn_text', ['label' => 'Button', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Watch Video']);
        $this->add_control('height', ['label' => 'Height', 'type' => \Elementor\Controls_Manager::SLIDER, 'range' => ['px' => ['min' => 300, 'max' => 800]], 'default' => ['size' => 500]]);
        $this->end_controls_section();
    }

    protected function render()
    {
        $s = $this->get_settings_for_display();
        $ytId = preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([a-zA-Z0-9_-]+)/', $s['video_url'], $m) ? $m[1] : '';
        ?>
        <div class="bbt-video-bg-section" style="height:<?php echo esc_attr($s['height']['size']); ?>px">
            <?php if ($ytId): ?>
                <div class="bbt-vb-video"><iframe
                        src="https://www.youtube.com/embed/<?php echo esc_attr($ytId); ?>?autoplay=1&mute=1&loop=1&playlist=<?php echo esc_attr($ytId); ?>&controls=0"
                        frameborder="0" allow="autoplay"></iframe></div>
            <?php endif; ?>
            <div class="bbt-vb-overlay"></div>
            <div class="bbt-vb-content">
                <h2>
                    <?php echo esc_html($s['title']); ?>
                </h2>
                <?php if ($s['subtitle']): ?>
                    <p>
                        <?php echo esc_html($s['subtitle']); ?>
                    </p>
                <?php endif; ?>
                <?php if ($s['btn_text']): ?><button class="bbt-vb-btn">
                        <?php echo $s['btn_text']; ?>
                    </button>
                <?php endif; ?>
            </div>
        </div>
        <style>
            .bbt-video-bg-section {
                position: relative;
                border-radius: 24px;
                overflow: hidden;
                display: flex;
                align-items: center;
                justify-content: center
            }

            .bbt-vb-video {
                position: absolute;
                inset: -100px;
                pointer-events: none
            }

            .bbt-vb-video iframe {
                width: 300%;
                height: 300%;
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%)
            }

            .bbt-vb-overlay {
                position: absolute;
                inset: 0;
                background: rgba(0, 0, 0, .6)
            }

            .bbt-vb-content {
                position: relative;
                z-index: 2;
                text-align: center;
                color: #fff;
                padding: 40px
            }

            .bbt-vb-content h2 {
                font-size: 48px;
                margin: 0 0 15px
            }

            .bbt-vb-content p {
                font-size: 18px;
                opacity: .9;
                margin: 0 0 25px
            }

            .bbt-vb-btn {
                padding: 15px 35px;
                background: #F5A623;
                border: none;
                border-radius: 30px;
                font-size: 16px;
                font-weight: 600;
                cursor: pointer
            }
        </style>
        <?php
    }
}
