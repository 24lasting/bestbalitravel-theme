<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package BestBaliTravel
 */

get_header();
?>

<main id="primary" class="site-main">

    <!-- Search Header -->
    <section class="search-header"
        style="background: linear-gradient(135deg, var(--bbt-primary), #e09000); padding: 60px 0; color: white;">
        <div class="bbt-container" style="text-align: center;">
            <h1 class="search-title" style="color: white; margin-bottom: 10px;">
                <?php
                /* translators: %s: search query. */
                printf(esc_html__('Search Results for: %s', 'bestbalitravel'), '<span style="font-weight: 800;">' . get_search_query() . '</span>');
                ?>
            </h1>
            <p style="opacity: 0.9; margin-bottom: 20px;">
                <?php
                global $wp_query;
                /* translators: %d: number of results */
                printf(esc_html(_n('%d result found', '%d results found', $wp_query->found_posts, 'bestbalitravel')), intval($wp_query->found_posts));
                ?>
            </p>

            <!-- Search Form -->
            <div style="max-width: 500px; margin: 0 auto;">
                <?php get_search_form(); ?>
            </div>
        </div>
    </section>

    <!-- Search Results -->
    <section class="search-results bbt-section">
        <div class="bbt-container">
            <?php if (have_posts()): ?>

                <div class="search-results-grid bbt-grid"
                    style="grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 24px;">
                    <?php
                    while (have_posts()):
                        the_post();
                        ?>
                        <article id="post-<?php the_ID(); ?>" <?php post_class('bbt-card'); ?>>
                            <?php if (has_post_thumbnail()): ?>
                                <div class="bbt-card-image">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail('bbt-tour-card'); ?>
                                    </a>
                                </div>
                            <?php endif; ?>

                            <div class="bbt-card-body">
                                <!-- Post Type Badge -->
                                <span class="bbt-badge bbt-badge-primary" style="margin-bottom: 10px; display: inline-block;">
                                    <?php echo esc_html(get_post_type_object(get_post_type())->labels->singular_name); ?>
                                </span>

                                <h3 class="bbt-card-title">
                                    <a href="<?php the_permalink(); ?>" style="color: inherit;">
                                        <?php the_title(); ?>
                                    </a>
                                </h3>

                                <div class="bbt-card-meta">
                                    <span>
                                        <?php echo esc_html(get_the_date()); ?>
                                    </span>
                                </div>

                                <p style="color: var(--bbt-gray-600); font-size: 14px; margin-bottom: 15px;">
                                    <?php echo esc_html(wp_trim_words(get_the_excerpt(), 20, '...')); ?>
                                </p>

                                <?php if ('tour' === get_post_type()): ?>
                                    <?php
                                    $price = get_post_meta(get_the_ID(), '_tour_price', true);
                                    if ($price):
                                        ?>
                                        <div class="bbt-card-price">
                                            <?php echo esc_html(bbt_format_price($price)); ?>
                                        </div>
                                    <?php endif; ?>
                                <?php endif; ?>

                                <a href="<?php the_permalink(); ?>" class="bbt-btn bbt-btn-outline bbt-btn-sm"
                                    style="margin-top: 10px;">
                                    <?php esc_html_e('View Details', 'bestbalitravel'); ?>
                                </a>
                            </div>
                        </article>
                    <?php endwhile; ?>
                </div>

                <!-- Pagination -->
                <div class="search-pagination" style="margin-top: 40px; text-align: center;">
                    <?php
                    the_posts_pagination(array(
                        'mid_size' => 2,
                        'prev_text' => '&laquo; ' . esc_html__('Previous', 'bestbalitravel'),
                        'next_text' => esc_html__('Next', 'bestbalitravel') . ' &raquo;',
                    ));
                    ?>
                </div>

            <?php else: ?>

                <!-- No Results -->
                <div class="no-results" style="text-align: center; padding: 60px 20px;">
                    <div style="font-size: 80px; margin-bottom: 20px;">🔍</div>
                    <h2>
                        <?php esc_html_e('No Results Found', 'bestbalitravel'); ?>
                    </h2>
                    <p style="color: var(--bbt-gray-500); margin-bottom: 30px;">
                        <?php esc_html_e('Sorry, but nothing matched your search terms. Please try again with different keywords.', 'bestbalitravel'); ?>
                    </p>

                    <!-- Search Suggestions -->
                    <div class="search-suggestions" style="max-width: 400px; margin: 0 auto;">
                        <p style="font-weight: 600; margin-bottom: 15px;">
                            <?php esc_html_e('Try searching for:', 'bestbalitravel'); ?>
                        </p>
                        <div style="display: flex; gap: 10px; flex-wrap: wrap; justify-content: center;">
                            <a href="<?php echo esc_url(home_url('?s=bali+tour')); ?>"
                                class="bbt-btn bbt-btn-sm bbt-btn-outline">Bali Tour</a>
                            <a href="<?php echo esc_url(home_url('?s=nusa+penida')); ?>"
                                class="bbt-btn bbt-btn-sm bbt-btn-outline">Nusa Penida</a>
                            <a href="<?php echo esc_url(home_url('?s=ubud')); ?>"
                                class="bbt-btn bbt-btn-sm bbt-btn-outline">Ubud</a>
                            <a href="<?php echo esc_url(home_url('?s=temple')); ?>"
                                class="bbt-btn bbt-btn-sm bbt-btn-outline">Temple</a>
                        </div>
                    </div>

                    <div style="margin-top: 30px;">
                        <a href="<?php echo esc_url(home_url('/')); ?>" class="bbt-btn bbt-btn-primary">
                            <?php esc_html_e('Back to Home', 'bestbalitravel'); ?>
                        </a>
                    </div>
                </div>

            <?php endif; ?>
        </div>
    </section>

</main>

<?php
get_footer();
