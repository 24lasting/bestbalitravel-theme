/**
 * Best Bali Travel Main JavaScript
 *
 * @package BestBaliTravel
 */

(function ($) {
    'use strict';

    // ========================================
    // Mobile Menu
    // ========================================
    const mobileMenu = {
        init: function () {
            const menuToggle = $('.mobile-menu-toggle');
            const menuClose = $('.mobile-menu-close');
            const mobileMenu = $('#mobile-menu');
            const body = $('body');

            menuToggle.on('click', function () {
                mobileMenu.addClass('active');
                body.addClass('menu-open');
            });

            menuClose.on('click', function () {
                mobileMenu.removeClass('active');
                body.removeClass('menu-open');
            });

            // Close on outside click
            $(document).on('click', function (e) {
                if (!$(e.target).closest('#mobile-menu, .mobile-menu-toggle').length) {
                    mobileMenu.removeClass('active');
                    body.removeClass('menu-open');
                }
            });
        }
    };

    // ========================================
    // Search Overlay
    // ========================================
    const searchOverlay = {
        init: function () {
            const searchToggle = $('.header-search-toggle');
            const searchClose = $('.search-close');
            const overlay = $('#search-overlay');

            searchToggle.on('click', function () {
                overlay.addClass('active');
                overlay.find('.search-field').focus();
            });

            searchClose.on('click', function () {
                overlay.removeClass('active');
            });

            // Close on Escape key
            $(document).on('keydown', function (e) {
                if (e.key === 'Escape') {
                    overlay.removeClass('active');
                }
            });
        }
    };

    // ========================================
    // Language & Currency Dropdowns
    // ========================================
    const dropdowns = {
        init: function () {
            $('.lang-toggle, .currency-toggle').on('click', function (e) {
                e.stopPropagation();
                $(this).parent().toggleClass('active');
            });

            $(document).on('click', function () {
                $('.language-selector, .currency-selector').removeClass('active');
            });
        }
    };

    // ========================================
    // Sticky Header
    // ========================================
    const stickyHeader = {
        init: function () {
            const header = $('.site-header');
            let lastScroll = 0;

            $(window).on('scroll', function () {
                const currentScroll = $(window).scrollTop();

                if (currentScroll > 100) {
                    header.addClass('scrolled');
                } else {
                    header.removeClass('scrolled');
                }

                if (currentScroll > lastScroll && currentScroll > 200) {
                    header.addClass('header-hidden');
                } else {
                    header.removeClass('header-hidden');
                }

                lastScroll = currentScroll;
            });
        }
    };

    // ========================================
    // Date Picker (Flatpickr)
    // ========================================
    const datePicker = {
        init: function () {
            if (typeof flatpickr !== 'undefined') {
                flatpickr('.bbt-datepicker', {
                    minDate: 'today',
                    dateFormat: 'Y-m-d',
                    disableMobile: true,
                    onChange: function (selectedDates, dateStr) {
                        // Trigger price update
                        bookingWidget.updateTotal();
                    }
                });
            }
        }
    };

    // ========================================
    // Tour Gallery (Swiper)
    // ========================================
    const tourGallery = {
        init: function () {
            if (typeof Swiper !== 'undefined' && $('.bbt-gallery-main').length) {
                const thumbsSwiper = new Swiper('.bbt-gallery-thumbs', {
                    slidesPerView: 5,
                    spaceBetween: 10,
                    freeMode: true,
                    watchSlidesProgress: true,
                    breakpoints: {
                        320: { slidesPerView: 3 },
                        768: { slidesPerView: 4 },
                        1024: { slidesPerView: 5 }
                    }
                });

                new Swiper('.bbt-gallery-main', {
                    spaceBetween: 10,
                    navigation: {
                        nextEl: '.swiper-button-next',
                        prevEl: '.swiper-button-prev'
                    },
                    thumbs: {
                        swiper: thumbsSwiper
                    }
                });
            }
        }
    };

    // ========================================
    // Booking Widget
    // ========================================
    const bookingWidget = {
        init: function () {
            const self = this;

            // Quantity controls
            $('.bbt-qty-btn').on('click', function () {
                const target = $(this).data('target');
                const input = $('#' + target);
                let value = parseInt(input.val());
                const min = parseInt(input.attr('min'));
                const max = parseInt(input.attr('max'));

                if ($(this).hasClass('bbt-qty-plus')) {
                    if (value < max) value++;
                } else {
                    if (value > min) value--;
                }

                input.val(value);
                self.updateTotal();
            });

            // Add to cart
            $('#bbt-add-to-cart').on('click', function () {
                self.addToCart(false);
            });

            // Book now
            $('#bbt-booking-form').on('submit', function (e) {
                e.preventDefault();
                self.addToCart(true);
            });
        },

        updateTotal: function () {
            const form = $('#bbt-booking-form');
            const price = parseFloat(form.find('input[name="tour_price"]').val()) || 0;
            const adults = parseInt(form.find('#adults').val()) || 1;
            const children = parseInt(form.find('#children').val()) || 0;
            const total = price * (adults + children);

            $('#bbt-total-amount').text(this.formatPrice(total));
        },

        formatPrice: function (amount) {
            return 'Rp ' + amount.toLocaleString('id-ID');
        },

        addToCart: function (redirect) {
            const form = $('#bbt-booking-form');
            const button = redirect ? form.find('button[type="submit"]') : $('#bbt-add-to-cart');
            const originalText = button.html();

            button.prop('disabled', true).html('<span class="loading"></span>');

            $.ajax({
                url: bbtAjax.ajaxUrl,
                type: 'POST',
                data: {
                    action: 'bbt_add_to_cart',
                    nonce: bbtAjax.nonce,
                    tour_id: form.find('input[name="tour_id"]').val(),
                    tour_date: form.find('input[name="tour_date"]').val(),
                    adults: form.find('#adults').val(),
                    children: form.find('#children').val()
                },
                success: function (response) {
                    if (response.success) {
                        // Update cart count
                        $('.cart-count').text(response.data.cart_count);

                        if (redirect) {
                            window.location.href = response.data.cart_url;
                        } else {
                            // Show success message
                            button.html('✓ ' + bbtAjax.addedText || 'Added!');
                            setTimeout(function () {
                                button.prop('disabled', false).html(originalText);
                            }, 2000);
                        }
                    } else {
                        alert(response.data.message || 'Error adding to cart');
                        button.prop('disabled', false).html(originalText);
                    }
                },
                error: function () {
                    alert('Error. Please try again.');
                    button.prop('disabled', false).html(originalText);
                }
            });
        }
    };

    // ========================================
    // Tour Tabs
    // ========================================
    const tourTabs = {
        init: function () {
            $('.bbt-tab-link').on('click', function (e) {
                e.preventDefault();

                const tab = $(this).data('tab');

                // Update nav
                $('.bbt-tab-link').removeClass('active');
                $(this).addClass('active');

                // Update content
                $('.bbt-tab-panel').removeClass('active');
                $('#' + tab).addClass('active');

                // Scroll to tabs on mobile
                if ($(window).width() < 768) {
                    $('html, body').animate({
                        scrollTop: $('.bbt-tour-tabs').offset().top - 80
                    }, 300);
                }
            });
        }
    };

    // ========================================
    // FAQ Accordion
    // ========================================
    const faqAccordion = {
        init: function () {
            $('.bbt-faq-question').on('click', function () {
                const item = $(this).parent();
                const wasActive = item.hasClass('active');

                // Close all
                $('.bbt-faq-item').removeClass('active');

                // Toggle current
                if (!wasActive) {
                    item.addClass('active');
                }
            });
        }
    };

    // ========================================
    // Tour Filters
    // ========================================
    const tourFilters = {
        init: function () {
            const self = this;

            // Filter toggle (mobile)
            $('#bbt-filter-toggle').on('click', function () {
                $('.bbt-filters-sidebar').toggleClass('active');
            });

            // Sort select
            $('#bbt-sort-select').on('change', function () {
                self.filterTours();
            });

            // Filter form submit
            $('#bbt-filters-form').on('submit', function (e) {
                e.preventDefault();
                self.filterTours();
            });

            // Clear filters
            $('#bbt-clear-filters').on('click', function () {
                $('#bbt-filters-form')[0].reset();
                self.filterTours();
            });

            // View toggle
            $('.bbt-view-btn').on('click', function () {
                const view = $(this).data('view');
                $('.bbt-view-btn').removeClass('active');
                $(this).addClass('active');
                $('#bbt-tours-grid').attr('data-view', view);
            });
        },

        filterTours: function () {
            const form = $('#bbt-filters-form');
            const grid = $('#bbt-tours-grid');

            grid.addClass('loading');

            $.ajax({
                url: bbtAjax.ajaxUrl,
                type: 'POST',
                data: {
                    action: 'bbt_filter_tours',
                    nonce: bbtAjax.nonce,
                    location: form.find('input[name="location[]"]:checked').map(function () { return this.value; }).get().join(','),
                    type: form.find('input[name="type[]"]:checked').map(function () { return this.value; }).get().join(','),
                    duration: form.find('input[name="duration[]"]:checked').map(function () { return this.value; }).get().join(','),
                    min_price: form.find('input[name="min_price"]').val(),
                    max_price: form.find('input[name="max_price"]').val(),
                    orderby: $('#bbt-sort-select').val()
                },
                success: function (response) {
                    grid.removeClass('loading');
                    if (response.success) {
                        grid.html(response.data.html);
                        $('.bbt-tours-count').text(response.data.found + ' tours found');
                    }
                },
                error: function () {
                    grid.removeClass('loading');
                }
            });
        }
    };

    // ========================================
    // Newsletter
    // ========================================
    const newsletter = {
        init: function () {
            $('#bbt-newsletter-form').on('submit', function (e) {
                e.preventDefault();

                const form = $(this);
                const button = form.find('button');
                const message = form.find('.bbt-newsletter-message');
                const email = form.find('input[name="email"]').val();

                button.prop('disabled', true);

                $.ajax({
                    url: bbtAjax.ajaxUrl,
                    type: 'POST',
                    data: {
                        action: 'bbt_newsletter_subscribe',
                        nonce: bbtAjax.nonce,
                        email: email
                    },
                    success: function (response) {
                        button.prop('disabled', false);
                        if (response.success) {
                            message.html('<span class="success">' + response.data.message + '</span>');
                            form.find('input[name="email"]').val('');
                        } else {
                            message.html('<span class="error">' + response.data.message + '</span>');
                        }
                    },
                    error: function () {
                        button.prop('disabled', false);
                        message.html('<span class="error">Error. Please try again.</span>');
                    }
                });
            });
        }
    };

    // ========================================
    // Initialize
    // ========================================
    $(document).ready(function () {
        mobileMenu.init();
        searchOverlay.init();
        dropdowns.init();
        stickyHeader.init();
        datePicker.init();
        tourGallery.init();
        bookingWidget.init();
        tourTabs.init();
        faqAccordion.init();
        tourFilters.init();
        newsletter.init();
    });

})(jQuery);
