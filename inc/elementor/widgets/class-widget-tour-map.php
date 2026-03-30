<?php
/**
 * Elementor Tour Map Widget
 *
 * @package BestBaliTravel
 */

if (!defined('ABSPATH'))
    exit;

class BBT_Widget_Tour_Map extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'bbt-tour-map';
    }
    public function get_title()
    {
        return esc_html__('Tour Map', 'bestbalitravel');
    }
    public function get_icon()
    {
        return 'eicon-google-maps';
    }
    public function get_categories()
    {
        return ['bbt-widgets'];
    }

    protected function register_controls()
    {
        $this->start_controls_section('section_map', ['label' => 'Map Settings']);

        $this->add_control('lat', ['label' => 'Latitude', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '-8.4095']);
        $this->add_control('lng', ['label' => 'Longitude', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '115.1889']);
        $this->add_control('zoom', ['label' => 'Zoom', 'type' => \Elementor\Controls_Manager::SLIDER, 'range' => ['px' => ['min' => 5, 'max' => 18]], 'default' => ['size' => 10]]);
        $this->add_responsive_control('height', ['label' => 'Height', 'type' => \Elementor\Controls_Manager::SLIDER, 'range' => ['px' => ['min' => 200, 'max' => 600]], 'default' => ['size' => 400]]);

        $repeater = new \Elementor\Repeater();
        $repeater->add_control('title', ['label' => 'Title', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Location']);
        $repeater->add_control('lat', ['label' => 'Latitude', 'type' => \Elementor\Controls_Manager::TEXT]);
        $repeater->add_control('lng', ['label' => 'Longitude', 'type' => \Elementor\Controls_Manager::TEXT]);

        $this->add_control('markers', [
            'label' => 'Markers',
            'type' => \Elementor\Controls_Manager::REPEATER,
            'fields' => $repeater->get_controls(),
            'default' => [
                ['title' => 'Ubud Palace', 'lat' => '-8.5069', 'lng' => '115.2625'],
                ['title' => 'Tanah Lot', 'lat' => '-8.6210', 'lng' => '115.0867'],
                ['title' => 'Uluwatu Temple', 'lat' => '-8.8291', 'lng' => '115.0849'],
            ],
        ]);

        $this->end_controls_section();
    }

    protected function render()
    {
        $s = $this->get_settings_for_display();
        $height = $s['height']['size'] . 'px';
        $markers = $s['markers'];
        ?>
        <div class="bbt-tour-map" style="height:<?php echo esc_attr($height); ?>">
            <div class="bbt-map-container">
                <iframe style="width:100%;height:100%;border:0;border-radius:20px" loading="lazy"
                    src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d500000!2d<?php echo esc_attr($s['lng']); ?>!3d<?php echo esc_attr($s['lat']); ?>!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2sid!4v1"
                    allowfullscreen>
                </iframe>
            </div>

            <?php if (!empty($markers)): ?>
                <div class="bbt-map-markers">
                    <?php foreach ($markers as $i => $m): ?>
                        <div class="bbt-marker-item" style="--d:<?php echo $i * 0.1; ?>s">
                            <span class="bbt-marker-icon">📍</span>
                            <span class="bbt-marker-title">
                                <?php echo esc_html($m['title']); ?>
                            </span>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
        <style>
            .bbt-tour-map {
                position: relative;
                border-radius: 20px;
                overflow: hidden;
                box-shadow: 0 20px 50px rgba(0, 0, 0, .1)
            }

            .bbt-map-container {
                position: absolute;
                inset: 0
            }

            .bbt-map-markers {
                position: absolute;
                bottom: 20px;
                left: 20px;
                right: 20px;
                display: flex;
                gap: 10px;
                flex-wrap: wrap
            }

            .bbt-marker-item {
                display: flex;
                align-items: center;
                gap: 8px;
                padding: 10px 16px;
                background: rgba(255, 255, 255, .95);
                backdrop-filter: blur(10px);
                border-radius: 30px;
                font-size: 13px;
                font-weight: 600;
                box-shadow: 0 4px 15px rgba(0, 0, 0, .1);
                opacity: 0;
                animation: bbtMarkerFade .4s ease forwards;
                animation-delay: var(--d)
            }

            @keyframes bbtMarkerFade {
                to {
                    opacity: 1
                }
            }

            .bbt-marker-item:hover {
                transform: translateY(-3px);
                box-shadow: 0 8px 25px rgba(0, 0, 0, .15)
            }
        </style>
        <?php
    }
}
