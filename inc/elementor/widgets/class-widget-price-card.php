<?php
if (!defined('ABSPATH'))
    exit;

class BBT_Widget_Price_Card extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'bbt-price-card';
    }
    public function get_title()
    {
        return esc_html__('Price Card', 'bestbalitravel');
    }
    public function get_icon()
    {
        return 'eicon-price-table';
    }
    public function get_categories()
    {
        return ['bbt-widgets'];
    }

    protected function register_controls()
    {
        $this->start_controls_section('section_content', ['label' => 'Content']);
        $this->add_control('title', ['label' => 'Title', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Premium Package']);
        $this->add_control('price', ['label' => 'Price', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Rp 750,000']);
        $this->add_control('period', ['label' => 'Period', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'per person']);
        $this->add_control('features', ['label' => 'Features (one per line)', 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => "Private car\nEnglish guide\nLunch included\nHotel pickup\nAll entrance fees"]);
        $this->add_control('featured', ['label' => 'Featured', 'type' => \Elementor\Controls_Manager::SWITCHER]);
        $this->add_control('btn_text', ['label' => 'Button', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Book Now']);
        $this->add_control('btn_link', ['label' => 'Button Link', 'type' => \Elementor\Controls_Manager::URL]);
        $this->end_controls_section();
    }

    protected function render()
    {
        $s = $this->get_settings_for_display();
        $features = array_filter(explode("\n", $s['features']));
        $featured = $s['featured'] === 'yes';
        ?>
        <div class="bbt-price-card <?php echo $featured ? 'featured' : ''; ?>">
            <?php if ($featured): ?><span class="bbt-pc-badge">⭐ Most Popular</span>
            <?php endif; ?>
            <h3>
                <?php echo esc_html($s['title']); ?>
            </h3>
            <div class="bbt-pc-price">
                <?php echo esc_html($s['price']); ?><span>
                    <?php echo esc_html($s['period']); ?>
                </span>
            </div>
            <ul class="bbt-pc-features">
                <?php foreach ($features as $f): ?>
                    <li>✓
                        <?php echo esc_html(trim($f)); ?>
                    </li>
                <?php endforeach; ?>
            </ul>
            <a href="<?php echo esc_url($s['btn_link']['url'] ?? '#'); ?>" class="bbt-pc-btn">
                <?php echo esc_html($s['btn_text']); ?>
            </a>
        </div>
        <style>
            .bbt-price-card {
                position: relative;
                background: #fff;
                padding: 40px 30px;
                border-radius: 24px;
                text-align: center;
                box-shadow: 0 10px 40px rgba(0, 0, 0, .08);
                transition: all .4s ease
            }

            .bbt-price-card:hover {
                transform: translateY(-10px);
                box-shadow: 0 20px 60px rgba(0, 0, 0, .15)
            }

            .bbt-price-card.featured {
                border: 3px solid #F5A623;
                transform: scale(1.05)
            }

            .bbt-pc-badge {
                position: absolute;
                top: -12px;
                left: 50%;
                transform: translateX(-50%);
                background: linear-gradient(135deg, #F5A623, #FFD93D);
                padding: 8px 20px;
                border-radius: 25px;
                font-size: 12px;
                font-weight: 700;
                white-space: nowrap
            }

            .bbt-price-card h3 {
                margin: 0 0 15px;
                font-size: 24px;
                color: #333
            }

            .bbt-pc-price {
                font-size: 42px;
                font-weight: 800;
                color: #F5A623;
                margin-bottom: 5px
            }

            .bbt-pc-price span {
                display: block;
                font-size: 14px;
                font-weight: 400;
                color: #666
            }

            .bbt-pc-features {
                list-style: none;
                padding: 0;
                margin: 25px 0;
                text-align: left
            }

            .bbt-pc-features li {
                padding: 12px 0;
                border-bottom: 1px solid #eee;
                font-size: 14px;
                color: #555
            }

            .bbt-pc-btn {
                display: block;
                padding: 16px;
                background: #1a1a1a;
                color: #fff;
                text-decoration: none;
                border-radius: 12px;
                font-weight: 600;
                transition: all .3s ease
            }

            .bbt-pc-btn:hover {
                background: #F5A623;
                color: #000
            }

            .featured .bbt-pc-btn {
                background: #F5A623;
                color: #000
            }
        </style>
        <?php
    }
}
