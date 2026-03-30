<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package BestBaliTravel
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if (post_password_required()) {
    return;
}
?>

<div id="comments" class="comments-area">

    <?php if (have_comments()): ?>
        <h3 class="comments-title" style="margin-bottom: 30px;">
            <?php
            $bbt_comment_count = get_comments_number();
            if ('1' === $bbt_comment_count) {
                printf(
                    /* translators: 1: title. */
                    esc_html__('One comment on &ldquo;%1$s&rdquo;', 'bestbalitravel'),
                    '<span>' . wp_kses_post(get_the_title()) . '</span>'
                );
            } else {
                printf(
                    /* translators: 1: comment count number, 2: title. */
                    esc_html(_nx('%1$s comment on &ldquo;%2$s&rdquo;', '%1$s comments on &ldquo;%2$s&rdquo;', $bbt_comment_count, 'comments title', 'bestbalitravel')),
                    number_format_i18n($bbt_comment_count),
                    '<span>' . wp_kses_post(get_the_title()) . '</span>'
                );
            }
            ?>
        </h3>

        <ol class="comment-list" style="list-style: none; padding: 0;">
            <?php
            wp_list_comments(
                array(
                    'style' => 'ol',
                    'short_ping' => true,
                    'avatar_size' => 60,
                    'callback' => 'bbt_comment_callback',
                )
            );
            ?>
        </ol>

        <?php
        the_comments_navigation(
            array(
                'prev_text' => esc_html__('&laquo; Older Comments', 'bestbalitravel'),
                'next_text' => esc_html__('Newer Comments &raquo;', 'bestbalitravel'),
            )
        );

        // If comments are closed and there are comments, let's leave a little note.
        if (!comments_open()):
            ?>
            <p class="no-comments"
                style="padding: 20px; background: var(--bbt-gray-100); border-radius: 8px; text-align: center;">
                <?php esc_html_e('Comments are closed.', 'bestbalitravel'); ?>
            </p>
        <?php endif; ?>

    <?php endif; // Check for have_comments(). ?>

    <?php
    comment_form(
        array(
            'class_form' => 'comment-form bbt-comment-form',
            'title_reply' => esc_html__('Leave a Comment', 'bestbalitravel'),
            'title_reply_before' => '<h3 id="reply-title" class="comment-reply-title" style="margin-bottom: 20px;">',
            'title_reply_after' => '</h3>',
            'comment_field' => '<p class="comment-form-comment"><label for="comment">' . esc_html__('Your Comment', 'bestbalitravel') . '</label><textarea id="comment" name="comment" class="bbt-form-textarea" rows="5" required></textarea></p>',
            'submit_button' => '<button type="submit" name="%1$s" id="%2$s" class="bbt-btn bbt-btn-primary %3$s">%4$s</button>',
            'submit_field' => '<p class="form-submit" style="margin-top: 20px;">%1$s %2$s</p>',
        )
    );
    ?>

</div>

<?php
/**
 * Custom comment callback function
 *
 * @param WP_Comment $comment The comment object.
 * @param array      $args    Comment arguments.
 * @param int        $depth   Comment depth.
 */
if (!function_exists('bbt_comment_callback')) {
    function bbt_comment_callback($comment, $args, $depth)
    {
        ?>
        <li id="comment-<?php comment_ID(); ?>" <?php comment_class('comment-item'); ?> style="margin-bottom: 20px; padding:
    20px; background: var(--bbt-gray-50); border-radius: 12px;">
            <article class="comment-body">
                <header class="comment-meta" style="display: flex; align-items: center; gap: 15px; margin-bottom: 15px;">
                    <div class="comment-author vcard">
                        <?php echo get_avatar($comment, 60, '', '', array('style' => 'border-radius: 50%;')); ?>
                    </div>
                    <div class="comment-metadata">
                        <strong class="fn">
                            <?php echo esc_html(get_comment_author()); ?>
                        </strong>
                        <br>
                        <time datetime="<?php echo esc_attr(get_comment_date(DATE_W3C)); ?>"
                            style="color: var(--bbt-gray-500); font-size: 14px;">
                            <?php
                            printf(
                                /* translators: 1: date, 2: time */
                                esc_html__('%1$s at %2$s', 'bestbalitravel'),
                                esc_html(get_comment_date()),
                                esc_html(get_comment_time())
                            );
                            ?>
                        </time>
                    </div>
                </header>

                <div class="comment-content" style="margin-bottom: 15px;">
                    <?php comment_text(); ?>
                </div>

                <footer class="comment-links" style="font-size: 14px;">
                    <?php
                    comment_reply_link(
                        array_merge(
                            $args,
                            array(
                                'depth' => $depth,
                                'max_depth' => $args['max_depth'],
                                'before' => '<span class="reply-link">',
                                'after' => '</span>',
                            )
                        )
                    );

                    edit_comment_link(esc_html__('Edit', 'bestbalitravel'), ' <span class="edit-link">', '</span>');
                    ?>
                </footer>

                <?php if ('0' === $comment->comment_approved): ?>
                    <p class="comment-awaiting-moderation" style="color: var(--bbt-warning); margin-top: 10px;">
                        <?php esc_html_e('Your comment is awaiting moderation.', 'bestbalitravel'); ?>
                    </p>
                <?php endif; ?>
            </article>
            <?php
    }
}
