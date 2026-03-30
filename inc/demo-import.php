<?php
/**
 * Demo Content Importer
 *
 * @package BestBaliTravel
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add Demo Import Menu
 */
function bbt_demo_import_menu()
{
    add_theme_page(
        __('Import Demo Content', 'bestbalitravel'),
        __('Demo Import', 'bestbalitravel'),
        'manage_options',
        'bbt-demo-import',
        'bbt_demo_import_page'
    );
}
add_action('admin_menu', 'bbt_demo_import_menu');

/**
 * Demo Import Page
 */
function bbt_demo_import_page()
{
    ?>
    <div class="wrap">
        <h1>
            <?php esc_html_e('Import Demo Content', 'bestbalitravel'); ?>
        </h1>

        <div class="bbt-demo-notice"
            style="background: #fff; padding: 20px; border-left: 4px solid #f5a623; margin: 20px 0;">
            <h3 style="margin-top: 0;">
                <?php esc_html_e('Welcome to Best Bali Travel Theme!', 'bestbalitravel'); ?>
            </h3>
            <p>
                <?php esc_html_e('Click the button below to import sample tours, activities, and pages to get you started quickly.', 'bestbalitravel'); ?>
            </p>
            <p><strong>
                    <?php esc_html_e('This will create:', 'bestbalitravel'); ?>
                </strong></p>
            <ul style="list-style: disc; margin-left: 20px;">
                <li>
                    <?php esc_html_e('6 Sample Tours with full details', 'bestbalitravel'); ?>
                </li>
                <li>
                    <?php esc_html_e('3 Sample Activities', 'bestbalitravel'); ?>
                </li>
                <li>
                    <?php esc_html_e('Sample pages (About, Contact, Privacy Policy, Terms)', 'bestbalitravel'); ?>
                </li>
                <li>
                    <?php esc_html_e('Navigation menus', 'bestbalitravel'); ?>
                </li>
            </ul>
        </div>

        <?php if (isset($_GET['imported']) && $_GET['imported'] == 'success'): ?>
            <div class="notice notice-success">
                <p>
                    <?php esc_html_e('Demo content imported successfully!', 'bestbalitravel'); ?>
                </p>
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['imported']) && $_GET['imported'] == 'exists'): ?>
            <div class="notice notice-warning">
                <p>
                    <?php esc_html_e('Demo content has already been imported.', 'bestbalitravel'); ?>
                </p>
            </div>
        <?php endif; ?>

        <form method="post" action="">
            <?php wp_nonce_field('bbt_import_demo', 'bbt_demo_nonce'); ?>

            <p>
                <button type="submit" name="bbt_import_demo" class="button button-primary button-hero">
                    <?php esc_html_e('Import Demo Content', 'bestbalitravel'); ?>
                </button>
            </p>
        </form>
    </div>
    <?php
}

/**
 * Process Demo Import
 */
function bbt_process_demo_import()
{
    if (!isset($_POST['bbt_import_demo']) || !isset($_POST['bbt_demo_nonce'])) {
        return;
    }

    if (!wp_verify_nonce($_POST['bbt_demo_nonce'], 'bbt_import_demo')) {
        return;
    }

    if (!current_user_can('manage_options')) {
        return;
    }

    // Check if already imported
    if (get_option('bbt_demo_imported')) {
        wp_redirect(admin_url('themes.php?page=bbt-demo-import&imported=exists'));
        exit;
    }

    // Import Tours
    bbt_import_demo_tours();

    // Import Activities
    bbt_import_demo_activities();

    // Import Pages
    bbt_import_demo_pages();

    // Create Menus
    bbt_import_demo_menus();

    // Mark as imported
    update_option('bbt_demo_imported', true);

    wp_redirect(admin_url('themes.php?page=bbt-demo-import&imported=success'));
    exit;
}
add_action('admin_init', 'bbt_process_demo_import');

/**
 * Import Demo Tours
 */
