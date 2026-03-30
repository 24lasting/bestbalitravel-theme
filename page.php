<?php
/**
 * Generic Page Template
 *
 * @package BestBaliTravel
 */

get_header();
?>

<main id="main" class="site-main">

    <?php while (have_posts()):
        the_post(); ?>

        <!-- Page Header -->
        <section class="bbt-page-header">
            <div class="bbt-container">
                <h1 class="bbt-page-title">
                    <?php the_title(); ?>
                </h1>
                <?php bbt_breadcrumbs(); ?>
            </div>
        </section>

        <!-- Page Content -->
        <section class="bbt-section bbt-page-content">
            <div class="bbt-container">
                <div class="bbt-content-wrapper">
                    <?php if (has_post_thumbnail()): ?>
                        <div class="bbt-featured-image">
                            <?php the_post_thumbnail('bbt-tour-hero'); ?>
                        </div>
                    <?php endif; ?>

                    <div class="bbt-entry-content">
                        <?php the_content(); ?>
                    </div>
                </div>
            </div>
        </section>

    <?php endwhile; ?>

</main>

<?php
get_footer();
