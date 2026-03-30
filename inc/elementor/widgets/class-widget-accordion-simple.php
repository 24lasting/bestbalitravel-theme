<?php
if (!defined('ABSPATH'))
    exit;

class BBT_Widget_Accordion_Simple extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'bbt-accordion-simple';
    }
    public function get_title()
    {
        return esc_html__('Simple Accordion', 'bestbalitravel');
    }
    public function get_icon()
    {
        return 'eicon-toggle';
    }
    public function get_categories()
    {
        return ['bbt-widgets'];
    }

    protected function register_controls()
    {
        $this->start_controls_section('section_items', ['label' => 'Items']);
        $repeater = new \Elementor\Repeater();
        $repeater->add_control('title', ['label' => 'Title', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Accordion Title']);
        $repeater->add_control('content', ['label' => 'Content', 'type' => \Elementor\Controls_Manager::WYSIWYG]);
        $this->add_control('items', [
            'type' => \Elementor\Controls_Manager::REPEATER,
            'fields' => $repeater->get_controls(),
            'default' => [
                ['title' => 'What is included?', 'content' => 'All tours include transportation, guide, lunch, and entrance fees.'],
                ['title' => 'How to book?', 'content' => 'Simply select your date, add to cart, and complete checkout.'],
            ]
        ]);
        $this->end_controls_section();
    }

    protected function render()
    {
        $items = $this->get_settings_for_display()['items'];
        ?>
        <div class="bbt-accordion-simple">
            <?php foreach ($items as $i => $item): ?>
                <div class="bbt-acc-item <?php echo $i === 0 ? 'active' : ''; ?>">
                    <button class="bbt-acc-header">
                        <?php echo esc_html($item['title']); ?><span class="bbt-acc-icon">+</span>
                    </button>
                    <div class="bbt-acc-body">
                        <?php echo $item['content']; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <style>
            .bbt-accordion-simple {
                border-radius: 16px;
                overflow: hidden;
                border: 1px solid #eee
            }

            .bbt-acc-item {
                border-bottom: 1px solid #eee
            }

            .bbt-acc-item:last-child {
                border-bottom: none
            }

            .bbt-acc-header {
                width: 100%;
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 20px 25px;
                background: #fff;
                border: none;
                font-size: 16px;
                font-weight: 600;
                text-align: left;
                cursor: pointer;
                transition: background .2s ease
            }

            .bbt-acc-header:hover {
                background: #f9f9f9
            }

            .bbt-acc-icon {
                font-size: 24px;
                color: #F5A623;
                transition: transform .3s ease
            }

            .bbt-acc-item.active .bbt-acc-icon {
                transform: rotate(45deg)
            }

            .bbt-acc-body {
                max-height: 0;
                overflow: hidden;
                transition: max-height .3s ease
            }

            .bbt-acc-item.active .bbt-acc-body {
                max-height: 500px
            }

            .bbt-acc-body>* {
                padding: 0 25px 20px;
                color: #666
            }
        </style>
        <script>document.querySelectorAll('.bbt-acc-header').forEach(function (h) { h.addEventListener('click', function () { this.parentElement.classList.toggle('active') }) });</script>
        <?php
    }
}
