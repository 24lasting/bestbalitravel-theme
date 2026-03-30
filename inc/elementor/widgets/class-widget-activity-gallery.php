<?php
if (!defined('ABSPATH'))
    exit;

class BBT_Widget_Activity_Gallery extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'bbt-activity-gallery';
    }
    public function get_title()
    {
        return esc_html__('Activity Gallery', 'bestbalitravel');
    }
    public function get_icon()
    {
        return 'eicon-gallery-grid';
    }
    public function get_categories()
    {
        return ['bbt-widgets'];
    }

    protected function register_controls()
    {
        $this->start_controls_section('section_gallery', ['label' => 'Gallery']);
        $this->add_control('images', ['label' => 'Images', 'type' => \Elementor\Controls_Manager::GALLERY]);
        $this->end_controls_section();
    }

    protected function render()
    {
        $s = $this->get_settings_for_display();
        $images = $s['images'] ?: [
            ['url' => 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=800'],
            ['url' => 'https://images.unsplash.com/photo-1555400038-63f5ba517a47?w=800'],
            ['url' => 'https://images.unsplash.com/photo-1552733407-5d5c46c3bb3b?w=800'],
            ['url' => 'https://images.unsplash.com/photo-1544644181-1484b3fdfc62?w=800'],
        ];
        ?>
        <div class="bbt-activity-gallery">
            <div class="bbt-ag-main"><img src="<?php echo esc_url($images[0]['url']); ?>" alt=""></div>
            <div class="bbt-ag-thumbs">
                <?php foreach (array_slice($images, 1, 4) as $i => $img): ?>
                    <div class="bbt-ag-thumb<?php echo $i === 3 ? ' more' : ''; ?>">
                        <img src="<?php echo esc_url($img['url']); ?>" alt="">
                        <?php if ($i === 3 && count($images) > 5): ?><span>+
                                <?php echo count($images) - 4; ?>
                            </span>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <style>
            .bbt-activity-gallery {
                display: grid;
                grid-template-columns: 2fr 1fr;
                gap: 15px;
                border-radius: 20px;
                overflow: hidden
            }

            .bbt-ag-main {
                grid-row: span 2
            }

            .bbt-ag-main img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                min-height: 400px
            }

            .bbt-ag-thumbs {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 15px
            }

            .bbt-ag-thumb {
                position: relative;
                overflow: hidden;
                border-radius: 12px
            }

            .bbt-ag-thumb img {
                width: 100%;
                height: 180px;
                object-fit: cover;
                transition: transform .4s ease
            }

            .bbt-ag-thumb:hover img {
                transform: scale(1.1)
            }

            .bbt-ag-thumb.more span {
                position: absolute;
                inset: 0;
                background: rgba(0, 0, 0, .6);
                display: flex;
                align-items: center;
                justify-content: center;
                color: #fff;
                font-size: 24px;
                font-weight: 700
            }

            @media(max-width:768px) {
                .bbt-activity-gallery {
                    grid-template-columns: 1fr
                }

                .bbt-ag-main {
                    grid-row: auto
                }
            }
        </style>
        <?php
    }
}
