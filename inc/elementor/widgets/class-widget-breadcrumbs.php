<?php
if (!defined('ABSPATH'))
    exit;

class BBT_Widget_Breadcrumbs extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'bbt-breadcrumbs';
    }
    public function get_title()
    {
        return esc_html__('Breadcrumbs', 'bestbalitravel');
    }
    public function get_icon()
    {
        return 'eicon-navigation-horizontal';
    }
    public function get_categories()
    {
        return ['bbt-widgets'];
    }

    protected function register_controls()
    {
        $this->start_controls_section('section_style', ['label' => 'Style']);
        $this->add_control('separator', ['label' => 'Separator', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '›']);
        $this->add_control('home_text', ['label' => 'Home Text', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Home']);
        $this->end_controls_section();
    }

    protected function render()
    {
        $s = $this->get_settings_for_display();
        ?>
        <nav class="bbt-breadcrumbs">
            <a href="<?php echo esc_url(home_url('/')); ?>">
                <?php echo esc_html($s['home_text']); ?>
            </a>
            <span class="bbt-bc-sep">
                <?php echo esc_html($s['separator']); ?>
            </span>
            <?php if (is_singular()): ?>
                <span class="bbt-bc-current">
                    <?php the_title(); ?>
                </span>
            <?php elseif (is_archive()): ?>
                <span class="bbt-bc-current">
                    <?php the_archive_title(); ?>
                </span>
            <?php endif; ?>
        </nav>
        <style>
            .bbt-breadcrumbs {
                display: flex;
                align-items: center;
                gap: 10px;
                font-size: 14px
            }

            .bbt-breadcrumbs a {
                color: #666;
                text-decoration: none;
                transition: color .2s ease
            }

            .bbt-breadcrumbs a:hover {
                color: #F5A623
            }

            .bbt-bc-sep {
                color: #ccc
            }

            .bbt-bc-current {
                color: #1a1a1a;
                font-weight: 600
            }
        </style>
        <?php
    }
}
