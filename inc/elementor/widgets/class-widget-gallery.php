<?php
/**
 * Elementor Gallery Widget
 *
 * @package BestBaliTravel
 */

if (!defined('ABSPATH')) {
    exit;
}

class BBT_Widget_Gallery extends \Elementor\Widget_Base
{

    public function get_name()
    {
        return 'bbt-gallery';
    }

    public function get_title()
    {
        return esc_html__('BBT Gallery', 'bestbalitravel');
    }

    public function get_icon()
    {
        return 'eicon-gallery-grid';
    }

    public function get_categories()
    {
        return array('bbt-widgets');
    }

    protected function register_controls()
    {
        $this->start_controls_section(
            'section_gallery',
            array(
                'label' => esc_html__('Gallery', 'bestbalitravel'),
            )
        );

        $this->add_control(
            'source',
            array(
                'label' => esc_html__('Source', 'bestbalitravel'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'manual',
                'options' => array(
                    'manual' => esc_html__('Manual Selection', 'bestbalitravel'),
                    'tour_gallery' => esc_html__('Current Tour Gallery', 'bestbalitravel'),
                    'instagram' => esc_html__('Instagram (Coming Soon)', 'bestbalitravel'),
                ),
            )
        );

        $this->add_control(
            'images',
            array(
                'label' => esc_html__('Add Images', 'bestbalitravel'),
                'type' => \Elementor\Controls_Manager::GALLERY,
                'default' => array(),
                'condition' => array('source' => 'manual'),
            )
        );

        $this->end_controls_section();

        // Layout Section
        $this->start_controls_section(
            'section_layout',
            array(
                'label' => esc_html__('Layout', 'bestbalitravel'),
            )
        );

        $this->add_control(
            'layout',
            array(
                'label' => esc_html__('Layout', 'bestbalitravel'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'grid',
                'options' => array(
                    'grid' => esc_html__('Grid', 'bestbalitravel'),
                    'masonry' => esc_html__('Masonry', 'bestbalitravel'),
                    'justified' => esc_html__('Justified', 'bestbalitravel'),
                    'slider' => esc_html__('Slider', 'bestbalitravel'),
                ),
            )
        );

        $this->add_responsive_control(
            'columns',
            array(
                'label' => esc_html__('Columns', 'bestbalitravel'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '4',
                'options' => array(
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                    '5' => '5',
                    '6' => '6',
                ),
                'condition' => array('layout!' => 'slider'),
            )
        );

        $this->add_control(
            'gap',
            array(
                'label' => esc_html__('Gap', 'bestbalitravel'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => array('px'),
                'range' => array(
                    'px' => array('min' => 0, 'max' => 50, 'step' => 2),
                ),
                'default' => array('unit' => 'px', 'size' => 10),
                'selectors' => array(
                    '{{WRAPPER}} .bbt-gallery-grid' => 'gap: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->add_control(
            'aspect_ratio',
            array(
                'label' => esc_html__('Aspect Ratio', 'bestbalitravel'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'square',
                'options' => array(
                    'square' => esc_html__('1:1 Square', 'bestbalitravel'),
                    'portrait' => esc_html__('3:4 Portrait', 'bestbalitravel'),
                    'landscape' => esc_html__('4:3 Landscape', 'bestbalitravel'),
                    'wide' => esc_html__('16:9 Wide', 'bestbalitravel'),
                    'original' => esc_html__('Original', 'bestbalitravel'),
                ),
                'condition' => array('layout' => 'grid'),
            )
        );

        $this->end_controls_section();

        // Lightbox Section
        $this->start_controls_section(
            'section_lightbox',
            array(
                'label' => esc_html__('Lightbox', 'bestbalitravel'),
            )
        );

        $this->add_control(
            'enable_lightbox',
            array(
                'label' => esc_html__('Enable Lightbox', 'bestbalitravel'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
            )
        );

        $this->add_control(
            'show_caption',
            array(
                'label' => esc_html__('Show Caption', 'bestbalitravel'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
                'condition' => array('enable_lightbox' => 'yes'),
            )
        );

        $this->end_controls_section();

        // Hover Effect Section
        $this->start_controls_section(
            'section_hover',
            array(
                'label' => esc_html__('Hover Effects', 'bestbalitravel'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_control(
            'hover_effect',
            array(
                'label' => esc_html__('Hover Effect', 'bestbalitravel'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'zoom',
                'options' => array(
                    'none' => esc_html__('None', 'bestbalitravel'),
                    'zoom' => esc_html__('Zoom', 'bestbalitravel'),
                    'overlay' => esc_html__('Dark Overlay', 'bestbalitravel'),
                    'blur' => esc_html__('Blur', 'bestbalitravel'),
                    'shine' => esc_html__('Shine', 'bestbalitravel'),
                ),
            )
        );

        $this->add_control(
            'border_radius',
            array(
                'label' => esc_html__('Border Radius', 'bestbalitravel'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => array('px', '%'),
                'range' => array(
                    'px' => array('min' => 0, 'max' => 50),
                    '%' => array('min' => 0, 'max' => 50),
                ),
                'default' => array('unit' => 'px', 'size' => 8),
                'selectors' => array(
                    '{{WRAPPER}} .bbt-gallery-item' => 'border-radius: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $images = array();

        if ('manual' === $settings['source']) {
            $images = $settings['images'];
        } elseif ('tour_gallery' === $settings['source']) {
            $gallery_ids = get_post_meta(get_the_ID(), '_bbt_tour_gallery', true);
            if ($gallery_ids) {
                foreach ((array) $gallery_ids as $id) {
                    $images[] = array('id' => $id, 'url' => wp_get_attachment_url($id));
                }
            }
        }

        if (empty($images)) {
            if (\Elementor\Plugin::$instance->editor->is_edit_mode()) {
                echo '<p style="text-align:center;padding:40px;">No images selected</p>';
            }
            return;
        }

        $columns = $settings['columns'] ?? '4';
        $gallery_id = 'bbt-gallery-' . $this->get_id();
        ?>

        <div id="<?php echo esc_attr($gallery_id); ?>"
            class="bbt-gallery bbt-gallery-<?php echo esc_attr($settings['layout']); ?> bbt-cols-<?php echo esc_attr($columns); ?> bbt-hover-<?php echo esc_attr($settings['hover_effect']); ?> bbt-ratio-<?php echo esc_attr($settings['aspect_ratio']); ?>">

            <div class="bbt-gallery-grid">
                <?php foreach ($images as $index => $image):
                    $image_url = is_array($image) ? ($image['url'] ?? '') : wp_get_attachment_url($image);
                    $image_id = is_array($image) ? ($image['id'] ?? 0) : $image;
                    $full_url = wp_get_attachment_image_url($image_id, 'full');
                    $caption = wp_get_attachment_caption($image_id);
                    ?>
                    <div class="bbt-gallery-item">
                        <?php if ('yes' === $settings['enable_lightbox']): ?>
                            <a href="<?php echo esc_url($full_url); ?>" class="bbt-lightbox-trigger"
                                data-gallery="<?php echo esc_attr($gallery_id); ?>" data-caption="<?php echo esc_attr($caption); ?>">
                            <?php endif; ?>

                            <div class="bbt-gallery-image">
                                <?php echo wp_get_attachment_image($image_id, 'medium_large'); ?>
                            </div>

                            <div class="bbt-gallery-overlay">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="11" cy="11" r="8" />
                                    <line x1="21" y1="21" x2="16.65" y2="16.65" />
                                    <line x1="11" y1="8" x2="11" y2="14" />
                                    <line x1="8" y1="11" x2="14" y2="11" />
                                </svg>
                            </div>

                            <?php if ('yes' === $settings['enable_lightbox']): ?>
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <?php
    }
}
