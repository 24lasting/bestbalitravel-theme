<?php
/**
 * Elementor Team/Guides Widget
 *
 * @package BestBaliTravel
 */

if (!defined('ABSPATH'))
    exit;

class BBT_Widget_Team_Guides extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'bbt-team-guides';
    }
    public function get_title()
    {
        return esc_html__('Team/Guides', 'bestbalitravel');
    }
    public function get_icon()
    {
        return 'eicon-person';
    }
    public function get_categories()
    {
        return ['bbt-widgets'];
    }

    protected function register_controls()
    {
        $this->start_controls_section('section_team', ['label' => 'Team Members']);

        $repeater = new \Elementor\Repeater();
        $repeater->add_control('name', ['label' => 'Name', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Made Wijaya']);
        $repeater->add_control('role', ['label' => 'Role', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Tour Guide']);
        $repeater->add_control('photo', ['label' => 'Photo', 'type' => \Elementor\Controls_Manager::MEDIA]);
        $repeater->add_control('experience', ['label' => 'Experience', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '10+ years']);
        $repeater->add_control('languages', ['label' => 'Languages', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'English, Indonesian']);

        $this->add_control('members', [
            'type' => \Elementor\Controls_Manager::REPEATER,
            'fields' => $repeater->get_controls(),
            'default' => [
                ['name' => 'Made Wijaya', 'role' => 'Senior Tour Guide', 'experience' => '12 years', 'languages' => 'English, Japanese'],
                ['name' => 'Ketut Ari', 'role' => 'Adventure Guide', 'experience' => '8 years', 'languages' => 'English, German'],
                ['name' => 'Wayan Surya', 'role' => 'Cultural Expert', 'experience' => '15 years', 'languages' => 'English, French'],
            ],
        ]);

        $this->end_controls_section();
    }

    protected function render()
    {
        $members = $this->get_settings_for_display()['members'];
        ?>
        <div class="bbt-team-guides">
            <?php foreach ($members as $i => $m):
                $photo = !empty($m['photo']['url']) ? $m['photo']['url'] : 'https://ui-avatars.com/api/?name=' . urlencode($m['name']) . '&size=300&background=F5A623&color=fff';
                ?>
                <div class="bbt-guide-card" style="--d:<?php echo $i * 0.15; ?>s">
                    <div class="bbt-guide-photo">
                        <img src="<?php echo esc_url($photo); ?>" alt="<?php echo esc_attr($m['name']); ?>">
                        <div class="bbt-guide-overlay">
                            <span class="bbt-guide-exp">🏆
                                <?php echo esc_html($m['experience']); ?>
                            </span>
                        </div>
                    </div>
                    <div class="bbt-guide-info">
                        <h4>
                            <?php echo esc_html($m['name']); ?>
                        </h4>
                        <span class="bbt-guide-role">
                            <?php echo esc_html($m['role']); ?>
                        </span>
                        <div class="bbt-guide-langs">🗣️
                            <?php echo esc_html($m['languages']); ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <style>
            .bbt-team-guides {
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                gap: 30px
            }

            .bbt-guide-card {
                background: #fff;
                border-radius: 24px;
                overflow: hidden;
                box-shadow: 0 10px 40px rgba(0, 0, 0, .08);
                transition: all .4s ease;
                opacity: 0;
                animation: bbtGuideFade .5s ease forwards;
                animation-delay: var(--d)
            }

            @keyframes bbtGuideFade {
                to {
                    opacity: 1
                }
            }

            .bbt-guide-card:hover {
                transform: translateY(-10px);
                box-shadow: 0 20px 60px rgba(0, 0, 0, .15)
            }

            .bbt-guide-photo {
                position: relative;
                height: 280px;
                overflow: hidden
            }

            .bbt-guide-photo img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                transition: transform .6s ease
            }

            .bbt-guide-card:hover .bbt-guide-photo img {
                transform: scale(1.1)
            }

            .bbt-guide-overlay {
                position: absolute;
                inset: 0;
                background: linear-gradient(180deg, transparent 50%, rgba(0, 0, 0, .7) 100%);
                display: flex;
                align-items: flex-end;
                padding: 20px
            }

            .bbt-guide-exp {
                background: #F5A623;
                color: #000;
                padding: 6px 14px;
                border-radius: 20px;
                font-size: 12px;
                font-weight: 700
            }

            .bbt-guide-info {
                padding: 25px;
                text-align: center
            }

            .bbt-guide-info h4 {
                margin: 0 0 5px;
                font-size: 20px;
                font-weight: 700
            }

            .bbt-guide-role {
                display: block;
                color: #F5A623;
                font-weight: 600;
                margin-bottom: 10px
            }

            .bbt-guide-langs {
                font-size: 13px;
                color: #666
            }

            @media(max-width:768px) {
                .bbt-team-guides {
                    grid-template-columns: 1fr
                }
            }
        </style>
        <?php
    }
}
