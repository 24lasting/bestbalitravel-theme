<?php
/**
 * Tour Archive Template
 *
 * @package BestBaliTravel
 */

get_header();
?>

<main id="main" class="site-main archive-tour">
    
    <!-- Page Header -->
    <section class="bbt-page-header">
        <div class="bbt-container">
            <h1 class="bbt-page-title">
                <?php
                if (is_tax('tour_location')) {
                    single_term_title(__('Tours in ', 'bestbalitravel'));
                } elseif (is_tax('tour_type')) {
                    single_term_title();
                } elseif (is_tax('tour_duration')) {
                    single_term_title();
                } else {
                    esc_html_e('All Tours', 'bestbalitravel');
                }
                ?>
            </h1>
            
            <?php bbt_breadcrumbs(); ?>
        </div>
    </section>
    
    <!-- Tours Archive -->
    <section class="bbt-section bbt-tours-archive">
        <div class="bbt-container">
            <div class="bbt-archive-layout">
                
                <!-- Filters Sidebar -->
                <aside class="bbt-filters-sidebar">
                    <div class="bbt-filters-header">
                        <h3><?php esc_html_e('Filters', 'bestbalitravel'); ?></h3>
                        <button type="button" class="bbt-filters-clear" id="bbt-clear-filters">
                            <?php esc_html_e('Clear All', 'bestbalitravel'); ?>
                        </button>
                    </div>
                    
                    <form class="bbt-filters-form" id="bbt-filters-form">
                        <?php wp_nonce_field('bbt_nonce', 'filter_nonce'); ?>
                        
                        <!-- Location Filter -->
                        <div class="bbt-filter-group">
                            <h4 class="bbt-filter-title"><?php esc_html_e('Location', 'bestbalitravel'); ?></h4>
                            <div class="bbt-filter-options">
                                <?php
                                $locations = get_terms(array('taxonomy' => 'tour_location', 'hide_empty' => true));
                                foreach ($locations as $location) :
                                    $checked = (is_tax('tour_location', $location->slug)) ? 'checked' : '';
                                ?>
                                    <label class="bbt-filter-checkbox">
                                        <input type="checkbox" name="location[]" value="<?php echo esc_attr($location->slug); ?>" <?php echo $checked; ?>>
                                        <span><?php echo esc_html($location->name); ?></span>
                                        <span class="count">(<?php echo esc_html($location->count); ?>)</span>
                                    </label>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        
                        <!-- Tour Type Filter -->
                        <div class="bbt-filter-group">
                            <h4 class="bbt-filter-title"><?php esc_html_e('Tour Type', 'bestbalitravel'); ?></h4>
                            <div class="bbt-filter-options">
                                <?php
                                $types = get_terms(array('taxonomy' => 'tour_type', 'hide_empty' => true));
                                foreach ($types as $type) :
                                    $checked = (is_tax('tour_type', $type->slug)) ? 'checked' : '';
                                ?>
                                    <label class="bbt-filter-checkbox">
                                        <input type="checkbox" name="type[]" value="<?php echo esc_attr($type->slug); ?>" <?php echo $checked; ?>>
                                        <span><?php echo esc_html($type->name); ?></span>
                                        <span class="count">(<?php echo esc_html($type->count); ?>)</span>
                                    </label>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        
                        <!-- Duration Filter -->
                        <div class="bbt-filter-group">
                            <h4 class="bbt-filter-title"><?php esc_html_e('Duration', 'bestbalitravel'); ?></h4>
                            <div class="bbt-filter-options">
                                <?php
                                $durations = get_terms(array('taxonomy' => 'tour_duration', 'hide_empty' => true));
                                foreach ($durations as $duration) :
                                ?>
                                    <label class="bbt-filter-checkbox">
                                        <input type="checkbox" name="duration[]" value="<?php echo esc_attr($duration->slug); ?>">
                                        <span><?php echo esc_html($duration->name); ?></span>
                                        <span class="count">(<?php echo esc_html($duration->count); ?>)</span>
                                    </label>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        
                        <!-- Price Range Filter -->
                        <div class="bbt-filter-group">
                            <h4 class="bbt-filter-title"><?php esc_html_e('Price Range', 'bestbalitravel'); ?></h4>
                            <div class="bbt-price-range">
                                <input type="number" name="min_price" placeholder="<?php esc_attr_e('Min', 'bestbalitravel'); ?>" class="bbt-form-input">
                                <span>-</span>
                                <input type="number" name="max_price" placeholder="<?php esc_attr_e('Max', 'bestbalitravel'); ?>" class="bbt-form-input">
                            </div>
                        </div>
                        
                        <button type="submit" class="bbt-btn bbt-btn-primary bbt-btn-block">
                            <?php esc_html_e('Apply Filters', 'bestbalitravel'); ?>
                        </button>
                    </form>
                </aside>
                
                <!-- Tours Grid -->
                <div class="bbt-tours-content">
                    
                    <!-- Toolbar -->
                    <div class="bbt-tours-toolbar">
                        <div class="bbt-tours-count">
                            <?php
                            global $wp_query;
                            printf(
                                _n('%d tour found', '%d tours found', $wp_query->found_posts, 'bestbalitravel'),
                                $wp_query->found_posts
                            );
                            ?>
                        </div>
                        
                        <div class="bbt-tours-sort">
                            <label><?php esc_html_e('Sort by:', 'bestbalitravel'); ?></label>
                            <select name="orderby" class="bbt-form-select" id="bbt-sort-select">
                                <option value="date"><?php esc_html_e('Newest', 'bestbalitravel'); ?></option>
                                <option value="price_low"><?php esc_html_e('Price: Low to High', 'bestbalitravel'); ?></option>
                                <option value="price_high"><?php esc_html_e('Price: High to Low', 'bestbalitravel'); ?></option>
                                <option value="name"><?php esc_html_e('Name: A-Z', 'bestbalitravel'); ?></option>
                            </select>
                        </div>
                        
                        <div class="bbt-tours-view">
                            <button type="button" class="bbt-view-btn active" data-view="grid">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                                    <rect x="3" y="3" width="7" height="7"></rect>
                                    <rect x="14" y="3" width="7" height="7"></rect>
                                    <rect x="3" y="14" width="7" height="7"></rect>
                                    <rect x="14" y="14" width="7" height="7"></rect>
                                </svg>
                            </button>
                            <button type="button" class="bbt-view-btn" data-view="list">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                                    <rect x="3" y="4" width="18" height="4"></rect>
                                    <rect x="3" y="10" width="18" height="4"></rect>
                                    <rect x="3" y="16" width="18" height="4"></rect>
                                </svg>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Mobile Filter Toggle -->
                    <button type="button" class="bbt-filter-toggle bbt-hide-desktop" id="bbt-filter-toggle">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="4" y1="21" x2="4" y2="14"></line>
                            <line x1="4" y1="10" x2="4" y2="3"></line>
                            <line x1="12" y1="21" x2="12" y2="12"></line>
                            <line x1="12" y1="8" x2="12" y2="3"></line>
                            <line x1="20" y1="21" x2="20" y2="16"></line>
                            <line x1="20" y1="12" x2="20" y2="3"></line>
                            <line x1="1" y1="14" x2="7" y2="14"></line>
                            <line x1="9" y1="8" x2="15" y2="8"></line>
                            <line x1="17" y1="16" x2="23" y2="16"></line>
                        </svg>
                        <?php esc_html_e('Filters', 'bestbalitravel'); ?>
                    </button>
                    
                    <!-- Tours Grid -->
                    <div class="bbt-tours-grid" id="bbt-tours-grid">
                        <?php if (have_posts()) : ?>
                            <?php while (have_posts()) : the_post(); ?>
                                <?php bbt_tour_card(); ?>
                            <?php endwhile; ?>
                        <?php else : ?>
                            <div class="bbt-no-results">
                                <h3><?php esc_html_e('No tours found', 'bestbalitravel'); ?></h3>
                                <p><?php esc_html_e('Try adjusting your filters or search criteria.', 'bestbalitravel'); ?></p>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Pagination -->
                    <?php if ($wp_query->max_num_pages > 1) : ?>
                        <nav class="bbt-pagination">
                            <?php
                            echo paginate_links(array(
                                'prev_text' => '&laquo; ' . __('Previous', 'bestbalitravel'),
                                'next_text' => __('Next', 'bestbalitravel') . ' &raquo;',
                                'type' => 'list',
                            ));
                            ?>
                        </nav>
                    <?php endif; ?>
                    
                </div>
                
            </div>
        </div>
    </section>

</main>

<?php
get_footer();
