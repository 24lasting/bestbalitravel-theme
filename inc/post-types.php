<?php
/**
 * Register Custom Post Types
 *
 * @package BestBaliTravel
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register Tour Post Type
 */
function bbt_register_tour_post_type()
{
    $labels = array(
        'name' => _x('Tours', 'Post Type General Name', 'bestbalitravel'),
        'singular_name' => _x('Tour', 'Post Type Singular Name', 'bestbalitravel'),
        'menu_name' => __('Tours', 'bestbalitravel'),
        'name_admin_bar' => __('Tour', 'bestbalitravel'),
        'archives' => __('Tour Archives', 'bestbalitravel'),
        'attributes' => __('Tour Attributes', 'bestbalitravel'),
        'parent_item_colon' => __('Parent Tour:', 'bestbalitravel'),
        'all_items' => __('All Tours', 'bestbalitravel'),
        'add_new_item' => __('Add New Tour', 'bestbalitravel'),
        'add_new' => __('Add New', 'bestbalitravel'),
        'new_item' => __('New Tour', 'bestbalitravel'),
        'edit_item' => __('Edit Tour', 'bestbalitravel'),
        'update_item' => __('Update Tour', 'bestbalitravel'),
        'view_item' => __('View Tour', 'bestbalitravel'),
        'view_items' => __('View Tours', 'bestbalitravel'),
        'search_items' => __('Search Tour', 'bestbalitravel'),
        'not_found' => __('Not found', 'bestbalitravel'),
        'not_found_in_trash' => __('Not found in Trash', 'bestbalitravel'),
        'featured_image' => __('Featured Image', 'bestbalitravel'),
        'set_featured_image' => __('Set featured image', 'bestbalitravel'),
        'remove_featured_image' => __('Remove featured image', 'bestbalitravel'),
        'use_featured_image' => __('Use as featured image', 'bestbalitravel'),
        'insert_into_item' => __('Insert into tour', 'bestbalitravel'),
        'uploaded_to_this_item' => __('Uploaded to this tour', 'bestbalitravel'),
        'items_list' => __('Tours list', 'bestbalitravel'),
        'items_list_navigation' => __('Tours list navigation', 'bestbalitravel'),
        'filter_items_list' => __('Filter tours list', 'bestbalitravel'),
    );

    $args = array(
        'label' => __('Tour', 'bestbalitravel'),
        'description' => __('Tour packages', 'bestbalitravel'),
        'labels' => $labels,
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'revisions'),
        'hierarchical' => false,
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        'menu_icon' => 'dashicons-palmtree',
        'show_in_admin_bar' => true,
        'show_in_nav_menus' => true,
        'can_export' => true,
        'has_archive' => 'tours',
        'exclude_from_search' => false,
        'publicly_queryable' => true,
        'capability_type' => 'post',
        'show_in_rest' => true,
        'rewrite' => array(
            'slug' => 'tour',
            'with_front' => false,
        ),
    );

    register_post_type('tour', $args);
}
add_action('init', 'bbt_register_tour_post_type', 0);

/**
 * Register Activity Post Type
 */
