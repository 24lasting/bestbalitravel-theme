<?php
if (!defined('ABSPATH'))
    exit;

class BBT_Widget_Share_Buttons extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'bbt-share-buttons';
    }
    public function get_title()
    {
        return esc_html__('Share Buttons', 'bestbalitravel');
    }
    public function get_icon()
    {
        return 'eicon-share';
    }
    public function get_categories()
    {
        return ['bbt-widgets'];
    }

    protected function register_controls()
    {
        $this->start_controls_section('section_content', ['label' => 'Platforms']);
        $this->add_control('show_facebook', ['label' => 'Facebook', 'type' => \Elementor\Controls_Manager::SWITCHER, 'default' => 'yes']);
        $this->add_control('show_twitter', ['label' => 'Twitter', 'type' => \Elementor\Controls_Manager::SWITCHER, 'default' => 'yes']);
        $this->add_control('show_whatsapp', ['label' => 'WhatsApp', 'type' => \Elementor\Controls_Manager::SWITCHER, 'default' => 'yes']);
        $this->add_control('show_linkedin', ['label' => 'LinkedIn', 'type' => \Elementor\Controls_Manager::SWITCHER]);
        $this->add_control('show_copy', ['label' => 'Copy Link', 'type' => \Elementor\Controls_Manager::SWITCHER, 'default' => 'yes']);
        $this->end_controls_section();
    }

    protected function render()
    {
        $s = $this->get_settings_for_display();
        $url = get_permalink();
        $title = get_the_title();
        ?>
        <div class="bbt-share-buttons">
            <span class="bbt-sb-label">Share:</span>
            <?php if ($s['show_facebook'] === 'yes'): ?>
                <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode($url); ?>" target="_blank"
                    class="bbt-sb-btn fb">📘</a>
            <?php endif; ?>
            <?php if ($s['show_twitter'] === 'yes'): ?>
                <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode($url); ?>&text=<?php echo urlencode($title); ?>"
                    target="_blank" class="bbt-sb-btn tw">🐦</a>
            <?php endif; ?>
            <?php if ($s['show_whatsapp'] === 'yes'): ?>
                <a href="https://wa.me/?text=<?php echo urlencode($title . ' ' . $url); ?>" target="_blank"
                    class="bbt-sb-btn wa">💬</a>
            <?php endif; ?>
            <?php if ($s['show_linkedin'] === 'yes'): ?>
                <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo urlencode($url); ?>" target="_blank"
                    class="bbt-sb-btn li">💼</a>
            <?php endif; ?>
            <?php if ($s['show_copy'] === 'yes'): ?>
                <button class="bbt-sb-btn copy"
                    onclick="navigator.clipboard.writeText('<?php echo esc_url($url); ?>');this.textContent='✅';setTimeout(()=>this.textContent='🔗',2000)">🔗</button>
            <?php endif; ?>
        </div>
        <style>
            .bbt-share-buttons {
                display: flex;
                align-items: center;
                gap: 12px;
                flex-wrap: wrap
            }

            .bbt-sb-label {
                font-size: 14px;
                font-weight: 600;
                color: #666
            }

            .bbt-sb-btn {
                width: 44px;
                height: 44px;
                border: none;
                border-radius: 12px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 20px;
                cursor: pointer;
                text-decoration: none;
                transition: all .3s ease
            }

            .bbt-sb-btn.fb {
                background: #E7F3FF
            }

            .bbt-sb-btn.tw {
                background: #E8F5FD
            }

            .bbt-sb-btn.wa {
                background: #E7FBE6
            }

            .bbt-sb-btn.li {
                background: #E8F4F8
            }

            .bbt-sb-btn.copy {
                background: #f5f5f5
            }

            .bbt-sb-btn:hover {
                transform: translateY(-3px)
            }
        </style>
        <?php
    }
}
