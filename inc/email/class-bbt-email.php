<?php
/**
 * Email Manager
 * Handles all email notifications with beautiful HTML templates
 *
 * @package BestBaliTravel
 */

if (!defined('ABSPATH')) {
    exit;
}

class BBT_Email_Manager
{

    private static $instance = null;

    private $from_name;
    private $from_email;
    private $admin_email;

    public static function get_instance()
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct()
    {
        $settings = get_option('bbt_settings', array());

        $this->from_name = $settings['email_from_name'] ?? 'Best Bali Travel';
        $this->from_email = $settings['email_from_address'] ?? 'noreply@bestbalitravel.com';
        $this->admin_email = $settings['booking_notification_email'] ?? 'info@bestbalitravel.com';

        // Hooks for email
        add_filter('wp_mail_from', array($this, 'set_from_email'));
        add_filter('wp_mail_from_name', array($this, 'set_from_name'));
        add_filter('wp_mail_content_type', array($this, 'set_content_type'));

        // AJAX handlers
        add_action('wp_ajax_bbt_send_test_email', array($this, 'ajax_send_test_email'));
    }

    public function set_from_email($email)
    {
        return $this->from_email;
    }

    public function set_from_name($name)
    {
        return $this->from_name;
    }

    public function set_content_type($content_type)
    {
        return 'text/html';
    }

    /**
     * Send booking confirmation to customer
     */
    public function send_booking_confirmation($booking_data)
    {
        $settings = get_option('bbt_settings', array());

        if (empty($settings['notify_customer_booking'])) {
            return false;
        }

        $to = $booking_data['customer_email'];
        $subject = sprintf(__('Booking Confirmation - %s', 'bestbalitravel'), $booking_data['tour_name']);

        $template_data = array(
            'customer_name' => $booking_data['customer_name'],
            'tour_name' => $booking_data['tour_name'],
            'tour_date' => $booking_data['tour_date'],
            'guests' => $booking_data['guests'],
            'total_price' => $booking_data['total_price'],
            'booking_id' => $booking_data['booking_id'],
        );

        $body = $this->get_template('booking-confirmation', $template_data);

        return wp_mail($to, $subject, $body);
    }

    /**
     * Send booking notification to admin
     */
    public function send_admin_notification($booking_data)
    {
        $settings = get_option('bbt_settings', array());

        if (empty($settings['notify_admin_new_booking'])) {
            return false;
        }

        $to = $this->admin_email;
        $subject = sprintf(__('🌴 New Booking: %s', 'bestbalitravel'), $booking_data['tour_name']);

        $body = $this->get_template('admin-booking-notification', $booking_data);

        return wp_mail($to, $subject, $body);
    }

    /**
     * Send payment receipt
     */
    public function send_payment_receipt($payment_data)
    {
        $settings = get_option('bbt_settings', array());

        if (empty($settings['notify_customer_payment'])) {
            return false;
        }

        $to = $payment_data['customer_email'];
        $subject = sprintf(__('Payment Receipt - %s', 'bestbalitravel'), $payment_data['booking_id']);

        $body = $this->get_template('payment-receipt', $payment_data);

        return wp_mail($to, $subject, $body);
    }

    /**
     * Send tour reminder (1 day before)
     */
    public function send_tour_reminder($booking_data)
    {
        $settings = get_option('bbt_settings', array());

        if (empty($settings['notify_customer_reminder'])) {
            return false;
        }

        $to = $booking_data['customer_email'];
        $subject = sprintf(__('Reminder: Your %s tour is tomorrow!', 'bestbalitravel'), $booking_data['tour_name']);

        $body = $this->get_template('tour-reminder', $booking_data);

        return wp_mail($to, $subject, $body);
    }

    /**
     * Send review request (after tour)
     */
    public function send_review_request($booking_data)
    {
        $settings = get_option('bbt_settings', array());

        if (empty($settings['notify_customer_review_request'])) {
            return false;
        }

        $to = $booking_data['customer_email'];
        $subject = __('How was your Bali experience? Leave a review!', 'bestbalitravel');

        $body = $this->get_template('review-request', $booking_data);

        return wp_mail($to, $subject, $body);
    }

