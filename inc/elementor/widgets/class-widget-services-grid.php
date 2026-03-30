<?php
if (!defined('ABSPATH'))
    exit;

class BBT_Widget_Services_Grid extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'bbt-services-grid';
    }
    public function get_title()
    {
        return esc_html__('Services Grid', 'bestbalitravel');
    }
    public function get_icon()
    {
        return 'eicon-apps';
    }
    public function get_categories()
    {
        return ['bbt-widgets'];
    }

    protected function register_controls()
    {
        $this->start_controls_section('section_services', ['label' => 'Services']);
        $repeater = new \Elementor\Repeater();
        $repeater->add_control('icon', ['label' => 'Icon', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '🚐']);
        $repeater->add_control('title', ['label' => 'Title', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Service']);
        $repeater->add_control('description', ['label' => 'Description', 'type' => \Elementor\Controls_Manager::TEXTAREA]);
        $repeater->add_control('link', ['label' => 'Link', 'type' => \Elementor\Controls_Manager::URL]);
        $this->add_control('services', [
            'type' => \Elementor\Controls_Manager::REPEATER,
            'fields' => $repeater->get_controls(),
            'default' => [
                ['icon' => '🚐', 'title' => 'Airport Transfer', 'description' => 'Comfortable pickup from Ngurah Rai Airport'],
                ['icon' => '🗺️', 'title' => 'Private Tours', 'description' => 'Customized tours with personal guide'],
                ['icon' => '🚤', 'title' => 'Boat Trips', 'description' => 'Island hopping and snorkeling tours'],
                ['icon' => '🏨', 'title' => 'Hotel Booking', 'description' => 'Best rates on accommodations'],
                ['icon' => '📷', 'title' => 'Photo Tours', 'description' => 'Professional photoshoot locations'],
                ['icon' => '🎭', 'title' => 'Cultural Tours', 'description' => 'Authentic Balinese experiences'],
            ]
        ]);
        $this->end_controls_section();
    }

    protected function render()
    {
        $services = $this->get_settings_for_display()['services'];
        ?>
        <div class="bbt-services-grid">
            <?php foreach ($services as $i => $s): ?>
                <div class="bbt-service-card" style="--d:<?php echo $i * 0.1; ?>s">
                    <span class="bbt-service-icon">
                        <?php echo $s['icon']; ?>
                    </span>
                    <h3>
                        <?php echo esc_html($s['title']); ?>
                    </h3>
                    <p>
                        <?php echo esc_html($s['description']); ?>
                    </p>
                    <?php if (!empty($s['link']['url'])): ?><a href="<?php echo esc_url($s['link']['url']); ?>"
                            class="bbt-service-link">Learn More →</a>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
        <style>
            .bbt-services-grid {
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                gap: 25px
            }

            .bbt-service-card {
                background: #fff;
                padding: 35px;
                border-radius: 20px;
                text-align: center;
                box-shadow: 0 8px 30px rgba(0, 0, 0, .06);
                transition: all .4s ease;
                opacity: 0;
                animation: bbtSvcFade .5s ease forwards;
                animation-delay: var(--d)
            }

            @keyframes bbtSvcFade {
                to {
                    opacity: 1
                }
            }

            .bbt-service-card:hover {
                transform: translateY(-10px);
                box-shadow: 0 20px 50px rgba(0, 0, 0, .12)
            }

            .bbt-service-icon {
                display: block;
                font-size: 50px;
                margin-bottom: 20px;
                transition: transform .3s ease
            }

            .bbt-service-card:hover .bbt-service-icon {
                transform: scale(1.2) rotate(10deg)
            }

            .bbt-service-card h3 {
                margin: 0 0 12px;
                font-size: 20px
            }

            .bbt-service-card p {
                margin: 0 0 15px;
                color: #666;
                font-size: 14px;
                line-height: 1.6
            }

            .bbt-service-link {
                color: #F5A623;
                text-decoration: none;
                font-weight: 600
            }

            @media(max-width:768px) {
                .bbt-services-grid {
                    grid-template-columns: 1fr
                }
            }
        </style>
        <?php
    }
}
