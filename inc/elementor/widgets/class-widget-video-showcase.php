<?php
/**
 * Elementor Tour Video Showcase Widget
 * Hero video with play overlay
 *
 * @package BestBaliTravel
 */

if (!defined('ABSPATH')) {
    exit;
}

class BBT_Widget_Video_Showcase extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'bbt-video-showcase';
    }
    public function get_title()
    {
        return esc_html__('Video Showcase', 'bestbalitravel');
    }
    public function get_icon()
    {
        return 'eicon-youtube';
    }
    public function get_categories()
    {
        return ['bbt-widgets'];
    }

    protected function register_controls()
    {
        $this->start_controls_section('section_video', [
            'label' => esc_html__('Video', 'bestbalitravel'),
        ]);

        $this->add_control('video_type', [
            'label' => esc_html__('Video Type', 'bestbalitravel'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'options' => [
                'youtube' => 'YouTube',
                'vimeo' => 'Vimeo',
                'self' => 'Self Hosted',
            ],
            'default' => 'youtube',
        ]);

        $this->add_control('youtube_url', [
            'label' => esc_html__('YouTube URL', 'bestbalitravel'),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
            'condition' => ['video_type' => 'youtube'],
        ]);

        $this->add_control('thumbnail', [
            'label' => esc_html__('Thumbnail Image', 'bestbalitravel'),
            'type' => \Elementor\Controls_Manager::MEDIA,
            'default' => ['url' => 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=1200'],
        ]);

        $this->add_control('title', [
            'label' => esc_html__('Title', 'bestbalitravel'),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => 'Discover Bali Paradise',
        ]);

        $this->add_control('subtitle', [
            'label' => esc_html__('Subtitle', 'bestbalitravel'),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => 'Watch our latest tour highlights',
        ]);

        $this->add_responsive_control('height', [
            'label' => esc_html__('Height', 'bestbalitravel'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['px', 'vh'],
            'range' => ['px' => ['min' => 200, 'max' => 800], 'vh' => ['min' => 20, 'max' => 100]],
            'default' => ['unit' => 'px', 'size' => 500],
        ]);

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $thumbnail = $settings['thumbnail']['url'] ?: 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=1200';
        $height = $settings['height']['size'] . $settings['height']['unit'];

        // Extract YouTube ID
        $video_id = '';
        if ($settings['video_type'] === 'youtube' && !empty($settings['youtube_url'])) {
            preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $settings['youtube_url'], $matches);
            $video_id = $matches[1] ?? '';
        }
        ?>
        <div class="bbt-video-showcase" style="height: <?php echo esc_attr($height); ?>">
            <div class="bbt-video-thumbnail" style="background-image: url('<?php echo esc_url($thumbnail); ?>')">
                <div class="bbt-video-overlay"></div>

                <div class="bbt-video-content">
                    <?php if ($settings['title']): ?>
                        <h2 class="bbt-video-title">
                            <?php echo esc_html($settings['title']); ?>
                        </h2>
                    <?php endif; ?>

                    <?php if ($settings['subtitle']): ?>
                        <p class="bbt-video-subtitle">
                            <?php echo esc_html($settings['subtitle']); ?>
                        </p>
                    <?php endif; ?>

                    <button class="bbt-play-button" data-video-id="<?php echo esc_attr($video_id); ?>">
                        <span class="bbt-play-icon">
                            <svg width="30" height="30" viewBox="0 0 24 24" fill="currentColor">
                                <polygon points="5 3 19 12 5 21 5 3"></polygon>
                            </svg>
                        </span>
                        <span class="bbt-play-text">
                            <?php esc_html_e('Watch Video', 'bestbalitravel'); ?>
                        </span>
                    </button>
                </div>
            </div>

            <div class="bbt-video-modal" style="display: none;">
                <div class="bbt-modal-backdrop"></div>
                <div class="bbt-modal-content">
                    <button class="bbt-modal-close">&times;</button>
                    <div class="bbt-video-player"></div>
                </div>
            </div>
        </div>

        <style>
            .bbt-video-showcase {
                position: relative;
                border-radius: 24px;
                overflow: hidden;
            }

            .bbt-video-thumbnail {
                position: absolute;
                inset: 0;
                background-size: cover;
                background-position: center;
                animation: bbtVideoZoom 20s ease infinite alternate;
            }

            @keyframes bbtVideoZoom {
                0% {
                    transform: scale(1);
                }

                100% {
                    transform: scale(1.1);
                }
            }

            .bbt-video-overlay {
                position: absolute;
                inset: 0;
                background: linear-gradient(180deg, rgba(0, 0, 0, 0.3) 0%, rgba(0, 0, 0, 0.7) 100%);
            }

            .bbt-video-content {
                position: absolute;
                inset: 0;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                text-align: center;
                color: #fff;
                padding: 40px;
            }

            .bbt-video-title {
                font-size: clamp(28px, 5vw, 48px);
                font-weight: 700;
                margin: 0 0 15px;
                animation: bbtFadeUp 0.8s ease forwards;
            }

            .bbt-video-subtitle {
                font-size: 18px;
                opacity: 0.9;
                margin: 0 0 30px;
                animation: bbtFadeUp 0.8s ease 0.2s forwards;
                opacity: 0;
            }

            @keyframes bbtFadeUp {
                from {
                    opacity: 0;
                    transform: translateY(20px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .bbt-play-button {
                display: flex;
                align-items: center;
                gap: 15px;
                padding: 18px 35px;
                background: rgba(255, 255, 255, 0.15);
                backdrop-filter: blur(10px);
                border: 2px solid rgba(255, 255, 255, 0.3);
                border-radius: 50px;
                color: #fff;
                cursor: pointer;
                transition: all 0.4s ease;
                animation: bbtPulse 2s ease infinite;
            }

            .bbt-play-button:hover {
                background: #F5A623;
                border-color: #F5A623;
                color: #000;
                transform: scale(1.05);
            }

            @keyframes bbtPulse {

                0%,
                100% {
                    box-shadow: 0 0 0 0 rgba(245, 166, 35, 0.5);
                }

                50% {
                    box-shadow: 0 0 0 20px rgba(245, 166, 35, 0);
                }
            }

            .bbt-play-icon {
                width: 50px;
                height: 50px;
                background: #F5A623;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                color: #000;
            }

            .bbt-play-text {
                font-size: 16px;
                font-weight: 600;
            }

            .bbt-video-modal {
                position: fixed;
                inset: 0;
                z-index: 9999;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .bbt-modal-backdrop {
                position: absolute;
                inset: 0;
                background: rgba(0, 0, 0, 0.9);
            }

            .bbt-modal-content {
                position: relative;
                width: 90%;
                max-width: 1000px;
                aspect-ratio: 16/9;
                background: #000;
                border-radius: 16px;
                overflow: hidden;
            }

            .bbt-modal-close {
                position: absolute;
                top: -40px;
                right: 0;
                background: none;
                border: none;
                color: #fff;
                font-size: 30px;
                cursor: pointer;
            }
        </style>
        <?php
    }
}
