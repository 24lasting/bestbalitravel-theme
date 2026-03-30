<?php
/**
 * The footer template
 * Supports Elementor Theme Builder for custom footer
 *
 * @package BestBaliTravel
 */
?>
</div><!-- #content -->

<?php
// Check if Elementor Pro has a custom footer template
if (function_exists('elementor_theme_do_location') && elementor_theme_do_location('footer')) {
    // Elementor footer is displayed, skip theme footer
} else {
    // Display default theme footer
?>

<!-- Footer -->
<footer id="colophon" class="site-footer">
    <!-- Footer Main -->
    <div class="footer-main">
        <div class="bbt-container">
            <div class="footer-grid">
                <!-- About Column -->
                <div class="footer-col footer-about">
                    <div class="footer-logo">
                        <?php if (has_custom_logo()): ?>
                            <?php the_custom_logo(); ?>
                        <?php else: ?>
                            <a href="<?php echo esc_url(home_url('/')); ?>" class="site-logo-text">
                                <span class="logo-best">BEST</span>
                                <span class="logo-bali">BALI</span>
                                <span class="logo-travel">TRAVEL</span>
                            </a>
                        <?php endif; ?>
                    </div>
                    <p class="footer-description">
                        <?php echo esc_html(get_theme_mod('bbt_footer_description', 'Explore Bali the Right Way. We provide the best tour experiences with local guides, personalized service, and unforgettable memories.')); ?>
                    </p>
                    <div class="footer-social">
                        <a href="<?php echo esc_url(get_theme_mod('bbt_instagram', 'https://instagram.com/bestbalitravel')); ?>"
                            target="_blank" rel="noopener noreferrer" aria-label="Instagram">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                <path
                                    d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                            </svg>
                        </a>
                        <a href="<?php echo esc_url(get_theme_mod('bbt_facebook', 'https://facebook.com/bestbalitravel')); ?>"
                            target="_blank" rel="noopener noreferrer" aria-label="Facebook">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                <path
                                    d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                            </svg>
                        </a>
                        <a href="<?php echo esc_url(get_theme_mod('bbt_tiktok', 'https://tiktok.com/@bestbalitravel')); ?>"
                            target="_blank" rel="noopener noreferrer" aria-label="TikTok">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                <path
                                    d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z" />
                            </svg>
                        </a>
                        <a href="<?php echo esc_url(get_theme_mod('bbt_youtube', 'https://youtube.com/@bestbalitravel')); ?>"
                            target="_blank" rel="noopener noreferrer" aria-label="YouTube">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                <path
                                    d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z" />
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="footer-col">
                    <h4 class="footer-title">
                        <?php esc_html_e('Quick Links', 'bestbalitravel'); ?>
                    </h4>
                    <ul class="footer-links">
                        <li><a href="<?php echo esc_url(home_url('/tours/')); ?>">
                                <?php esc_html_e('All Tours', 'bestbalitravel'); ?>
                            </a></li>
                        <li><a href="<?php echo esc_url(home_url('/activities/')); ?>">
                                <?php esc_html_e('Activities', 'bestbalitravel'); ?>
                            </a></li>
                        <li><a href="<?php echo esc_url(home_url('/honeymoon/')); ?>">
                                <?php esc_html_e('Honeymoon', 'bestbalitravel'); ?>
                            </a></li>
                        <li><a href="<?php echo esc_url(home_url('/airport-transfer/')); ?>">
                                <?php esc_html_e('Airport Transfer', 'bestbalitravel'); ?>
                            </a></li>
                        <li><a href="<?php echo esc_url(home_url('/about/')); ?>">
                                <?php esc_html_e('About Us', 'bestbalitravel'); ?>
                            </a></li>
                        <li><a href="<?php echo esc_url(home_url('/contact/')); ?>">
                                <?php esc_html_e('Contact', 'bestbalitravel'); ?>
                            </a></li>
                    </ul>
                </div>

                <!-- Tour Locations -->
                <div class="footer-col">
                    <h4 class="footer-title">
                        <?php esc_html_e('Destinations', 'bestbalitravel'); ?>
                    </h4>
                    <ul class="footer-links">
                        <li><a href="<?php echo esc_url(home_url('/location/kintamani/')); ?>">
                                <?php esc_html_e('Kintamani', 'bestbalitravel'); ?>
                            </a></li>
                        <li><a href="<?php echo esc_url(home_url('/location/ubud/')); ?>">
                                <?php esc_html_e('Ubud', 'bestbalitravel'); ?>
                            </a></li>
                        <li><a href="<?php echo esc_url(home_url('/location/uluwatu/')); ?>">
                                <?php esc_html_e('Uluwatu', 'bestbalitravel'); ?>
                            </a></li>
                        <li><a href="<?php echo esc_url(home_url('/location/nusa-penida/')); ?>">
                                <?php esc_html_e('Nusa Penida', 'bestbalitravel'); ?>
                            </a></li>
                        <li><a href="<?php echo esc_url(home_url('/location/karangasem/')); ?>">
                                <?php esc_html_e('Karangasem', 'bestbalitravel'); ?>
                            </a></li>
                        <li><a href="<?php echo esc_url(home_url('/location/singaraja/')); ?>">
                                <?php esc_html_e('Singaraja', 'bestbalitravel'); ?>
                            </a></li>
                    </ul>
                </div>

                <!-- Contact Info -->
                <div class="footer-col">
                    <h4 class="footer-title">
                        <?php esc_html_e('Contact Us', 'bestbalitravel'); ?>
                    </h4>
                    <ul class="footer-contact">
                        <li>
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <path
                                    d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z">
                                </path>
                            </svg>
                            <a href="https://wa.me/6287854806011">+62 878 5480 6011</a>
                        </li>
                        <li>
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z">
                                </path>
                                <polyline points="22,6 12,13 2,6"></polyline>
                            </svg>
                            <a href="mailto:info@bestbalitravel.com">info@bestbalitravel.com</a>
                        </li>
                        <li>
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                <circle cx="12" cy="10" r="3"></circle>
                            </svg>
                            <span>Bali, Indonesia</span>
                        </li>
                    </ul>

                    <!-- Payment Methods -->
                    <div class="footer-payments">
                        <h5>
                            <?php esc_html_e('We Accept', 'bestbalitravel'); ?>
                        </h5>
                        <div class="payment-icons">
                            <img src="<?php echo BBT_THEME_ASSETS; ?>/images/payments/visa.svg" alt="Visa">
                            <img src="<?php echo BBT_THEME_ASSETS; ?>/images/payments/mastercard.svg" alt="Mastercard">
                            <img src="<?php echo BBT_THEME_ASSETS; ?>/images/payments/gopay.svg" alt="GoPay">
                            <img src="<?php echo BBT_THEME_ASSETS; ?>/images/payments/ovo.svg" alt="OVO">
                            <img src="<?php echo BBT_THEME_ASSETS; ?>/images/payments/dana.svg" alt="DANA">
                            <img src="<?php echo BBT_THEME_ASSETS; ?>/images/payments/qris.svg" alt="QRIS">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer Bottom -->
    <div class="footer-bottom">
        <div class="bbt-container">
            <div class="footer-bottom-inner">
                <p class="copyright">
                    &copy;
                    <?php echo date('Y'); ?>
                    <?php bloginfo('name'); ?>.
                    <?php esc_html_e('All Rights Reserved.', 'bestbalitravel'); ?>
                </p>
                <ul class="footer-legal">
                    <li><a href="<?php echo esc_url(home_url('/privacy-policy/')); ?>">
                            <?php esc_html_e('Privacy Policy', 'bestbalitravel'); ?>
                        </a></li>
                    <li><a href="<?php echo esc_url(home_url('/terms/')); ?>">
                            <?php esc_html_e('Terms & Conditions', 'bestbalitravel'); ?>
                        </a></li>
                    <li><a href="<?php echo esc_url(home_url('/refund-policy/')); ?>">
                            <?php esc_html_e('Refund Policy', 'bestbalitravel'); ?>
                        </a></li>
                </ul>
            </div>
    </div>
</footer>

<?php } // End else (default theme footer) ?>