function bbt_register_activity_post_type()
{
    $labels = array(
        'name' => _x('Activities', 'Post Type General Name', 'bestbalitravel'),
        'singular_name' => _x('Activity', 'Post Type Singular Name', 'bestbalitravel'),
        'menu_name' => __('Activities', 'bestbalitravel'),
        'name_admin_bar' => __('Activity', 'bestbalitravel'),
        'archives' => __('Activity Archives', 'bestbalitravel'),
        'all_items' => __('All Activities', 'bestbalitravel'),
        'add_new_item' => __('Add New Activity', 'bestbalitravel'),
        'add_new' => __('Add New', 'bestbalitravel'),
        'new_item' => __('New Activity', 'bestbalitravel'),
        'edit_item' => __('Edit Activity', 'bestbalitravel'),
        'update_item' => __('Update Activity', 'bestbalitravel'),
        'view_item' => __('View Activity', 'bestbalitravel'),
        'search_items' => __('Search Activity', 'bestbalitravel'),
        'not_found' => __('Not found', 'bestbalitravel'),
        'not_found_in_trash' => __('Not found in Trash', 'bestbalitravel'),
    );

    $args = array(
        'label' => __('Activity', 'bestbalitravel'),
        'description' => __('Tour activities', 'bestbalitravel'),
        'labels' => $labels,
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'revisions'),
        'hierarchical' => false,
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 6,
        'menu_icon' => 'dashicons-universal-access',
        'show_in_admin_bar' => true,
        'show_in_nav_menus' => true,
        'can_export' => true,
        'has_archive' => 'activities',
        'exclude_from_search' => false,
        'publicly_queryable' => true,
        'capability_type' => 'post',
        'show_in_rest' => true,
        'rewrite' => array(
            'slug' => 'activity',
            'with_front' => false,
        ),
    );

    register_post_type('activity', $args);
}
add_action('init', 'bbt_register_activity_post_type', 0);

/**
 * Register Review Post Type
 */
function bbt_register_review_post_type()
{
    $labels = array(
        'name' => _x('Reviews', 'Post Type General Name', 'bestbalitravel'),
        'singular_name' => _x('Review', 'Post Type Singular Name', 'bestbalitravel'),
        'menu_name' => __('Reviews', 'bestbalitravel'),
        'all_items' => __('All Reviews', 'bestbalitravel'),
        'add_new_item' => __('Add New Review', 'bestbalitravel'),
        'add_new' => __('Add New', 'bestbalitravel'),
        'edit_item' => __('Edit Review', 'bestbalitravel'),
        'view_item' => __('View Review', 'bestbalitravel'),
        'search_items' => __('Search Reviews', 'bestbalitravel'),
        'not_found' => __('No reviews found', 'bestbalitravel'),
    );

    $args = array(
        'label' => __('Review', 'bestbalitravel'),
        'labels' => $labels,
        'supports' => array('title', 'editor', 'thumbnail'),
        'hierarchical' => false,
        'public' => false,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 7,
        'menu_icon' => 'dashicons-star-filled',
        'show_in_admin_bar' => false,
        'show_in_nav_menus' => false,
        'can_export' => true,
        'has_archive' => false,
        'exclude_from_search' => true,
        'publicly_queryable' => false,
        'capability_type' => 'post',
        'show_in_rest' => true,
    );

    register_post_type('review', $args);
}
add_action('init', 'bbt_register_review_post_type', 0);

/**
 * Add Meta Boxes for Tours
 */
function bbt_add_tour_meta_boxes()
{
    add_meta_box(
        'bbt_tour_details',
        __('Tour Details', 'bestbalitravel'),
        'bbt_tour_details_callback',
        'tour',
        'normal',
        'high'
    );

    add_meta_box(
        'bbt_tour_pricing',
        __('Pricing', 'bestbalitravel'),
        'bbt_tour_pricing_callback',
        'tour',
        'side',
        'high'
    );

    add_meta_box(
        'bbt_tour_gallery',
        __('Tour Gallery', 'bestbalitravel'),
        'bbt_tour_gallery_callback',
        'tour',
        'normal',
        'default'
    );

    add_meta_box(
        'bbt_tour_itinerary',
        __('Itinerary', 'bestbalitravel'),
        'bbt_tour_itinerary_callback',
        'tour',
        'normal',
        'default'
    );

    add_meta_box(
        'bbt_tour_faq',
        __('FAQ', 'bestbalitravel'),
        'bbt_tour_faq_callback',
        'tour',
        'normal',
        'default'
    );
}
add_action('add_meta_boxes', 'bbt_add_tour_meta_boxes');

/**
 * Tour Details Meta Box Callback
 */
