<?php
if (!defined('ABSPATH'))
    exit;

class BBT_Widget_Rating_Display extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'bbt-rating-display';
    }
    public function get_title()
    {
        return esc_html__('Rating Display', 'bestbalitravel');
    }
    public function get_icon()
    {
        return 'eicon-rating';
    }
    public function get_categories()
    {
        return ['bbt-widgets'];
    }

    protected function register_controls()
    {
        $this->start_controls_section('section_content', ['label' => 'Content']);
        $this->add_control('rating', ['label' => 'Rating', 'type' => \Elementor\Controls_Manager::NUMBER, 'default' => 4.8, 'min' => 0, 'max' => 5, 'step' => 0.1]);
        $this->add_control('reviews', ['label' => 'Reviews Count', 'type' => \Elementor\Controls_Manager::NUMBER, 'default' => 1250]);
        $this->add_control('style', ['label' => 'Style', 'type' => \Elementor\Controls_Manager::SELECT, 'options' => ['inline' => 'Inline', 'card' => 'Card', 'large' => 'Large'], 'default' => 'card']);
        $this->end_controls_section();
    }

    protected function render()
    {
        $s = $this->get_settings_for_display();
        $full = floor($s['rating']);
        $half = ($s['rating'] - $full) >= 0.5;
        ?>
        <div class="bbt-rating-display style-<?php echo esc_attr($s['style']); ?>">
            <div class="bbt-rd-score">
                <?php echo esc_html($s['rating']); ?>
            </div>
            <div class="bbt-rd-stars">
                <?php for ($i = 0; $i < $full; $i++)
                    echo '⭐';
                if ($half)
                    echo '⭐'; ?>
            </div>
            <div class="bbt-rd-count">
                <?php echo number_format($s['reviews']); ?> reviews
            </div>
        </div>
        <style>
            .bbt-rating-display.style-inline {
                display: flex;
                align-items: center;
                gap: 12px
            }

            .bbt-rating-display.style-card {
                background: #fff;
                padding: 25px;
                border-radius: 16px;
                text-align: center;
                box-shadow: 0 8px 30px rgba(0, 0, 0, .08)
            }

            .bbt-rating-display.style-large {
                text-align: center;
                padding: 40px
            }

            .bbt-rd-score {
                font-size: 48px;
                font-weight: 800;
                color: #F5A623
            }

            .style-inline .bbt-rd-score {
                font-size: 24px
            }

            .bbt-rd-stars {
                font-size: 20px;
                margin: 10px 0
            }

            .style-inline .bbt-rd-stars {
                margin: 0
            }

            .bbt-rd-count {
                font-size: 14px;
                color: #666
            }
        </style>
        <?php
    }
}
