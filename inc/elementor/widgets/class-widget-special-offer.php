<?php
if (!defined('ABSPATH'))
    exit;

class BBT_Widget_Special_Offer extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'bbt-special-offer';
    }
    public function get_title()
    {
        return esc_html__('Special Offer', 'bestbalitravel');
    }
    public function get_icon()
    {
        return 'eicon-price-list';
    }
    public function get_categories()
    {
        return ['bbt-widgets'];
    }

    protected function register_controls()
    {
        $this->start_controls_section('section_content', ['label' => 'Content']);
        $this->add_control('badge', ['label' => 'Badge', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '🔥 Limited Time']);
        $this->add_control('discount', ['label' => 'Discount %', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '25%']);
        $this->add_control('title', ['label' => 'Title', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Flash Sale']);
        $this->add_control('description', ['label' => 'Description', 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'Book any tour today and save big!']);
        $this->add_control('code', ['label' => 'Promo Code', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'BALI25']);
        $this->add_control('expiry', ['label' => 'Expires', 'type' => \Elementor\Controls_Manager::DATE_TIME]);
        $this->add_control('image', ['label' => 'Background', 'type' => \Elementor\Controls_Manager::MEDIA]);
        $this->end_controls_section();
    }

    protected function render()
    {
        $s = $this->get_settings_for_display();
        $bg = !empty($s['image']['url']) ? $s['image']['url'] : 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=1200';
        ?>
        <div class="bbt-special-offer" style="background-image:url('<?php echo esc_url($bg); ?>')">
            <div class="bbt-so-overlay"></div>
            <div class="bbt-so-content">
                <span class="bbt-so-badge">
                    <?php echo esc_html($s['badge']); ?>
                </span>
                <div class="bbt-so-discount">
                    <?php echo esc_html($s['discount']); ?> OFF
                </div>
                <h2>
                    <?php echo esc_html($s['title']); ?>
                </h2>
                <p>
                    <?php echo esc_html($s['description']); ?>
                </p>
                <div class="bbt-so-code">
                    <span>Use code:</span>
                    <strong>
                        <?php echo esc_html($s['code']); ?>
                    </strong>
                    <button onclick="navigator.clipboard.writeText('<?php echo esc_attr($s['code']); ?>')">📋</button>
                </div>
            </div>
        </div>
        <style>
            .bbt-special-offer {
                position: relative;
                padding: 60px;
                border-radius: 24px;
                overflow: hidden;
                background-size: cover;
                background-position: center
            }

            .bbt-so-overlay {
                position: absolute;
                inset: 0;
                background: linear-gradient(135deg, rgba(245, 166, 35, .9), rgba(255, 107, 107, .8))
            }

            .bbt-so-content {
                position: relative;
                z-index: 2;
                text-align: center;
                color: #fff;
                max-width: 500px;
                margin: 0 auto
            }

            .bbt-so-badge {
                display: inline-block;
                background: rgba(255, 255, 255, .2);
                padding: 8px 20px;
                border-radius: 25px;
                font-size: 14px;
                margin-bottom: 20px
            }

            .bbt-so-discount {
                font-size: 64px;
                font-weight: 900;
                margin-bottom: 10px;
                text-shadow: 0 4px 20px rgba(0, 0, 0, .2)
            }

            .bbt-so-content h2 {
                margin: 0 0 10px;
                font-size: 32px
            }

            .bbt-so-content p {
                margin: 0 0 25px;
                font-size: 16px;
                opacity: .95
            }

            .bbt-so-code {
                display: inline-flex;
                align-items: center;
                gap: 12px;
                background: rgba(0, 0, 0, .2);
                padding: 12px 25px;
                border-radius: 12px
            }

            .bbt-so-code strong {
                font-size: 20px;
                letter-spacing: 2px
            }

            .bbt-so-code button {
                background: none;
                border: none;
                color: #fff;
                cursor: pointer;
                font-size: 18px
            }
        </style>
        <?php
    }
}
