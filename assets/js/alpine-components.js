/**
 * Best Bali Travel - Alpine.js Components
 * Super interactive components for currency, language, and UI effects
 * 
 * @package BestBaliTravel
 */

document.addEventListener('alpine:init', () => {

    // ========================================
    // CURRENCY SWITCHER COMPONENT
    // ========================================
    Alpine.data('currencySwitcher', () => ({
        open: false,
        currentCurrency: 'IDR',
        currencies: [
            { code: 'IDR', name: 'Indonesian Rupiah', symbol: 'Rp', flag: '🇮🇩' },
            { code: 'USD', name: 'US Dollar', symbol: '$', flag: '🇺🇸' },
            { code: 'EUR', name: 'Euro', symbol: '€', flag: '🇪🇺' },
            { code: 'GBP', name: 'British Pound', symbol: '£', flag: '🇬🇧' },
            { code: 'AUD', name: 'Australian Dollar', symbol: 'A$', flag: '🇦🇺' },
            { code: 'SGD', name: 'Singapore Dollar', symbol: 'S$', flag: '🇸🇬' },
            { code: 'JPY', name: 'Japanese Yen', symbol: '¥', flag: '🇯🇵' },
            { code: 'MYR', name: 'Malaysian Ringgit', symbol: 'RM', flag: '🇲🇾' },
        ],

        init() {
            // Get from cookie or detect
            const saved = this.getCookie('bbt_currency');
            if (saved) this.currentCurrency = saved;
        },

        toggle() {
            this.open = !this.open;
        },

        select(code) {
            this.currentCurrency = code;
            this.setCookie('bbt_currency', code, 30);
            this.open = false;

            // AJAX call to update session
            fetch(bbtAjax.ajaxUrl, {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `action=bbt_switch_currency&nonce=${bbtAjax.nonce}&currency=${code}`
            }).then(() => {
                // Show toast
                Alpine.store('toast').show('Currency changed to ' + code, 'success');
                // Reload to update prices
                setTimeout(() => location.reload(), 500);
            });
        },

        getCurrentFlag() {
            return this.currencies.find(c => c.code === this.currentCurrency)?.flag || '💰';
        },

        getCookie(name) {
            const match = document.cookie.match(new RegExp('(^| )' + name + '=([^;]+)'));
            return match ? match[2] : null;
        },

        setCookie(name, value, days) {
            const expires = new Date(Date.now() + days * 864e5).toUTCString();
            document.cookie = `${name}=${value}; expires=${expires}; path=/`;
        }
    }));

    // ========================================
    // LANGUAGE SWITCHER COMPONENT
    // ========================================
    Alpine.data('languageSwitcher', () => ({
        open: false,
        currentLang: 'en',
        languages: [
            { code: 'en', name: 'English', flag: '🇬🇧' },
            { code: 'id', name: 'Bahasa Indonesia', flag: '🇮🇩' },
            { code: 'zh', name: '中文', flag: '🇨🇳' },
            { code: 'ja', name: '日本語', flag: '🇯🇵' },
            { code: 'ko', name: '한국어', flag: '🇰🇷' },
            { code: 'de', name: 'Deutsch', flag: '🇩🇪' },
            { code: 'fr', name: 'Français', flag: '🇫🇷' },
            { code: 'ru', name: 'Русский', flag: '🇷🇺' },
        ],

        init() {
            const saved = this.getCookie('bbt_language');
            if (saved) this.currentLang = saved;
        },

        toggle() {
            this.open = !this.open;
        },

        select(code) {
            this.currentLang = code;
            this.setCookie('bbt_language', code, 30);
            this.open = false;
            Alpine.store('toast').show('Language changed', 'success');
        },

        getCurrentFlag() {
            return this.languages.find(l => l.code === this.currentLang)?.flag || '🌍';
        },

        getCookie(name) {
            const match = document.cookie.match(new RegExp('(^| )' + name + '=([^;]+)'));
            return match ? match[2] : null;
        },

        setCookie(name, value, days) {
            const expires = new Date(Date.now() + days * 864e5).toUTCString();
            document.cookie = `${name}=${value}; expires=${expires}; path=/`;
        }
    }));

    // ========================================
    // TOAST NOTIFICATION STORE
    // ========================================
    Alpine.store('toast', {
        visible: false,
        message: '',
        type: 'success',

        show(message, type = 'success') {
            this.message = message;
            this.type = type;
            this.visible = true;

            setTimeout(() => {
                this.visible = false;
            }, 3000);
        }
    });

    // ========================================
    // ANIMATED COUNTER COMPONENT
    // ========================================
    Alpine.data('animatedCounter', (target = 0, duration = 2000) => ({
        count: 0,
        target: target,
        started: false,

        init() {
            // Use Intersection Observer
            const observer = new IntersectionObserver((entries) => {
                if (entries[0].isIntersecting && !this.started) {
                    this.started = true;
                    this.animate();
                }
            }, { threshold: 0.5 });

            observer.observe(this.$el);
        },

        animate() {
            const startTime = performance.now();
            const step = (currentTime) => {
                const elapsed = currentTime - startTime;
                const progress = Math.min(elapsed / duration, 1);

                // Ease out quad
                const easeOut = 1 - (1 - progress) * (1 - progress);
                this.count = Math.floor(easeOut * this.target);

                if (progress < 1) {
                    requestAnimationFrame(step);
                } else {
                    this.count = this.target;
                }
            };
            requestAnimationFrame(step);
        }
    }));

    // ========================================
    // SCROLL REVEAL COMPONENT
    // ========================================
    Alpine.data('scrollReveal', (delay = 0) => ({
        visible: false,

        init() {
            const observer = new IntersectionObserver((entries) => {
                if (entries[0].isIntersecting) {
                    setTimeout(() => {
                        this.visible = true;
                    }, delay);
                    observer.unobserve(this.$el);
                }
            }, { threshold: 0.1 });

            observer.observe(this.$el);
        }
    }));

    // ========================================
    // IMAGE CAROUSEL COMPONENT
    // ========================================
    Alpine.data('imageCarousel', () => ({
        currentIndex: 0,
        images: [],
        autoplay: true,
        interval: null,

        init() {
            this.images = Array.from(this.$el.querySelectorAll('[data-carousel-item]'));
            if (this.autoplay && this.images.length > 1) {
                this.startAutoplay();
            }
        },

        next() {
            this.currentIndex = (this.currentIndex + 1) % this.images.length;
        },

        prev() {
            this.currentIndex = (this.currentIndex - 1 + this.images.length) % this.images.length;
        },

        goTo(index) {
            this.currentIndex = index;
        },

        startAutoplay() {
            this.interval = setInterval(() => this.next(), 5000);
        },

        stopAutoplay() {
            if (this.interval) clearInterval(this.interval);
        }
    }));

    // ========================================
    // BOOKING MODAL COMPONENT
    // ========================================
    Alpine.data('bookingModal', () => ({
        open: false,
        step: 1,
        tourId: null,
        tourName: '',
        adults: 2,
        children: 0,
        date: '',
        total: 0,

        openModal(tourId, tourName, price) {
            this.tourId = tourId;
            this.tourName = tourName;
            this.basePrice = price;
            this.calculateTotal();
            this.open = true;
            document.body.style.overflow = 'hidden';
        },

        closeModal() {
            this.open = false;
            this.step = 1;
            document.body.style.overflow = '';
        },

        nextStep() {
            if (this.step < 3) this.step++;
        },

        prevStep() {
            if (this.step > 1) this.step--;
        },

        calculateTotal() {
            const childPrice = this.basePrice * 0.5;
            this.total = (this.adults * this.basePrice) + (this.children * childPrice);
        },

        formatPrice(amount) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(amount);
        }
    }));

    // ========================================
    // PARALLAX EFFECT
    // ========================================
    Alpine.data('parallax', (speed = 0.5) => ({
        init() {
            window.addEventListener('scroll', () => {
                const scrolled = window.scrollY;
                const rect = this.$el.getBoundingClientRect();
                const visible = rect.top < window.innerHeight && rect.bottom > 0;

                if (visible) {
                    const yPos = -(scrolled * speed);
                    this.$el.style.transform = `translateY(${yPos}px)`;
                }
            });
        }
    }));

    // ========================================
    // MAGNETIC BUTTON EFFECT
    // ========================================
    Alpine.data('magneticButton', () => ({
        x: 0,
        y: 0,

        onMouseMove(e) {
            const rect = this.$el.getBoundingClientRect();
            const centerX = rect.left + rect.width / 2;
            const centerY = rect.top + rect.height / 2;

            this.x = (e.clientX - centerX) * 0.3;
            this.y = (e.clientY - centerY) * 0.3;
        },

        onMouseLeave() {
            this.x = 0;
            this.y = 0;
        }
    }));

    // ========================================
    // MEGA NAVIGATION COMPONENT
    // ========================================
    Alpine.data('megaNavigation', () => ({
        activeDropdown: null,
        mobileMenuOpen: false,
        mobileActiveSubmenu: null,

        openDropdown(name) {
            this.activeDropdown = name;
        },

        closeDropdown() {
            this.activeDropdown = null;
        },

        toggleDropdown(name) {
            this.activeDropdown = this.activeDropdown === name ? null : name;
        },

        toggleMobileMenu() {
            this.mobileMenuOpen = !this.mobileMenuOpen;
            document.body.style.overflow = this.mobileMenuOpen ? 'hidden' : '';
        },

        closeMobileMenu() {
            this.mobileMenuOpen = false;
            document.body.style.overflow = '';
        },

        toggleMobileSubmenu(name) {
            this.mobileActiveSubmenu = this.mobileActiveSubmenu === name ? null : name;
        }
    }));

    // ========================================
    // MOBILE BOTTOM NAVIGATION COMPONENT
    // ========================================
    Alpine.data('mobileBottomNav', () => ({
        activeTab: 'home',
        wishlistCount: 0,
        cartCount: 0,

        init() {
            // Detect current page
            const path = window.location.pathname;
            if (path === '/' || path.includes('/home')) {
                this.activeTab = 'home';
            } else if (path.includes('/tour') || path.includes('/activities')) {
                this.activeTab = 'tours';
            } else if (path.includes('/booking') || path.includes('/cart')) {
                this.activeTab = 'booking';
            } else if (path.includes('/wishlist') || path.includes('/favorite')) {
                this.activeTab = 'wishlist';
            } else if (path.includes('/account') || path.includes('/profile')) {
                this.activeTab = 'profile';
            }

            // Get counts from localStorage
            const wishlist = JSON.parse(localStorage.getItem('bbt_wishlist') || '[]');
            this.wishlistCount = wishlist.length;
        },

        setActive(tab) {
            this.activeTab = tab;
        },

        addToWishlist(tourId) {
            let wishlist = JSON.parse(localStorage.getItem('bbt_wishlist') || '[]');
            if (!wishlist.includes(tourId)) {
                wishlist.push(tourId);
                localStorage.setItem('bbt_wishlist', JSON.stringify(wishlist));
                this.wishlistCount = wishlist.length;
                Alpine.store('toast').show('Added to wishlist', 'success');
            }
        },

        isInWishlist(tourId) {
            const wishlist = JSON.parse(localStorage.getItem('bbt_wishlist') || '[]');
            return wishlist.includes(tourId);
        }
    }));

    // ========================================
    // CATEGORY TABS COMPONENT
    // ========================================
    Alpine.data('categoryTabs', () => ({
        activeCategory: 'all',
        categories: [],

        init() {
            // Get categories from DOM
            this.categories = Array.from(
                this.$el.querySelectorAll('[data-category]')
            ).map(el => el.dataset.category);

            // Check URL for active category
            const urlParams = new URLSearchParams(window.location.search);
            const urlCategory = urlParams.get('category');
            if (urlCategory) {
                this.activeCategory = urlCategory;
            }
        },

        setCategory(category) {
            this.activeCategory = category;

            // Smooth scroll tab into view
            const tabEl = this.$el.querySelector(`[data-category="${category}"]`);
            if (tabEl) {
                tabEl.scrollIntoView({ behavior: 'smooth', inline: 'center', block: 'nearest' });
            }

            // Trigger filter event
            this.$dispatch('category-changed', { category });
        },

        isActive(category) {
            return this.activeCategory === category;
        }
    }));

    // ========================================
    // FILTER SHEET COMPONENT (Mobile)
    // ========================================
    Alpine.data('filterSheet', () => ({
        open: false,
        filters: {
            priceRange: [0, 10000000],
            duration: [],
            locations: [],
            rating: 0
        },
        tempFilters: {},

        openSheet() {
            this.tempFilters = JSON.parse(JSON.stringify(this.filters));
            this.open = true;
            document.body.style.overflow = 'hidden';
        },

        closeSheet() {
            this.open = false;
            document.body.style.overflow = '';
        },

        applyFilters() {
            this.filters = JSON.parse(JSON.stringify(this.tempFilters));
            this.closeSheet();
            this.$dispatch('filters-applied', { filters: this.filters });
            Alpine.store('toast').show('Filters applied', 'success');
        },

        resetFilters() {
            this.tempFilters = {
                priceRange: [0, 10000000],
                duration: [],
                locations: [],
                rating: 0
            };
        },

        toggleDuration(value) {
            const index = this.tempFilters.duration.indexOf(value);
            if (index > -1) {
                this.tempFilters.duration.splice(index, 1);
            } else {
                this.tempFilters.duration.push(value);
            }
        },

        toggleLocation(value) {
            const index = this.tempFilters.locations.indexOf(value);
            if (index > -1) {
                this.tempFilters.locations.splice(index, 1);
            } else {
                this.tempFilters.locations.push(value);
            }
        },

        setRating(value) {
            this.tempFilters.rating = value;
        },

        getActiveFilterCount() {
            let count = 0;
            if (this.filters.duration.length) count++;
            if (this.filters.locations.length) count++;
            if (this.filters.rating > 0) count++;
            if (this.filters.priceRange[0] > 0 || this.filters.priceRange[1] < 10000000) count++;
            return count;
        }
    }));

    // ========================================
    // QUICK SEARCH COMPONENT
    // ========================================
    Alpine.data('quickSearch', () => ({
        open: false,
        query: '',
        results: [],
        loading: false,
        recentSearches: [],

        init() {
            // Load recent searches
            this.recentSearches = JSON.parse(localStorage.getItem('bbt_recent_searches') || '[]');
        },

        async search() {
            if (this.query.length < 2) {
                this.results = [];
                return;
            }

            this.loading = true;

            try {
                // AJAX search
                const response = await fetch(`${bbtAjax.ajaxUrl}?action=bbt_quick_search&query=${encodeURIComponent(this.query)}&nonce=${bbtAjax.nonce}`);
                const data = await response.json();
                this.results = data.results || [];
            } catch (error) {
                console.error('Search error:', error);
                this.results = [];
            }

            this.loading = false;
        },

        selectResult(result) {
            // Save to recent searches
            const recent = this.recentSearches.filter(r => r.id !== result.id);
            recent.unshift(result);
            this.recentSearches = recent.slice(0, 5);
            localStorage.setItem('bbt_recent_searches', JSON.stringify(this.recentSearches));

            // Navigate
            window.location.href = result.url;
        },

        clearRecentSearches() {
            this.recentSearches = [];
            localStorage.removeItem('bbt_recent_searches');
        },

        openSearch() {
            this.open = true;
            this.$nextTick(() => {
                this.$refs.searchInput?.focus();
            });
        },

        closeSearch() {
            this.open = false;
            this.query = '';
            this.results = [];
        }
    }));

    // ========================================
    // TOUR CARD COMPONENT
    // ========================================
    Alpine.data('tourCard', (tourId) => ({
        isWishlisted: false,
        isHovered: false,

        init() {
            const wishlist = JSON.parse(localStorage.getItem('bbt_wishlist') || '[]');
            this.isWishlisted = wishlist.includes(tourId);
        },

        toggleWishlist() {
            let wishlist = JSON.parse(localStorage.getItem('bbt_wishlist') || '[]');

            if (this.isWishlisted) {
                wishlist = wishlist.filter(id => id !== tourId);
                this.isWishlisted = false;
                Alpine.store('toast').show('Removed from wishlist', 'info');
            } else {
                wishlist.push(tourId);
                this.isWishlisted = true;
                Alpine.store('toast').show('Added to wishlist ❤️', 'success');
            }

            localStorage.setItem('bbt_wishlist', JSON.stringify(wishlist));

            // Update bottom nav count
            this.$dispatch('wishlist-updated', { count: wishlist.length });
        }
    }));

    // ========================================
    // FLOATING CHECKOUT COMPONENT
    // ========================================
    Alpine.data('floatingCheckout', (config) => ({
        visible: false,
        modalOpen: false,
        step: 1,
        loading: false,
        bookingId: '',
        successMessage: '',
        whatsappUrl: '',

        // Config
        tourId: config.tourId,
        tourName: config.tourName,
        basePrice: config.basePrice,
        basePersons: config.basePersons || 2,
        additionalPercent: config.additionalPercent || 30,

        // Form data
        form: {
            date: '',
            persons: 2,
            name: '',
            email: '',
            phone: '',
            notes: ''
        },

        init() {
            this.form.persons = this.basePersons;
            // Show after small delay
            setTimeout(() => {
                this.checkScroll();
            }, 1000);
        },

        checkScroll() {
            // Show when user scrolls past 300px
            this.visible = window.scrollY > 300;
        },

        get totalPrice() {
            const extra = Math.max(0, this.form.persons - this.basePersons);
            const additionalCost = this.basePrice * (this.additionalPercent / 100) * extra;
            return this.basePrice + additionalCost;
        },

        get additionalCost() {
            const extra = Math.max(0, this.form.persons - this.basePersons);
            return this.basePrice * (this.additionalPercent / 100) * extra;
        },

        get formattedPrice() {
            return this.formatPrice(this.basePrice);
        },

        formatPrice(amount) {
            return 'Rp ' + new Intl.NumberFormat('id-ID').format(amount);
        },

        incrementPersons() {
            if (this.form.persons < 20) {
                this.form.persons++;
            }
        },

        decrementPersons() {
            if (this.form.persons > 1) {
                this.form.persons--;
            }
        },

        openModal() {
            this.modalOpen = true;
            this.step = 1;
            document.body.style.overflow = 'hidden';
        },

        closeModal() {
            this.modalOpen = false;
            document.body.style.overflow = '';
            // Reset form if not completed
            if (this.step !== 3) {
                this.step = 1;
            }
        },

        nextStep() {
            if (this.step < 3) {
                this.step++;
            }
        },

        prevStep() {
            if (this.step > 1) {
                this.step--;
            }
        },

        async submitBooking() {
            this.loading = true;

            try {
                const formData = new FormData();
                formData.append('action', 'bbt_process_booking');
                formData.append('nonce', bbtAjax.nonce);
                formData.append('tour_id', this.tourId);
                formData.append('customer_name', this.form.name);
                formData.append('customer_email', this.form.email);
                formData.append('customer_phone', this.form.phone);
                formData.append('booking_date', this.form.date);
                formData.append('num_persons', this.form.persons);
                formData.append('notes', this.form.notes);

                const response = await fetch(bbtAjax.ajaxUrl, {
                    method: 'POST',
                    body: formData
                });

                const result = await response.json();

                if (result.success) {
                    this.bookingId = result.data.booking_id;
                    this.successMessage = result.data.message;
                    this.whatsappUrl = result.data.whatsapp_url;
                    this.step = 3;
                    Alpine.store('toast').show('Booking confirmed! 🎉', 'success');
                } else {
                    Alpine.store('toast').show('Booking failed. Please try again.', 'error');
                }
            } catch (error) {
                console.error('Booking error:', error);
                Alpine.store('toast').show('Something went wrong. Please try again.', 'error');
            }

            this.loading = false;
        }
    }));

});

