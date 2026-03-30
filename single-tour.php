<?php
/**
 * Single Tour Template - Full Width Layout
 * Matches mockup design with proper width
 */

get_header();

// Start the loop
while (have_posts()) : the_post();

// Get tour data
$tour_id = get_the_ID();
$tour_title = get_the_title();
$tour_content = apply_filters('the_content', get_the_content());

// Get tour meta with safe defaults
$gallery = [];
if (function_exists('bbt_get_tour_gallery')) {
    $g = bbt_get_tour_gallery($tour_id);
    $gallery = is_array($g) ? $g : [];
}

$duration = '';
if (function_exists('bbt_get_tour_duration')) {
    $d = bbt_get_tour_duration($tour_id);
    $duration = is_string($d) ? $d : (is_array($d) ? '' : '');
}

$price = '0';
if (function_exists('bbt_get_tour_price')) {
    $p = bbt_get_tour_price($tour_id);
    $price = is_numeric($p) ? number_format($p, 0, ',', '.') : (is_string($p) ? $p : '0');
}

$rating = 5;
if (function_exists('bbt_get_tour_rating')) {
    $r = bbt_get_tour_rating($tour_id);
    $rating = is_numeric($r) ? floatval($r) : 5;
}

$highlights = [];
if (function_exists('bbt_get_tour_highlights')) {
    $h = bbt_get_tour_highlights($tour_id);
    $highlights = is_array($h) ? $h : [];
}

$included = [];
if (function_exists('bbt_get_tour_included')) {
    $inc = bbt_get_tour_included($tour_id);
    $included = is_array($inc) ? $inc : [];
}

$excluded = [];
if (function_exists('bbt_get_tour_excluded')) {
    $exc = bbt_get_tour_excluded($tour_id);
    $excluded = is_array($exc) ? $exc : [];
}

$itinerary = [];
if (function_exists('bbt_get_tour_itinerary')) {
    $it = bbt_get_tour_itinerary($tour_id);
    $itinerary = is_array($it) ? $it : [];
}

// Images
$hero_img = has_post_thumbnail() ? get_the_post_thumbnail_url($tour_id, 'full') : 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=1200';

// WhatsApp
$whatsapp = get_theme_mod('bbt_whatsapp_number', '6287854806011');
?>

<style>
/* ============================================
   FULL WIDTH RESET - OVERRIDE ALL PARENTS
============================================ */
body.single-tour #page,
body.single-tour .site,
body.single-tour .site-content,
body.single-tour #content,
body.single-tour .content-area,
body.single-tour #primary,
body.single-tour #main,
body.single-tour .site-main,
body.single-tour article,
body.single-tour .entry-content,
body#error-page {
    width: 100% !important;
    max-width: 100% !important;
    padding-left: 0 !important;
    padding-right: 0 !important;
    margin: 0 !important;
}

/* ============================================
   TOUR PAGE WRAPPER
============================================ */
.bbt-tour-page {
    background: #f5f7fa;
    min-height: 100vh;
    width: 100%;
}

/* ============================================
   HERO SECTION - FULL WIDTH
============================================ */
.bbt-tour-hero {
    position: relative;
    width: 100%;
    height: 420px;
    background: #1a3c40;
    overflow: hidden;
}
.bbt-tour-hero-bg {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    opacity: 0.7;
}
.bbt-tour-hero-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(to bottom, rgba(26,60,64,0.4) 0%, rgba(26,60,64,0.8) 100%);
}
.bbt-tour-hero-content {
    position: relative;
    z-index: 10;
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 30px;
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: flex-end;
    padding-bottom: 50px;
    color: #fff;
}
.bbt-tour-breadcrumb {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 14px;
    margin-bottom: 20px;
    opacity: 0.9;
}
.bbt-tour-breadcrumb a {
    color: #fff;
    text-decoration: none;
}
.bbt-tour-breadcrumb a:hover {
    text-decoration: underline;
}
.bbt-tour-breadcrumb span {
    opacity: 0.6;
}
.bbt-tour-title {
    font-size: 48px;
    font-weight: 700;
    margin: 0 0 25px 0;
    line-height: 1.2;
}
.bbt-tour-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 30px;
}
.bbt-tour-meta-item {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 15px;
}
.bbt-tour-meta-item svg {
    width: 20px;
    height: 20px;
    opacity: 0.9;
}

