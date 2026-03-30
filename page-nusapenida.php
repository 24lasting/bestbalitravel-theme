<?php
/**
 * Template Name: Nusa Penida Tours
 * 
 * Nusa Penida island tours page with stunning ocean vibes
 *
 * @package BestBaliTravel
 */

get_header();
?>

<main id="main" class="site-main page-nusapenida">

    <!-- Hero Section -->
    <section class="nusapenida-hero">
        <div class="hero-video-bg">
            <video autoplay muted loop playsinline>
                <source src="<?php echo BBT_THEME_ASSETS; ?>/videos/nusapenida-ocean.mp4" type="video/mp4">
            </video>
        </div>
        <div class="hero-overlay"></div>
        <div class="bbt-container">
            <div class="hero-content">
                <span class="hero-badge" x-data="scrollReveal()" :class="{ 'visible': visible }">
                    🏝️
                    <?php esc_html_e('Island Paradise', 'bestbalitravel'); ?>
                </span>
                <h1 x-data="scrollReveal(100)" :class="{ 'visible': visible }">
                    <?php esc_html_e('Nusa Penida', 'bestbalitravel'); ?>
                </h1>
                <p x-data="scrollReveal(200)" :class="{ 'visible': visible }">
                    <?php esc_html_e('Discover the most Instagrammable island in Bali', 'bestbalitravel'); ?>
                </p>
                <a href="#tours" class="hero-cta" x-data="scrollReveal(300)" :class="{ 'visible': visible }">
                    <?php esc_html_e('Explore Tours', 'bestbalitravel'); ?> 🌊
                </a>
            </div>
        </div>

        <!-- Animated Wave -->
        <div class="hero-wave">
            <svg viewBox="0 0 1440 120" preserveAspectRatio="none">
                <path fill="#ffffff"
                    d="M0,64L48,69.3C96,75,192,85,288,80C384,75,480,53,576,48C672,43,768,53,864,69.3C960,85,1056,107,1152,101.3C1248,96,1344,64,1392,48L1440,32L1440,120L0,120Z" />
            </svg>
        </div>
    </section>

    <!-- Highlights -->
    <section class="highlights-section">
        <div class="bbt-container">
            <div class="highlights-grid">
                <div class="highlight-item" x-data="scrollReveal()" :class="{ 'visible': visible }">
                    <img src="<?php echo BBT_THEME_ASSETS; ?>/images/kelingking-beach.jpg" alt="Kelingking Beach">
                    <div class="highlight-content">
                        <h3>
                            <?php esc_html_e('Kelingking Beach', 'bestbalitravel'); ?>
                        </h3>
                        <p>
                            <?php esc_html_e('T-Rex shaped cliff', 'bestbalitravel'); ?>
                        </p>
                    </div>
                </div>
                <div class="highlight-item" x-data="scrollReveal(100)" :class="{ 'visible': visible }">
                    <img src="<?php echo BBT_THEME_ASSETS; ?>/images/broken-beach.jpg" alt="Broken Beach">
                    <div class="highlight-content">
                        <h3>
                            <?php esc_html_e('Broken Beach', 'bestbalitravel'); ?>
                        </h3>
                        <p>
                            <?php esc_html_e('Natural rock archway', 'bestbalitravel'); ?>
                        </p>
                    </div>
                </div>
                <div class="highlight-item" x-data="scrollReveal(200)" :class="{ 'visible': visible }">
                    <img src="<?php echo BBT_THEME_ASSETS; ?>/images/angel-billabong.jpg" alt="Angel Billabong">
                    <div class="highlight-content">
                        <h3>
                            <?php esc_html_e("Angel's Billabong", 'bestbalitravel'); ?>
                        </h3>
                        <p>
                            <?php esc_html_e('Natural infinity pool', 'bestbalitravel'); ?>
                        </p>
                    </div>
                </div>
                <div class="highlight-item" x-data="scrollReveal(300)" :class="{ 'visible': visible }">
                    <img src="<?php echo BBT_THEME_ASSETS; ?>/images/manta-point.jpg" alt="Manta Point">
                    <div class="highlight-content">
                        <h3>
                            <?php esc_html_e('Manta Point', 'bestbalitravel'); ?>
                        </h3>
                        <p>
                            <?php esc_html_e('Swim with manta rays', 'bestbalitravel'); ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Tour Packages -->
    <section class="tours-section" id="tours">
        <div class="bbt-container">
            <div class="section-header">
                <h2>
                    <?php esc_html_e('Nusa Penida Tour Packages', 'bestbalitravel'); ?>
                </h2>
                <p>
                    <?php esc_html_e('Choose your perfect island adventure', 'bestbalitravel'); ?>
                </p>
            </div>

            <div class="tour-packages-grid">
                <!-- West Tour -->
                <div class="tour-package" x-data="tourCard(1)"
                    x-init="setTimeout(() => $el.classList.add('visible'), 0)">
                    <div class="package-image">
                        <img src="<?php echo BBT_THEME_ASSETS; ?>/images/nusapenida-west.jpg" alt="West Tour">
                        <div class="package-tag">
                            <?php esc_html_e('Most Popular', 'bestbalitravel'); ?>
                        </div>
                        <button class="wishlist-btn" :class="{ 'active': isWishlisted }" @click="toggleWishlist()">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                :fill="isWishlisted ? 'currentColor' : 'none'">
                                <path
                                    d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z">
                                </path>
                            </svg>
                        </button>
                    </div>
                    <div class="package-content">
                        <h3>
                            <?php esc_html_e('West Nusa Penida Tour', 'bestbalitravel'); ?>
                        </h3>
                        <div class="package-highlights">
                            <span>🦕 Kelingking Beach</span>
                            <span>🏊 Broken Beach</span>
                            <span>🌊 Angel Billabong</span>
                            <span>🏖️ Crystal Bay</span>
                        </div>
                        <div class="package-meta">
                            <span>⏱️ 10-12 hours</span>
                            <span>⭐ 4.9 (2.5k reviews)</span>
                        </div>
                        <div class="package-footer">
                            <div class="package-price">
                                <span class="label">
                                    <?php esc_html_e('From', 'bestbalitravel'); ?>
                                </span>
                                <span class="amount">Rp 450.000</span>
                                <span class="per">/person</span>
                            </div>
                            <a href="#" class="book-btn">
                                <?php esc_html_e('Book Now', 'bestbalitravel'); ?>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- East Tour -->
                <div class="tour-package" x-data="tourCard(2)"
                    x-init="setTimeout(() => $el.classList.add('visible'), 100)">
                    <div class="package-image">
                        <img src="<?php echo BBT_THEME_ASSETS; ?>/images/nusapenida-east.jpg" alt="East Tour">
                        <button class="wishlist-btn" :class="{ 'active': isWishlisted }" @click="toggleWishlist()">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                :fill="isWishlisted ? 'currentColor' : 'none'">
                                <path
                                    d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z">
                                </path>
                            </svg>
                        </button>
                    </div>
                    <div class="package-content">
                        <h3>
                            <?php esc_html_e('East Nusa Penida Tour', 'bestbalitravel'); ?>
                        </h3>
                        <div class="package-highlights">
                            <span>🌳 Treehouse</span>
                            <span>🌉 Diamond Beach</span>
                            <span>🌿 Atuh Beach</span>
                            <span>🛕 Goa Giri Putri</span>
                        </div>
                        <div class="package-meta">
                            <span>⏱️ 10-12 hours</span>
                            <span>⭐ 4.8 (1.8k reviews)</span>
                        </div>
                        <div class="package-footer">
                            <div class="package-price">
                                <span class="label">
                                    <?php esc_html_e('From', 'bestbalitravel'); ?>
                                </span>
                                <span class="amount">Rp 450.000</span>
                                <span class="per">/person</span>
                            </div>
                            <a href="#" class="book-btn">
                                <?php esc_html_e('Book Now', 'bestbalitravel'); ?>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Snorkeling Tour -->
                <div class="tour-package" x-data="tourCard(3)"
                    x-init="setTimeout(() => $el.classList.add('visible'), 200)">
                    <div class="package-image">
                        <img src="<?php echo BBT_THEME_ASSETS; ?>/images/nusapenida-snorkel.jpg" alt="Snorkeling Tour">
                        <div class="package-tag adventure">
                            <?php esc_html_e('Adventure', 'bestbalitravel'); ?>
                        </div>
                        <button class="wishlist-btn" :class="{ 'active': isWishlisted }" @click="toggleWishlist()">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                :fill="isWishlisted ? 'currentColor' : 'none'">
                                <path
                                    d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z">
                                </path>
                            </svg>
                        </button>
                    </div>
                    <div class="package-content">
                        <h3>
                            <?php esc_html_e('Snorkeling with Mantas', 'bestbalitravel'); ?>
                        </h3>
                        <div class="package-highlights">
                            <span>🐠 Manta Point</span>
                            <span>🐢 Crystal Bay</span>
                            <span>🦑 Gamat Bay</span>
                            <span>🤿 3 Spots</span>
                        </div>
                        <div class="package-meta">
                            <span>⏱️ 8-10 hours</span>
                            <span>⭐ 4.9 (980 reviews)</span>
                        </div>
                        <div class="package-footer">
                            <div class="package-price">
                                <span class="label">
                                    <?php esc_html_e('From', 'bestbalitravel'); ?>
                                </span>
                                <span class="amount">Rp 550.000</span>
                                <span class="per">/person</span>
                            </div>
                            <a href="#" class="book-btn">
                                <?php esc_html_e('Book Now', 'bestbalitravel'); ?>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Combo Tour -->
                <div class="tour-package" x-data="tourCard(4)"
                    x-init="setTimeout(() => $el.classList.add('visible'), 300)">
                    <div class="package-image">
                        <img src="<?php echo BBT_THEME_ASSETS; ?>/images/nusapenida-combo.jpg" alt="Combo Tour">
                        <div class="package-tag premium">
                            <?php esc_html_e('Best Value', 'bestbalitravel'); ?>
                        </div>
                        <button class="wishlist-btn" :class="{ 'active': isWishlisted }" @click="toggleWishlist()">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                :fill="isWishlisted ? 'currentColor' : 'none'">
                                <path
                                    d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z">
                                </path>
                            </svg>
                        </button>
                    </div>
                    <div class="package-content">
                        <h3>
                            <?php esc_html_e('2D1N Nusa Penida Combo', 'bestbalitravel'); ?>
                        </h3>
                        <div class="package-highlights">
                            <span>🏨 Overnight Stay</span>
                            <span>🌅 Sunrise</span>
                            <span>📸 All Spots</span>
                            <span>🤿 Snorkeling</span>
                        </div>
                        <div class="package-meta">
                            <span>⏱️ 2 Days</span>
                            <span>⭐ 5.0 (450 reviews)</span>
                        </div>
                        <div class="package-footer">
                            <div class="package-price">
                                <span class="label">
                                    <?php esc_html_e('From', 'bestbalitravel'); ?>
                                </span>
                                <span class="amount">Rp 1.800.000</span>
                                <span class="per">/person</span>
                            </div>
                            <a href="#" class="book-btn">
                                <?php esc_html_e('Book Now', 'bestbalitravel'); ?>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Inclusions -->
    <section class="inclusions-section">
        <div class="bbt-container">
            <div class="section-header">
                <h2>
                    <?php esc_html_e('What\'s Included', 'bestbalitravel'); ?>
                </h2>
            </div>
            <div class="inclusions-grid">
                <div class="inclusion-item">
                    <span>🚤</span>
                    <p>
                        <?php esc_html_e('Fast Boat Transfer', 'bestbalitravel'); ?>
                    </p>
                </div>
                <div class="inclusion-item">
                    <span>🚗</span>
                    <p>
                        <?php esc_html_e('Hotel Pickup', 'bestbalitravel'); ?>
                    </p>
                </div>
                <div class="inclusion-item">
                    <span>🍱</span>
                    <p>
                        <?php esc_html_e('Lunch', 'bestbalitravel'); ?>
                    </p>
                </div>
                <div class="inclusion-item">
                    <span>🎫</span>
                    <p>
                        <?php esc_html_e('Entrance Fees', 'bestbalitravel'); ?>
                    </p>
                </div>
                <div class="inclusion-item">
                    <span>👨‍✈️</span>
                    <p>
                        <?php esc_html_e('Local Guide', 'bestbalitravel'); ?>
                    </p>
                </div>
                <div class="inclusion-item">
                    <span>🤿</span>
                    <p>
                        <?php esc_html_e('Snorkel Gear', 'bestbalitravel'); ?>
                    </p>
                </div>
            </div>
        </div>
    </section>

