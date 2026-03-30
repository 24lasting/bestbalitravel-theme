<?php
/**
 * Template Tags
 *
 * @package BestBaliTravel
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Display Tour Card
 */
function bbt_tour_card($post_id = null, $size = 'default')
{
    if (!$post_id) {
        $post_id = get_the_ID();
    }

    $prices = bbt_get_tour_price($post_id);
    $duration = bbt_get_tour_duration($post_id);
    $rating = bbt_get_tour_rating($post_id);
    $locations = wp_get_post_terms($post_id, 'tour_location');
    $location_name = !empty($locations) ? $locations[0]->name : '';
    ?>
    <article class="bbt-tour-card bbt-card <?php echo esc_attr($size === 'small' ? 'bbt-card-small' : ''); ?>">
        <div class="bbt-card-image">
            <a href="<?php echo esc_url(get_permalink($post_id)); ?>">
                <?php if (has_post_thumbnail($post_id)): ?>
                    <?php echo get_the_post_thumbnail($post_id, 'bbt-tour-card'); ?>
                <?php else: ?>
                    <img src="<?php echo BBT_THEME_ASSETS; ?>/images/placeholder-tour.jpg"
                        alt="<?php echo esc_attr(get_the_title($post_id)); ?>">
                <?php endif; ?>
            </a>

            <?php if ($prices['sale']): ?>
                <span class="bbt-badge bbt-badge-sale">
                    <?php esc_html_e('Sale', 'bestbalitravel'); ?>
                </span>
            <?php endif; ?>
        </div>

        <div class="bbt-card-body">
            <h3 class="bbt-card-title">
                <a href="<?php echo esc_url(get_permalink($post_id)); ?>">
                    <?php echo esc_html(get_the_title($post_id)); ?>
                </a>
            </h3>

            <div class="bbt-card-meta">
                <?php echo bbt_display_rating_stars($rating['average'], true, $rating['count']); ?>
            </div>

            <div class="bbt-card-info">
                <?php if ($location_name): ?>
                    <span class="bbt-card-location">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                            <circle cx="12" cy="10" r="3"></circle>
                        </svg>
                        <?php echo esc_html($location_name); ?>
                    </span>
                <?php endif; ?>

                <span class="bbt-card-duration">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <polyline points="12 6 12 12 16 14"></polyline>
                    </svg>
                    <?php echo esc_html($duration['display']); ?>
                </span>
            </div>

            <div class="bbt-card-footer">
                <div class="bbt-card-price">
                    <?php if ($prices['sale']): ?>
                        <span class="bbt-price-was">
                            <?php echo bbt_format_price($prices['regular']); ?>
                        </span>
                    <?php endif; ?>
                    <span class="bbt-price-now">
                        <?php echo bbt_format_price($prices['current']); ?>
                    </span>
                    <span class="bbt-price-per">
                        <?php esc_html_e('/person', 'bestbalitravel'); ?>
                    </span>
                </div>

                <a href="<?php echo esc_url(get_permalink($post_id)); ?>" class="bbt-btn bbt-btn-primary bbt-btn-sm">
                    <?php esc_html_e('Book Now', 'bestbalitravel'); ?>
                </a>
            </div>
        </div>
    </article>
    <?php
}

/**
 * Display Location Card
 */
function bbt_location_card($term)
{
    $image_id = get_term_meta($term->term_id, 'location_image', true);
    $tour_count = $term->count;
    ?>
    <a href="<?php echo esc_url(get_term_link($term)); ?>" class="bbt-location-card">
        <div class="bbt-location-image">
            <?php if ($image_id): ?>
                <?php echo wp_get_attachment_image($image_id, 'bbt-tour-card'); ?>
            <?php else: ?>
                <img src="<?php echo BBT_THEME_ASSETS; ?>/images/placeholder-location.jpg"
                    alt="<?php echo esc_attr($term->name); ?>">
            <?php endif; ?>
            <div class="bbt-location-overlay"></div>
        </div>
        <div class="bbt-location-content">
            <h3 class="bbt-location-name">
                <?php echo esc_html($term->name); ?>
            </h3>
            <span class="bbt-location-count">
                <?php echo esc_html($tour_count); ?>
                <?php esc_html_e('Tours', 'bestbalitravel'); ?>
            </span>
        </div>
    </a>
    <?php
}