function bbt_import_demo_tours()
{
    $tours = array(
        array(
            'title' => 'Mount Batur Sunrise Trekking',
            'content' => '<p>Experience the breathtaking sunrise from the top of Mount Batur, an active volcano in Bali. This unforgettable adventure starts in the early morning hours with a guided trek through volcanic landscapes.</p>
            
<p>Watch as the sun rises over the clouds, illuminating the crater lake below and casting golden light across the island. After the trek, enjoy a natural hot spring bath to relax your muscles.</p>

<p>This tour is perfect for adventure seekers and photography enthusiasts who want to capture Bali\'s natural beauty at its finest.</p>',
            'excerpt' => 'Witness a magical sunrise from the summit of Mount Batur with breakfast cooked by volcanic steam.',
            'price' => 750000,
            'sale_price' => 650000,
            'duration' => '6 hours',
            'group_size' => 15,
            'location' => 'Kintamani',
            'type' => 'Sunrise Tour',
            'highlights' => array(
                'Stunning sunrise views from 1,717m altitude',
                'Breakfast cooked by volcanic steam',
                'Natural hot spring bath included',
                'Professional local mountain guide',
                'Small group experience'
            ),
            'included' => array(
                'Hotel pickup and drop-off',
                'Professional trekking guide',
                'Breakfast at summit',
                'Flashlight and walking stick',
                'Hot spring entrance fee',
                'Bottled water'
            ),
            'excluded' => array(
                'Personal expenses',
                'Tips for guide',
                'Travel insurance'
            ),
        ),
        array(
            'title' => 'Ubud Cultural Tour',
            'content' => '<p>Discover the cultural heart of Bali with our comprehensive Ubud tour. Visit ancient temples, traditional art villages, and the famous Tegallalang Rice Terraces.</p>

<p>Experience the artistic soul of Bali as you explore galleries, watch traditional craftsmen at work, and walk through the Sacred Monkey Forest Sanctuary.</p>

<p>This tour offers a perfect blend of culture, nature, and art that showcases the essence of Balinese life.</p>',
            'excerpt' => 'Explore Ubud\'s temples, rice terraces, and monkey forest in one comprehensive cultural experience.',
            'price' => 600000,
            'sale_price' => 0,
            'duration' => '8 hours',
            'group_size' => 8,
            'location' => 'Ubud',
            'type' => 'Cultural',
            'highlights' => array(
                'Tegallalang Rice Terraces',
                'Sacred Monkey Forest Sanctuary',
                'Tirta Empul Holy Spring Temple',
                'Traditional art villages',
                'Ubud Royal Palace'
            ),
            'included' => array(
                'Air-conditioned transport',
                'English-speaking guide',
                'All entrance fees',
                'Sarong for temple visits',
                'Lunch at local restaurant'
            ),
            'excluded' => array(
                'Personal expenses',
                'Tips',
                'Dinner'
            ),
        ),
        array(
            'title' => 'Nusa Penida Island Day Trip',
            'content' => '<p>Escape to Nusa Penida, a stunning island paradise just off the coast of Bali. This full-day adventure takes you to the island\'s most iconic spots including Kelingking Beach, Angel\'s Billabong, and Broken Beach.</p>

<p>Marvel at dramatic cliff formations, crystal clear waters, and untouched natural beauty. The T-Rex shaped cliff at Kelingking is one of the most photographed spots in all of Indonesia.</p>

<p>This tour includes fast boat transfers, comfortable transportation on the island, and plenty of time to explore and take photos.</p>',
            'excerpt' => 'Visit the famous Kelingking Beach, Angel\'s Billabong, and explore paradise island.',
            'price' => 850000,
            'sale_price' => 750000,
            'duration' => 'Full Day',
            'group_size' => 12,
            'location' => 'Nusa Penida',
            'type' => 'Adventure',
            'highlights' => array(
                'Kelingking Beach (T-Rex viewpoint)',
                'Angel\'s Billabong natural infinity pool',
                'Broken Beach rock formation',
                'Crystal Bay snorkeling (optional)',
                'Fast boat sea transfer'
            ),
            'included' => array(
                'Hotel pickup and drop-off',
                'Fast boat round trip',
                'Land transport on Nusa Penida',
                'Entrance fees',
                'Lunch',
                'English-speaking guide'
            ),
            'excluded' => array(
                'Snorkeling gear rental',
                'Personal expenses',
                'Tips'
            ),
        ),
        array(
            'title' => 'Uluwatu Temple & Kecak Fire Dance',
            'content' => '<p>Experience the magic of Bali\'s most spectacular temple perched on a dramatic cliff 70 meters above the Indian Ocean. Uluwatu Temple is one of six key temples believed to be Bali\'s spiritual pillars.</p>

<p>As the sun sets, watch the mesmerizing Kecak Fire Dance performance, a traditional Balinese dance drama performed by over 100 men chanting and dancing in a trance-like state.</p>

<p>End your evening with a delicious seafood dinner at Jimbaran Bay, dining on the beach with your feet in the sand.</p>',
            'excerpt' => 'Witness stunning sunset at clifftop temple followed by traditional Kecak dance performance.',
            'price' => 550000,
            'sale_price' => 0,
            'duration' => '5 hours',
            'group_size' => 20,
            'location' => 'Uluwatu',
            'type' => 'Cultural',
            'highlights' => array(
                'Uluwatu Temple at sunset',
                'Kecak Fire Dance performance',
                'Seafood dinner at Jimbaran Bay',
                'Ocean cliff views',
                'Friendly temple monkeys'
            ),
            'included' => array(
                'Hotel pickup and drop-off',
                'Temple entrance fee',
                'Kecak dance ticket',
                'Seafood dinner',
                'Sarong rental'
            ),
            'excluded' => array(
                'Drinks',
                'Tips',
                'Personal expenses'
            ),
        ),
        array(
            'title' => 'Bali Swing & Rice Terrace Experience',
            'content' => '<p>Fly high above the jungle on the famous Bali Swing and capture Instagram-worthy photos with stunning backdrop views. This tour combines thrilling swing experiences with beautiful rice terrace walks.</p>

<p>Choose from various swing heights and styles, from romantic couple swings to adrenaline-pumping solo swings over the valley. Afterward, explore traditional Balinese rice terraces and learn about the ancient irrigation system.</p>

<p>Perfect for couples, families, and anyone looking for a unique Bali experience.</p>',
            'excerpt' => 'Swing over jungle valleys and walk through stunning rice terraces for the perfect photos.',
            'price' => 500000,
            'sale_price' => 450000,
            'duration' => '4 hours',
            'group_size' => 10,
            'location' => 'Ubud',
            'type' => 'Adventure',
            'highlights' => array(
                'Multiple swing experiences included',
                'Instagram-worthy photo spots',
                'Rice terrace walk',
                'Luwak coffee tasting',
                'Professional photography'
            ),
            'included' => array(
                'Hotel pickup and drop-off',
                'All swing activities',
                'Rice terrace entrance',
                'Coffee/tea tasting',
                'Basic photography service'
            ),
            'excluded' => array(
                'Premium photography package',
                'Lunch',
                'Tips'
            ),
        ),
        array(
            'title' => 'Romantic Honeymoon Package',
            'content' => '<p>Create unforgettable memories with your loved one in this specially designed honeymoon experience. Enjoy private beach dinners, couples spa treatments, and exclusive tours to Bali\'s most romantic destinations.</p>

<p>This 3-day package includes luxury accommodation, candlelit dinners, flower bath experiences, and guided tours to hidden gems perfect for couples.</p>

<p>Let us handle all the details while you focus on celebrating your love in paradise.</p>',
            'excerpt' => 'Complete romantic getaway package with spa, private dinners, and exclusive couple experiences.',
            'price' => 5500000,
            'sale_price' => 4800000,
            'duration' => '3 Days',
            'group_size' => 2,
            'location' => 'Ubud',
            'type' => 'Honeymoon',
            'highlights' => array(
                'Private candlelit beach dinner',
                'Couples spa treatment',
                'Flower bath experience',
                'Sunrise champagne picnic',
                'Romantic temple visit'
            ),
            'included' => array(
                '2 nights luxury accommodation',
                'Daily breakfast',
                'Airport transfers',
                'All activities as described',
                'Romance package amenities'
            ),
            'excluded' => array(
                'Flights',
                'Travel insurance',
                'Personal expenses'
            ),
        ),
    );

    foreach ($tours as $tour_data) {
        // Check if tour already exists
        $existing = get_page_by_title($tour_data['title'], OBJECT, 'tour');
        if ($existing)
            continue;

        $tour_id = wp_insert_post(array(
            'post_type' => 'tour',
            'post_title' => $tour_data['title'],
            'post_content' => $tour_data['content'],
            'post_excerpt' => $tour_data['excerpt'],
            'post_status' => 'publish',
        ));

        if ($tour_id && !is_wp_error($tour_id)) {
            // Add meta
            update_post_meta($tour_id, '_bbt_tour_price', $tour_data['price']);
            update_post_meta($tour_id, '_bbt_tour_sale_price', $tour_data['sale_price']);
            update_post_meta($tour_id, '_bbt_tour_duration', $tour_data['duration']);
            update_post_meta($tour_id, '_bbt_tour_group_size', $tour_data['group_size']);
            update_post_meta($tour_id, '_bbt_tour_highlights', $tour_data['highlights']);
            update_post_meta($tour_id, '_bbt_tour_included', $tour_data['included']);
            update_post_meta($tour_id, '_bbt_tour_excluded', $tour_data['excluded']);
            update_post_meta($tour_id, '_bbt_tour_featured', true);

            // Add taxonomies
            wp_set_object_terms($tour_id, $tour_data['location'], 'tour_location');
            wp_set_object_terms($tour_id, $tour_data['type'], 'tour_type');
        }
    }
}