</div><!-- #page -->

<!-- Mobile Bottom Navigation (Tiket.com/Traveloka Style) -->
<nav class="mobile-bottom-nav" x-data="mobileBottomNav()"
    @wishlist-updated.window="wishlistCount = $event.detail.count">
    <div class="mobile-bottom-nav-inner">
        <!-- Home -->
        <a href="<?php echo esc_url(home_url('/')); ?>" class="mobile-nav-item"
            :class="{ 'active': activeTab === 'home' }" @click="setActive('home')">
            <span class="mobile-nav-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"></path>
                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                </svg>
            </span>
            <span class="mobile-nav-label"><?php esc_html_e('Home', 'bestbalitravel'); ?></span>
        </a>

        <!-- Tours -->
        <a href="<?php echo esc_url(home_url('/tours/')); ?>" class="mobile-nav-item"
            :class="{ 'active': activeTab === 'tours' }" @click="setActive('tours')">
            <span class="mobile-nav-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="10" r="3"></circle>
                    <path d="M12 21.7C17.3 17 20 13 20 10a8 8 0 10-16 0c0 3 2.7 6.9 8 11.7z"></path>
                </svg>
            </span>
            <span class="mobile-nav-label"><?php esc_html_e('Tours', 'bestbalitravel'); ?></span>
        </a>

        <!-- Book Now (Center Action) -->
        <a href="<?php echo esc_url(home_url('/booking/')); ?>" class="mobile-nav-item nav-action"
            :class="{ 'active': activeTab === 'booking' }" @click="setActive('booking')">
            <span class="mobile-nav-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                    <line x1="16" y1="2" x2="16" y2="6"></line>
                    <line x1="8" y1="2" x2="8" y2="6"></line>
                    <line x1="3" y1="10" x2="21" y2="10"></line>
                    <path d="M9 16l2 2 4-4"></path>
                </svg>
            </span>
            <span class="mobile-nav-label"><?php esc_html_e('Book', 'bestbalitravel'); ?></span>
        </a>

        <!-- Wishlist -->
        <a href="<?php echo esc_url(home_url('/wishlist/')); ?>" class="mobile-nav-item"
            :class="{ 'active': activeTab === 'wishlist' }" @click="setActive('wishlist')">
            <span class="mobile-nav-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path
                        d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z">
                    </path>
                </svg>
                <span class="mobile-nav-badge" x-show="wishlistCount > 0" x-text="wishlistCount" x-cloak></span>
            </span>
            <span class="mobile-nav-label"><?php esc_html_e('Wishlist', 'bestbalitravel'); ?></span>
        </a>

        <!-- Profile -->
        <a href="<?php echo esc_url(home_url('/my-account/')); ?>" class="mobile-nav-item"
            :class="{ 'active': activeTab === 'profile' }" @click="setActive('profile')">
            <span class="mobile-nav-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"></path>
                    <circle cx="12" cy="7" r="4"></circle>
                </svg>
            </span>
            <span class="mobile-nav-label"><?php esc_html_e('Profile', 'bestbalitravel'); ?></span>
        </a>
    </div>
</nav>

<!-- Toast Notification Container -->
<div class="bbt-toast" x-data :class="{ 'visible': $store.toast.visible, [$store.toast.type]: true }"
    x-text="$store.toast.message" x-show="$store.toast.visible" x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
    x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0"
    x-transition:leave-end="opacity-0 translate-y-4" x-cloak>
</div>

<?php wp_footer(); ?>

</body>

</html>