/**
 * Display Breadcrumbs
 */
function bbt_breadcrumbs()
{
    $separator = '<span class="bbt-breadcrumb-sep">/</span>';

    echo '<nav class="bbt-breadcrumbs" aria-label="' . esc_attr__('Breadcrumb', 'bestbalitravel') . '">';
    echo '<a href="' . esc_url(home_url('/')) . '">' . esc_html__('Home', 'bestbalitravel') . '</a>';

    if (is_singular('tour')) {
        $locations = wp_get_post_terms(get_the_ID(), 'tour_location');
        if (!empty($locations)) {
            echo $separator . '<a href="' . esc_url(get_term_link($locations[0])) . '">' . esc_html($locations[0]->name) . '</a>';
        }
        echo $separator . '<span>' . esc_html(get_the_title()) . '</span>';
    } elseif (is_post_type_archive('tour')) {
        echo $separator . '<span>' . esc_html__('Tours', 'bestbalitravel') . '</span>';
    } elseif (is_tax('tour_location')) {
        echo $separator . '<a href="' . esc_url(home_url('/tours/')) . '">' . esc_html__('Tours', 'bestbalitravel') . '</a>';
        echo $separator . '<span>' . single_term_title('', false) . '</span>';
    } elseif (is_page()) {
        echo $separator . '<span>' . esc_html(get_the_title()) . '</span>';
    }

    echo '</nav>';
}

/**
 * Display Tour Tabs Navigation
 */
function bbt_tour_tabs_nav($active = 'overview')
{
    $tabs = array(
        'overview' => __('Overview', 'bestbalitravel'),
        'itinerary' => __('Itinerary', 'bestbalitravel'),
        'includes' => __('What\'s Included', 'bestbalitravel'),
        'reviews' => __('Reviews', 'bestbalitravel'),
        'faq' => __('FAQ', 'bestbalitravel'),
    );
    ?>
    <nav class="bbt-tour-tabs">
        <ul class="bbt-tabs-nav">
            <?php foreach ($tabs as $id => $label): ?>
                <li>
                    <a href="#<?php echo esc_attr($id); ?>" class="bbt-tab-link <?php echo $active === $id ? 'active' : ''; ?>"
                        data-tab="<?php echo esc_attr($id); ?>">
                        <?php echo esc_html($label); ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </nav>
    <?php
}

/**
 * Display Booking Widget
 */
