<?php
/**
 * Template Name: Tour Packages
 * 
 * Modern Tour Packages page with tiket.com/Traveloka style layout
 *
 * @package BestBaliTravel
 */

get_header();

// Get tour types for categories
$tour_types = get_terms(array(
    'taxonomy' => 'tour_type',
    'hide_empty' => true,
));

// Query tours
$paged = get_query_var('paged') ? get_query_var('paged') : 1;
$args = array(
    'post_type' => 'tour',
    'posts_per_page' => 12,
    'paged' => $paged,
    'orderby' => 'date',
    'order' => 'DESC',
);

// Filter by category if set
if (isset($_GET['category']) && !empty($_GET['category'])) {
    $args['tax_query'] = array(
        array(
            'taxonomy' => 'tour_type',
            'field' => 'slug',
            'terms' => sanitize_text_field($_GET['category']),
        ),
    );
}

$tours_query = new WP_Query($args);
?>

<main id="main" class="site-main page-tour-packages" x-data="{ viewMode: 'grid' }">

    <!-- Hero Section -->
    <section class="packages-hero">
        <div class="packages-hero-bg"></div>
        <div class="bbt-container">
            <div class="packages-hero-content">
                <h1 class="packages-hero-title" x-data="scrollReveal()" :class="{ 'visible': visible }">
                    <?php esc_html_e('Discover Amazing Tours', 'bestbalitravel'); ?>
                </h1>
                <p class="packages-hero-subtitle" x-data="scrollReveal(200)" :class="{ 'visible': visible }">
                    <?php esc_html_e('Explore Bali with our carefully curated tour packages', 'bestbalitravel'); ?>
                </p>

                <!-- Mobile Search Bar -->
                <div class="mobile-search-bar" x-data="quickSearch()">
                    <form @submit.prevent="search()">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <circle cx="11" cy="11" r="8"></circle>
                            <path d="M21 21l-4.35-4.35"></path>
                        </svg>
                        <input type="search" x-model="query" @input.debounce.300ms="search()"
                            placeholder="<?php esc_attr_e('Search tours...', 'bestbalitravel'); ?>">
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Category Tabs -->
    <section class="category-tabs-section">
        <div class="category-tabs" x-data="categoryTabs()">
            <a href="<?php echo esc_url(remove_query_arg('category')); ?>" class="category-tab" data-category="all"
                :class="{ 'active': isActive('all') }" @click.prevent="setCategory('all')">
                <span class="category-tab-icon">🌴</span>
                <span class="category-tab-label"><?php esc_html_e('All Tours', 'bestbalitravel'); ?></span>
            </a>

            <?php
            $icons = array(
                'day-tour' => '☀️',
                'adventure' => '🏄',
                'cultural' => '🛕',
                'nature' => '🌿',
                'water-sports' => '🏊',
                'sunset' => '🌅',
                'photography' => '📷',
                'food' => '🍜',
            );

            foreach ($tour_types as $type):
                $icon = isset($icons[$type->slug]) ? $icons[$type->slug] : '🎯';
                ?>
                <a href="<?php echo esc_url(add_query_arg('category', $type->slug)); ?>" class="category-tab"
                    data-category="<?php echo esc_attr($type->slug); ?>"
                    :class="{ 'active': isActive('<?php echo esc_attr($type->slug); ?>') }"
                    @click.prevent="setCategory('<?php echo esc_attr($type->slug); ?>')">
                    <span class="category-tab-icon"><?php echo esc_html($icon); ?></span>
                    <span class="category-tab-label"><?php echo esc_html($type->name); ?></span>
                </a>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- Filter Chips & Toolbar -->
    <section class="filter-toolbar">
        <div class="bbt-container">
            <div class="filter-toolbar-inner">
                <div class="filter-chips" x-data>
                    <button type="button" class="filter-chip" @click="$dispatch('open-filter-sheet')">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <line x1="4" y1="21" x2="4" y2="14"></line>
                            <line x1="4" y1="10" x2="4" y2="3"></line>
                            <line x1="12" y1="21" x2="12" y2="12"></line>
                            <line x1="12" y1="8" x2="12" y2="3"></line>
                            <line x1="20" y1="21" x2="20" y2="16"></line>
                            <line x1="20" y1="12" x2="20" y2="3"></line>
                        </svg>
                        <?php esc_html_e('Filters', 'bestbalitravel'); ?>
                    </button>
                    <button type="button" class="filter-chip">💰
                        <?php esc_html_e('Price', 'bestbalitravel'); ?></button>
                    <button type="button" class="filter-chip">⏱️
                        <?php esc_html_e('Duration', 'bestbalitravel'); ?></button>
                    <button type="button" class="filter-chip">⭐
                        <?php esc_html_e('Rating', 'bestbalitravel'); ?></button>
                    <button type="button" class="filter-chip">📍
                        <?php esc_html_e('Location', 'bestbalitravel'); ?></button>
                </div>

                <div class="view-toggle">
                    <button type="button" class="view-btn" :class="{ 'active': viewMode === 'grid' }"
                        @click="viewMode = 'grid'">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                            <rect x="3" y="3" width="7" height="7"></rect>
                            <rect x="14" y="3" width="7" height="7"></rect>
                            <rect x="3" y="14" width="7" height="7"></rect>
                            <rect x="14" y="14" width="7" height="7"></rect>
                        </svg>
                    </button>
                    <button type="button" class="view-btn" :class="{ 'active': viewMode === 'list' }"
                        @click="viewMode = 'list'">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                            <rect x="3" y="4" width="18" height="4"></rect>
                            <rect x="3" y="10" width="18" height="4"></rect>
                            <rect x="3" y="16" width="18" height="4"></rect>
                        </svg>
                    </button>
                </div>
            </div>

            <div class="results-count">
                <?php
                printf(
                    _n('%d tour available', '%d tours available', $tours_query->found_posts, 'bestbalitravel'),
                    $tours_query->found_posts
                );
                ?>
            </div>
        </div>
    </section>

    <!-- Tours Grid -->
    <section class="tours-section">
        <div class="bbt-container">
            <div class="tours-grid" :class="{ 'list-view': viewMode === 'list' }">
                <?php if ($tours_query->have_posts()): ?>
                    <?php $delay = 0; ?>
                    <?php while ($tours_query->have_posts()):
                        $tours_query->the_post(); ?>
                        <?php
                        $tour_id = get_the_ID();
                        $price = get_post_meta($tour_id, '_tour_price', true);
                        $duration = get_post_meta($tour_id, '_tour_duration', true);
                        $rating = get_post_meta($tour_id, '_tour_rating', true) ?: 4.8;
                        $locations = get_the_terms($tour_id, 'tour_location');
                        ?>

                        <article class="tour-card" x-data="tourCard(<?php echo esc_attr($tour_id); ?>)"
                            x-init="setTimeout(() => $el.classList.add('visible'), <?php echo $delay; ?>)">
                            <a href="<?php the_permalink(); ?>" class="tour-card-link">
                                <div class="tour-card-image">
                                    <?php if (has_post_thumbnail()): ?>
                                        <?php the_post_thumbnail('bbt-tour-card'); ?>
                                    <?php else: ?>
                                        <img src="<?php echo esc_url(bbt_get_tour_fallback_image($tour_id, 'medium')); ?>"
                                            alt="<?php the_title_attribute(); ?>" loading="lazy">
                                    <?php endif; ?>

                                    <div class="tour-card-badges">
                                        <?php if ($rating >= 4.5): ?>
                                            <span class="badge badge-top">⭐ Top Rated</span>
                                        <?php endif; ?>
                                    </div>

                                    <button type="button" class="wishlist-btn" :class="{ 'active': isWishlisted }"
                                        @click.prevent="toggleWishlist()">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            :fill="isWishlisted ? 'currentColor' : 'none'">
                                            <path
                                                d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z">
                                            </path>
                                        </svg>
                                    </button>
                                </div>

                                <div class="tour-card-content">
                                    <div class="tour-card-meta">
                                        <span class="tour-rating">
                                            <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor">
                                                <polygon
                                                    points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2">
                                                </polygon>
                                            </svg>
                                            <?php echo esc_html(number_format((float) $rating, 1)); ?>
                                        </span>
                                        <?php if ($duration): ?>
                                            <span class="tour-duration">⏱️ <?php echo esc_html($duration); ?></span>
                                        <?php endif; ?>
                                    </div>

                                    <h3 class="tour-card-title"><?php the_title(); ?></h3>

                                    <?php if ($locations): ?>
                                        <p class="tour-card-location">
                                            📍 <?php echo esc_html($locations[0]->name); ?>
                                        </p>
                                    <?php endif; ?>

                                    <div class="tour-card-footer">
                                        <div class="tour-price">
                                            <span class="price-from"><?php esc_html_e('From', 'bestbalitravel'); ?></span>
                                            <span class="price-amount">
                                                <?php echo function_exists('wc_price') ? wc_price($price) : 'Rp ' . number_format($price, 0, ',', '.'); ?>
                                            </span>
                                        </div>
                                        <span class="book-now-btn"><?php esc_html_e('Book Now', 'bestbalitravel'); ?></span>
                                    </div>
                                </div>
                            </a>
                        </article>

                        <?php $delay += 100; ?>
                    <?php endwhile; ?>
                    <?php wp_reset_postdata(); ?>
                <?php else: ?>
                    <div class="no-tours-found">
                        <div class="no-results-icon">🔍</div>
                        <h3><?php esc_html_e('No tours found', 'bestbalitravel'); ?></h3>
                        <p><?php esc_html_e('Try adjusting your filters or browse all tours.', 'bestbalitravel'); ?></p>
                        <a href="<?php echo esc_url(remove_query_arg('category')); ?>" class="bbt-btn bbt-btn-primary">
                            <?php esc_html_e('View All Tours', 'bestbalitravel'); ?>
                        </a>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Pagination -->
            <?php if ($tours_query->max_num_pages > 1): ?>
                <nav class="tours-pagination">
                    <?php
                    echo paginate_links(array(
                        'total' => $tours_query->max_num_pages,
                        'current' => $paged,
                        'prev_text' => '&laquo;',
                        'next_text' => '&raquo;',
                        'type' => 'list',
                    ));
                    ?>
                </nav>
            <?php endif; ?>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="packages-cta">
        <div class="bbt-container">
            <div class="cta-card" x-data="scrollReveal()" :class="{ 'visible': visible }">
                <div class="cta-content">
                    <h2><?php esc_html_e('Can\'t find what you\'re looking for?', 'bestbalitravel'); ?></h2>
                    <p><?php esc_html_e('Let us create a custom tour package just for you!', 'bestbalitravel'); ?></p>
                </div>
                <a href="https://wa.me/6287854806011?text=<?php echo urlencode('Hi, I would like to request a custom tour package.'); ?>"
                    class="cta-btn" target="_blank" rel="noopener">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                        <path
                            d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                    </svg>
                    <?php esc_html_e('Request Custom Tour', 'bestbalitravel'); ?>
                </a>
            </div>
        </div>
    </section>

