<?php
if (!defined('ABSPATH'))
    exit;

class BBT_Widget_Team_Member extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'bbt-team-member';
    }
    public function get_title()
    {
        return esc_html__('Team Member', 'bestbalitravel');
    }
    public function get_icon()
    {
        return 'eicon-user-circle-o';
    }
    public function get_categories()
    {
        return ['bbt-widgets'];
    }

    protected function register_controls()
    {
        $this->start_controls_section('section_content', ['label' => 'Member']);
        $this->add_control('photo', ['label' => 'Photo', 'type' => \Elementor\Controls_Manager::MEDIA]);
        $this->add_control('name', ['label' => 'Name', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Made Wijaya']);
        $this->add_control('role', ['label' => 'Role', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Tour Guide']);
        $this->add_control('bio', ['label' => 'Bio', 'type' => \Elementor\Controls_Manager::TEXTAREA]);
        $this->add_control('whatsapp', ['label' => 'WhatsApp', 'type' => \Elementor\Controls_Manager::TEXT]);
        $this->add_control('email', ['label' => 'Email', 'type' => \Elementor\Controls_Manager::TEXT]);
        $this->end_controls_section();
    }

    protected function render()
    {
        $s = $this->get_settings_for_display();
        $photo = !empty($s['photo']['url']) ? $s['photo']['url'] : 'https://ui-avatars.com/api/?name=' . urlencode($s['name']) . '&size=300&background=F5A623&color=fff';
        ?>
        <div class="bbt-team-member">
            <div class="bbt-tm-photo"><img src="<?php echo esc_url($photo); ?>" alt="<?php echo esc_attr($s['name']); ?>"></div>
            <div class="bbt-tm-info">
                <h3>
                    <?php echo esc_html($s['name']); ?>
                </h3>
                <span class="bbt-tm-role">
                    <?php echo esc_html($s['role']); ?>
                </span>
                <?php if ($s['bio']): ?>
                    <p>
                        <?php echo esc_html($s['bio']); ?>
                    </p>
                <?php endif; ?>
                <div class="bbt-tm-social">
                    <?php if ($s['whatsapp']): ?><a href="https://wa.me/<?php echo esc_attr($s['whatsapp']); ?>"
                            target="_blank">💬</a>
                    <?php endif; ?>
                    <?php if ($s['email']): ?><a href="mailto:<?php echo esc_attr($s['email']); ?>">📧</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <style>
            .bbt-team-member {
                background: #fff;
                border-radius: 24px;
                overflow: hidden;
                box-shadow: 0 10px 40px rgba(0, 0, 0, .08);
                text-align: center;
                transition: all .4s ease
            }

            .bbt-team-member:hover {
                transform: translateY(-10px)
            }

            .bbt-tm-photo {
                overflow: hidden
            }

            .bbt-tm-photo img {
                width: 100%;
                height: 280px;
                object-fit: cover;
                transition: transform .5s ease
            }

            .bbt-team-member:hover .bbt-tm-photo img {
                transform: scale(1.1)
            }

            .bbt-tm-info {
                padding: 25px
            }

            .bbt-tm-info h3 {
                margin: 0 0 5px;
                font-size: 20px
            }

            .bbt-tm-role {
                display: block;
                color: #F5A623;
                font-weight: 600;
                margin-bottom: 12px
            }

            .bbt-tm-info p {
                color: #666;
                font-size: 14px;
                margin: 0 0 15px
            }

            .bbt-tm-social {
                display: flex;
                gap: 10px;
                justify-content: center
            }

            .bbt-tm-social a {
                width: 40px;
                height: 40px;
                background: #f5f5f5;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                text-decoration: none;
                font-size: 18px;
                transition: all .3s ease
            }

            .bbt-tm-social a:hover {
                background: #F5A623
            }
        </style>
        <?php
    }
}
