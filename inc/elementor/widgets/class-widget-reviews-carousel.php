<?php
/**
 * Elementor Customer Reviews Carousel Widget
 * Animated testimonial slider
 *
 * @package BestBaliTravel
 */

if (!defined('ABSPATH')) {
    exit;
}

class BBT_Widget_Reviews_Carousel extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'bbt-reviews-carousel';
    }
    public function get_title()
    {
        return esc_html__('Reviews Carousel', 'bestbalitravel');
    }
    public function get_icon()
    {
        return 'eicon-testimonial-carousel';
    }
    public function get_categories()
    {
        return ['bbt-widgets'];
    }

    protected function register_controls()
    {
        $this->start_controls_section('section_reviews', [
            'label' => esc_html__('Reviews', 'bestbalitravel'),
        ]);

        $repeater = new \Elementor\Repeater();
        $repeater->add_control('name', ['label' => 'Name', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'John Doe']);
        $repeater->add_control('country', ['label' => 'Country', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'USA']);
        $repeater->add_control('rating', ['label' => 'Rating', 'type' => \Elementor\Controls_Manager::NUMBER, 'default' => 5, 'min' => 1, 'max' => 5]);
        $repeater->add_control('review', ['label' => 'Review', 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'Amazing experience!']);
        $repeater->add_control('avatar', ['label' => 'Avatar', 'type' => \Elementor\Controls_Manager::MEDIA]);
        $repeater->add_control('tour', ['label' => 'Tour Name', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Bali Swing Tour']);

        $this->add_control('reviews', [
            'type' => \Elementor\Controls_Manager::REPEATER,
            'fields' => $repeater->get_controls(),
            'default' => [
                ['name' => 'Sarah M.', 'country' => 'Australia', 'rating' => 5, 'review' => 'Absolutely breathtaking! The tour guide was knowledgeable and the views were stunning.', 'tour' => 'Ubud Rice Terrace Tour'],
                ['name' => 'James W.', 'country' => 'UK', 'rating' => 5, 'review' => 'Best day of our Bali trip. Highly recommend!', 'tour' => 'Nusa Penida Day Trip'],
                ['name' => 'Maria S.', 'country' => 'Spain', 'rating' => 5, 'review' => 'Professional service and amazing experience!', 'tour' => 'Temple Sunset Tour'],
            ],
            'title_field' => '{{{ name }}}',
        ]);

        $this->add_control('autoplay', ['label' => 'Autoplay', 'type' => \Elementor\Controls_Manager::SWITCHER, 'default' => 'yes']);

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $id = 'reviews-' . uniqid();
        ?>
        <div class="bbt-reviews-carousel" id="<?php echo $id; ?>">
            <div class="bbt-reviews-track">
                <?php foreach ($settings['reviews'] as $i => $review):
                    $avatar = !empty($review['avatar']['url']) ? $review['avatar']['url'] : 'https://ui-avatars.com/api/?name=' . urlencode($review['name']) . '&background=F5A623&color=fff';
                    ?>
                    <div class="bbt-review-card" style="--delay: <?php echo $i * 0.15; ?>s">
                        <div class="bbt-review-header">
                            <img src="<?php echo esc_url($avatar); ?>" alt="<?php echo esc_attr($review['name']); ?>"
                                class="bbt-review-avatar">
                            <div class="bbt-review-meta">
                                <h4>
                                    <?php echo esc_html($review['name']); ?>
                                </h4>
                                <span class="bbt-review-location">📍
                                    <?php echo esc_html($review['country']); ?>
                                </span>
                            </div>
                            <div class="bbt-review-stars">
                                <?php echo str_repeat('⭐', (int) $review['rating']); ?>
                            </div>
                        </div>
                        <p class="bbt-review-text">"
                            <?php echo esc_html($review['review']); ?>"
                        </p>
                        <div class="bbt-review-tour">
                            <span class="label">Tour:</span>
                            <span class="tour-name">
                                <?php echo esc_html($review['tour']); ?>
                            </span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="bbt-reviews-nav">
                <button class="bbt-review-prev"><svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2">
                        <path d="M15 18l-6-6 6-6" />
                    </svg></button>
                <button class="bbt-review-next"><svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2">
                        <path d="M9 18l6-6-6-6" />
                    </svg></button>
            </div>
        </div>

        <style>
            .bbt-reviews-carousel {
                position: relative;
                padding: 40px 0;
                overflow: hidden;
            }

            .bbt-reviews-track {
                display: flex;
                gap: 30px;
                transition: transform 0.5s ease;
            }

            .bbt-review-card {
                flex: 0 0 380px;
                background: #fff;
                padding: 30px;
                border-radius: 24px;
                box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
                opacity: 0;
                animation: bbtReviewFade 0.5s ease forwards;
                animation-delay: var(--delay);
                transition: all 0.3s ease;
            }

            @keyframes bbtReviewFade {
                to {
                    opacity: 1;
                }
            }

            .bbt-review-card:hover {
                transform: translateY(-10px);
                box-shadow: 0 20px 50px rgba(0, 0, 0, 0.12);
            }

            .bbt-review-header {
                display: flex;
                align-items: center;
                gap: 15px;
                margin-bottom: 20px;
            }

            .bbt-review-avatar {
                width: 60px;
                height: 60px;
                border-radius: 50%;
                object-fit: cover;
                border: 3px solid #F5A623;
            }

            .bbt-review-meta h4 {
                margin: 0 0 4px;
                font-size: 16px;
                font-weight: 700;
            }

            .bbt-review-location {
                font-size: 13px;
                color: #666;
            }

            .bbt-review-stars {
                margin-left: auto;
                font-size: 16px;
            }

            .bbt-review-text {
                font-size: 15px;
                color: #4a4a4a;
                line-height: 1.7;
                margin: 0 0 20px;
                font-style: italic;
            }

            .bbt-review-tour {
                display: flex;
                gap: 8px;
                padding-top: 15px;
                border-top: 1px solid #eee;
                font-size: 13px;
            }

            .bbt-review-tour .label {
                color: #999;
            }

            .bbt-review-tour .tour-name {
                color: #F5A623;
                font-weight: 600;
            }

            .bbt-reviews-nav {
                display: flex;
                justify-content: center;
                gap: 15px;
                margin-top: 30px;
            }

            .bbt-reviews-nav button {
                width: 50px;
                height: 50px;
                border-radius: 50%;
                border: 2px solid #eee;
                background: #fff;
                cursor: pointer;
                transition: all 0.3s ease;
            }

            .bbt-reviews-nav button:hover {
                border-color: #F5A623;
                color: #F5A623;
                transform: scale(1.1);
            }

            @media (max-width: 768px) {
                .bbt-review-card {
                    flex: 0 0 300px;
                }
            }
        </style>
        <?php
    }
}
