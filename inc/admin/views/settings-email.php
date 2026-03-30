<?php
/**
 * Email Settings Tab
 *
 * @package BestBaliTravel
 */

if (!defined('ABSPATH')) {
    exit;
}

$settings = get_option('bbt_settings', array());
?>

<div class="bbt-settings-section">
    <h2><?php esc_html_e('Email Settings', 'bestbalitravel'); ?></h2>
    <p class="description"><?php esc_html_e('Configure email notifications for bookings and inquiries.', 'bestbalitravel'); ?></p>
    
    <table class="form-table">
        <tr>
            <th scope="row">
                <label for="bbt_email_from_name"><?php esc_html_e('From Name', 'bestbalitravel'); ?></label>
            </th>
            <td>
                <input type="text" 
                       id="bbt_email_from_name" 
                       name="bbt_settings[email_from_name]" 
                       value="<?php echo esc_attr($settings['email_from_name'] ?? 'Best Bali Travel'); ?>" 
                       class="regular-text">
                <p class="description"><?php esc_html_e('Name that appears in the From field of emails.', 'bestbalitravel'); ?></p>
            </td>
        </tr>
        
        <tr>
            <th scope="row">
                <label for="bbt_email_from_address"><?php esc_html_e('From Email', 'bestbalitravel'); ?></label>
            </th>
            <td>
                <input type="email" 
                       id="bbt_email_from_address" 
                       name="bbt_settings[email_from_address]" 
                       value="<?php echo esc_attr($settings['email_from_address'] ?? 'noreply@bestbalitravel.com'); ?>" 
                       class="regular-text">
            </td>
        </tr>
        
        <tr>
            <th scope="row">
                <label for="bbt_booking_notification_email">
                    <?php esc_html_e('Booking Notification Email', 'bestbalitravel'); ?>
                </label>
            </th>
            <td>
                <input type="email" 
                       id="bbt_booking_notification_email" 
                       name="bbt_settings[booking_notification_email]" 
                       value="<?php echo esc_attr($settings['booking_notification_email'] ?? 'info@bestbalitravel.com'); ?>" 
                       class="regular-text">
                <p class="description">
                    <?php esc_html_e('All booking notifications will be sent to this email.', 'bestbalitravel'); ?>
                    <strong><?php esc_html_e('Default: info@bestbalitravel.com', 'bestbalitravel'); ?></strong>
                </p>
            </td>
        </tr>
    </table>
</div>