/* ============================================
   MAIN CONTAINER - 1400px MAX
============================================ */
.bbt-tour-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 30px;
}

/* ============================================
   LAYOUT - TWO COLUMNS
============================================ */
.bbt-tour-layout {
    display: grid;
    grid-template-columns: 1fr 380px;
    gap: 40px;
    margin-top: -80px;
    position: relative;
    z-index: 20;
    padding-bottom: 60px;
}

/* ============================================
   LEFT COLUMN - CONTENT
============================================ */
.bbt-tour-main {
    display: flex;
    flex-direction: column;
    gap: 30px;
}

/* Card Base */
.bbt-tour-card {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    overflow: hidden;
}

/* Gallery */
.bbt-tour-gallery {
    padding: 20px;
}
.bbt-tour-gallery-main {
    width: 100%;
    height: 450px;
    object-fit: cover;
    border-radius: 12px;
}
.bbt-tour-gallery-thumbs {
    display: flex;
    gap: 12px;
    margin-top: 15px;
    overflow-x: auto;
    padding-bottom: 5px;
}
.bbt-tour-gallery-thumb {
    flex: 0 0 100px;
    height: 70px;
    border-radius: 8px;
    object-fit: cover;
    cursor: pointer;
    opacity: 0.6;
    transition: all 0.3s ease;
    border: 3px solid transparent;
}
.bbt-tour-gallery-thumb:hover,
.bbt-tour-gallery-thumb.active {
    opacity: 1;
    border-color: #16a085;
}

/* Content Section */
.bbt-tour-content {
    padding: 35px;
}
.bbt-tour-section-title {
    font-size: 24px;
    font-weight: 700;
    color: #1a3c40;
    margin: 0 0 20px 0;
    padding-bottom: 15px;
    border-bottom: 2px solid #f0f0f0;
}
.bbt-tour-description {
    font-size: 16px;
    line-height: 1.8;
    color: #555;
}
.bbt-tour-description p {
    margin-bottom: 15px;
}

/* Highlights */
.bbt-tour-highlights {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 20px;
    margin-top: 30px;
}
.bbt-tour-highlight-item {
    display: flex;
    align-items: flex-start;
    gap: 15px;
    padding: 20px;
    background: #f8fafa;
    border-radius: 12px;
    transition: transform 0.3s ease;
}
.bbt-tour-highlight-item:hover {
    transform: translateY(-3px);
}
.bbt-tour-highlight-icon {
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, #16a085, #1abc9c);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    flex-shrink: 0;
}
.bbt-tour-highlight-text {
    font-size: 15px;
    font-weight: 500;
    color: #333;
    line-height: 1.5;
}

/* Tabs */
.bbt-tour-tabs {
    margin-top: 35px;
}
.bbt-tour-tabs-nav {
    display: flex;
    gap: 5px;
    border-bottom: 2px solid #f0f0f0;
}
.bbt-tour-tab-btn {
    padding: 15px 30px;
    background: none;
    border: none;
    font-size: 15px;
    font-weight: 600;
    color: #888;
    cursor: pointer;
    position: relative;
    transition: color 0.3s;
}
.bbt-tour-tab-btn::after {
    content: '';
    position: absolute;
    bottom: -2px;
    left: 0;
    right: 0;
    height: 3px;
    background: #16a085;
    border-radius: 3px 3px 0 0;
    transform: scaleX(0);
    transition: transform 0.3s;
}
.bbt-tour-tab-btn:hover {
    color: #16a085;
}
.bbt-tour-tab-btn.active {
    color: #16a085;
}
.bbt-tour-tab-btn.active::after {
    transform: scaleX(1);
}
.bbt-tour-tab-content {
    display: none;
    padding-top: 30px;
}
.bbt-tour-tab-content.active {
    display: block;
}

