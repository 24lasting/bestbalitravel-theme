<?php
/**
 * Elementor WhatsApp CTA Widget
 *
 * @package BestBaliTravel
 */

if (!defined('ABSPATH')) {
    exit;
}

class BBT_Widget_Whatsapp_Cta extends \Elementor\Widget_Base
{

    public function get_name()
    {
        return 'bbt-whatsapp-cta';
    }

    public function get_title()
    {
        return esc_html__('BBT WhatsApp CTA', 'bestbalitravel');
    }

    public function get_icon()
    {
        return 'eicon-commenting-o';
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
                'label' => esc_html__('WhatsApp Settings', 'bestbalitravel'),
            )
        );

        $this->add_control(
            'phone_number',
            array(
                'label' => esc_html__('WhatsApp Number', 'bestbalitravel'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => '+6287854806011',
                'placeholder' => '+6281234567890',
            )
        );

        $this->add_control(
            'default_message',
            array(
                'label' => esc_html__('Default Message', 'bestbalitravel'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => 'Hi! I have a question about your tours.',
            )
        );

        $this->add_control(
            'button_text',
            array(
                'label' => esc_html__('Button Text', 'bestbalitravel'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => 'Chat with Us',
            )
        );

        $this->add_control(
            'style',
            array(
                'label' => esc_html__('Style', 'bestbalitravel'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'floating',
                'options' => array(
                    'floating' => esc_html__('Floating Button', 'bestbalitravel'),
                    'inline' => esc_html__('Inline Button', 'bestbalitravel'),
                    'banner' => esc_html__('Banner', 'bestbalitravel'),
                ),
            )
        );

        $this->add_control(
            'position',
            array(
                'label' => esc_html__('Position', 'bestbalitravel'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'bottom-right',
                'options' => array(
                    'bottom-right' => esc_html__('Bottom Right', 'bestbalitravel'),
                    'bottom-left' => esc_html__('Bottom Left', 'bestbalitravel'),
                ),
                'condition' => array('style' => 'floating'),
            )
        );

        $this->add_control(
            'show_pulse',
            array(
                'label' => esc_html__('Pulse Animation', 'bestbalitravel'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
            )
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $phone = preg_replace('/[^0-9]/', '', $settings['phone_number']);
        $message = urlencode($settings['default_message']);
        $url = "https://wa.me/{$phone}?text={$message}";

        $pulse_class = 'yes' === $settings['show_pulse'] ? 'bbt-pulse' : '';
        ?>

        <?php if ('floating' === $settings['style']): ?>
            <div class="bbt-whatsapp-floating <?php echo esc_attr($settings['position'] . ' ' . $pulse_class); ?>">
                <a href="<?php echo esc_url($url); ?>" target="_blank" class="bbt-wa-btn" aria-label="WhatsApp">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="currentColor">
                        <path
                            d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                    </svg>
                </a>
                <span class="bbt-wa-tooltip">
                    <?php echo esc_html($settings['button_text']); ?>
                </span>
            </div>

        <?php elseif ('banner' === $settings['style']): ?>
            <div class="bbt-whatsapp-banner">
                <div class="bbt-banner-content">
                    <div class="bbt-banner-icon">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                        </svg>
                    </div>
                    <div class="bbt-banner-text">
                        <strong>
                            <?php esc_html_e('Need help planning your trip?', 'bestbalitravel'); ?>
                        </strong>
                        <p>
                            <?php esc_html_e('Chat with our travel experts on WhatsApp!', 'bestbalitravel'); ?>
                        </p>
                    </div>
                </div>
                <a href="<?php echo esc_url($url); ?>" target="_blank" class="bbt-banner-btn">
                    <?php echo esc_html($settings['button_text']); ?>
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M5 12h14M12 5l7 7-7 7" />
                    </svg>
                </a>
            </div>

        <?php else: ?>
            <a href="<?php echo esc_url($url); ?>" target="_blank"
                class="bbt-whatsapp-inline <?php echo esc_attr($pulse_class); ?>">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                    <path
                        d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                </svg>
                <?php echo esc_html($settings['button_text']); ?>
            </a>
        <?php endif; ?>

        <?php
    }
}
