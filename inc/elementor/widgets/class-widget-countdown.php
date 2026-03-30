<?php
/**
 * Elementor Countdown Timer Widget
 *
 * @package BestBaliTravel
 */

if (!defined('ABSPATH')) {
    exit;
}

class BBT_Widget_Countdown extends \Elementor\Widget_Base
{

    public function get_name()
    {
        return 'bbt-countdown';
    }

    public function get_title()
    {
        return esc_html__('BBT Countdown Timer', 'bestbalitravel');
    }

    public function get_icon()
    {
        return 'eicon-countdown';
    }

    public function get_categories()
    {
        return array('bbt-widgets');
    }

    protected function register_controls()
    {
        $this->start_controls_section(
            'section_countdown',
            array(
                'label' => esc_html__('Countdown', 'bestbalitravel'),
            )
        );

        $this->add_control(
            'due_date',
            array(
                'label' => esc_html__('Due Date', 'bestbalitravel'),
                'type' => \Elementor\Controls_Manager::DATE_TIME,
                'default' => date('Y-m-d H:i', strtotime('+7 days')),
            )
        );

        $this->add_control(
            'title',
            array(
                'label' => esc_html__('Title', 'bestbalitravel'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => 'Limited Time Offer!',
            )
        );

        $this->add_control(
            'subtitle',
            array(
                'label' => esc_html__('Subtitle', 'bestbalitravel'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => 'Book now and save up to 30%',
            )
        );

        $this->add_control(
            'show_days',
            array(
                'label' => esc_html__('Show Days', 'bestbalitravel'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
            )
        );

        $this->add_control(
            'show_hours',
            array(
                'label' => esc_html__('Show Hours', 'bestbalitravel'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
            )
        );

        $this->add_control(
            'show_minutes',
            array(
                'label' => esc_html__('Show Minutes', 'bestbalitravel'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
            )
        );

        $this->add_control(
            'show_seconds',
            array(
                'label' => esc_html__('Show Seconds', 'bestbalitravel'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
            )
        );

        $this->add_control(
            'expire_action',
            array(
                'label' => esc_html__('After Expire', 'bestbalitravel'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'hide',
                'options' => array(
                    'hide' => esc_html__('Hide Widget', 'bestbalitravel'),
                    'message' => esc_html__('Show Message', 'bestbalitravel'),
                    'redirect' => esc_html__('Redirect', 'bestbalitravel'),
                ),
            )
        );

        $this->add_control(
            'expire_message',
            array(
                'label' => esc_html__('Expire Message', 'bestbalitravel'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => 'This offer has expired.',
                'condition' => array('expire_action' => 'message'),
            )
        );

        $this->end_controls_section();

        // Style Section
        $this->start_controls_section(
            'section_style',
            array(
                'label' => esc_html__('Style', 'bestbalitravel'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_control(
            'style',
            array(
                'label' => esc_html__('Style', 'bestbalitravel'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'cards',
                'options' => array(
                    'cards' => esc_html__('Cards', 'bestbalitravel'),
                    'circles' => esc_html__('Circles', 'bestbalitravel'),
                    'minimal' => esc_html__('Minimal', 'bestbalitravel'),
                    'flip' => esc_html__('Flip Cards', 'bestbalitravel'),
                ),
            )
        );

        $this->add_control(
            'number_color',
            array(
                'label' => esc_html__('Number Color', 'bestbalitravel'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#f5a623',
                'selectors' => array(
                    '{{WRAPPER}} .bbt-countdown-number' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->add_control(
            'background_color',
            array(
                'label' => esc_html__('Background', 'bestbalitravel'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#1e3a5f',
                'selectors' => array(
                    '{{WRAPPER}} .bbt-countdown-unit' => 'background-color: {{VALUE}};',
                ),
            )
        );

        $this->end_controls_section();

        // CTA Section
        $this->start_controls_section(
            'section_cta',
            array(
                'label' => esc_html__('Call to Action', 'bestbalitravel'),
            )
        );

        $this->add_control(
            'show_button',
            array(
                'label' => esc_html__('Show Button', 'bestbalitravel'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
            )
        );

        $this->add_control(
            'button_text',
            array(
                'label' => esc_html__('Button Text', 'bestbalitravel'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => 'Book Now',
                'condition' => array('show_button' => 'yes'),
            )
        );

        $this->add_control(
            'button_link',
            array(
                'label' => esc_html__('Button Link', 'bestbalitravel'),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => 'https://example.com',
                'condition' => array('show_button' => 'yes'),
            )
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $due_date = strtotime($settings['due_date']);
        $countdown_id = 'bbt-countdown-' . $this->get_id();

        $countdown_config = array(
            'dueDate' => $due_date * 1000, // Convert to milliseconds
            'expireAction' => $settings['expire_action'],
            'expireMessage' => $settings['expire_message'],
        );
        ?>

        <div id="<?php echo esc_attr($countdown_id); ?>"
            class="bbt-countdown-widget bbt-countdown-<?php echo esc_attr($settings['style']); ?>"
            data-countdown='<?php echo wp_json_encode($countdown_config); ?>'>

            <?php if (!empty($settings['title']) || !empty($settings['subtitle'])): ?>
                <div class="bbt-countdown-header">
                    <?php if (!empty($settings['title'])): ?>
                        <h3 class="bbt-countdown-title">
                            <?php echo esc_html($settings['title']); ?>
                        </h3>
                    <?php endif; ?>

                    <?php if (!empty($settings['subtitle'])): ?>
                        <p class="bbt-countdown-subtitle">
                            <?php echo esc_html($settings['subtitle']); ?>
                        </p>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <div class="bbt-countdown-timer">
                <?php if ('yes' === $settings['show_days']): ?>
                    <div class="bbt-countdown-unit">
                        <span class="bbt-countdown-number" data-type="days">00</span>
                        <span class="bbt-countdown-label">
                            <?php esc_html_e('Days', 'bestbalitravel'); ?>
                        </span>
                    </div>
                <?php endif; ?>

                <?php if ('yes' === $settings['show_hours']): ?>
                    <div class="bbt-countdown-unit">
                        <span class="bbt-countdown-number" data-type="hours">00</span>
                        <span class="bbt-countdown-label">
                            <?php esc_html_e('Hours', 'bestbalitravel'); ?>
                        </span>
                    </div>
                <?php endif; ?>

                <?php if ('yes' === $settings['show_minutes']): ?>
                    <div class="bbt-countdown-unit">
                        <span class="bbt-countdown-number" data-type="minutes">00</span>
                        <span class="bbt-countdown-label">
                            <?php esc_html_e('Minutes', 'bestbalitravel'); ?>
                        </span>
                    </div>
                <?php endif; ?>

                <?php if ('yes' === $settings['show_seconds']): ?>
                    <div class="bbt-countdown-unit">
                        <span class="bbt-countdown-number" data-type="seconds">00</span>
                        <span class="bbt-countdown-label">
                            <?php esc_html_e('Seconds', 'bestbalitravel'); ?>
                        </span>
                    </div>
                <?php endif; ?>
            </div>

            <?php if ('yes' === $settings['show_button']):
                $link = $settings['button_link'];
                $link_url = $link['url'] ?? '#';
                $link_target = !empty($link['is_external']) ? '_blank' : '_self';
                ?>
                <div class="bbt-countdown-cta">
                    <a href="<?php echo esc_url($link_url); ?>" target="<?php echo esc_attr($link_target); ?>"
                        class="bbt-btn bbt-btn-primary">
                        <?php echo esc_html($settings['button_text']); ?>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="5" y1="12" x2="19" y2="12" />
                            <polyline points="12 5 19 12 12 19" />
                        </svg>
                    </a>
                </div>
            <?php endif; ?>

            <div class="bbt-countdown-expired" style="display: none;">
                <?php echo esc_html($settings['expire_message']); ?>
            </div>
        </div>

        <?php
    }
}
