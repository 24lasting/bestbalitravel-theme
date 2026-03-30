<?php
/**
 * Template Name: Activities
 * 
 * Premium Activities Page with Tailwind CSS & Alpine.js
 *
 * @package BestBaliTravel
 */

get_header();

// Query activities
$paged = get_query_var('paged') ? get_query_var('paged') : 1;
$args = array(
    'post_type' => 'tour',
    'posts_per_page' => 12,
    'paged' => $paged,
    'orderby' => 'date',
    'order' => 'DESC',
);

// Apply filters
if (isset($_GET['location']) && !empty($_GET['location'])) {
    $args['tax_query'][] = array(
        'taxonomy' => 'tour_location',
        'field' => 'slug',
        'terms' => array_map('sanitize_text_field', (array) $_GET['location']),
    );
}

if (isset($_GET['type']) && !empty($_GET['type'])) {
    $args['tax_query'][] = array(
        'taxonomy' => 'tour_type',
        'field' => 'slug',
        'terms' => array_map('sanitize_text_field', (array) $_GET['type']),
    );
}

$activities_query = new WP_Query($args);
$locations = get_terms(array('taxonomy' => 'tour_location', 'hide_empty' => true));
$types = get_terms(array('taxonomy' => 'tour_type', 'hide_empty' => true));
?>

<!-- Tailwind CSS CDN -->
<script src="https://cdn.tailwindcss.com"></script>
<script>
tailwind.config = {
    theme: {
        extend: {
            colors: {
                primary: { 50: '#f0fdfa', 100: '#ccfbf1', 200: '#99f6e4', 300: '#5eead4', 400: '#2dd4bf', 500: '#14b8a6', 600: '#0d9488', 700: '#0f766e', 800: '#115e59', 900: '#134e4a' },
                accent: { 50: '#fffbeb', 100: '#fef3c7', 200: '#fde68a', 300: '#fcd34d', 400: '#fbbf24', 500: '#f59e0b', 600: '#d97706', 700: '#b45309', 800: '#92400e', 900: '#78350f' },
                dark: { 800: '#1a2e35', 900: '#0f1d22' }
            }
        }
    }
}
</script>

<!-- Alpine.js CDN -->
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

<style>
/* Hide problematic elements */
.gtranslate_wrapper, .language-selector-footer, #gtranslate_selector, .currency-selector-footer, [class*="language-switcher"], [class*="currency-switcher"] { display: none !important; }

