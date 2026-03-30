<?php
if (!defined('ABSPATH'))
    exit;

class BBT_Widget_Booking_Steps extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'bbt-booking-steps';
    }
    public function get_title()
    {
        return esc_html__('Booking Steps', 'bestbalitravel');
    }
    public function get_icon()
    {
        return 'eicon-flow';
    }
    public function get_categories()
    {
        return ['bbt-widgets'];
    }

    protected function register_controls()
    {
        $this->start_controls_section('section_steps', ['label' => 'Steps']);
        $repeater = new \Elementor\Repeater();
        $repeater->add_control('icon', ['label' => 'Icon', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '🔍']);
        $repeater->add_control('title', ['label' => 'Title', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Step']);
        $repeater->add_control('desc', ['label' => 'Description', 'type' => \Elementor\Controls_Manager::TEXTAREA]);
        $this->add_control('steps', [
            'type' => \Elementor\Controls_Manager::REPEATER,
            'fields' => $repeater->get_controls(),
            'default' => [
                ['icon' => '🔍', 'title' => 'Browse Activities', 'desc' => 'Explore our collection of tours'],
                ['icon' => '📅', 'title' => 'Choose Date', 'desc' => 'Pick your preferred date'],
                ['icon' => '💳', 'title' => 'Secure Payment', 'desc' => 'Pay safely online'],
                ['icon' => '🎉', 'title' => 'Enjoy!', 'desc' => 'Have an amazing experience'],
            ]
        ]);
        $this->end_controls_section();
    }

    protected function render()
    {
        $steps = $this->get_settings_for_display()['steps'];
        ?>
        <div class="bbt-booking-steps">
            <?php foreach ($steps as $i => $step): ?>
                <div class="bbt-bs-item" style="--d:<?php echo $i * 0.15; ?>s">
                    <div class="bbt-bs-number">
                        <?php echo $i + 1; ?>
                    </div>
                    <div class="bbt-bs-icon">
                        <?php echo $step['icon']; ?>
                    </div>
                    <h4>
                        <?php echo esc_html($step['title']); ?>
                    </h4>
                    <p>
                        <?php echo esc_html($step['desc']); ?>
                    </p>
                </div>
                <?php if ($i < count($steps) - 1): ?>
                    <div class="bbt-bs-line"></div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
        <style>
            .bbt-booking-steps {
                display: flex;
                align-items: flex-start;
                justify-content: space-between
            }

            .bbt-bs-item {
                flex: 1;
                text-align: center;
                position: relative;
                opacity: 0;
                animation: bbtBsFade .5s ease forwards;
                animation-delay: var(--d)
            }

            @keyframes bbtBsFade {
                to {
                    opacity: 1
                }
            }

            .bbt-bs-number {
                position: absolute;
                top: -10px;
                left: 50%;
                transform: translateX(-50%);
                width: 28px;
                height: 28px;
                background: #F5A623;
                color: #000;
                border-radius: 50%;
                font-size: 12px;
                font-weight: 700;
                display: flex;
                align-items: center;
                justify-content: center
            }

            .bbt-bs-icon {
                width: 80px;
                height: 80px;
                background: linear-gradient(135deg, #F5A623, #FFD93D);
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 32px;
                margin: 20px auto 15px;
                box-shadow: 0 10px 30px rgba(245, 166, 35, .3)
            }

            .bbt-bs-item h4 {
                margin: 0 0 8px;
                font-size: 16px
            }

            .bbt-bs-item p {
                margin: 0;
                font-size: 13px;
                color: #666;
                max-width: 150px;
                margin: 0 auto
            }

            .bbt-bs-line {
                flex: 0 1 100px;
                height: 3px;
                background: linear-gradient(90deg, #F5A623, #FFD93D);
                margin-top: 60px;
                border-radius: 3px
            }

            @media(max-width:768px) {
                .bbt-booking-steps {
                    flex-direction: column;
                    gap: 30px
                }

                .bbt-bs-line {
                    width: 3px;
                    height: 40px;
                    margin: 0 auto
                }
            }
        </style>
        <?php
    }
}