// ========================================
// GSAP ANIMATIONS
// ========================================
document.addEventListener('DOMContentLoaded', () => {
    if (typeof gsap !== 'undefined' && typeof ScrollTrigger !== 'undefined') {
        gsap.registerPlugin(ScrollTrigger);

        // Hero section animation
        gsap.from('.hero-content', {
            duration: 1.2,
            y: 100,
            opacity: 0,
            ease: 'power3.out'
        });

        // Staggered card animations
        gsap.utils.toArray('.tour-card').forEach((card, i) => {
            gsap.from(card, {
                scrollTrigger: {
                    trigger: card,
                    start: 'top 85%',
                    toggleActions: 'play none none none'
                },
                duration: 0.8,
                y: 60,
                opacity: 0,
                delay: i * 0.1,
                ease: 'power2.out'
            });
        });

        // Section title animations
        gsap.utils.toArray('.section-title').forEach(title => {
            gsap.from(title, {
                scrollTrigger: {
                    trigger: title,
                    start: 'top 90%'
                },
                duration: 1,
                y: 30,
                opacity: 0,
                ease: 'power2.out'
            });
        });

        // Parallax backgrounds
        gsap.utils.toArray('[data-parallax]').forEach(el => {
            gsap.to(el, {
                scrollTrigger: {
                    trigger: el,
                    scrub: true
                },
                y: -100,
                ease: 'none'
            });
        });
    }
});
