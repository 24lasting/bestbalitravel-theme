<?php
/**
 * Elementor Search Box Widget
 *
 * @package BestBaliTravel
 */

if (!defined('ABSPATH')) {
    exit;
}

class BBT_Widget_Search_Box extends \Elementor\Widget_Base
{

    public function get_name()
    {
        return 'bbt-search-box';
    }

    public function get_title()
    {
        return esc_html__('BBT Search Box', 'bestbalitravel');
    }

    public function get_icon()
    {
        return 'eicon-search';
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
                'label' => esc_html__('Search Settings', 'bestbalitravel'),
            )
        );

        $this->add_control(
            'style',
            array(
                'label' => esc_html__('Style', 'bestbalitravel'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'horizontal',
                'options' => array(
                    'horizontal' => esc_html__('Horizontal', 'bestbalitravel'),
                    'vertical' => esc_html__('Vertical', 'bestbalitravel'),
                    'minimal' => esc_html__('Minimal Bar', 'bestbalitravel'),
                ),
            )
        );

        $this->add_control(
            'show_destination',
            array(
                'label' => esc_html__('Show Destination', 'bestbalitravel'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
            )
        );

        $this->add_control(
            'show_tour_type',
            array(
                'label' => esc_html__('Show Tour Type', 'bestbalitravel'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
            )
        );

        $this->add_control(
            'show_date',
            array(
                'label' => esc_html__('Show Date Picker', 'bestbalitravel'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
            )
        );

        $this->add_control(
            'show_guests',
            array(
                'label' => esc_html__('Show Guests', 'bestbalitravel'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'no',
            )
        );

        $this->add_control(
            'button_text',
            array(
                'label' => esc_html__('Button Text', 'bestbalitravel'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => 'Search Tours',
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
            'background_style',
            array(
                'label' => esc_html__('Background', 'bestbalitravel'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'glass',
                'options' => array(
                    'solid' => esc_html__('Solid White', 'bestbalitravel'),
                    'glass' => esc_html__('Glass Effect', 'bestbalitravel'),
                    'dark' => esc_html__('Dark', 'bestbalitravel'),
                ),
            )
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $locations = get_terms(array('taxonomy' => 'tour_location', 'hide_empty' => false));
        $types = get_terms(array('taxonomy' => 'tour_type', 'hide_empty' => false));

        $classes = array(
            'bbt-search-box',
            'bbt-search-' . $settings['style'],
            'bbt-search-bg-' . $settings['background_style'],
        );
        ?>

        <div class="<?php echo esc_attr(implode(' ', $classes)); ?>">
            <form class="bbt-search-form" action="<?php echo esc_url(home_url('/')); ?>" method="get">
                <input type="hidden" name="post_type" value="tour">

                <?php if ('yes' === $settings['show_destination'] && !is_wp_error($locations)): ?>
                    <div class="bbt-search-field">
                        <label>
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" />
                                <circle cx="12" cy="10" r="3" />
                            </svg>
                            <?php esc_html_e('Destination', 'bestbalitravel'); ?>
                        </label>
                        <select name="tour_location" class="bbt-search-select">
                            <option value="">
                                <?php esc_html_e('All Locations', 'bestbalitravel'); ?>
                            </option>
                            <?php foreach ($locations as $location): ?>
                                <option value="<?php echo esc_attr($location->slug); ?>">
                                    <?php echo esc_html($location->name); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                <?php endif; ?>

                <?php if ('yes' === $settings['show_tour_type'] && !is_wp_error($types)): ?>
                    <div class="bbt-search-field">
                        <label>
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10" />
                                <polygon points="16.24 7.76 14.12 14.12 7.76 16.24 9.88 9.88 16.24 7.76" />
                            </svg>
                            <?php esc_html_e('Tour Type', 'bestbalitravel'); ?>
                        </label>
                        <select name="tour_type" class="bbt-search-select">
                            <option value="">
                                <?php esc_html_e('All Types', 'bestbalitravel'); ?>
                            </option>
                            <?php foreach ($types as $type): ?>
                                <option value="<?php echo esc_attr($type->slug); ?>">
                                    <?php echo esc_html($type->name); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                <?php endif; ?>

                <?php if ('yes' === $settings['show_date']): ?>
                    <div class="bbt-search-field">
                        <label>
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                                <line x1="16" y1="2" x2="16" y2="6" />
                                <line x1="8" y1="2" x2="8" y2="6" />
                                <line x1="3" y1="10" x2="21" y2="10" />
                            </svg>
                            <?php esc_html_e('Date', 'bestbalitravel'); ?>
                        </label>
                        <input type="date" name="tour_date" class="bbt-search-date" min="<?php echo esc_attr(date('Y-m-d')); ?>"
                            placeholder="<?php esc_attr_e('Select Date', 'bestbalitravel'); ?>">
                    </div>
                <?php endif; ?>

                <?php if ('yes' === $settings['show_guests']): ?>
                    <div class="bbt-search-field">
                        <label>
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                                <circle cx="9" cy="7" r="4" />
                                <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                                <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                            </svg>
                            <?php esc_html_e('Guests', 'bestbalitravel'); ?>
                        </label>
                        <select name="guests" class="bbt-search-select">
                            <option value="">
                                <?php esc_html_e('Any', 'bestbalitravel'); ?>
                            </option>
                            <?php for ($i = 1; $i <= 10; $i++): ?>
                                <option value="<?php echo esc_attr($i); ?>">
                                    <?php echo esc_html($i . ' ' . _n('Guest', 'Guests', $i, 'bestbalitravel')); ?>
                                </option>
                            <?php endfor; ?>
                        </select>
                    </div>
                <?php endif; ?>

                <button type="submit" class="bbt-search-btn">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="8" />
                        <line x1="21" y1="21" x2="16.65" y2="16.65" />
                    </svg>
                    <span>
                        <?php echo esc_html($settings['button_text']); ?>
                    </span>
                </button>
            </form>
        </div>

        <?php
    }
}
