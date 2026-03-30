<?php
/**
 * AJAX Handlers
 *
 * @package BestBaliTravel
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Filter Tours AJAX
 */
function bbt_ajax_filter_tours()
{
    check_ajax_referer('bbt_nonce', 'nonce');

    $args = array(
        'post_type' => 'tour',
        'posts_per_page' => isset($_POST['per_page']) ? intval($_POST['per_page']) : 12,
        'paged' => isset($_POST['page']) ? intval($_POST['page']) : 1,
    );

    // Location filter
    if (!empty($_POST['location'])) {
        $args['tax_query'][] = array(
            'taxonomy' => 'tour_location',
            'field' => 'slug',
            'terms' => sanitize_text_field($_POST['location']),
        );
    }

    // Type filter
    if (!empty($_POST['type'])) {
        $args['tax_query'][] = array(
            'taxonomy' => 'tour_type',
            'field' => 'slug',
            'terms' => sanitize_text_field($_POST['type']),
        );
    }

    // Duration filter
    if (!empty($_POST['duration'])) {
        $args['tax_query'][] = array(
            'taxonomy' => 'tour_duration',
            'field' => 'slug',
            'terms' => sanitize_text_field($_POST['duration']),
        );
    }

    // Price range filter
    if (!empty($_POST['min_price']) || !empty($_POST['max_price'])) {
        $args['meta_query'][] = array(
            'key' => '_bbt_tour_price',
            'value' => array(
                intval($_POST['min_price']) ?: 0,
                intval($_POST['max_price']) ?: 999999999,
            ),
            'type' => 'NUMERIC',
            'compare' => 'BETWEEN',
        );
    }

    // Sorting
    if (!empty($_POST['orderby'])) {
        switch ($_POST['orderby']) {
            case 'price_low':
                $args['meta_key'] = '_bbt_tour_price';
                $args['orderby'] = 'meta_value_num';
                $args['order'] = 'ASC';
                break;
            case 'price_high':
                $args['meta_key'] = '_bbt_tour_price';
                $args['orderby'] = 'meta_value_num';
                $args['order'] = 'DESC';
                break;
            case 'name':
                $args['orderby'] = 'title';
                $args['order'] = 'ASC';
                break;
            case 'date':
            default:
                $args['orderby'] = 'date';
                $args['order'] = 'DESC';
                break;
        }
    }

    $query = new WP_Query($args);

    ob_start();

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            bbt_tour_card();
        }
    } else {
        echo '<div class="bbt-no-results">';
        echo '<p>' . esc_html__('No tours found matching your criteria.', 'bestbalitravel') . '</p>';
        echo '</div>';
    }

    $html = ob_get_clean();

    wp_send_json_success(array(
        'html' => $html,
        'found' => $query->found_posts,
        'max_pages' => $query->max_num_pages,
    ));

    wp_reset_postdata();
    wp_die();
}
add_action('wp_ajax_bbt_filter_tours', 'bbt_ajax_filter_tours');
add_action('wp_ajax_nopriv_bbt_filter_tours', 'bbt_ajax_filter_tours');

/**
 * Search Tours AJAX
 */
function bbt_ajax_search_tours()
{
    check_ajax_referer('bbt_nonce', 'nonce');

    $search = isset($_POST['search']) ? sanitize_text_field($_POST['search']) : '';

    if (strlen($search) < 2) {
        wp_send_json_success(array('results' => array()));
        wp_die();
    }

    $args = array(
        'post_type' => 'tour',
        'posts_per_page' => 5,
        's' => $search,
    );

    $query = new WP_Query($args);
    $results = array();

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $prices = bbt_get_tour_price();
            $locations = wp_get_post_terms(get_the_ID(), 'tour_location');

            $results[] = array(
                'id' => get_the_ID(),
                'title' => get_the_title(),
                'url' => get_permalink(),
                'image' => get_the_post_thumbnail_url(get_the_ID(), 'thumbnail'),
                'price' => bbt_format_price($prices['current']),
                'location' => !empty($locations) ? $locations[0]->name : '',
            );
        }
    }

    wp_send_json_success(array('results' => $results));
    wp_reset_postdata();
    wp_die();
}
add_action('wp_ajax_bbt_search_tours', 'bbt_ajax_search_tours');
add_action('wp_ajax_nopriv_bbt_search_tours', 'bbt_ajax_search_tours');

/**
 * Add to Cart AJAX
 */
