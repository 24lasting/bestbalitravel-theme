<?php
if (!defined('ABSPATH'))
    exit;

class BBT_Widget_Contact_Form extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'bbt-contact-form';
    }
    public function get_title()
    {
        return esc_html__('Contact Form', 'bestbalitravel');
    }
    public function get_icon()
    {
        return 'eicon-envelope';
    }
    public function get_categories()
    {
        return ['bbt-widgets'];
    }

    protected function register_controls()
    {
        $this->start_controls_section('section_content', ['label' => 'Settings']);
        $this->add_control('title', ['label' => 'Title', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Get in Touch']);
        $this->add_control('show_tour_select', ['label' => 'Show Tour Selection', 'type' => \Elementor\Controls_Manager::SWITCHER, 'default' => 'yes']);
        $this->end_controls_section();
    }

    protected function render()
    {
        $s = $this->get_settings_for_display();
        ?>
        <div class="bbt-contact-form">
            <div class="bbt-cf-header">
                <h3>📧
                    <?php echo esc_html($s['title']); ?>
                </h3>
                <p>We'll respond within 24 hours</p>
            </div>
            <form class="bbt-cf-form">
                <div class="bbt-cf-row">
                    <div class="bbt-cf-field"><label>Name</label><input type="text" name="name" required></div>
                    <div class="bbt-cf-field"><label>Email</label><input type="email" name="email" required></div>
                </div>
                <div class="bbt-cf-field"><label>Phone</label><input type="tel" name="phone"></div>
                <?php if ($s['show_tour_select'] === 'yes'): ?>
                    <div class="bbt-cf-field"><label>Interested In</label>
                        <select name="tour">
                            <option value="">Select a tour (optional)</option>
                            <?php $tours = get_posts(['post_type' => 'tour', 'posts_per_page' => 20]);
                            foreach ($tours as $t)
                                echo '<option value="' . $t->ID . '">' . esc_html($t->post_title) . '</option>'; ?>
                        </select>
                    </div>
                <?php endif; ?>
                <div class="bbt-cf-field"><label>Message</label><textarea name="message" rows="4" required></textarea></div>
                <button type="submit" class="bbt-btn bbt-btn-primary">Send Message</button>
            </form>
        </div>
        <style>
            .bbt-contact-form {
                background: #fff;
                border-radius: 24px;
                padding: 35px;
                box-shadow: 0 15px 50px rgba(0, 0, 0, .1)
            }

            .bbt-cf-header h3 {
                margin: 0 0 5px;
                font-size: 24px
            }

            .bbt-cf-header p {
                margin: 0 0 25px;
                color: #666
            }

            .bbt-cf-row {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 20px
            }

            .bbt-cf-field {
                margin-bottom: 18px
            }

            .bbt-cf-field label {
                display: block;
                font-size: 13px;
                font-weight: 600;
                margin-bottom: 8px;
                color: #333
            }

            .bbt-cf-field input,
            .bbt-cf-field select,
            .bbt-cf-field textarea {
                width: 100%;
                padding: 14px 16px;
                border: 2px solid #eee;
                border-radius: 12px;
                font-size: 15px;
                transition: all .2s ease
            }

            .bbt-cf-field input:focus,
            .bbt-cf-field select:focus,
            .bbt-cf-field textarea:focus {
                outline: none;
                border-color: #F5A623
            }

            .bbt-contact-form .bbt-btn {
                width: 100%;
                padding: 16px;
                font-size: 16px
            }

            @media(max-width:640px) {
                .bbt-cf-row {
                    grid-template-columns: 1fr
                }
            }
        </style>
        <?php
    }
}