</main>

<style>
    .nusapenida-hero {
        position: relative;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }

    .hero-video-bg {
        position: absolute;
        inset: 0;
    }

    .hero-video-bg video {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .hero-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(180deg, rgba(0, 0, 0, 0.3) 0%, rgba(6, 182, 212, 0.4) 100%);
    }

    .nusapenida-hero .hero-content {
        position: relative;
        text-align: center;
        color: white;
        z-index: 10;
    }

    .nusapenida-hero .hero-badge {
        display: inline-block;
        padding: 10px 24px;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        border-radius: 50px;
        font-size: 14px;
        margin-bottom: 20px;
        opacity: 0;
        transform: translateY(20px);
        transition: all 0.6s;
    }

    .nusapenida-hero .hero-badge.visible {
        opacity: 1;
        transform: translateY(0);
    }

    .nusapenida-hero h1 {
        font-family: 'Cormorant Garamond', serif;
        font-size: clamp(4rem, 12vw, 8rem);
        font-weight: 600;
        margin-bottom: 16px;
        text-shadow: 0 4px 30px rgba(0, 0, 0, 0.3);
        opacity: 0;
        transform: translateY(40px);
        transition: all 1s;
    }

    .nusapenida-hero h1.visible {
        opacity: 1;
        transform: translateY(0);
    }

    .nusapenida-hero p {
        font-size: 1.25rem;
        opacity: 0.9;
        margin-bottom: 30px;
    }

    .nusapenida-hero .hero-cta {
        display: inline-block;
        padding: 16px 40px;
        background: white;
        color: #06b6d4;
        font-weight: 600;
        font-size: 1rem;
        text-decoration: none;
        border-radius: 50px;
        transition: all 0.3s;
        opacity: 0;
        transform: translateY(20px);
    }

    .nusapenida-hero .hero-cta.visible {
        opacity: 1;
        transform: translateY(0);
    }

    .nusapenida-hero .hero-cta:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    }

    .hero-wave {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        line-height: 0;
    }

    .hero-wave svg {
        width: 100%;
        height: 80px;
    }

    .highlights-section {
        padding: 60px 0;
        background: white;
    }

    .highlights-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
    }

    .highlight-item {
        position: relative;
        border-radius: 20px;
        overflow: hidden;
        aspect-ratio: 3/4;
        opacity: 0;
        transform: translateY(30px);
        transition: all 0.6s;
    }

    .highlight-item.visible {
        opacity: 1;
        transform: translateY(0);
    }

    .highlight-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s;
    }

    .highlight-item:hover img {
        transform: scale(1.1);
    }

    .highlight-content {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        padding: 20px;
        background: linear-gradient(to top, rgba(0, 0, 0, 0.8), transparent);
        color: white;
    }

    .highlight-content h3 {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 4px;
    }

    .highlight-content p {
        font-size: 14px;
        opacity: 0.8;
    }

    .tours-section {
        padding: 60px 0;
        background: linear-gradient(180deg, #f0fdfa, #fff);
    }

    .tour-packages-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 24px;
    }

    .tour-package {
        background: white;
        border-radius: 24px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        opacity: 0;
        transform: translateY(30px);
        transition: all 0.5s;
    }

    .tour-package.visible {
        opacity: 1;
        transform: translateY(0);
    }

    .tour-package:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
    }

    .package-image {
        position: relative;
        height: 200px;
        overflow: hidden;
    }

    .package-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s;
    }

    .tour-package:hover .package-image img {
        transform: scale(1.1);
    }

    .package-tag {
        position: absolute;
        top: 12px;
        left: 12px;
        padding: 6px 14px;
        background: #06b6d4;
        color: white;
        font-size: 12px;
        font-weight: 600;
        border-radius: 20px;
    }

    .package-tag.adventure {
        background: #f97316;
    }

    .package-tag.premium {
        background: linear-gradient(135deg, #fbbf24, #f59e0b);
    }

    .tour-package .wishlist-btn {
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
        color: #6b7280;
        transition: all 0.3s;
    }

    .tour-package .wishlist-btn:hover,
    .tour-package .wishlist-btn.active {
        color: #ef4444;
        background: white;
    }

    .tour-package .wishlist-btn svg {
        width: 18px;
        height: 18px;
    }

    .package-content {
        padding: 20px;
    }

    .package-content h3 {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 18px;
        font-weight: 600;
        color: #111827;
        margin-bottom: 12px;
    }

    .package-highlights {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-bottom: 12px;
    }

    .package-highlights span {
        padding: 4px 10px;
        background: #f0fdfa;
        color: #0d9488;
        font-size: 12px;
        border-radius: 20px;
    }

    .package-meta {
        display: flex;
        gap: 16px;
        margin-bottom: 16px;
        font-size: 13px;
        color: #6b7280;
    }

    .package-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding-top: 16px;
        border-top: 1px solid #f3f4f6;
    }

    .package-price .label {
        display: block;
        font-size: 11px;
        color: #9ca3af;
    }

    .package-price .amount {
        font-size: 20px;
        font-weight: 700;
        color: #06b6d4;
    }

    .package-price .per {
        font-size: 12px;
        color: #6b7280;
    }

    .tour-package .book-btn {
        padding: 12px 24px;
        background: linear-gradient(135deg, #06b6d4, #0891b2);
        color: white;
        text-decoration: none;
        font-weight: 600;
        font-size: 14px;
        border-radius: 10px;
        transition: all 0.3s;
    }

    .tour-package .book-btn:hover {
        box-shadow: 0 8px 25px rgba(6, 182, 212, 0.4);
        transform: translateY(-2px);
    }

    .inclusions-section {
        padding: 60px 0;
        background: #06b6d4;
        color: white;
    }

    .inclusions-section .section-header h2 {
        color: white;
    }

    .inclusions-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
        gap: 20px;
        margin-top: 30px;
    }

    .inclusion-item {
        text-align: center;
        padding: 20px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 16px;
        transition: all 0.3s;
    }

    .inclusion-item:hover {
        background: rgba(255, 255, 255, 0.2);
    }

    .inclusion-item span {
        font-size: 36px;
        display: block;
        margin-bottom: 10px;
    }

    .inclusion-item p {
        font-size: 14px;
        opacity: 0.9;
    }
</style>

<?php
get_footer();
