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

    <!-- Premium Apple/Airbnb Style Hero Section -->
    <style>
    /* Full Width & Animations */
    .premium-hero-wrapper {
        margin-left: calc(-50vw + 50%);
        width: 100vw;
    }
    @keyframes kenburns {
        0% { transform: scale(1); }
        100% { transform: scale(1.08); }
    }
    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    </style>
    
    <?php 
    $hero_img = $hero_bg ? wp_get_attachment_image_url($hero_bg, 'full') : 'https://images.unsplash.com/photo-1544644181-1484b3fdfc62?w=1920';
    $locations = get_terms(array('taxonomy' => 'tour_location', 'hide_empty' => false));
    $types = get_terms(array('taxonomy' => 'tour_type', 'hide_empty' => false));
    ?>
    
    <section class="relative h-[85vh] min-h-[600px] max-h-[900px] overflow-hidden bg-black premium-hero-wrapper">
        <!-- Background with Ken Burns -->
        <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('<?php echo esc_url($hero_img); ?>'); animation: kenburns 25s ease-in-out infinite alternate;"></div>
        
        <!-- Gradient Overlay -->
        <div class="absolute inset-0 bg-gradient-to-b from-black/70 via-black/20 to-black/70"></div>
        
        <!-- Content Container -->
        <div class="relative h-full flex flex-col items-center justify-center px-6 sm:px-10 lg:px-20 z-10 w-full max-w-7xl mx-auto">
            
            <div class="text-center w-full max-w-4xl mb-12" style="animation: fadeUp 1s ease-out forwards;">
                <!-- Badge -->
                <div class="flex items-center justify-center gap-4 mb-6">
                    <span class="w-12 sm:w-16 h-px bg-gradient-to-r from-transparent to-amber-500"></span>
                    <span class="text-amber-400 text-xs sm:text-sm font-semibold tracking-[0.25em] uppercase">Best Bali Travel</span>
                    <span class="w-12 sm:w-16 h-px bg-gradient-to-l from-transparent to-amber-500"></span>
                </div>
                
                <h1 class="text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-black text-white leading-tight mb-6 drop-shadow-xl text-center">
                    <?php echo esc_html($hero_title); ?>
                </h1>
                
                <p class="text-lg sm:text-xl text-gray-200 font-light max-w-2xl mx-auto drop-shadow-md text-center">
                    <?php echo esc_html($hero_subtitle); ?>
                </p>
            </div>
            
            <!-- Sleek Search Form -->
            <div class="w-full max-w-5xl bg-white/10 backdrop-blur-md border border-white/20 p-2 lg:p-4 rounded-3xl shadow-2xl" style="animation: fadeUp 1.2s ease-out forwards;">
                <form action="<?php echo esc_url(home_url('/tours/')); ?>" method="get" class="flex flex-col md:flex-row bg-white rounded-2xl overflow-hidden shadow-inner">
                    <!-- Location -->
                    <div class="flex-1 flex items-center px-6 py-5 border-b md:border-b-0 md:border-r border-gray-100 hover:bg-gray-50 transition-colors">
                        <div class="w-full">
                            <label class="block text-xs font-bold text-gray-800 uppercase tracking-wider mb-1">Destination</label>
                            <select name="location" class="w-full bg-transparent text-gray-500 focus:outline-none appearance-none font-medium cursor-pointer">
                                <option value="">Where are you going?</option>
                                <?php foreach ($locations as $loc): ?>
                                    <option value="<?php echo esc_attr($loc->slug); ?>"><?php echo esc_html($loc->name); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    
                    <!-- Type -->
                    <div class="flex-1 flex items-center px-6 py-5 border-b md:border-b-0 md:border-r border-gray-100 hover:bg-gray-50 transition-colors">
                        <div class="w-full">
                            <label class="block text-xs font-bold text-gray-800 uppercase tracking-wider mb-1">Experience</label>
                            <select name="type" class="w-full bg-transparent text-gray-500 focus:outline-none appearance-none font-medium cursor-pointer">
                                <option value="">Select Tour Type</option>
                                <?php foreach ($types as $type): ?>
                                    <option value="<?php echo esc_attr($type->slug); ?>"><?php echo esc_html($type->name); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    
                    <!-- Date -->
                    <div class="flex-1 flex items-center px-6 py-5 border-b md:border-b-0 md:border-r border-gray-100 hover:bg-gray-50 transition-colors">
                        <div class="w-full">
                            <label class="block text-xs font-bold text-gray-800 uppercase tracking-wider mb-1">Date</label>
                            <input type="text" name="date" class="w-full bg-transparent text-gray-500 focus:outline-none font-medium bbt-datepicker" placeholder="Any Date">
                        </div>
                    </div>
                    
                    <!-- Search Button -->
                    <button type="submit" class="bg-amber-500 hover:bg-amber-600 text-white font-bold py-5 px-8 lg:px-12 flex items-center justify-center gap-3 transition-colors text-lg h-auto md:h-auto">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M21 21l-4.35-4.35m1.35-5.65a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        <span class="md:hidden lg:inline">Search</span>
                    </button>
                </form>
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
