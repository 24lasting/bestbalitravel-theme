<?php
/**
 * Front Page Template
 *
 * @package BestBaliTravel
 */

get_header();

// Check if Elementor is active and this page is built with Elementor
$is_elementor = false;
if (class_exists('\Elementor\Plugin')) {
    $is_elementor = \Elementor\Plugin::$instance->documents->get(get_the_ID())->is_built_with_elementor();
}

// Start the loop (required for Elementor)
while (have_posts()) : the_post();
?>

<main id="main" class="site-main">

<?php 
// If Elementor is building this page, show Elementor content
if ($is_elementor): 
?>
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <?php the_content(); ?>
    </article>
<?php 
// Otherwise show default theme content
else:
    $hero_title = get_theme_mod('bbt_hero_title', 'BEST BALI TRAVEL');
    $hero_subtitle = get_theme_mod('bbt_hero_subtitle', 'Explore Bali the Right Way');
    $hero_bg = get_theme_mod('bbt_hero_bg');
    $featured_count = get_theme_mod('bbt_featured_count', 6);
?>

    <!-- Hero Section -->
    <section class="bbt-hero" <?php if ($hero_bg): ?>style="background-image: url('
        <?php echo esc_url(wp_get_attachment_image_url($hero_bg, 'full')); ?>');"
        <?php endif; ?>>
        <div class="bbt-hero-overlay"></div>
        <div class="bbt-container">
            <div class="bbt-hero-content">
                <h1 class="bbt-hero-title">
                    <?php echo esc_html($hero_title); ?>
                </h1>
                <p class="bbt-hero-subtitle">
                    <?php echo esc_html($hero_subtitle); ?>
                </p>

                <!-- Search Form -->
                <div class="bbt-hero-search">
                    <form class="bbt-search-form" action="<?php echo esc_url(home_url('/tours/')); ?>" method="get">
                        <div class="bbt-search-grid">
                            <div class="bbt-search-field">
                                <label>
                                    <?php esc_html_e('Destination', 'bestbalitravel'); ?>
                                </label>
                                <select name="location" class="bbt-form-select">
                                    <option value="">
                                        <?php esc_html_e('All Locations', 'bestbalitravel'); ?>
                                    </option>
                                    <?php
                                    $locations = get_terms(array('taxonomy' => 'tour_location', 'hide_empty' => false));
                                    foreach ($locations as $location):
                                        ?>
                                        <option value="<?php echo esc_attr($location->slug); ?>">
                                            <?php echo esc_html($location->name); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="bbt-search-field">
                                <label>
                                    <?php esc_html_e('Tour Type', 'bestbalitravel'); ?>
                                </label>
                                <select name="type" class="bbt-form-select">
                                    <option value="">
                                        <?php esc_html_e('All Types', 'bestbalitravel'); ?>
                                    </option>
                                    <?php
                                    $types = get_terms(array('taxonomy' => 'tour_type', 'hide_empty' => false));
                                    foreach ($types as $type):
                                        ?>
                                        <option value="<?php echo esc_attr($type->slug); ?>">
                                            <?php echo esc_html($type->name); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="bbt-search-field">
                                <label>
                                    <?php esc_html_e('Date', 'bestbalitravel'); ?>
                                </label>
                                <input type="text" name="date" class="bbt-form-input bbt-datepicker"
                                    placeholder="<?php esc_attr_e('Select date', 'bestbalitravel'); ?>">
                            </div>

                            <button type="submit" class="bbt-btn bbt-btn-primary bbt-btn-lg">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <circle cx="11" cy="11" r="8"></circle>
                                    <path d="M21 21l-4.35-4.35"></path>
                                </svg>
                                <?php esc_html_e('Search', 'bestbalitravel'); ?>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Package Categories -->
    <section class="bbt-section bbt-categories-section">
        <div class="bbt-container">
            <div class="bbt-section-header">
                <h2>
                    <?php esc_html_e('Our Packages', 'bestbalitravel'); ?>
                </h2>
                <p>
                    <?php esc_html_e('Choose from our carefully curated tour packages', 'bestbalitravel'); ?>
                </p>
            </div>

            <div class="bbt-categories-grid">
                <a href="<?php echo esc_url(home_url('/tours/')); ?>" class="bbt-category-card">
                    <div class="bbt-category-icon">🏝️</div>
                    <h3>
                        <?php esc_html_e('Tour Packages', 'bestbalitravel'); ?>
                    </h3>
                    <p>
                        <?php esc_html_e('Explore beautiful Bali destinations', 'bestbalitravel'); ?>
                    </p>
                </a>

                <a href="<?php echo esc_url(home_url('/activities/')); ?>" class="bbt-category-card">
                    <div class="bbt-category-icon">🎯</div>
                    <h3>
                        <?php esc_html_e('Activities', 'bestbalitravel'); ?>
                    </h3>
                    <p>
                        <?php esc_html_e('Adventure and fun activities', 'bestbalitravel'); ?>
                    </p>
                </a>

                <a href="<?php echo esc_url(home_url('/tour-type/honeymoon/')); ?>" class="bbt-category-card">
                    <div class="bbt-category-icon">💑</div>
                    <h3>
                        <?php esc_html_e('Honeymoon', 'bestbalitravel'); ?>
                    </h3>
                    <p>
                        <?php esc_html_e('Romantic getaway packages', 'bestbalitravel'); ?>
                    </p>
                </a>

                <a href="<?php echo esc_url(home_url('/tour-type/airport-transfer/')); ?>" class="bbt-category-card">
                    <div class="bbt-category-icon">✈️</div>
                    <h3>
                        <?php esc_html_e('Airport Transfer', 'bestbalitravel'); ?>
                    </h3>
                    <p>
                        <?php esc_html_e('Comfortable airport pickup', 'bestbalitravel'); ?>
                    </p>
                </a>

                <a href="<?php echo esc_url(home_url('/location/nusa-penida/')); ?>" class="bbt-category-card">
                    <div class="bbt-category-icon">🏖️</div>
                    <h3>
                        <?php esc_html_e('Nusa Penida', 'bestbalitravel'); ?>
                    </h3>
                    <p>
                        <?php esc_html_e('Island paradise experiences', 'bestbalitravel'); ?>
                    </p>
                </a>
            </div>
        </div>
    </section>

    <!-- Popular Locations -->
    <section class="bbt-section bbt-locations-section">
        <div class="bbt-container">
            <div class="bbt-section-header">
                <h2>
                    <?php esc_html_e('Popular Destinations', 'bestbalitravel'); ?>
                </h2>
                <p>
                    <?php esc_html_e('Discover the best of Bali', 'bestbalitravel'); ?>
                </p>
            </div>

            <div class="bbt-locations-grid">
                <?php
                $locations = bbt_get_popular_locations(8);
                if ($locations):
                    foreach ($locations as $location):
                        bbt_location_card($location);
                    endforeach;
                endif;
                ?>
            </div>
        </div>
    </section>

    <!-- Featured Tours -->
    <section class="bbt-section bbt-featured-section">
        <div class="bbt-container">
            <div class="bbt-section-header">
                <h2>
                    <?php esc_html_e('Get Inspired', 'bestbalitravel'); ?>
                </h2>
                <p>
                    <?php esc_html_e('Our most popular tour experiences', 'bestbalitravel'); ?>
                </p>
            </div>

            <div class="bbt-tours-grid">
                <?php
                $featured_tours = bbt_get_featured_tours($featured_count);
                if ($featured_tours->have_posts()):
                    while ($featured_tours->have_posts()):
                        $featured_tours->the_post();
                        bbt_tour_card();
                    endwhile;
                    wp_reset_postdata();
                endif;
                ?>
            </div>

            <div class="bbt-section-footer">
                <a href="<?php echo esc_url(home_url('/tours/')); ?>" class="bbt-btn bbt-btn-outline bbt-btn-lg">
                    <?php esc_html_e('View All Tours', 'bestbalitravel'); ?>
                </a>
            </div>
        </div>
    </section>

    <!-- Why Choose Us -->
    <section class="bbt-section bbt-why-section">
        <div class="bbt-container">
            <div class="bbt-section-header">
                <h2>
                    <?php esc_html_e("Why We're Different", 'bestbalitravel'); ?>
                </h2>
            </div>

            <div class="bbt-why-grid">
                <div class="bbt-why-card">
                    <div class="bbt-why-icon">🏆</div>
                    <h3>
                        <?php esc_html_e('Local Expert Guides', 'bestbalitravel'); ?>
                    </h3>
                    <p>
                        <?php esc_html_e('Our guides are local Balinese who know every hidden gem and cultural insight', 'bestbalitravel'); ?>
                    </p>
                </div>

                <div class="bbt-why-card">
                    <div class="bbt-why-icon">📸</div>
                    <h3>
                        <?php esc_html_e('Personalized Experience', 'bestbalitravel'); ?>
                    </h3>
                    <p>
                        <?php esc_html_e('Tours tailored to your preferences, pace, and interests', 'bestbalitravel'); ?>
                    </p>
                </div>

                <div class="bbt-why-card">
                    <div class="bbt-why-icon">🌱</div>
                    <h3>
                        <?php esc_html_e('Eco-Friendly Tourism', 'bestbalitravel'); ?>
                    </h3>
                    <p>
                        <?php esc_html_e('We support local communities and sustainable tourism practices', 'bestbalitravel'); ?>
                    </p>
                </div>

                <div class="bbt-why-card">
                    <div class="bbt-why-icon">💯</div>
                    <h3>
                        <?php esc_html_e('Best Price Guarantee', 'bestbalitravel'); ?>
                    </h3>
                    <p>
                        <?php esc_html_e('Competitive prices with no hidden fees, what you see is what you pay', 'bestbalitravel'); ?>
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Newsletter -->
    <section class="bbt-section bbt-newsletter-section">
        <div class="bbt-container">
            <div class="bbt-newsletter-content">
                <h2>
                    <?php esc_html_e('Get Special Offers', 'bestbalitravel'); ?>
                </h2>
                <p>
                    <?php esc_html_e('Subscribe to receive exclusive deals and travel tips', 'bestbalitravel'); ?>
                </p>

                <form class="bbt-newsletter-form" id="bbt-newsletter-form">
                    <?php wp_nonce_field('bbt_nonce', 'newsletter_nonce'); ?>
                    <div class="bbt-newsletter-input">
                        <input type="email" name="email"
                            placeholder="<?php esc_attr_e('Enter your email', 'bestbalitravel'); ?>" required>
                        <button type="submit" class="bbt-btn bbt-btn-primary">
                            <?php esc_html_e('Subscribe', 'bestbalitravel'); ?>
                        </button>
                    </div>
                    <div class="bbt-newsletter-message"></div>
                </form>
            </div>
        </div>
    </section>

<?php endif; // End if/else for Elementor check ?>

<?php endwhile; // End the loop ?>

</main>

<?php
get_footer();
