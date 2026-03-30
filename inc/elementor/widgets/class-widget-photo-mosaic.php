<?php
/**
 * Elementor Photo Mosaic Widget
 *
 * @package BestBaliTravel
 */

if (!defined('ABSPATH'))
    exit;

class BBT_Widget_Photo_Mosaic extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'bbt-photo-mosaic';
    }
    public function get_title()
    {
        return esc_html__('Photo Mosaic', 'bestbalitravel');
    }
    public function get_icon()
    {
        return 'eicon-gallery-masonry';
    }
    public function get_categories()
    {
        return ['bbt-widgets'];
    }

    protected function register_controls()
    {
        $this->start_controls_section('section_gallery', ['label' => 'Gallery']);

        $this->add_control('images', [
            'label' => 'Images',
            'type' => \Elementor\Controls_Manager::GALLERY,
            'default' => [],
        ]);

        $this->add_control('lightbox', ['label' => 'Enable Lightbox', 'type' => \Elementor\Controls_Manager::SWITCHER, 'default' => 'yes']);
        $this->add_control('columns', ['label' => 'Columns', 'type' => \Elementor\Controls_Manager::SELECT, 'options' => ['3' => '3', '4' => '4', '5' => '5'], 'default' => '4']);

        $this->end_controls_section();
    }

    protected function render()
    {
        $s = $this->get_settings_for_display();
        $images = $s['images'];
        $cols = $s['columns'];

        // Fallback images if none selected
        if (empty($images)) {
            $images = [
                ['url' => 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=600'],
                ['url' => 'https://images.unsplash.com/photo-1555400038-63f5ba517a47?w=600'],
                ['url' => 'https://images.unsplash.com/photo-1552733407-5d5c46c3bb3b?w=600'],
                ['url' => 'https://images.unsplash.com/photo-1544644181-1484b3fdfc62?w=600'],
                ['url' => 'https://images.unsplash.com/photo-1518548419970-58e3b4079ab2?w=600'],
                ['url' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=600'],
                ['url' => 'https://images.unsplash.com/photo-1501179691627-eeaa65ea017c?w=600'],
                ['url' => 'https://images.unsplash.com/photo-1573790387438-4da905039392?w=600'],
            ];
        }
        ?>
        <div class="bbt-photo-mosaic" style="--cols:<?php echo esc_attr($cols); ?>">
            <?php foreach ($images as $i => $img):
                $url = is_array($img) ? $img['url'] : $img;
                $span = ($i % 5 === 0) ? 'large' : 'normal';
                ?>
                <div class="bbt-mosaic-item <?php echo $span; ?>" style="--d:<?php echo $i * 0.08; ?>s">
                    <img src="<?php echo esc_url($url); ?>" alt="Gallery image" loading="lazy">
                    <div class="bbt-mosaic-overlay">
                        <span class="bbt-mosaic-zoom">🔍</span>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <style>
            .bbt-photo-mosaic {
                display: grid;
                grid-template-columns: repeat(var(--cols), 1fr);
                gap: 15px
            }

            .bbt-mosaic-item {
                position: relative;
                border-radius: 16px;
                overflow: hidden;
                cursor: pointer;
                opacity: 0;
                animation: bbtMosaicFade .5s ease forwards;
                animation-delay: var(--d)
            }

            @keyframes bbtMosaicFade {
                to {
                    opacity: 1
                }
            }

            .bbt-mosaic-item.large {
                grid-column: span 2;
                grid-row: span 2
            }

            .bbt-mosaic-item img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                min-height: 200px;
                transition: transform .6s ease
            }

            .bbt-mosaic-item.large img {
                min-height: 415px
            }

            .bbt-mosaic-item:hover img {
                transform: scale(1.1)
            }

            .bbt-mosaic-overlay {
                position: absolute;
                inset: 0;
                background: rgba(0, 0, 0, .5);
                display: flex;
                align-items: center;
                justify-content: center;
                opacity: 0;
                transition: opacity .3s ease
            }

            .bbt-mosaic-item:hover .bbt-mosaic-overlay {
                opacity: 1
            }

            .bbt-mosaic-zoom {
                width: 50px;
                height: 50px;
                background: #fff;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 24px;
                transform: scale(0);
                transition: transform .3s ease
            }

            .bbt-mosaic-item:hover .bbt-mosaic-zoom {
                transform: scale(1)
            }

            @media(max-width:768px) {
                .bbt-photo-mosaic {
                    grid-template-columns: repeat(2, 1fr)
                }

                .bbt-mosaic-item.large {
                    grid-column: span 1;
                    grid-row: span 1
                }
            }
        </style>
        <?php
    }
}
