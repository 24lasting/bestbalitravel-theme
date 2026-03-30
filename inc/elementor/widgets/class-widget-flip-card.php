<?php
if (!defined('ABSPATH')) exit;

class BBT_Widget_Flip_Card extends \Elementor\Widget_Base {
    public function get_name() { return 'bbt-flip-card'; }
    public function get_title() { return esc_html__('Flip Card', 'bestbalitravel'); }
    public function get_icon() { return 'eicon-flip-box'; }
    public function get_categories() { return ['bbt-widgets']; }

    protected function register_controls() {
        $this->start_controls_section('section_front', ['label' => 'Front']);
        $this->add_control('front_image', ['label' => 'Image', 'type' => \Elementor\Controls_Manager::MEDIA]);
        $this->add_control('front_title', ['label' => 'Title', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Front Title']);
        $this->end_controls_section();
        $this->start_controls_section('section_back', ['label' => 'Back']);
        $this->add_control('back_title', ['label' => 'Title', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Back Title']);
        $this->add_control('back_content', ['label' => 'Content', 'type' => \Elementor\Controls_Manager::TEXTAREA]);
        $this->add_control('back_btn', ['label' => 'Button', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Learn More']);
        $this->add_control('back_link', ['label' => 'Link', 'type' => \Elementor\Controls_Manager::URL]);
        $this->end_controls_section();
    }

    protected function render() {
        $s = $this->get_settings_for_display();
        $img = !empty($s['front_image']['url']) ? $s['front_image']['url'] : 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=600';
        ?>
        <div class="bbt-flip-card">
            <div class="bbt-fc-inner">
                <div class="bbt-fc-front" style="background-image:url('<?php echo esc_url($img); ?>')">
                    <div class="bbt-fc-overlay"></div>
                    <h3><?php echo esc_html($s['front_title']); ?></h3>
                </div>
                <div class="bbt-fc-back">
                    <h3><?php echo esc_html($s['back_title']); ?></h3>
                    <p><?php echo esc_html($s['back_content']); ?></p>
                    <?php if ($s['back_btn']) : ?><a href="<?php echo esc_url($s['back_link']['url'] ?? '#'); ?>" class="bbt-fc-btn"><?php echo esc_html($s['back_btn']); ?></a><?php endif; ?>
                </div>
            </div>
        </div>
        <style>
            .bbt-flip-card{perspective:1000px;height:350px}
            .bbt-fc-inner{position:relative;width:100%;height:100%;transition:transform .8s;transform-style:preserve-3d}
            .bbt-flip-card:hover .bbt-fc-inner{transform:rotateY(180deg)}
            .bbt-fc-front,.bbt-fc-back{position:absolute;inset:0;backface-visibility:hidden;border-radius:20px;overflow:hidden}
            .bbt-fc-front{background-size:cover;background-position:center;display:flex;align-items:flex-end;padding:30px}
            .bbt-fc-overlay{position:absolute;inset:0;background:linear-gradient(180deg,transparent 50%,rgba(0,0,0,.8) 100%)}
            .bbt-fc-front h3{position:relative;z-index:2;color:#fff;font-size:22px;margin:0}
            .bbt-fc-back{background:linear-gradient(135deg,#F5A623,#FFD93D);transform:rotateY(180deg);display:flex;flex-direction:column;align-items:center;justify-content:center;text-align:center;padding:30px}
            .bbt-fc-back h3{margin:0 0 15px;font-size:24px}
            .bbt-fc-back p{margin:0 0 20px;font-size:14px;opacity:.9}
            .bbt-fc-btn{padding:12px 25px;background:#000;color:#fff;text-decoration:none;border-radius:25px;font-weight:600}
        </style>
        <?php
    }
}
