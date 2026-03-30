<?php
/**
 * Elementor Booking Widget
 *
 * @package BestBaliTravel
 */

if (!defined('ABSPATH')) {
    exit;
}

class BBT_Widget_Booking extends \Elementor\Widget_Base
{

    public function get_name()
    {
        return 'bbt-booking-widget';
    }

    public function get_title()
    {
        return esc_html__('BBT Booking Widget', 'bestbalitravel');
    }

    public function get_icon()
    {
        return 'eicon-form-horizontal';
    }

    public function get_categories()
    {
        return array('bbt-widgets');
    }

    protected function register_controls()
    {
        $this->start_controls_section(
            'section_booking',
            array(
                'label' => esc_html__('Booking Settings', 'bestbalitravel'),
            )
        );

        $this->add_control(
            'tour_source',
            array(
                'label' => esc_html__('Tour Source', 'bestbalitravel'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'current',
                'options' => array(
                    'current' => esc_html__('Current Post', 'bestbalitravel'),
                    'select' => esc_html__('Select Tour', 'bestbalitravel'),
                ),
            )
        );

        $this->add_control(
            'widget_style',
            array(
                'label' => esc_html__('Style', 'bestbalitravel'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'card',
                'options' => array(
                    'card' => esc_html__('Card', 'bestbalitravel'),
                    'inline' => esc_html__('Inline', 'bestbalitravel'),
                    'sticky' => esc_html__('Sticky Sidebar', 'bestbalitravel'),
                ),
            )
        );

        $this->add_control(
            'show_price',
            array(
                'label' => esc_html__('Show Price', 'bestbalitravel'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
            )
        );

        $this->add_control(
            'show_date_picker',
            array(
                'label' => esc_html__('Show Date Picker', 'bestbalitravel'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
            )
        );

        $this->add_control(
            'show_guest_counter',
            array(
                'label' => esc_html__('Show Guest Counter', 'bestbalitravel'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
            )
        );

        $this->add_control(
            'whatsapp_booking',
            array(
                'label' => esc_html__('Enable WhatsApp Booking', 'bestbalitravel'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
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
            'primary_color',
            array(
                'label' => esc_html__('Primary Color', 'bestbalitravel'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#f5a623',
                'selectors' => array(
                    '{{WRAPPER}} .bbt-booking-btn' => 'background: {{VALUE}};',
                    '{{WRAPPER}} .bbt-booking-price' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $tour_id = get_the_ID();
        $price = get_post_meta($tour_id, '_bbt_tour_price', true);
        $sale_price = get_post_meta($tour_id, '_bbt_tour_sale_price', true);
        $child_price = get_post_meta($tour_id, '_bbt_tour_child_price', true);
        $whatsapp = get_theme_mod('bbt_whatsapp', '+6287854806011');

        $current_price = $sale_price ? $sale_price : $price;
        ?>

        <div class="bbt-booking-widget bbt-booking-<?php echo esc_attr($settings['widget_style']); ?>">

            <?php if ('yes' === $settings['show_price']): ?>
                <div class="bbt-booking-pricing">
                    <?php if ($sale_price): ?>
                        <span class="bbt-price-original">
                            <?php echo esc_html(bbt_format_price($price)); ?>
                        </span>
                    <?php endif; ?>
                    <span class="bbt-booking-price">
                        <?php echo esc_html(bbt_format_price($current_price)); ?>
                    </span>
                    <span class="bbt-price-unit">/
                        <?php esc_html_e('person', 'bestbalitravel'); ?>
                    </span>
                </div>
            <?php endif; ?>

            <form class="bbt-booking-form" data-tour-id="<?php echo esc_attr($tour_id); ?>">
                <?php wp_nonce_field('bbt_booking_nonce', 'bbt_booking_nonce'); ?>
                <input type="hidden" name="tour_id" value="<?php echo esc_attr($tour_id); ?>">
                <input type="hidden" name="tour_title" value="<?php echo esc_attr(get_the_title($tour_id)); ?>">
                <input type="hidden" name="adult_price" value="<?php echo esc_attr($current_price); ?>">
                <input type="hidden" name="child_price" value="<?php echo esc_attr($child_price ?: $current_price * 0.5); ?>">

                <?php if ('yes' === $settings['show_date_picker']): ?>
                    <div class="bbt-form-group">
                        <label>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                                <line x1="16" y1="2" x2="16" y2="6" />
                                <line x1="8" y1="2" x2="8" y2="6" />
                                <line x1="3" y1="10" x2="21" y2="10" />
                            </svg>
                            <?php esc_html_e('Select Date', 'bestbalitravel'); ?>
                        </label>
                        <input type="date" name="tour_date" class="bbt-date-input"
                            min="<?php echo esc_attr(date('Y-m-d', strtotime('+1 day'))); ?>" required>
                    </div>
                <?php endif; ?>

                <?php if ('yes' === $settings['show_guest_counter']): ?>
                    <div class="bbt-form-group">
                        <label>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                                <circle cx="9" cy="7" r="4" />
                                <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                                <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                            </svg>
                            <?php esc_html_e('Guests', 'bestbalitravel'); ?>
                        </label>

                        <div class="bbt-guests-selector">
                            <div class="bbt-guest-row">
                                <div class="bbt-guest-info">
                                    <span class="bbt-guest-type">
                                        <?php esc_html_e('Adults', 'bestbalitravel'); ?>
                                    </span>
                                    <span class="bbt-guest-age">
                                        <?php esc_html_e('Age 12+', 'bestbalitravel'); ?>
                                    </span>
                                </div>
                                <div class="bbt-guest-counter">
                                    <button type="button" class="bbt-counter-btn bbt-minus" data-target="adults">−</button>
                                    <input type="number" name="adults" value="2" min="1" max="20" class="bbt-counter-input"
                                        readonly>
                                    <button type="button" class="bbt-counter-btn bbt-plus" data-target="adults">+</button>
                                </div>
                            </div>

                            <div class="bbt-guest-row">
                                <div class="bbt-guest-info">
                                    <span class="bbt-guest-type">
                                        <?php esc_html_e('Children', 'bestbalitravel'); ?>
                                    </span>
                                    <span class="bbt-guest-age">
                                        <?php esc_html_e('Age 2-11', 'bestbalitravel'); ?>
                                    </span>
                                </div>
                                <div class="bbt-guest-counter">
                                    <button type="button" class="bbt-counter-btn bbt-minus" data-target="children">−</button>
                                    <input type="number" name="children" value="0" min="0" max="10" class="bbt-counter-input"
                                        readonly>
                                    <button type="button" class="bbt-counter-btn bbt-plus" data-target="children">+</button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Price Summary -->
                <div class="bbt-price-summary">
                    <div class="bbt-summary-row">
                        <span>
                            <?php esc_html_e('Adults', 'bestbalitravel'); ?> (<span class="bbt-adult-count">2</span> ×
                            <?php echo esc_html(bbt_format_price($current_price)); ?>)
                        </span>
                        <span class="bbt-adult-total">
                            <?php echo esc_html(bbt_format_price($current_price * 2)); ?>
                        </span>
                    </div>
                    <div class="bbt-summary-row bbt-children-row" style="display: none;">
                        <span>
                            <?php esc_html_e('Children', 'bestbalitravel'); ?> (<span class="bbt-child-count">0</span> ×
                            <?php echo esc_html(bbt_format_price($child_price ?: $current_price * 0.5)); ?>)
                        </span>
                        <span class="bbt-child-total">
                            <?php echo esc_html(bbt_format_price(0)); ?>
                        </span>
                    </div>
                    <div class="bbt-summary-row bbt-total-row">
                        <strong>
                            <?php esc_html_e('Total', 'bestbalitravel'); ?>
                        </strong>
                        <strong class="bbt-grand-total">
                            <?php echo esc_html(bbt_format_price($current_price * 2)); ?>
                        </strong>
                    </div>
                </div>

                <!-- Booking Button -->
                <button type="submit" class="bbt-booking-btn">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z" />
                        <line x1="7" y1="7" x2="7.01" y2="7" />
                    </svg>
                    <?php esc_html_e('Book Now', 'bestbalitravel'); ?>
                </button>

                <?php if ('yes' === $settings['whatsapp_booking']): ?>
                    <a href="https://wa.me/<?php echo esc_attr(preg_replace('/[^0-9]/', '', $whatsapp)); ?>?text=<?php echo esc_attr(urlencode('Hi! I want to book: ' . get_the_title($tour_id))); ?>"
                        class="bbt-whatsapp-btn" target="_blank">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                        </svg>
                        <?php esc_html_e('Book via WhatsApp', 'bestbalitravel'); ?>
                    </a>
                <?php endif; ?>

            </form>

            <!-- Trust Badges -->
            <div class="bbt-trust-badges">
                <div class="bbt-badge">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                    </svg>
                    <?php esc_html_e('Secure Booking', 'bestbalitravel'); ?>
                </div>
                <div class="bbt-badge">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10" />
                        <polyline points="12 6 12 12 16 14" />
                    </svg>
                    <?php esc_html_e('Instant Confirmation', 'bestbalitravel'); ?>
                </div>
            </div>
        </div>

        <?php
    }
}