<div class="bbt-settings-section">
    <h2><?php esc_html_e('Email Notifications', 'bestbalitravel'); ?></h2>
    <p class="description"><?php esc_html_e('Enable or disable specific email notifications.', 'bestbalitravel'); ?></p>
    
    <div class="bbt-email-notifications">
        <!-- Admin Notifications -->
        <div class="bbt-notification-group">
            <h3><span class="dashicons dashicons-admin-users"></span> <?php esc_html_e('Admin Notifications', 'bestbalitravel'); ?></h3>
            
            <label class="bbt-notification-item">
                <input type="checkbox" 
                       name="bbt_settings[notify_admin_new_booking]" 
                       value="1" 
                       <?php checked($settings['notify_admin_new_booking'] ?? 1, 1); ?>>
                <span class="bbt-notification-content">
                    <strong><?php esc_html_e('New Booking', 'bestbalitravel'); ?></strong>
                    <small><?php esc_html_e('Receive email when a new booking is made', 'bestbalitravel'); ?></small>
                </span>
            </label>
            
            <label class="bbt-notification-item">
                <input type="checkbox" 
                       name="bbt_settings[notify_admin_payment]" 
                       value="1" 
                       <?php checked($settings['notify_admin_payment'] ?? 1, 1); ?>>
                <span class="bbt-notification-content">
                    <strong><?php esc_html_e('Payment Received', 'bestbalitravel'); ?></strong>
                    <small><?php esc_html_e('Receive email when payment is completed', 'bestbalitravel'); ?></small>
                </span>
            </label>
            
            <label class="bbt-notification-item">
                <input type="checkbox" 
                       name="bbt_settings[notify_admin_inquiry]" 
                       value="1" 
                       <?php checked($settings['notify_admin_inquiry'] ?? 1, 1); ?>>
                <span class="bbt-notification-content">
                    <strong><?php esc_html_e('New Inquiry', 'bestbalitravel'); ?></strong>
                    <small><?php esc_html_e('Receive email when contact form is submitted', 'bestbalitravel'); ?></small>
                </span>
            </label>
            
            <label class="bbt-notification-item">
                <input type="checkbox" 
                       name="bbt_settings[notify_admin_review]" 
                       value="1" 
                       <?php checked($settings['notify_admin_review'] ?? 1, 1); ?>>
                <span class="bbt-notification-content">
                    <strong><?php esc_html_e('New Review', 'bestbalitravel'); ?></strong>
                    <small><?php esc_html_e('Receive email when a review is submitted', 'bestbalitravel'); ?></small>
                </span>
            </label>
        </div>
        
        <!-- Customer Notifications -->
        <div class="bbt-notification-group">
            <h3><span class="dashicons dashicons-groups"></span> <?php esc_html_e('Customer Notifications', 'bestbalitravel'); ?></h3>
            
            <label class="bbt-notification-item">
                <input type="checkbox" 
                       name="bbt_settings[notify_customer_booking]" 
                       value="1" 
                       <?php checked($settings['notify_customer_booking'] ?? 1, 1); ?>>
                <span class="bbt-notification-content">
                    <strong><?php esc_html_e('Booking Confirmation', 'bestbalitravel'); ?></strong>
                    <small><?php esc_html_e('Send confirmation email to customer after booking', 'bestbalitravel'); ?></small>
                </span>
            </label>
            
            <label class="bbt-notification-item">
                <input type="checkbox" 
                       name="bbt_settings[notify_customer_payment]" 
                       value="1" 
                       <?php checked($settings['notify_customer_payment'] ?? 1, 1); ?>>
                <span class="bbt-notification-content">
                    <strong><?php esc_html_e('Payment Receipt', 'bestbalitravel'); ?></strong>
                    <small><?php esc_html_e('Send payment receipt to customer', 'bestbalitravel'); ?></small>
                </span>
            </label>
            
            <label class="bbt-notification-item">
                <input type="checkbox" 
                       name="bbt_settings[notify_customer_reminder]" 
                       value="1" 
                       <?php checked($settings['notify_customer_reminder'] ?? 1, 1); ?>>
                <span class="bbt-notification-content">
                    <strong><?php esc_html_e('Tour Reminder', 'bestbalitravel'); ?></strong>
                    <small><?php esc_html_e('Send reminder 1 day before the tour', 'bestbalitravel'); ?></small>
                </span>
            </label>
            
            <label class="bbt-notification-item">
                <input type="checkbox" 
                       name="bbt_settings[notify_customer_review_request]" 
                       value="1" 
                       <?php checked($settings['notify_customer_review_request'] ?? 1, 1); ?>>
                <span class="bbt-notification-content">
                    <strong><?php esc_html_e('Review Request', 'bestbalitravel'); ?></strong>
                    <small><?php esc_html_e('Ask customer to leave a review after tour', 'bestbalitravel'); ?></small>
                </span>
            </label>
        </div>
    </div>
</div>

<div class="bbt-settings-section">
    <h2><?php esc_html_e('Email Template', 'bestbalitravel'); ?></h2>
    
    <table class="form-table">
        <tr>
            <th scope="row">
                <label for="bbt_email_logo"><?php esc_html_e('Email Logo', 'bestbalitravel'); ?></label>
            </th>
            <td>
                <div class="bbt-media-upload">
                    <input type="hidden" 
                           id="bbt_email_logo" 
                           name="bbt_settings[email_logo]" 
                           value="<?php echo esc_attr($settings['email_logo'] ?? ''); ?>">
                    <button type="button" class="button bbt-upload-logo"><?php esc_html_e('Upload Logo', 'bestbalitravel'); ?></button>
                    <div class="bbt-logo-preview">
                        <?php if (!empty($settings['email_logo'])) : ?>
                            <img src="<?php echo esc_url($settings['email_logo']); ?>" alt="Email Logo">
                        <?php endif; ?>
                    </div>
                </div>
            </td>
        </tr>
        
        <tr>
            <th scope="row">
                <label for="bbt_email_footer_text"><?php esc_html_e('Email Footer Text', 'bestbalitravel'); ?></label>
            </th>
            <td>
                <textarea id="bbt_email_footer_text" 
                          name="bbt_settings[email_footer_text]" 
                          rows="3" 
                          class="large-text"><?php echo esc_textarea($settings['email_footer_text'] ?? 'Thank you for choosing Best Bali Travel! Have a wonderful trip.'); ?></textarea>
            </td>
        </tr>
    </table>