function bbt_tour_details_callback($post)
{
    wp_nonce_field('bbt_save_tour_meta', 'bbt_tour_meta_nonce');

    $duration = get_post_meta($post->ID, '_bbt_tour_duration', true);
    $duration_unit = get_post_meta($post->ID, '_bbt_tour_duration_unit', true);
    $group_size = get_post_meta($post->ID, '_bbt_tour_group_size', true);
    $meeting_point = get_post_meta($post->ID, '_bbt_tour_meeting_point', true);
    $languages = get_post_meta($post->ID, '_bbt_tour_languages', true);
    $included = get_post_meta($post->ID, '_bbt_tour_included', true);
    $excluded = get_post_meta($post->ID, '_bbt_tour_excluded', true);
    $highlights = get_post_meta($post->ID, '_bbt_tour_highlights', true);
    $important_info = get_post_meta($post->ID, '_bbt_tour_important_info', true);
    ?>
    <table class="form-table">
        <tr>
            <th><label for="bbt_tour_duration">
                    <?php esc_html_e('Duration', 'bestbalitravel'); ?>
                </label></th>
            <td>
                <input type="number" id="bbt_tour_duration" name="bbt_tour_duration"
                    value="<?php echo esc_attr($duration); ?>" min="1" style="width: 80px;">
                <select name="bbt_tour_duration_unit">
                    <option value="hours" <?php selected($duration_unit, 'hours'); ?>>
                        <?php esc_html_e('Hours', 'bestbalitravel'); ?>
                    </option>
                    <option value="days" <?php selected($duration_unit, 'days'); ?>>
                        <?php esc_html_e('Days', 'bestbalitravel'); ?>
                    </option>
                </select>
            </td>
        </tr>
        <tr>
            <th><label for="bbt_tour_group_size">
                    <?php esc_html_e('Group Size', 'bestbalitravel'); ?>
                </label></th>
            <td>
                <input type="number" id="bbt_tour_group_size" name="bbt_tour_group_size"
                    value="<?php echo esc_attr($group_size); ?>" min="1" style="width: 80px;">
                <span class="description">
                    <?php esc_html_e('Maximum people per group', 'bestbalitravel'); ?>
                </span>
            </td>
        </tr>
        <tr>
            <th><label for="bbt_tour_meeting_point">
                    <?php esc_html_e('Meeting Point', 'bestbalitravel'); ?>
                </label></th>
            <td>
                <input type="text" id="bbt_tour_meeting_point" name="bbt_tour_meeting_point"
                    value="<?php echo esc_attr($meeting_point); ?>" class="regular-text">
            </td>
        </tr>
        <tr>
            <th><label for="bbt_tour_languages">
                    <?php esc_html_e('Languages', 'bestbalitravel'); ?>
                </label></th>
            <td>
                <input type="text" id="bbt_tour_languages" name="bbt_tour_languages"
                    value="<?php echo esc_attr($languages); ?>" class="regular-text">
                <p class="description">
                    <?php esc_html_e('Comma-separated, e.g., English, Indonesian, Japanese', 'bestbalitravel'); ?>
                </p>
            </td>
        </tr>
        <tr>
            <th><label for="bbt_tour_highlights">
                    <?php esc_html_e('Highlights', 'bestbalitravel'); ?>
                </label></th>
            <td>
                <textarea id="bbt_tour_highlights" name="bbt_tour_highlights" rows="4"
                    class="large-text"><?php echo esc_textarea($highlights); ?></textarea>
                <p class="description">
                    <?php esc_html_e('One highlight per line', 'bestbalitravel'); ?>
                </p>
            </td>
        </tr>
        <tr>
            <th><label for="bbt_tour_included">
                    <?php esc_html_e("What's Included", 'bestbalitravel'); ?>
                </label></th>
            <td>
                <textarea id="bbt_tour_included" name="bbt_tour_included" rows="5"
                    class="large-text"><?php echo esc_textarea($included); ?></textarea>
                <p class="description">
                    <?php esc_html_e('One item per line', 'bestbalitravel'); ?>
                </p>
            </td>
        </tr>
        <tr>
            <th><label for="bbt_tour_excluded">
                    <?php esc_html_e("What's Not Included", 'bestbalitravel'); ?>
                </label></th>
            <td>
                <textarea id="bbt_tour_excluded" name="bbt_tour_excluded" rows="4"
                    class="large-text"><?php echo esc_textarea($excluded); ?></textarea>
                <p class="description">
                    <?php esc_html_e('One item per line', 'bestbalitravel'); ?>
                </p>
            </td>
        </tr>
        <tr>
            <th><label for="bbt_tour_important_info">
                    <?php esc_html_e('Important Information', 'bestbalitravel'); ?>
                </label></th>
            <td>
                <textarea id="bbt_tour_important_info" name="bbt_tour_important_info" rows="4"
                    class="large-text"><?php echo esc_textarea($important_info); ?></textarea>
                <p class="description">
                    <?php esc_html_e('What to bring, requirements, etc. One item per line', 'bestbalitravel'); ?>
                </p>
            </td>
        </tr>
    </table>
    <?php
}

