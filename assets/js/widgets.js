/**
 * Best Bali Travel - Frontend JavaScript
 * Handles widgets interactions, animations, and AJAX
 * 
 * @package BestBaliTravel
 */

(function ($) {
    'use strict';

    // Initialize when DOM is ready
    $(document).ready(function () {
        BBT.init();
    });

    // Main BBT Object
    var BBT = {
        init: function () {
            this.initCountdowns();
            this.initStatsCounters();
            this.initGuestCounters();
            this.initCurrencySwitcher();
            this.initNewsletterForms();
            this.initLightbox();
            this.initSwiperCarousels();
            this.initBookingWidget();
        },

        // ========================================
        // COUNTDOWN TIMERS
        // ========================================
        initCountdowns: function () {
            $('.bbt-countdown-widget').each(function () {
                var $widget = $(this);
                var config = $widget.data('countdown');

                if (!config || !config.dueDate) return;

                BBT.updateCountdown($widget, config);

                setInterval(function () {
                    BBT.updateCountdown($widget, config);
                }, 1000);
            });
        },

        updateCountdown: function ($widget, config) {
            var now = new Date().getTime();
            var distance = config.dueDate - now;

            if (distance < 0) {
                // Countdown expired
                if (config.expireAction === 'hide') {
                    $widget.fadeOut();
                } else if (config.expireAction === 'message') {
                    $widget.find('.bbt-countdown-timer').hide();
                    $widget.find('.bbt-countdown-expired').show();
                }
                return;
            }

            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

            $widget.find('[data-type="days"]').text(BBT.pad(days));
            $widget.find('[data-type="hours"]').text(BBT.pad(hours));
            $widget.find('[data-type="minutes"]').text(BBT.pad(minutes));
            $widget.find('[data-type="seconds"]').text(BBT.pad(seconds));
        },

        pad: function (num) {
            return num < 10 ? '0' + num : num;
        },

        // ========================================
        // STATS COUNTER ANIMATION
        // ========================================
        initStatsCounters: function () {
            var $counters = $('.bbt-stats-counter');

            if (!$counters.length) return;

            var observer = new IntersectionObserver(function (entries) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        BBT.animateCounters($(entry.target));
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.3 });

            $counters.each(function () {
                observer.observe(this);
            });
        },

        animateCounters: function ($container) {
            var duration = parseInt($container.data('duration')) || 2000;

            $container.find('.bbt-stat-number').each(function () {
                var $number = $(this);
                var target = parseInt($number.data('target')) || 0;
                var suffix = $number.text().replace(/[0-9]/g, '').trim();

                $({ count: 0 }).animate({ count: target }, {
                    duration: duration,
                    easing: 'swing',
                    step: function () {
                        $number.text(Math.floor(this.count).toLocaleString() + suffix);
                    },
                    complete: function () {
                        $number.text(target.toLocaleString() + suffix);
                    }
                });
            });
        },

        // ========================================
        // GUEST COUNTERS (Booking Widget)
        // ========================================
        initGuestCounters: function () {
            $(document).on('click', '.bbt-counter-btn', function (e) {
                e.preventDefault();

                var $btn = $(this);
                var $input = $btn.siblings('.bbt-counter-input');
                var currentVal = parseInt($input.val()) || 0;
                var min = parseInt($input.attr('min')) || 0;
                var max = parseInt($input.attr('max')) || 99;

                if ($btn.hasClass('bbt-plus') && currentVal < max) {
                    $input.val(currentVal + 1);
                } else if ($btn.hasClass('bbt-minus') && currentVal > min) {
                    $input.val(currentVal - 1);
                }

                // Trigger price update
                $input.trigger('change');
            });
        },

        // ========================================
        // CURRENCY SWITCHER
        // ========================================
        initCurrencySwitcher: function () {
            var $switcher = $('.bbt-currency-switcher');
            if (!$switcher.length) return;

            // Toggle dropdown
            $switcher.on('click', '.bbt-currency-toggle', function (e) {
                e.stopPropagation();
                var $dropdown = $switcher.find('.bbt-currency-dropdown');
                $dropdown.toggleClass('active');
                $(this).attr('aria-expanded', $dropdown.hasClass('active'));
            });

            // Select currency
            $switcher.on('click', '.bbt-currency-option', function (e) {
                e.preventDefault();
                var currency = $(this).data('currency');

                $.ajax({
                    url: bbtAjax.ajaxUrl,
                    type: 'POST',
                    data: {
                        action: 'bbt_switch_currency',
                        nonce: bbtAjax.nonce,
                        currency: currency
                    },
                    success: function (response) {
                        if (response.success) {
                            location.reload();
                        }
                    }
                });
            });

            // Close on outside click
            $(document).on('click', function () {
                $switcher.find('.bbt-currency-dropdown').removeClass('active');
            });
        },

        // ========================================
        // NEWSLETTER FORMS
        // ========================================
        initNewsletterForms: function () {
            $(document).on('submit', '.bbt-newsletter-form', function (e) {
                e.preventDefault();

                var $form = $(this);
                var $btn = $form.find('.bbt-newsletter-btn');
                var $message = $form.find('.bbt-newsletter-message');
                var email = $form.find('input[type="email"]').val();

                // Show loading
                $btn.addClass('loading');

                $.ajax({
                    url: bbtAjax.ajaxUrl,
                    type: 'POST',
                    data: {
                        action: 'bbt_subscribe_newsletter',
                        nonce: $form.find('#bbt_newsletter_nonce').val(),
                        email: email
                    },
                    success: function (response) {
                        $btn.removeClass('loading');

                        if (response.success) {
                            $message.html('<span class="success">✓ ' + response.data.message + '</span>');
                            $form.find('input[type="email"]').val('');
                        } else {
                            $message.html('<span class="error">' + response.data.message + '</span>');
                        }
                    },
                    error: function () {
                        $btn.removeClass('loading');
                        $message.html('<span class="error">An error occurred. Please try again.</span>');
                    }
                });
            });
        },

        // ========================================
        // LIGHTBOX
        // ========================================
        initLightbox: function () {
            $(document).on('click', '.bbt-lightbox-trigger', function (e) {
                e.preventDefault();

                var $trigger = $(this);
                var imageUrl = $trigger.attr('href');
                var caption = $trigger.data('caption') || '';
                var galleryId = $trigger.data('gallery');

                // Create lightbox
                var $lightbox = $('<div class="bbt-lightbox">' +
                    '<div class="bbt-lightbox-overlay"></div>' +
                    '<div class="bbt-lightbox-content">' +
                    '<button class="bbt-lightbox-close">&times;</button>' +
                    '<img src="' + imageUrl + '" alt="">' +
                    (caption ? '<div class="bbt-lightbox-caption">' + caption + '</div>' : '') +
                    '</div>' +
                    '</div>');

                $('body').append($lightbox).addClass('bbt-lightbox-open');

                setTimeout(function () {
                    $lightbox.addClass('active');
                }, 10);
            });

            // Close lightbox
            $(document).on('click', '.bbt-lightbox-close, .bbt-lightbox-overlay', function () {
                var $lightbox = $('.bbt-lightbox');
                $lightbox.removeClass('active');

                setTimeout(function () {
                    $lightbox.remove();
                    $('body').removeClass('bbt-lightbox-open');
                }, 300);
            });

            // ESC key
            $(document).on('keydown', function (e) {
                if (e.key === 'Escape' && $('.bbt-lightbox').length) {
                    $('.bbt-lightbox-close').click();
                }
            });
        },

        // ========================================
        // SWIPER CAROUSELS
        // ========================================
        initSwiperCarousels: function () {
            if (typeof Swiper === 'undefined') return;

            $('[data-swiper]').each(function () {
                var $slider = $(this);
                var config = $slider.data('swiper');

                new Swiper($slider[0], config);
            });
        },

        // ========================================
        // BOOKING WIDGET
        // ========================================
        initBookingWidget: function () {
            var $widget = $('.bbt-booking-widget');
            if (!$widget.length) return;

            // Update price on input change
            $widget.on('change', 'input[name="adults"], input[name="children"]', function () {
                BBT.updateBookingPrice($widget);
            });

            // Form submission
            $widget.on('submit', '.bbt-booking-form', function (e) {
                e.preventDefault();

                var $form = $(this);
                var $btn = $form.find('.bbt-booking-btn');

                // Validate
                if (!$form.find('input[name="tour_date"]').val()) {
                    alert('Please select a date');
                    return;
                }

                // Show loading
                $btn.prop('disabled', true).addClass('loading');

                // Collect data
                var data = {
                    action: 'bbt_process_booking',
                    nonce: bbtAjax.nonce,
                    tour_id: $form.find('[name="tour_id"]').val(),
                    tour_title: $form.find('[name="tour_title"]').val(),
                    tour_date: $form.find('[name="tour_date"]').val(),
                    adults: $form.find('[name="adults"]').val(),
                    children: $form.find('[name="children"]').val()
                };

                // Redirect to checkout or show modal
                window.location.href = bbtAjax.checkoutUrl + '?' + $.param(data);
            });
        },

        updateBookingPrice: function ($widget) {
            var adults = parseInt($widget.find('[name="adults"]').val()) || 0;
            var children = parseInt($widget.find('[name="children"]').val()) || 0;
            var adultPrice = parseFloat($widget.find('[name="adult_price"]').val()) || 0;
            var childPrice = parseFloat($widget.find('[name="child_price"]').val()) || 0;

            var adultTotal = adults * adultPrice;
            var childTotal = children * childPrice;
            var grandTotal = adultTotal + childTotal;

            // Update display
            $widget.find('.bbt-adult-count').text(adults);
            $widget.find('.bbt-child-count').text(children);

            // Show/hide children row
            if (children > 0) {
                $widget.find('.bbt-children-row').show();
            } else {
                $widget.find('.bbt-children-row').hide();
            }

            // Format and update totals (this is a simplified version)
            $widget.find('.bbt-adult-total').text('Rp ' + adultTotal.toLocaleString());
            $widget.find('.bbt-child-total').text('Rp ' + childTotal.toLocaleString());
            $widget.find('.bbt-grand-total').text('Rp ' + grandTotal.toLocaleString());
        }
    };

    // Make BBT globally accessible
    window.BBT = BBT;

})(jQuery);
