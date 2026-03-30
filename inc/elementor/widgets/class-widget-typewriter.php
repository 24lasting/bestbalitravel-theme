<?php
if (!defined('ABSPATH'))
    exit;

class BBT_Widget_Typewriter extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'bbt-typewriter';
    }
    public function get_title()
    {
        return esc_html__('Typewriter Effect', 'bestbalitravel');
    }
    public function get_icon()
    {
        return 'eicon-animation-text';
    }
    public function get_categories()
    {
        return ['bbt-widgets'];
    }

    protected function register_controls()
    {
        $this->start_controls_section('section_content', ['label' => 'Content']);
        $this->add_control('prefix', ['label' => 'Prefix Text', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Discover']);
        $this->add_control('words', ['label' => 'Rotating Words (one per line)', 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => "Bali's Beaches\nAncient Temples\nRice Terraces\nWaterfalls"]);
        $this->add_control('suffix', ['label' => 'Suffix Text', 'type' => \Elementor\Controls_Manager::TEXT]);
        $this->add_control('speed', ['label' => 'Speed (ms)', 'type' => \Elementor\Controls_Manager::NUMBER, 'default' => 100]);
        $this->end_controls_section();
    }

    protected function render()
    {
        $s = $this->get_settings_for_display();
        $words = array_filter(array_map('trim', explode("\n", $s['words'])));
        $id = 'tw-' . uniqid();
        ?>
        <div class="bbt-typewriter" id="<?php echo $id; ?>">
            <span class="bbt-tw-prefix">
                <?php echo esc_html($s['prefix']); ?>
            </span>
            <span class="bbt-tw-text"></span>
            <span class="bbt-tw-cursor">|</span>
            <span class="bbt-tw-suffix">
                <?php echo esc_html($s['suffix']); ?>
            </span>
        </div>
        <style>
            .bbt-typewriter {
                font-size: 48px;
                font-weight: 700
            }

            .bbt-tw-text {
                color: #F5A623
            }

            .bbt-tw-cursor {
                animation: bbtTwBlink 1s infinite
            }

            @keyframes bbtTwBlink {

                0%,
                100% {
                    opacity: 1
                }

                50% {
                    opacity: 0
                }
            }
        </style>
        <script>
            (function () {
                var words =<?php echo json_encode($words); ?>, el = document.querySelector('#<?php echo $id; ?> .bbt-tw-text'), idx = 0, char = 0, dir = 1, speed =<?php echo (int) $s['speed']; ?>;
                function type() { el.textContent = words[idx].substring(0, char); if (dir > 0 && char < words[idx].length) { char++; setTimeout(type, speed) } else if (dir > 0) { dir = -1; setTimeout(type, 2000) } else if (char > 0) { char--; setTimeout(type, speed / 2) } else { dir = 1; idx = (idx + 1) % words.length; setTimeout(type, 500) } } type()
            })();
        </script>
        <?php
    }
}