/* Itinerary List */
.bbt-tour-itinerary-list {
    display: flex;
    flex-direction: column;
    gap: 20px;
}
.bbt-tour-itinerary-item {
    display: flex;
    gap: 20px;
    padding: 20px;
    background: #f8fafa;
    border-radius: 12px;
    border-left: 4px solid #16a085;
}
.bbt-tour-itinerary-time {
    flex: 0 0 100px;
    font-size: 14px;
    font-weight: 700;
    color: #16a085;
}
.bbt-tour-itinerary-content {
    flex: 1;
}
.bbt-tour-itinerary-title {
    font-size: 16px;
    font-weight: 600;
    color: #1a3c40;
    margin: 0 0 8px 0;
}
.bbt-tour-itinerary-desc {
    font-size: 14px;
    color: #666;
    line-height: 1.6;
    margin: 0;
}

/* Include/Exclude Lists */
.bbt-tour-lists-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 40px;
}
.bbt-tour-list-title {
    font-size: 18px;
    font-weight: 600;
    margin: 0 0 20px 0;
    display: flex;
    align-items: center;
    gap: 10px;
}
.bbt-tour-list-title.included {
    color: #27ae60;
}
.bbt-tour-list-title.excluded {
    color: #e74c3c;
}
.bbt-tour-list {
    list-style: none;
    padding: 0;
    margin: 0;
}
.bbt-tour-list li {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    padding: 12px 0;
    border-bottom: 1px solid #f0f0f0;
    font-size: 14px;
    color: #555;
}
.bbt-tour-list li:last-child {
    border-bottom: none;
}
.bbt-tour-list li svg {
    width: 18px;
    height: 18px;
    flex-shrink: 0;
    margin-top: 2px;
}
.bbt-tour-list li.included svg {
    color: #27ae60;
}
.bbt-tour-list li.excluded svg {
    color: #e74c3c;
}

/* ============================================
   RIGHT COLUMN - SIDEBAR
============================================ */
.bbt-tour-sidebar {
    position: sticky;
    top: 100px;
    display: flex;
    flex-direction: column;
    gap: 25px;
}

/* Booking Widget */
.bbt-tour-booking {
    padding: 0;
}
.bbt-tour-price-box {
    background: linear-gradient(135deg, #1a3c40, #16a085);
    padding: 30px;
    text-align: center;
    color: #fff;
}
.bbt-tour-price-badge {
    display: inline-block;
    background: rgba(255,255,255,0.2);
    padding: 5px 15px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    margin-bottom: 15px;
}
.bbt-tour-price-value {
    font-size: 36px;
    font-weight: 700;
}
.bbt-tour-price-value small {
    font-size: 16px;
    font-weight: 400;
    opacity: 0.9;
}
.bbt-tour-rating {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 5px;
    margin-top: 15px;
}
.bbt-tour-rating svg {
    width: 18px;
    height: 18px;
    fill: #ffc107;
}
.bbt-tour-rating span {
    font-size: 14px;
    margin-left: 5px;
    opacity: 0.9;
}

.bbt-tour-booking-form {
    padding: 30px;
}
.bbt-tour-form-group {
    margin-bottom: 20px;
}
.bbt-tour-form-label {
    display: block;
    font-size: 13px;
    font-weight: 600;
    color: #555;
    margin-bottom: 8px;
}
.bbt-tour-form-input {
    width: 100%;
    padding: 14px 16px;
    border: 2px solid #e8e8e8;
    border-radius: 10px;
    font-size: 14px;
    transition: border-color 0.3s;
}
.bbt-tour-form-input:focus {
    outline: none;
    border-color: #16a085;
}

.bbt-tour-qty-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px 0;
    border-bottom: 1px solid #f0f0f0;
}
.bbt-tour-qty-label {
    font-size: 14px;
    color: #555;
}
.bbt-tour-qty-label small {
    display: block;
    font-size: 12px;
    color: #999;
}
.bbt-tour-qty-control {
    display: flex;
    align-items: center;
    gap: 15px;
}
.bbt-tour-qty-btn {
    width: 36px;
    height: 36px;
    border: 2px solid #e8e8e8;
    background: #fff;
    border-radius: 8px;
    font-size: 20px;
    cursor: pointer;
    transition: all 0.3s;
    display: flex;
    align-items: center;
    justify-content: center;
}
.bbt-tour-qty-btn:hover {
    background: #16a085;
    border-color: #16a085;
    color: #fff;
}
.bbt-tour-qty-value {
    font-size: 18px;
    font-weight: 600;
    width: 30px;
    text-align: center;
}