</main>

<!-- Filter Sheet (Mobile) -->
<div x-data="filterSheet()" @open-filter-sheet.window="openSheet()">
    <div class="filter-sheet-overlay" :class="{ 'active': open }" @click="closeSheet()"></div>
    <div class="filter-sheet" :class="{ 'active': open }">
        <div class="filter-sheet-handle"></div>
        <div class="filter-sheet-header">
            <h3 class="filter-sheet-title"><?php esc_html_e('Filters', 'bestbalitravel'); ?></h3>
            <button type="button" class="filter-sheet-close" @click="closeSheet()">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M18 6L6 18M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <div class="filter-sheet-content">
            <!-- Price Range -->
            <div class="filter-group">
                <h4><?php esc_html_e('Price Range', 'bestbalitravel'); ?></h4>
                <div class="price-inputs">
                    <input type="number" placeholder="Min" x-model="tempFilters.priceRange[0]">
                    <span>-</span>
                    <input type="number" placeholder="Max" x-model="tempFilters.priceRange[1]">
                </div>
            </div>

            <!-- Duration -->
            <div class="filter-group">
                <h4><?php esc_html_e('Duration', 'bestbalitravel'); ?></h4>
                <div class="filter-options">
                    <label class="filter-option">
                        <input type="checkbox" @change="toggleDuration('half-day')">
                        <span><?php esc_html_e('Half Day (4-5 hours)', 'bestbalitravel'); ?></span>
                    </label>
                    <label class="filter-option">
                        <input type="checkbox" @change="toggleDuration('full-day')">
                        <span><?php esc_html_e('Full Day (8-10 hours)', 'bestbalitravel'); ?></span>
                    </label>
                    <label class="filter-option">
                        <input type="checkbox" @change="toggleDuration('multi-day')">
                        <span><?php esc_html_e('Multi-day', 'bestbalitravel'); ?></span>
                    </label>
                </div>
            </div>

            <!-- Rating -->
            <div class="filter-group">
                <h4><?php esc_html_e('Minimum Rating', 'bestbalitravel'); ?></h4>
                <div class="rating-options">
                    <template x-for="star in [4, 3, 2, 1]">
                        <button type="button" class="rating-btn" :class="{ 'active': tempFilters.rating === star }"
                            @click="setRating(star)">
                            <span x-text="star"></span>⭐ <?php esc_html_e('& up', 'bestbalitravel'); ?>
                        </button>
                    </template>
                </div>
            </div>
        </div>
        <div class="filter-sheet-footer">
            <button type="button" class="filter-sheet-btn secondary" @click="resetFilters()">
                <?php esc_html_e('Reset', 'bestbalitravel'); ?>
            </button>
            <button type="button" class="filter-sheet-btn primary" @click="applyFilters()">
                <?php esc_html_e('Apply Filters', 'bestbalitravel'); ?>
            </button>
        </div>
    </div>