/**
 * Import Demo Activities
 */
function bbt_import_demo_activities()
{
    $activities = array(
        array(
            'title' => 'Bali Rafting Adventure',
            'content' => '<p>Experience thrilling white water rafting on the Ayung River, Bali\'s longest river flowing through a stunning rainforest gorge.</p><p>Navigate through class II-III rapids while enjoying beautiful scenery, waterfalls, and wildlife. Suitable for beginners and families.</p>',
            'excerpt' => 'White water rafting through Bali\'s beautiful Ayung River gorge.',
            'price' => 450000,
            'location' => 'Ubud',
        ),
        array(
            'title' => 'Scuba Diving PADI Course',
            'content' => '<p>Get your PADI certification while exploring Bali\'s incredible underwater world. Our professional instructors will guide you through the complete Open Water Diver course.</p><p>Explore coral reefs, tropical fish, and even the famous USAT Liberty shipwreck in Tulamben.</p>',
            'excerpt' => 'Complete PADI Open Water Diver certification in Bali\'s crystal clear waters.',
            'price' => 6500000,
            'location' => 'Nusa Penida',
        ),
        array(
            'title' => 'Balinese Cooking Class',
            'content' => '<p>Learn to cook authentic Balinese dishes with a local family. Start your experience at a traditional market, selecting fresh ingredients.</p><p>Return to a beautiful jungle cooking school where you\'ll prepare 5-7 traditional dishes and enjoy your creations for lunch.</p>',
            'excerpt' => 'Learn traditional Balinese recipes in a hands-on cooking experience.',
            'price' => 350000,
            'location' => 'Ubud',
        ),
    );

    foreach ($activities as $activity_data) {
        $existing = get_page_by_title($activity_data['title'], OBJECT, 'activity');
        if ($existing)
            continue;

        $activity_id = wp_insert_post(array(
            'post_type' => 'activity',
            'post_title' => $activity_data['title'],
            'post_content' => $activity_data['content'],
            'post_excerpt' => $activity_data['excerpt'],
            'post_status' => 'publish',
        ));

        if ($activity_id && !is_wp_error($activity_id)) {
            update_post_meta($activity_id, '_bbt_tour_price', $activity_data['price']);
            wp_set_object_terms($activity_id, $activity_data['location'], 'tour_location');
        }
    }
}

