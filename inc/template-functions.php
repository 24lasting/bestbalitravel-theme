<?php
/**
 * Template Functions
 *
 * @package BestBaliTravel
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Get Tour Price
 */
function bbt_get_tour_price($post_id = null)
{
    if (!$post_id) {
        $post_id = get_the_ID();
    }

    $price = get_post_meta($post_id, '_bbt_tour_price', true);
    $sale_price = get_post_meta($post_id, '_bbt_tour_sale_price', true);

    if ($sale_price && $sale_price < $price) {
        return array(
            'regular' => floatval($price),
            'sale' => floatval($sale_price),
            'current' => floatval($sale_price),
        );
    }

    return array(
        'regular' => floatval($price),
        'sale' => null,
        'current' => floatval($price),
    );
}

/**
 * Format Price
 */
function bbt_format_price($price, $currency = 'IDR')
{
    if ($currency === 'IDR') {
        return 'Rp ' . number_format($price, 0, ',', '.');
    }
    return '$' . number_format($price, 2);
}

/**
 * Display Tour Price
 */
function bbt_display_tour_price($post_id = null)
{
    $prices = bbt_get_tour_price($post_id);

    $html = '<div class="bbt-price">';
    if ($prices['sale']) {
        $html .= '<span class="bbt-price-regular"><del>' . bbt_format_price($prices['regular']) . '</del></span> ';
        $html .= '<span class="bbt-price-sale">' . bbt_format_price($prices['sale']) . '</span>';
    } else {
        $html .= '<span class="bbt-price-current">' . bbt_format_price($prices['regular']) . '</span>';
    }
    $html .= '<span class="bbt-price-per"> / ' . __('person', 'bestbalitravel') . '</span>';
    $html .= '</div>';

    return $html;
}

/**
 * Get Tour Duration
 */
function bbt_get_tour_duration($post_id = null)
{
    if (!$post_id) {
        $post_id = get_the_ID();
    }

    $duration = get_post_meta($post_id, '_bbt_tour_duration', true);
    $unit = get_post_meta($post_id, '_bbt_tour_duration_unit', true);

    if (!$unit) {
        $unit = 'hours';
    }

    return array(
        'value' => intval($duration),
        'unit' => $unit,
        'display' => $duration . ' ' . ($unit === 'hours' ? __('Hours', 'bestbalitravel') : __('Days', 'bestbalitravel')),
    );
}

/**
 * Get Tour Rating
 */
function bbt_get_tour_rating($post_id = null)
{
    if (!$post_id) {
        $post_id = get_the_ID();
    }

    // Get average rating from reviews or meta
    $rating = get_post_meta($post_id, '_bbt_tour_rating', true);
    $count = get_post_meta($post_id, '_bbt_tour_review_count', true);

    return array(
        'average' => $rating ? floatval($rating) : 4.8,
        'count' => $count ? intval($count) : 0,
    );
}

/**
 * Display Rating Stars
 */
function bbt_display_rating_stars($rating, $show_count = true, $count = 0)
{
    $full_stars = floor($rating);
    $half_star = ($rating - $full_stars) >= 0.5;
    $empty_stars = 5 - $full_stars - ($half_star ? 1 : 0);

    $html = '<div class="bbt-rating">';

    // Full stars
    for ($i = 0; $i < $full_stars; $i++) {
        $html .= '<span class="bbt-rating-star">★</span>';
    }

    // Half star
    if ($half_star) {
        $html .= '<span class="bbt-rating-star half">★</span>';
    }

    // Empty stars
    for ($i = 0; $i < $empty_stars; $i++) {
        $html .= '<span class="bbt-rating-star empty">☆</span>';
    }

    $html .= '<span class="bbt-rating-value">' . number_format($rating, 1) . '</span>';

    if ($show_count && $count > 0) {
        $html .= '<span class="bbt-rating-count">(' . $count . ' ' . __('reviews', 'bestbalitravel') . ')</span>';
    }

    $html .= '</div>';

    return $html;
}

/**
 * Get Tour Gallery
 */