    /**
     * Get email template
     */
    private function get_template($template_name, $data)
    {
        $template_file = BBT_THEME_DIR . '/inc/email/templates/' . $template_name . '.php';

        if (file_exists($template_file)) {
            ob_start();
            extract($data);
            include $template_file;
            return ob_get_clean();
        }

        // Fallback: generate basic template
        return $this->generate_default_template($template_name, $data);
    }

    /**
     * Generate default email template
     */
    private function generate_default_template($template_name, $data)
    {
        $settings = get_option('bbt_settings', array());
        $logo = $settings['email_logo'] ?? '';
        $footer_text = $settings['email_footer_text'] ?? 'Thank you for choosing Best Bali Travel!';

        ob_start();
        ?>
        <!DOCTYPE html>
        <html>

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
        </head>

        <body style="margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f5f5f5;">
            <table width="100%" cellpadding="0" cellspacing="0" style="background: #f5f5f5; padding: 40px 20px;">
                <tr>
                    <td align="center">
                        <table width="600" cellpadding="0" cellspacing="0"
                            style="background: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.1);">
                            <!-- Header -->
                            <tr>
                                <td
                                    style="background: linear-gradient(135deg, #1e3a5f 0%, #2a5480 100%); padding: 30px; text-align: center;">
                                    <?php if ($logo): ?>
                                        <img src="<?php echo esc_url($logo); ?>" alt="Best Bali Travel"
                                            style="max-height: 50px; width: auto;">
                                    <?php else: ?>
                                        <h1 style="margin: 0; color: #f5a623; font-size: 24px;">🌴 Best Bali Travel</h1>
                                    <?php endif; ?>
                                </td>
                            </tr>

                            <!-- Content -->
                            <tr>
                                <td style="padding: 40px 30px;">
                                    <?php echo $this->render_template_content($template_name, $data); ?>
                                </td>
                            </tr>

                            <!-- Footer -->
                            <tr>
                                <td style="background: #f9f9f9; padding: 25px; text-align: center; border-top: 1px solid #eee;">
                                    <p style="margin: 0 0 15px; color: #666; font-size: 14px;">
                                        <?php echo esc_html($footer_text); ?>
                                    </p>
                                    <p style="margin: 0; font-size: 12px; color: #999;">
                                        ©
                                        <?php echo date('Y'); ?> Best Bali Travel. All rights reserved.
                                    </p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </body>

        </html>
        <?php
        return ob_get_clean();
    }

