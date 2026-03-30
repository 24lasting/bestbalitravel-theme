<?php
/**
 * Contact Page Template
 *
 * Template Name: Contact Page
 *
 * @package BestBaliTravel
 */

get_header();
?>

<main id="main" class="site-main page-contact">

    <!-- Page Header -->
    <section class="bbt-page-header">
        <div class="bbt-container">
            <h1 class="bbt-page-title">
                <?php esc_html_e('Contact Us', 'bestbalitravel'); ?>
            </h1>
            <?php bbt_breadcrumbs(); ?>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="bbt-section bbt-contact-section">
        <div class="bbt-container">
            <div class="bbt-contact-grid">

                <!-- Contact Form -->
                <div class="bbt-contact-form-wrapper">
                    <h2>
                        <?php esc_html_e('Send Us a Message', 'bestbalitravel'); ?>
                    </h2>
                    <p class="bbt-contact-intro">
                        <?php esc_html_e('Have questions about our tours? Fill out the form below and we\'ll get back to you within 24 hours.', 'bestbalitravel'); ?>
                    </p>

                    <form class="bbt-contact-form" id="bbt-contact-form"
                        action="<?php echo esc_url(admin_url('admin-ajax.php')); ?>" method="post">
                        <?php wp_nonce_field('bbt_contact', 'contact_nonce'); ?>
                        <input type="hidden" name="action" value="bbt_contact_form">

                        <div class="bbt-form-row">
                            <div class="bbt-form-group">
                                <label class="bbt-form-label" for="contact_name">
                                    <?php esc_html_e('Your Name', 'bestbalitravel'); ?> *
                                </label>
                                <input type="text" name="contact_name" id="contact_name" class="bbt-form-input"
                                    required>
                            </div>

                            <div class="bbt-form-group">
                                <label class="bbt-form-label" for="contact_email">
                                    <?php esc_html_e('Email Address', 'bestbalitravel'); ?> *
                                </label>
                                <input type="email" name="contact_email" id="contact_email" class="bbt-form-input"
                                    required>
                            </div>
                        </div>

                        <div class="bbt-form-row">
                            <div class="bbt-form-group">
                                <label class="bbt-form-label" for="contact_phone">
                                    <?php esc_html_e('Phone / WhatsApp', 'bestbalitravel'); ?>
                                </label>
                                <input type="tel" name="contact_phone" id="contact_phone" class="bbt-form-input">
                            </div>

                            <div class="bbt-form-group">
                                <label class="bbt-form-label" for="contact_subject">
                                    <?php esc_html_e('Subject', 'bestbalitravel'); ?> *
                                </label>
                                <select name="contact_subject" id="contact_subject" class="bbt-form-select" required>
                                    <option value="">
                                        <?php esc_html_e('Select a subject', 'bestbalitravel'); ?>
                                    </option>
                                    <option value="tour-inquiry">
                                        <?php esc_html_e('Tour Inquiry', 'bestbalitravel'); ?>
                                    </option>
                                    <option value="booking-question">
                                        <?php esc_html_e('Booking Question', 'bestbalitravel'); ?>
                                    </option>
                                    <option value="custom-tour">
                                        <?php esc_html_e('Custom Tour Request', 'bestbalitravel'); ?>
                                    </option>
                                    <option value="partnership">
                                        <?php esc_html_e('Partnership / Business', 'bestbalitravel'); ?>
                                    </option>
                                    <option value="other">
                                        <?php esc_html_e('Other', 'bestbalitravel'); ?>
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="bbt-form-group">
                            <label class="bbt-form-label" for="contact_message">
                                <?php esc_html_e('Your Message', 'bestbalitravel'); ?> *
                            </label>
                            <textarea name="contact_message" id="contact_message" class="bbt-form-textarea" rows="5"
                                required></textarea>
                        </div>

                        <div class="bbt-form-actions">
                            <button type="submit" class="bbt-btn bbt-btn-primary bbt-btn-lg">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <line x1="22" y1="2" x2="11" y2="13"></line>
                                    <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                                </svg>
                                <?php esc_html_e('Send Message', 'bestbalitravel'); ?>
                            </button>
                        </div>

                        <div class="bbt-form-message" id="bbt-form-message"></div>
                    </form>
                </div>

                <!-- Contact Info -->
                <div class="bbt-contact-info-wrapper">
                    <div class="bbt-contact-card">
                        <h3>
                            <?php esc_html_e('Get in Touch', 'bestbalitravel'); ?>
                        </h3>

                        <ul class="bbt-contact-list">
                            <li>
                                <div class="bbt-contact-icon">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                                        <path
                                            d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                                    </svg>
                                </div>
                                <div class="bbt-contact-text">
                                    <strong>
                                        <?php esc_html_e('WhatsApp', 'bestbalitravel'); ?>
                                    </strong>
                                    <a
                                        href="https://wa.me/<?php echo preg_replace('/[^0-9]/', '', get_theme_mod('bbt_whatsapp_number', '+6287854806011')); ?>">
                                        <?php echo esc_html(get_theme_mod('bbt_whatsapp_number', '+62 878 5480 6011')); ?>
                                    </a>
                                </div>
                            </li>

                            <li>
                                <div class="bbt-contact-icon">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2">
                                        <path
                                            d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z">
                                        </path>
                                        <polyline points="22,6 12,13 2,6"></polyline>
                                    </svg>
                                </div>
                                <div class="bbt-contact-text">
                                    <strong>
                                        <?php esc_html_e('Email', 'bestbalitravel'); ?>
                                    </strong>
                                    <a
                                        href="mailto:<?php echo esc_attr(get_theme_mod('bbt_email', 'info@bestbalitravel.com')); ?>">
                                        <?php echo esc_html(get_theme_mod('bbt_email', 'info@bestbalitravel.com')); ?>
                                    </a>
                                </div>
                            </li>

                            <li>
                                <div class="bbt-contact-icon">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2">
                                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                        <circle cx="12" cy="10" r="3"></circle>
                                    </svg>
                                </div>
                                <div class="bbt-contact-text">
                                    <strong>
                                        <?php esc_html_e('Address', 'bestbalitravel'); ?>
                                    </strong>
                                    <span>
                                        <?php echo esc_html(get_theme_mod('bbt_address', 'Bali, Indonesia')); ?>
                                    </span>
                                </div>
                            </li>
                        </ul>

                        <!-- Quick WhatsApp CTA -->
                        <div class="bbt-contact-cta">
                            <p>
                                <?php esc_html_e('Prefer instant messaging?', 'bestbalitravel'); ?>
                            </p>
                            <a href="https://wa.me/<?php echo preg_replace('/[^0-9]/', '', get_theme_mod('bbt_whatsapp_number', '+6287854806011')); ?>?text=<?php echo urlencode(__('Hi! I have a question about your tours.', 'bestbalitravel')); ?>"
                                class="bbt-btn bbt-btn-whatsapp bbt-btn-block" target="_blank">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                    <path
                                        d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                                </svg>
                                <?php esc_html_e('Chat on WhatsApp', 'bestbalitravel'); ?>
                            </a>
                        </div>
                    </div>

                    <!-- Business Hours -->
                    <div class="bbt-hours-card">
                        <h4>
                            <?php esc_html_e('Business Hours', 'bestbalitravel'); ?>
                        </h4>
                        <ul class="bbt-hours-list">
                            <li>
                                <span>
                                    <?php esc_html_e('Monday - Friday', 'bestbalitravel'); ?>
                                </span>
                                <span>08:00 - 20:00 WITA</span>
                            </li>
                            <li>
                                <span>
                                    <?php esc_html_e('Saturday', 'bestbalitravel'); ?>
                                </span>
                                <span>08:00 - 18:00 WITA</span>
                            </li>
                            <li>
                                <span>
                                    <?php esc_html_e('Sunday', 'bestbalitravel'); ?>
                                </span>
                                <span>09:00 - 17:00 WITA</span>
                            </li>
                        </ul>
                        <p class="bbt-hours-note">
                            <?php esc_html_e('WhatsApp support available 24/7 for urgent inquiries.', 'bestbalitravel'); ?>
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Google Maps Section -->
    <section class="bbt-section bbt-map-section">
        <div class="bbt-container">
            <div class="bbt-section-header">
                <h2>
                    <?php esc_html_e('Find Us', 'bestbalitravel'); ?>
                </h2>
            </div>

            <div class="bbt-map-wrapper">
                <?php
                $map_embed = get_theme_mod('bbt_google_maps_embed', '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d252621.38841455846!2d115.08826024843752!3d-8.455553249999991!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd23d739f22c9c3%3A0x54a1ec47a6e5fa2!2sBali%2C%20Indonesia!5e0!3m2!1sen!2sus!4v1695000000000!5m2!1sen!2sus" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>');
                echo $map_embed;
                ?>
            </div>
        </div>
    </section>