/**
 * Tour Pricing Meta Box Callback
 */
function bbt_tour_pricing_callback($post)
{
    $price = get_post_meta($post->ID, '_bbt_tour_price', true);
    $sale_price = get_post_meta($post->ID, '_bbt_tour_sale_price', true);
    $child_price = get_post_meta($post->ID, '_bbt_tour_child_price', true);
    ?>
    <p>
        <label for="bbt_tour_price"><strong>
                <?php esc_html_e('Regular Price (IDR)', 'bestbalitravel'); ?>
            </strong></label>
        <input type="number" id="bbt_tour_price" name="bbt_tour_price" value="<?php echo esc_attr($price); ?>"
            class="widefat" min="0">
    </p>
    <p>
        <label for="bbt_tour_sale_price"><strong>
                <?php esc_html_e('Sale Price (IDR)', 'bestbalitravel'); ?>
            </strong></label>
        <input type="number" id="bbt_tour_sale_price" name="bbt_tour_sale_price"
            value="<?php echo esc_attr($sale_price); ?>" class="widefat" min="0">
    </p>
    <p>
        <label for="bbt_tour_child_price"><strong>
                <?php esc_html_e('Child Price (IDR)', 'bestbalitravel'); ?>
            </strong></label>
        <input type="number" id="bbt_tour_child_price" name="bbt_tour_child_price"
            value="<?php echo esc_attr($child_price); ?>" class="widefat" min="0">
    </p>
    <?php
}

/**
 * Tour Gallery Meta Box Callback
 */