.bbt-tour-book-btn {
    width: 100%;
    padding: 18px;
    background: linear-gradient(135deg, #16a085, #1abc9c);
    color: #fff;
    border: none;
    border-radius: 12px;
    font-size: 16px;
    font-weight: 700;
    cursor: pointer;
    margin-top: 25px;
    transition: transform 0.3s, box-shadow 0.3s;
}
.bbt-tour-book-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(22, 160, 133, 0.35);
}

.bbt-tour-whatsapp-btn {
    width: 100%;
    padding: 16px;
    background: #25d366;
    color: #fff;
    border: none;
    border-radius: 12px;
    font-size: 15px;
    font-weight: 600;
    cursor: pointer;
    margin-top: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    text-decoration: none;
    transition: background 0.3s;
}
.bbt-tour-whatsapp-btn:hover {
    background: #1da851;
    color: #fff;
}
.bbt-tour-whatsapp-btn svg {
    width: 22px;
    height: 22px;
}

/* Quick Info Widget */
.bbt-tour-quick-info {
    padding: 30px;
}
.bbt-tour-quick-title {
    font-size: 18px;
    font-weight: 700;
    color: #1a3c40;
    margin: 0 0 25px 0;
}
.bbt-tour-quick-list {
    display: flex;
    flex-direction: column;
    gap: 18px;
}
.bbt-tour-quick-item {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    font-size: 14px;
    color: #555;
}
.bbt-tour-quick-item svg {
    width: 18px;
    height: 18px;
    color: #16a085;
    flex-shrink: 0;
    margin-top: 2px;
}

/* ============================================
   RESPONSIVE
============================================ */
@media (max-width: 1200px) {
    .bbt-tour-layout {
        grid-template-columns: 1fr 350px;
        gap: 30px;
    }
    .bbt-tour-title {
        font-size: 40px;
    }
}

@media (max-width: 992px) {
    .bbt-tour-layout {
        grid-template-columns: 1fr;
    }
    .bbt-tour-sidebar {
        position: static;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }
    .bbt-tour-hero {
        height: 350px;
    }
    .bbt-tour-title {
        font-size: 34px;
    }
    .bbt-tour-layout {
        margin-top: -60px;
    }
}

@media (max-width: 768px) {
    .bbt-tour-hero {
        height: 320px;
    }
    .bbt-tour-hero-content {
        padding: 0 20px;
        padding-bottom: 40px;
    }
    .bbt-tour-title {
        font-size: 28px;
    }
    .bbt-tour-meta {
        gap: 15px;
    }
    .bbt-tour-meta-item {
        font-size: 13px;
    }
    .bbt-tour-container {
        padding: 0 15px;
    }
    .bbt-tour-layout {
        margin-top: -50px;
        gap: 20px;
    }
    .bbt-tour-sidebar {
        grid-template-columns: 1fr;
    }
    .bbt-tour-gallery-main {
        height: 300px;
    }
    .bbt-tour-content {
        padding: 25px;
    }
    .bbt-tour-highlights {
        grid-template-columns: 1fr;
    }
    .bbt-tour-tabs-nav {
        flex-wrap: wrap;
    }
    .bbt-tour-tab-btn {
        padding: 12px 20px;
        font-size: 14px;
    }
    .bbt-tour-lists-grid {
        grid-template-columns: 1fr;
        gap: 30px;
    }
    .bbt-tour-booking-form {
        padding: 20px;
    }
}

