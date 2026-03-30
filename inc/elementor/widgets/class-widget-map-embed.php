<?php
if (!defined('ABSPATH'))
    exit;

class BBT_Widget_Map_Embed extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'bbt-map-embed';
    }
    public function get_title()
    {
        return esc_html__('Map Embed', 'bestbalitravel');
    }
    public function get_icon()
    {
        return 'eicon-google-maps';
    }
    public function get_categories()
    {
        return ['bbt-widgets'];
    }

    protected function register_controls()
    {
        $this->start_controls_section('section_content', ['label' => 'Map']);
        $this->add_control('address', ['label' => 'Address', 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'Ubud, Bali, Indonesia']);
        $this->add_control('height', ['label' => 'Height', 'type' => \Elementor\Controls_Manager::SLIDER, 'range' => ['px' => ['min' => 200, 'max' => 600]], 'default' => ['size' => 400]]);
        $this->add_control('zoom', ['label' => 'Zoom', 'type' => \Elementor\Controls_Manager::SLIDER, 'range' => ['px' => ['min' => 5, 'max' => 18]], 'default' => ['size' => 14]]);
        $this->end_controls_section();
    }

    protected function render()
    {
        $s = $this->get_settings_for_display();
        $addr = urlencode($s['address']);
        ?>
        <div class="bbt-map-embed" style="height:<?php echo esc_attr($s['height']['size']); ?>px">
            <iframe
                src="https://maps.google.com/maps?q=<?php echo $addr; ?>&z=<?php echo esc_attr($s['zoom']['size']); ?>&output=embed"
                frameborder="0" allowfullscreen></iframe>
        </div>
        <style>
            .bbt-map-embed {
                border-radius: 20px;
                overflow: hidden;
                box-shadow: 0 10px 30px rgba(0, 0, 0, .1)
            }

            .bbt-map-embed iframe {
                width: 100%;
                height: 100%;
                border: 0
            }
        </style>
        <?php
    }
}