    /**
     * Render template content based on type
     */
    private function render_template_content($template_name, $data)
    {
        ob_start();

        switch ($template_name) {
            case 'booking-confirmation':
                ?>
                <h2 style="margin: 0 0 20px; color: #1e3a5f; font-size: 24px;">Booking Confirmed! 🎉</h2>
                <p style="color: #555; line-height: 1.6;">
                    Dear
                    <?php echo esc_html($data['customer_name']); ?>,<br><br>
                    Thank you for booking with Best Bali Travel! Your adventure awaits.
                </p>

                <div style="background: #f9f9f9; border-radius: 12px; padding: 25px; margin: 25px 0;">
                    <h3 style="margin: 0 0 15px; color: #1e3a5f;">Booking Details</h3>
                    <table width="100%" style="font-size: 14px; color: #555;">
                        <tr>
                            <td style="padding: 8px 0;"><strong>Booking ID:</strong></td>
                            <td style="padding: 8px 0; text-align: right;">
                                <?php echo esc_html($data['booking_id']); ?>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 8px 0;"><strong>Tour:</strong></td>
                            <td style="padding: 8px 0; text-align: right;">
                                <?php echo esc_html($data['tour_name']); ?>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 8px 0;"><strong>Date:</strong></td>
                            <td style="padding: 8px 0; text-align: right;">
                                <?php echo esc_html($data['tour_date']); ?>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 8px 0;"><strong>Guests:</strong></td>
                            <td style="padding: 8px 0; text-align: right;">
                                <?php echo esc_html($data['guests']); ?>
                            </td>
                        </tr>
                        <tr style="border-top: 2px solid #e0e0e0;">
                            <td style="padding: 15px 0; font-size: 16px;"><strong>Total:</strong></td>
                            <td style="padding: 15px 0; text-align: right; font-size: 20px; color: #f5a623; font-weight: bold;">
                                <?php echo esc_html($data['total_price']); ?>
                            </td>
                        </tr>
                    </table>
                </div>

                <p style="text-align: center;">
                    <a href="<?php echo esc_url(home_url()); ?>"
                        style="display: inline-block; background: #f5a623; color: #1e3a5f; padding: 12px 30px; border-radius: 30px; text-decoration: none; font-weight: 600;">View
                        Your Booking</a>
                </p>
                <?php
                break;

            case 'admin-booking-notification':
                ?>
                <h2 style="margin: 0 0 20px; color: #1e3a5f; font-size: 24px;">New Booking Received! 🌴</h2>
                <p style="color: #555;">A new booking has been made:</p>

                <div
                    style="background: #f0fdf4; border-left: 4px solid #10b981; padding: 20px; margin: 20px 0; border-radius: 0 8px 8px 0;">
                    <p style="margin: 0;"><strong>Tour:</strong>
                        <?php echo esc_html($data['tour_name']); ?>
                    </p>
                    <p style="margin: 10px 0 0;"><strong>Customer:</strong>
                        <?php echo esc_html($data['customer_name']); ?>
                    </p>
                    <p style="margin: 10px 0 0;"><strong>Email:</strong>
                        <?php echo esc_html($data['customer_email']); ?>
                    </p>
                    <p style="margin: 10px 0 0;"><strong>Date:</strong>
                        <?php echo esc_html($data['tour_date']); ?>
                    </p>
                    <p style="margin: 10px 0 0;"><strong>Guests:</strong>
                        <?php echo esc_html($data['guests']); ?>
                    </p>
                    <p style="margin: 10px 0 0; font-size: 18px; color: #10b981;"><strong>Total:</strong>
                        <?php echo esc_html($data['total_price']); ?>
                    </p>
                </div>

                <p style="text-align: center;">
                    <a href="<?php echo esc_url(admin_url('edit.php?post_type=bbt_booking')); ?>"
                        style="display: inline-block; background: #1e3a5f; color: #fff; padding: 12px 30px; border-radius: 30px; text-decoration: none; font-weight: 600;">View
                        in Dashboard</a>
                </p>
                <?php
                break;

            default:
                echo '<p>Email content</p>';
        }

        return ob_get_clean();
    }

    /**
     * AJAX: Send test email
     */
    public function ajax_send_test_email()
    {
        check_ajax_referer('bbt_admin_nonce', 'nonce');

        if (!current_user_can('manage_options')) {
            wp_send_json_error(array('message' => 'Unauthorized'));
        }

        $email = sanitize_email($_POST['email'] ?? '');

        if (!is_email($email)) {
            wp_send_json_error(array('message' => 'Invalid email address'));
        }

        $test_data = array(
            'customer_name' => 'Test Customer',
            'tour_name' => 'Mount Batur Sunrise Trek',
            'tour_date' => date('F j, Y', strtotime('+7 days')),
            'guests' => '2 Adults',
            'total_price' => 'Rp 1,500,000',
            'booking_id' => 'BBT-' . strtoupper(substr(md5(time()), 0, 8)),
        );

        $body = $this->generate_default_template('booking-confirmation', $test_data);
        $subject = '🧪 Test Email - Best Bali Travel';

        $sent = wp_mail($email, $subject, $body);

        if ($sent) {
            wp_send_json_success(array('message' => 'Test email sent!'));
        } else {
            wp_send_json_error(array('message' => 'Failed to send email. Check your mail server.'));
        }
    }
}

// Initialize
BBT_Email_Manager::get_instance();
