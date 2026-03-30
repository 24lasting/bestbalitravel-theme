<?php
/**
 * Elementor CTA Banner Widget
 * Premium Design with Full Customization & Working Countdown
 *
 * @package BestBaliTravel
 */

if (!defined('ABSPATH'))
    exit;

class BBT_Widget_CTA_Banner extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'bbt-cta-banner';
    }
    
    public function get_title()
    {
        return esc_html__('CTA Banner', 'bestbalitravel');
    }
    
    public function get_icon()
    {
        return 'eicon-call-to-action';
    }
    
    public function get_categories()
    {
        return ['bbt-widgets'];
    }

    protected function register_controls()
    {
        // ============================================
        // CONTENT TAB
        // ============================================
        $this->start_controls_section('section_content', [
            'label' => esc_html__('Content', 'bestbalitravel'),
            'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
        ]);

        $this->add_control('title', [
            'label' => esc_html__('Title', 'bestbalitravel'),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => 'Ready for Your Bali Adventure?',
            'label_block' => true,
            'dynamic' => ['active' => true],
        ]);

        $this->add_control('subtitle', [
            'label' => esc_html__('Subtitle', 'bestbalitravel'),
            'type' => \Elementor\Controls_Manager::TEXTAREA,
            'default' => 'Book now and get 15% off your first tour!',
            'dynamic' => ['active' => true],
        ]);

        $this->add_control('button_text', [
            'label' => esc_html__('Button Text', 'bestbalitravel'),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => 'Book Now',
        ]);

        $this->add_control('button_link', [
            'label' => esc_html__('Button Link', 'bestbalitravel'),
            'type' => \Elementor\Controls_Manager::URL,
            'placeholder' => 'https://your-link.com',
        ]);

        $this->add_control('background', [
            'label' => esc_html__('Background Image', 'bestbalitravel'),
            'type' => \Elementor\Controls_Manager::MEDIA,
        ]);

        $this->end_controls_section();

        // ============================================
        // COUNTDOWN SECTION
        // ============================================
        $this->start_controls_section('section_countdown', [
            'label' => esc_html__('Countdown Timer', 'bestbalitravel'),
            'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
        ]);

        $this->add_control('show_countdown', [
            'label' => esc_html__('Show Countdown', 'bestbalitravel'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'default' => '',
        ]);

        $this->add_control('countdown_date', [
            'label' => esc_html__('End Date & Time', 'bestbalitravel'),
            'type' => \Elementor\Controls_Manager::DATE_TIME,
            'default' => date('Y-m-d H:i', strtotime('+7 days')),
            'condition' => ['show_countdown' => 'yes'],
            'description' => esc_html__('Set the countdown end date and time', 'bestbalitravel'),
        ]);

        $this->add_control('countdown_label_days', [
            'label' => esc_html__('Days Label', 'bestbalitravel'),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => 'Days',
            'condition' => ['show_countdown' => 'yes'],
        ]);

        $this->add_control('countdown_label_hours', [
            'label' => esc_html__('Hours Label', 'bestbalitravel'),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => 'Hours',
            'condition' => ['show_countdown' => 'yes'],
        ]);

        $this->add_control('countdown_label_minutes', [
            'label' => esc_html__('Minutes Label', 'bestbalitravel'),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => 'Minutes',
            'condition' => ['show_countdown' => 'yes'],
        ]);

        $this->add_control('countdown_label_seconds', [
            'label' => esc_html__('Seconds Label', 'bestbalitravel'),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => 'Seconds',
            'condition' => ['show_countdown' => 'yes'],
        ]);

        $this->end_controls_section();

        // ============================================
        // STYLE TAB - Title
        // ============================================
        $this->start_controls_section('section_style_title', [
            'label' => esc_html__('Title Style', 'bestbalitravel'),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control('title_color', [
            'label' => esc_html__('Title Color', 'bestbalitravel'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#ffffff',
            'selectors' => [
                '{{WRAPPER}} .bbt-cta-title' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label' => esc_html__('Title Typography', 'bestbalitravel'),
                'selector' => '{{WRAPPER}} .bbt-cta-title',
            ]
        );

        $this->end_controls_section();

        // ============================================
        // STYLE TAB - Subtitle
        // ============================================
        $this->start_controls_section('section_style_subtitle', [
            'label' => esc_html__('Subtitle Style', 'bestbalitravel'),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control('subtitle_color', [
            'label' => esc_html__('Subtitle Color', 'bestbalitravel'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => 'rgba(255,255,255,0.85)',
            'selectors' => [
                '{{WRAPPER}} .bbt-cta-subtitle' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'subtitle_typography',
                'label' => esc_html__('Subtitle Typography', 'bestbalitravel'),
                'selector' => '{{WRAPPER}} .bbt-cta-subtitle',
            ]
        );

        $this->end_controls_section();

        // ============================================
        // STYLE TAB - Button
        // ============================================
        $this->start_controls_section('section_style_button', [
            'label' => esc_html__('Button Style', 'bestbalitravel'),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control('button_bg_color', [
            'label' => esc_html__('Button Background', 'bestbalitravel'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#f59e0b',
            'selectors' => [
                '{{WRAPPER}} .bbt-cta-button' => 'background: {{VALUE}};',
            ],
        ]);

        $this->add_control('button_text_color', [
            'label' => esc_html__('Button Text Color', 'bestbalitravel'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#000000',
            'selectors' => [
                '{{WRAPPER}} .bbt-cta-button' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'button_typography',
                'label' => esc_html__('Button Typography', 'bestbalitravel'),
                'selector' => '{{WRAPPER}} .bbt-cta-button',
            ]
        );

        $this->add_control('button_border_radius', [
            'label' => esc_html__('Border Radius', 'bestbalitravel'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range' => ['px' => ['min' => 0, 'max' => 50]],
            'default' => ['size' => 50, 'unit' => 'px'],
            'selectors' => [
                '{{WRAPPER}} .bbt-cta-button' => 'border-radius: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->end_controls_section();

        // ============================================
        // STYLE TAB - Countdown
        // ============================================
        $this->start_controls_section('section_style_countdown', [
            'label' => esc_html__('Countdown Style', 'bestbalitravel'),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            'condition' => ['show_countdown' => 'yes'],
        ]);

        $this->add_control('countdown_number_color', [
            'label' => esc_html__('Number Color', 'bestbalitravel'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#f59e0b',
            'selectors' => [
                '{{WRAPPER}} .bbt-countdown-item span' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_control('countdown_label_color', [
            'label' => esc_html__('Label Color', 'bestbalitravel'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => 'rgba(255,255,255,0.7)',
            'selectors' => [
                '{{WRAPPER}} .bbt-countdown-item small' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_control('countdown_bg_color', [
            'label' => esc_html__('Box Background', 'bestbalitravel'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => 'rgba(255,255,255,0.1)',
            'selectors' => [
                '{{WRAPPER}} .bbt-countdown-item' => 'background: {{VALUE}};',
            ],
        ]);

        $this->end_controls_section();

        // ============================================
        // STYLE TAB - Background
        // ============================================
        $this->start_controls_section('section_style_background', [
            'label' => esc_html__('Background Style', 'bestbalitravel'),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control('bg_overlay_color', [
            'label' => esc_html__('Overlay Color', 'bestbalitravel'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => 'rgba(0,0,0,0.6)',
            'selectors' => [
                '{{WRAPPER}} .bbt-cta-overlay' => 'background: {{VALUE}};',
            ],
        ]);

        $this->add_control('banner_padding', [
            'label' => esc_html__('Padding', 'bestbalitravel'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em'],
            'default' => [
                'top' => '80',
                'right' => '60',
                'bottom' => '80',
                'left' => '60',
                'unit' => 'px',
            ],
            'selectors' => [
                '{{WRAPPER}} .bbt-cta-banner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->add_control('banner_border_radius', [
            'label' => esc_html__('Border Radius', 'bestbalitravel'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range' => ['px' => ['min' => 0, 'max' => 100]],
            'default' => ['size' => 32, 'unit' => 'px'],
            'selectors' => [
                '{{WRAPPER}} .bbt-cta-banner' => 'border-radius: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->end_controls_section();
    }

    protected function render()
    {
        $s = $this->get_settings_for_display();
        $bg = !empty($s['background']['url']) ? $s['background']['url'] : 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=1600';
        $link = !empty($s['button_link']['url']) ? $s['button_link']['url'] : '#';
        $widget_id = 'cta-' . $this->get_id();
        
        // Parse countdown date
        $countdown_timestamp = 0;
        if ($s['show_countdown'] === 'yes' && !empty($s['countdown_date'])) {
            $countdown_timestamp = strtotime($s['countdown_date']) * 1000; // Convert to milliseconds for JS
        }
        ?>
        
        <div class="bbt-cta-banner" id="<?php echo esc_attr($widget_id); ?>">
            <!-- Background -->
            <div class="bbt-cta-bg" style="background-image:url('<?php echo esc_url($bg); ?>')"></div>
            <div class="bbt-cta-overlay"></div>

            <!-- Content -->
            <div class="bbt-cta-content">
                <h2 class="bbt-cta-title"><?php echo esc_html($s['title']); ?></h2>
                <p class="bbt-cta-subtitle"><?php echo esc_html($s['subtitle']); ?></p>

                <?php if ($s['show_countdown'] === 'yes' && $countdown_timestamp > 0): ?>
                <div class="bbt-cta-countdown" id="<?php echo esc_attr($widget_id); ?>-countdown" data-end="<?php echo esc_attr($countdown_timestamp); ?>">
                    <div class="bbt-countdown-item">
                        <span class="countdown-days">00</span>
                        <small><?php echo esc_html($s['countdown_label_days']); ?></small>
                    </div>
                    <div class="bbt-countdown-item">
                        <span class="countdown-hours">00</span>
                        <small><?php echo esc_html($s['countdown_label_hours']); ?></small>
                    </div>
                    <div class="bbt-countdown-item">
                        <span class="countdown-minutes">00</span>
                        <small><?php echo esc_html($s['countdown_label_minutes']); ?></small>
                    </div>
                    <div class="bbt-countdown-item">
                        <span class="countdown-seconds">00</span>
                        <small><?php echo esc_html($s['countdown_label_seconds']); ?></small>
                    </div>
                </div>
                
                <!-- Countdown JavaScript -->
                <script>
                (function() {
                    const countdownEl = document.getElementById('<?php echo esc_js($widget_id); ?>-countdown');
                    if (!countdownEl) return;
                    
                    const endTime = parseInt(countdownEl.getAttribute('data-end'));
                    if (!endTime || isNaN(endTime)) return;
                    
                    function updateCountdown() {
                        const now = Date.now();
                        const diff = endTime - now;
                        
                        if (diff <= 0) {
                            countdownEl.innerHTML = '<div class="bbt-countdown-expired">Offer Expired!</div>';
                            return;
                        }
                        
                        const days = Math.floor(diff / (1000 * 60 * 60 * 24));
                        const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                        const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                        const seconds = Math.floor((diff % (1000 * 60)) / 1000);
                        
                        const daysEl = countdownEl.querySelector('.countdown-days');
                        const hoursEl = countdownEl.querySelector('.countdown-hours');
                        const minutesEl = countdownEl.querySelector('.countdown-minutes');
                        const secondsEl = countdownEl.querySelector('.countdown-seconds');
                        
                        if (daysEl) daysEl.textContent = String(days).padStart(2, '0');
                        if (hoursEl) hoursEl.textContent = String(hours).padStart(2, '0');
                        if (minutesEl) minutesEl.textContent = String(minutes).padStart(2, '0');
                        if (secondsEl) secondsEl.textContent = String(seconds).padStart(2, '0');
                    }
                    
                    // Update immediately
                    updateCountdown();
                    
                    // Update every second
                    setInterval(updateCountdown, 1000);
                })();
                </script>
                <?php endif; ?>

                <a href="<?php echo esc_url($link); ?>" class="bbt-cta-button">
                    <?php echo esc_html($s['button_text']); ?>
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <path d="M5 12h14M12 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
        </div>
        
        <style>
            .bbt-cta-banner {
                position: relative;
                overflow: hidden;
                text-align: center;
            }
            .bbt-cta-bg {
                position: absolute;
                inset: 0;
                background-size: cover;
                background-position: center;
                animation: bbtCtaZoom 20s ease infinite alternate;
            }
            @keyframes bbtCtaZoom {
                0% { transform: scale(1); }
                100% { transform: scale(1.1); }
            }
            .bbt-cta-overlay {
                position: absolute;
                inset: 0;
            }
            .bbt-cta-content {
                position: relative;
                z-index: 2;
                max-width: 700px;
                margin: 0 auto;
            }
            .bbt-cta-title {
                font-size: clamp(28px, 5vw, 48px);
                font-weight: 800;
                margin: 0 0 15px;
                line-height: 1.2;
            }
            .bbt-cta-subtitle {
                font-size: 18px;
                margin: 0 0 30px;
                line-height: 1.6;
            }
            .bbt-cta-countdown {
                display: flex;
                justify-content: center;
                gap: 15px;
                margin-bottom: 30px;
                flex-wrap: wrap;
            }
            .bbt-countdown-item {
                padding: 20px 25px;
                border-radius: 16px;
                min-width: 90px;
                text-align: center;
            }
            .bbt-countdown-item span {
                display: block;
                font-size: 36px;
                font-weight: 800;
                line-height: 1;
                font-variant-numeric: tabular-nums;
            }
            .bbt-countdown-item small {
                display: block;
                font-size: 12px;
                margin-top: 8px;
                text-transform: uppercase;
                letter-spacing: 1px;
            }
            .bbt-countdown-expired {
                font-size: 24px;
                font-weight: 700;
                color: #ef4444;
                padding: 20px;
            }
            .bbt-cta-button {
                display: inline-flex;
                align-items: center;
                gap: 10px;
                padding: 18px 40px;
                text-decoration: none;
                font-weight: 700;
                transition: all 0.3s ease;
            }
            .bbt-cta-button:hover {
                transform: translateY(-3px) scale(1.05);
                box-shadow: 0 20px 40px rgba(0,0,0,0.3);
            }
            .bbt-cta-button svg {
                transition: transform 0.3s;
            }
            .bbt-cta-button:hover svg {
                transform: translateX(5px);
            }
            @media(max-width:768px) {
                .bbt-countdown-item {
                    padding: 15px 20px;
                    min-width: 70px;
                }
                .bbt-countdown-item span {
                    font-size: 28px;
                }
            }
        </style>
        <?php
    }
}
