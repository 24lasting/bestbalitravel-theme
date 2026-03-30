<?php
/**
 * Elementor Before/After Gallery Widget
 *
 * @package BestBaliTravel
 */

if (!defined('ABSPATH'))
    exit;

class BBT_Widget_Before_After extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'bbt-before-after';
    }
    public function get_title()
    {
        return esc_html__('Before/After Gallery', 'bestbalitravel');
    }
    public function get_icon()
    {
        return 'eicon-image-before-after';
    }
    public function get_categories()
    {
        return ['bbt-widgets'];
    }

    protected function register_controls()
    {
        $this->start_controls_section('section_images', ['label' => 'Images']);

        $this->add_control('before_image', [
            'label' => 'Before Image',
            'type' => \Elementor\Controls_Manager::MEDIA,
            'default' => ['url' => 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=800'],
        ]);

        $this->add_control('after_image', [
            'label' => 'After Image',
            'type' => \Elementor\Controls_Manager::MEDIA,
            'default' => ['url' => 'https://images.unsplash.com/photo-1552733407-5d5c46c3bb3b?w=800'],
        ]);

        $this->add_control('before_label', ['label' => 'Before Label', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Before']);
        $this->add_control('after_label', ['label' => 'After Label', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'After']);

        $this->end_controls_section();
    }

    protected function render()
    {
        $s = $this->get_settings_for_display();
        $id = 'ba-' . uniqid();
        $before = $s['before_image']['url'] ?: 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=800';
        $after = $s['after_image']['url'] ?: 'https://images.unsplash.com/photo-1552733407-5d5c46c3bb3b?w=800';
        ?>
        <div class="bbt-before-after" id="<?php echo $id; ?>">
            <div class="bbt-ba-container">
                <div class="bbt-ba-after"><img src="<?php echo esc_url($after); ?>" alt="After"><span class="bbt-ba-label">
                        <?php echo esc_html($s['after_label']); ?>
                    </span></div>
                <div class="bbt-ba-before"><img src="<?php echo esc_url($before); ?>" alt="Before"><span class="bbt-ba-label">
                        <?php echo esc_html($s['before_label']); ?>
                    </span></div>
                <div class="bbt-ba-slider">
                    <div class="bbt-ba-handle"><svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M8 5v14l-6-7zm8 0v14l6-7z" />
                        </svg></div>
                </div>
            </div>
        </div>
        <style>
            .bbt-before-after {
                position: relative;
                border-radius: 20px;
                overflow: hidden;
                box-shadow: 0 20px 50px rgba(0, 0, 0, .15)
            }

            .bbt-ba-container {
                position: relative;
                width: 100%;
                aspect-ratio: 16/10;
                cursor: ew-resize
            }

            .bbt-ba-before,
            .bbt-ba-after {
                position: absolute;
                inset: 0
            }

            .bbt-ba-before {
                width: 50%;
                overflow: hidden;
                z-index: 2
            }

            .bbt-ba-before img,
            .bbt-ba-after img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                position: absolute;
                top: 0;
                left: 0
            }

            .bbt-ba-before img {
                min-width: 100%;
                width: auto
            }

            .bbt-ba-label {
                position: absolute;
                bottom: 20px;
                padding: 8px 16px;
                background: rgba(0, 0, 0, .7);
                color: #fff;
                font-size: 12px;
                font-weight: 600;
                border-radius: 20px;
                text-transform: uppercase
            }

            .bbt-ba-before .bbt-ba-label {
                left: 20px
            }

            .bbt-ba-after .bbt-ba-label {
                right: 20px
            }

            .bbt-ba-slider {
                position: absolute;
                top: 0;
                bottom: 0;
                left: 50%;
                width: 4px;
                background: #F5A623;
                z-index: 3;
                cursor: ew-resize;
                transform: translateX(-50%)
            }

            .bbt-ba-handle {
                position: absolute;
                top: 50%;
                left: 50%;
                width: 44px;
                height: 44px;
                background: #F5A623;
                border-radius: 50%;
                transform: translate(-50%, -50%);
                display: flex;
                align-items: center;
                justify-content: center;
                color: #fff;
                box-shadow: 0 4px 15px rgba(245, 166, 35, .5)
            }
        </style>
        <script>
            (function () {
                var el = document.getElementById('<?php echo $id; ?>');
                var slider = el.querySelector('.bbt-ba-slider');
                var before = el.querySelector('.bbt-ba-before');
                var container = el.querySelector('.bbt-ba-container');
                var dragging = false;
                function move(e) {
                    if (!dragging) return;
                    var rect = container.getBoundingClientRect();
                    var x = (e.clientX || e.touches[0].clientX) - rect.left;
                    var pct = Math.max(0, Math.min(100, x / rect.width * 100));
                    slider.style.left = pct + '%';
                    before.style.width = pct + '%';
                }
                slider.addEventListener('mousedown', function () { dragging = true });
                slider.addEventListener('touchstart', function () { dragging = true });
                document.addEventListener('mouseup', function () { dragging = false });
                document.addEventListener('touchend', function () { dragging = false });
                document.addEventListener('mousemove', move);
                document.addEventListener('touchmove', move);
            })();
        </script>
        <?php
    }
}
