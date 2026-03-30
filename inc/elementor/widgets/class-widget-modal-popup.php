<?php
if (!defined('ABSPATH'))
    exit;

class BBT_Widget_Modal_Popup extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'bbt-modal-popup';
    }
    public function get_title()
    {
        return esc_html__('Modal Popup', 'bestbalitravel');
    }
    public function get_icon()
    {
        return 'eicon-site-identity';
    }
    public function get_categories()
    {
        return ['bbt-widgets'];
    }

    protected function register_controls()
    {
        $this->start_controls_section('section_content', ['label' => 'Content']);
        $this->add_control('btn_text', ['label' => 'Button Text', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Open Popup']);
        $this->add_control('title', ['label' => 'Modal Title', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Special Offer']);
        $this->add_control('content', ['label' => 'Content', 'type' => \Elementor\Controls_Manager::WYSIWYG]);
        $this->end_controls_section();
    }

    protected function render()
    {
        $s = $this->get_settings_for_display();
        $id = 'modal-' . uniqid();
        ?>
        <button class="bbt-modal-trigger" data-modal="<?php echo $id; ?>">
            <?php echo esc_html($s['btn_text']); ?>
        </button>
        <div class="bbt-modal" id="<?php echo $id; ?>">
            <div class="bbt-modal-backdrop"></div>
            <div class="bbt-modal-content">
                <button class="bbt-modal-close">&times;</button>
                <h2>
                    <?php echo esc_html($s['title']); ?>
                </h2>
                <div class="bbt-modal-body">
                    <?php echo $s['content']; ?>
                </div>
            </div>
        </div>
        <style>
            .bbt-modal-trigger {
                padding: 16px 32px;
                background: linear-gradient(135deg, #F5A623, #FFD93D);
                border: none;
                border-radius: 30px;
                font-size: 16px;
                font-weight: 600;
                cursor: pointer;
                transition: all .3s ease
            }

            .bbt-modal-trigger:hover {
                transform: translateY(-2px);
                box-shadow: 0 10px 30px rgba(245, 166, 35, .3)
            }

            .bbt-modal {
                position: fixed;
                inset: 0;
                z-index: 9999;
                display: none;
                align-items: center;
                justify-content: center
            }

            .bbt-modal.active {
                display: flex
            }

            .bbt-modal-backdrop {
                position: absolute;
                inset: 0;
                background: rgba(0, 0, 0, .8);
                animation: bbtModalFade .3s ease
            }

            @keyframes bbtModalFade {
                from {
                    opacity: 0
                }

                to {
                    opacity: 1
                }
            }

            .bbt-modal-content {
                position: relative;
                background: #fff;
                padding: 40px;
                border-radius: 24px;
                max-width: 500px;
                width: 90%;
                max-height: 80vh;
                overflow-y: auto;
                animation: bbtModalScale .3s ease
            }

            @keyframes bbtModalScale {
                from {
                    opacity: 0;
                    transform: scale(.9)
                }

                to {
                    opacity: 1;
                    transform: scale(1)
                }
            }

            .bbt-modal-close {
                position: absolute;
                top: 15px;
                right: 15px;
                width: 40px;
                height: 40px;
                background: #f5f5f5;
                border: none;
                border-radius: 50%;
                font-size: 24px;
                cursor: pointer
            }

            .bbt-modal-content h2 {
                margin: 0 0 20px
            }
        </style>
        <script>
            document.querySelectorAll('.bbt-modal-trigger').forEach(function (btn) { btn.addEventListener('click', function () { document.getElementById(this.dataset.modal).classList.add('active') }) });
            document.querySelectorAll('.bbt-modal-close,.bbt-modal-backdrop').forEach(function (el) { el.addEventListener('click', function () { this.closest('.bbt-modal').classList.remove('active') }) });
        </script>
        <?php
    }
}
