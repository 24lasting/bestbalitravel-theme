<?php
/**
 * Template Name: Airport Transfer
 * 
 * Airport Transfer booking page with vehicle options
 *
 * @package BestBaliTravel
 */

get_header();
?>

<main id="main" class="site-main page-airport-transfer">

    <!-- Hero Section -->
    <section class="transfer-hero">
        <div class="bbt-container">
            <div class="transfer-hero-content">
                <span class="hero-badge" x-data="scrollReveal()" :class="{ 'visible': visible }">
                    ✈️
                    <?php esc_html_e('24/7 Service', 'bestbalitravel'); ?>
                </span>
                <h1 x-data="scrollReveal(100)" :class="{ 'visible': visible }">
                    <?php esc_html_e('Airport Transfer', 'bestbalitravel'); ?>
                </h1>
                <p x-data="scrollReveal(200)" :class="{ 'visible': visible }">
                    <?php esc_html_e('Comfortable and reliable airport pickup & drop-off service', 'bestbalitravel'); ?>
                </p>
            </div>
        </div>
    </section>

    <!-- Quick Booking Form -->
    <section class="booking-section">
        <div class="bbt-container">
            <div class="booking-card" x-data="{ tripType: 'arrival', passengers: 2 }">
                <h2>
                    <?php esc_html_e('Book Your Transfer', 'bestbalitravel'); ?>
                </h2>

                <div class="trip-type-toggle">
                    <button type="button" :class="{ 'active': tripType === 'arrival' }" @click="tripType = 'arrival'">
                        🛬
                        <?php esc_html_e('Arrival', 'bestbalitravel'); ?>
                    </button>
                    <button type="button" :class="{ 'active': tripType === 'departure' }"
                        @click="tripType = 'departure'">
                        🛫
                        <?php esc_html_e('Departure', 'bestbalitravel'); ?>
                    </button>
                    <button type="button" :class="{ 'active': tripType === 'roundtrip' }"
                        @click="tripType = 'roundtrip'">
                        🔄
                        <?php esc_html_e('Round Trip', 'bestbalitravel'); ?>
                    </button>
                </div>

                <form class="booking-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label>📍
                                <?php esc_html_e('Destination', 'bestbalitravel'); ?>
                            </label>
                            <select name="destination">
                                <option value="">
                                    <?php esc_html_e('Select area', 'bestbalitravel'); ?>
                                </option>
                                <option value="kuta">Kuta / Legian / Seminyak</option>
                                <option value="sanur">Sanur</option>
                                <option value="nusa-dua">Nusa Dua / Jimbaran</option>
                                <option value="ubud">Ubud</option>
                                <option value="canggu">Canggu</option>
                                <option value="uluwatu">Uluwatu</option>
                                <option value="lovina">Lovina / North Bali</option>
                                <option value="amed">Amed</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>📅
                                <?php esc_html_e('Date', 'bestbalitravel'); ?>
                            </label>
                            <input type="date" name="date" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>⏰
                                <?php esc_html_e('Pickup Time', 'bestbalitravel'); ?>
                            </label>
                            <input type="time" name="time" required>
                        </div>
                        <div class="form-group">
                            <label>👥
                                <?php esc_html_e('Passengers', 'bestbalitravel'); ?>
                            </label>
                            <div class="passenger-counter">
                                <button type="button" @click="passengers = Math.max(1, passengers - 1)">-</button>
                                <span x-text="passengers"></span>
                                <button type="button" @click="passengers = Math.min(15, passengers + 1)">+</button>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>✈️
                            <?php esc_html_e('Flight Number (Optional)', 'bestbalitravel'); ?>
                        </label>
                        <input type="text" name="flight" placeholder="e.g. GA 123">
                    </div>

                    <button type="submit" class="submit-btn">
                        <?php esc_html_e('Check Availability', 'bestbalitravel'); ?> →
                    </button>
                </form>
            </div>
        </div>
    </section>

    <!-- Vehicle Options -->
    <section class="vehicles-section">
        <div class="bbt-container">
            <div class="section-header">
                <h2>
                    <?php esc_html_e('Our Vehicles', 'bestbalitravel'); ?>
                </h2>
                <p>
                    <?php esc_html_e('Choose the perfect vehicle for your transfer', 'bestbalitravel'); ?>
                </p>
            </div>

            <div class="vehicles-grid">
                <div class="vehicle-card" x-data="scrollReveal()" :class="{ 'visible': visible }">
                    <div class="vehicle-icon">🚗</div>
                    <h3>
                        <?php esc_html_e('Economy Car', 'bestbalitravel'); ?>
                    </h3>
                    <ul class="vehicle-specs">
                        <li>👥 1-3 passengers</li>
                        <li>🧳 2 suitcases</li>
                        <li>❄️ Air conditioned</li>
                    </ul>
                    <div class="vehicle-price">
                        <span class="price-from">
                            <?php esc_html_e('From', 'bestbalitravel'); ?>
                        </span>
                        <span class="price-amount">Rp 150.000</span>
                    </div>
                </div>

                <div class="vehicle-card popular" x-data="scrollReveal(100)" :class="{ 'visible': visible }">
                    <span class="popular-badge">
                        <?php esc_html_e('Most Popular', 'bestbalitravel'); ?>
                    </span>
                    <div class="vehicle-icon">🚐</div>
                    <h3>
                        <?php esc_html_e('Standard MPV', 'bestbalitravel'); ?>
                    </h3>
                    <ul class="vehicle-specs">
                        <li>👥 4-6 passengers</li>
                        <li>🧳 4 suitcases</li>
                        <li>❄️ Air conditioned</li>
                        <li>💧 Mineral water</li>
                    </ul>
                    <div class="vehicle-price">
                        <span class="price-from">
                            <?php esc_html_e('From', 'bestbalitravel'); ?>
                        </span>
                        <span class="price-amount">Rp 200.000</span>
                    </div>
                </div>

                <div class="vehicle-card" x-data="scrollReveal(200)" :class="{ 'visible': visible }">
                    <div class="vehicle-icon">🚌</div>
                    <h3>
                        <?php esc_html_e('Premium Van', 'bestbalitravel'); ?>
                    </h3>
                    <ul class="vehicle-specs">
                        <li>👥 7-12 passengers</li>
                        <li>🧳 8 suitcases</li>
                        <li>❄️ Air conditioned</li>
                        <li>💧 Mineral water</li>
                        <li>📺 Entertainment</li>
                    </ul>
                    <div class="vehicle-price">
                        <span class="price-from">
                            <?php esc_html_e('From', 'bestbalitravel'); ?>
                        </span>
                        <span class="price-amount">Rp 350.000</span>
                    </div>
                </div>

                <div class="vehicle-card" x-data="scrollReveal(300)" :class="{ 'visible': visible }">
                    <div class="vehicle-icon">🚙</div>
                    <h3>
                        <?php esc_html_e('VIP SUV', 'bestbalitravel'); ?>
                    </h3>
                    <ul class="vehicle-specs">
                        <li>👥 1-4 passengers</li>
                        <li>🧳 4 suitcases</li>
                        <li>❄️ Premium AC</li>
                        <li>💧 Refreshments</li>
                        <li>📶 WiFi</li>
                    </ul>
                    <div class="vehicle-price">
                        <span class="price-from">
                            <?php esc_html_e('From', 'bestbalitravel'); ?>
                        </span>
                        <span class="price-amount">Rp 500.000</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Choose Us -->
    <section class="why-section">
        <div class="bbt-container">
            <div class="why-grid">
                <div class="why-item">
                    <span class="why-icon">⏰</span>
                    <h3>
                        <?php esc_html_e('24/7 Service', 'bestbalitravel'); ?>
                    </h3>
                    <p>
                        <?php esc_html_e('Available anytime, any flight', 'bestbalitravel'); ?>
                    </p>
                </div>
                <div class="why-item">
                    <span class="why-icon">✈️</span>
                    <h3>
                        <?php esc_html_e('Flight Tracking', 'bestbalitravel'); ?>
                    </h3>
                    <p>
                        <?php esc_html_e('We monitor your flight status', 'bestbalitravel'); ?>
                    </p>
                </div>
                <div class="why-item">
                    <span class="why-icon">💳</span>
                    <h3>
                        <?php esc_html_e('Fixed Price', 'bestbalitravel'); ?>
                    </h3>
                    <p>
                        <?php esc_html_e('No hidden fees or surcharges', 'bestbalitravel'); ?>
                    </p>
                </div>
                <div class="why-item">
                    <span class="why-icon">🎯</span>
                    <h3>
                        <?php esc_html_e('Meet & Greet', 'bestbalitravel'); ?>
                    </h3>
                    <p>
                        <?php esc_html_e('Driver waits with name board', 'bestbalitravel'); ?>
                    </p>
                </div>
            </div>
        </div>
    </section>

