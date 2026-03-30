<?php
if (!defined('ABSPATH'))
    exit;

class BBT_Widget_Important_Info extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'bbt-important-info';
    }
    public function get_title()
    {
        return esc_html__('Important Info', 'bestbalitravel');
    }
    public function get_icon()
    {
        return 'eicon-info-circle-o';
    }
    public function get_categories()
    {
        return ['bbt-widgets'];
    }

    protected function register_controls()
    {
        $this->start_controls_section('section_info', ['label' => 'Information']);
        $repeater = new \Elementor\Repeater();
        $repeater->add_control('icon', ['label' => 'Icon', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '📌']);
        $repeater->add_control('title', ['label' => 'Title', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Info']);
        $repeater->add_control('content', ['label' => 'Content', 'type' => \Elementor\Controls_Manager::TEXTAREA]);
        $this->add_control('items', [
            'type' => \Elementor\Controls_Manager::REPEATER,
            'fields' => $repeater->get_controls(),
            'default' => [
                ['icon' => '👕', 'title' => 'What to Wear', 'content' => 'Comfortable clothing and closed-toe shoes recommended'],
                ['icon' => '🎒', 'title' => 'What to Bring', 'content' => 'Sunscreen, camera, light jacket, comfortable shoes'],
                ['icon' => '⚠️', 'title' => 'Health', 'content' => 'Not recommended for pregnant women or people with heart conditions'],
            ]
        ]);
        $this->end_controls_section();
    }

    protected function render()
    {
        $items = $this->get_settings_for_display()['items'];
        ?>
        <div class="bbt-important-info">
            <h3>ℹ️ Important Information</h3>
            <div class="bbt-ii-grid">
                <?php foreach ($items as $item): ?>
                    <div class="bbt-ii-item">
                        <span class="bbt-ii-icon">
                            <?php echo $item['icon']; ?>
                        </span>
                        <h4>
                            <?php echo esc_html($item['title']); ?>
                        </h4>
                        <p>
                            <?php echo esc_html($item['content']); ?>
                        </p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <style>
            .bbt-important-info h3 {
                margin: 0 0 20px;
                font-size: 20px
            }

            .bbt-ii-grid {
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                gap: 20px
            }

            .bbt-ii-item {
                background: #FFF8E8;
                padding: 25px;
                border-radius: 16px;
                border-left: 4px solid #F5A623
            }

            .bbt-ii-icon {
                font-size: 32px;
                display: block;
                margin-bottom: 12px
            }

            .bbt-ii-item h4 {
                margin: 0 0 8px;
                font-size: 15px
            }

            .bbt-ii-item p {
                margin: 0;
                font-size: 13px;
                color: #666
            }

            @media(max-width:768px) {
                .bbt-ii-grid {
                    grid-template-columns: 1fr
                }
            }
        </style>
        <?php
    }
}
