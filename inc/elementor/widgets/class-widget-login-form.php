<?php
if (!defined('ABSPATH'))
    exit;

class BBT_Widget_Login_Form extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'bbt-login-form';
    }
    public function get_title()
    {
        return esc_html__('Login Form', 'bestbalitravel');
    }
    public function get_icon()
    {
        return 'eicon-lock-user';
    }
    public function get_categories()
    {
        return ['bbt-widgets'];
    }

    protected function register_controls()
    {
        $this->start_controls_section('section_content', ['label' => 'Settings']);
        $this->add_control('title', ['label' => 'Title', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Welcome Back']);
        $this->add_control('show_social', ['label' => 'Social Login', 'type' => \Elementor\Controls_Manager::SWITCHER, 'default' => 'yes']);
        $this->end_controls_section();
    }

    protected function render()
    {
        $s = $this->get_settings_for_display();
        ?>
        <div class="bbt-login-form">
            <h2>
                <?php echo esc_html($s['title']); ?>
            </h2>
            <p>Sign in to access your bookings</p>
            <form>
                <div class="bbt-lf-field"><input type="email" placeholder="Email address" required></div>
                <div class="bbt-lf-field"><input type="password" placeholder="Password" required></div>
                <div class="bbt-lf-row"><label><input type="checkbox"> Remember me</label><a href="#">Forgot password?</a></div>
                <button type="submit" class="bbt-lf-btn">Sign In</button>
            </form>
            <?php if ($s['show_social'] === 'yes'): ?>
                <div class="bbt-lf-divider"><span>or continue with</span></div>
                <div class="bbt-lf-social"><button type="button">📘 Facebook</button><button type="button">📧 Google</button></div>
            <?php endif; ?>
            <p class="bbt-lf-signup">Don't have an account? <a href="#">Sign up</a></p>
        </div>
        <style>
            .bbt-login-form {
                background: #fff;
                padding: 40px;
                border-radius: 24px;
                max-width: 400px;
                margin: 0 auto;
                box-shadow: 0 15px 50px rgba(0, 0, 0, .1)
            }

            .bbt-login-form h2 {
                margin: 0 0 5px;
                font-size: 28px;
                text-align: center
            }

            .bbt-login-form>p {
                text-align: center;
                color: #666;
                margin: 0 0 30px
            }

            .bbt-lf-field {
                margin-bottom: 18px
            }

            .bbt-lf-field input {
                width: 100%;
                padding: 15px 18px;
                border: 2px solid #eee;
                border-radius: 12px;
                font-size: 15px
            }

            .bbt-lf-field input:focus {
                outline: none;
                border-color: #F5A623
            }

            .bbt-lf-row {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 20px;
                font-size: 13px
            }

            .bbt-lf-row a {
                color: #F5A623
            }

            .bbt-lf-btn {
                width: 100%;
                padding: 16px;
                background: #F5A623;
                border: none;
                border-radius: 12px;
                font-size: 16px;
                font-weight: 700;
                cursor: pointer
            }

            .bbt-lf-divider {
                text-align: center;
                margin: 25px 0;
                position: relative
            }

            .bbt-lf-divider::before {
                content: '';
                position: absolute;
                top: 50%;
                left: 0;
                right: 0;
                height: 1px;
                background: #eee
            }

            .bbt-lf-divider span {
                position: relative;
                background: #fff;
                padding: 0 15px;
                color: #666;
                font-size: 13px
            }

            .bbt-lf-social {
                display: flex;
                gap: 12px
            }

            .bbt-lf-social button {
                flex: 1;
                padding: 12px;
                border: 2px solid #eee;
                border-radius: 12px;
                background: #fff;
                font-size: 14px;
                cursor: pointer
            }

            .bbt-lf-signup {
                text-align: center;
                margin: 25px 0 0;
                font-size: 14px
            }

            .bbt-lf-signup a {
                color: #F5A623;
                font-weight: 600
            }
        </style>
        <?php
    }
}
