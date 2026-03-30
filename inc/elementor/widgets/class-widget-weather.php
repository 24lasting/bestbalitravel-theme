<?php
/**
 * Elementor Weather Widget
 * Display weather information for Bali locations
 *
 * @package BestBaliTravel
 */

if (!defined('ABSPATH')) {
    exit;
}

class BBT_Widget_Weather extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'bbt-weather';
    }

    public function get_title()
    {
        return esc_html__('Bali Weather', 'bestbalitravel');
    }

    public function get_icon()
    {
        return 'eicon-cloud-check';
    }

    public function get_categories()
    {
        return ['bbt-widgets'];
    }

    protected function register_controls()
    {
        $this->start_controls_section('section_content', [
            'label' => esc_html__('Weather Settings', 'bestbalitravel'),
        ]);

        $this->add_control('location', [
            'label' => esc_html__('Location', 'bestbalitravel'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'options' => [
                'bali' => 'Bali (General)',
                'ubud' => 'Ubud',
                'seminyak' => 'Seminyak',
                'kuta' => 'Kuta',
                'nusa_dua' => 'Nusa Dua',
                'uluwatu' => 'Uluwatu',
            ],
            'default' => 'bali',
        ]);

        $this->add_control('style', [
            'label' => esc_html__('Style', 'bestbalitravel'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'options' => [
                'card' => esc_html__('Card', 'bestbalitravel'),
                'minimal' => esc_html__('Minimal', 'bestbalitravel'),
                'detailed' => esc_html__('Detailed', 'bestbalitravel'),
            ],
            'default' => 'card',
        ]);

        $this->add_control('show_forecast', [
            'label' => esc_html__('Show 5-Day Forecast', 'bestbalitravel'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'default' => 'yes',
        ]);

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $location = ucfirst(str_replace('_', ' ', $settings['location']));
        $style = $settings['style'];

        // Simulated weather data (in production, use weather API)
        $weather = [
            'temp' => rand(26, 32),
            'condition' => ['Sunny', 'Partly Cloudy', 'Scattered Clouds'][rand(0, 2)],
            'humidity' => rand(60, 85),
            'wind' => rand(5, 20),
            'icon' => ['☀️', '⛅', '🌤️'][rand(0, 2)],
        ];

        $forecast = [
            ['day' => 'Mon', 'temp' => rand(26, 32), 'icon' => '☀️'],
            ['day' => 'Tue', 'temp' => rand(26, 32), 'icon' => '⛅'],
            ['day' => 'Wed', 'temp' => rand(26, 32), 'icon' => '🌤️'],
            ['day' => 'Thu', 'temp' => rand(26, 32), 'icon' => '☀️'],
            ['day' => 'Fri', 'temp' => rand(26, 32), 'icon' => '⛅'],
        ];
        ?>
        <div class="bbt-weather-widget style-<?php echo esc_attr($style); ?>">
            <div class="bbt-weather-main">
                <div class="bbt-weather-icon">
                    <?php echo $weather['icon']; ?>
                </div>
                <div class="bbt-weather-info">
                    <div class="bbt-weather-temp">
                        <?php echo $weather['temp']; ?>°C
                    </div>
                    <div class="bbt-weather-condition">
                        <?php echo esc_html($weather['condition']); ?>
                    </div>
                    <div class="bbt-weather-location">
                        <?php echo esc_html($location); ?>, Bali
                    </div>
                </div>
            </div>

            <?php if ($style === 'detailed'): ?>
                <div class="bbt-weather-details">
                    <div class="bbt-weather-detail">
                        <span class="label">💧 Humidity</span>
                        <span class="value">
                            <?php echo $weather['humidity']; ?>%
                        </span>
                    </div>
                    <div class="bbt-weather-detail">
                        <span class="label">💨 Wind</span>
                        <span class="value">
                            <?php echo $weather['wind']; ?> km/h
                        </span>
                    </div>
                </div>
            <?php endif; ?>

            <?php if ($settings['show_forecast'] === 'yes'): ?>
                <div class="bbt-weather-forecast">
                    <?php foreach ($forecast as $day): ?>
                        <div class="bbt-forecast-day">
                            <span class="day">
                                <?php echo $day['day']; ?>
                            </span>
                            <span class="icon">
                                <?php echo $day['icon']; ?>
                            </span>
                            <span class="temp">
                                <?php echo $day['temp']; ?>°
                            </span>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <div class="bbt-weather-tip">
                <span>🌴 Best time to visit:
                    <?php echo esc_html($location); ?> is great year-round!
                </span>
            </div>
        </div>

        <style>
            .bbt-weather-widget {
                background: linear-gradient(135deg, #0EA5E9, #38BDF8);
                padding: 30px;
                border-radius: 24px;
                color: #fff;
                box-shadow: 0 20px 60px rgba(14, 165, 233, 0.3);
                animation: bbtWeatherPulse 3s ease-in-out infinite;
            }

            @keyframes bbtWeatherPulse {

                0%,
                100% {
                    box-shadow: 0 20px 60px rgba(14, 165, 233, 0.3);
                }

                50% {
                    box-shadow: 0 25px 70px rgba(14, 165, 233, 0.4);
                }
            }

            .bbt-weather-main {
                display: flex;
                align-items: center;
                gap: 20px;
                margin-bottom: 25px;
            }

            .bbt-weather-icon {
                font-size: 72px;
                animation: bbtWeatherFloat 2s ease-in-out infinite;
            }

            @keyframes bbtWeatherFloat {

                0%,
                100% {
                    transform: translateY(0);
                }

                50% {
                    transform: translateY(-10px);
                }
            }

            .bbt-weather-temp {
                font-size: 48px;
                font-weight: 700;
                line-height: 1;
            }

            .bbt-weather-condition {
                font-size: 18px;
                opacity: 0.9;
            }

            .bbt-weather-location {
                font-size: 14px;
                opacity: 0.8;
                margin-top: 5px;
            }

            .bbt-weather-details {
                display: flex;
                gap: 30px;
                margin-bottom: 25px;
                padding: 15px 0;
                border-top: 1px solid rgba(255, 255, 255, 0.2);
                border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            }

            .bbt-weather-detail {
                display: flex;
                flex-direction: column;
            }

            .bbt-weather-detail .label {
                font-size: 13px;
                opacity: 0.8;
            }

            .bbt-weather-detail .value {
                font-size: 18px;
                font-weight: 600;
            }

            .bbt-weather-forecast {
                display: flex;
                justify-content: space-between;
                margin-bottom: 20px;
            }

            .bbt-forecast-day {
                display: flex;
                flex-direction: column;
                align-items: center;
                gap: 5px;
                padding: 10px;
                background: rgba(255, 255, 255, 0.1);
                border-radius: 12px;
                transition: all 0.3s ease;
            }

            .bbt-forecast-day:hover {
                background: rgba(255, 255, 255, 0.2);
                transform: translateY(-5px);
            }

            .bbt-forecast-day .day {
                font-size: 12px;
                opacity: 0.8;
            }

            .bbt-forecast-day .icon {
                font-size: 24px;
            }

            .bbt-forecast-day .temp {
                font-size: 14px;
                font-weight: 600;
            }

            .bbt-weather-tip {
                background: rgba(255, 255, 255, 0.15);
                padding: 12px 16px;
                border-radius: 12px;
                font-size: 13px;
            }

            .style-minimal {
                padding: 20px;
                background: rgba(255, 255, 255, 0.95);
                color: #1a1a1a;
            }

            .style-minimal .bbt-weather-icon {
                font-size: 48px;
            }

            .style-minimal .bbt-weather-temp {
                font-size: 32px;
                color: #0EA5E9;
            }
        </style>
        <?php
    }
}
