<?php
/**
 * Template Name: Honeymoon Packages
 * 
 * Romantic Honeymoon packages page with elegant design
 *
 * @package BestBaliTravel
 */

get_header();
?>

<main id="main" class="site-main page-honeymoon">

    <!-- Hero Section -->
    <section class="honeymoon-hero">
        <div class="honeymoon-hero-overlay"></div>
        <div class="honeymoon-particles">
            <span>💕</span><span>✨</span><span>💖</span><span>🌹</span><span>💕</span>
        </div>
        <div class="bbt-container">
            <div class="honeymoon-hero-content">
                <span class="hero-badge" x-data="scrollReveal()" :class="{ 'visible': visible }">
                    💕
                    <?php esc_html_e('For Couples', 'bestbalitravel'); ?>
                </span>
                <h1 x-data="scrollReveal(100)" :class="{ 'visible': visible }">
                    <?php esc_html_e('Romantic Honeymoon', 'bestbalitravel'); ?>
                </h1>
                <p x-data="scrollReveal(200)" :class="{ 'visible': visible }">
                    <?php esc_html_e('Create unforgettable memories with your loved one in paradise', 'bestbalitravel'); ?>
                </p>
                <a href="#packages" class="hero-cta" x-data="scrollReveal(300)" :class="{ 'visible': visible }">
                    <?php esc_html_e('View Packages', 'bestbalitravel'); ?> ❤️
                </a>
            </div>
        </div>
    </section>

    <!-- Honeymoon Features -->
    <section class="honeymoon-features">
        <div class="bbt-container">
            <div class="features-grid">
                <div class="feature-item" x-data="scrollReveal()" :class="{ 'visible': visible }">
                    <span class="feature-icon">🌅</span>
                    <h3>
                        <?php esc_html_e('Sunset Dinners', 'bestbalitravel'); ?>
                    </h3>
                    <p>
                        <?php esc_html_e('Romantic beachfront dining', 'bestbalitravel'); ?>
                    </p>
                </div>
                <div class="feature-item" x-data="scrollReveal(100)" :class="{ 'visible': visible }">
                    <span class="feature-icon">💆</span>
                    <h3>
                        <?php esc_html_e('Couple Spa', 'bestbalitravel'); ?>
                    </h3>
                    <p>
                        <?php esc_html_e('Relaxing treatments for two', 'bestbalitravel'); ?>
                    </p>
                </div>
                <div class="feature-item" x-data="scrollReveal(200)" :class="{ 'visible': visible }">
                    <span class="feature-icon">🏨</span>
                    <h3>
                        <?php esc_html_e('Luxury Villas', 'bestbalitravel'); ?>
                    </h3>
                    <p>
                        <?php esc_html_e('Private pool villas', 'bestbalitravel'); ?>
                    </p>
                </div>
                <div class="feature-item" x-data="scrollReveal(300)" :class="{ 'visible': visible }">
                    <span class="feature-icon">📸</span>
                    <h3>
                        <?php esc_html_e('Photo Session', 'bestbalitravel'); ?>
                    </h3>
                    <p>
                        <?php esc_html_e('Professional photography', 'bestbalitravel'); ?>
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Honeymoon Packages -->
    <section class="honeymoon-packages" id="packages">
        <div class="bbt-container">
            <div class="section-header">
                <h2>
                    <?php esc_html_e('Honeymoon Packages', 'bestbalitravel'); ?>
                </h2>
                <p>
                    <?php esc_html_e('Curated experiences for couples', 'bestbalitravel'); ?>
                </p>
            </div>

            <div class="packages-grid">
                <!-- Package 1 -->
                <div class="package-card" x-data="scrollReveal()" :class="{ 'visible': visible }">
                    <div class="package-badge">💎
                        <?php esc_html_e('Popular', 'bestbalitravel'); ?>
                    </div>
                    <div class="package-image">
                        <img src="<?php echo BBT_THEME_ASSETS; ?>/images/honeymoon-romantic.jpg" alt="Romantic Escape">
                    </div>
                    <div class="package-content">
                        <span class="package-duration">3 Days / 2 Nights</span>
                        <h3>
                            <?php esc_html_e('Romantic Escape', 'bestbalitravel'); ?>
                        </h3>
                        <ul class="package-includes">
                            <li>✓
                                <?php esc_html_e('Private Pool Villa', 'bestbalitravel'); ?>
                            </li>
                            <li>✓
                                <?php esc_html_e('Sunset Dinner', 'bestbalitravel'); ?>
                            </li>
                            <li>✓
                                <?php esc_html_e('Couple Spa 2hr', 'bestbalitravel'); ?>
                            </li>
                            <li>✓
                                <?php esc_html_e('Airport Transfer', 'bestbalitravel'); ?>
                            </li>
                        </ul>
                        <div class="package-footer">
                            <div class="package-price">
                                <span class="price-from">
                                    <?php esc_html_e('From', 'bestbalitravel'); ?>
                                </span>
                                <span class="price-amount">Rp 4.500.000</span>
                                <span class="price-per">/couple</span>
                            </div>
                            <a href="#" class="package-btn">
                                <?php esc_html_e('Book Now', 'bestbalitravel'); ?>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Package 2 -->
                <div class="package-card featured" x-data="scrollReveal(100)" :class="{ 'visible': visible }">
                    <div class="package-badge">👑
                        <?php esc_html_e('Best Value', 'bestbalitravel'); ?>
                    </div>
                    <div class="package-image">
                        <img src="<?php echo BBT_THEME_ASSETS; ?>/images/honeymoon-luxury.jpg" alt="Luxury Romance">
                    </div>
                    <div class="package-content">
                        <span class="package-duration">5 Days / 4 Nights</span>
                        <h3>
                            <?php esc_html_e('Luxury Romance', 'bestbalitravel'); ?>
                        </h3>
                        <ul class="package-includes">
                            <li>✓
                                <?php esc_html_e('5-Star Private Villa', 'bestbalitravel'); ?>
                            </li>
                            <li>✓
                                <?php esc_html_e('Floating Breakfast', 'bestbalitravel'); ?>
                            </li>
                            <li>✓
                                <?php esc_html_e('Romantic Dinner 2x', 'bestbalitravel'); ?>
                            </li>
                            <li>✓
                                <?php esc_html_e('Full Day Spa', 'bestbalitravel'); ?>
                            </li>
                            <li>✓
                                <?php esc_html_e('Photo Session', 'bestbalitravel'); ?>
                            </li>
                        </ul>
                        <div class="package-footer">
                            <div class="package-price">
                                <span class="price-from">
                                    <?php esc_html_e('From', 'bestbalitravel'); ?>
                                </span>
                                <span class="price-amount">Rp 12.500.000</span>
                                <span class="price-per">/couple</span>
                            </div>
                            <a href="#" class="package-btn">
                                <?php esc_html_e('Book Now', 'bestbalitravel'); ?>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Package 3 -->
                <div class="package-card" x-data="scrollReveal(200)" :class="{ 'visible': visible }">
                    <div class="package-badge">🌟
                        <?php esc_html_e('Premium', 'bestbalitravel'); ?>
                    </div>
                    <div class="package-image">
                        <img src="<?php echo BBT_THEME_ASSETS; ?>/images/honeymoon-ultimate.jpg" alt="Ultimate Bliss">
                    </div>
                    <div class="package-content">
                        <span class="package-duration">7 Days / 6 Nights</span>
                        <h3>
                            <?php esc_html_e('Ultimate Bliss', 'bestbalitravel'); ?>
                        </h3>
                        <ul class="package-includes">
                            <li>✓
                                <?php esc_html_e('Cliff-edge Villa', 'bestbalitravel'); ?>
                            </li>
                            <li>✓
                                <?php esc_html_e('Yacht Cruise', 'bestbalitravel'); ?>
                            </li>
                            <li>✓
                                <?php esc_html_e('All Meals Included', 'bestbalitravel'); ?>
                            </li>
                            <li>✓
                                <?php esc_html_e('Private Tour', 'bestbalitravel'); ?>
                            </li>
                            <li>✓
                                <?php esc_html_e('24/7 Butler Service', 'bestbalitravel'); ?>
                            </li>
                        </ul>
                        <div class="package-footer">
                            <div class="package-price">
                                <span class="price-from">
                                    <?php esc_html_e('From', 'bestbalitravel'); ?>
                                </span>
                                <span class="price-amount">Rp 25.000.000</span>
                                <span class="price-per">/couple</span>
                            </div>
                            <a href="#" class="package-btn">
                                <?php esc_html_e('Book Now', 'bestbalitravel'); ?>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="honeymoon-cta">
        <div class="bbt-container">
            <div class="cta-content" x-data="scrollReveal()" :class="{ 'visible': visible }">
                <h2>
                    <?php esc_html_e('Plan Your Dream Honeymoon', 'bestbalitravel'); ?>
                </h2>
                <p>
                    <?php esc_html_e('Let us customize the perfect romantic getaway for you', 'bestbalitravel'); ?>
                </p>
                <a href="https://wa.me/6287854806011?text=<?php echo urlencode('Hi! I want to plan my honeymoon in Bali.'); ?>"
                    class="cta-btn" target="_blank">
                    💬
                    <?php esc_html_e('Chat with Us', 'bestbalitravel'); ?>
                </a>
            </div>
        </div>
    </section>

