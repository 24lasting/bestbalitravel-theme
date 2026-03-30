<?php
if (!defined('ABSPATH'))
    exit;

class BBT_Widget_Activity_Details extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'bbt-activity-details';
    }
    public function get_title()
    {
        return esc_html__('Activity Details', 'bestbalitravel');
    }
    public function get_icon()
    {
        return 'eicon-document-file';
    }
    public function get_categories()
    {
        return ['bbt-widgets'];
    }

    protected function register_controls()
    {
        $this->start_controls_section('section_content', ['label' => 'Content']);
        $this->add_control('content', ['label' => 'Description', 'type' => \Elementor\Controls_Manager::WYSIWYG, 'default' => '<p>Experience the thrill of adventure with our expertly guided tour...</p>']);
        $this->end_controls_section();
    }

    protected function render()
    {
        $s = $this->get_settings_for_display();
        ?>
        <div class="bbt-activity-details">
            <h3>📖 About This Activity</h3>
            <div class="bbt-ad-content">
                <?php echo $s['content']; ?>
            </div>
        </div>
        <style>
            .bbt-activity-details {
                background: #fff;
                padding: 30px;
                border-radius: 20px;
                box-shadow: 0 8px 30px rgba(0, 0, 0, .08)
            }

            .bbt-activity-details h3 {
                margin: 0 0 20px;
                font-size: 20px
            }

            .bbt-ad-content {
                color: #555;
                line-height: 1.8;
                font-size: 15px
            }

            .bbt-ad-content p {
                margin: 0 0 15px
            }

            .bbt-ad-content ul {
                padding-left: 25px;
                margin: 15px 0
            }

            .bbt-ad-content li {
                margin-bottom: 8px
            }
        </style>
        <?php
    }
}
