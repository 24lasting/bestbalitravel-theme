/**
 * Single Tour Page JavaScript
 * 
 * Handles tab switching, FAQ accordion, gallery initialization, and booking form
 * 
 * @package BestBaliTravel
 */

(function () {
    'use strict';

    /**
     * Initialize all functionality when DOM is ready
     */
    document.addEventListener('DOMContentLoaded', function () {
        initTabs();
        initFAQ();
        initGallery();
        initQuantityControls();
    });

    /**
     * Tab Navigation
     */
    function initTabs() {
        const tabLinks = document.querySelectorAll('.bbt-tab-link');
        const tabPanels = document.querySelectorAll('.bbt-tab-panel');

        if (!tabLinks.length) return;

        tabLinks.forEach(function (link) {
            link.addEventListener('click', function (e) {
                e.preventDefault();

                const targetId = this.getAttribute('data-tab') || this.getAttribute('href').replace('#', '');

                // Update active tab link
                tabLinks.forEach(function (l) {
                    l.classList.remove('active');
                });
                this.classList.add('active');

                // Update active tab panel
                tabPanels.forEach(function (panel) {
                    panel.classList.remove('active');
                    if (panel.id === targetId) {
                        panel.classList.add('active');
                    }
                });
            });
        });
    }

    /**
     * FAQ Accordion
     */
    function initFAQ() {
        const faqQuestions = document.querySelectorAll('.bbt-faq-question');

        if (!faqQuestions.length) return;

        faqQuestions.forEach(function (question) {
            question.addEventListener('click', function () {
                const faqItem = this.closest('.bbt-faq-item');
                const isActive = faqItem.classList.contains('active');
                const icon = this.querySelector('.bbt-faq-icon');

                // Close all other FAQ items (optional: comment out for multi-open)
                document.querySelectorAll('.bbt-faq-item').forEach(function (item) {
                    item.classList.remove('active');
                    const itemIcon = item.querySelector('.bbt-faq-icon');
                    if (itemIcon) itemIcon.textContent = '+';
                });

                // Toggle current item
                if (!isActive) {
                    faqItem.classList.add('active');
                    if (icon) icon.textContent = '−';
                    this.setAttribute('aria-expanded', 'true');
                } else {
                    this.setAttribute('aria-expanded', 'false');
                }
            });
        });
    }

    /**
     * Gallery with Swiper
     */
    function initGallery() {
        // Check if Swiper is available
        if (typeof Swiper === 'undefined') {
            console.warn('Swiper library not loaded');
            return;
        }

        const thumbsContainer = document.getElementById('tour-gallery-thumbs');
        const mainContainer = document.getElementById('tour-gallery-main');

        if (!mainContainer) return;

        // Initialize thumbnails swiper first
        let galleryThumbs = null;
        if (thumbsContainer) {
            galleryThumbs = new Swiper('#tour-gallery-thumbs', {
                spaceBetween: 10,
                slidesPerView: 4,
                freeMode: true,
                watchSlidesProgress: true,
                breakpoints: {
                    320: {
                        slidesPerView: 3,
                    },
                    640: {
                        slidesPerView: 4,
                    },
                    1024: {
                        slidesPerView: 5,
                    },
                },
            });
        }

        // Initialize main gallery swiper
        new Swiper('#tour-gallery-main', {
            spaceBetween: 10,
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            thumbs: {
                swiper: galleryThumbs,
            },
            loop: true,
            autoplay: {
                delay: 5000,
                disableOnInteraction: true,
            },
        });
    }

    /**
     * Quantity Controls for Booking Widget
     */
    function initQuantityControls() {
        const qtyControls = document.querySelectorAll('.bbt-qty-control');

        qtyControls.forEach(function (control) {
            const minusBtn = control.querySelector('.bbt-qty-minus');
            const plusBtn = control.querySelector('.bbt-qty-plus');
            const input = control.querySelector('.bbt-qty-input');

            if (!minusBtn || !plusBtn || !input) return;

            minusBtn.addEventListener('click', function () {
                let value = parseInt(input.value) || 0;
                const min = parseInt(input.min) || 0;
                if (value > min) {
                    input.value = value - 1;
                    input.dispatchEvent(new Event('change'));
                }
            });

            plusBtn.addEventListener('click', function () {
                let value = parseInt(input.value) || 0;
                const max = parseInt(input.max) || 99;
                if (value < max) {
                    input.value = value + 1;
                    input.dispatchEvent(new Event('change'));
                }
            });
        });

        // Update total when quantities change
        const adultsInput = document.getElementById('adults');
        const childrenInput = document.getElementById('children');
        const totalElement = document.getElementById('bbt-total-amount');
        const priceInput = document.querySelector('input[name="tour_price"]');

        if (adultsInput && totalElement && priceInput) {
            const updateTotal = function () {
                const adults = parseInt(adultsInput.value) || 0;
                const children = childrenInput ? (parseInt(childrenInput.value) || 0) : 0;
                const pricePerPerson = parseFloat(priceInput.value) || 0;

                // Simple calculation - can be enhanced with child pricing
                const total = (adults * pricePerPerson) + (children * pricePerPerson * 0.5);

                // Format as Indonesian Rupiah
                totalElement.textContent = 'Rp ' + total.toLocaleString('id-ID');
            };

            adultsInput.addEventListener('change', updateTotal);
            if (childrenInput) {
                childrenInput.addEventListener('change', updateTotal);
            }
        }
    }

})();