function bbt_ajax_add_to_cart()
{
    check_ajax_referer('bbt_nonce', 'nonce');

    // Check if WooCommerce is active
    if (!class_exists('WooCommerce')) {
        wp_send_json_error(array('message' => __('WooCommerce is not active', 'bestbalitravel')));
        wp_die();
    }

    $tour_id = isset($_POST['tour_id']) ? intval($_POST['tour_id']) : 0;
    $product_id = get_post_meta($tour_id, '_bbt_wc_product_id', true);

    if (!$product_id) {
        // Create WC product if not exists
        $tour = get_post($tour_id);
        $prices = bbt_get_tour_price($tour_id);

        $product = new WC_Product_Simple();
        $product->set_name($tour->post_title);
        $product->set_regular_price($prices['regular']);
        if ($prices['sale']) {
            $product->set_sale_price($prices['sale']);
        }
        $product->set_status('publish');
        $product->set_catalog_visibility('hidden');
        $product->set_virtual(true);
        $product_id = $product->save();

        update_post_meta($tour_id, '_bbt_wc_product_id', $product_id);
    }

    $cart_item_data = array(
        'tour_id' => $tour_id,
        'tour_date' => isset($_POST['tour_date']) ? sanitize_text_field($_POST['tour_date']) : '',
        'adults' => isset($_POST['adults']) ? intval($_POST['adults']) : 1,
        'children' => isset($_POST['children']) ? intval($_POST['children']) : 0,
    );

    $quantity = $cart_item_data['adults'] + $cart_item_data['children'];

    $cart_item_key = WC()->cart->add_to_cart($product_id, $quantity, 0, array(), $cart_item_data);

    if ($cart_item_key) {
        wp_send_json_success(array(
            'message' => __('Tour added to cart!', 'bestbalitravel'),
            'cart_count' => WC()->cart->get_cart_contents_count(),
            'cart_url' => wc_get_cart_url(),
        ));
    } else {
        wp_send_json_error(array('message' => __('Could not add to cart', 'bestbalitravel')));
    }

    wp_die();
}
add_action('wp_ajax_bbt_add_to_cart', 'bbt_ajax_add_to_cart');
add_action('wp_ajax_nopriv_bbt_add_to_cart', 'bbt_ajax_add_to_cart');

/**
 * Submit Review AJAX
 */
function bbt_ajax_submit_review()
{
    check_ajax_referer('bbt_nonce', 'nonce');

    if (!is_user_logged_in()) {
        wp_send_json_error(array('message' => __('Please log in to submit a review', 'bestbalitravel')));
        wp_die();
    }

    $tour_id = isset($_POST['tour_id']) ? intval($_POST['tour_id']) : 0;
    $rating = isset($_POST['rating']) ? intval($_POST['rating']) : 5;
    $review = isset($_POST['review']) ? sanitize_textarea_field($_POST['review']) : '';

    if (!$tour_id || !$review) {
        wp_send_json_error(array('message' => __('Please fill all required fields', 'bestbalitravel')));
        wp_die();
    }

    $user = wp_get_current_user();

    $review_id = wp_insert_post(array(
        'post_type' => 'review',
        'post_title' => sprintf(__('Review for %s', 'bestbalitravel'), get_the_title($tour_id)),
        'post_content' => $review,
        'post_status' => 'pending',
        'post_author' => $user->ID,
    ));

    if ($review_id) {
        update_post_meta($review_id, '_bbt_review_tour_id', $tour_id);
        update_post_meta($review_id, '_bbt_review_rating', $rating);
        update_post_meta($review_id, '_bbt_review_author_name', $user->display_name);

        wp_send_json_success(array('message' => __('Thank you! Your review has been submitted for approval.', 'bestbalitravel')));
    } else {
        wp_send_json_error(array('message' => __('Error submitting review', 'bestbalitravel')));
    }

    wp_die();
}
add_action('wp_ajax_bbt_submit_review', 'bbt_ajax_submit_review');

/**
 * Newsletter Subscribe AJAX
 */
function bbt_ajax_newsletter_subscribe()
{
    check_ajax_referer('bbt_nonce', 'nonce');

    $email = isset($_POST['email']) ? sanitize_email($_POST['email']) : '';

    if (!is_email($email)) {
        wp_send_json_error(array('message' => __('Please enter a valid email address', 'bestbalitravel')));
        wp_die();
    }

    // Store in options (for simple implementation)
    $subscribers = get_option('bbt_newsletter_subscribers', array());

    if (in_array($email, $subscribers)) {
        wp_send_json_error(array('message' => __('You are already subscribed!', 'bestbalitravel')));
        wp_die();
    }

    $subscribers[] = $email;
    update_option('bbt_newsletter_subscribers', $subscribers);

    wp_send_json_success(array('message' => __('Thank you for subscribing!', 'bestbalitravel')));
    wp_die();
}
add_action('wp_ajax_bbt_newsletter_subscribe', 'bbt_ajax_newsletter_subscribe');
add_action('wp_ajax_nopriv_bbt_newsletter_subscribe', 'bbt_ajax_newsletter_subscribe');