function bbt_get_tour_gallery($post_id = null)
{
    if (!$post_id) {
        $post_id = get_the_ID();
    }

    $gallery = get_post_meta($post_id, '_bbt_tour_gallery', true);

    if (!$gallery) {
        return array();
    }

    // Handle if already an array
    if (is_array($gallery)) {
        return $gallery;
    }

    return explode(',', $gallery);
}

/**
 * Get Tour Itinerary
 */
function bbt_get_tour_itinerary($post_id = null)
{
    if (!$post_id) {
        $post_id = get_the_ID();
    }

    $itinerary = get_post_meta($post_id, '_bbt_tour_itinerary', true);

    return is_array($itinerary) ? $itinerary : array();
}

/**
 * Get Tour Included Items
 */
function bbt_get_tour_included($post_id = null)
{
    if (!$post_id) {
        $post_id = get_the_ID();
    }

    $included = get_post_meta($post_id, '_bbt_tour_included', true);

    if (!$included) {
        return array();
    }

    // Handle if already an array
    if (is_array($included)) {
        return array_filter(array_map('trim', $included));
    }

    return array_filter(array_map('trim', explode("\n", $included)));
}

/**
 * Get Tour Excluded Items
 */
function bbt_get_tour_excluded($post_id = null)
{
    if (!$post_id) {
        $post_id = get_the_ID();
    }

    $excluded = get_post_meta($post_id, '_bbt_tour_excluded', true);

    if (!$excluded) {
        return array();
    }

    // Handle if already an array
    if (is_array($excluded)) {
        return array_filter(array_map('trim', $excluded));
    }

    return array_filter(array_map('trim', explode("\n", $excluded)));
}

/**
 * Get Tour Highlights
 */
function bbt_get_tour_highlights($post_id = null)
{
    if (!$post_id) {
        $post_id = get_the_ID();
    }

    $highlights = get_post_meta($post_id, '_bbt_tour_highlights', true);

    if (!$highlights) {
        return array();
    }

    // Handle if already an array
    if (is_array($highlights)) {
        return array_filter(array_map('trim', $highlights));
    }

    // Handle string (newline-separated)
    return array_filter(array_map('trim', explode("\n", $highlights)));
}

/**
 * Get Tour Important Info
 */
function bbt_get_tour_important_info($post_id = null)
{
    if (!$post_id) {
        $post_id = get_the_ID();
    }

    $info = get_post_meta($post_id, '_bbt_tour_important_info', true);

    if (!$info) {
        return array();
    }

    // Handle if already an array
    if (is_array($info)) {
        return array_filter(array_map('trim', $info));
    }

    // Handle string (newline-separated)
    return array_filter(array_map('trim', explode("\n", $info)));
}

/**
 * Get Tour FAQ
 */
function bbt_get_tour_faq($post_id = null)
{
    if (!$post_id) {
        $post_id = get_the_ID();
    }

    $faq = get_post_meta($post_id, '_bbt_tour_faq', true);

    return is_array($faq) ? $faq : array();
}

/**
 * Get Tour Reviews
 */
function bbt_get_tour_reviews($post_id = null, $limit = 10)
{
    if (!$post_id) {
        $post_id = get_the_ID();
    }

    // Get reviews linked to this tour
    $args = array(
        'post_type' => 'review',
        'posts_per_page' => $limit,
        'meta_query' => array(
            array(
                'key' => '_bbt_review_tour_id',
                'value' => $post_id,
                'compare' => '=',
            ),
        ),
        'orderby' => 'date',
        'order' => 'DESC',
    );

    return new WP_Query($args);
}

/**
 * Get Related Tours
 */
