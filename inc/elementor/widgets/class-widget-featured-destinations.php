<?php
/**
 * Elementor Featured Destinations Widget
 * Animated destination cards with hover effects
 *
 * @package BestBaliTravel
 */

if (!defined('ABSPATH')) {
    exit;
}

class BBT_Widget_Featured_Destinations extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'bbt-featured-destinations';
    }
    public function get_title()
    {
        return esc_html__('Featured Destinations', 'bestbalitravel');
    }
    public function get_icon()
    {
        return 'eicon-map-pin';
    }
    public function get_categories()
    {
        return ['bbt-widgets'];
    }

    protected function register_controls()
    {
        $this->start_controls_section('section_destinations', [
            'label' => esc_html__('Destinations', 'bestbalitravel'),
        ]);

        $repeater = new \Elementor\Repeater();

        $repeater->add_control('name', [
            'label' => esc_html__('Destination Name', 'bestbalitravel'),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => 'Ubud',
        ]);

        $repeater->add_control('description', [
            'label' => esc_html__('Description', 'bestbalitravel'),
            'type' => \Elementor\Controls_Manager::TEXTAREA,
            'default' => 'Cultural heart of Bali',
        ]);

        $repeater->add_control('image', [
            'label' => esc_html__('Image', 'bestbalitravel'),
            'type' => \Elementor\Controls_Manager::MEDIA,
        ]);

        $repeater->add_control('tours_count', [
            'label' => esc_html__('Tours Count', 'bestbalitravel'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'default' => 12,
        ]);

        $repeater->add_control('link', [
            'label' => esc_html__('Link', 'bestbalitravel'),
            'type' => \Elementor\Controls_Manager::URL,
        ]);

        $this->add_control('destinations', [
            'label' => esc_html__('Destinations', 'bestbalitravel'),
            'type' => \Elementor\Controls_Manager::REPEATER,
            'fields' => $repeater->get_controls(),
            'default' => [
                ['name' => 'Ubud', 'description' => 'Cultural heart of Bali', 'tours_count' => 15],
                ['name' => 'Seminyak', 'description' => 'Beach clubs & nightlife', 'tours_count' => 12],
                ['name' => 'Uluwatu', 'description' => 'Stunning cliff temples', 'tours_count' => 8],
                ['name' => 'Nusa Penida', 'description' => 'Island paradise', 'tours_count' => 10],
            ],
            'title_field' => '{{{ name }}}',
        ]);

        $this->add_control('columns', [
            'label' => esc_html__('Columns', 'bestbalitravel'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'options' => ['2' => '2', '3' => '3', '4' => '4'],
            'default' => '4',
        ]);

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $destinations = $settings['destinations'];
        $columns = $settings['columns'];

        $default_images = [
            'https://images.unsplash.com/photo-1552733407-5d5c46c3bb3b?w=600',
            'https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=600',
            'https://images.unsplash.com/photo-1555400038-63f5ba517a47?w=600',
            'https://images.unsplash.com/photo-1544644181-1484b3fdfc62?w=600',
        ];
        ?>
        <div class="bbt-featured-destinations">
            <div class="bbt-destinations-grid" style="--columns: <?php echo esc_attr($columns); ?>">
                <?php foreach ($destinations as $index => $dest):
                    $image = !empty($dest['image']['url']) ? $dest['image']['url'] : $default_images[$index % 4];
                    $link = !empty($dest['link']['url']) ? $dest['link']['url'] : '#';
                    ?>
                    <a href="<?php echo esc_url($link); ?>" class="bbt-destination-card"
                        style="--delay: <?php echo $index * 0.1; ?>s">
                        <div class="bbt-dest-image">
                            <img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr($dest['name']); ?>" loading="lazy">
                            <div class="bbt-dest-overlay"></div>
                        </div>

                        <div class="bbt-dest-content">
                            <span class="bbt-dest-count">
                                <?php echo esc_html($dest['tours_count']); ?> Tours
                            </span>
                            <h3 class="bbt-dest-name">
                                <?php echo esc_html($dest['name']); ?>
                            </h3>
                            <p class="bbt-dest-desc">
                                <?php echo esc_html($dest['description']); ?>
                            </p>

                            <div class="bbt-dest-arrow">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M5 12h14M12 5l7 7-7 7" />
                                </svg>
                            </div>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>

        <style>
            .bbt-destinations-grid {
                display: grid;
                grid-template-columns: repeat(var(--columns), 1fr);
                gap: 24px;
            }

            .bbt-destination-card {
                position: relative;
                height: 350px;
                border-radius: 24px;
                overflow: hidden;
                text-decoration: none;
                color: #fff;
                opacity: 0;
                animation: bbtDestFade 0.6s ease forwards;
                animation-delay: var(--delay);
            }

            @keyframes bbtDestFade {
                to {
                    opacity: 1;
                }
            }

            .bbt-dest-image {
                position: absolute;
                inset: 0;
            }

            .bbt-dest-image img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                transition: transform 0.6s ease;
            }

            .bbt-destination-card:hover .bbt-dest-image img {
                transform: scale(1.1);
            }

            .bbt-dest-overlay {
                position: absolute;
                inset: 0;
                background: linear-gradient(180deg, transparent 0%, rgba(0, 0, 0, 0.8) 100%);
                transition: background 0.4s ease;
            }

            .bbt-destination-card:hover .bbt-dest-overlay {
                background: linear-gradient(180deg, rgba(245, 166, 35, 0.2) 0%, rgba(0, 0, 0, 0.9) 100%);
            }

            .bbt-dest-content {
                position: absolute;
                bottom: 0;
                left: 0;
                right: 0;
                padding: 30px;
                transform: translateY(20px);
                transition: transform 0.4s ease;
            }

            .bbt-destination-card:hover .bbt-dest-content {
                transform: translateY(0);
            }

            .bbt-dest-count {
                display: inline-block;
                background: #F5A623;
                color: #000;
                padding: 4px 12px;
                border-radius: 20px;
                font-size: 12px;
                font-weight: 700;
                margin-bottom: 10px;
            }

            .bbt-dest-name {
                margin: 0 0 8px;
                font-size: 24px;
                font-weight: 700;
            }

            .bbt-dest-desc {
                margin: 0;
                font-size: 14px;
                opacity: 0.9;
            }

            .bbt-dest-arrow {
                position: absolute;
                right: 30px;
                bottom: 30px;
                width: 48px;
                height: 48px;
                background: rgba(255, 255, 255, 0.1);
                backdrop-filter: blur(10px);
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                opacity: 0;
                transform: translateX(-20px);
                transition: all 0.4s ease;
            }

            .bbt-destination-card:hover .bbt-dest-arrow {
                opacity: 1;
                transform: translateX(0);
            }

            @media (max-width: 1024px) {
                .bbt-destinations-grid {
                    grid-template-columns: repeat(2, 1fr);
                }
            }

            @media (max-width: 640px) {
                .bbt-destinations-grid {
                    grid-template-columns: 1fr;
                }

                .bbt-destination-card {
                    height: 280px;
                }
            }
        </style>
        <?php
    }
}