</main>

<style>
    /* Contact Page Styles */
    .bbt-contact-grid {
        display: grid;
        grid-template-columns: 1fr 400px;
        gap: var(--bbt-space-10);
    }

    .bbt-contact-form-wrapper h2 {
        margin-bottom: var(--bbt-space-3);
    }

    .bbt-contact-intro {
        color: var(--bbt-gray-600);
        margin-bottom: var(--bbt-space-6);
    }

    .bbt-form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: var(--bbt-space-4);
    }

    .bbt-form-textarea {
        width: 100%;
        padding: var(--bbt-space-3) var(--bbt-space-4);
        font-size: var(--bbt-text-base);
        border: 2px solid var(--bbt-gray-200);
        border-radius: var(--bbt-radius-lg);
        resize: vertical;
        min-height: 120px;
    }

    .bbt-form-textarea:focus {
        outline: none;
        border-color: var(--bbt-primary);
    }

    .bbt-form-actions {
        margin-top: var(--bbt-space-4);
    }

    .bbt-form-message {
        margin-top: var(--bbt-space-4);
    }

    .bbt-form-message .success {
        color: var(--bbt-success);
    }

    .bbt-form-message .error {
        color: var(--bbt-error);
    }

    .bbt-contact-card {
        background: var(--bbt-white);
        border-radius: var(--bbt-radius-xl);
        padding: var(--bbt-space-6);
        box-shadow: var(--bbt-shadow-md);
        margin-bottom: var(--bbt-space-6);
    }

    .bbt-contact-card h3 {
        margin-bottom: var(--bbt-space-5);
    }

    .bbt-contact-list {
        display: flex;
        flex-direction: column;
        gap: var(--bbt-space-5);
        margin-bottom: var(--bbt-space-6);
    }

    .bbt-contact-list li {
        display: flex;
        gap: var(--bbt-space-4);
    }

    .bbt-contact-icon {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(245, 166, 35, 0.1);
        color: var(--bbt-primary);
        border-radius: var(--bbt-radius-lg);
        flex-shrink: 0;
    }

    .bbt-contact-text strong {
        display: block;
        margin-bottom: var(--bbt-space-1);
    }

    .bbt-contact-text a,
    .bbt-contact-text span {
        color: var(--bbt-gray-600);
    }

    .bbt-contact-text a:hover {
        color: var(--bbt-primary);
    }

    .bbt-contact-cta {
        padding-top: var(--bbt-space-5);
        border-top: 1px solid var(--bbt-gray-100);
    }

    .bbt-contact-cta p {
        margin-bottom: var(--bbt-space-3);
        color: var(--bbt-gray-600);
        text-align: center;
    }

    .bbt-hours-card {
        background: var(--bbt-gray-50);
        border-radius: var(--bbt-radius-xl);
        padding: var(--bbt-space-5);
    }

    .bbt-hours-card h4 {
        margin-bottom: var(--bbt-space-4);
    }

    .bbt-hours-list {
        display: flex;
        flex-direction: column;
        gap: var(--bbt-space-2);
    }

    .bbt-hours-list li {
        display: flex;
        justify-content: space-between;
        padding: var(--bbt-space-2) 0;
        border-bottom: 1px solid var(--bbt-gray-200);
    }

    .bbt-hours-list li:last-child {
        border-bottom: none;
    }

    .bbt-hours-note {
        margin-top: var(--bbt-space-4);
        font-size: var(--bbt-text-sm);
        color: var(--bbt-gray-500);
    }

    .bbt-map-wrapper {
        border-radius: var(--bbt-radius-xl);
        overflow: hidden;
        box-shadow: var(--bbt-shadow-md);
    }

    .bbt-map-wrapper iframe {
        display: block;
        width: 100%;
    }

    @media (max-width: 1024px) {
        .bbt-contact-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 640px) {
        .bbt-form-row {
            grid-template-columns: 1fr;
        }
    }
</style>

<?php
get_footer();
