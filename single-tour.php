<?php
/**
 * Single Tour Template - Forever Vacation Design
 * Premium layout with dynamic data from Edit Tour meta fields
 *
 * @package BestBaliTravel
 */

get_header();

// Enqueue the dedicated CSS
wp_enqueue_style('bbt-single-tour', get_template_directory_uri() . '/assets/css/single-tour.css', array(), '2.0');

// Enqueue Font Awesome if not already loaded
wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css');

while (have_posts()) : the_post();

$tour_id    = get_the_ID();
$tour_title = get_the_title();
$tour_desc  = apply_filters('the_content', get_the_content());

// --- Fetch all meta data ---
$price_data    = bbt_get_tour_price($tour_id);
$duration_data = bbt_get_tour_duration($tour_id);
$rating_data   = bbt_get_tour_rating($tour_id);
$gallery_ids   = bbt_get_tour_gallery($tour_id);
$itinerary     = bbt_get_tour_itinerary($tour_id);
$included      = bbt_get_tour_included($tour_id);
$excluded      = bbt_get_tour_excluded($tour_id);
$highlights    = bbt_get_tour_highlights($tour_id);
$important_info = bbt_get_tour_important_info($tour_id);
$faq           = bbt_get_tour_faq($tour_id);

$group_size    = get_post_meta($tour_id, '_bbt_tour_group_size', true);
$meeting_point = get_post_meta($tour_id, '_bbt_tour_meeting_point', true);
$languages     = get_post_meta($tour_id, '_bbt_tour_languages', true);
$child_price   = get_post_meta($tour_id, '_bbt_tour_child_price', true);

// WhatsApp
$whatsapp = get_theme_mod('bbt_whatsapp_number', '6287854806011');

// Build gallery URLs array
$gallery_urls = array();
if (!empty($gallery_ids)) {
    foreach ($gallery_ids as $img_id) {
        $img_id = trim($img_id);
        if (is_numeric($img_id)) {
            $url = wp_get_attachment_image_url(intval($img_id), 'large');
            if ($url) $gallery_urls[] = $url;
        } elseif (is_string($img_id) && !empty($img_id)) {
            $gallery_urls[] = $img_id;
        }
    }
}

// Fallback hero image
$hero_img = has_post_thumbnail() ? get_the_post_thumbnail_url($tour_id, 'full') : 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=1200';

// If gallery is empty, use hero as first
if (empty($gallery_urls)) {
    $gallery_urls[] = $hero_img;
}

// Format price
$current_price = isset($price_data['current']) ? $price_data['current'] : 0;
$regular_price = isset($price_data['regular']) ? $price_data['regular'] : 0;
$sale_price_val = isset($price_data['sale']) ? $price_data['sale'] : null;

// Duration display
$duration_display = '';
if (is_array($duration_data) && isset($duration_data['display'])) {
    $duration_display = $duration_data['display'];
} elseif (is_string($duration_data)) {
    $duration_display = $duration_data;
}

// Rating
$avg_rating = is_array($rating_data) ? (isset($rating_data['average']) ? $rating_data['average'] : 4.8) : (is_numeric($rating_data) ? $rating_data : 4.8);
$review_count = is_array($rating_data) ? (isset($rating_data['count']) ? $rating_data['count'] : 0) : 0;

// Related tours
$related = bbt_get_related_tours($tour_id, 4);
?>