/* Additional animations */
@keyframes float { 0%, 100% { transform: translateY(0px); } 50% { transform: translateY(-10px); } }
@keyframes pulse-ring { 0% { transform: scale(0.8); opacity: 1; } 100% { transform: scale(1.4); opacity: 0; } }
.animate-float { animation: float 3s ease-in-out infinite; }
.card-hover { transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); }
.card-hover:hover { transform: translateY(-12px) scale(1.02); }
.card-hover:hover .card-image img { transform: scale(1.1); }
.card-image img { transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1); }
.glass { background: rgba(255,255,255,0.1); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.2); }
.gradient-text { background: linear-gradient(135deg, #14b8a6, #f59e0b); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
</style>

<main x-data="{ 
    mobileFilters: false, 
    view: 'grid',
    activeFilters: [],
    sortBy: 'newest',
    showQuickView: false,
    quickViewItem: null
}" class="min-h-screen bg-gradient-to-b from-gray-50 to-white">
    
    <!-- Hero Section -->
    <section class="relative overflow-hidden bg-gradient-to-br from-dark-900 via-dark-800 to-primary-900">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-0 left-0 w-96 h-96 bg-primary-500 rounded-full filter blur-[100px]"></div>
            <div class="absolute bottom-0 right-0 w-96 h-96 bg-accent-500 rounded-full filter blur-[100px]"></div>
        </div>
        
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-28">
            <div class="text-center">
                <!-- Badge -->
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-white/10 backdrop-blur-sm rounded-full border border-white/20 mb-6">
                    <span class="animate-pulse w-2 h-2 bg-green-400 rounded-full"></span>
                    <span class="text-white/90 text-sm font-medium">150+ Curated Experiences</span>
                </div>
                
                <!-- Title -->
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-6">
                    Extraordinary <span class="gradient-text">Activities</span><br class="hidden md:block">
                    in Bali
                </h1>
                
                <p class="text-lg md:text-xl text-white/70 max-w-2xl mx-auto mb-10">
                    From thrilling adventures to peaceful retreats. Find your perfect Bali experience.
                </p>
                
                <!-- Search Bar -->
                <div class="max-w-3xl mx-auto">
                    <div class="flex flex-col md:flex-row gap-3 p-3 bg-white rounded-2xl shadow-2xl shadow-black/20">
                        <div class="flex-1 flex items-center gap-3 px-4 py-3 bg-gray-50 rounded-xl">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            <input type="text" placeholder="Search activities..." class="flex-1 bg-transparent border-none outline-none text-gray-700 placeholder-gray-400">
                        </div>
                        <div class="flex items-center gap-3 px-4 py-3 bg-gray-50 rounded-xl md:w-48">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            </svg>
                            <select class="flex-1 bg-transparent border-none outline-none text-gray-700 cursor-pointer">
                                <option value="">All Locations</option>
                                <?php if (!is_wp_error($locations)): foreach ($locations as $loc): ?>
                                    <option value="<?php echo esc_attr($loc->slug); ?>"><?php echo esc_html($loc->name); ?></option>
                                <?php endforeach; endif; ?>
                            </select>
                        </div>
                        <button class="flex items-center justify-center gap-2 px-8 py-3 bg-gradient-to-r from-primary-500 to-primary-600 text-white font-semibold rounded-xl hover:from-primary-600 hover:to-primary-700 transition-all duration-300 shadow-lg shadow-primary-500/30">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            Search
                        </button>
                    </div>
                </div>
                
                <!-- Stats -->
                <div class="flex flex-wrap justify-center gap-8 md:gap-16 mt-12">
                    <div class="text-center">
                        <div class="text-3xl md:text-4xl font-bold text-white">150+</div>
                        <div class="text-sm text-white/60">Activities</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl md:text-4xl font-bold text-white">50K+</div>
                        <div class="text-sm text-white/60">Happy Guests</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl md:text-4xl font-bold text-accent-400">4.9</div>
                        <div class="text-sm text-white/60">Rating</div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Wave Divider -->
        <div class="absolute bottom-0 left-0 right-0">
            <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-auto">
                <path d="M0 120L60 105C120 90 240 60 360 45C480 30 600 30 720 37.5C840 45 960 60 1080 67.5C1200 75 1320 75 1380 75L1440 75V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0Z" fill="#f9fafb"/>
            </svg>
        </div>
    </section>

    <!-- Main Content -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="flex flex-col lg:flex-row gap-8">
            
            <!-- Filters Sidebar (Desktop) -->
            <aside class="hidden lg:block w-80 flex-shrink-0">
                <div class="sticky top-24 space-y-6">
                    <!-- Filter Card -->
                    <div class="bg-white rounded-2xl shadow-lg shadow-gray-100 border border-gray-100 overflow-hidden">
                        <div class="flex items-center justify-between p-5 border-b border-gray-100">
                            <h3 class="font-bold text-gray-900 flex items-center gap-2">
                                <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                                </svg>
                                Filters
                            </h3>
                            <button class="text-sm text-primary-600 hover:text-primary-700 font-medium">Clear All</button>
                        </div>
                        
                        <div class="p-5 space-y-6">
                            <!-- Location -->
                            <div x-data="{ open: true }">
                                <button @click="open = !open" class="flex items-center justify-between w-full text-left">
                                    <span class="font-semibold text-gray-900">Location</span>
                                    <svg :class="{ 'rotate-180': open }" class="w-5 h-5 text-gray-400 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </button>
                                <div x-show="open" x-collapse class="mt-3 space-y-2">
                                    <?php if (!is_wp_error($locations)): foreach ($locations as $location): ?>
                                    <label class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-50 cursor-pointer transition-colors">
                                        <input type="checkbox" class="w-4 h-4 rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                                        <span class="text-sm text-gray-600"><?php echo esc_html($location->name); ?></span>
                                        <span class="ml-auto text-xs text-gray-400">(<?php echo $location->count; ?>)</span>
                                    </label>
                                    <?php endforeach; endif; ?>
                                </div>
                            </div>
                            
                            <!-- Activity Type -->
                            <div x-data="{ open: true }">
                                <button @click="open = !open" class="flex items-center justify-between w-full text-left">
                                    <span class="font-semibold text-gray-900">Activity Type</span>
                                    <svg :class="{ 'rotate-180': open }" class="w-5 h-5 text-gray-400 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </button>
                                <div x-show="open" x-collapse class="mt-3 space-y-2">
                                    <?php if (!is_wp_error($types)): foreach ($types as $type): ?>
                                    <label class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-50 cursor-pointer transition-colors">
                                        <input type="checkbox" class="w-4 h-4 rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                                        <span class="text-sm text-gray-600"><?php echo esc_html($type->name); ?></span>
                                        <span class="ml-auto text-xs text-gray-400">(<?php echo $type->count; ?>)</span>
                                    </label>
                                    <?php endforeach; endif; ?>
                                </div>
                            </div>
                            
                            <!-- Duration -->
                            <div x-data="{ open: true }">
                                <button @click="open = !open" class="flex items-center justify-between w-full text-left">
                                    <span class="font-semibold text-gray-900">Duration</span>
                                    <svg :class="{ 'rotate-180': open }" class="w-5 h-5 text-gray-400 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </button>
                                <div x-show="open" x-collapse class="mt-3 space-y-2">
                                    <label class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-50 cursor-pointer transition-colors">
                                        <input type="checkbox" class="w-4 h-4 rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                                        <span class="text-sm text-gray-600">Half Day (4-6 hours)</span>
                                    </label>
                                    <label class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-50 cursor-pointer transition-colors">
                                        <input type="checkbox" class="w-4 h-4 rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                                        <span class="text-sm text-gray-600">Full Day (8-10 hours)</span>
                                    </label>
                                    <label class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-50 cursor-pointer transition-colors">
                                        <input type="checkbox" class="w-4 h-4 rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                                        <span class="text-sm text-gray-600">Multi-Day</span>
                                    </label>
                                </div>
                            </div>
                            
                            <!-- Price Range -->
                            <div>
                                <span class="font-semibold text-gray-900">Price Range</span>
                                <div class="mt-3 flex items-center gap-3">
                                    <input type="number" placeholder="Min" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none">
                                    <span class="text-gray-400">—</span>
                                    <input type="number" placeholder="Max" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none">
                                </div>
                            </div>
                        </div>
                        
                        <div class="p-5 bg-gray-50 border-t border-gray-100">
                            <button class="w-full py-3 bg-gradient-to-r from-primary-500 to-primary-600 text-white font-semibold rounded-xl hover:from-primary-600 hover:to-primary-700 transition-all duration-300 shadow-lg shadow-primary-500/20">
                                Apply Filters
                            </button>
                        </div>
                    </div>
                    
                    <!-- Promo Card -->
                    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-accent-500 to-accent-600 p-6 text-white">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2"></div>
                        <div class="relative">
                            <div class="text-4xl mb-3">🎁</div>
                            <h4 class="font-bold text-lg mb-2">Special Offer!</h4>
                            <p class="text-white/90 text-sm mb-4">Get 15% off your first booking</p>
                            <div class="inline-block px-4 py-2 bg-white/20 backdrop-blur-sm rounded-lg font-mono font-bold">BALI15</div>
                        </div>
                    </div>
                </div>
            </aside>
            
            <!-- Mobile Filter Button -->
            <button @click="mobileFilters = true" class="lg:hidden flex items-center justify-center gap-2 w-full py-3 bg-white border border-gray-200 rounded-xl text-gray-700 font-medium shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                </svg>
                Filters
            </button>
            
            <!-- Activities Grid -->
            <div class="flex-1 min-w-0">
                <!-- Toolbar -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
                    <p class="text-gray-600">
                        <span class="font-semibold text-gray-900"><?php echo $activities_query->found_posts; ?></span> activities found
                    </p>
                    
                    <div class="flex items-center gap-4">
                        <div class="flex items-center gap-2">
                            <span class="text-sm text-gray-500">Sort:</span>
                            <select x-model="sortBy" class="px-3 py-2 bg-white border border-gray-200 rounded-lg text-sm cursor-pointer focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none">
                                <option value="newest">Newest</option>
                                <option value="popular">Most Popular</option>
                                <option value="price-low">Price: Low to High</option>
                                <option value="price-high">Price: High to Low</option>
                                <option value="rating">Top Rated</option>
                            </select>
                        </div>
                        
                        <div class="hidden sm:flex items-center gap-1 p-1 bg-gray-100 rounded-lg">
                            <button @click="view = 'grid'" :class="view === 'grid' ? 'bg-white shadow-sm text-primary-600' : 'text-gray-400'" class="p-2 rounded-md transition-all">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <rect x="3" y="3" width="7" height="7" rx="1"/>
                                    <rect x="14" y="3" width="7" height="7" rx="1"/>
                                    <rect x="3" y="14" width="7" height="7" rx="1"/>
                                    <rect x="14" y="14" width="7" height="7" rx="1"/>
                                </svg>
                            </button>
                            <button @click="view = 'list'" :class="view === 'list' ? 'bg-white shadow-sm text-primary-600' : 'text-gray-400'" class="p-2 rounded-md transition-all">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <rect x="3" y="4" width="18" height="4" rx="1"/>
                                    <rect x="3" y="10" width="18" height="4" rx="1"/>
                                    <rect x="3" y="16" width="18" height="4" rx="1"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Grid -->
                <div :class="view === 'grid' ? 'grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6' : 'space-y-4'">
                    <?php if ($activities_query->have_posts()) : $index = 0; ?>
                        <?php while ($activities_query->have_posts()) : $activities_query->the_post();
                            $price = '';
                            $rating = number_format(rand(45, 50) / 10, 1);
                            $duration = '';
                            $review_count = rand(50, 500);
                            
                            if (function_exists('bbt_get_tour_price')) {
                                $p = bbt_get_tour_price();
                                $price = is_numeric($p) ? 'IDR ' . number_format($p, 0, ',', '.') : (is_string($p) ? $p : '');
                            }
                            if (function_exists('bbt_get_tour_duration')) {
                                $d = bbt_get_tour_duration();
                                $duration = is_string($d) ? $d : '';
                            }
                        ?>
                        <!-- Activity Card -->
                        <article class="card-hover group bg-white rounded-2xl overflow-hidden shadow-lg shadow-gray-100 border border-gray-100" style="animation-delay: <?php echo $index * 0.05; ?>s">
                            <!-- Image -->
                            <div class="card-image relative aspect-[4/3] overflow-hidden">
                                <a href="<?php the_permalink(); ?>" class="block w-full h-full">
                                    <?php if (has_post_thumbnail()) : ?>
                                        <?php the_post_thumbnail('medium_large', ['class' => 'w-full h-full object-cover']); ?>
                                    <?php else : ?>
                                        <img src="https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=600" alt="<?php the_title_attribute(); ?>" class="w-full h-full object-cover">
                                    <?php endif; ?>
                                </a>
                                
                                <!-- Badges -->
                                <div class="absolute top-4 left-4 flex flex-wrap gap-2">
                                    <span class="px-3 py-1 bg-black/70 backdrop-blur-sm text-white text-xs font-semibold rounded-full flex items-center gap-1">
                                        ⭐ <?php echo $rating; ?>
                                    </span>
                                    <?php if ($index < 3) : ?>
                                    <span class="px-3 py-1 bg-gradient-to-r from-red-500 to-orange-500 text-white text-xs font-semibold rounded-full">
                                        🔥 Popular
                                    </span>
                                    <?php endif; ?>
                                </div>
                                
                                <!-- Wishlist -->
                                <button class="absolute top-4 right-4 w-10 h-10 bg-white/90 backdrop-blur-sm rounded-full flex items-center justify-center text-gray-600 hover:text-red-500 hover:bg-white transition-all shadow-lg opacity-0 group-hover:opacity-100 translate-y-2 group-hover:translate-y-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                    </svg>
                                </button>
                                
                                <!-- Quick View Overlay -->
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex items-end justify-center pb-4">
                                    <a href="<?php the_permalink(); ?>" class="px-6 py-2 bg-white/90 backdrop-blur-sm text-gray-900 text-sm font-semibold rounded-full hover:bg-white transition-colors">
                                        Quick View
                                    </a>
                                </div>
                            </div>
                            
                            <!-- Content -->
                            <div class="p-5">
                                <!-- Meta -->
                                <div class="flex items-center gap-4 text-xs text-gray-500 mb-3">
                                    <?php if ($duration) : ?>
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <circle cx="12" cy="12" r="10" stroke-width="2"/>
                                            <path stroke-width="2" d="M12 6v6l4 2"/>
                                        </svg>
                                        <?php echo esc_html($duration); ?>
                                    </span>
                                    <?php endif; ?>
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                            <circle cx="12" cy="10" r="3" stroke-width="2"/>
                                        </svg>
                                        Bali
                                    </span>
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                        <?php echo $review_count; ?> reviews
                                    </span>
                                </div>
                                
                                <!-- Title -->
                                <h3 class="font-bold text-gray-900 text-lg mb-2 line-clamp-2 group-hover:text-primary-600 transition-colors">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h3>
                                
                                <!-- Excerpt -->
                                <p class="text-gray-500 text-sm line-clamp-2 mb-4">
                                    <?php echo wp_trim_words(get_the_excerpt(), 15, '...'); ?>
                                </p>
                                
                                <!-- Footer -->
                                <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                                    <div>
                                        <span class="text-xs text-gray-400 block">From</span>
                                        <span class="text-lg font-bold text-primary-600"><?php echo esc_html($price ?: 'IDR 450,000'); ?></span>
                                    </div>
                                    <a href="<?php the_permalink(); ?>" class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-primary-500 to-primary-600 text-white text-sm font-semibold rounded-xl hover:from-primary-600 hover:to-primary-700 transition-all shadow-lg shadow-primary-500/20 group/btn">
                                        Book Now
                                        <svg class="w-4 h-4 transition-transform group-hover/btn:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </article>
                        <?php $index++; endwhile; wp_reset_postdata(); ?>
                    <?php else : ?>
                        <div class="col-span-full py-20 text-center">
                            <div class="text-6xl mb-4">🔍</div>
                            <h3 class="text-xl font-bold text-gray-900 mb-2">No activities found</h3>
                            <p class="text-gray-500">Try adjusting your filters or search criteria.</p>
                        </div>
                    <?php endif; ?>
                </div>
                
                <!-- Pagination -->
                <?php if ($activities_query->max_num_pages > 1) : ?>
                <nav class="mt-12 flex justify-center">
                    <div class="inline-flex items-center gap-2">
                        <?php
                        echo paginate_links(array(
                            'total' => $activities_query->max_num_pages,
                            'current' => $paged,
                            'prev_text' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>',
                            'next_text' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>',
                            'before_page_number' => '<span class="px-4 py-2 rounded-lg hover:bg-gray-100 transition-colors">',
                            'after_page_number' => '</span>',
                        ));
                        ?>
                    </div>
                </nav>
                <?php endif; ?>
            </div>
        </div>
    </section>
    
    <!-- Mobile Filter Drawer -->
    <div x-show="mobileFilters" x-cloak class="fixed inset-0 z-50 lg:hidden">
        <!-- Overlay -->
        <div @click="mobileFilters = false" x-show="mobileFilters" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="absolute inset-0 bg-black/50"></div>
        
        <!-- Drawer -->
        <div x-show="mobileFilters" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full" class="absolute right-0 top-0 bottom-0 w-80 max-w-full bg-white shadow-2xl overflow-y-auto">
            <div class="sticky top-0 flex items-center justify-between p-4 bg-white border-b border-gray-100">
                <h3 class="font-bold text-lg">Filters</h3>
                <button @click="mobileFilters = false" class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            
            <div class="p-4">
                <!-- Mobile filter content here - same as desktop -->
                <p class="text-gray-500 text-center py-8">Filter options...</p>
            </div>
            
            <div class="sticky bottom-0 p-4 bg-white border-t border-gray-100">
                <button @click="mobileFilters = false" class="w-full py-3 bg-gradient-to-r from-primary-500 to-primary-600 text-white font-semibold rounded-xl">
                    Apply Filters
                </button>
            </div>
        </div>
    </div>
</main>

<?php get_footer(); ?>