</main>

<style>
    .transfer-hero {
        padding: 120px 0 60px;
        background: linear-gradient(135deg, #1e3a5f 0%, #2d5a87 50%, #3b82f6 100%);
        color: white;
    }

    .transfer-hero-content {
        text-align: center;
    }

    .transfer-hero .hero-badge {
        display: inline-block;
        padding: 8px 20px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50px;
        font-size: 14px;
        margin-bottom: 16px;
        opacity: 0;
        transform: translateY(20px);
        transition: all 0.6s;
    }

    .transfer-hero .hero-badge.visible {
        opacity: 1;
        transform: translateY(0);
    }

    .transfer-hero h1 {
        font-family: 'Cormorant Garamond', serif;
        font-size: clamp(2.5rem, 6vw, 4rem);
        margin-bottom: 12px;
        opacity: 0;
        transform: translateY(30px);
        transition: all 0.8s;
    }

    .transfer-hero h1.visible {
        opacity: 1;
        transform: translateY(0);
    }

    .transfer-hero p {
        font-size: 1.125rem;
        opacity: 0.9;
    }

    .booking-section {
        margin-top: -40px;
        padding-bottom: 60px;
        position: relative;
        z-index: 10;
    }

    .booking-card {
        background: white;
        border-radius: 24px;
        padding: 30px;
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.15);
        max-width: 700px;
        margin: 0 auto;
    }

    .booking-card h2 {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.75rem;
        text-align: center;
        margin-bottom: 24px;
        color: #111827;
    }

    .trip-type-toggle {
        display: flex;
        gap: 8px;
        margin-bottom: 24px;
        padding: 4px;
        background: #f3f4f6;
        border-radius: 12px;
    }

    .trip-type-toggle button {
        flex: 1;
        padding: 12px 16px;
        background: transparent;
        border: none;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 500;
        color: #6b7280;
        cursor: pointer;
        transition: all 0.3s;
    }

    .trip-type-toggle button.active {
        background: #3b82f6;
        color: white;
    }

    .booking-form .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
        margin-bottom: 16px;
    }

    @media (max-width: 600px) {
        .booking-form .form-row {
            grid-template-columns: 1fr;
        }
    }

    .form-group {
        margin-bottom: 16px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-size: 14px;
        font-weight: 500;
        color: #374151;
    }

    .form-group input,
    .form-group select {
        width: 100%;
        padding: 12px 16px;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        font-size: 14px;
        transition: border-color 0.3s;
    }

    .form-group input:focus,
    .form-group select:focus {
        outline: none;
        border-color: #3b82f6;
    }

    .passenger-counter {
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 8px 16px;
        background: #f9fafb;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
    }

    .passenger-counter button {
        width: 32px;
        height: 32px;
        border: none;
        background: #3b82f6;
        color: white;
        border-radius: 50%;
        font-size: 18px;
        cursor: pointer;
    }

    .passenger-counter span {
        flex: 1;
        text-align: center;
        font-size: 18px;
        font-weight: 600;
    }

    .submit-btn {
        width: 100%;
        padding: 16px;
        background: linear-gradient(135deg, #3b82f6, #2563eb);
        color: white;
        font-size: 16px;
        font-weight: 600;
        border: none;
        border-radius: 12px;
        cursor: pointer;
        transition: all 0.3s;
    }

    .submit-btn:hover {
        box-shadow: 0 8px 25px rgba(59, 130, 246, 0.4);
        transform: translateY(-2px);
    }

    .vehicles-section {
        padding: 60px 0;
        background: #f9fafb;
    }

    .vehicles-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 24px;
    }

    .vehicle-card {
        background: white;
        border-radius: 20px;
        padding: 30px;
        text-align: center;
        border: 2px solid transparent;
        transition: all 0.3s;
        position: relative;
        opacity: 0;
        transform: translateY(20px);
    }

    .vehicle-card.visible {
        opacity: 1;
        transform: translateY(0);
    }

    .vehicle-card:hover {
        border-color: #3b82f6;
        transform: translateY(-4px);
    }

    .vehicle-card.popular {
        border-color: #3b82f6;
    }

    .popular-badge {
        position: absolute;
        top: -12px;
        left: 50%;
        transform: translateX(-50%);
        padding: 6px 16px;
        background: #3b82f6;
        color: white;
        font-size: 12px;
        font-weight: 600;
        border-radius: 20px;
    }

    .vehicle-icon {
        font-size: 56px;
        margin-bottom: 16px;
    }

    .vehicle-card h3 {
        font-size: 18px;
        font-weight: 600;
        color: #111827;
        margin-bottom: 16px;
    }

    .vehicle-specs {
        list-style: none;
        padding: 0;
        margin: 0 0 20px;
        text-align: left;
    }

    .vehicle-specs li {
        padding: 8px 0;
        font-size: 14px;
        color: #6b7280;
        border-bottom: 1px solid #f3f4f6;
    }

    .vehicle-price .price-from {
        display: block;
        font-size: 12px;
        color: #9ca3af;
    }

    .vehicle-price .price-amount {
        font-size: 24px;
        font-weight: 700;
        color: #3b82f6;
    }

    .why-section {
        padding: 60px 0;
        background: white;
    }

    .why-section .why-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 30px;
    }

    .why-section .why-item {
        text-align: center;
        padding: 20px;
    }

    .why-section .why-icon {
        font-size: 40px;
        margin-bottom: 12px;
    }

    .why-section .why-item h3 {
        font-size: 16px;
        font-weight: 600;
        color: #111827;
        margin-bottom: 8px;
    }

    .why-section .why-item p {
        font-size: 14px;
        color: #6b7280;
    }
</style>

<?php
get_footer();