function bbt_get_related_tours($post_id = null, $limit = 4)
{
    if (!$post_id) {
        $post_id = get_the_ID();
    }

    // Get locations
    $locations = wp_get_post_terms($post_id, 'tour_location', array('fields' => 'ids'));
    $types = wp_get_post_terms($post_id, 'tour_type', array('fields' => 'ids'));

    $args = array(
        'post_type' => 'tour',
        'posts_per_page' => $limit,
        'post__not_in' => array($post_id),
        'orderby' => 'rand',
    );

    if (!empty($locations) || !empty($types)) {
        $args['tax_query'] = array('relation' => 'OR');

        if (!empty($locations)) {
            $args['tax_query'][] = array(
                'taxonomy' => 'tour_location',
                'field' => 'term_id',
                'terms' => $locations,
            );
        }

        if (!empty($types)) {
            $args['tax_query'][] = array(
                'taxonomy' => 'tour_type',
                'field' => 'term_id',
                'terms' => $types,
            );
        }
    }

    return new WP_Query($args);
}

/**
 * Fallback Menu
 */
function bbt_fallback_menu()
{
    $html = '<ul class="nav-menu">';
    $html .= '<li><a href="' . esc_url(home_url('/')) . '">' . __('Home', 'bestbalitravel') . '</a></li>';
    $html .= '<li><a href="' . esc_url(home_url('/about/')) . '">' . __('About', 'bestbalitravel') . '</a></li>';
    $html .= '<li><a href="' . esc_url(home_url('/tours/')) . '">' . __('Tours', 'bestbalitravel') . '</a></li>';
    $html .= '<li><a href="' . esc_url(home_url('/contact/')) . '">' . __('Contact', 'bestbalitravel') . '</a></li>';
    $html .= '</ul>';

    echo $html;
}

/**
 * Get Featured Tours
 */
function bbt_get_featured_tours($limit = 6)
{
    $args = array(
        'post_type' => 'tour',
        'posts_per_page' => $limit,
        'meta_query' => array(
            array(
                'key' => '_bbt_tour_featured',
                'value' => '1',
                'compare' => '=',
            ),
        ),
    );

    $query = new WP_Query($args);

    // Fallback to latest tours if no featured
    if (!$query->have_posts()) {
        $args = array(
            'post_type' => 'tour',
            'posts_per_page' => $limit,
            'orderby' => 'date',
            'order' => 'DESC',
        );
        $query = new WP_Query($args);
    }

    return $query;
}

/**
 * Get Popular Locations
 */
function bbt_get_popular_locations($limit = 8)
{
    $terms = get_terms(array(
        'taxonomy' => 'tour_location',
        'hide_empty' => false,
        'number' => $limit,
        'orderby' => 'count',
        'order' => 'DESC',
    ));

    return $terms;
}

/**
 * Get Tour Fallback Image
 * Returns an appropriate Unsplash image URL based on tour title keywords
 */
