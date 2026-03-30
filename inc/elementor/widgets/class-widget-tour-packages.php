<?php
/**
 * Elementor Tour Packages Widget
 *
 * @package BestBaliTravel
 */

if (!defined('ABSPATH'))
    exit;

class BBT_Widget_Tour_Packages extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'bbt-tour-packages';
    }
    public function get_title()
    {
        return esc_html__('Tour Packages', 'bestbalitravel');
    }
    public function get_icon()
    {
        return 'eicon-products';
    }
    public function get_categories()
    {
        return ['bbt-widgets'];
    }

    protected function register_controls()
    {
        $this->start_controls_section('section_packages', ['label' => 'Packages']);

        $repeater = new \Elementor\Repeater();
        $repeater->add_control('name', ['label' => 'Name', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Standard']);
        $repeater->add_control('price', ['label' => 'Price', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Rp 450,000']);
        $repeater->add_control('description', ['label' => 'Description', 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'Perfect for solo travelers']);
        $repeater->add_control('features', ['label' => 'Features (one per line)', 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => "Hotel pickup\nLunch included\nEnglish guide"]);
        $repeater->add_control('popular', ['label' => 'Most Popular', 'type' => \Elementor\Controls_Manager::SWITCHER]);
        $repeater->add_control('color', ['label' => 'Accent Color', 'type' => \Elementor\Controls_Manager::COLOR, 'default' => '#F5A623']);

        $this->add_control('packages', [
            'type' => \Elementor\Controls_Manager::REPEATER,
            'fields' => $repeater->get_controls(),
            'default' => [
                ['name' => 'Basic', 'price' => 'Rp 350,000', 'features' => "Shared transport\nLunch included\nEnglish guide", 'color' => '#6B7280'],
                ['name' => 'Premium', 'price' => 'Rp 550,000', 'features' => "Private car\nLunch included\nEnglish guide\nPhoto session\nDrone footage", 'popular' => 'yes', 'color' => '#F5A623'],
                ['name' => 'VIP', 'price' => 'Rp 850,000', 'features' => "Luxury car\nFine dining\nPrivate guide\nPhoto + video\nSpa treatment\nSunset dinner", 'color' => '#8B5CF6'],
            ],
        ]);

        $this->end_controls_section();
    }

    protected function render()
    {
        $packages = $this->get_settings_for_display()['packages'];
        ?>
        <div class="bbt-tour-packages">
            <?php foreach ($packages as $i => $p):
                $features = array_filter(explode("\n", $p['features']));
                $popular = $p['popular'] === 'yes';
                ?>
                <div class="bbt-package-card<?php echo $popular ? ' popular' : ''; ?>"
                    style="--accent:<?php echo esc_attr($p['color']); ?>;--d:<?php echo $i * 0.15; ?>s">
                    <?php if ($popular): ?><span class="bbt-package-badge">⭐ Most Popular</span>
                    <?php endif; ?>
                    <h3 class="bbt-package-name">
                        <?php echo esc_html($p['name']); ?>
                    </h3>
                    <div class="bbt-package-price">
                        <?php echo esc_html($p['price']); ?><span>/person</span>
                    </div>
                    <p class="bbt-package-desc">
                        <?php echo esc_html($p['description']); ?>
                    </p>
                    <ul class="bbt-package-features">
                        <?php foreach ($features as $f): ?>
                            <li>✓
                                <?php echo esc_html(trim($f)); ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                    <a href="#" class="bbt-package-btn">Select Package</a>
                </div>
            <?php endforeach; ?>
        </div>
        <style>
            .bbt-tour-packages {
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                gap: 30px;
                align-items: start
            }

            .bbt-package-card {
                position: relative;
                background: #fff;
                padding: 35px;
                border-radius: 24px;
                text-align: center;
                box-shadow: 0 10px 40px rgba(0, 0, 0, .08);
                transition: all .4s ease;
                opacity: 0;
                animation: bbtPkgFade .5s ease forwards;
                animation-delay: var(--d)
            }

            @keyframes bbtPkgFade {
                to {
                    opacity: 1
                }
            }

            .bbt-package-card:hover {
                transform: translateY(-10px);
                box-shadow: 0 20px 60px rgba(0, 0, 0, .15)
            }

            .bbt-package-card.popular {
                border: 3px solid var(--accent);
                transform: scale(1.05);
                z-index: 2
            }

            .bbt-package-badge {
                position: absolute;
                top: -12px;
                left: 50%;
                transform: translateX(-50%);
                background: linear-gradient(135deg, #F5A623, #FFD93D);
                padding: 6px 20px;
                border-radius: 20px;
                font-size: 12px;
                font-weight: 700;
                white-space: nowrap
            }

            .bbt-package-name {
                font-size: 22px;
                font-weight: 700;
                color: var(--accent);
                margin: 0 0 10px
            }

            .bbt-package-price {
                font-size: 32px;
                font-weight: 800;
                color: #1a1a1a;
                margin-bottom: 5px
            }

            .bbt-package-price span {
                font-size: 14px;
                font-weight: 400;
                color: #666
            }

            .bbt-package-desc {
                color: #666;
                font-size: 14px;
                margin-bottom: 20px
            }

            .bbt-package-features {
                list-style: none;
                padding: 0;
                margin: 0 0 25px;
                text-align: left
            }

            .bbt-package-features li {
                padding: 10px 0;
                border-bottom: 1px solid #eee;
                font-size: 14px;
                color: #4a4a4a
            }

            .bbt-package-btn {
                display: block;
                padding: 15px;
                background: var(--accent);
                color: #fff;
                text-decoration: none;
                border-radius: 12px;
                font-weight: 700;
                transition: all .3s ease
            }

            .bbt-package-btn:hover {
                opacity: .9;
                transform: translateY(-2px)
            }

            @media(max-width:1024px) {
                .bbt-tour-packages {
                    grid-template-columns: 1fr
                }

                .bbt-package-card.popular {
                    transform: none
                }
            }
        </style>
        <?php
    }
}
