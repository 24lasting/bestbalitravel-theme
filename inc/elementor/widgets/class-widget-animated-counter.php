<?php
if (!defined('ABSPATH'))
    exit;

class BBT_Widget_Animated_Counter extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'bbt-animated-counter';
    }
    public function get_title()
    {
        return esc_html__('Animated Counter', 'bestbalitravel');
    }
    public function get_icon()
    {
        return 'eicon-counter';
    }
    public function get_categories()
    {
        return ['bbt-widgets'];
    }

    protected function register_controls()
    {
        $this->start_controls_section('section_counters', ['label' => 'Counters']);
        $repeater = new \Elementor\Repeater();
        $repeater->add_control('icon', ['label' => 'Icon', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '🌴']);
        $repeater->add_control('number', ['label' => 'Number', 'type' => \Elementor\Controls_Manager::NUMBER, 'default' => 100]);
        $repeater->add_control('suffix', ['label' => 'Suffix', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '+']);
        $repeater->add_control('title', ['label' => 'Title', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Tours']);
        $this->add_control('counters', [
            'type' => \Elementor\Controls_Manager::REPEATER,
            'fields' => $repeater->get_controls(),
            'default' => [
                ['icon' => '🌴', 'number' => 150, 'suffix' => '+', 'title' => 'Tours'],
                ['icon' => '👥', 'number' => 50000, 'suffix' => '+', 'title' => 'Happy Travelers'],
                ['icon' => '⭐', 'number' => 4.9, 'suffix' => '', 'title' => 'Average Rating'],
                ['icon' => '🏆', 'number' => 10, 'suffix' => '+', 'title' => 'Years Experience'],
            ]
        ]);
        $this->end_controls_section();
    }

    protected function render()
    {
        $counters = $this->get_settings_for_display()['counters'];
        ?>
        <div class="bbt-animated-counters">
            <?php foreach ($counters as $i => $c): ?>
                <div class="bbt-counter-item" style="--d:<?php echo $i * 0.15; ?>s">
                    <span class="bbt-counter-icon">
                        <?php echo $c['icon']; ?>
                    </span>
                    <span class="bbt-counter-number" data-target="<?php echo esc_attr($c['number']); ?>">
                        <?php echo esc_html($c['number']); ?>
                    </span>
                    <span class="bbt-counter-suffix">
                        <?php echo esc_html($c['suffix']); ?>
                    </span>
                    <span class="bbt-counter-title">
                        <?php echo esc_html($c['title']); ?>
                    </span>
                </div>
            <?php endforeach; ?>
        </div>
        <style>
            .bbt-animated-counters {
                display: flex;
                justify-content: space-around;
                flex-wrap: wrap;
                gap: 30px;
                padding: 40px 0
            }

            .bbt-counter-item {
                text-align: center;
                opacity: 0;
                animation: bbtCountFade .5s ease forwards;
                animation-delay: var(--d)
            }

            @keyframes bbtCountFade {
                to {
                    opacity: 1
                }
            }

            .bbt-counter-icon {
                display: block;
                font-size: 50px;
                margin-bottom: 15px
            }

            .bbt-counter-number {
                font-size: 48px;
                font-weight: 800;
                color: #F5A623
            }

            .bbt-counter-suffix {
                font-size: 32px;
                font-weight: 700;
                color: #F5A623
            }

            .bbt-counter-title {
                display: block;
                font-size: 16px;
                color: #666;
                margin-top: 10px
            }
        </style>
        <?php
    }
}
