<?php
/**
 * Register Custom Taxonomies
 *
 * @package BestBaliTravel
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register Tour Location Taxonomy
 */
function bbt_register_tour_location_taxonomy()
{
    $labels = array(
        'name' => _x('Locations', 'Taxonomy General Name', 'bestbalitravel'),
        'singular_name' => _x('Location', 'Taxonomy Singular Name', 'bestbalitravel'),
        'menu_name' => __('Locations', 'bestbalitravel'),
        'all_items' => __('All Locations', 'bestbalitravel'),
        'parent_item' => __('Parent Location', 'bestbalitravel'),
        'parent_item_colon' => __('Parent Location:', 'bestbalitravel'),
        'new_item_name' => __('New Location Name', 'bestbalitravel'),
        'add_new_item' => __('Add New Location', 'bestbalitravel'),
        'edit_item' => __('Edit Location', 'bestbalitravel'),
        'update_item' => __('Update Location', 'bestbalitravel'),
        'view_item' => __('View Location', 'bestbalitravel'),
        'separate_items_with_commas' => __('Separate locations with commas', 'bestbalitravel'),
        'add_or_remove_items' => __('Add or remove locations', 'bestbalitravel'),
        'choose_from_most_used' => __('Choose from the most used', 'bestbalitravel'),
        'popular_items' => __('Popular Locations', 'bestbalitravel'),
        'search_items' => __('Search Locations', 'bestbalitravel'),
        'not_found' => __('Not Found', 'bestbalitravel'),
    );

    $args = array(
        'labels' => $labels,
        'hierarchical' => true,
        'public' => true,
        'show_ui' => true,
        'show_admin_column' => true,
        'show_in_nav_menus' => true,
        'show_tagcloud' => true,
        'show_in_rest' => true,
        'rewrite' => array(
            'slug' => 'location',
            'with_front' => false,
            'hierarchical' => true,
        ),
    );

    register_taxonomy('tour_location', array('tour', 'activity'), $args);

    // Add default locations
    $default_locations = array(
        'Kintamani' => 'kintamani',
        'Ubud' => 'ubud',
        'Uluwatu' => 'uluwatu',
        'Nusa Penida' => 'nusa-penida',
        'Karangasem' => 'karangasem',
        'Singaraja' => 'singaraja',
        'Tabanan' => 'tabanan',
        'Denpasar' => 'denpasar',
    );

    foreach ($default_locations as $name => $slug) {
        if (!term_exists($name, 'tour_location')) {
            wp_insert_term($name, 'tour_location', array('slug' => $slug));
        }
    }
}
add_action('init', 'bbt_register_tour_location_taxonomy', 0);

/**
 * Register Tour Type Taxonomy
 */
function bbt_register_tour_type_taxonomy()
{
    $labels = array(
        'name' => _x('Tour Types', 'Taxonomy General Name', 'bestbalitravel'),
        'singular_name' => _x('Tour Type', 'Taxonomy Singular Name', 'bestbalitravel'),
        'menu_name' => __('Tour Types', 'bestbalitravel'),
        'all_items' => __('All Tour Types', 'bestbalitravel'),
        'new_item_name' => __('New Tour Type Name', 'bestbalitravel'),
        'add_new_item' => __('Add New Tour Type', 'bestbalitravel'),
        'edit_item' => __('Edit Tour Type', 'bestbalitravel'),
        'update_item' => __('Update Tour Type', 'bestbalitravel'),
        'view_item' => __('View Tour Type', 'bestbalitravel'),
        'search_items' => __('Search Tour Types', 'bestbalitravel'),
        'not_found' => __('Not Found', 'bestbalitravel'),
    );

    $args = array(
        'labels' => $labels,
        'hierarchical' => true,
        'public' => true,
        'show_ui' => true,
        'show_admin_column' => true,
        'show_in_nav_menus' => true,
        'show_tagcloud' => true,
        'show_in_rest' => true,
        'rewrite' => array(
            'slug' => 'tour-type',
            'with_front' => false,
        ),
    );

    register_taxonomy('tour_type', array('tour'), $args);

    // Add default types
    $default_types = array(
        'Sunrise Tour' => 'sunrise-tour',
        'Adventure' => 'adventure',
        'Cultural' => 'cultural',
        'Water Sports' => 'water-sports',
        'Trekking' => 'trekking',
        'Honeymoon' => 'honeymoon',
        'Airport Transfer' => 'airport-transfer',
        'Private Tour' => 'private-tour',
        'Group Tour' => 'group-tour',
    );

    foreach ($default_types as $name => $slug) {
        if (!term_exists($name, 'tour_type')) {
            wp_insert_term($name, 'tour_type', array('slug' => $slug));
        }
    }
}
add_action('init', 'bbt_register_tour_type_taxonomy', 0);

/**
 * Register Tour Duration Taxonomy
 */
