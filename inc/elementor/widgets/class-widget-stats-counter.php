<?php
/**
 * Elementor Stats Counter Widget
 *
 * @package BestBaliTravel
 */

if (!defined('ABSPATH')) {
    exit;
}

class BBT_Widget_Stats_Counter extends \Elementor\Widget_Base
{

    public function get_name()
    {
        return 'bbt-stats-counter';
    }

    public function get_title()
    {
        return esc_html__('BBT Stats Counter', 'bestbalitravel');
    }

    public function get_icon()
    {
        return 'eicon-counter';
    }

    public function get_categories()
    {
        return array('bbt-widgets');
    }

    protected function register_controls()
    {
        $this->start_controls_section(
            'section_stats',
            array(
                'label' => esc_html__('Stats', 'bestbalitravel'),
            )
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'number',
            array(
                'label' => esc_html__('Number', 'bestbalitravel'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 500,
            )
        );

        $repeater->add_control(
            'suffix',
            array(
                'label' => esc_html__('Suffix', 'bestbalitravel'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => '+',
            )
        );

        $repeater->add_control(
            'title',
            array(
                'label' => esc_html__('Title', 'bestbalitravel'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => 'Happy Travelers',
            )
        );

        $repeater->add_control(
            'icon',
            array(
                'label' => esc_html__('Icon', 'bestbalitravel'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => array(
                    'value' => 'fas fa-users',
                    'library' => 'fa-solid',
                ),
            )
        );

        $this->add_control(
            'stats',
            array(
                'label' => esc_html__('Stats', 'bestbalitravel'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => array(
                    array('number' => 15000, 'suffix' => '+', 'title' => 'Happy Travelers'),
                    array('number' => 150, 'suffix' => '+', 'title' => 'Tours Completed'),
                    array('number' => 98, 'suffix' => '%', 'title' => 'Satisfaction Rate'),
                    array('number' => 50, 'suffix' => '+', 'title' => 'Expert Guides'),
                ),
                'title_field' => '{{{ title }}}',
            )
        );

        $this->add_control(
            'animation_duration',
            array(
                'label' => esc_html__('Animation Duration (ms)', 'bestbalitravel'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 2000,
            )
        );

        $this->end_controls_section();

        // Style
        $this->start_controls_section(
            'section_style',
            array(
                'label' => esc_html__('Style', 'bestbalitravel'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_control(
            'number_color',
            array(
                'label' => esc_html__('Number Color', 'bestbalitravel'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#f5a623',
                'selectors' => array(
                    '{{WRAPPER}} .bbt-stat-number' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        ?>

        <div class="bbt-stats-counter" data-duration="<?php echo esc_attr($settings['animation_duration']); ?>">
            <?php foreach ($settings['stats'] as $index => $stat): ?>
                <div class="bbt-stat-item">
                    <?php if (!empty($stat['icon']['value'])): ?>
                        <div class="bbt-stat-icon">
                            <?php \Elementor\Icons_Manager::render_icon($stat['icon'], array('aria-hidden' => 'true')); ?>
                        </div>
                    <?php endif; ?>

                    <div class="bbt-stat-number" data-target="<?php echo esc_attr($stat['number']); ?>">
                        0
                        <?php echo esc_html($stat['suffix']); ?>
                    </div>

                    <div class="bbt-stat-title">
                        <?php echo esc_html($stat['title']); ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <?php
    }
}
