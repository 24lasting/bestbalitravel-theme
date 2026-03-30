<?php
/**
 * Elementor Newsletter Widget
 *
 * @package BestBaliTravel
 */

if (!defined('ABSPATH')) {
    exit;
}

class BBT_Widget_Newsletter extends \Elementor\Widget_Base
{

    public function get_name()
    {
        return 'bbt-newsletter';
    }

    public function get_title()
    {
        return esc_html__('BBT Newsletter', 'bestbalitravel');
    }

    public function get_icon()
    {
        return 'eicon-email-field';
    }

    public function get_categories()
    {
        return array('bbt-widgets');
    }

    protected function register_controls()
    {
        $this->start_controls_section(
            'section_content',
            array(
                'label' => esc_html__('Content', 'bestbalitravel'),
            )
        );

        $this->add_control(
            'title',
            array(
                'label' => esc_html__('Title', 'bestbalitravel'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => 'Subscribe to Our Newsletter',
            )
        );

        $this->add_control(
            'description',
            array(
                'label' => esc_html__('Description', 'bestbalitravel'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => 'Get exclusive travel deals and insider tips delivered to your inbox.',
            )
        );

        $this->add_control(
            'button_text',
            array(
                'label' => esc_html__('Button Text', 'bestbalitravel'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => 'Subscribe',
            )
        );

        $this->add_control(
            'style',
            array(
                'label' => esc_html__('Style', 'bestbalitravel'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'inline',
                'options' => array(
                    'inline' => esc_html__('Inline', 'bestbalitravel'),
                    'stacked' => esc_html__('Stacked', 'bestbalitravel'),
                    'minimal' => esc_html__('Minimal', 'bestbalitravel'),
                ),
            )
        );

        $this->add_control(
            'background_style',
            array(
                'label' => esc_html__('Background', 'bestbalitravel'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'gradient',
                'options' => array(
                    'none' => esc_html__('None', 'bestbalitravel'),
                    'gradient' => esc_html__('Gradient', 'bestbalitravel'),
                    'image' => esc_html__('Image', 'bestbalitravel'),
                ),
            )
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $style_class = 'bbt-newsletter-' . $settings['style'];
        $bg_class = 'bbt-newsletter-bg-' . $settings['background_style'];
        ?>

        <div class="bbt-newsletter-widget <?php echo esc_attr($style_class . ' ' . $bg_class); ?>">
            <div class="bbt-newsletter-content">
                <?php if (!empty($settings['title'])): ?>
                    <h3 class="bbt-newsletter-title">
                        <?php echo esc_html($settings['title']); ?>
                    </h3>
                <?php endif; ?>

                <?php if (!empty($settings['description'])): ?>
                    <p class="bbt-newsletter-desc">
                        <?php echo esc_html($settings['description']); ?>
                    </p>
                <?php endif; ?>
            </div>

            <form class="bbt-newsletter-form" action="#" method="post">
                <?php wp_nonce_field('bbt_newsletter', 'bbt_newsletter_nonce'); ?>

                <div class="bbt-newsletter-input-wrap">
                    <input type="email" name="email" class="bbt-newsletter-input"
                        placeholder="<?php esc_attr_e('Enter your email', 'bestbalitravel'); ?>" required>

                    <button type="submit" class="bbt-newsletter-btn">
                        <span class="bbt-btn-text">
                            <?php echo esc_html($settings['button_text']); ?>
                        </span>
                        <span class="bbt-btn-loading">
                            <svg class="bbt-spinner" width="20" height="20" viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3" fill="none"
                                    stroke-dasharray="30 70" />
                            </svg>
                        </span>
                    </button>
                </div>

                <div class="bbt-newsletter-message"></div>
            </form>

            <p class="bbt-newsletter-privacy">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                </svg>
                <?php esc_html_e('We respect your privacy. Unsubscribe anytime.', 'bestbalitravel'); ?>
            </p>
        </div>

        <?php
    }
}