function bbt_tour_gallery_callback($post)
{
    $gallery = get_post_meta($post->ID, '_bbt_tour_gallery', true);
    ?>
    <div id="bbt-gallery-container">
        <div id="bbt-gallery-images" class="bbt-gallery-images">
            <?php if ($gallery):
                $image_ids = explode(',', $gallery);
                foreach ($image_ids as $image_id):
                    $image = wp_get_attachment_image_src($image_id, 'thumbnail');
                    if ($image):
                        ?>
                        <div class="bbt-gallery-item" data-id="<?php echo esc_attr($image_id); ?>">
                            <img src="<?php echo esc_url($image[0]); ?>" alt="">
                            <button type="button" class="bbt-remove-image">&times;</button>
                        </div>
                        <?php
                    endif;
                endforeach;
            endif; ?>
        </div>
        <input type="hidden" id="bbt_tour_gallery" name="bbt_tour_gallery" value="<?php echo esc_attr($gallery); ?>">
        <button type="button" id="bbt-add-gallery-images" class="button">
            <?php esc_html_e('Add Images', 'bestbalitravel'); ?>
        </button>
    </div>

    <style>
        .bbt-gallery-images {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 10px;
        }

        .bbt-gallery-item {
            position: relative;
            width: 100px;
            height: 100px;
        }

        .bbt-gallery-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 4px;
        }

        .bbt-remove-image {
            position: absolute;
            top: -5px;
            right: -5px;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: #dc3545;
            color: #fff;
            border: none;
            cursor: pointer;
            font-size: 14px;
            line-height: 1;
        }
    </style>

    <script>
        jQuery(document).ready(function ($) {
            var frame;

            $('#bbt-add-gallery-images').on('click', function (e) {
                e.preventDefault();

                if (frame) {
                    frame.open();
                    return;
                }

                frame = wp.media({
                    title: '<?php esc_html_e('Select Gallery Images', 'bestbalitravel'); ?>',
                    button: { text: '<?php esc_html_e('Add to Gallery', 'bestbalitravel'); ?>' },
                    multiple: true
                });

                frame.on('select', function () {
                    var attachments = frame.state().get('selection').toJSON();
                    var currentIds = $('#bbt_tour_gallery').val() ? $('#bbt_tour_gallery').val().split(',') : [];

                    attachments.forEach(function (attachment) {
                        if (currentIds.indexOf(attachment.id.toString()) === -1) {
                            currentIds.push(attachment.id);
                            var thumb = attachment.sizes.thumbnail ? attachment.sizes.thumbnail.url : attachment.url;
                            $('#bbt-gallery-images').append(
                                '<div class="bbt-gallery-item" data-id="' + attachment.id + '">' +
                                '<img src="' + thumb + '" alt="">' +
                                '<button type="button" class="bbt-remove-image">&times;</button>' +
                                '</div>'
                            );
                        }
                    });

                    $('#bbt_tour_gallery').val(currentIds.join(','));
                });

                frame.open();
            });

            $(document).on('click', '.bbt-remove-image', function () {
                var item = $(this).parent();
                var id = item.data('id').toString();
                var currentIds = $('#bbt_tour_gallery').val().split(',');
                currentIds = currentIds.filter(function (i) { return i !== id; });
                $('#bbt_tour_gallery').val(currentIds.join(','));
                item.remove();
            });
        });
    </script>
    <?php
}

/**
 * Tour Itinerary Meta Box Callback
 */
function bbt_tour_itinerary_callback($post)
{
    $itinerary = get_post_meta($post->ID, '_bbt_tour_itinerary', true);
    if (!$itinerary)
        $itinerary = array();
    ?>
    <div id="bbt-itinerary-container">
        <div id="bbt-itinerary-items">
            <?php if (!empty($itinerary)):
                foreach ($itinerary as $index => $item): ?>
                    <div class="bbt-itinerary-item" data-index="<?php echo esc_attr($index); ?>">
                        <div class="bbt-itinerary-header">
                            <span class="dashicons dashicons-menu handle"></span>
                            <input type="text" name="bbt_tour_itinerary[<?php echo esc_attr($index); ?>][time]"
                                value="<?php echo esc_attr($item['time'] ?? ''); ?>"
                                placeholder="<?php esc_attr_e('Time (e.g., 06:00 AM)', 'bestbalitravel'); ?>"
                                class="bbt-itinerary-time">
                            <input type="text" name="bbt_tour_itinerary[<?php echo esc_attr($index); ?>][title]"
                                value="<?php echo esc_attr($item['title'] ?? ''); ?>"
                                placeholder="<?php esc_attr_e('Title', 'bestbalitravel'); ?>" class="bbt-itinerary-title">
                            <button type="button" class="button bbt-remove-itinerary">&times;</button>
                        </div>
                        <textarea name="bbt_tour_itinerary[<?php echo esc_attr($index); ?>][description]"
                            placeholder="<?php esc_attr_e('Description', 'bestbalitravel'); ?>" rows="2"
                            class="widefat"><?php echo esc_textarea($item['description'] ?? ''); ?></textarea>
                    </div>
                <?php endforeach;
            endif; ?>
        </div>
        <button type="button" id="bbt-add-itinerary" class="button button-secondary">
            <?php esc_html_e('Add Itinerary Stop', 'bestbalitravel'); ?>
        </button>
    </div>

    <style>
        .bbt-itinerary-item {
            background: #f9f9f9;
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 4px;
            border: 1px solid #ddd;
        }

        .bbt-itinerary-header {
            display: flex;
            gap: 10px;
            align-items: center;
            margin-bottom: 10px;
        }

        .bbt-itinerary-time {
            width: 120px;
        }

        .bbt-itinerary-title {
            flex: 1;
        }

        .handle {
            cursor: move;
            color: #999;
        }
    </style>

    <script>
        jQuery(document).ready(function ($) {
            var itineraryIndex = <?php echo !empty($itinerary) ? count($itinerary) : 0; ?>;

            $('#bbt-add-itinerary').on('click', function () {
                var html = '<div class="bbt-itinerary-item" data-index="' + itineraryIndex + '">' +
                    '<div class="bbt-itinerary-header">' +
                    '<span class="dashicons dashicons-menu handle"></span>' +
                    '<input type="text" name="bbt_tour_itinerary[' + itineraryIndex + '][time]" placeholder="<?php esc_attr_e('Time (e.g., 06:00 AM)', 'bestbalitravel'); ?>" class="bbt-itinerary-time">' +
                    '<input type="text" name="bbt_tour_itinerary[' + itineraryIndex + '][title]" placeholder="<?php esc_attr_e('Title', 'bestbalitravel'); ?>" class="bbt-itinerary-title">' +
                    '<button type="button" class="button bbt-remove-itinerary">&times;</button>' +
                    '</div>' +
                    '<textarea name="bbt_tour_itinerary[' + itineraryIndex + '][description]" placeholder="<?php esc_attr_e('Description', 'bestbalitravel'); ?>" rows="2" class="widefat"></textarea>' +
                    '</div>';
                $('#bbt-itinerary-items').append(html);
                itineraryIndex++;
            });

            $(document).on('click', '.bbt-remove-itinerary', function () {
                $(this).closest('.bbt-itinerary-item').remove();
            });

            if ($.fn.sortable) {
                $('#bbt-itinerary-items').sortable({ handle: '.handle' });
            }
        });
    </script>
    <?php
}

