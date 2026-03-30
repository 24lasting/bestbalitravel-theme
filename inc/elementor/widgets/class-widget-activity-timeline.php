<?php
/**
 * Elementor Activity Timeline Widget
 * Display day-by-day itinerary in timeline format
 *
 * @package BestBaliTravel
 */

if (!defined('ABSPATH')) {
    exit;
}

class BBT_Widget_Activity_Timeline extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'bbt-activity-timeline';
    }

    public function get_title()
    {
        return esc_html__('Activity Timeline', 'bestbalitravel');
    }

    public function get_icon()
    {
        return 'eicon-time-line';
    }

    public function get_categories()
    {
        return ['bbt-widgets'];
    }

    public function get_keywords()
    {
        return ['timeline', 'itinerary', 'activity', 'schedule', 'day'];
    }

    protected function register_controls()
    {
        $this->start_controls_section('section_timeline', [
            'label' => esc_html__('Timeline Items', 'bestbalitravel'),
            'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
        ]);

        $repeater = new \Elementor\Repeater();

        $repeater->add_control('day_number', [
            'label' => esc_html__('Day/Time', 'bestbalitravel'),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => 'Day 1',
        ]);

        $repeater->add_control('title', [
            'label' => esc_html__('Title', 'bestbalitravel'),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => 'Activity Title',
        ]);

        $repeater->add_control('description', [
            'label' => esc_html__('Description', 'bestbalitravel'),
            'type' => \Elementor\Controls_Manager::TEXTAREA,
            'default' => 'Description of this activity...',
        ]);

        $repeater->add_control('icon', [
            'label' => esc_html__('Icon', 'bestbalitravel'),
            'type' => \Elementor\Controls_Manager::ICONS,
            'default' => ['value' => 'fas fa-map-marker-alt', 'library' => 'fa-solid'],
        ]);

        $repeater->add_control('image', [
            'label' => esc_html__('Image', 'bestbalitravel'),
            'type' => \Elementor\Controls_Manager::MEDIA,
        ]);

        $this->add_control('timeline_items', [
            'label' => esc_html__('Timeline Items', 'bestbalitravel'),
            'type' => \Elementor\Controls_Manager::REPEATER,
            'fields' => $repeater->get_controls(),
            'default' => [
                ['day_number' => '08:00 AM', 'title' => 'Hotel Pickup', 'description' => 'Our driver picks you up from your hotel'],
                ['day_number' => '10:00 AM', 'title' => 'Rice Terrace Visit', 'description' => 'Explore the beautiful Tegallalang Rice Terraces'],
                ['day_number' => '12:00 PM', 'title' => 'Lunch Break', 'description' => 'Enjoy traditional Balinese cuisine'],
            ],
            'title_field' => '{{{ day_number }}} - {{{ title }}}',
        ]);

        $this->end_controls_section();

        // Style Section
        $this->start_controls_section('section_style', [
            'label' => esc_html__('Style', 'bestbalitravel'),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control('line_color', [
            'label' => esc_html__('Timeline Line Color', 'bestbalitravel'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#F5A623',
        ]);

        $this->add_control('dot_color', [
            'label' => esc_html__('Dot Color', 'bestbalitravel'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#10B981',
        ]);

        $this->add_control('layout', [
            'label' => esc_html__('Layout', 'bestbalitravel'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'options' => [
                'left' => esc_html__('Left Aligned', 'bestbalitravel'),
                'alternating' => esc_html__('Alternating', 'bestbalitravel'),
            ],
            'default' => 'left',
        ]);

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $items = $settings['timeline_items'];
        $layout = $settings['layout'];

        if (empty($items))
            return;
        ?>
        <div class="bbt-activity-timeline layout-<?php echo esc_attr($layout); ?>">
            <div class="bbt-timeline-line" style="background: <?php echo esc_attr($settings['line_color']); ?>"></div>

            <?php foreach ($items as $index => $item):
                $side = ($layout === 'alternating' && $index % 2 === 1) ? 'right' : 'left';
                ?>
                <div class="bbt-timeline-item side-<?php echo $side; ?>" data-aos="fade-up"
                    data-aos-delay="<?php echo $index * 100; ?>">
                    <div class="bbt-timeline-dot" style="background: <?php echo esc_attr($settings['dot_color']); ?>">
                        <?php if (!empty($item['icon']['value'])): ?>
                            <i class="<?php echo esc_attr($item['icon']['value']); ?>"></i>
                        <?php endif; ?>
                    </div>

                    <div class="bbt-timeline-content">
                        <span class="bbt-timeline-time">
                            <?php echo esc_html($item['day_number']); ?>
                        </span>
                        <h4 class="bbt-timeline-title">
                            <?php echo esc_html($item['title']); ?>
                        </h4>
                        <p class="bbt-timeline-desc">
                            <?php echo esc_html($item['description']); ?>
                        </p>

                        <?php if (!empty($item['image']['url'])): ?>
                            <div class="bbt-timeline-image">
                                <img src="<?php echo esc_url($item['image']['url']); ?>" alt="<?php echo esc_attr($item['title']); ?>"
                                    loading="lazy">
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <style>
            .bbt-activity-timeline {
                position: relative;
                padding: 40px 0;
            }

            .bbt-timeline-line {
                position: absolute;
                left: 30px;
                top: 0;
                bottom: 0;
                width: 3px;
                border-radius: 3px;
            }

            .bbt-timeline-item {
                position: relative;
                padding-left: 80px;
                margin-bottom: 40px;
                opacity: 0;
                animation: bbtTimelineFade 0.6s ease forwards;
            }

            .bbt-timeline-item:nth-child(1) {
                animation-delay: 0.1s;
            }

            .bbt-timeline-item:nth-child(2) {
                animation-delay: 0.2s;
            }

            .bbt-timeline-item:nth-child(3) {
                animation-delay: 0.3s;
            }

            .bbt-timeline-item:nth-child(4) {
                animation-delay: 0.4s;
            }

            .bbt-timeline-item:nth-child(5) {
                animation-delay: 0.5s;
            }

            .bbt-timeline-dot {
                position: absolute;
                left: 15px;
                top: 5px;
                width: 34px;
                height: 34px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                color: #fff;
                font-size: 14px;
                box-shadow: 0 4px 15px rgba(16, 185, 129, 0.4);
                z-index: 2;
                transition: transform 0.3s ease;
            }

            .bbt-timeline-item:hover .bbt-timeline-dot {
                transform: scale(1.2);
            }

            .bbt-timeline-content {
                background: #fff;
                padding: 24px;
                border-radius: 16px;
                box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
                transition: all 0.3s ease;
            }

            .bbt-timeline-item:hover .bbt-timeline-content {
                transform: translateX(10px);
                box-shadow: 0 12px 40px rgba(0, 0, 0, 0.12);
            }

            .bbt-timeline-time {
                display: inline-block;
                background: linear-gradient(135deg, #F5A623, #FFD93D);
                color: #000;
                padding: 4px 12px;
                border-radius: 20px;
                font-size: 12px;
                font-weight: 700;
                margin-bottom: 10px;
            }

            .bbt-timeline-title {
                margin: 0 0 8px;
                font-size: 18px;
                font-weight: 700;
                color: #1a1a1a;
            }

            .bbt-timeline-desc {
                margin: 0;
                color: #666;
                line-height: 1.6;
            }

            .bbt-timeline-image {
                margin-top: 15px;
                border-radius: 12px;
                overflow: hidden;
            }

            .bbt-timeline-image img {
                width: 100%;
                height: 150px;
                object-fit: cover;
            }

            /* Alternating Layout */
            .layout-alternating .bbt-timeline-line {
                left: 50%;
                transform: translateX(-50%);
            }

            .layout-alternating .bbt-timeline-item {
                width: 50%;
                padding-left: 0;
                padding-right: 50px;
            }

            .layout-alternating .bbt-timeline-item .bbt-timeline-dot {
                left: auto;
                right: -17px;
            }

            .layout-alternating .bbt-timeline-item.side-right {
                margin-left: 50%;
                padding-left: 50px;
                padding-right: 0;
            }

            .layout-alternating .bbt-timeline-item.side-right .bbt-timeline-dot {
                right: auto;
                left: -17px;
            }

            .layout-alternating .bbt-timeline-item.side-right .bbt-timeline-content {
                text-align: left;
            }

            @keyframes bbtTimelineFade {
                to {
                    opacity: 1;
                }
            }

            @media (max-width: 768px) {
                .layout-alternating .bbt-timeline-line {
                    left: 30px;
                    transform: none;
                }

                .layout-alternating .bbt-timeline-item,
                .layout-alternating .bbt-timeline-item.side-right {
                    width: 100%;
                    padding-left: 80px;
                    padding-right: 0;
                    margin-left: 0;
                }

                .layout-alternating .bbt-timeline-item .bbt-timeline-dot,
                .layout-alternating .bbt-timeline-item.side-right .bbt-timeline-dot {
                    left: 15px;
                    right: auto;
                }
            }
        </style>
        <?php
    }
}
