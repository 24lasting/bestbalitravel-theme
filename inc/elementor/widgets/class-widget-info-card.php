<?php
if (!defined('ABSPATH')) exit;

class BBT_Widget_Info_Card extends \Elementor\Widget_Base {
    public function get_name() { return 'bbt-info-card'; }
    public function get_title() { return esc_html__('Info Card', 'bestbalitravel'); }
    public function get_icon() { return 'eicon-info-box'; }
    public function get_categories() { return ['bbt-widgets']; }

    protected function register_controls() {
        $this->start_controls_section('section_content', ['label' => 'Content']);
        $this->add_control('icon', ['label' => 'Icon', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '📍']);
        $this->add_control('title', ['label' => 'Title', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Our Location']);
        $this->add_control('content', ['label' => 'Content', 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'Jl. Sunset Road No. 123, Kuta, Bali']);
        $this->add_control('link', ['label' => 'Link', 'type' => \Elementor\Controls_Manager::URL]);
        $this->end_controls_section();
    }

    protected function render() {
        $s = $this->get_settings_for_display();
        $tag = !empty($s['link']['url']) ? 'a' : 'div';
        $href = !empty($s['link']['url']) ? ' href="' . esc_url($s['link']['url']) . '"' : '';
        ?>
        <<?php echo $tag . $href; ?> class="bbt-info-card">
            <span class="bbt-ic-icon"><?php echo $s['icon']; ?></span>
            <h4><?php echo esc_html($s['title']); ?></h4>
            <p><?php echo esc_html($s['content']); ?></p>
        </<?php echo $tag; ?>>
        <style>
            .bbt-info-card{display:block;background:#fff;padding:30px;border-radius:20px;text-align:center;box-shadow:0 8px 30px rgba(0,0,0,.08);text-decoration:none;color:inherit;transition:all .4s ease}
            .bbt-info-card:hover{transform:translateY(-8px);box-shadow:0 15px 40px rgba(0,0,0,.12)}
            .bbt-ic-icon{display:block;font-size:48px;margin-bottom:15px}
            .bbt-info-card h4{margin:0 0 10px;font-size:18px}
            .bbt-info-card p{margin:0;color:#666;font-size:14px}
        </style>
        <?php
    }
}