function bbt_booking_widget($post_id = null)
{
    if (!$post_id) {
        $post_id = get_the_ID();
    }

    $prices = bbt_get_tour_price($post_id);
    $rating = bbt_get_tour_rating($post_id);
    ?>
    <div class="bbt-booking-widget">
        <div class="bbt-booking-header">
            <div class="bbt-booking-price">
                <span class="bbt-price-label">
                    <?php esc_html_e('From', 'bestbalitravel'); ?>
                </span>
                <?php if ($prices['sale']): ?>
                    <span class="bbt-price-was">
                        <?php echo bbt_format_price($prices['regular']); ?>
                    </span>
                <?php endif; ?>
                <span class="bbt-price-amount">
                    <?php echo bbt_format_price($prices['current']); ?>
                </span>
                <span class="bbt-price-per">
                    <?php esc_html_e('/ person', 'bestbalitravel'); ?>
                </span>
            </div>

            <div class="bbt-booking-rating">
                <?php echo bbt_display_rating_stars($rating['average'], true, $rating['count']); ?>
            </div>
        </div>

        <form class="bbt-booking-form" id="bbt-booking-form" data-tour-id="<?php echo esc_attr($post_id); ?>">
            <?php wp_nonce_field('bbt_booking', 'bbt_booking_nonce'); ?>
            <input type="hidden" name="tour_id" value="<?php echo esc_attr($post_id); ?>">
            <input type="hidden" name="tour_price" value="<?php echo esc_attr($prices['current']); ?>">

            <div class="bbt-form-group">
                <label class="bbt-form-label">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                        <line x1="16" y1="2" x2="16" y2="6"></line>
                        <line x1="8" y1="2" x2="8" y2="6"></line>
                        <line x1="3" y1="10" x2="21" y2="10"></line>
                    </svg>
                    <?php esc_html_e('Select Date', 'bestbalitravel'); ?>
                </label>
                <input type="text" name="tour_date" class="bbt-form-input bbt-datepicker"
                    placeholder="<?php esc_attr_e('Choose date', 'bestbalitravel'); ?>" required>
            </div>

            <div class="bbt-form-group">
                <label class="bbt-form-label">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                    </svg>
                    <?php esc_html_e('Travelers', 'bestbalitravel'); ?>
                </label>

                <div class="bbt-travelers-group">
                    <div class="bbt-traveler-row">
                        <span class="bbt-traveler-label">
                            <?php esc_html_e('Adults', 'bestbalitravel'); ?>
                            <small>
                                <?php esc_html_e('(12+ years)', 'bestbalitravel'); ?>
                            </small>
                        </span>
                        <div class="bbt-qty-control">
                            <button type="button" class="bbt-qty-btn bbt-qty-minus" data-target="adults">-</button>
                            <input type="number" name="adults" id="adults" value="2" min="1" max="20" class="bbt-qty-input"
                                readonly>
                            <button type="button" class="bbt-qty-btn bbt-qty-plus" data-target="adults">+</button>
                        </div>
                    </div>

                    <div class="bbt-traveler-row">
                        <span class="bbt-traveler-label">
                            <?php esc_html_e('Children', 'bestbalitravel'); ?>
                            <small>
                                <?php esc_html_e('(2-11 years)', 'bestbalitravel'); ?>
                            </small>
                        </span>
                        <div class="bbt-qty-control">
                            <button type="button" class="bbt-qty-btn bbt-qty-minus" data-target="children">-</button>
                            <input type="number" name="children" id="children" value="0" min="0" max="10"
                                class="bbt-qty-input" readonly>
                            <button type="button" class="bbt-qty-btn bbt-qty-plus" data-target="children">+</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bbt-booking-total">
                <div class="bbt-total-row">
                    <span>
                        <?php esc_html_e('Total', 'bestbalitravel'); ?>
                    </span>
                    <span class="bbt-total-amount" id="bbt-total-amount">
                        <?php echo bbt_format_price($prices['current'] * 2); ?>
                    </span>
                </div>
            </div>

            <div class="bbt-booking-actions">
                <button type="button" class="bbt-btn bbt-btn-outline bbt-btn-block" id="bbt-add-to-cart">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="9" cy="21" r="1"></circle>
                        <circle cx="20" cy="21" r="1"></circle>
                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                    </svg>
                    <?php esc_html_e('Add to Cart', 'bestbalitravel'); ?>
                </button>

                <button type="submit" class="bbt-btn bbt-btn-primary bbt-btn-block">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                        <polyline points="22 4 12 14.01 9 11.01"></polyline>
                    </svg>
                    <?php esc_html_e('Book Now', 'bestbalitravel'); ?>
                </button>
            </div>

            <div class="bbt-booking-trust">
                <div class="bbt-trust-item">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                        <polyline points="22 4 12 14.01 9 11.01"></polyline>
                    </svg>
                    <?php esc_html_e('Free cancellation', 'bestbalitravel'); ?>
                </div>
                <div class="bbt-trust-item">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                        <polyline points="22 4 12 14.01 9 11.01"></polyline>
                    </svg>
                    <?php esc_html_e('Instant confirmation', 'bestbalitravel'); ?>
                </div>
            </div>
        </form>
    </div>
    <?php
}