</main>

<style>
    .honeymoon-hero {
        position: relative;
        min-height: 80vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #ec4899 0%, #f43f5e 50%, #f97316 100%);
        overflow: hidden;
    }

    .honeymoon-hero-overlay {
        position: absolute;
        inset: 0;
        background: url('<?php echo BBT_THEME_ASSETS; ?>/images/honeymoon-hero.jpg') center/cover;
        opacity: 0.3;
    }

    .honeymoon-particles {
        position: absolute;
        inset: 0;
        overflow: hidden;
        pointer-events: none;
    }

    .honeymoon-particles span {
        position: absolute;
        font-size: 20px;
        animation: floatParticle 15s infinite;
        opacity: 0.6;
    }

    .honeymoon-particles span:nth-child(1) {
        left: 10%;
        animation-delay: 0s;
    }

    .honeymoon-particles span:nth-child(2) {
        left: 25%;
        animation-delay: 3s;
    }

    .honeymoon-particles span:nth-child(3) {
        left: 50%;
        animation-delay: 6s;
    }

    .honeymoon-particles span:nth-child(4) {
        left: 75%;
        animation-delay: 9s;
    }

    .honeymoon-particles span:nth-child(5) {
        left: 90%;
        animation-delay: 12s;
    }

    @keyframes floatParticle {
        0% {
            transform: translateY(100vh) rotate(0deg);
            opacity: 0;
        }

        10% {
            opacity: 1;
        }

        90% {
            opacity: 1;
        }

        100% {
            transform: translateY(-100px) rotate(360deg);
            opacity: 0;
        }
    }

    .honeymoon-hero-content {
        position: relative;
        text-align: center;
        color: white;
        padding: 40px 20px;
    }

    .honeymoon-hero-content .hero-badge {
        display: inline-block;
        padding: 8px 24px;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        border-radius: 50px;
        font-size: 14px;
        margin-bottom: 20px;
        opacity: 0;
        transform: translateY(20px);
        transition: all 0.6s;
    }

    .honeymoon-hero-content .hero-badge.visible {
        opacity: 1;
        transform: translateY(0);
    }

    .honeymoon-hero-content h1 {
        font-family: 'Cormorant Garamond', serif;
        font-size: clamp(3rem, 8vw, 5rem);
        font-weight: 600;
        margin-bottom: 16px;
        text-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        opacity: 0;
        transform: translateY(30px);
        transition: all 0.8s;
    }

    .honeymoon-hero-content h1.visible {
        opacity: 1;
        transform: translateY(0);
    }

    .honeymoon-hero-content p {
        font-size: 1.25rem;
        opacity: 0.9;
        margin-bottom: 30px;
    }

    .hero-cta {
        display: inline-block;
        padding: 16px 40px;
        background: white;
        color: #ec4899;
        font-weight: 600;
        font-size: 1rem;
        text-decoration: none;
        border-radius: 50px;
        transition: all 0.3s;
        opacity: 0;
        transform: translateY(20px);
    }

    .hero-cta.visible {
        opacity: 1;
        transform: translateY(0);
    }

    .hero-cta:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    }

    .honeymoon-features {
        padding: 60px 0;
        background: white;
    }

    .features-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 30px;
    }

    .feature-item {
        text-align: center;
        padding: 30px 20px;
        border-radius: 20px;
        transition: all 0.3s;
        opacity: 0;
        transform: translateY(20px);
    }

    .feature-item.visible {
        opacity: 1;
        transform: translateY(0);
    }

    .feature-item:hover {
        background: linear-gradient(135deg, #fdf2f8, #fce7f3);
    }

    .feature-icon {
        font-size: 48px;
        display: block;
        margin-bottom: 16px;
    }

    .feature-item h3 {
        font-size: 18px;
        font-weight: 600;
        color: #111827;
        margin-bottom: 8px;
    }

    .feature-item p {
        font-size: 14px;
        color: #6b7280;
    }

    .honeymoon-packages {
        padding: 60px 0;
        background: linear-gradient(180deg, #fdf2f8 0%, #fff 100%);
    }

    .packages-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 30px;
        align-items: start;
    }

    .package-card {
        background: white;
        border-radius: 24px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        position: relative;
        opacity: 0;
        transform: translateY(30px);
        transition: all 0.6s;
    }

    .package-card.visible {
        opacity: 1;
        transform: translateY(0);
    }

    .package-card.featured {
        border: 2px solid #ec4899;
        transform: scale(1.02);
    }

    .package-card.featured.visible {
        transform: scale(1.02) translateY(0);
    }

    .package-badge {
        position: absolute;
        top: 16px;
        left: 16px;
        padding: 6px 14px;
        background: linear-gradient(135deg, #ec4899, #f43f5e);
        color: white;
        font-size: 12px;
        font-weight: 600;
        border-radius: 20px;
        z-index: 10;
    }

    .package-image {
        height: 200px;
        overflow: hidden;
    }

    .package-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s;
    }

    .package-card:hover .package-image img {
        transform: scale(1.1);
    }

    .package-content {
        padding: 24px;
    }

    .package-duration {
        display: inline-block;
        padding: 4px 12px;
        background: #fdf2f8;
        color: #ec4899;
        font-size: 12px;
        font-weight: 600;
        border-radius: 20px;
        margin-bottom: 12px;
    }

    .package-content h3 {
        font-family: 'Cormorant Garamond', serif;
        font-size: 24px;
        font-weight: 600;
        color: #111827;
        margin-bottom: 16px;
    }

    .package-includes {
        list-style: none;
        padding: 0;
        margin: 0 0 20px;
    }

    .package-includes li {
        padding: 6px 0;
        font-size: 14px;
        color: #374151;
        border-bottom: 1px solid #f9fafb;
    }

    .package-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding-top: 16px;
        border-top: 1px solid #f3f4f6;
    }

    .package-price .price-from {
        display: block;
        font-size: 11px;
        color: #9ca3af;
    }

    .package-price .price-amount {
        font-size: 20px;
        font-weight: 700;
        color: #ec4899;
    }

    .package-price .price-per {
        font-size: 12px;
        color: #6b7280;
    }

    .package-btn {
        padding: 12px 24px;
        background: linear-gradient(135deg, #ec4899, #f43f5e);
        color: white;
        text-decoration: none;
        font-weight: 600;
        font-size: 14px;
        border-radius: 10px;
        transition: all 0.3s;
    }

    .package-btn:hover {
        box-shadow: 0 8px 25px rgba(236, 72, 153, 0.4);
        transform: translateY(-2px);
    }

    .honeymoon-cta {
        padding: 80px 0;
        background: linear-gradient(135deg, #ec4899, #f43f5e);
    }

    .honeymoon-cta .cta-content {
        text-align: center;
        color: white;
        opacity: 0;
        transform: translateY(30px);
        transition: all 0.8s;
    }

    .honeymoon-cta .cta-content.visible {
        opacity: 1;
        transform: translateY(0);
    }

    .honeymoon-cta h2 {
        font-family: 'Cormorant Garamond', serif;
        font-size: 2.5rem;
        margin-bottom: 12px;
    }

    .honeymoon-cta p {
        font-size: 1.125rem;
        opacity: 0.9;
        margin-bottom: 30px;
    }

    .honeymoon-cta .cta-btn {
        display: inline-block;
        padding: 16px 40px;
        background: white;
        color: #ec4899;
        font-weight: 600;
        font-size: 1rem;
        text-decoration: none;
        border-radius: 50px;
        transition: all 0.3s;
    }

    .honeymoon-cta .cta-btn:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    }
</style>

<?php
get_footer();