/**
 * Import Demo Pages
 */
function bbt_import_demo_pages()
{
    $pages = array(
        array(
            'title' => 'About Us',
            'content' => '<h2>Welcome to Best Bali Travel</h2>
<p>We are a local Balinese tour operator dedicated to sharing the beauty, culture, and hidden gems of our beloved island with travelers from around the world.</p>

<h3>Our Story</h3>
<p>Founded by passionate local guides, Best Bali Travel was born from a desire to offer authentic, personalized experiences that go beyond typical tourist activities. We believe in sustainable tourism that benefits local communities while creating unforgettable memories for our guests.</p>

<h3>Why Choose Us?</h3>
<ul>
<li><strong>Local Expertise:</strong> All our guides are born and raised in Bali</li>
<li><strong>Personalized Service:</strong> We customize every tour to your preferences</li>
<li><strong>Fair Pricing:</strong> No hidden fees, what you see is what you pay</li>
<li><strong>24/7 Support:</strong> We\'re always available via WhatsApp</li>
</ul>',
            'template' => '',
        ),
        array(
            'title' => 'Contact',
            'content' => '',
            'template' => 'page-contact.php',
        ),
        array(
            'title' => 'Privacy Policy',
            'content' => '<h2>Privacy Policy</h2>
<p>Last updated: January 2026</p>

<h3>Information We Collect</h3>
<p>We collect information you provide directly to us, such as when you make a booking, contact us, or sign up for our newsletter.</p>

<h3>How We Use Your Information</h3>
<p>We use the information we collect to process bookings, communicate with you, and improve our services.</p>

<h3>Information Security</h3>
<p>We implement appropriate security measures to protect your personal information.</p>

<h3>Contact Us</h3>
<p>If you have questions about this Privacy Policy, please contact us via WhatsApp or email.</p>',
            'template' => '',
        ),
        array(
            'title' => 'Terms & Conditions',
            'content' => '<h2>Terms & Conditions</h2>
<p>Last updated: January 2026</p>

<h3>Booking Terms</h3>
<p>All bookings are subject to availability. Full payment is required to confirm your reservation.</p>

<h3>Cancellation Policy</h3>
<ul>
<li>Free cancellation up to 24 hours before the tour start time</li>
<li>50% refund for cancellations between 12-24 hours before</li>
<li>No refund for cancellations less than 12 hours before</li>
</ul>

<h3>Safety & Responsibility</h3>
<p>Guests participate in all activities at their own risk. We recommend purchasing travel insurance.</p>

<h3>Changes to Tours</h3>
<p>We reserve the right to modify tour itineraries due to weather, safety concerns, or other unforeseen circumstances.</p>',
            'template' => '',
        ),
    );

    foreach ($pages as $page_data) {
        $existing = get_page_by_title($page_data['title'], OBJECT, 'page');
        if ($existing)
            continue;

        $page_id = wp_insert_post(array(
            'post_type' => 'page',
            'post_title' => $page_data['title'],
            'post_content' => $page_data['content'],
            'post_status' => 'publish',
        ));

        if ($page_id && !is_wp_error($page_id) && !empty($page_data['template'])) {
            update_post_meta($page_id, '_wp_page_template', $page_data['template']);
        }
    }
}

