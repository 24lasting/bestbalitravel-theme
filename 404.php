<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package BestBaliTravel
 */

get_header();
?>

<main id="primary" class="site-main">
    <section class="error-404 not-found bbt-section">
        <div class="bbt-container">
            <div class="error-404-content" style="text-align: center; max-width: 600px; margin: 0 auto;">

                <!-- 404 Icon -->
                <div class="error-icon" style="font-size: 120px; margin-bottom: 20px;">
                    🏝️
                </div>

                <!-- Error Number -->
                <h1 class="error-number"
                    style="font-size: 100px; font-weight: 800; color: var(--bbt-primary); margin-bottom: 0; line-height: 1;">
                    404
                </h1>

                <!-- Error Title -->
                <h2 class="error-title" style="font-size: 28px; margin-bottom: 20px;">
                    <?php esc_html_e('Oops! Page Not Found', 'bestbalitravel'); ?>
                </h2>

                <!-- Error Description -->
                <p class="error-description" style="color: var(--bbt-gray-500); font-size: 18px; margin-bottom: 30px;">
                    <?php esc_html_e('It looks like the paradise you\'re looking for has moved or doesn\'t exist. Let\'s get you back on track!', 'bestbalitravel'); ?>
                </p>

                <!-- Search Form -->
                <div class="error-search" style="margin-bottom: 30px;">
                    <?php get_search_form(); ?>
                </div>

                <!-- Helpful Links -->
                <div class="error-links">
                    <p style="color: var(--bbt-gray-600); margin-bottom: 15px;">
                        <?php esc_html_e('Or try these helpful links:', 'bestbalitravel'); ?>
                    </p>
                    <div class="error-buttons"
                        style="display: flex; gap: 15px; justify-content: center; flex-wrap: wrap;">
                        <a href="<?php echo esc_url(home_url('/')); ?>" class="bbt-btn bbt-btn-primary">
                            <?php esc_html_e('Back to Home', 'bestbalitravel'); ?>
                        </a>
                        <a href="<?php echo esc_url(get_post_type_archive_link('tour')); ?>"
                            class="bbt-btn bbt-btn-outline">
                            <?php esc_html_e('Browse Tours', 'bestbalitravel'); ?>
                        </a>
                        <a href="<?php echo esc_url(home_url('/contact')); ?>" class="bbt-btn bbt-btn-secondary">
                            <?php esc_html_e('Contact Us', 'bestbalitravel'); ?>
                        </a>
                    </div>
                </div>

                <!-- Popular Tours -->
                <div class="error-popular-tours" style="margin-top: 60px;">
                    <h3 style="margin-bottom: 30px;">
                        <?php esc_html_e('Popular Tours', 'bestbalitravel'); ?>
                    </h3>
                    <div class="bbt-grid"
                        style="grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px;">
                        <?php
                        $popular_tours = new WP_Query(array(
                            'post_type' => 'tour',
                            'posts_per_page' => 3,
                            'meta_key' => '_tour_featured',
                            'meta_value' => '1',
                        ));

                        if ($popular_tours->have_posts()):
                            while ($popular_tours->have_posts()):
                                $popular_tours->the_post();
                                ?>
                                <a href="<?php the_permalink(); ?>" class="bbt-card" style="text-decoration: none;">
                                    <div class="bbt-card-image">
                                        <?php if (has_post_thumbnail()): ?>
                                            <?php the_post_thumbnail('bbt-tour-card'); ?>
                                        <?php endif; ?>
                                    </div>
                                    <div class="bbt-card-body">
                                        <h4 class="bbt-card-title">
                                            <?php the_title(); ?>
                                        </h4>
                                        <?php
                                        $price = get_post_meta(get_the_ID(), '_tour_price', true);
                                        if ($price):
                                            ?>
                                            <div class="bbt-card-price">
                                                <?php echo esc_html(bbt_format_price($price)); ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </a>
                                <?php
                            endwhile;
                            wp_reset_postdata();
                        endif;
                        ?>
                    </div>
                </div>

            </div>
        </div>
    </section>
</main>

<?php
get_footer();
