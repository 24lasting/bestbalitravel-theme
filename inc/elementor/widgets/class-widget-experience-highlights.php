<?php
/**
 * Elementor Experience Highlights Widget
 *
 * @package BestBaliTravel
 */

if (!defined('ABSPATH'))
    exit;

class BBT_Widget_Experience_Highlights extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'bbt-experience-highlights';
    }
    public function get_title()
    {
        return esc_html__('Experience Highlights', 'bestbalitravel');
    }
    public function get_icon()
    {
        return 'eicon-star';
    }
    public function get_categories()
    {
        return ['bbt-widgets'];
    }

    protected function register_controls()
    {
        $this->start_controls_section('section_highlights', ['label' => 'Highlights']);

        $repeater = new \Elementor\Repeater();
        $repeater->add_control('icon', ['label' => 'Icon', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '🌅']);
        $repeater->add_control('title', ['label' => 'Title', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Sunset Views']);
        $repeater->add_control('description', ['label' => 'Description', 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'Watch breathtaking sunsets']);
        $repeater->add_control('image', ['label' => 'Background Image', 'type' => \Elementor\Controls_Manager::MEDIA]);

        $this->add_control('highlights', [
            'type' => \Elementor\Controls_Manager::REPEATER,
            'fields' => $repeater->get_controls(),
            'default' => [
                ['icon' => '🌅', 'title' => 'Stunning Sunsets', 'description' => 'Watch magical sunsets over the ocean'],
                ['icon' => '🏝️', 'title' => 'Hidden Beaches', 'description' => 'Discover secluded paradise spots'],
                ['icon' => '🍜', 'title' => 'Local Cuisine', 'description' => 'Taste authentic Balinese flavors'],
                ['icon' => '🛕', 'title' => 'Ancient Temples', 'description' => 'Explore centuries-old sacred sites'],
            ],
        ]);

        $this->end_controls_section();
    }

    protected function render()
    {
        $highlights = $this->get_settings_for_display()['highlights'];
        $bgImages = [
            'https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=800',
            'https://images.unsplash.com/photo-1555400038-63f5ba517a47?w=800',
            'https://images.unsplash.com/photo-1552733407-5d5c46c3bb3b?w=800',
            'https://images.unsplash.com/photo-1544644181-1484b3fdfc62?w=800',
        ];
        ?>
        <div class="bbt-experience-highlights">
            <?php foreach ($highlights as $i => $h):
                $bg = !empty($h['image']['url']) ? $h['image']['url'] : $bgImages[$i % 4];
                ?>
                <div class="bbt-exp-item" style="--d:<?php echo $i * 0.15; ?>s">
                    <div class="bbt-exp-bg" style="background-image:url('<?php echo esc_url($bg); ?>')"></div>
                    <div class="bbt-exp-overlay"></div>
                    <div class="bbt-exp-content">
                        <span class="bbt-exp-icon">
                            <?php echo $h['icon']; ?>
                        </span>
                        <h4>
                            <?php echo esc_html($h['title']); ?>
                        </h4>
                        <p>
                            <?php echo esc_html($h['description']); ?>
                        </p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <style>
            .bbt-experience-highlights {
                display: grid;
                grid-template-columns: repeat(4, 1fr);
                gap: 20px
            }

            .bbt-exp-item {
                position: relative;
                height: 320px;
                border-radius: 24px;
                overflow: hidden;
                cursor: pointer;
                opacity: 0;
                animation: bbtExpFade .5s ease forwards;
                animation-delay: var(--d)
            }

            @keyframes bbtExpFade {
                to {
                    opacity: 1
                }
            }

            .bbt-exp-bg {
                position: absolute;
                inset: 0;
                background-size: cover;
                background-position: center;
                transition: transform .6s ease
            }

            .bbt-exp-item:hover .bbt-exp-bg {
                transform: scale(1.1)
            }

            .bbt-exp-overlay {
                position: absolute;
                inset: 0;
                background: linear-gradient(180deg, transparent 30%, rgba(0, 0, 0, .8) 100%)
            }

            .bbt-exp-content {
                position: absolute;
                bottom: 0;
                left: 0;
                right: 0;
                padding: 30px;
                color: #fff;
                transform: translateY(20px);
                transition: transform .4s ease
            }

            .bbt-exp-item:hover .bbt-exp-content {
                transform: translateY(0)
            }

            .bbt-exp-icon {
                display: block;
                font-size: 40px;
                margin-bottom: 15px;
                transition: transform .3s ease
            }

            .bbt-exp-item:hover .bbt-exp-icon {
                transform: scale(1.2) rotate(10deg)
            }

            .bbt-exp-content h4 {
                margin: 0 0 8px;
                font-size: 20px;
                font-weight: 700
            }

            .bbt-exp-content p {
                margin: 0;
                font-size: 14px;
                opacity: 0;
                transition: opacity .3s ease
            }

            .bbt-exp-item:hover .bbt-exp-content p {
                opacity: .9
            }

            @media(max-width:1024px) {
                .bbt-experience-highlights {
                    grid-template-columns: repeat(2, 1fr)
                }
            }

            @media(max-width:640px) {
                .bbt-experience-highlights {
                    grid-template-columns: 1fr
                }
            }
        </style>
        <?php
    }
}