/**
 * Import Demo Menus
 */
function bbt_import_demo_menus()
{
    // Create Primary Menu
    $menu_name = 'Primary Menu';
    $menu_exists = wp_get_nav_menu_object($menu_name);

    if (!$menu_exists) {
        $menu_id = wp_create_nav_menu($menu_name);

        // Add menu items
        wp_update_nav_menu_item($menu_id, 0, array(
            'menu-item-title' => 'Home',
            'menu-item-url' => home_url('/'),
            'menu-item-status' => 'publish',
        ));

        wp_update_nav_menu_item($menu_id, 0, array(
            'menu-item-title' => 'Tours',
            'menu-item-url' => home_url('/tours/'),
            'menu-item-status' => 'publish',
        ));

        wp_update_nav_menu_item($menu_id, 0, array(
            'menu-item-title' => 'Activities',
            'menu-item-url' => home_url('/activities/'),
            'menu-item-status' => 'publish',
        ));

        $about_page = get_page_by_title('About Us');
        if ($about_page) {
            wp_update_nav_menu_item($menu_id, 0, array(
                'menu-item-title' => 'About',
                'menu-item-object-id' => $about_page->ID,
                'menu-item-object' => 'page',
                'menu-item-type' => 'post_type',
                'menu-item-status' => 'publish',
            ));
        }

        $contact_page = get_page_by_title('Contact');
        if ($contact_page) {
            wp_update_nav_menu_item($menu_id, 0, array(
                'menu-item-title' => 'Contact',
                'menu-item-object-id' => $contact_page->ID,
                'menu-item-object' => 'page',
                'menu-item-type' => 'post_type',
                'menu-item-status' => 'publish',
            ));
        }

        // Assign menu to location
        $locations = get_theme_mod('nav_menu_locations');
        $locations['primary'] = $menu_id;
        set_theme_mod('nav_menu_locations', $locations);
    }
}

/**
 * Sanitize iframe for Google Maps
 */
function bbt_sanitize_iframe($input)
{
    // Allow iframe tags for Google Maps
    $allowed = array(
        'iframe' => array(
            'src' => array(),
            'width' => array(),
            'height' => array(),
            'style' => array(),
            'allowfullscreen' => array(),
            'loading' => array(),
            'referrerpolicy' => array(),
            'frameborder' => array(),
        ),
    );
    return wp_kses($input, $allowed);
}
