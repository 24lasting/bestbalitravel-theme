<?php
if (!defined('ABSPATH'))
    exit;

class BBT_Widget_Alert_Box extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'bbt-alert-box';
    }
    public function get_title()
    {
        return esc_html__('Alert Box', 'bestbalitravel');
    }
    public function get_icon()
    {
        return 'eicon-alert';
    }
    public function get_categories()
    {
        return ['bbt-widgets'];
    }

    protected function register_controls()
    {
        $this->start_controls_section('section_content', ['label' => 'Content']);
        $this->add_control('type', ['label' => 'Type', 'type' => \Elementor\Controls_Manager::SELECT, 'options' => ['info' => 'Info', 'success' => 'Success', 'warning' => 'Warning', 'danger' => 'Danger'], 'default' => 'info']);
        $this->add_control('title', ['label' => 'Title', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Important Notice']);
        $this->add_control('content', ['label' => 'Content', 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'This is an important message.']);
        $this->add_control('dismissible', ['label' => 'Dismissible', 'type' => \Elementor\Controls_Manager::SWITCHER]);
        $this->end_controls_section();
    }

    protected function render()
    {
        $s = $this->get_settings_for_display();
        $icons = ['info' => 'ℹ️', 'success' => '✅', 'warning' => '⚠️', 'danger' => '🚫'];
        ?>
        <div class="bbt-alert-box type-<?php echo esc_attr($s['type']); ?>">
            <span class="bbt-alert-icon">
                <?php echo $icons[$s['type']]; ?>
            </span>
            <div class="bbt-alert-content">
                <?php if ($s['title']): ?><strong>
                        <?php echo esc_html($s['title']); ?>
                    </strong>
                <?php endif; ?>
                <p>
                    <?php echo esc_html($s['content']); ?>
                </p>
            </div>
            <?php if ($s['dismissible'] === 'yes'): ?><button class="bbt-alert-close"
                    onclick="this.parentElement.remove()">&times;</button>
            <?php endif; ?>
        </div>
        <style>
            .bbt-alert-box {
                display: flex;
                align-items: flex-start;
                gap: 15px;
                padding: 20px;
                border-radius: 12px;
                margin-bottom: 15px
            }

            .type-info {
                background: #E8F4FD;
                border-left: 4px solid #2196F3
            }

            .type-success {
                background: #E8F8E8;
                border-left: 4px solid #4CAF50
            }

            .type-warning {
                background: #FFF8E1;
                border-left: 4px solid #FF9800
            }

            .type-danger {
                background: #FFEBEE;
                border-left: 4px solid #F44336
            }

            .bbt-alert-icon {
                font-size: 24px
            }

            .bbt-alert-content {
                flex: 1
            }

            .bbt-alert-content strong {
                display: block;
                margin-bottom: 5px
            }

            .bbt-alert-content p {
                margin: 0;
                font-size: 14px
            }

            .bbt-alert-close {
                background: none;
                border: none;
                font-size: 24px;
                cursor: pointer;
                opacity: .5
            }

            .bbt-alert-close:hover {
                opacity: 1
            }
        </style>
        <?php
    }
}