</div>

<div class="bbt-settings-section">
    <h2><?php esc_html_e('Test Email', 'bestbalitravel'); ?></h2>
    
    <p class="description"><?php esc_html_e('Send a test email to verify your email settings.', 'bestbalitravel'); ?></p>
    
    <div class="bbt-test-email">
        <input type="email" 
               id="bbt_test_email_address" 
               placeholder="test@example.com" 
               class="regular-text"
               value="<?php echo esc_attr(get_option('admin_email')); ?>">
        <button type="button" class="button button-secondary" id="bbt-send-test-email">
            <span class="dashicons dashicons-email"></span>
            <?php esc_html_e('Send Test Email', 'bestbalitravel'); ?>
        </button>
        <span id="bbt-test-email-status"></span>
    </div>
</div>

<style>
.bbt-email-notifications {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    margin-top: 15px;
}

.bbt-notification-group {
    background: #fff;
    border: 1px solid #e0e0e0;
    border-radius: 10px;
    padding: 20px;
}

.bbt-notification-group h3 {
    display: flex;
    align-items: center;
    gap: 8px;
    margin: 0 0 15px;
    padding-bottom: 10px;
    border-bottom: 1px solid #eee;
    font-size: 16px;
    color: #1e3a5f;
}

.bbt-notification-item {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    padding: 12px;
    margin-bottom: 8px;
    background: #f9f9f9;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.2s;
}

.bbt-notification-item:hover {
    background: #f0f0f0;
}

.bbt-notification-item input[type="checkbox"] {
    margin-top: 3px;
}

.bbt-notification-content {
    display: flex;
    flex-direction: column;
}

.bbt-notification-content strong {
    font-weight: 500;
}

.bbt-notification-content small {
    color: #666;
    font-size: 12px;
    margin-top: 2px;
}

.bbt-test-email {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-top: 10px;
}

.bbt-test-email .button {
    display: flex;
    align-items: center;
    gap: 5px;
}

#bbt-test-email-status {
    font-size: 13px;
}

.bbt-media-upload {
    display: flex;
    align-items: center;
    gap: 15px;
}

.bbt-logo-preview img {
    max-height: 50px;
    width: auto;
}

@media (max-width: 1200px) {
    .bbt-email-notifications {
        grid-template-columns: 1fr;
    }
}
</style>

<script>
jQuery(document).ready(function($) {
    // Test email
    $('#bbt-send-test-email').on('click', function() {
        var $btn = $(this);
        var $status = $('#bbt-test-email-status');
        var email = $('#bbt_test_email_address').val();
        
        if (!email) {
            $status.css('color', 'red').text('Please enter an email address');
            return;
        }
        
        $btn.prop('disabled', true);
        $status.css('color', '#666').text('Sending...');
        
        $.ajax({
            url: ajaxurl,
            type: 'POST',
            data: {
                action: 'bbt_send_test_email',
                email: email,
                nonce: '<?php echo wp_create_nonce('bbt_admin_nonce'); ?>'
            },
            success: function(response) {
                if (response.success) {
                    $status.css('color', 'green').text('✓ Test email sent successfully!');
                } else {
                    $status.css('color', 'red').text('✗ Failed: ' + response.data.message);
                }
            },
            error: function() {
                $status.css('color', 'red').text('✗ Error sending email');
            },
            complete: function() {
                $btn.prop('disabled', false);
            }
        });
    });
});
</script>
