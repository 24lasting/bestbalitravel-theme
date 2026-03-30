<?php
if (!defined('ABSPATH'))
    exit;

class BBT_Widget_Countdown_Timer extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'bbt-countdown-timer';
    }
    public function get_title()
    {
        return esc_html__('Countdown Timer', 'bestbalitravel');
    }
    public function get_icon()
    {
        return 'eicon-countdown';
    }
    public function get_categories()
    {
        return ['bbt-widgets'];
    }

    protected function register_controls()
    {
        $this->start_controls_section('section_content', ['label' => 'Content']);
        $this->add_control('date', ['label' => 'Target Date', 'type' => \Elementor\Controls_Manager::DATE_TIME]);
        $this->add_control('title', ['label' => 'Title', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Sale Ends In']);
        $this->add_control('style', ['label' => 'Style', 'type' => \Elementor\Controls_Manager::SELECT, 'options' => ['boxes' => 'Boxes', 'inline' => 'Inline', 'circles' => 'Circles'], 'default' => 'boxes']);
        $this->end_controls_section();
    }

    protected function render()
    {
        $s = $this->get_settings_for_display();
        $date = $s['date'] ?: date('Y-m-d H:i:s', strtotime('+7 days'));
        $id = 'ct-' . uniqid();
        ?>
        <div class="bbt-countdown-timer style-<?php echo esc_attr($s['style']); ?>" id="<?php echo $id; ?>"
            data-date="<?php echo esc_attr($date); ?>">
            <?php if ($s['title']): ?>
                <h3 class="bbt-ct-title">
                    <?php echo esc_html($s['title']); ?>
                </h3>
            <?php endif; ?>
            <div class="bbt-ct-units">
                <div class="bbt-ct-unit"><span class="bbt-ct-value" data-unit="days">00</span><span
                        class="bbt-ct-label">Days</span></div>
                <div class="bbt-ct-sep">:</div>
                <div class="bbt-ct-unit"><span class="bbt-ct-value" data-unit="hours">00</span><span
                        class="bbt-ct-label">Hours</span></div>
                <div class="bbt-ct-sep">:</div>
                <div class="bbt-ct-unit"><span class="bbt-ct-value" data-unit="mins">00</span><span
                        class="bbt-ct-label">Minutes</span></div>
                <div class="bbt-ct-sep">:</div>
                <div class="bbt-ct-unit"><span class="bbt-ct-value" data-unit="secs">00</span><span
                        class="bbt-ct-label">Seconds</span></div>
            </div>
        </div>
        <style>
            .bbt-ct-title {
                text-align: center;
                margin: 0 0 20px;
                font-size: 24px
            }

            .bbt-ct-units {
                display: flex;
                justify-content: center;
                align-items: center;
                gap: 15px
            }

            .style-boxes .bbt-ct-unit {
                background: #fff;
                padding: 20px 25px;
                border-radius: 16px;
                text-align: center;
                min-width: 80px;
                box-shadow: 0 8px 25px rgba(0, 0, 0, .08)
            }

            .style-circles .bbt-ct-unit {
                width: 100px;
                height: 100px;
                border-radius: 50%;
                background: #fff;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                box-shadow: 0 8px 25px rgba(0, 0, 0, .08)
            }

            .bbt-ct-value {
                font-size: 36px;
                font-weight: 800;
                color: #F5A623;
                display: block
            }

            .bbt-ct-label {
                font-size: 12px;
                color: #666;
                text-transform: uppercase;
                letter-spacing: 1px
            }

            .bbt-ct-sep {
                font-size: 36px;
                font-weight: 700;
                color: #F5A623
            }

            .style-inline .bbt-ct-sep,
            .style-circles .bbt-ct-sep {
                display: none
            }
        </style>
        <script>
            (function () {
                var el = document.getElementById('<?php echo $id; ?>'), target = new Date(el.dataset.date).getTime();
                setInterval(function () {
                    var now = Date.now(), diff = Math.max(0, target - now), d = Math.floor(diff / 86400000), h = Math.floor((diff % 86400000) / 3600000), m = Math.floor((diff % 3600000) / 60000), s = Math.floor((diff % 60000) / 1000);
                    el.querySelector('[data-unit="days"]').textContent = String(d).padStart(2, '0');
                    el.querySelector('[data-unit="hours"]').textContent = String(h).padStart(2, '0');
                    el.querySelector('[data-unit="mins"]').textContent = String(m).padStart(2, '0');
                    el.querySelector('[data-unit="secs"]').textContent = String(s).padStart(2, '0');
                }, 1000)
            })();
        </script>
        <?php
    }
}