<div class="fv-tour-page">
<div class="fv-container" style="padding-top: 30px;">

    <!-- ========== GALLERY GRID ========== -->
    <div class="fv-gallery" id="fvGallery">
        <div class="fv-gallery-main">
            <img src="<?php echo esc_url($gallery_urls[0]); ?>" alt="<?php echo esc_attr($tour_title); ?>" id="fvMainImg">
        </div>
        <?php for ($gi = 1; $gi <= 4; $gi++) :
            $thumb_url = isset($gallery_urls[$gi]) ? $gallery_urls[$gi] : (isset($gallery_urls[0]) ? $gallery_urls[0] : $hero_img);
        ?>
        <div class="fv-gallery-thumb">
            <img src="<?php echo esc_url($thumb_url); ?>" alt="Gallery <?php echo $gi; ?>">
            <?php if ($gi === 4 && count($gallery_urls) > 5) : ?>
                <div class="fv-gallery-more">+<?php echo count($gallery_urls) - 5; ?> more</div>
            <?php endif; ?>
        </div>
        <?php endfor; ?>
    </div>

    <!-- ========== BREADCRUMB ========== -->
    <div class="fv-breadcrumb">
        <a href="<?php echo esc_url(home_url('/')); ?>">Home</a>
        <span>›</span>
        <a href="<?php echo esc_url(home_url('/tours')); ?>">Tours</a>
        <span>›</span>
        <span style="color:#111;"><?php echo esc_html($tour_title); ?></span>
    </div>

    <!-- ========== TOUR HEADER ========== -->
    <div class="fv-tour-header">
        <h1 class="fv-tour-title"><?php echo esc_html($tour_title); ?></h1>
        <div class="fv-tour-meta-row">
            <span class="fv-stars">
                <?php for ($s = 0; $s < 5; $s++) : ?>
                    <i class="fas fa-star"></i>
                <?php endfor; ?>
                <strong style="color:#111; margin-left:5px;"><?php echo number_format($avg_rating, 1); ?></strong>
            </span>
            <?php if ($review_count > 0) : ?>
                <span>(<?php echo $review_count; ?> reviews)</span>
            <?php endif; ?>

            <?php if (!empty($duration_display)) : ?>
                <div class="fv-meta-divider"></div>
                <span><i class="far fa-clock" style="margin-right:5px;"></i><?php echo esc_html($duration_display); ?></span>
            <?php endif; ?>

            <?php if (!empty($group_size)) : ?>
                <div class="fv-meta-divider"></div>
                <span><i class="fas fa-users" style="margin-right:5px;"></i>Max <?php echo esc_html($group_size); ?> People</span>
            <?php endif; ?>
        </div>
    </div>

    <!-- ========== TWO COLUMN LAYOUT ========== -->
    <div class="fv-tour-layout">

        <!-- LEFT: CONTENT COLUMN -->
        <div class="fv-tour-content">

            <!-- Quick Info Badges -->
            <div class="fv-quick-badges">
                <?php if (!empty($duration_display)) : ?>
                    <div class="fv-badge"><i class="far fa-clock"></i> <?php echo esc_html($duration_display); ?></div>
                <?php endif; ?>
                <?php if (!empty($group_size)) : ?>
                    <div class="fv-badge"><i class="fas fa-users"></i> <?php echo esc_html($group_size); ?> People</div>
                <?php endif; ?>
                <?php if (!empty($languages)) : ?>
                    <div class="fv-badge"><i class="fas fa-globe"></i> <?php echo esc_html($languages); ?></div>
                <?php endif; ?>
                <?php if (!empty($meeting_point)) : ?>
                    <div class="fv-badge"><i class="fas fa-map-marker-alt"></i> <?php echo esc_html($meeting_point); ?></div>
                <?php endif; ?>
            </div>

            <!-- Overview -->
            <div class="fv-section">
                <h2 class="fv-section-title">Overview</h2>
                <div class="fv-overview-text">
                    <?php echo $tour_desc; ?>
                </div>
            </div>

            <!-- Highlights -->
            <?php if (!empty($highlights)) : ?>
            <div class="fv-section">
                <h2 class="fv-section-title">Highlights</h2>
                <div class="fv-perks-grid">
                    <?php foreach ($highlights as $hl) :
                        $hl_text = is_array($hl) ? (isset($hl['text']) ? $hl['text'] : '') : $hl;
                        if (empty($hl_text)) continue;
                    ?>
                    <div class="fv-perk-card">
                        <div class="fv-perk-icon"><i class="fas fa-star"></i></div>
                        <span class="fv-perk-text"><?php echo esc_html($hl_text); ?></span>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>

            <!-- What's Included / Excluded -->
            <?php if (!empty($included) || !empty($excluded)) : ?>
            <div class="fv-section">
                <h2 class="fv-section-title">What's Included</h2>
                <div class="fv-perks-grid">
                    <?php foreach ($included as $inc_item) :
                        $inc_text = is_array($inc_item) ? (isset($inc_item['text']) ? $inc_item['text'] : '') : $inc_item;
                        if (empty($inc_text)) continue;
                    ?>
                    <div class="fv-perk-card">
                        <div class="fv-perk-icon"><i class="fas fa-check"></i></div>
                        <span class="fv-perk-text"><?php echo esc_html($inc_text); ?></span>
                    </div>
                    <?php endforeach; ?>
                </div>

                <?php if (!empty($excluded)) : ?>
                <h3 class="fv-section-title" style="margin-top:30px; font-size:18px; color:#e74c3c;">Not Included</h3>
                <div class="fv-perks-grid">
                    <?php foreach ($excluded as $exc_item) :
                        $exc_text = is_array($exc_item) ? (isset($exc_item['text']) ? $exc_item['text'] : '') : $exc_item;
                        if (empty($exc_text)) continue;
                    ?>
                    <div class="fv-perk-card" style="border-color: #fde8e8;">
                        <div class="fv-perk-icon" style="background:#fde8e8;"><i class="fas fa-times" style="color:#e74c3c;"></i></div>
                        <span class="fv-perk-text"><?php echo esc_html($exc_text); ?></span>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
            <?php endif; ?>

            <!-- Itinerary Timeline -->
            <?php if (!empty($itinerary)) : ?>
            <div class="fv-section">
                <h2 class="fv-section-title">Tour Itinerary</h2>
                <div class="fv-timeline">
                    <?php foreach ($itinerary as $idx => $it_item) :
                        $it_time  = isset($it_item['time']) ? $it_item['time'] : '';
                        $it_title = isset($it_item['title']) ? $it_item['title'] : '';
                        $it_desc  = isset($it_item['description']) ? $it_item['description'] : '';
                    ?>
                    <div class="fv-timeline-item">
                        <div class="fv-timeline-dot"></div>
                        <?php if (!empty($it_time)) : ?>
                            <div class="fv-timeline-time"><?php echo esc_html($it_time); ?></div>
                        <?php endif; ?>
                        <?php if (!empty($it_title)) : ?>
                            <h4 class="fv-timeline-title"><?php echo esc_html($it_title); ?></h4>
                        <?php endif; ?>
                        <?php if (!empty($it_desc)) : ?>
                            <p class="fv-timeline-desc"><?php echo esc_html($it_desc); ?></p>
                        <?php endif; ?>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>

            <!-- FAQ Section -->
            <?php if (!empty($faq)) : ?>
            <div class="fv-section">
                <h2 class="fv-section-title">Frequently Asked Questions</h2>
                <?php foreach ($faq as $faq_item) : ?>
                <div style="border-bottom:1px solid #f0f0f0; padding: 20px 0;">
                    <h4 style="font-size:16px; font-weight:700; color:#111; margin:0 0 8px 0; cursor:pointer;">
                        <i class="fas fa-chevron-right" style="font-size:12px; margin-right:10px; color:#16a085;"></i>
                        <?php echo esc_html($faq_item['question'] ?? ''); ?>
                    </h4>
                    <p style="font-size:14px; color:#666; line-height:1.7; margin:0; padding-left:25px;">
                        <?php echo esc_html($faq_item['answer'] ?? ''); ?>
                    </p>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <!-- Reviews Section -->
            <div class="fv-reviews">
                <h2 class="fv-section-title">Guest Reviews</h2>
                <div class="fv-reviews-summary">
                    <div class="fv-rating-big"><?php echo number_format($avg_rating, 1); ?></div>
                    <div>
                        <div class="fv-rating-stars-row">
                            <?php for ($s = 0; $s < 5; $s++) : ?>
                                <i class="fas fa-star"></i>
                            <?php endfor; ?>
                        </div>
                        <div class="fv-rating-count"><?php echo $review_count > 0 ? $review_count . ' reviews' : 'Excellent'; ?></div>
                    </div>
                </div>

                <?php
                // Try to fetch reviews from CPT
                $reviews_query = bbt_get_tour_reviews($tour_id, 5);
                if ($reviews_query->have_posts()) :
                    while ($reviews_query->have_posts()) : $reviews_query->the_post();
                ?>
                <div class="fv-review-card">
                    <div class="fv-review-avatar"><?php echo strtoupper(substr(get_the_title(), 0, 1)); ?></div>
                    <div>
                        <h4 class="fv-review-author"><?php the_title(); ?></h4>
                        <div class="fv-review-meta">
                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                            &bull; <?php echo get_the_date(); ?>
                        </div>
                        <div class="fv-review-text"><?php the_excerpt(); ?></div>
                    </div>
                </div>
                <?php endwhile; wp_reset_postdata();
                else :
                    // Static fallback reviews
                    $static_reviews = array(
                        array('name' => 'Sarah Johnson', 'date' => 'March 2025', 'text' => 'Amazing experience! Our guide was incredibly knowledgeable and friendly. The views were absolutely breathtaking. Highly recommend this tour to anyone visiting Bali!'),
                        array('name' => 'Michael Chen', 'date' => 'February 2025', 'text' => 'One of the best tours I have ever taken. Everything was well organized, from pickup to drop-off. The hidden gems we visited were out of this world.'),
                        array('name' => 'Emma Williams', 'date' => 'January 2025', 'text' => 'Wonderful tour with great attention to detail. The lunch was delicious and the driver was very professional. Will definitely book again!'),
                    );
                    foreach ($static_reviews as $sr) :
                ?>
                <div class="fv-review-card">
                    <div class="fv-review-avatar"><?php echo strtoupper(substr($sr['name'], 0, 1)); ?></div>
                    <div>
                        <h4 class="fv-review-author"><?php echo esc_html($sr['name']); ?></h4>
                        <div class="fv-review-meta">
                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                            &bull; <?php echo esc_html($sr['date']); ?>
                        </div>
                        <div class="fv-review-text"><?php echo esc_html($sr['text']); ?></div>
                    </div>
                </div>
                <?php endforeach; endif; ?>
            </div>

        </div>
        <!-- END LEFT COLUMN -->

        <!-- RIGHT: STICKY BOOKING SIDEBAR -->
        <aside class="fv-sidebar">
            <div class="fv-booking-box">
                <div class="fv-booking-price">
                    <div class="fv-price-label">Starts from</div>
                    <div class="fv-price-amount">
                        <?php echo bbt_format_price($current_price); ?>
                        <small>/ person</small>
                        <?php if ($sale_price_val && $regular_price > $sale_price_val) : ?>
                            <span class="fv-price-original"><?php echo bbt_format_price($regular_price); ?></span>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="fv-booking-form">
                    <div class="fv-form-group">
                        <label class="fv-form-label">Select Date</label>
                        <input type="date" class="fv-form-input" min="<?php echo date('Y-m-d'); ?>">
                    </div>

                    <div class="fv-guests-row">
                        <div class="fv-guests-label">Adults <small>Ages 12+</small></div>
                        <div class="fv-qty-control">
                            <button class="fv-qty-btn" onclick="fvQty(this,-1)">−</button>
                            <span class="fv-qty-val">2</span>
                            <button class="fv-qty-btn" onclick="fvQty(this,1)">+</button>
                        </div>
                    </div>
                    <div class="fv-guests-row">
                        <div class="fv-guests-label">Children <small>Ages 5-11</small></div>
                        <div class="fv-qty-control">
                            <button class="fv-qty-btn" onclick="fvQty(this,-1)">−</button>
                            <span class="fv-qty-val">0</span>
                            <button class="fv-qty-btn" onclick="fvQty(this,1)">+</button>
                        </div>
                    </div>

                    <a href="https://wa.me/<?php echo esc_attr($whatsapp); ?>?text=<?php echo rawurlencode('Hi! I want to book: ' . $tour_title . ' - Price: ' . bbt_format_price($current_price)); ?>" class="fv-book-btn" target="_blank">
                        Book Now
                    </a>
                    <a href="https://wa.me/<?php echo esc_attr($whatsapp); ?>?text=<?php echo rawurlencode('Hi! I have a question about: ' . $tour_title); ?>" class="fv-wa-btn" target="_blank">
                        <i class="fab fa-whatsapp"></i> WhatsApp Us
                    </a>
                </div>
                <div class="fv-booking-guarantee">
                    <i class="fas fa-shield-alt"></i> Free cancellation up to 24 hours before
                </div>
            </div>

            <!-- Quick Info Sidebar -->
            <div class="fv-booking-box" style="padding:25px;">
                <h4 style="font-size:16px; font-weight:700; margin:0 0 18px 0;">Quick Info</h4>
                <?php if (!empty($duration_display)) : ?>
                <div style="display:flex; align-items:center; gap:10px; padding:10px 0; border-bottom:1px solid #f5f5f5; font-size:14px; color:#555;">
                    <i class="far fa-clock" style="color:#16a085; width:18px;"></i> Duration: <strong><?php echo esc_html($duration_display); ?></strong>
                </div>
                <?php endif; ?>
                <?php if (!empty($group_size)) : ?>
                <div style="display:flex; align-items:center; gap:10px; padding:10px 0; border-bottom:1px solid #f5f5f5; font-size:14px; color:#555;">
                    <i class="fas fa-users" style="color:#16a085; width:18px;"></i> Group Size: <strong>Max <?php echo esc_html($group_size); ?></strong>
                </div>
                <?php endif; ?>
                <?php if (!empty($languages)) : ?>
                <div style="display:flex; align-items:center; gap:10px; padding:10px 0; border-bottom:1px solid #f5f5f5; font-size:14px; color:#555;">
                    <i class="fas fa-globe" style="color:#16a085; width:18px;"></i> Language: <strong><?php echo esc_html($languages); ?></strong>
                </div>
                <?php endif; ?>
                <div style="display:flex; align-items:center; gap:10px; padding:10px 0; border-bottom:1px solid #f5f5f5; font-size:14px; color:#555;">
                    <i class="fas fa-check-circle" style="color:#16a085; width:18px;"></i> <strong>Instant Confirmation</strong>
                </div>
                <div style="display:flex; align-items:center; gap:10px; padding:10px 0; font-size:14px; color:#555;">
                    <i class="fas fa-mobile-alt" style="color:#16a085; width:18px;"></i> <strong>Mobile Voucher</strong>
                </div>
            </div>
        </aside>

    </div>
    <!-- END TWO COLUMN LAYOUT -->

