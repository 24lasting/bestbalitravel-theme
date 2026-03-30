<?php
/**
 * Elementor Pricing Table Widget
 *
 * @package BestBaliTravel
 */

if (!defined('ABSPATH')) {
    exit;
}

class BBT_Widget_Pricing_Table extends \Elementor\Widget_Base
{

    public function get_name()
    {
        return 'bbt-pricing-table';
    }

    public function get_title()
    {
        return esc_html__('BBT Pricing Table', 'bestbalitravel');
    }

    public function get_icon()
    {
        return 'eicon-price-table';
    }

    public function get_categories()
    {
        return array('bbt-widgets');
    }

    protected function register_controls()
    {
        // Pricing Plans Section
        $this->start_controls_section(
            'section_pricing',
            array(
                'label' => esc_html__('Pricing Plans', 'bestbalitravel'),
            )
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'title',
            array(
                'label' => esc_html__('Plan Title', 'bestbalitravel'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => 'Standard',
            )
        );

        $repeater->add_control(
            'subtitle',
            array(
                'label' => esc_html__('Subtitle', 'bestbalitravel'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => 'Best for solo travelers',
            )
        );

        $repeater->add_control(
            'price',
            array(
                'label' => esc_html__('Price', 'bestbalitravel'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => '500,000',
            )
        );

        $repeater->add_control(
            'currency',
            array(
                'label' => esc_html__('Currency', 'bestbalitravel'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => 'Rp',
            )
        );

        $repeater->add_control(
            'period',
            array(
                'label' => esc_html__('Period', 'bestbalitravel'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => 'per person',
            )
        );

        $repeater->add_control(
            'original_price',
            array(
                'label' => esc_html__('Original Price (for sale)', 'bestbalitravel'),
                'type' => \Elementor\Controls_Manager::TEXT,
            )
        );

        $repeater->add_control(
            'is_featured',
            array(
                'label' => esc_html__('Featured', 'bestbalitravel'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'no',
            )
        );

        $repeater->add_control(
            'badge_text',
            array(
                'label' => esc_html__('Badge Text', 'bestbalitravel'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => 'Most Popular',
                'condition' => array('is_featured' => 'yes'),
            )
        );

        $repeater->add_control(
            'features',
            array(
                'label' => esc_html__('Features (one per line)', 'bestbalitravel'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => "Hotel pickup & drop-off\nEnglish speaking guide\nLunch included\nEntrance tickets\nBottled water",
            )
        );

        $repeater->add_control(
            'button_text',
            array(
                'label' => esc_html__('Button Text', 'bestbalitravel'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => 'Book Now',
            )
        );

        $repeater->add_control(
            'button_link',
            array(
                'label' => esc_html__('Button Link', 'bestbalitravel'),
                'type' => \Elementor\Controls_Manager::URL,
            )
        );

        $this->add_control(
            'plans',
            array(
                'label' => esc_html__('Pricing Plans', 'bestbalitravel'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => array(
                    array(
                        'title' => 'Standard',
                        'price' => '500,000',
                        'features' => "Hotel pickup\nEnglish guide\nLunch\nEntrance tickets",
                    ),
                    array(
                        'title' => 'Premium',
                        'price' => '750,000',
                        'is_featured' => 'yes',
                        'badge_text' => 'Best Value',
                        'features' => "Private transport\nEnglish guide\nLunch & snacks\nEntrance tickets\nPhoto session",
                    ),
                    array(
                        'title' => 'Luxury',
                        'price' => '1,200,000',
                        'features' => "Private luxury car\nPersonal guide\nFine dining\nVIP access\nProfessional photos\nSpa treatment",
                    ),
                ),
                'title_field' => '{{{ title }}}',
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
                'default' => 'default',
                'options' => array(
                    'default' => esc_html__('Default', 'bestbalitravel'),
                    'gradient' => esc_html__('Gradient', 'bestbalitravel'),
                    'minimal' => esc_html__('Minimal', 'bestbalitravel'),
                    'dark' => esc_html__('Dark', 'bestbalitravel'),
                ),
            )
        );

        $this->add_control(
            'featured_color',
            array(
                'label' => esc_html__('Featured Plan Accent', 'bestbalitravel'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#f5a623',
            )
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        if (empty($settings['plans'])) {
            return;
        }
        ?>

        <div class="bbt-pricing-table bbt-pricing-<?php echo esc_attr($settings['style']); ?>">
            <?php foreach ($settings['plans'] as $index => $plan):
                $is_featured = 'yes' === $plan['is_featured'];
                $classes = array('bbt-pricing-plan');
                if ($is_featured) {
                    $classes[] = 'bbt-plan-featured';
                }

                $features = array_filter(array_map('trim', explode("\n", $plan['features'])));
                ?>
                <div class="<?php echo esc_attr(implode(' ', $classes)); ?>">
                    <?php if ($is_featured && !empty($plan['badge_text'])): ?>
                        <span class="bbt-plan-badge" style="background-color: <?php echo esc_attr($settings['featured_color']); ?>">
                            <?php echo esc_html($plan['badge_text']); ?>
                        </span>
                    <?php endif; ?>

                    <div class="bbt-plan-header">
                        <h3 class="bbt-plan-title">
                            <?php echo esc_html($plan['title']); ?>
                        </h3>
                        <?php if (!empty($plan['subtitle'])): ?>
                            <p class="bbt-plan-subtitle">
                                <?php echo esc_html($plan['subtitle']); ?>
                            </p>
                        <?php endif; ?>
                    </div>

                    <div class="bbt-plan-price">
                        <?php if (!empty($plan['original_price'])): ?>
                            <span class="bbt-price-original">
                                <?php echo esc_html($plan['currency'] . ' ' . $plan['original_price']); ?>
                            </span>
                        <?php endif; ?>

                        <div class="bbt-price-current">
                            <span class="bbt-price-currency">
                                <?php echo esc_html($plan['currency']); ?>
                            </span>
                            <span class="bbt-price-amount">
                                <?php echo esc_html($plan['price']); ?>
                            </span>
                        </div>

                        <?php if (!empty($plan['period'])): ?>
                            <span class="bbt-price-period">
                                <?php echo esc_html($plan['period']); ?>
                            </span>
                        <?php endif; ?>
                    </div>

                    <?php if (!empty($features)): ?>
                        <ul class="bbt-plan-features">
                            <?php foreach ($features as $feature): ?>
                                <li>
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                                        <polyline points="20 6 9 17 4 12" />
                                    </svg>
                                    <?php echo esc_html($feature); ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>

                    <?php if (!empty($plan['button_text'])):
                        $link = $plan['button_link'];
                        $link_url = $link['url'] ?? '#';
                        $btn_class = $is_featured ? 'bbt-btn-primary' : 'bbt-btn-outline';
                        ?>
                        <a href="<?php echo esc_url($link_url); ?>" class="bbt-btn <?php echo esc_attr($btn_class); ?>">
                            <?php echo esc_html($plan['button_text']); ?>
                        </a>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>

        <?php
    }
}
