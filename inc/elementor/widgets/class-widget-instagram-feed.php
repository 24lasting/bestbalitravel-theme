<?php
if (!defined('ABSPATH'))
    exit;

class BBT_Widget_Instagram_Feed extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'bbt-instagram-feed';
    }
    public function get_title()
    {
        return esc_html__('Instagram Feed', 'bestbalitravel');
    }
    public function get_icon()
    {
        return 'eicon-instagram-gallery';
    }
    public function get_categories()
    {
        return ['bbt-widgets'];
    }

    protected function register_controls()
    {
        $this->start_controls_section('section_content', ['label' => 'Settings']);
        $this->add_control('username', ['label' => 'Username', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '@bestbalitravel']);
        $this->add_control('columns', ['label' => 'Columns', 'type' => \Elementor\Controls_Manager::SELECT, 'options' => ['4' => '4', '5' => '5', '6' => '6'], 'default' => '5']);
        $this->end_controls_section();
    }

    protected function render()
    {
        $s = $this->get_settings_for_display();
        $images = [
            'https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=400',
            'https://images.unsplash.com/photo-1555400038-63f5ba517a47?w=400',
            'https://images.unsplash.com/photo-1552733407-5d5c46c3bb3b?w=400',
            'https://images.unsplash.com/photo-1544644181-1484b3fdfc62?w=400',
            'https://images.unsplash.com/photo-1518548419970-58e3b4079ab2?w=400',
        ];
        ?>
        <div class="bbt-instagram-feed">
            <div class="bbt-ig-header">
                <span class="bbt-ig-icon">📸</span>
                <div class="bbt-ig-info">
                    <h3>Follow Us</h3><span>
                        <?php echo esc_html($s['username']); ?>
                    </span>
                </div>
                <a href="https://instagram.com" target="_blank" class="bbt-ig-btn">Follow</a>
            </div>
            <div class="bbt-ig-grid" style="--cols:<?php echo esc_attr($s['columns']); ?>">
                <?php foreach ($images as $i => $img): ?>
                    <a href="#" class="bbt-ig-item" style="--d:<?php echo $i * 0.1; ?>s">
                        <img src="<?php echo esc_url($img); ?>" alt="">
                        <div class="bbt-ig-overlay"><span>❤️ 1.2K</span></div>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
        <style>
            .bbt-instagram-feed {
                padding: 30px;
                background: #fff;
                border-radius: 24px;
                box-shadow: 0 10px 40px rgba(0, 0, 0, .08)
            }

            .bbt-ig-header {
                display: flex;
                align-items: center;
                gap: 15px;
                margin-bottom: 25px
            }

            .bbt-ig-icon {
                font-size: 40px
            }

            .bbt-ig-info {
                flex: 1
            }

            .bbt-ig-info h3 {
                margin: 0;
                font-size: 18px
            }

            .bbt-ig-info span {
                color: #666;
                font-size: 14px
            }

            .bbt-ig-btn {
                padding: 10px 25px;
                background: linear-gradient(45deg, #f09433, #e6683c, #dc2743, #cc2366, #bc1888);
                color: #fff;
                text-decoration: none;
                border-radius: 25px;
                font-weight: 600
            }

            .bbt-ig-grid {
                display: grid;
                grid-template-columns: repeat(var(--cols), 1fr);
                gap: 10px
            }

            .bbt-ig-item {
                position: relative;
                border-radius: 12px;
                overflow: hidden;
                aspect-ratio: 1;
                opacity: 0;
                animation: bbtIgFade .4s ease forwards;
                animation-delay: var(--d)
            }

            @keyframes bbtIgFade {
                to {
                    opacity: 1
                }
            }

            .bbt-ig-item img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                transition: transform .4s ease
            }

            .bbt-ig-item:hover img {
                transform: scale(1.1)
            }

            .bbt-ig-overlay {
                position: absolute;
                inset: 0;
                background: rgba(0, 0, 0, .5);
                display: flex;
                align-items: center;
                justify-content: center;
                opacity: 0;
                transition: opacity .3s ease;
                color: #fff;
                font-weight: 600
            }

            .bbt-ig-item:hover .bbt-ig-overlay {
                opacity: 1
            }
        </style>
        <?php
    }
}
