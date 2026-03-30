<?php
/**
 * The search form template
 *
 * @package BestBaliTravel
 */

?>
<form role="search" method="get" class="search-form bbt-search-form" action="<?php echo esc_url(home_url('/')); ?>">
    <label class="screen-reader-text" for="search-field-<?php echo esc_attr(wp_unique_id()); ?>">
        <?php esc_html_e('Search for:', 'bestbalitravel'); ?>
    </label>
    <div class="search-form-inner" style="display: flex; gap: 10px;">
        <input type="search" id="search-field-<?php echo esc_attr(wp_unique_id()); ?>"
            class="search-field bbt-form-input"
            placeholder="<?php esc_attr_e('Search tours, destinations...', 'bestbalitravel'); ?>"
            value="<?php echo get_search_query(); ?>" name="s" style="flex: 1;" />
        <button type="submit" class="search-submit bbt-btn bbt-btn-primary">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="11" cy="11" r="8"></circle>
                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
            </svg>
            <span class="screen-reader-text">
                <?php esc_html_e('Search', 'bestbalitravel'); ?>
            </span>
        </button>
    </div>
</form>