<?php
if (!defined('ABSPATH'))
    exit;

class BBT_Widget_Tiktok_Feed extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'bbt-tiktok-feed';
    }
    public function get_title()
    {
        return esc_html__('TikTok Feed', 'bestbalitravel');
    }
    public function get_icon()
    {
        return 'eicon-social-icons';
    }
    public function get_categories()
    {
        return ['bbt-widgets'];
    }

    protected function register_controls()
    {
        $this->start_controls_section('section_content', ['label' => 'Settings']);
        $this->add_control('username', ['label' => 'Username', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '@bestbalitravel']);
        $this->add_control('videos', ['label' => 'Video Thumbnails', 'type' => \Elementor\Controls_Manager::GALLERY]);
        $this->end_controls_section();
    }

    protected function render()
    {
        $s = $this->get_settings_for_display();
        $videos = $s['videos'] ?: [['url' => 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=400'], ['url' => 'https://images.unsplash.com/photo-1555400038-63f5ba517a47?w=400'], ['url' => 'https://images.unsplash.com/photo-1552733407-5d5c46c3bb3b?w=400'], ['url' => 'https://images.unsplash.com/photo-1544644181-1484b3fdfc62?w=400']];
        ?>
        <div class="bbt-tiktok-feed">
            <div class="bbt-tf-header"><span class="bbt-tf-icon">🎵</span>
                <div>
                    <h3>TikTok</h3><span>
                        <?php echo esc_html($s['username']); ?>
                    </span>
                </div><a href="https://tiktok.com" target="_blank" class="bbt-tf-btn">Follow</a>
            </div>
            <div class="bbt-tf-grid">
                <?php foreach ($videos as $v): ?>
                    <div class="bbt-tf-item"><img src="<?php echo esc_url($v['url']); ?>" alt="">
                        <div class="bbt-tf-play">▶</div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <style>
            .bbt-tiktok-feed {
                background: #fff;
                padding: 25px;
                border-radius: 20px;
                box-shadow: 0 10px 40px rgba(0, 0, 0, .08)
            }

            .bbt-tf-header {
                display: flex;
                align-items: center;
                gap: 15px;
                margin-bottom: 20px
            }

            .bbt-tf-icon {
                font-size: 40px
            }

            .bbt-tf-header h3 {
                margin: 0;
                font-size: 18px
            }

            .bbt-tf-header>div span {
                color: #666;
                font-size: 14px
            }

            .bbt-tf-btn {
                margin-left: auto;
                padding: 10px 25px;
                background: #000;
                color: #fff;
                text-decoration: none;
                border-radius: 25px;
                font-weight: 600
            }

            .bbt-tf-grid {
                display: grid;
                grid-template-columns: repeat(4, 1fr);
                gap: 12px
            }

            .bbt-tf-item {
                position: relative;
                aspect-ratio: 9/16;
                border-radius: 12px;
                overflow: hidden
            }

            .bbt-tf-item img {
                width: 100%;
                height: 100%;
                object-fit: cover
            }

            .bbt-tf-play {
                position: absolute;
                inset: 0;
                display: flex;
                align-items: center;
                justify-content: center;
                background: rgba(0, 0, 0, .3);
                color: #fff;
                font-size: 24px;
                opacity: 0;
                transition: opacity .3s ease
            }

            .bbt-tf-item:hover .bbt-tf-play {
                opacity: 1
            }
        </style>
        <?php
    }
}