/**
 * Tour FAQ Meta Box Callback
 */
function bbt_tour_faq_callback($post)
{
    $faq = get_post_meta($post->ID, '_bbt_tour_faq', true);
    if (!$faq)
        $faq = array();
    ?>
    <div id="bbt-faq-container">
        <div id="bbt-faq-items">
            <?php if (!empty($faq)):
                foreach ($faq as $index => $item): ?>
                    <div class="bbt-faq-item" data-index="<?php echo esc_attr($index); ?>">
                        <div class="bbt-faq-header">
                            <span class="dashicons dashicons-menu handle"></span>
                            <input type="text" name="bbt_tour_faq[<?php echo esc_attr($index); ?>][question]"
                                value="<?php echo esc_attr($item['question'] ?? ''); ?>"
                                placeholder="<?php esc_attr_e('Question', 'bestbalitravel'); ?>"
                                class="bbt-faq-question-input" style="flex:1;">
                            <button type="button" class="button bbt-remove-faq">&times;</button>
                        </div>
                        <textarea name="bbt_tour_faq[<?php echo esc_attr($index); ?>][answer]"
                            placeholder="<?php esc_attr_e('Answer', 'bestbalitravel'); ?>" rows="2"
                            class="widefat"><?php echo esc_textarea($item['answer'] ?? ''); ?></textarea>
                    </div>
                <?php endforeach;
            endif; ?>
        </div>
        <button type="button" id="bbt-add-faq" class="button button-secondary">
            <?php esc_html_e('Add FAQ Item', 'bestbalitravel'); ?>
        </button>
    </div>

    <style>
        .bbt-faq-item {
            background: #f9f9f9;
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 4px;
            border: 1px solid #ddd;
        }

        .bbt-faq-header {
            display: flex;
            gap: 10px;
            align-items: center;
            margin-bottom: 10px;
        }

        .bbt-faq-question-input {
            flex: 1;
        }

        #bbt-faq-container .handle {
            cursor: move;
            color: #999;
        }
    </style>

    <script>
        jQuery(document).ready(function ($) {
            var faqIndex = <?php echo !empty($faq) ? count($faq) : 0; ?>;

            $('#bbt-add-faq').on('click', function () {
                var html = '<div class="bbt-faq-item" data-index="' + faqIndex + '">' +
                    '<div class="bbt-faq-header">' +
                    '<span class="dashicons dashicons-menu handle"></span>' +
                    '<input type="text" name="bbt_tour_faq[' + faqIndex + '][question]" placeholder="<?php esc_attr_e('Question', 'bestbalitravel'); ?>" class="bbt-faq-question-input" style="flex:1;">' +
                    '<button type="button" class="button bbt-remove-faq">&times;</button>' +
                    '</div>' +
                    '<textarea name="bbt_tour_faq[' + faqIndex + '][answer]" placeholder="<?php esc_attr_e('Answer', 'bestbalitravel'); ?>" rows="2" class="widefat"></textarea>' +
                    '</div>';
                $('#bbt-faq-items').append(html);
                faqIndex++;
            });

            $(document).on('click', '.bbt-remove-faq', function () {
                $(this).closest('.bbt-faq-item').remove();
            });

            if ($.fn.sortable) {
                $('#bbt-faq-items').sortable({ handle: '.handle' });
            }
        });
    </script>
    <?php
}