function bbt_register_tour_duration_taxonomy()
{
    $labels = array(
        'name' => _x('Durations', 'Taxonomy General Name', 'bestbalitravel'),
        'singular_name' => _x('Duration', 'Taxonomy Singular Name', 'bestbalitravel'),
        'menu_name' => __('Durations', 'bestbalitravel'),
        'all_items' => __('All Durations', 'bestbalitravel'),
        'new_item_name' => __('New Duration', 'bestbalitravel'),
        'add_new_item' => __('Add New Duration', 'bestbalitravel'),
        'edit_item' => __('Edit Duration', 'bestbalitravel'),
        'search_items' => __('Search Durations', 'bestbalitravel'),
        'not_found' => __('Not Found', 'bestbalitravel'),
    );

    $args = array(
        'labels' => $labels,
        'hierarchical' => true,
        'public' => true,
        'show_ui' => true,
        'show_admin_column' => true,
        'show_in_nav_menus' => true,
        'show_in_rest' => true,
        'rewrite' => array(
            'slug' => 'duration',
            'with_front' => false,
        ),
    );

    register_taxonomy('tour_duration', array('tour', 'activity'), $args);

    // Add default durations
    $default_durations = array(
        '0-3 Hours' => '0-3-hours',
        '3-5 Hours' => '3-5-hours',
        '5-7 Hours' => '5-7-hours',
        'Full Day' => 'full-day',
        'Multi Day' => 'multi-day',
    );

    foreach ($default_durations as $name => $slug) {
        if (!term_exists($name, 'tour_duration')) {
            wp_insert_term($name, 'tour_duration', array('slug' => $slug));
        }
    }
}
add_action('init', 'bbt_register_tour_duration_taxonomy', 0);

/**
 * Add Location Meta Fields
 */
function bbt_add_location_meta_fields()
{
    // Add meta fields to tour_location taxonomy
    add_action('tour_location_add_form_fields', 'bbt_location_add_meta_fields', 10, 2);
    add_action('tour_location_edit_form_fields', 'bbt_location_edit_meta_fields', 10, 2);
    add_action('created_tour_location', 'bbt_save_location_meta_fields', 10, 2);
    add_action('edited_tour_location', 'bbt_save_location_meta_fields', 10, 2);
}
add_action('init', 'bbt_add_location_meta_fields');

/**
 * Add meta fields to new location form
 */
function bbt_location_add_meta_fields()
{
    ?>
    <div class="form-field">
        <label for="location_image"><?php esc_html_e('Location Image', 'bestbalitravel'); ?></label>
        <input type="hidden" id="location_image" name="location_image" value="">
        <div id="location-image-preview"></div>
        <button type="button" class="button"
            id="upload-location-image"><?php esc_html_e('Upload Image', 'bestbalitravel'); ?></button>
    </div>
    <div class="form-field">
        <label for="location_map_lat"><?php esc_html_e('Latitude', 'bestbalitravel'); ?></label>
        <input type="text" name="location_map_lat" id="location_map_lat" value="">
    </div>
    <div class="form-field">
        <label for="location_map_lng"><?php esc_html_e('Longitude', 'bestbalitravel'); ?></label>
        <input type="text" name="location_map_lng" id="location_map_lng" value="">
    </div>
    <?php
}

/**
 * Add meta fields to edit location form
 */
function bbt_location_edit_meta_fields($term)
{
    $image_id = get_term_meta($term->term_id, 'location_image', true);
    $lat = get_term_meta($term->term_id, 'location_map_lat', true);
    $lng = get_term_meta($term->term_id, 'location_map_lng', true);
    ?>
    <tr class="form-field">
        <th scope="row"><label for="location_image"><?php esc_html_e('Location Image', 'bestbalitravel'); ?></label></th>
        <td>
            <input type="hidden" id="location_image" name="location_image" value="<?php echo esc_attr($image_id); ?>">
            <div id="location-image-preview">
                <?php if ($image_id): ?>
                    <?php echo wp_get_attachment_image($image_id, 'thumbnail'); ?>
                <?php endif; ?>
            </div>
            <button type="button" class="button"
                id="upload-location-image"><?php esc_html_e('Upload Image', 'bestbalitravel'); ?></button>
            <?php if ($image_id): ?>
                <button type="button" class="button"
                    id="remove-location-image"><?php esc_html_e('Remove Image', 'bestbalitravel'); ?></button>
            <?php endif; ?>
        </td>
    </tr>
    <tr class="form-field">
        <th scope="row"><label for="location_map_lat"><?php esc_html_e('Latitude', 'bestbalitravel'); ?></label></th>
        <td>
            <input type="text" name="location_map_lat" id="location_map_lat" value="<?php echo esc_attr($lat); ?>">
        </td>
    </tr>
    <tr class="form-field">
        <th scope="row"><label for="location_map_lng"><?php esc_html_e('Longitude', 'bestbalitravel'); ?></label></th>
        <td>
            <input type="text" name="location_map_lng" id="location_map_lng" value="<?php echo esc_attr($lng); ?>">
        </td>
    </tr>
    <?php
}

/**
 * Save location meta fields
 */
function bbt_save_location_meta_fields($term_id)
{
    if (isset($_POST['location_image'])) {
        update_term_meta($term_id, 'location_image', absint($_POST['location_image']));
    }
    if (isset($_POST['location_map_lat'])) {
        update_term_meta($term_id, 'location_map_lat', sanitize_text_field($_POST['location_map_lat']));
    }
    if (isset($_POST['location_map_lng'])) {
        update_term_meta($term_id, 'location_map_lng', sanitize_text_field($_POST['location_map_lng']));
    }
}
