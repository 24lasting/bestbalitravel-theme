<?php
/**
 * Single Tour Mega Widget for Elementor
 *
 * @package BestBaliTravel
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class BBT_Widget_Single_Tour_Mega extends \Elementor\Widget_Base {

    public function get_name() {
        return 'bbt-single-tour-mega';
    }

    public function get_title() {
        return esc_html__( 'Single Tour (Mega)', 'bestbalitravel' );
    }

    public function get_icon() {
        return 'eicon-text-area';
    }

    public function get_categories() {
        return [ 'bbt-widgets' ];
    }

    protected function register_controls() {
        // --- Header Section ---
        $this->start_controls_section(
            'section_header',
            [
                'label' => esc_html__( 'Header & Title', 'bestbalitravel' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'tour_title',
            [
                'label' => esc_html__( 'Tour Title', 'bestbalitravel' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__( 'Bali Secret Waterfalls Tour', 'bestbalitravel' ),
            ]
        );

        $this->add_control(
            'breadcrumbs',
            [
                'label' => esc_html__( 'Breadcrumbs', 'bestbalitravel' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__( 'Home / Destination / Bali / Bali Secret Waterfalls Tour', 'bestbalitravel' ),
            ]
        );
        $this->end_controls_section();

        // --- Gallery Section ---
        $this->start_controls_section(
            'section_gallery',
            [
                'label' => esc_html__( 'Gallery', 'bestbalitravel' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $gallery_repeater = new \Elementor\Repeater();
        $gallery_repeater->add_control(
            'image',
            [
                'label' => esc_html__( 'Image', 'bestbalitravel' ),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );
        $this->add_control(
            'gallery_images',
            [
                'label' => esc_html__( 'Gallery Images (Recommend 5)', 'bestbalitravel' ),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $gallery_repeater->get_controls(),
                'default' => [
                    [ 'image' => [ 'url' => \Elementor\Utils::get_placeholder_image_src() ] ],
                    [ 'image' => [ 'url' => \Elementor\Utils::get_placeholder_image_src() ] ],
                    [ 'image' => [ 'url' => \Elementor\Utils::get_placeholder_image_src() ] ],
                    [ 'image' => [ 'url' => \Elementor\Utils::get_placeholder_image_src() ] ],
                    [ 'image' => [ 'url' => \Elementor\Utils::get_placeholder_image_src() ] ],
                ],
            ]
        );
        $this->end_controls_section();

        // --- Overview Section ---
        $this->start_controls_section(
            'section_overview',
            [
                'label' => esc_html__( 'Overview & Video', 'bestbalitravel' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        
        $this->add_control(
            'overview_text',
            [
                'label' => esc_html__( 'Overview Description', 'bestbalitravel' ),
                'type' => \Elementor\Controls_Manager::WYSIWYG,
                'default' => esc_html__( 'Explore the majestic hidden waterfalls of Bali on this full-day private tour. You will be visiting Tukad Cepung Waterfall, Tegenungan Waterfall, and Tibumana Waterfall.', 'bestbalitravel' ),
            ]
        );
        
        $this->add_control(
            'video_thumbnail',
            [
                'label' => esc_html__( 'Video Thumbnail', 'bestbalitravel' ),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );
        
        $this->add_control(
            'video_url',
            [
                'label' => esc_html__( 'Video URL (YouTube)', 'bestbalitravel' ),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => esc_html__( 'https://your-link.com', 'bestbalitravel' ),
                'default' => [
                    'url' => 'https://www.youtube.com/watch?v=XHOmBV4js_E',
                ],
            ]
        );
        $this->end_controls_section();

        // --- Info Badges Section ---
        $this->start_controls_section(
            'section_info_badges',
            [
                'label' => esc_html__( 'Quick Info Tags', 'bestbalitravel' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $tag_repeater = new \Elementor\Repeater();
        $tag_repeater->add_control(
            'icon',
            [
                'label' => esc_html__( 'Icon', 'bestbalitravel' ),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-clock',
                    'library' => 'solid',
                ],
            ]
        );
        $tag_repeater->add_control(
            'text',
            [
                'label' => esc_html__( 'Text', 'bestbalitravel' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__( '8 Hours', 'bestbalitravel' ),
            ]
        );
        $this->add_control(
            'info_badges',
            [
                'label' => esc_html__( 'Badges', 'bestbalitravel' ),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $tag_repeater->get_controls(),
                'default' => [
                    [ 'text' => '8 Hours', 'icon' => ['value' => 'far fa-clock'] ],
                    [ 'text' => '2-10 Persons', 'icon' => ['value' => 'fas fa-user-friends'] ],
                    [ 'text' => '2 Options', 'icon' => ['value' => 'fas fa-sliders-h'] ],
                ],
            ]
        );
        $this->end_controls_section();

        // --- Perks Section ---
        $this->start_controls_section(
            'section_perks',
            [
                'label' => esc_html__( 'Included Perks', 'bestbalitravel' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'perks_title',
            [
                'label' => esc_html__( 'Section Title', 'bestbalitravel' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__( 'Our Special Included Perks', 'bestbalitravel' ),
            ]
        );
        $perks_repeater = new \Elementor\Repeater();
        $perks_repeater->add_control(
            'icon',
            [
                'label' => esc_html__( 'Icon', 'bestbalitravel' ),
                'type' => \Elementor\Controls_Manager::ICONS,
            ]
        );
        $perks_repeater->add_control(
            'title',
            [
                'label' => esc_html__( 'Title', 'bestbalitravel' ),
                'type' => \Elementor\Controls_Manager::TEXT,
            ]
        );
        $this->add_control(
            'perks_items',
            [
                'label' => esc_html__( 'Items', 'bestbalitravel' ),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $perks_repeater->get_controls(),
                'default' => [
                    [ 'title' => 'Free Cancellation', 'icon' => ['value' => 'fas fa-check-circle'] ],
                    [ 'title' => 'Private Guide', 'icon' => ['value' => 'fas fa-user-shield'] ],
                    [ 'title' => 'Customizable', 'icon' => ['value' => 'fas fa-pencil-alt'] ],
                    [ 'title' => 'Pick-up included', 'icon' => ['value' => 'fas fa-car'] ],
                ],
            ]
        );
        $this->end_controls_section();

        // --- Itinerary Section ---
        $this->start_controls_section(
            'section_itinerary',
            [
                'label' => esc_html__( 'Itinerary Timeline', 'bestbalitravel' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $iti_repeater = new \Elementor\Repeater();
        $iti_repeater->add_control(
            'time',
            [
                'label' => esc_html__( 'Time', 'bestbalitravel' ),
                'type' => \Elementor\Controls_Manager::TEXT,
            ]
        );
        $iti_repeater->add_control(
            'title',
            [
                'label' => esc_html__( 'Title/Location', 'bestbalitravel' ),
                'type' => \Elementor\Controls_Manager::TEXT,
            ]
        );
        $iti_repeater->add_control(
            'description',
            [
                'label' => esc_html__( 'Description', 'bestbalitravel' ),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
            ]
        );
        $this->add_control(
            'itinerary_items',
            [
                'label' => esc_html__( 'Timeline Stops', 'bestbalitravel' ),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $iti_repeater->get_controls(),
                'title_field' => '{{{ time }}} - {{{ title }}}',
                'default' => [
                    [ 'time' => '08:00', 'title' => 'Pick up from hotel', 'description' => 'Our driver will meet you.' ],
                    [ 'time' => '09:00', 'title' => 'Tegenungan Waterfall', 'description' => 'Enjoy the morning mist.' ],
                    [ 'time' => '11:00', 'title' => 'Tibumana Waterfall', 'description' => 'Hidden gem.' ],
                ],
            ]
        );
        $this->end_controls_section();

        // --- Booking Widget ---
        $this->start_controls_section(
            'section_booking',
            [
                'label' => esc_html__( 'Booking Sidebar Box', 'bestbalitravel' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'price_starting',
            [
                'label' => esc_html__( 'Starting Price', 'bestbalitravel' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__( '$55 USD', 'bestbalitravel' ),
            ]
        );
        $this->add_control(
            'booking_cta_text',
            [
                'label' => esc_html__( 'CTA Button Text', 'bestbalitravel' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__( 'Book Now', 'bestbalitravel' ),
            ]
        );
        $this->add_control(
            'booking_cta_link',
            [
                'label' => esc_html__( 'CTA Link', 'bestbalitravel' ),
                'type' => \Elementor\Controls_Manager::URL,
                'default' => [ 'url' => '#' ],
            ]
        );
        $this->end_controls_section();

        // --- Reviews Section ---
        $this->start_controls_section(
            'section_reviews',
            [
                'label' => esc_html__( 'Reviews Section', 'bestbalitravel' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'reviews_title',
            [
                'label' => esc_html__( 'Section Title', 'bestbalitravel' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__( 'Guest Reviews', 'bestbalitravel' ),
            ]
        );
        $this->add_control(
            'reviews_average',
            [
                'label' => esc_html__( 'Average Score (e.g. 5.0)', 'bestbalitravel' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => '5.0',
            ]
        );
        $review_repeater = new \Elementor\Repeater();
        $review_repeater->add_control(
            'author',
            [
                'label' => esc_html__( 'Author Name', 'bestbalitravel' ),
                'type' => \Elementor\Controls_Manager::TEXT,
            ]
        );
        $review_repeater->add_control(
            'date',
            [
                'label' => esc_html__( 'Date', 'bestbalitravel' ),
                'type' => \Elementor\Controls_Manager::TEXT,
            ]
        );
        $review_repeater->add_control(
            'text',
            [
                'label' => esc_html__( 'Review Text', 'bestbalitravel' ),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
            ]
        );
        $this->add_control(
            'reviews_items',
            [
                'label' => esc_html__( 'Review Items', 'bestbalitravel' ),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $review_repeater->get_controls(),
                'default' => [
                    [ 'author' => 'John Doe', 'date' => 'October 12, 2024', 'text' => 'Amazing tour! The waterfalls were breathtaking and our guide was totally super friendly and helpful.' ]
                ],
            ]
        );
        $this->end_controls_section();

        // --- Why Choose Us Banner ---
        $this->start_controls_section(
            'section_why_us',
            [
                'label' => esc_html__( 'Why We Are Different Banner', 'bestbalitravel' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'why_us_title',
            [
                'label' => esc_html__( 'Title', 'bestbalitravel' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__( 'WHY WE\'RE DIFFERENT', 'bestbalitravel' ),
            ]
        );
        $this->add_control(
            'why_us_desc',
            [
                'label' => esc_html__( 'Description Text', 'bestbalitravel' ),
                'type' => \Elementor\Controls_Manager::WYSIWYG,
            ]
        );
        $this->add_control(
            'why_us_image',
            [
                'label' => esc_html__( 'Character/Hero Image', 'bestbalitravel' ),
                'type' => \Elementor\Controls_Manager::MEDIA,
            ]
        );
        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>
        <div class="bbt-mega-tour">
            
            <!-- STYLES -->
            <style>
                .bbt-mega-tour { font-family: 'Inter', sans-serif; color: #333; }
                .bbt-tour-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
                .bbt-tour-header h1 { font-size: 32px; font-weight: 800; margin: 0; line-height: 1.2; }
                .bbt-breadcrumbs { color: #888; font-size: 14px; margin-bottom: 10px; }
                .bbt-tour-actions { display: flex; gap: 15px; }
                .bbt-tour-actions a { color: #333; text-decoration: none; font-weight: 600; display: flex; align-items: center; gap: 5px; cursor: pointer; }
                .bbt-tour-actions a i { color: #f5b026; }
                
                /* Gallery Grid */
                .bbt-tour-gallery { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; height: 500px; border-radius: 12px; overflow: hidden; margin-bottom: 40px; }
                .bbt-tour-gallery .bbt-gal-main { width: 100%; height: 100%; background-size: cover; background-position: center; }
                .bbt-gal-subgrid { display: grid; grid-template-columns: 1fr 1fr; grid-template-rows: 1fr 1fr; gap: 10px; height: 100%; }
                .bbt-gal-subgrid .bbt-gal-item { width: 100%; height: 100%; background-size: cover; background-position: center; position: relative; }
                .bbt-gal-item.has-more::after { content: ''; position: absolute; inset: 0; background: rgba(0,0,0,0.4); }
                .bbt-see-all-btn { position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); padding: 10px 20px; background: white; color: black; font-weight: bold; border-radius: 8px; z-index: 2; border: none; cursor: pointer; white-space: nowrap; }

                /* Layout Split */
                .bbt-tour-layout { display: flex; gap: 40px; margin-bottom: 60px; }
                .bbt-tour-main { flex: 1; min-width: 0; }
                .bbt-tour-sidebar { width: 350px; flex-shrink: 0; }
                
                /* Main Info Badges */
                .bbt-info-row { display: flex; flex-wrap: wrap; gap: 15px; margin-bottom: 30px; }
                .bbt-info-badge { display: flex; align-items: center; gap: 8px; padding: 8px 16px; background: #fffcf0; border: 1px solid #fce7b0; border-radius: 50px; font-weight: 600; color: #b1851e; font-size: 14px; }
                
                /* Overview & Video */
                .bbt-tour-overview { font-size: 16px; line-height: 1.7; color: #555; margin-bottom: 30px; }
                .bbt-tour-video { position: relative; width: 100%; height: 350px; border-radius: 16px; background-size: cover; background-position: center; margin-bottom: 40px; display: flex; align-items: center; justify-content: center; }
                .bbt-tour-video::before { content: ''; position: absolute; inset: 0; background: rgba(0,0,0,0.3); border-radius: 16px; }
                .bbt-play-btn { width: 70px; height: 70px; background: #fce824; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 24px; color: #000; position: relative; z-index: 2; cursor: pointer; transition: transform 0.2s; box-shadow: 0 10px 20px rgba(0,0,0,0.2); }
                .bbt-play-btn:hover { transform: scale(1.1); }
                .bbt-play-btn i { margin-left: 5px; }

                /* Perks Grid */
                .bbt-perks-section { background: #fffdf5; border: 1px solid #fbedc5; border-radius: 20px; padding: 30px; margin-bottom: 50px; text-align: center; }
                .bbt-perks-section h3 { font-size: 20px; font-weight: 800; margin-bottom: 25px; color: #333; }
                .bbt-perks-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px; }
                .bbt-perk-card { background: white; border-radius: 12px; padding: 15px; display: flex; align-items: center; gap: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.03); border: 1px solid #f6f6f6; text-align: left; }
                .bbt-perk-card i { font-size: 24px; color: #ffca28; }
                .bbt-perk-card span { font-weight: 700; font-size: 15px; }

                /* Timeline */
                .bbt-timeline-wrap { margin-bottom: 50px; }
                .bbt-timeline-wrap h3 { font-size: 24px; font-weight: 800; margin-bottom: 25px; }
                .bbt-timeline { position: relative; padding-left: 30px; }
                .bbt-timeline::before { content: ''; position: absolute; left: 6px; top: 0; bottom: 0; width: 2px; background: #f0f0f0; }
                .bbt-timeline-item { position: relative; margin-bottom: 30px; }
                .bbt-timeline-item:last-child { margin-bottom: 0; }
                .bbt-timeline-marker { position: absolute; left: -30px; width: 14px; height: 14px; background: #ffcc00; border-radius: 50%; border: 3px solid white; box-shadow: 0 0 0 2px #ffcc00; top: 5px; }
                .bbt-timeline-content h4 { margin: 0 0 5px 0; font-size: 16px; font-weight: 700; }
                .bbt-timeline-time { display: inline-block; padding: 3px 10px; background: #f5f5f5; border-radius: 4px; font-size: 13px; font-weight: 600; margin-bottom: 10px; color: #555; }
                .bbt-timeline-desc { font-size: 14px; color: #666; line-height: 1.6; }

                /* Booking Sidebar */
                .bbt-booking-sticky { position: sticky; top: 100px; background: white; border-radius: 20px; padding: 30px; box-shadow: 0 10px 40px rgba(0,0,0,0.08); border: 1px solid #f0f0f0; }
                .bbt-price-head { font-size: 16px; color: #666; font-weight: 600; margin-bottom: 20px; padding-bottom: 20px; border-bottom: 1px solid #eee; }
                .bbt-price-head strong { font-size: 24px; color: #111; font-weight: 800; }
                .bbt-form-field { margin-bottom: 15px; }
                .bbt-form-field label { display: block; font-size: 13px; font-weight: 700; margin-bottom: 5px; color: #444; }
                .bbt-form-field input, .bbt-form-field select { width: 100%; padding: 12px 15px; border: 1px solid #ddd; border-radius: 8px; font-family: inherit; font-size: 14px; background: #fcfcfc; }
                .bbt-book-btn { width: 100%; display: block; text-align: center; background: #111; color: white; padding: 15px; font-size: 16px; font-weight: 800; border-radius: 12px; margin-top: 10px; text-decoration: none; cursor: pointer; transition: background 0.2s; }
                .bbt-book-btn:hover { background: #333; color: white; }
                .bbt-booking-guarantee { text-align: center; margin-top: 15px; font-size: 13px; color: #777; display: flex; align-items: center; justify-content: center; gap: 5px; }

                /* Reviews Section */
                .bbt-reviews-section { margin-top: 50px; padding-top: 50px; border-top: 1px solid #f0f0f0; }
                .bbt-reviews-header { margin-bottom: 30px; }
                .bbt-reviews-header h2 { font-size: 28px; font-weight: 800; }
                .bbt-reviews-summary { display: flex; align-items: center; gap: 20px; margin-bottom: 40px; background: #fafafa; padding: 25px; border-radius: 16px; }
                .bbt-rating-huge { font-size: 50px; font-weight: 900; color: #111; line-height: 1; }
                .bbt-rating-stars i { color: #f5b026; font-size: 18px; margin-right: 2px; }
                .bbt-review-card { display: flex; gap: 20px; padding-bottom: 30px; margin-bottom: 30px; border-bottom: 1px solid #f0f0f0; }
                .bbt-review-avatar { width: 50px; height: 50px; background: #e0e0e0; color: #555; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 20px; flex-shrink: 0; }
                .bbt-review-content h4 { margin: 0 0 5px 0; font-size: 16px; font-weight: 700; }
                .bbt-review-meta { font-size: 13px; color: #888; margin-bottom: 10px; }
                .bbt-review-text { font-size: 15px; color: #444; line-height: 1.6; }

                /* Why Different Banner */
                .bbt-why-us { background: #eab308; padding: 80px 40px; border-radius: 30px; display: flex; align-items: center; justify-content: space-between; gap: 40px; margin-top: 80px; position: relative; overflow: hidden; }
                /* Torn paper effect top and bottom via SVG masks or borders - simplified with border-radius for now */
                .bbt-why-us::before, .bbt-why-us::after { content: ''; position: absolute; left: 0; right: 0; height: 30px; background-image: url('data:image/svg+xml;utf8,<svg viewBox="0 0 1440 30" xmlns="http://www.w3.org/2000/svg"><path d="M0,0 C240,30 480,30 720,0 C960,-30 1200,-30 1440,0 L1440,30 L0,30 Z" fill="white"/></svg>'); background-size: cover; background-repeat: repeat-x; }
                .bbt-why-us::before { top: -1px; transform: rotate(180deg); }
                .bbt-why-us::after { bottom: -1px; }
                
                .bbt-why-img img { max-width: 400px; height: auto; position: relative; z-index: 2; filter: drop-shadow(0 20px 30px rgba(0,0,0,0.2)); }
                .bbt-why-text { color: #111; flex: 1; max-width: 600px; z-index: 2; position: relative; }
                .bbt-why-text h2 { font-size: 38px; font-weight: 900; letter-spacing: 2px; text-transform: uppercase; margin-bottom: 25px; line-height: 1.1; display: inline-block; border-bottom: 4px solid #111; padding-bottom: 5px; }
                .bbt-why-text .bbt-desc { font-size: 17px; font-weight: 600; line-height: 1.7; margin-bottom: 30px; }
                .bbt-why-badges { display: flex; gap: 15px; }
                .bbt-why-badges div { width: 70px; height: 70px; background: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 5px 15px rgba(0,0,0,0.1); font-size: 24px; color: #111; }

                /* Responsiveness */
                @media(max-width: 991px) {
                    .bbt-tour-layout { flex-direction: column; }
                    .bbt-tour-sidebar { width: 100%; }
                    .bbt-tour-gallery { height: auto; grid-template-columns: 1fr; }
                    .bbt-gal-main { height: 300px; }
                    .bbt-gal-subgrid { grid-template-columns: 1fr 1fr; grid-template-rows: 150px; }
                    .bbt-gal-item:nth-child(n+3) { display: none; }
                    .bbt-why-us { flex-direction: column; text-align: center; padding: 60px 20px; }
                    .bbt-why-text h2 { margin: 0 auto 25px auto; }
                    .bbt-why-badges { justify-content: center; }
                }
            </style>

            <div class="bbt-breadcrumbs"><?php echo esc_html($settings['breadcrumbs']); ?></div>
            
            <div class="bbt-tour-header">
                <h1><?php echo esc_html($settings['tour_title']); ?></h1>
                <div class="bbt-tour-actions">
                    <a href="#"><i class="fas fa-share-alt"></i> Share</a>
                    <a href="#"><i class="far fa-heart"></i> Save to Wishlist</a>
                </div>
            </div>

            <?php if (!empty($settings['gallery_images']) && is_array($settings['gallery_images'])) : ?>
            <div class="bbt-tour-gallery">
                <?php $main_bg = $settings['gallery_images'][0]['image']['url']; ?>
                <div class="bbt-gal-main" style="background-image: url('<?php echo esc_url($main_bg); ?>');"></div>
                <div class="bbt-gal-subgrid">
                    <?php 
                    for ($i = 1; $i <= 4; $i++) {
                        if (isset($settings['gallery_images'][$i])) {
                            $bg = $settings['gallery_images'][$i]['image']['url'];
                            $class = 'bbt-gal-item';
                            $btn = '';
                            if ($i == 4 && count($settings['gallery_images']) > 5) {
                                $class .= ' has-more';
                                $btn = '<button class="bbt-see-all-btn"><i class="fas fa-th"></i> See All Photos</button>';
                            }
                            echo '<div class="' . esc_attr($class) . '" style="background-image: url(\'' . esc_url($bg) . '\');">' . $btn . '</div>';
                        }
                    }
                    ?>
                </div>
            </div>
            <?php endif; ?>

            <div class="bbt-tour-layout">
                <div class="bbt-tour-main">
                    
                    <div class="bbt-info-row">
                        <?php foreach($settings['info_badges'] as $badge): ?>
                        <div class="bbt-info-badge">
                            <?php \Elementor\Icons_Manager::render_icon( $badge['icon'], [ 'aria-hidden' => 'true' ] ); ?>
                            <?php echo esc_html($badge['text']); ?>
                        </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="bbt-tour-overview">
                        <?php echo wp_kses_post($settings['overview_text']); ?>
                    </div>

                    <?php if(!empty($settings['video_thumbnail']['url'])): ?>
                    <div class="bbt-tour-video" style="background-image: url('<?php echo esc_url($settings['video_thumbnail']['url']); ?>');">
                        <a href="<?php echo esc_url($settings['video_url']['url'] ?? '#'); ?>" target="_blank" class="bbt-play-btn">
                            <i class="fas fa-play"></i>
                        </a>
                    </div>
                    <?php endif; ?>

                    <?php if(!empty($settings['perks_items'])): ?>
                    <div class="bbt-perks-section">
                        <h3><i class="fas fa-crown" style="color:#f5b026;"></i> <?php echo esc_html($settings['perks_title']); ?></h3>
                        <div class="bbt-perks-grid">
                            <?php foreach($settings['perks_items'] as $perk): ?>
                            <div class="bbt-perk-card">
                                <?php \Elementor\Icons_Manager::render_icon( $perk['icon'], [ 'aria-hidden' => 'true' ] ); ?>
                                <span><?php echo esc_html($perk['title']); ?></span>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>

                    <?php if(!empty($settings['itinerary_items'])): ?>
                    <div class="bbt-timeline-wrap">
                        <h3>Tour Itinerary</h3>
                        <div class="bbt-timeline">
                            <?php foreach($settings['itinerary_items'] as $iti): ?>
                            <div class="bbt-timeline-item">
                                <div class="bbt-timeline-marker"></div>
                                <div class="bbt-timeline-content">
                                    <span class="bbt-timeline-time"><?php echo esc_html($iti['time']); ?></span>
                                    <h4><?php echo esc_html($iti['title']); ?></h4>
                                    <div class="bbt-timeline-desc"><?php echo wp_kses_post($iti['description']); ?></div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>

                </div>
                
                <div class="bbt-tour-sidebar">
                    <div class="bbt-booking-sticky">
                        <div class="bbt-price-head">
                            From <strong><?php echo esc_html($settings['price_starting']); ?></strong> / person
                        </div>
                        <div class="bbt-form-field">
                            <label>Select Date</label>
                            <input type="date" value="<?php echo date('Y-m-d'); ?>">
                        </div>
                        <div class="bbt-form-field">
                            <label>Guests</label>
                            <select>
                                <option>1 Adult</option>
                                <option selected>2 Adults</option>
                                <option>3 Adults</option>
                            </select>
                        </div>
                        <a href="<?php echo esc_url($settings['booking_cta_link']['url'] ?? '#'); ?>" class="bbt-book-btn">
                            <?php echo esc_html($settings['booking_cta_text']); ?>
                        </a>
                        <div class="bbt-booking-guarantee">
                            <i class="fas fa-shield-alt"></i> Secure Payment Guarantee
                        </div>
                    </div>
                </div>
            </div>

            <!-- Reviews Section -->
            <?php if (!empty($settings['reviews_items'])): ?>
            <div class="bbt-reviews-section">
                <div class="bbt-reviews-header">
                    <h2><?php echo esc_html($settings['reviews_title']); ?></h2>
                </div>
                <div class="bbt-reviews-summary">
                    <div class="bbt-rating-huge"><?php echo esc_html($settings['reviews_average']); ?></div>
                    <div>
                        <div class="bbt-rating-stars">
                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                        </div>
                        <div style="font-size:14px; color:#666; margin-top:5px;">Based on <?php echo count($settings['reviews_items']); ?> reviews</div>
                    </div>
                </div>
                
                <div class="bbt-reviews-list">
                    <?php foreach($settings['reviews_items'] as $review): 
                        $initial = strtoupper(substr($review['author'], 0, 1));
                    ?>
                    <div class="bbt-review-card">
                        <div class="bbt-review-avatar"><?php echo esc_html($initial); ?></div>
                        <div class="bbt-review-content">
                            <h4><?php echo esc_html($review['author']); ?></h4>
                            <div class="bbt-review-meta">
                                <span class="bbt-rating-stars" style="font-size:12px;"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></span>
                                &bull; <?php echo esc_html($review['date']); ?>
                            </div>
                            <div class="bbt-review-text">
                                <?php echo wp_kses_post($review['text']); ?>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>

            <!-- Why We're Different Banner -->
            <div class="bbt-why-us">
                <?php if(!empty($settings['why_us_image']['url'])): ?>
                <div class="bbt-why-img">
                    <img src="<?php echo esc_url($settings['why_us_image']['url']); ?>" alt="Why us">
                </div>
                <?php endif; ?>
                <div class="bbt-why-text">
                    <h2><?php echo esc_html($settings['why_us_title']); ?></h2>
                    <div class="bbt-desc">
                        <?php echo wp_kses_post($settings['why_us_desc']); ?>
                    </div>
                    <div class="bbt-why-badges">
                        <div><i class="fab fa-tripadvisor"></i></div>
                        <div><i class="fab fa-google"></i></div>
                        <div><i class="fab fa-facebook"></i></div>
                    </div>
                </div>
            </div>

        </div>
        <?php
    }
}