</div>

<style>
    /* Tour Packages Page Styles */
    .packages-hero {
        position: relative;
        padding: 120px 0 60px;
        background: linear-gradient(135deg, #f5a623 0%, #10b981 100%);
        overflow: hidden;
    }

    .packages-hero-bg {
        position: absolute;
        inset: 0;
        background: url('<?php echo BBT_THEME_ASSETS; ?>/images/pattern-tropical.png') repeat;
        opacity: 0.1;
    }

    .packages-hero-content {
        position: relative;
        text-align: center;
        color: white;
    }

    .packages-hero-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: clamp(2rem, 5vw, 3.5rem);
        font-weight: 600;
        margin-bottom: 0.5rem;
        opacity: 0;
        transform: translateY(30px);
        transition: all 0.8s ease;
    }

    .packages-hero-title.visible {
        opacity: 1;
        transform: translateY(0);
    }

    .packages-hero-subtitle {
        font-size: 1.125rem;
        opacity: 0.9;
    }

    .category-tabs-section {
        background: white;
        border-bottom: 1px solid #f3f4f6;
        position: sticky;
        top: 70px;
        z-index: 100;
    }

    .filter-toolbar {
        background: #f9fafb;
        padding: 12px 0;
        border-bottom: 1px solid #f3f4f6;
    }

    .filter-toolbar-inner {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
    }

    .view-toggle {
        display: none;
        gap: 4px;
    }

    @media (min-width: 768px) {
        .view-toggle {
            display: flex;
        }
    }

    .view-btn {
        padding: 8px;
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 6px;
        color: #6b7280;
        cursor: pointer;
        transition: all 0.2s;
    }

    .view-btn.active {
        background: #f5a623;
        border-color: #f5a623;
        color: white;
    }

    .results-count {
        margin-top: 8px;
        font-size: 13px;
        color: #6b7280;
    }

    .tours-section {
        padding: 24px 0 60px;
        background: #f9fafb;
    }

    .tours-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 24px;
    }

    .tours-grid.list-view {
        grid-template-columns: 1fr;
    }

    @media (max-width: 768px) {
        .tours-grid {
            grid-template-columns: 1fr;
            gap: 16px;
        }
    }

    .tour-card {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
        opacity: 0;
        transform: translateY(20px);
        transition: all 0.5s ease;
    }

    .tour-card.visible {
        opacity: 1;
        transform: translateY(0);
    }

    .tour-card:hover {
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
        transform: translateY(-4px);
    }

    .tour-card-link {
        text-decoration: none;
        color: inherit;
        display: block;
    }

    .tour-card-image {
        position: relative;
        aspect-ratio: 4/3;
        overflow: hidden;
    }

    .tour-card-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s;
    }

    .tour-card:hover .tour-card-image img {
        transform: scale(1.05);
    }

    .tour-card-badges {
        position: absolute;
        top: 12px;
        left: 12px;
        display: flex;
        gap: 8px;
    }

    .badge {
        padding: 4px 10px;
        background: rgba(255, 255, 255, 0.95);
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
    }

    .badge-top {
        background: linear-gradient(135deg, #f5a623, #e69316);
        color: white;
    }

    .wishlist-btn {
        position: absolute;
        top: 12px;
        right: 12px;
        width: 36px;
        height: 36px;
        background: rgba(255, 255, 255, 0.95);
        border: none;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s;
        color: #6b7280;
    }

    .wishlist-btn:hover,
    .wishlist-btn.active {
        color: #ef4444;
        background: white;
    }

    .wishlist-btn svg {
        width: 18px;
        height: 18px;
    }

    .tour-card-content {
        padding: 16px;
    }

    .tour-card-meta {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 8px;
        font-size: 13px;
    }

    .tour-rating {
        display: flex;
        align-items: center;
        gap: 4px;
        color: #f59e0b;
        font-weight: 600;
    }

    .tour-duration {
        color: #6b7280;
    }

    .tour-card-title {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 16px;
        font-weight: 600;
        color: #111827;
        margin-bottom: 4px;
        line-height: 1.4;
    }

    .tour-card-location {
        font-size: 13px;
        color: #6b7280;
        margin-bottom: 12px;
    }

    .tour-card-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding-top: 12px;
        border-top: 1px solid #f3f4f6;
    }

    .tour-price .price-from {
        display: block;
        font-size: 11px;
        color: #9ca3af;
        text-transform: uppercase;
    }

    .tour-price .price-amount {
        font-size: 18px;
        font-weight: 700;
        color: #f5a623;
    }

    .book-now-btn {
        padding: 8px 16px;
        background: linear-gradient(135deg, #f5a623, #e69316);
        color: white;
        font-size: 13px;
        font-weight: 600;
        border-radius: 8px;
        transition: all 0.3s;
    }

    .tour-card:hover .book-now-btn {
        box-shadow: 0 4px 15px rgba(245, 166, 35, 0.4);
    }

    /* List View */
    .tours-grid.list-view .tour-card {
        display: flex;
        flex-direction: row;
    }

    .tours-grid.list-view .tour-card-image {
        width: 200px;
        min-height: 150px;
        aspect-ratio: auto;
    }

    .tours-grid.list-view .tour-card-content {
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    /* No Results */
    .no-tours-found {
        grid-column: 1 / -1;
        text-align: center;
        padding: 60px 20px;
    }

    .no-results-icon {
        font-size: 64px;
        margin-bottom: 16px;
    }

    /* CTA Section */
    .packages-cta {
        padding: 40px 0;
        background: white;
    }

    .cta-card {
        background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
        border-radius: 20px;
        padding: 40px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 24px;
        color: white;
        opacity: 0;
        transform: translateY(30px);
        transition: all 0.8s;
    }

    .cta-card.visible {
        opacity: 1;
        transform: translateY(0);
    }

    @media (max-width: 768px) {
        .cta-card {
            flex-direction: column;
            text-align: center;
            padding: 30px 20px;
        }
    }

    .cta-content h2 {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.75rem;
        margin-bottom: 8px;
    }

    .cta-content p {
        opacity: 0.8;
    }

    .cta-btn {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 14px 28px;
        background: #25D366;
        color: white;
        text-decoration: none;
        font-weight: 600;
        border-radius: 50px;
        transition: all 0.3s;
        white-space: nowrap;
    }

    .cta-btn:hover {
        background: #128C7E;
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(37, 211, 102, 0.3);
    }

    /* Pagination */
    .tours-pagination {
        margin-top: 40px;
        display: flex;
        justify-content: center;
    }

    .tours-pagination ul {
        display: flex;
        gap: 8px;
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .tours-pagination li a,
    .tours-pagination li span {
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 40px;
        height: 40px;
        padding: 0 12px;
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        font-size: 14px;
        color: #374151;
        text-decoration: none;
        transition: all 0.2s;
    }

    .tours-pagination li a:hover {
        background: #f5a623;
        border-color: #f5a623;
        color: white;
    }

    .tours-pagination li span.current {
        background: #f5a623;
        border-color: #f5a623;
        color: white;
    }

    /* Filter Sheet Styles */
    .filter-group {
        margin-bottom: 24px;
    }

    .filter-group h4 {
        font-size: 14px;
        font-weight: 600;
        margin-bottom: 12px;
        color: #111827;
    }

    .price-inputs {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .price-inputs input {
        flex: 1;
        padding: 10px 14px;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        font-size: 14px;
    }

    .filter-options {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .filter-option {
        display: flex;
        align-items: center;
        gap: 10px;
        cursor: pointer;
    }

    .filter-option input[type="checkbox"] {
        width: 18px;
        height: 18px;
        accent-color: #f5a623;
    }

    .rating-options {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }

    .rating-btn {
        padding: 8px 14px;
        background: #f3f4f6;
        border: 1px solid transparent;
        border-radius: 20px;
        font-size: 13px;
        cursor: pointer;
        transition: all 0.2s;
    }

    .rating-btn.active {
        background: #fef3c7;
        border-color: #f5a623;
        color: #92400e;
    }
</style>

<?php
get_footer();
