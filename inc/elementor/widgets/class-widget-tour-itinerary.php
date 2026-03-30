<?php
if (!defined('ABSPATH'))
    exit;

class BBT_Widget_Tour_Itinerary extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'bbt-tour-itinerary';
    }
    public function get_title()
    {
        return esc_html__('Tour Itinerary', 'bestbalitravel');
    }
    public function get_icon()
    {
        return 'eicon-post-list';
    }
    public function get_categories()
    {
        return ['bbt-widgets'];
    }

    protected function register_controls()
    {
        $this->start_controls_section('section_itinerary', ['label' => 'Itinerary']);
        $repeater = new \Elementor\Repeater();
        $repeater->add_control('time', ['label' => 'Time', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '08:00 AM']);
        $repeater->add_control('title', ['label' => 'Title', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Activity']);
        $repeater->add_control('desc', ['label' => 'Description', 'type' => \Elementor\Controls_Manager::TEXTAREA]);
        $this->add_control('items', [
            'type' => \Elementor\Controls_Manager::REPEATER,
            'fields' => $repeater->get_controls(),
            'default' => [
                ['time' => '08:00 AM', 'title' => 'Hotel Pickup', 'desc' => 'Our driver will pick you up from your hotel'],
                ['time' => '09:30 AM', 'title' => 'Temple Visit', 'desc' => 'Explore the ancient temple'],
                ['time' => '12:00 PM', 'title' => 'Lunch', 'desc' => 'Traditional Balinese lunch'],
                ['time' => '05:00 PM', 'title' => 'Return to Hotel', 'desc' => 'Drop off at your hotel'],
            ]
        ]);
        $this->end_controls_section();
    }

    protected function render()
    {
        $items = $this->get_settings_for_display()['items'];
        ?>
        <div class="bbt-tour-itinerary">
            <h3>📍 Itinerary</h3>
            <div class="bbt-ti-timeline">
                <?php foreach ($items as $i => $item): ?>
                    <div class="bbt-ti-item" style="--d:<?php echo $i * 0.15; ?>s">
                        <div class="bbt-ti-time"><span>
                                <?php echo esc_html($item['time']); ?>
                            </span></div>
                        <div class="bbt-ti-dot"></div>
                        <div class="bbt-ti-content">
                            <h4>
                                <?php echo esc_html($item['title']); ?>
                            </h4>
                            <p>
                                <?php echo esc_html($item['desc']); ?>
                            </p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <style>
            .bbt-tour-itinerary h3 {
                margin: 0 0 25px;
                font-size: 20px
            }

            .bbt-ti-timeline {
                position: relative;
                padding-left: 100px
            }

            .bbt-ti-timeline::before {
                content: '';
                position: absolute;
                left: 90px;
                top: 15px;
                bottom: 15px;
                width: 2px;
                background: #eee
            }

            .bbt-ti-item {
                display: flex;
                align-items: flex-start;
                gap: 25px;
                padding: 20px 0;
                opacity: 0;
                animation: bbtTiFade .5s ease forwards;
                animation-delay: var(--d)
            }

            @keyframes bbtTiFade {
                to {
                    opacity: 1
                }
            }

            .bbt-ti-time {
                position: absolute;
                left: 0;
                width: 80px;
                text-align: right;
                font-size: 13px;
                font-weight: 600;
                color: #F5A623
            }

            .bbt-ti-dot {
                width: 16px;
                height: 16px;
                background: #fff;
                border: 4px solid #F5A623;
                border-radius: 50%;
                z-index: 2;
                margin-left: -8px;
                flex-shrink: 0
            }

            .bbt-ti-content {
                flex: 1;
                background: #f9f9f9;
                padding: 20px;
                border-radius: 14px
            }

            .bbt-ti-content h4 {
                margin: 0 0 5px;
                font-size: 16px
            }

            .bbt-ti-content p {
                margin: 0;
                color: #666;
                font-size: 14px
            }
        </style>
        <?php
    }
}