function bbt_get_tour_fallback_image($post_id = null, $size = 'medium')
{
    if (!$post_id) {
        $post_id = get_the_ID();
    }

    // If post has thumbnail, use it
    if (has_post_thumbnail($post_id)) {
        return get_the_post_thumbnail_url($post_id, $size);
    }

    $title = strtolower(get_the_title($post_id));

    // Image dimensions based on size
    $dimensions = array(
        'small' => '400x300',
        'medium' => '600x400',
        'large' => '800x600',
        'full' => '1200x800',
    );
    $dim = isset($dimensions[$size]) ? $dimensions[$size] : '600x400';
    list($w, $h) = explode('x', $dim);

    // Keyword to image mapping with Unsplash IDs
    $image_map = array(
        // Temples & Cultural
        'temple' => 'photo-1537996194471-e657df975ab4',
        'uluwatu' => 'photo-1555400038-63f5ba517a47',
        'tanah lot' => 'photo-1518548419970-58e3b4079ab2',
        'tirta empul' => 'photo-1604999565976-8913ad2ddb7c',
        'besakih' => 'photo-1555400038-63f5ba517a47',
        'pura' => 'photo-1537996194471-e657df975ab4',
        'cultural' => 'photo-1537996194471-e657df975ab4',

        // Beaches
        'beach' => 'photo-1507525428034-b723cf961d3e',
        'kuta' => 'photo-1507525428034-b723cf961d3e',
        'seminyak' => 'photo-1559628233-100c798642d4',
        'sanur' => 'photo-1559628233-100c798642d4',
        'nusa dua' => 'photo-1559628233-100c798642d4',
        'jimbaran' => 'photo-1559628233-100c798642d4',

        // Waterfalls
        'waterfall' => 'photo-1544551763-46a013bb70d5',
        'tegenungan' => 'photo-1544551763-46a013bb70d5',
        'sekumpul' => 'photo-1544551763-46a013bb70d5',
        'gitgit' => 'photo-1544551763-46a013bb70d5',

        // Rice Terraces
        'rice' => 'photo-1555400038-63f5ba517a47',
        'tegallalang' => 'photo-1555400038-63f5ba517a47',
        'jatiluwih' => 'photo-1555400038-63f5ba517a47',
        'terrace' => 'photo-1555400038-63f5ba517a47',

        // Mountains & Trekking  
        'mount' => 'photo-1604537529428-15bcbeecfe4d',
        'batur' => 'photo-1604537529428-15bcbeecfe4d',
        'agung' => 'photo-1604537529428-15bcbeecfe4d',
        'sunrise' => 'photo-1604537529428-15bcbeecfe4d',
        'trek' => 'photo-1604537529428-15bcbeecfe4d',
        'hiking' => 'photo-1604537529428-15bcbeecfe4d',

        // Water Activities
        'surf' => 'photo-1502680390469-be75c86b636f',
        'diving' => 'photo-1544551763-46a013bb70d5',
        'snorkel' => 'photo-1544551763-92ab472cad5d',
        'rafting' => 'photo-1530866495561-507c9faab2ed',
        'kayak' => 'photo-1530866495561-507c9faab2ed',

        // Islands
        'nusa penida' => 'photo-1570789210967-2cac24f04e5c',
        'lembongan' => 'photo-1570789210967-2cac24f04e5c',
        'gili' => 'photo-1570789210967-2cac24f04e5c',
        'island' => 'photo-1570789210967-2cac24f04e5c',

        // Adventure
        'atv' => 'photo-1558981403-c5f9899a28bc',
        'quad' => 'photo-1558981403-c5f9899a28bc',
        'cycling' => 'photo-1558618666-fcd25c85cd64',
        'bike' => 'photo-1558618666-fcd25c85cd64',
        'swing' => 'photo-1555400038-63f5ba517a47',

        // Wildlife
        'monkey' => 'photo-1540959733332-eab4deabeeaf',
        'elephant' => 'photo-1564760055775-d63b17a7215d',
        'dolphin' => 'photo-1568430462989-44163eb1752f',
        'safari' => 'photo-1564760055775-d63b17a7215d',

        // Spa & Wellness
        'spa' => 'photo-1540555700478-4be289fbecef',
        'massage' => 'photo-1540555700478-4be289fbecef',
        'yoga' => 'photo-1545389336-cf090694435e',
        'wellness' => 'photo-1540555700478-4be289fbecef',

        // General locations
        'ubud' => 'photo-1555400038-63f5ba517a47',
        'kintamani' => 'photo-1604537529428-15bcbeecfe4d',
        'bedugul' => 'photo-1544551763-46a013bb70d5',
    );

    // Find matching keyword
    foreach ($image_map as $keyword => $photo_id) {
        if (strpos($title, $keyword) !== false) {
            return "https://images.unsplash.com/{$photo_id}?w={$w}&h={$h}&fit=crop";
        }
    }

    // Default Bali landscape image
    return "https://images.unsplash.com/photo-1537996194471-e657df975ab4?w={$w}&h={$h}&fit=crop";
}

/**
 * Display Tour Card Image
 * Helper function to display tour card image with fallback
 */
function bbt_tour_card_image($post_id = null, $size = 'bbt-tour-card')
{
    if (!$post_id) {
        $post_id = get_the_ID();
    }

    if (has_post_thumbnail($post_id)) {
        echo get_the_post_thumbnail($post_id, $size, array(
            'loading' => 'lazy',
            'alt' => get_the_title($post_id)
        ));
    } else {
        $fallback_url = bbt_get_tour_fallback_image($post_id, 'medium');
        printf(
            '<img src="%s" alt="%s" loading="lazy">',
            esc_url($fallback_url),
            esc_attr(get_the_title($post_id))
        );
    }
}
