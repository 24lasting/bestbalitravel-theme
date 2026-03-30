<?php
if (!defined('ABSPATH'))
    exit;

class BBT_Widget_Social_Icons extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'bbt-social-icons';
    }
    public function get_title()
    {
        return esc_html__('Social Icons', 'bestbalitravel');
    }
    public function get_icon()
    {
        return 'eicon-social-icons';
    }
    public function get_categories()
    {
        return ['bbt-widgets'];
    }

    protected function register_controls()
    {
        $this->start_controls_section('section_icons', ['label' => 'Icons']);
        $this->add_control('facebook', ['label' => 'Facebook URL', 'type' => \Elementor\Controls_Manager::URL]);
        $this->add_control('instagram', ['label' => 'Instagram URL', 'type' => \Elementor\Controls_Manager::URL]);
        $this->add_control('twitter', ['label' => 'Twitter URL', 'type' => \Elementor\Controls_Manager::URL]);
        $this->add_control('youtube', ['label' => 'YouTube URL', 'type' => \Elementor\Controls_Manager::URL]);
        $this->add_control('tiktok', ['label' => 'TikTok URL', 'type' => \Elementor\Controls_Manager::URL]);
        $this->add_control('whatsapp', ['label' => 'WhatsApp Number', 'type' => \Elementor\Controls_Manager::TEXT]);
        $this->add_control('style', ['label' => 'Style', 'type' => \Elementor\Controls_Manager::SELECT, 'options' => ['rounded' => 'Rounded', 'circle' => 'Circle', 'square' => 'Square'], 'default' => 'rounded']);
        $this->end_controls_section();
    }

    protected function render()
    {
        $s = $this->get_settings_for_display();
        $socials = [
            'facebook' => ['url' => $s['facebook']['url'] ?? '', 'icon' => '📘', 'color' => '#1877F2'],
            'instagram' => ['url' => $s['instagram']['url'] ?? '', 'icon' => '📸', 'color' => '#E4405F'],
            'twitter' => ['url' => $s['twitter']['url'] ?? '', 'icon' => '🐦', 'color' => '#1DA1F2'],
            'youtube' => ['url' => $s['youtube']['url'] ?? '', 'icon' => '📺', 'color' => '#FF0000'],
            'tiktok' => ['url' => $s['tiktok']['url'] ?? '', 'icon' => '🎵', 'color' => '#000'],
            'whatsapp' => ['url' => $s['whatsapp'] ? 'https://wa.me/' . $s['whatsapp'] : '', 'icon' => '💬', 'color' => '#25D366'],
        ];
        ?>
        <div class="bbt-social-icons style-<?php echo esc_attr($s['style']); ?>">
            <?php foreach ($socials as $name => $data):
                if ($data['url']): ?>
                    <a href="<?php echo esc_url($data['url']); ?>" target="_blank" class="bbt-si-item"
                        style="--color:<?php echo esc_attr($data['color']); ?>">
                        <?php echo $data['icon']; ?>
                    </a>
                <?php endif; endforeach; ?>
        </div>
        <style>
            .bbt-social-icons {
                display: flex;
                gap: 12px;
                flex-wrap: wrap
            }

            .bbt-si-item {
                width: 48px;
                height: 48px;
                background: #f5f5f5;
                display: flex;
                align-items: center;
                justify-content: center;
                text-decoration: none;
                font-size: 22px;
                transition: all .3s ease
            }

            .style-rounded .bbt-si-item {
                border-radius: 12px
            }

            .style-circle .bbt-si-item {
                border-radius: 50%
            }

            .style-square .bbt-si-item {
                border-radius: 0
            }

            .bbt-si-item:hover {
                background: var(--color);
                transform: translateY(-3px)
            }
        </style>
        <?php
    }
}
