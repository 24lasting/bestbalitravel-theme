<?php
/**
 * Elementor Tour Availability Calendar Widget
 *
 * @package BestBaliTravel
 */

if (!defined('ABSPATH'))
    exit;

class BBT_Widget_Availability_Calendar extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'bbt-availability-calendar';
    }
    public function get_title()
    {
        return esc_html__('Availability Calendar', 'bestbalitravel');
    }
    public function get_icon()
    {
        return 'eicon-calendar';
    }
    public function get_categories()
    {
        return ['bbt-widgets'];
    }

    protected function register_controls()
    {
        $this->start_controls_section('section_calendar', ['label' => 'Calendar Settings']);

        $this->add_control('tour_id', [
            'label' => 'Select Tour',
            'type' => \Elementor\Controls_Manager::SELECT2,
            'options' => $this->get_tours(),
        ]);

        $this->add_control('months_to_show', [
            'label' => 'Months to Show',
            'type' => \Elementor\Controls_Manager::SELECT,
            'options' => ['1' => '1 Month', '2' => '2 Months', '3' => '3 Months'],
            'default' => '2',
        ]);

        $this->add_control('legend_available', ['label' => 'Available Color', 'type' => \Elementor\Controls_Manager::COLOR, 'default' => '#10B981']);
        $this->add_control('legend_limited', ['label' => 'Limited Color', 'type' => \Elementor\Controls_Manager::COLOR, 'default' => '#F5A623']);
        $this->add_control('legend_sold_out', ['label' => 'Sold Out Color', 'type' => \Elementor\Controls_Manager::COLOR, 'default' => '#EF4444']);

        $this->end_controls_section();
    }

    private function get_tours()
    {
        $options = [];
        $tours = get_posts(['post_type' => 'tour', 'posts_per_page' => 50, 'post_status' => 'publish']);
        foreach ($tours as $t)
            $options[$t->ID] = $t->post_title;
        return $options;
    }

    protected function render()
    {
        $s = $this->get_settings_for_display();
        $months = (int) $s['months_to_show'];
        $id = 'cal-' . uniqid();

        // Generate sample availability data
        $today = new DateTime();
        ?>
        <div class="bbt-availability-calendar" id="<?php echo $id; ?>">
            <div class="bbt-cal-header">
                <h3>📅 Availability Calendar</h3>
                <div class="bbt-cal-legend">
                    <span><i style="background:<?php echo esc_attr($s['legend_available']); ?>"></i> Available</span>
                    <span><i style="background:<?php echo esc_attr($s['legend_limited']); ?>"></i> Limited</span>
                    <span><i style="background:<?php echo esc_attr($s['legend_sold_out']); ?>"></i> Sold Out</span>
                </div>
            </div>

            <div class="bbt-cal-months">
                <?php for ($m = 0; $m < $months; $m++):
                    $month = clone $today;
                    $month->modify("+{$m} month");
                    $firstDay = (clone $month)->modify('first day of this month');
                    $lastDay = (clone $month)->modify('last day of this month');
                    $startWeekday = (int) $firstDay->format('w');
                    ?>
                    <div class="bbt-cal-month" style="--d:<?php echo $m * 0.2; ?>s">
                        <div class="bbt-cal-month-header">
                            <?php echo $month->format('F Y'); ?>
                        </div>
                        <div class="bbt-cal-weekdays">
                            <span>Sun</span><span>Mon</span><span>Tue</span><span>Wed</span><span>Thu</span><span>Fri</span><span>Sat</span>
                        </div>
                        <div class="bbt-cal-days">
                            <?php for ($i = 0; $i < $startWeekday; $i++): ?>
                                <span class="bbt-cal-day empty"></span>
                            <?php endfor; ?>

                            <?php for ($d = 1; $d <= (int) $lastDay->format('d'); $d++):
                                $status = ['available', 'available', 'available', 'limited', 'sold-out'][rand(0, 4)];
                                $isPast = ($m === 0 && $d < (int) $today->format('d'));
                                if ($isPast)
                                    $status = 'past';
                                ?>
                                <span class="bbt-cal-day <?php echo $status; ?>" data-day="<?php echo $d; ?>">
                                    <?php echo $d; ?>
                                </span>
                            <?php endfor; ?>
                        </div>
                    </div>
                <?php endfor; ?>
            </div>

            <div class="bbt-cal-footer">
                <p>💡 Click on a date to check availability and book instantly!</p>
            </div>
        </div>

        <style>
            .bbt-availability-calendar {
                background: #fff;
                border-radius: 24px;
                padding: 30px;
                box-shadow: 0 10px 40px rgba(0, 0, 0, .08)
            }

            .bbt-cal-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 25px;
                flex-wrap: wrap;
                gap: 15px
            }

            .bbt-cal-header h3 {
                margin: 0;
                font-size: 20px
            }

            .bbt-cal-legend {
                display: flex;
                gap: 20px
            }

            .bbt-cal-legend span {
                display: flex;
                align-items: center;
                gap: 6px;
                font-size: 13px;
                color: #666
            }

            .bbt-cal-legend i {
                width: 12px;
                height: 12px;
                border-radius: 50%
            }

            .bbt-cal-months {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
                gap: 30px
            }

            .bbt-cal-month {
                opacity: 0;
                animation: bbtCalFade .5s ease forwards;
                animation-delay: var(--d)
            }

            @keyframes bbtCalFade {
                to {
                    opacity: 1
                }
            }

            .bbt-cal-month-header {
                text-align: center;
                font-weight: 700;
                font-size: 16px;
                margin-bottom: 15px;
                color: #1a1a1a
            }

            .bbt-cal-weekdays {
                display: grid;
                grid-template-columns: repeat(7, 1fr);
                text-align: center;
                font-size: 12px;
                font-weight: 600;
                color: #999;
                margin-bottom: 10px
            }

            .bbt-cal-days {
                display: grid;
                grid-template-columns: repeat(7, 1fr);
                gap: 5px
            }

            .bbt-cal-day {
                aspect-ratio: 1;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 14px;
                border-radius: 10px;
                cursor: pointer;
                transition: all .2s ease
            }

            .bbt-cal-day.empty {
                cursor: default
            }

            .bbt-cal-day.past {
                color: #ccc;
                cursor: not-allowed
            }

            .bbt-cal-day.available {
                background: #E6F9F0;
                color: #10B981;
                font-weight: 600
            }

            .bbt-cal-day.available:hover {
                background: #10B981;
                color: #fff;
                transform: scale(1.1)
            }

            .bbt-cal-day.limited {
                background: #FEF3E6;
                color: #F5A623;
                font-weight: 600
            }

            .bbt-cal-day.limited:hover {
                background: #F5A623;
                color: #fff;
                transform: scale(1.1)
            }

            .bbt-cal-day.sold-out {
                background: #FEE2E2;
                color: #EF4444;
                text-decoration: line-through;
                cursor: not-allowed
            }

            .bbt-cal-footer {
                margin-top: 25px;
                text-align: center
            }

            .bbt-cal-footer p {
                margin: 0;
                font-size: 14px;
                color: #666
            }
        </style>
        <?php
    }
}