</div>
<!-- END CONTAINER -->

<!-- ========== WHY WE'RE DIFFERENT BANNER ========== -->
<div class="fv-container" style="padding-bottom: 0;">
    <div class="fv-why-us">
        <div class="fv-why-text">
            <h2>Why We're Different</h2>
            <p>We are a local, family-owned tour company born and raised in Bali. Every tour is led by certified Balinese guides who share real stories from the heart of the island. No tourist traps — only authentic, unforgettable experiences.</p>
            <a href="<?php echo esc_url(home_url('/about')); ?>" class="fv-explore-btn">Explore Our Story</a>
            <div class="fv-why-badges">
                <div class="fv-why-badge" title="TripAdvisor"><i class="fab fa-tripadvisor" style="font-size:28px; color:#00af87;"></i></div>
                <div class="fv-why-badge" title="Google Reviews"><i class="fab fa-google" style="font-size:28px; color:#4285f4;"></i></div>
                <div class="fv-why-badge" title="Certified"><i class="fas fa-award" style="font-size:28px; color:#eab308;"></i></div>
                <div class="fv-why-badge" title="Eco-Friendly"><i class="fas fa-leaf" style="font-size:28px; color:#22c55e;"></i></div>
            </div>
        </div>
    </div>
</div>

<!-- ========== RELATED TOURS ========== -->
<?php if ($related->have_posts()) : ?>
<div class="fv-container">
    <div class="fv-related">
        <h2 class="fv-related-title">You Might Also Like</h2>
        <div class="fv-related-grid">
            <?php while ($related->have_posts()) : $related->the_post();
                $rel_price = bbt_get_tour_price(get_the_ID());
                $rel_dur   = bbt_get_tour_duration(get_the_ID());
                $rel_img   = bbt_get_tour_fallback_image(get_the_ID(), 'medium');
            ?>
            <a href="<?php the_permalink(); ?>" class="fv-related-card">
                <img src="<?php echo esc_url($rel_img); ?>" alt="<?php the_title_attribute(); ?>">
                <div class="fv-related-info">
                    <h4><?php the_title(); ?></h4>
                    <span class="fv-rel-price"><?php echo bbt_format_price($rel_price['current']); ?></span>
                    <?php if (is_array($rel_dur) && !empty($rel_dur['display'])) : ?>
                        <span class="fv-rel-duration"> · <?php echo esc_html($rel_dur['display']); ?></span>
                    <?php endif; ?>
                </div>
            </a>
            <?php endwhile; wp_reset_postdata(); ?>
        </div>
    </div>
</div>
<?php endif; ?>

</div>
<!-- END .fv-tour-page -->

<script>
function fvQty(btn, delta) {
    const val = btn.parentElement.querySelector('.fv-qty-val');
    let n = parseInt(val.textContent) + delta;
    if (n < 0) n = 0;
    if (n > 20) n = 20;
    val.textContent = n;
}
</script>

<?php endwhile; ?>

<?php get_footer(); ?>
