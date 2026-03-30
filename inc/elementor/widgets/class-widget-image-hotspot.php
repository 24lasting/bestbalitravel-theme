<?php
if (!defined('ABSPATH')) exit;

class BBT_Widget_Image_Hotspot extends \Elementor\Widget_Base {
    public function get_name() { return 'bbt-image-hotspot'; }
    public function get_title() { return esc_html__('Image Hotspot', 'bestbalitravel'); }
    public function get_icon() { return 'eicon-image-hotspot'; }
    public function get_categories() { return ['bbt-widgets']; }

    protected function register_controls() {
        $this->start_controls_section('section_content', ['label' => 'Content']);
        $this->add_control('image', ['label' => 'Image', 'type' => \Elementor\Controls_Manager::MEDIA, 'default' => ['url' => 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=1200']]);
        $repeater = new \Elementor\Repeater();
        $repeater->add_control('x', ['label' => 'X Position %', 'type' => \Elementor\Controls_Manager::SLIDER, 'default' => ['size' => 50]]);
        $repeater->add_control('y', ['label' => 'Y Position %', 'type' => \Elementor\Controls_Manager::SLIDER, 'default' => ['size' => 50]]);
        $repeater->add_control('title', ['label' => 'Title', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Hotspot']);
        $repeater->add_control('content', ['label' => 'Content', 'type' => \Elementor\Controls_Manager::TEXTAREA]);
        $this->add_control('hotspots', ['type' => \Elementor\Controls_Manager::REPEATER, 'fields' => $repeater->get_controls(), 'default' => [
            ['x' => ['size' => 25], 'y' => ['size' => 40], 'title' => 'Rice Terraces', 'content' => 'Beautiful UNESCO heritage site'],
            ['x' => ['size' => 70], 'y' => ['size' => 60], 'title' => 'Temple', 'content' => 'Ancient sacred temple'],
        ]]);
        $this->end_controls_section();
    }

    protected function render() {
        $s = $this->get_settings_for_display();
        $img = $s['image']['url'] ?: 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=1200';
        ?>
        <div class="bbt-image-hotspot">
            <img src="<?php echo esc_url($img); ?>" alt="">
            <?php foreach ($s['hotspots'] as $i => $h) : ?>
            <div class="bbt-hotspot" style="left:<?php echo esc_attr($h['x']['size']); ?>%;top:<?php echo esc_attr($h['y']['size']); ?>%">
                <span class="bbt-hotspot-dot"></span>
                <div class="bbt-hotspot-tooltip"><strong><?php echo esc_html($h['title']); ?></strong><p><?php echo esc_html($h['content']); ?></p></div>
            </div>
            <?php endforeach; ?>
        </div>
        <style>
            .bbt-image-hotspot{position:relative;border-radius:20px;overflow:hidden}
            .bbt-image-hotspot>img{width:100%;display:block}
            .bbt-hotspot{position:absolute;z-index:10}
            .bbt-hotspot-dot{display:block;width:24px;height:24px;background:#F5A623;border:3px solid #fff;border-radius:50%;cursor:pointer;animation:bbtHotspotPulse 2s ease infinite;box-shadow:0 4px 15px rgba(0,0,0,.2)}
            @keyframes bbtHotspotPulse{0%,100%{transform:scale(1)}50%{transform:scale(1.2)}}
            .bbt-hotspot-tooltip{position:absolute;bottom:calc(100% + 15px);left:50%;transform:translateX(-50%);background:#fff;padding:15px 20px;border-radius:12px;box-shadow:0 10px 30px rgba(0,0,0,.15);opacity:0;visibility:hidden;transition:all .3s ease;min-width:180px;text-align:center}
            .bbt-hotspot:hover .bbt-hotspot-tooltip{opacity:1;visibility:visible}
            .bbt-hotspot-tooltip strong{display:block;margin-bottom:5px;color:#1a1a1a}
            .bbt-hotspot-tooltip p{margin:0;font-size:13px;color:#666}
        </style>
        <?php
    }
}