/**
 * Save Tour Meta
 */
function bbt_save_tour_meta($post_id)
{
    // Check nonce
    if (!isset($_POST['bbt_tour_meta_nonce']) || !wp_verify_nonce($_POST['bbt_tour_meta_nonce'], 'bbt_save_tour_meta')) {
        return;
    }

    // Check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Check permissions
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Save tour details
    $fields = array(
        'bbt_tour_duration' => '_bbt_tour_duration',
        'bbt_tour_duration_unit' => '_bbt_tour_duration_unit',
        'bbt_tour_group_size' => '_bbt_tour_group_size',
        'bbt_tour_meeting_point' => '_bbt_tour_meeting_point',
        'bbt_tour_languages' => '_bbt_tour_languages',
        'bbt_tour_highlights' => '_bbt_tour_highlights',
        'bbt_tour_included' => '_bbt_tour_included',
        'bbt_tour_excluded' => '_bbt_tour_excluded',
        'bbt_tour_important_info' => '_bbt_tour_important_info',
        'bbt_tour_price' => '_bbt_tour_price',
        'bbt_tour_sale_price' => '_bbt_tour_sale_price',
        'bbt_tour_child_price' => '_bbt_tour_child_price',
        'bbt_tour_gallery' => '_bbt_tour_gallery',
    );

    foreach ($fields as $field => $meta_key) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, $meta_key, sanitize_text_field($_POST[$field]));
        }
    }

    // Save itinerary
    if (isset($_POST['bbt_tour_itinerary']) && is_array($_POST['bbt_tour_itinerary'])) {
        $itinerary = array();
        foreach ($_POST['bbt_tour_itinerary'] as $item) {
            $itinerary[] = array(
                'time' => sanitize_text_field($item['time'] ?? ''),
                'title' => sanitize_text_field($item['title'] ?? ''),
                'description' => sanitize_textarea_field($item['description'] ?? ''),
            );
        }
        update_post_meta($post_id, '_bbt_tour_itinerary', $itinerary);
    }

    // Save FAQ
    if (isset($_POST['bbt_tour_faq']) && is_array($_POST['bbt_tour_faq'])) {
        $faq = array();
        foreach ($_POST['bbt_tour_faq'] as $item) {
            if (!empty($item['question'])) {
                $faq[] = array(
                    'question' => sanitize_text_field($item['question'] ?? ''),
                    'answer' => sanitize_textarea_field($item['answer'] ?? ''),
                );
            }
        }
        update_post_meta($post_id, '_bbt_tour_faq', $faq);
    }
}
add_action('save_post_tour', 'bbt_save_tour_meta');

