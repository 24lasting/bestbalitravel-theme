<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package BestBaliTravel
 */

if (!is_active_sidebar('sidebar-1') && !is_active_sidebar('tour-sidebar')) {
    return;
}
?>

<aside id="secondary" class="widget-area sidebar" role="complementary">
    <?php
    // Use tour sidebar on tour pages, otherwise use main sidebar.
    if (is_singular('tour') || is_post_type_archive('tour')) {
        if (is_active_sidebar('tour-sidebar')) {
            dynamic_sidebar('tour-sidebar');
        }
    } else {
        if (is_active_sidebar('sidebar-1')) {
            dynamic_sidebar('sidebar-1');
        }
    }
    ?>

    <?php if (!is_active_sidebar('sidebar-1') && !is_active_sidebar('tour-sidebar')): ?>
        <!-- Default Sidebar Content -->
        <div class="widget default-widget">
            <h4 class="widget-title">
                <?php esc_html_e('Popular Tours', 'bestbalitravel'); ?>
            </h4>
            <ul class="popular-tours-list">
                <?php
                $popular = new WP_Query(array(
                    'post_type' => 'tour',
                    'posts_per_page' => 5,
                    'orderby' => 'comment_count',
                    'order' => 'DESC',
                ));

                if ($popular->have_posts()):
                    while ($popular->have_posts()):
                        $popular->the_post();
                        ?>
                        <li>
                            <a href="<?php the_permalink(); ?>">
                                <?php the_title(); ?>
                            </a>
                        </li>
                        <?php
                    endwhile;
                    wp_reset_postdata();
                endif;
                ?>
            </ul>
        </div>

        <div class="widget default-widget">
            <h4 class="widget-title">
                <?php esc_html_e('Need Help?', 'bestbalitravel'); ?>
            </h4>
            <p>
                <?php esc_html_e('Contact us for custom tour packages or any questions.', 'bestbalitravel'); ?>
            </p>
            <a href="<?php echo esc_url(home_url('/contact')); ?>" class="bbt-btn bbt-btn-primary bbt-btn-block">
                <?php esc_html_e('Contact Us', 'bestbalitravel'); ?>
            </a>
        </div>
    <?php endif; ?>
</aside>