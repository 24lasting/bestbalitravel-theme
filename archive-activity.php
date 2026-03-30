<?php
/**
 * Activity Archive Template
 * Matches the Tours Archive Design
 *
 * @package BestBaliTravel
 */

get_header();
?>

<main id="main" class="site-main archive-activity">
    
    <!-- Page Header -->
    <section class="bbt-page-header">
        <div class="bbt-container">
            <h1 class="bbt-page-title">
                <?php
                if (is_tax('activity_category')) {
                    single_term_title(__('Activities: ', 'bestbalitravel'));
                } elseif (is_tax('activity_location')) {
                    single_term_title(__('Activities in ', 'bestbalitravel'));
                } else {
                    esc_html_e('All Activities', 'bestbalitravel');
                }
                ?>
            </h1>
            
            <?php if (function_exists('bbt_breadcrumbs')) bbt_breadcrumbs(); ?>
        </div>
    </section>
    
    <!-- Activities Archive -->
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
                        
                        <!-- Category Filter -->
                        <div class="bbt-filter-group">
                            <h4 class="bbt-filter-title"><?php esc_html_e('Category', 'bestbalitravel'); ?></h4>
                            <div class="bbt-filter-options">
                                <?php
                                $categories = get_terms(array('taxonomy' => 'activity_category', 'hide_empty' => true));
                                if (!is_wp_error($categories) && !empty($categories)):
                                    foreach ($categories as $cat) :
                                        $checked = (is_tax('activity_category', $cat->slug)) ? 'checked' : '';
                                ?>
                                    <label class="bbt-filter-checkbox">
                                        <input type="checkbox" name="category[]" value="<?php echo esc_attr($cat->slug); ?>" <?php echo $checked; ?>>
                                        <span><?php echo esc_html($cat->name); ?></span>
                                        <span class="count">(<?php echo esc_html($cat->count); ?>)</span>
                                    </label>
                                <?php endforeach; endif; ?>
                            </div>
                        </div>
                        
                        <!-- Location Filter -->
                        <div class="bbt-filter-group">
                            <h4 class="bbt-filter-title"><?php esc_html_e('Location', 'bestbalitravel'); ?></h4>
                            <div class="bbt-filter-options">
                                <?php
                                $locations = get_terms(array('taxonomy' => 'activity_location', 'hide_empty' => true));
                                if (!is_wp_error($locations) && !empty($locations)):
                                    foreach ($locations as $location) :
                                        $checked = (is_tax('activity_location', $location->slug)) ? 'checked' : '';
                                ?>
                                    <label class="bbt-filter-checkbox">
                                        <input type="checkbox" name="location[]" value="<?php echo esc_attr($location->slug); ?>" <?php echo $checked; ?>>
                                        <span><?php echo esc_html($location->name); ?></span>
                                        <span class="count">(<?php echo esc_html($location->count); ?>)</span>
                                    </label>
                                <?php endforeach; endif; ?>
                            </div>
                        </div>
                        
                        <!-- Duration Filter -->
                        <div class="bbt-filter-group">
                            <h4 class="bbt-filter-title"><?php esc_html_e('Duration', 'bestbalitravel'); ?></h4>
                            <div class="bbt-filter-options">
                                <label class="bbt-filter-checkbox">
                                    <input type="checkbox" name="duration[]" value="half-day">
                                    <span><?php esc_html_e('Half Day', 'bestbalitravel'); ?></span>
                                </label>
                                <label class="bbt-filter-checkbox">
                                    <input type="checkbox" name="duration[]" value="full-day">
                                    <span><?php esc_html_e('Full Day', 'bestbalitravel'); ?></span>
                                </label>
                                <label class="bbt-filter-checkbox">
                                    <input type="checkbox" name="duration[]" value="multi-day">
                                    <span><?php esc_html_e('Multi-Day', 'bestbalitravel'); ?></span>
                                </label>
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
                
                <!-- Activities Grid -->
                <div class="bbt-tours-content">
                    
                    <!-- Toolbar -->
                    <div class="bbt-tours-toolbar">
                        <div class="bbt-tours-count">
                            <?php
                            global $wp_query;
                            printf(
                                _n('%d activity found', '%d activities found', $wp_query->found_posts, 'bestbalitravel'),
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
                    
                    <!-- Activities Grid -->
                    <div class="bbt-tours-grid" id="bbt-tours-grid">
                        <?php if (have_posts()) : ?>
                            <?php while (have_posts()) : the_post(); ?>
                                <?php 
                                // Use activity card or tour card function
                                if (function_exists('bbt_activity_card')) {
                                    bbt_activity_card();
                                } elseif (function_exists('bbt_tour_card')) {
                                    bbt_tour_card();
                                } else {
                                    // Fallback card
                                    $price = '';
                                    $rating = 4.8;
                                    $duration = '';
                                    
                                    if (function_exists('bbt_get_tour_price')) {
                                        $p = bbt_get_tour_price();
                                        $price = is_numeric($p) ? 'IDR ' . number_format($p, 0, ',', '.') : $p;
                                    }
                                    if (function_exists('bbt_get_tour_rating')) {
                                        $r = bbt_get_tour_rating();
                                        $rating = is_numeric($r) ? $r : 4.8;
                                    }
                                    if (function_exists('bbt_get_tour_duration')) {
                                        $d = bbt_get_tour_duration();
                                        $duration = is_string($d) ? $d : '';
                                    }
                                    ?>
                                    <article class="bbt-tour-card">
                                        <div class="bbt-tour-card-image">
                                            <a href="<?php the_permalink(); ?>">
                                                <?php if (has_post_thumbnail()) : ?>
                                                    <?php the_post_thumbnail('medium_large'); ?>
                                                <?php else : ?>
                                                    <img src="https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=600" alt="<?php the_title_attribute(); ?>">
                                                <?php endif; ?>
                                            </a>
                                            <div class="bbt-tour-card-badges">
                                                <span class="bbt-badge bbt-badge-rating">⭐ <?php echo esc_html($rating); ?></span>
                                            </div>
                                            <button class="bbt-wishlist-btn" title="Add to Wishlist">
                                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                                                </svg>
                                            </button>
                                        </div>
                                        <div class="bbt-tour-card-content">
                                            <div class="bbt-tour-card-meta">
                                                <?php if ($duration) : ?>
                                                    <span class="bbt-meta-item"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg> <?php echo esc_html($duration); ?></span>
                                                <?php endif; ?>
                                                <span class="bbt-meta-item"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg> Bali</span>
                                            </div>
                                            <h3 class="bbt-tour-card-title">
                                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                            </h3>
                                            <p class="bbt-tour-card-excerpt"><?php echo wp_trim_words(get_the_excerpt(), 12, '...'); ?></p>
                                            <div class="bbt-tour-card-footer">
                                                <div class="bbt-tour-card-price">
                                                    <span class="bbt-price-from"><?php esc_html_e('From', 'bestbalitravel'); ?></span>
                                                    <span class="bbt-price-amount"><?php echo esc_html($price ?: 'IDR 450,000'); ?></span>
                                                </div>
                                                <a href="<?php the_permalink(); ?>" class="bbt-tour-card-btn">
                                                    <?php esc_html_e('View', 'bestbalitravel'); ?>
                                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                                                </a>
                                            </div>
                                        </div>
                                    </article>
                                    <?php
                                }
                                ?>
                            <?php endwhile; ?>
                        <?php else : ?>
                            <div class="bbt-no-results">
                                <h3><?php esc_html_e('No activities found', 'bestbalitravel'); ?></h3>
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
