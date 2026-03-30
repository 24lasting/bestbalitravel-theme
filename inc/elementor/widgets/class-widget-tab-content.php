<?php
if (!defined('ABSPATH'))
    exit;

class BBT_Widget_Tab_Content extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'bbt-tab-content';
    }
    public function get_title()
    {
        return esc_html__('Tab Content', 'bestbalitravel');
    }
    public function get_icon()
    {
        return 'eicon-tabs';
    }
    public function get_categories()
    {
        return ['bbt-widgets'];
    }

    protected function register_controls()
    {
        $this->start_controls_section('section_tabs', ['label' => 'Tabs']);
        $repeater = new \Elementor\Repeater();
        $repeater->add_control('title', ['label' => 'Title', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Tab']);
        $repeater->add_control('icon', ['label' => 'Icon', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '📌']);
        $repeater->add_control('content', ['label' => 'Content', 'type' => \Elementor\Controls_Manager::WYSIWYG]);
        $this->add_control('tabs', [
            'type' => \Elementor\Controls_Manager::REPEATER,
            'fields' => $repeater->get_controls(),
            'default' => [
                ['title' => 'Overview', 'icon' => '📍', 'content' => 'Overview content goes here.'],
                ['title' => 'Details', 'icon' => '📋', 'content' => 'Details content goes here.'],
                ['title' => 'Reviews', 'icon' => '⭐', 'content' => 'Reviews content goes here.'],
            ]
        ]);
        $this->end_controls_section();
    }

    protected function render()
    {
        $tabs = $this->get_settings_for_display()['tabs'];
        $id = 'tc-' . uniqid();
        ?>
        <div class="bbt-tab-content" id="<?php echo $id; ?>">
            <div class="bbt-tc-nav">
                <?php foreach ($tabs as $i => $tab): ?>
                    <button class="bbt-tc-btn <?php echo $i === 0 ? 'active' : ''; ?>" data-tab="<?php echo $i; ?>">
                        <?php echo $tab['icon']; ?>
                        <?php echo esc_html($tab['title']); ?>
                    </button>
                <?php endforeach; ?>
            </div>
            <div class="bbt-tc-panels">
                <?php foreach ($tabs as $i => $tab): ?>
                    <div class="bbt-tc-panel <?php echo $i === 0 ? 'active' : ''; ?>" data-panel="<?php echo $i; ?>">
                        <?php echo $tab['content']; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <style>
            .bbt-tab-content {
                background: #fff;
                border-radius: 20px;
                overflow: hidden;
                box-shadow: 0 8px 30px rgba(0, 0, 0, .08)
            }

            .bbt-tc-nav {
                display: flex;
                border-bottom: 2px solid #eee
            }

            .bbt-tc-btn {
                flex: 1;
                padding: 18px;
                background: none;
                border: none;
                font-size: 15px;
                font-weight: 600;
                cursor: pointer;
                transition: all .3s ease;
                border-bottom: 3px solid transparent;
                margin-bottom: -2px
            }

            .bbt-tc-btn.active {
                color: #F5A623;
                border-bottom-color: #F5A623
            }

            .bbt-tc-panel {
                display: none;
                padding: 30px;
                animation: bbtTcFade .4s ease
            }

            .bbt-tc-panel.active {
                display: block
            }

            @keyframes bbtTcFade {
                from {
                    opacity: 0
                }

                to {
                    opacity: 1
                }
            }
        </style>
        <script>
            document.querySelectorAll('#<?php echo $id; ?> .bbt-tc-btn').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    var parent = this.closest('.bbt-tab-content'), idx = this.dataset.tab;
                    parent.querySelectorAll('.bbt-tc-btn,.bbt-tc-panel').forEach(function (el) { el.classList.remove('active') });
                    this.classList.add('active');
                    parent.querySelector('[data-panel="' + idx + '"]').classList.add('active');
                });
            });
        </script>
        <?php
    }
}
