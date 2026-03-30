<?php
if (!defined('ABSPATH'))
    exit;

class BBT_Widget_Divider extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'bbt-divider';
    }
    public function get_title()
    {
        return esc_html__('Divider', 'bestbalitravel');
    }
    public function get_icon()
    {
        return 'eicon-divider';
    }
    public function get_categories()
    {
        return ['bbt-widgets'];
    }

    protected function register_controls()
    {
        $this->start_controls_section('section_style', ['label' => 'Style']);
        $this->add_control('style', ['label' => 'Style', 'type' => \Elementor\Controls_Manager::SELECT, 'options' => ['solid' => 'Solid', 'dashed' => 'Dashed', 'dots' => 'Dots', 'wave' => 'Wave', 'gradient' => 'Gradient'], 'default' => 'solid']);
        $this->add_control('width', ['label' => 'Width', 'type' => \Elementor\Controls_Manager::SLIDER, 'range' => ['%' => ['min' => 10, 'max' => 100]], 'default' => ['size' => 100, 'unit' => '%']]);
        $this->add_control('color', ['label' => 'Color', 'type' => \Elementor\Controls_Manager::COLOR, 'default' => '#F5A623']);
        $this->add_control('icon', ['label' => 'Center Icon', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '']);
        $this->end_controls_section();
    }

    protected function render()
    {
        $s = $this->get_settings_for_display();
        ?>
        <div class="bbt-divider style-<?php echo esc_attr($s['style']); ?>"
            style="--color:<?php echo esc_attr($s['color']); ?>;--width:<?php echo esc_attr($s['width']['size'] . $s['width']['unit']); ?>">
            <?php if ($s['icon']): ?><span class="bbt-divider-icon">
                    <?php echo $s['icon']; ?>
                </span>
            <?php endif; ?>
        </div>
        <style>
            .bbt-divider {
                display: flex;
                align-items: center;
                justify-content: center;
                width: var(--width);
                margin: 30px auto
            }

            .bbt-divider::before,
            .bbt-divider::after {
                content: '';
                flex: 1;
                height: 2px
            }

            .style-solid::before,
            .style-solid::after {
                background: var(--color)
            }

            .style-dashed::before,
            .style-dashed::after {
                border-top: 2px dashed var(--color)
            }

            .style-dots::before,
            .style-dots::after {
                border-top: 3px dotted var(--color)
            }

            .style-gradient::before,
            .style-gradient::after {
                background: linear-gradient(90deg, transparent, var(--color), transparent)
            }

            .style-wave::before,
            .style-wave::after {
                height: 10px;
                background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1200 40'%3E%3Cpath fill='%23F5A623' d='M0 20c100-20 200 20 300 0s200-20 300 0 200-20 300 0 200 20 300 0V40H0z'/%3E%3C/svg%3E") repeat-x center;
                background-size: 100px
            }

            .bbt-divider-icon {
                padding: 0 20px;
                font-size: 24px
            }
        </style>
        <?php
    }
}
