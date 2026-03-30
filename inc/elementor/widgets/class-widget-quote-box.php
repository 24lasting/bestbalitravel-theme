<?php
if (!defined('ABSPATH'))
    exit;

class BBT_Widget_Quote_Box extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'bbt-quote-box';
    }
    public function get_title()
    {
        return esc_html__('Quote Box', 'bestbalitravel');
    }
    public function get_icon()
    {
        return 'eicon-blockquote';
    }
    public function get_categories()
    {
        return ['bbt-widgets'];
    }

    protected function register_controls()
    {
        $this->start_controls_section('section_content', ['label' => 'Content']);
        $this->add_control('quote', ['label' => 'Quote', 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'Travel is the only thing you buy that makes you richer.']);
        $this->add_control('author', ['label' => 'Author', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Anonymous']);
        $this->add_control('style', ['label' => 'Style', 'type' => \Elementor\Controls_Manager::SELECT, 'options' => ['simple' => 'Simple', 'bordered' => 'Bordered', 'filled' => 'Filled'], 'default' => 'bordered']);
        $this->end_controls_section();
    }

    protected function render()
    {
        $s = $this->get_settings_for_display();
        ?>
        <blockquote class="bbt-quote-box style-<?php echo esc_attr($s['style']); ?>">
            <span class="bbt-qb-mark">❝</span>
            <p>
                <?php echo esc_html($s['quote']); ?>
            </p>
            <cite>—
                <?php echo esc_html($s['author']); ?>
            </cite>
        </blockquote>
        <style>
            .bbt-quote-box {
                position: relative;
                padding: 35px 40px;
                margin: 0;
                font-style: italic
            }

            .style-simple {
                background: transparent
            }

            .style-bordered {
                border-left: 5px solid #F5A623;
                background: #f9f9f9;
                border-radius: 0 16px 16px 0
            }

            .style-filled {
                background: linear-gradient(135deg, #F5A623, #FFD93D);
                border-radius: 16px;
                color: #000
            }

            .bbt-qb-mark {
                position: absolute;
                top: 15px;
                left: 30px;
                font-size: 48px;
                opacity: .2;
                line-height: 1
            }

            .bbt-quote-box p {
                font-size: 20px;
                line-height: 1.6;
                margin: 0 0 15px;
                position: relative
            }

            .bbt-quote-box cite {
                font-size: 14px;
                font-style: normal;
                font-weight: 600;
                opacity: .8
            }
        </style>
        <?php
    }
}
