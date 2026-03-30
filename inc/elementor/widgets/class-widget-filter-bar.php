<?php
if (!defined('ABSPATH'))
    exit;

class BBT_Widget_Filter_Bar extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'bbt-filter-bar';
    }
    public function get_title()
    {
        return esc_html__('Filter Bar', 'bestbalitravel');
    }
    public function get_icon()
    {
        return 'eicon-filter';
    }
    public function get_categories()
    {
        return ['bbt-widgets'];
    }

    protected function register_controls()
    {
        $this->start_controls_section('section_filters', ['label' => 'Filters']);
        $this->add_control('show_location', ['label' => 'Location', 'type' => \Elementor\Controls_Manager::SWITCHER, 'default' => 'yes']);
        $this->add_control('show_type', ['label' => 'Type', 'type' => \Elementor\Controls_Manager::SWITCHER, 'default' => 'yes']);
        $this->add_control('show_price', ['label' => 'Price', 'type' => \Elementor\Controls_Manager::SWITCHER, 'default' => 'yes']);
        $this->add_control('show_search', ['label' => 'Search', 'type' => \Elementor\Controls_Manager::SWITCHER, 'default' => 'yes']);
        $this->end_controls_section();
    }

    protected function render()
    {
        $s = $this->get_settings_for_display();
        ?>
        <div class="bbt-filter-bar">
            <?php if ($s['show_search'] === 'yes'): ?>
                <div class="bbt-fb-field search"><span>🔍</span><input type="text" placeholder="Search tours..."></div>
            <?php endif; ?>
            <?php if ($s['show_location'] === 'yes'): ?>
                <div class="bbt-fb-field">
                    <span>📍</span>
                    <select>
                        <option value="">All Locations</option>
                        <?php $locs = get_terms(['taxonomy' => 'tour_location', 'hide_empty' => true]);
                        if (!is_wp_error($locs))
                            foreach ($locs as $l)
                                echo '<option value="' . esc_attr($l->slug) . '">' . esc_html($l->name) . '</option>'; ?>
                    </select>
                </div>
            <?php endif; ?>
            <?php if ($s['show_type'] === 'yes'): ?>
                <div class="bbt-fb-field">
                    <span>🎭</span>
                    <select>
                        <option value="">All Types</option>
                        <?php $types = get_terms(['taxonomy' => 'tour_type', 'hide_empty' => true]);
                        if (!is_wp_error($types))
                            foreach ($types as $t)
                                echo '<option value="' . esc_attr($t->slug) . '">' . esc_html($t->name) . '</option>'; ?>
                    </select>
                </div>
            <?php endif; ?>
            <?php if ($s['show_price'] === 'yes'): ?>
                <div class="bbt-fb-field">
                    <span>💰</span>
                    <select>
                        <option value="">Any Price</option>
                        <option value="0-500000">Under 500K</option>
                        <option value="500000-1000000">500K - 1M</option>
                        <option value="1000000+">1M+</option>
                    </select>
                </div>
            <?php endif; ?>
            <button class="bbt-fb-btn">Search</button>
        </div>
        <style>
            .bbt-filter-bar {
                display: flex;
                gap: 15px;
                padding: 20px;
                background: #fff;
                border-radius: 16px;
                box-shadow: 0 8px 30px rgba(0, 0, 0, .08);
                flex-wrap: wrap
            }

            .bbt-fb-field {
                display: flex;
                align-items: center;
                gap: 10px;
                padding: 12px 16px;
                background: #f5f5f5;
                border-radius: 12px;
                flex: 1;
                min-width: 150px
            }

            .bbt-fb-field.search {
                flex: 2
            }

            .bbt-fb-field span {
                font-size: 18px
            }

            .bbt-fb-field input,
            .bbt-fb-field select {
                flex: 1;
                border: none;
                background: transparent;
                font-size: 14px
            }

            .bbt-fb-field input:focus,
            .bbt-fb-field select:focus {
                outline: none
            }

            .bbt-fb-btn {
                padding: 15px 30px;
                background: #F5A623;
                border: none;
                border-radius: 12px;
                font-size: 15px;
                font-weight: 600;
                cursor: pointer
            }
        </style>
        <?php
    }
}
