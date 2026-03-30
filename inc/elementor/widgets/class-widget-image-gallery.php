<?php
if (!defined('ABSPATH'))
    exit;

class BBT_Widget_Image_Gallery extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'bbt-image-gallery';
    }
    public function get_title()
    {
        return esc_html__('Image Gallery', 'bestbalitravel');
    }
    public function get_icon()
    {
        return 'eicon-gallery-group';
    }
    public function get_categories()
    {
        return ['bbt-widgets'];
    }

    protected function register_controls()
    {
        $this->start_controls_section('section_gallery', ['label' => 'Gallery']);
        $this->add_control('images', ['label' => 'Images', 'type' => \Elementor\Controls_Manager::GALLERY]);
        $this->add_control('columns', ['label' => 'Columns', 'type' => \Elementor\Controls_Manager::SELECT, 'options' => ['2' => '2', '3' => '3', '4' => '4'], 'default' => '3']);
        $this->add_control('gap', ['label' => 'Gap', 'type' => \Elementor\Controls_Manager::SLIDER, 'default' => ['size' => 15]]);
        $this->add_control('lightbox', ['label' => 'Enable Lightbox', 'type' => \Elementor\Controls_Manager::SWITCHER, 'default' => 'yes']);
        $this->end_controls_section();
    }

    protected function render()
    {
        $s = $this->get_settings_for_display();
        $images = $s['images'] ?: [['url' => 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=600'], ['url' => 'https://images.unsplash.com/photo-1555400038-63f5ba517a47?w=600'], ['url' => 'https://images.unsplash.com/photo-1552733407-5d5c46c3bb3b?w=600'], ['url' => 'https://images.unsplash.com/photo-1544644181-1484b3fdfc62?w=600'], ['url' => 'https://images.unsplash.com/photo-1518548419970-58e3b4079ab2?w=600'], ['url' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=600']];
        ?>
        <div class="bbt-image-gallery"
            style="--cols:<?php echo esc_attr($s['columns']); ?>;--gap:<?php echo esc_attr($s['gap']['size']); ?>px">
            <?php foreach ($images as $i => $img): ?>
                <div class="bbt-gallery-item" style="--d:<?php echo $i * 0.1; ?>s">
                    <img src="<?php echo esc_url($img['url']); ?>" alt="">
                    <div class="bbt-gallery-overlay"><span>🔍</span></div>
                </div>
            <?php endforeach; ?>
        </div>
        <style>
            .bbt-image-gallery {
                display: grid;
                grid-template-columns: repeat(var(--cols), 1fr);
                gap: var(--gap)
            }

            .bbt-gallery-item {
                position: relative;
                border-radius: 16px;
                overflow: hidden;
                cursor: pointer;
                opacity: 0;
                animation: bbtGalFade .5s ease forwards;
                animation-delay: var(--d)
            }

            @keyframes bbtGalFade {
                to {
                    opacity: 1
                }
            }

            .bbt-gallery-item img {
                width: 100%;
                aspect-ratio: 1;
                object-fit: cover;
                transition: transform .5s ease
            }

            .bbt-gallery-item:hover img {
                transform: scale(1.1)
            }

            .bbt-gallery-overlay {
                position: absolute;
                inset: 0;
                background: rgba(0, 0, 0, .5);
                display: flex;
                align-items: center;
                justify-content: center;
                opacity: 0;
                transition: opacity .3s ease
            }

            .bbt-gallery-item:hover .bbt-gallery-overlay {
                opacity: 1
            }

            .bbt-gallery-overlay span {
                width: 50px;
                height: 50px;
                background: #fff;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 24px
            }
        </style>
        <?php
    }
}
