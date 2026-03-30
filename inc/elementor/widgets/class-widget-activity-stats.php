<?php
if (!defined('ABSPATH'))
    exit;

class BBT_Widget_Activity_Stats extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'bbt-activity-stats';
    }
    public function get_title()
    {
        return esc_html__('Activity Stats', 'bestbalitravel');
    }
    public function get_icon()
    {
        return 'eicon-number-field';
    }
    public function get_categories()
    {
        return ['bbt-widgets'];
    }

    protected function register_controls()
    {
        $this->start_controls_section('section_stats', ['label' => 'Stats']);
        $this->add_control('duration', ['label' => 'Duration', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '8 Hours']);
        $this->add_control('group_size', ['label' => 'Group Size', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Max 15']);
        $this->add_control('language', ['label' => 'Language', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'English']);
        $this->add_control('difficulty', ['label' => 'Difficulty', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Moderate']);
        $this->end_controls_section();
    }

    protected function render()
    {
        $s = $this->get_settings_for_display();
        ?>
        <div class="bbt-activity-stats">
            <div class="bbt-as-item"><span class="bbt-as-icon">⏱️</span>
                <div><span class="bbt-as-label">Duration</span><span class="bbt-as-value">
                        <?php echo esc_html($s['duration']); ?>
                    </span></div>
            </div>
            <div class="bbt-as-item"><span class="bbt-as-icon">👥</span>
                <div><span class="bbt-as-label">Group Size</span><span class="bbt-as-value">
                        <?php echo esc_html($s['group_size']); ?>
                    </span></div>
            </div>
            <div class="bbt-as-item"><span class="bbt-as-icon">🗣️</span>
                <div><span class="bbt-as-label">Language</span><span class="bbt-as-value">
                        <?php echo esc_html($s['language']); ?>
                    </span></div>
            </div>
            <div class="bbt-as-item"><span class="bbt-as-icon">📊</span>
                <div><span class="bbt-as-label">Difficulty</span><span class="bbt-as-value">
                        <?php echo esc_html($s['difficulty']); ?>
                    </span></div>
            </div>
        </div>
        <style>
            .bbt-activity-stats {
                display: grid;
                grid-template-columns: repeat(4, 1fr);
                gap: 20px
            }

            .bbt-as-item {
                display: flex;
                align-items: center;
                gap: 15px;
                background: #fff;
                padding: 20px;
                border-radius: 16px;
                box-shadow: 0 4px 15px rgba(0, 0, 0, .06)
            }

            .bbt-as-icon {
                font-size: 28px
            }

            .bbt-as-label {
                display: block;
                font-size: 12px;
                color: #666;
                text-transform: uppercase
            }

            .bbt-as-value {
                font-size: 16px;
                font-weight: 700
            }

            @media(max-width:768px) {
                .bbt-activity-stats {
                    grid-template-columns: repeat(2, 1fr)
                }
            }
        </style>
        <?php
    }
}
