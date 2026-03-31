<?php
/**
 * The header template with Alpine.js
 * Responsive navigation for desktop, tablet, and mobile
 * Supports Elementor Theme Builder for custom header
 *
 * @package BestBaliTravel
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- Tailwind CSS for Glassmorphism -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">

<?php
// Check if Elementor Pro has a custom header template
if (function_exists('elementor_theme_do_location') && elementor_theme_do_location('header')) {
    // Elementor header is displayed, skip theme header
} else {
    // Display default theme header
?>

    <div id="content" class="site-content">
    
    <style>
    /* ============================================
       HEADER STYLES WITH ALPINE.JS SUPPORT
    ============================================ */
    
    /* Base Header */
    .bbt-header {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        z-index: 1000;
        background: #fff;
        box-shadow: 0 2px 20px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
    }
    .bbt-header.scrolled {
        box-shadow: 0 4px 30px rgba(0,0,0,0.12);
    }
    .bbt-header-inner {
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 30px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        height: 80px;
    }
    
    /* Logo */
    .bbt-logo {
        display: flex;
        align-items: center;
        text-decoration: none;
        font-weight: 700;
        font-size: 22px;
    }
    .bbt-logo .logo-best { color: #f39c12; }
    .bbt-logo .logo-bali { color: #16a085; }
    .bbt-logo .logo-travel { color: #1a3c40; font-weight: 400; }
    .bbt-logo img {
        height: 50px;
        width: auto;
    }
    
    /* Desktop Navigation */
    .bbt-nav-desktop {
        display: flex;
        align-items: center;
        gap: 40px;
    }
    .bbt-nav-menu {
        display: flex;
        list-style: none;
        margin: 0;
        padding: 0;
        gap: 35px;
    }
    .bbt-nav-menu li {
        position: relative;
    }
    .bbt-nav-menu > li > a {
        display: flex;
        align-items: center;
        gap: 5px;
        color: #333;
        text-decoration: none;
        font-size: 15px;
        font-weight: 500;
        padding: 10px 0;
        transition: color 0.3s;
    }
    .bbt-nav-menu > li > a:hover,
    .bbt-nav-menu > li.current-menu-item > a {
        color: #16a085;
    }
    .bbt-nav-menu > li > a svg {
        width: 14px;
        height: 14px;
        transition: transform 0.3s;
    }
    .bbt-nav-menu > li:hover > a svg {
        transform: rotate(180deg);
    }
    
    /* Dropdown */
    .bbt-dropdown {
        position: absolute;
        top: 100%;
        left: -20px;
        min-width: 220px;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.12);
        padding: 15px 0;
        opacity: 0;
        visibility: hidden;
        transform: translateY(10px);
        transition: all 0.3s ease;
        z-index: 100;
    }
    .bbt-nav-menu > li:hover .bbt-dropdown {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }
    .bbt-dropdown a {
        display: block;
        padding: 12px 25px;
        color: #555;
        text-decoration: none;
        font-size: 14px;
        transition: all 0.2s;
    }
    .bbt-dropdown a:hover {
        background: #f8f9fa;
        color: #16a085;
        padding-left: 30px;
    }
    
    /* Header Actions */
    .bbt-header-actions {
        display: flex;
        align-items: center;
        gap: 15px;
    }
    .bbt-header-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 42px;
        height: 42px;
        border-radius: 10px;
        background: #f5f5f5;
        border: none;
        cursor: pointer;
        transition: all 0.3s;
        color: #555;
    }
    .bbt-header-btn:hover {
        background: #16a085;
        color: #fff;
    }
    .bbt-header-btn svg {
        width: 20px;
        height: 20px;
    }
    
    /* Language/Currency Dropdown */
    .bbt-selector {
        position: relative;
    }
    .bbt-selector-btn {
        display: flex;
        align-items: center;
        gap: 6px;
        padding: 10px 15px;
        background: #f5f5f5;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        font-size: 14px;
        font-weight: 500;
        color: #333;
        transition: all 0.3s;
    }
    .bbt-selector-btn:hover {
        background: #e8e8e8;
    }
    .bbt-selector-btn svg {
        width: 14px;
        height: 14px;
        transition: transform 0.3s;
    }
    .bbt-selector[x-data] .bbt-selector-btn svg {
        transform: rotate(0deg);
    }
    [x-show].bbt-selector-dropdown ~ .bbt-selector-btn svg,
    .bbt-selector-btn.open svg {
        transform: rotate(180deg);
    }
    .bbt-selector-dropdown {
        position: absolute;
        top: calc(100% + 10px);
        right: 0;
        min-width: 150px;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.15);
        padding: 10px 0;
        z-index: 100;
    }
    .bbt-selector-dropdown a {
        display: block;
        padding: 10px 20px;
        color: #555;
        text-decoration: none;
        font-size: 14px;
        transition: all 0.2s;
    }
    .bbt-selector-dropdown a:hover,
    .bbt-selector-dropdown a.active {
        background: #f0f9f7;
        color: #16a085;
    }
    
    /* Mobile Menu Toggle */
    .bbt-menu-toggle {
        display: none;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        width: 44px;
        height: 44px;
        background: none;
        border: none;
        cursor: pointer;
        padding: 10px;
        gap: 5px;
    }
    .bbt-menu-toggle span {
        display: block;
        width: 24px;
        height: 2px;
        background: #333;
        border-radius: 2px;
        transition: all 0.3s;
    }
    .bbt-menu-toggle.open span:nth-child(1) {
        transform: rotate(45deg) translate(5px, 5px);
    }
    .bbt-menu-toggle.open span:nth-child(2) {
        opacity: 0;
    }
    .bbt-menu-toggle.open span:nth-child(3) {
        transform: rotate(-45deg) translate(5px, -5px);
    }
    
    /* Mobile Menu Overlay */
    .bbt-mobile-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.5);
        z-index: 999;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s;
    }
    .bbt-mobile-overlay.open {
        opacity: 1;
        visibility: visible;
    }
    
    /* Mobile Menu Panel */
    .bbt-mobile-menu {
        position: fixed;
        top: 0;
        right: -320px;
        width: 320px;
        max-width: 90vw;
        height: 100vh;
        background: #fff;
        z-index: 1001;
        transition: right 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }
    .bbt-mobile-menu.open {
        right: 0;
    }
    .bbt-mobile-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 20px;
        border-bottom: 1px solid #eee;
    }
    .bbt-mobile-close {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f5f5f5;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        transition: all 0.3s;
    }
    .bbt-mobile-close:hover {
        background: #e74c3c;
        color: #fff;
    }
    .bbt-mobile-close svg {
        width: 20px;
        height: 20px;
    }
    
    /* Mobile Nav */
    .bbt-mobile-nav {
        flex: 1;
        overflow-y: auto;
        padding: 20px;
    }
    .bbt-mobile-nav-list {
        list-style: none;
        margin: 0;
        padding: 0;
    }
    .bbt-mobile-nav-list li {
        border-bottom: 1px solid #f0f0f0;
    }
    .bbt-mobile-nav-list > li > a {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 18px 0;
        color: #333;
        text-decoration: none;
        font-size: 16px;
        font-weight: 500;
        transition: color 0.3s;
    }
    .bbt-mobile-nav-list > li > a:hover {
        color: #16a085;
    }
    .bbt-mobile-nav-list > li > a svg {
        width: 18px;
        height: 18px;
        transition: transform 0.3s;
    }
    .bbt-mobile-nav-list > li.open > a svg {
        transform: rotate(180deg);
    }
    
    /* Mobile Submenu */
    .bbt-mobile-submenu {
        list-style: none;
        padding: 0 0 15px 20px;
        margin: 0;
        display: none;
    }
    .bbt-mobile-submenu.open {
        display: block;
    }
    .bbt-mobile-submenu li a {
        display: block;
        padding: 12px 0;
        color: #666;
        text-decoration: none;
        font-size: 14px;
        transition: color 0.3s;
    }
    .bbt-mobile-submenu li a:hover {
        color: #16a085;
    }
    
    /* Mobile Footer */
    .bbt-mobile-footer {
        padding: 20px;
        border-top: 1px solid #eee;
        background: #f8f9fa;
    }
    .bbt-mobile-selectors {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
        margin-bottom: 20px;
    }
    .bbt-mobile-selector {
        padding: 12px;
        background: #fff;
        border: 1px solid #e8e8e8;
        border-radius: 10px;
        cursor: pointer;
        font-size: 14px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .bbt-whatsapp-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        width: 100%;
        padding: 16px;
        background: #25d366;
        color: #fff;
        border: none;
        border-radius: 12px;
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        transition: background 0.3s;
    }
    .bbt-whatsapp-btn:hover {
        background: #1da851;
        color: #fff;
    }
    .bbt-whatsapp-btn svg {
        width: 22px;
        height: 22px;
    }
    
    /* Search Overlay */
    .bbt-search-overlay {
        position: fixed;
        inset: 0;
        background: rgba(26, 60, 64, 0.95);
        z-index: 1002;
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s;
    }
    .bbt-search-overlay.open {
        opacity: 1;
        visibility: visible;
    }
    .bbt-search-container {
        width: 100%;
        max-width: 700px;
        padding: 0 30px;
    }
    .bbt-search-form {
        display: flex;
        background: #fff;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 20px 60px rgba(0,0,0,0.3);
    }
    .bbt-search-input {
        flex: 1;
        padding: 22px 25px;
        border: none;
        font-size: 18px;
        outline: none;
    }
    .bbt-search-submit {
        padding: 22px 30px;
        background: #16a085;
        border: none;
        color: #fff;
        cursor: pointer;
        transition: background 0.3s;
    }
    .bbt-search-submit:hover {
        background: #138d75;
    }
    .bbt-search-submit svg {
        width: 24px;
        height: 24px;
    }
    .bbt-search-close {
        position: absolute;
        top: 30px;
        right: 30px;
        width: 50px;
        height: 50px;
        background: rgba(255,255,255,0.1);
        border: none;
        border-radius: 50%;
        color: #fff;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background 0.3s;
    }
    .bbt-search-close:hover {
        background: rgba(255,255,255,0.2);
    }
    .bbt-search-close svg {
        width: 24px;
        height: 24px;
    }
    
    /* Responsive */
    @media (max-width: 1200px) {
        .bbt-nav-menu {
            gap: 25px;
        }
    }
    
    @media (max-width: 992px) {
        .bbt-nav-desktop {
            display: none;
        }
        .bbt-menu-toggle {
            display: flex;
        }
        .bbt-header-actions .bbt-selector {
            display: none;
        }
    }
    
    @media (max-width: 768px) {
        .bbt-header-inner {
            height: 70px;
            padding: 0 20px;
        }
        .bbt-logo {
            font-size: 18px;
        }
        .bbt-logo img {
            height: 40px;
        }
    }
    
    /* Body padding for fixed header */
    body {
        padding-top: 80px;
    }
    @media (max-width: 768px) {
        body {
            padding-top: 70px;
        }
    }
    
    /* WhatsApp Float */
    .bbt-whatsapp-float {
        position: fixed;
        bottom: 25px;
        right: 25px;
        width: 60px;
        height: 60px;
        background: #25d366;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        box-shadow: 0 4px 20px rgba(37, 211, 102, 0.4);
        z-index: 999;
        transition: transform 0.3s, box-shadow 0.3s;
    }
    .bbt-whatsapp-float:hover {
        transform: scale(1.1);
        box-shadow: 0 6px 30px rgba(37, 211, 102, 0.5);
        color: #fff;
    }
    .bbt-whatsapp-float svg {
        width: 30px;
        height: 30px;
    }

    /* Transparent Header Mode (Added by Hero Slider Widget) */
    body.has-transparent-header {
        padding-top: 0;
    }
    @media (max-width: 768px) {
        body.has-transparent-header { padding-top: 0; }
    }
    body.has-transparent-header .bbt-header:not(.scrolled) {
        background: transparent;
        box-shadow: none;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }
    body.has-transparent-header .bbt-header:not(.scrolled) .bbt-nav-menu > li > a {
        color: #ffffff;
        text-shadow: 0 1px 3px rgba(0,0,0,0.5);
    }
    body.has-transparent-header .bbt-header:not(.scrolled) .bbt-nav-menu > li > a:hover {
        color: #f39c12;
    }
    body.has-transparent-header .bbt-header:not(.scrolled) .bbt-logo {
        color: #ffffff;
    }
    body.has-transparent-header .bbt-header:not(.scrolled) .bbt-logo .logo-best,
    body.has-transparent-header .bbt-header:not(.scrolled) .bbt-logo .logo-bali,
    body.has-transparent-header .bbt-header:not(.scrolled) .bbt-logo .logo-travel {
        color: #ffffff;
        text-shadow: 0 2px 4px rgba(0,0,0,0.5);
    }
    body.has-transparent-header .bbt-header:not(.scrolled) .bbt-header-btn,
    body.has-transparent-header .bbt-header:not(.scrolled) .bbt-selector-btn {
        background: rgba(255, 255, 255, 0.15);
        color: #ffffff;
        backdrop-filter: blur(10px);
        box-shadow: 0 1px 5px rgba(0,0,0,0.2);
    }
    body.has-transparent-header .bbt-header:not(.scrolled) .bbt-header-btn:hover,
    body.has-transparent-header .bbt-header:not(.scrolled) .bbt-selector-btn:hover {
        background: rgba(255, 255, 255, 0.25);
    }
    body.has-transparent-header .bbt-header:not(.scrolled) .bbt-menu-toggle span {
        background: #ffffff;
        box-shadow: 0 1px 2px rgba(0,0,0,0.5);
    }
    </style>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>

    <div id="page" class="site">
        <a class="skip-link screen-reader-text" href="#main">
            <?php esc_html_e('Skip to content', 'bestbalitravel'); ?>
        </a>

        <!-- Header with Alpine.js -->
        <header class="bbt-header" x-data="{ 
            mobileOpen: false, 
            searchOpen: false,
            langOpen: false,
            currOpen: false,
            scrolled: false
        }" 
        @scroll.window="scrolled = (window.scrollY > 50)"
        :class="{ 'scrolled': scrolled }">
            
            <div class="bbt-header-inner">
                <!-- Logo -->
                <a href="<?php echo esc_url(home_url('/')); ?>" class="bbt-logo">
                    <?php if (has_custom_logo()): ?>
                        <?php 
                        $logo_id = get_theme_mod('custom_logo');
                        $logo_url = wp_get_attachment_image_url($logo_id, 'full');
                        ?>
                        <img src="<?php echo esc_url($logo_url); ?>" alt="<?php bloginfo('name'); ?>">
                    <?php else: ?>
                        <span class="logo-best">BEST</span>
                        <span class="logo-bali">BALI</span>
                        <span class="logo-travel">TRAVEL</span>
                    <?php endif; ?>
                </a>

                <!-- Desktop Navigation -->
                <nav class="bbt-nav-desktop">
                    <ul class="bbt-nav-menu">
                        <li class="<?php echo is_front_page() ? 'current-menu-item' : ''; ?>">
                            <a href="<?php echo esc_url(home_url('/')); ?>">Home</a>
                        </li>
                        <li>
                            <a href="<?php echo esc_url(home_url('/tours')); ?>">
                                Tours
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 9l6 6 6-6"/></svg>
                            </a>
                            <div class="bbt-dropdown">
                                <a href="<?php echo esc_url(home_url('/tours')); ?>">All Tours</a>
                                <a href="<?php echo esc_url(home_url('/tours/?type=day-tour')); ?>">Day Tours</a>
                                <a href="<?php echo esc_url(home_url('/tours/?type=package')); ?>">Tour Packages</a>
                                <a href="<?php echo esc_url(home_url('/tours/?type=private')); ?>">Private Tours</a>
                            </div>
                        </li>
                        <li>
                            <a href="<?php echo esc_url(home_url('/activities')); ?>">
                                Activities
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 9l6 6 6-6"/></svg>
                            </a>
                            <div class="bbt-dropdown">
                                <a href="<?php echo esc_url(home_url('/activities')); ?>">All Activities</a>
                                <a href="<?php echo esc_url(home_url('/activities/?cat=water-sports')); ?>">Water Sports</a>
                                <a href="<?php echo esc_url(home_url('/activities/?cat=adventure')); ?>">Adventure</a>
                                <a href="<?php echo esc_url(home_url('/activities/?cat=wellness')); ?>">Wellness & Spa</a>
                            </div>
                        </li>
                        <li>
                            <a href="<?php echo esc_url(home_url('/destinations')); ?>">Destinations</a>
                        </li>
                        <li>
                            <a href="<?php echo esc_url(home_url('/about')); ?>">About</a>
                        </li>
                        <li>
                            <a href="<?php echo esc_url(home_url('/contact')); ?>">Contact</a>
                        </li>
                    </ul>
                </nav>

                <!-- Header Actions -->
                <div class="bbt-header-actions">
                    <!-- Search Button -->
                    <button type="button" class="bbt-header-btn" @click="searchOpen = true" aria-label="Search">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <circle cx="11" cy="11" r="8"></circle>
                            <path d="M21 21l-4.35-4.35"></path>
                        </svg>
                    </button>

                    <!-- Language Selector -->
                    <div class="bbt-selector" x-data="{ open: false }" @click.away="open = false">
                        <button type="button" class="bbt-selector-btn" @click="open = !open" :class="{ 'open': open }">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="10"></circle>
                                <path d="M2 12h20M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path>
                            </svg>
                            EN
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 9l6 6 6-6"/></svg>
                        </button>
                        <div class="bbt-selector-dropdown" x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform -translate-y-2" x-transition:enter-end="opacity-100 transform translate-y-0" x-cloak>
                            <a href="#" class="active">English</a>
                            <a href="#">Indonesia</a>
                            <a href="#">中文</a>
                            <a href="#">日本語</a>
                        </div>
                    </div>

                    <!-- Currency Selector -->
                    <div class="bbt-selector" x-data="{ open: false }" @click.away="open = false">
                        <button type="button" class="bbt-selector-btn" @click="open = !open" :class="{ 'open': open }">
                            IDR
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 9l6 6 6-6"/></svg>
                        </button>
                        <div class="bbt-selector-dropdown" x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform -translate-y-2" x-transition:enter-end="opacity-100 transform translate-y-0" x-cloak>
                            <a href="#" class="active">Rp IDR</a>
                            <a href="#">$ USD</a>
                            <a href="#">€ EUR</a>
                            <a href="#">A$ AUD</a>
                        </div>
                    </div>

                    <!-- Cart (WooCommerce) -->
                    <?php if (class_exists('WooCommerce')): ?>
                    <a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="bbt-header-btn">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <circle cx="9" cy="21" r="1"></circle>
                            <circle cx="20" cy="21" r="1"></circle>
                            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                        </svg>
                    </a>
                    <?php endif; ?>

                    <!-- Mobile Menu Toggle -->
                    <button type="button" class="bbt-menu-toggle" @click="mobileOpen = !mobileOpen" :class="{ 'open': mobileOpen }" aria-label="Menu">
                        <span></span>
                        <span></span>
                        <span></span>
                    </button>
                </div>
            </div>

            <!-- Search Overlay -->
            <div class="bbt-search-overlay" :class="{ 'open': searchOpen }" @keydown.escape.window="searchOpen = false">
                <div class="bbt-search-container">
                    <form role="search" method="get" class="bbt-search-form" action="<?php echo esc_url(home_url('/')); ?>">
                        <input type="search" class="bbt-search-input" placeholder="Search tours, activities..." name="s" x-ref="searchInput" @keydown.escape="searchOpen = false">
                        <button type="submit" class="bbt-search-submit">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <circle cx="11" cy="11" r="8"></circle>
                                <path d="M21 21l-4.35-4.35"></path>
                            </svg>
                        </button>
                    </form>
                </div>
                <button type="button" class="bbt-search-close" @click="searchOpen = false">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M18 6L6 18M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Mobile Menu Overlay -->
            <div class="bbt-mobile-overlay" :class="{ 'open': mobileOpen }" @click="mobileOpen = false"></div>

            <!-- Mobile Menu Panel -->
            <div class="bbt-mobile-menu" :class="{ 'open': mobileOpen }" x-data="{ submenu: null }">
                <div class="bbt-mobile-header">
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="bbt-logo">
                        <span class="logo-best">BEST</span>
                        <span class="logo-bali">BALI</span>
                        <span class="logo-travel">TRAVEL</span>
                    </a>
                    <button type="button" class="bbt-mobile-close" @click="mobileOpen = false">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M18 6L6 18M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <nav class="bbt-mobile-nav">
                    <ul class="bbt-mobile-nav-list">
                        <li>
                            <a href="<?php echo esc_url(home_url('/')); ?>">Home</a>
                        </li>
                        <li :class="{ 'open': submenu === 'tours' }">
                            <a href="#" @click.prevent="submenu = submenu === 'tours' ? null : 'tours'">
                                Tours
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 9l6 6 6-6"/></svg>
                            </a>
                            <ul class="bbt-mobile-submenu" :class="{ 'open': submenu === 'tours' }">
                                <li><a href="<?php echo esc_url(home_url('/tours')); ?>">All Tours</a></li>
                                <li><a href="<?php echo esc_url(home_url('/tours/?type=day-tour')); ?>">Day Tours</a></li>
                                <li><a href="<?php echo esc_url(home_url('/tours/?type=package')); ?>">Tour Packages</a></li>
                                <li><a href="<?php echo esc_url(home_url('/tours/?type=private')); ?>">Private Tours</a></li>
                            </ul>
                        </li>
                        <li :class="{ 'open': submenu === 'activities' }">
                            <a href="#" @click.prevent="submenu = submenu === 'activities' ? null : 'activities'">
                                Activities
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 9l6 6 6-6"/></svg>
                            </a>
                            <ul class="bbt-mobile-submenu" :class="{ 'open': submenu === 'activities' }">
                                <li><a href="<?php echo esc_url(home_url('/activities')); ?>">All Activities</a></li>
                                <li><a href="<?php echo esc_url(home_url('/activities/?cat=water-sports')); ?>">Water Sports</a></li>
                                <li><a href="<?php echo esc_url(home_url('/activities/?cat=adventure')); ?>">Adventure</a></li>
                                <li><a href="<?php echo esc_url(home_url('/activities/?cat=wellness')); ?>">Wellness & Spa</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="<?php echo esc_url(home_url('/destinations')); ?>">Destinations</a>
                        </li>
                        <li>
                            <a href="<?php echo esc_url(home_url('/about')); ?>">About</a>
                        </li>
                        <li>
                            <a href="<?php echo esc_url(home_url('/contact')); ?>">Contact</a>
                        </li>
                    </ul>
                </nav>

                <div class="bbt-mobile-footer">
                    <div class="bbt-mobile-selectors">
                        <button type="button" class="bbt-mobile-selector">
                            🌐 English
                            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 9l6 6 6-6"/></svg>
                        </button>
                        <button type="button" class="bbt-mobile-selector">
                            💰 IDR
                            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 9l6 6 6-6"/></svg>
                        </button>
                    </div>
                    <a href="https://wa.me/<?php echo esc_attr(get_theme_mod('bbt_whatsapp_number', '6287854806011')); ?>" class="bbt-whatsapp-btn" target="_blank">
                        <svg fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                        </svg>
                        Chat on WhatsApp
                    </a>
                </div>
            </div>
        </header>

        <!-- WhatsApp Floating Button -->
        <a href="https://wa.me/<?php echo esc_attr(get_theme_mod('bbt_whatsapp_number', '6287854806011')); ?>?text=<?php echo urlencode('Halo, saya tertarik dengan tour Best Bali Travel'); ?>" class="bbt-whatsapp-float" target="_blank" rel="noopener noreferrer" aria-label="Chat on WhatsApp">
            <svg fill="currentColor" viewBox="0 0 24 24">
                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
        </a>

<?php } // End else (default theme header) ?>

        <div id="content" class="site-content">