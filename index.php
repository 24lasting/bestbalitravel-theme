<?php
/**
 * The main template file
 *
 * @package BestBaliTravel
 */

get_header();
?>

<main id="main" class="site-main">
    <div class="bbt-container">
        <?php if (have_posts()) : ?>
            <div class="bbt-posts-grid">
                <?php while (have_posts()) : the_post(); ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class('bbt-card'); ?>>
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="bbt-card-image">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('bbt-tour-card'); ?>
                                </a>
                            </div>
                        <?php endif; ?>
                        
                        <div class="bbt-card-body">
                            <h2 class="bbt-card-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h2>
                            
                            <div class="bbt-card-excerpt">
                                <?php the_excerpt(); ?>
                            </div>
                            
                            <a href="<?php the_permalink(); ?>" class="bbt-btn bbt-btn-primary">
                                <?php esc_html_e('Read More', 'bestbalitravel'); ?>
                            </a>
                        </div>
                    </article>
                <?php endwhile; ?>
            </div>

            <?php the_posts_pagination(array(
                'mid_size' => 2,
                'prev_text' => '&laquo; ' . __('Previous', 'bestbalitravel'),
                'next_text' => __('Next', 'bestbalitravel') . ' &raquo;',
            )); ?>

        <?php else : ?>
            <div class="bbt-no-posts">
                <h2><?php esc_html_e('No posts found', 'bestbalitravel'); ?></h2>
                <p><?php esc_html_e('Sorry, no posts matched your criteria.', 'bestbalitravel'); ?></p>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php
get_footer();