@media (max-width: 480px) {
    .bbt-tour-hero {
        height: 280px;
    }
    .bbt-tour-title {
        font-size: 24px;
    }
    .bbt-tour-breadcrumb {
        font-size: 12px;
    }
    .bbt-tour-section-title {
        font-size: 20px;
    }
    .bbt-tour-gallery-main {
        height: 250px;
    }
    .bbt-tour-price-value {
        font-size: 28px;
    }
}
</style>

<div class="bbt-tour-page">
    <!-- HERO SECTION -->
    <section class="bbt-tour-hero">
        <img class="bbt-tour-hero-bg" src="<?php echo esc_url($hero_img); ?>" alt="<?php echo esc_attr($tour_title); ?>">
        <div class="bbt-tour-hero-overlay"></div>
        <div class="bbt-tour-hero-content">
            <nav class="bbt-tour-breadcrumb">
                <a href="<?php echo esc_url(home_url('/')); ?>">Home</a>
                <span>›</span>
                <a href="<?php echo esc_url(home_url('/tours')); ?>">Tours</a>
                <span>›</span>
                <span><?php echo esc_html($tour_title); ?></span>
            </nav>
            <h1 class="bbt-tour-title"><?php echo esc_html($tour_title); ?></h1>
            <div class="bbt-tour-meta">
                <?php if (!empty($duration)) : ?>
                <div class="bbt-tour-meta-item">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                    <span><?php echo esc_html($duration); ?></span>
                </div>
                <?php endif; ?>
                <div class="bbt-tour-meta-item">
                    <svg fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                    <span><?php echo number_format($rating, 1); ?>/5 (124 Reviews)</span>
                </div>
                <div class="bbt-tour-meta-item">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    <span>Max 8 People</span>
                </div>
            </div>
        </div>
    </section>

    <!-- MAIN CONTAINER -->
    <div class="bbt-tour-container">
        <div class="bbt-tour-layout">
            <!-- LEFT COLUMN -->
            <div class="bbt-tour-main">
                <!-- Gallery Card -->
                <div class="bbt-tour-card bbt-tour-gallery">
                    <img class="bbt-tour-gallery-main" id="mainGalleryImage" src="<?php echo esc_url($hero_img); ?>" alt="<?php echo esc_attr($tour_title); ?>">
                    <?php if (!empty($gallery)) : ?>
                    <div class="bbt-tour-gallery-thumbs">
                        <?php foreach ($gallery as $index => $img) : 
                            $img_url = '';
                            if (is_array($img) && isset($img['url'])) {
                                $img_url = $img['url'];
                            } elseif (is_string($img)) {
                                $img_url = $img;
                            }
                            if (empty($img_url)) continue;
                        ?>
                        <img class="bbt-tour-gallery-thumb<?php echo $index === 0 ? ' active' : ''; ?>" 
                             src="<?php echo esc_url($img_url); ?>" 
                             alt="Gallery <?php echo $index + 1; ?>"
                             onclick="changeGalleryImage(this)">
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- Content Card -->
                <div class="bbt-tour-card bbt-tour-content">
                    <h2 class="bbt-tour-section-title">About This Tour</h2>
                    <div class="bbt-tour-description">
                        <?php echo $tour_content; ?>
                    </div>

                    <!-- Highlights -->
                    <?php if (!empty($highlights)) : ?>
                    <h3 class="bbt-tour-section-title" style="margin-top: 40px;">Highlights</h3>
                    <div class="bbt-tour-highlights">
                        <?php 
                        $icons = ['🏛️', '🌾', '💃', '🏘️', '🐘', '🌅', '🛕', '🎭'];
                        foreach ($highlights as $i => $hl) : 
                            $hl_text = '';
                            if (is_array($hl) && isset($hl['text'])) {
                                $hl_text = $hl['text'];
                            } elseif (is_string($hl)) {
                                $hl_text = $hl;
                            }
                            if (empty($hl_text)) continue;
                        ?>
                        <div class="bbt-tour-highlight-item">
                            <div class="bbt-tour-highlight-icon"><?php echo $icons[$i % count($icons)]; ?></div>
                            <span class="bbt-tour-highlight-text"><?php echo esc_html($hl_text); ?></span>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>

                    <!-- Tabs -->
                    <div class="bbt-tour-tabs">
                        <div class="bbt-tour-tabs-nav">
                            <button class="bbt-tour-tab-btn active" data-tab="itinerary">Itinerary</button>
                            <button class="bbt-tour-tab-btn" data-tab="included">Included</button>
                            <button class="bbt-tour-tab-btn" data-tab="info">Info</button>
                        </div>

                        <!-- Itinerary Tab -->
                        <div class="bbt-tour-tab-content active" id="tab-itinerary">
                            <div class="bbt-tour-itinerary-list">
                                <?php if (!empty($itinerary)) : ?>
                                    <?php foreach ($itinerary as $i => $item) : 
                                        $item_time = '';
                                        $item_title = '';
                                        $item_desc = '';
                                        if (is_array($item)) {
                                            $item_time = isset($item['time']) ? $item['time'] : ('Day ' . ($i + 1));
                                            $item_title = isset($item['title']) ? $item['title'] : '';
                                            $item_desc = isset($item['description']) ? $item['description'] : '';
                                        } elseif (is_string($item)) {
                                            $item_time = 'Day ' . ($i + 1);
                                            $item_desc = $item;
                                        }
                                    ?>
                                    <div class="bbt-tour-itinerary-item">
                                        <div class="bbt-tour-itinerary-time"><?php echo esc_html($item_time); ?></div>
                                        <div class="bbt-tour-itinerary-content">
                                            <?php if (!empty($item_title)) : ?>
                                            <h4 class="bbt-tour-itinerary-title"><?php echo esc_html($item_title); ?></h4>
                                            <?php endif; ?>
                                            <p class="bbt-tour-itinerary-desc"><?php echo esc_html($item_desc); ?></p>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <div class="bbt-tour-itinerary-item">
                                        <div class="bbt-tour-itinerary-time">08:30 AM</div>
                                        <div class="bbt-tour-itinerary-content">
                                            <h4 class="bbt-tour-itinerary-title">Hotel Pickup</h4>
                                            <p class="bbt-tour-itinerary-desc">Our private vehicle will pick you up from your accommodation.</p>
                                        </div>
                                    </div>
                                    <div class="bbt-tour-itinerary-item">
                                        <div class="bbt-tour-itinerary-time">09:30 AM</div>
                                        <div class="bbt-tour-itinerary-content">
                                            <h4 class="bbt-tour-itinerary-title">First Destination</h4>
                                            <p class="bbt-tour-itinerary-desc">Explore the beautiful sights and cultural landmarks.</p>
                                        </div>
                                    </div>
                                    <div class="bbt-tour-itinerary-item">
                                        <div class="bbt-tour-itinerary-time">12:00 PM</div>
                                        <div class="bbt-tour-itinerary-content">
                                            <h4 class="bbt-tour-itinerary-title">Lunch Break</h4>
                                            <p class="bbt-tour-itinerary-desc">Enjoy authentic local cuisine at a traditional restaurant.</p>
                                        </div>
                                    </div>
                                    <div class="bbt-tour-itinerary-item">
                                        <div class="bbt-tour-itinerary-time">06:00 PM</div>
                                        <div class="bbt-tour-itinerary-content">
                                            <h4 class="bbt-tour-itinerary-title">Return to Hotel</h4>
                                            <p class="bbt-tour-itinerary-desc">Conclude the tour with a comfortable drop-off at your accommodation.</p>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Included Tab -->
                        <div class="bbt-tour-tab-content" id="tab-included">
                            <div class="bbt-tour-lists-grid">
                                <div>
                                    <h4 class="bbt-tour-list-title included">
                                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"/></svg>
                                        What's Included
                                    </h4>
                                    <ul class="bbt-tour-list">
                                        <?php if (!empty($included)) : ?>
                                            <?php foreach ($included as $inc) : 
                                                $inc_text = '';
                                                if (is_array($inc) && isset($inc['text'])) {
                                                    $inc_text = $inc['text'];
                                                } elseif (is_string($inc)) {
                                                    $inc_text = $inc;
                                                }
                                                if (empty($inc_text)) continue;
                                            ?>
                                            <li class="included">
                                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"/></svg>
                                                <?php echo esc_html($inc_text); ?>
                                            </li>
                                            <?php endforeach; ?>
                                        <?php else : ?>
                                            <li class="included"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"/></svg> Hotel pickup & drop-off</li>
                                            <li class="included"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"/></svg> Private air-conditioned transport</li>
                                            <li class="included"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"/></svg> English speaking guide</li>
                                            <li class="included"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"/></svg> All entrance fees</li>
                                            <li class="included"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"/></svg> Lunch at local restaurant</li>
                                            <li class="included"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"/></svg> Mineral water included</li>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                                <div>
                                    <h4 class="bbt-tour-list-title excluded">
                                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12"/></svg>
                                        Not Included
                                    </h4>
                                    <ul class="bbt-tour-list">
                                        <?php if (!empty($excluded)) : ?>
                                            <?php foreach ($excluded as $exc) : 
                                                $exc_text = '';
                                                if (is_array($exc) && isset($exc['text'])) {
                                                    $exc_text = $exc['text'];
                                                } elseif (is_string($exc)) {
                                                    $exc_text = $exc;
                                                }
                                                if (empty($exc_text)) continue;
                                            ?>
                                            <li class="excluded">
                                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12"/></svg>
                                                <?php echo esc_html($exc_text); ?>
                                            </li>
                                            <?php endforeach; ?>
                                        <?php else : ?>
                                            <li class="excluded"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12"/></svg> Travel insurance</li>
                                            <li class="excluded"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12"/></svg> Personal expenses</li>
                                            <li class="excluded"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12"/></svg> Tips & gratuities</li>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Info Tab -->
                        <div class="bbt-tour-tab-content" id="tab-info">
                            <div class="bbt-tour-lists-grid">
                                <div>
                                    <ul class="bbt-tour-list">
                                        <li class="included"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"/></svg> Instant confirmation</li>
                                        <li class="included"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"/></svg> Mobile voucher accepted</li>
                                        <li class="included"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"/></svg> Free cancellation up to 24h</li>
                                    </ul>
                                </div>
                                <div>
                                    <ul class="bbt-tour-list">
                                        <li class="included"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"/></svg> Wheelchair accessible</li>
                                        <li class="included"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"/></svg> Stroller accessible</li>
                                        <li class="included"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"/></svg> Service animals allowed</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- RIGHT COLUMN - SIDEBAR -->
            <aside class="bbt-tour-sidebar">
                <!-- Booking Widget -->
                <div class="bbt-tour-card bbt-tour-booking">
                    <div class="bbt-tour-price-box">
                        <span class="bbt-tour-price-badge">Best Value</span>
                        <div class="bbt-tour-price-value">
                            IDR <?php echo esc_html($price); ?> <small>/person</small>
                        </div>
                        <div class="bbt-tour-rating">
                            <?php for ($s = 1; $s <= 5; $s++) : ?>
                            <svg viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                            <?php endfor; ?>
                            <span>(124 Reviews)</span>
                        </div>
                    </div>
                    <div class="bbt-tour-booking-form">
                        <div class="bbt-tour-form-group">
                            <label class="bbt-tour-form-label">Select Date</label>
                            <input type="date" class="bbt-tour-form-input" min="<?php echo date('Y-m-d'); ?>">
                        </div>

                        <div class="bbt-tour-qty-row">
                            <div class="bbt-tour-qty-label">
                                Adults
                                <small>Ages 12+</small>
                            </div>
                            <div class="bbt-tour-qty-control">
                                <button class="bbt-tour-qty-btn" onclick="changeQty(this, -1)">−</button>
                                <span class="bbt-tour-qty-value">2</span>
                                <button class="bbt-tour-qty-btn" onclick="changeQty(this, 1)">+</button>
                            </div>
                        </div>

                        <div class="bbt-tour-qty-row">
                            <div class="bbt-tour-qty-label">
                                Children
                                <small>Ages 5-11</small>
                            </div>
                            <div class="bbt-tour-qty-control">
                                <button class="bbt-tour-qty-btn" onclick="changeQty(this, -1)">−</button>
                                <span class="bbt-tour-qty-value">0</span>
                                <button class="bbt-tour-qty-btn" onclick="changeQty(this, 1)">+</button>
                            </div>
                        </div>

                        <button class="bbt-tour-book-btn">Book Now</button>
                        
                        <a href="https://wa.me/<?php echo esc_attr($whatsapp); ?>?text=<?php echo rawurlencode('Hi! I want to book: ' . $tour_title); ?>" class="bbt-tour-whatsapp-btn" target="_blank">
                            <svg fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                            WhatsApp Us
                        </a>
                    </div>
                </div>

                <!-- Quick Info -->
                <div class="bbt-tour-card bbt-tour-quick-info">
                    <h3 class="bbt-tour-quick-title">Quick Info</h3>
                    <div class="bbt-tour-quick-list">
                        <div class="bbt-tour-quick-item">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"/></svg>
                            <span>Instant Confirmation</span>
                        </div>
                        <div class="bbt-tour-quick-item">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"/></svg>
                            <span>Mobile Voucher Accepted</span>
                        </div>
                        <div class="bbt-tour-quick-item">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"/></svg>
                            <span>Free Cancellation up to 24h</span>
                        </div>
                        <div class="bbt-tour-quick-item">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"/></svg>
                            <span>English Speaking Guide</span>
                        </div>
                        <div class="bbt-tour-quick-item">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"/></svg>
                            <span>Private Air-Conditioned Transport</span>
                        </div>
                        <div class="bbt-tour-quick-item">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"/></svg>
                            <span>Mineral Water Included</span>
                        </div>
                    </div>
                </div>
            </aside>
        </div>
    </div>
</div>

<script>
// Gallery Image Change
function changeGalleryImage(thumb) {
    document.querySelectorAll('.bbt-tour-gallery-thumb').forEach(t => t.classList.remove('active'));
    thumb.classList.add('active');
    document.getElementById('mainGalleryImage').src = thumb.src;
}

// Quantity Controls
function changeQty(btn, delta) {
    const valueEl = btn.parentElement.querySelector('.bbt-tour-qty-value');
    let val = parseInt(valueEl.textContent) + delta;
    if (val < 0) val = 0;
    if (val > 20) val = 20;
    valueEl.textContent = val;
}

// Tabs
document.querySelectorAll('.bbt-tour-tab-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const tabId = 'tab-' + this.dataset.tab;
        
        document.querySelectorAll('.bbt-tour-tab-btn').forEach(b => b.classList.remove('active'));
        this.classList.add('active');
        
        document.querySelectorAll('.bbt-tour-tab-content').forEach(c => c.classList.remove('active'));
        document.getElementById(tabId).classList.add('active');
    });
});
</script>

<?php endwhile; ?>

<?php get_footer(); ?>
