<?php
if (!defined('ABSPATH'))
    exit;

class BBT_Widget_Tour_Reviews extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'bbt-tour-reviews';
    }
    public function get_title()
    {
        return esc_html__('Tour Reviews', 'bestbalitravel');
    }
    public function get_icon()
    {
        return 'eicon-review';
    }
    public function get_categories()
    {
        return ['bbt-widgets'];
    }

    protected function register_controls()
    {
        $this->start_controls_section('section_reviews', ['label' => 'Reviews']);
        $repeater = new \Elementor\Repeater();
        $repeater->add_control('name', ['label' => 'Name', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Guest']);
        $repeater->add_control('rating', ['label' => 'Rating', 'type' => \Elementor\Controls_Manager::NUMBER, 'default' => 5, 'min' => 1, 'max' => 5]);
        $repeater->add_control('date', ['label' => 'Date', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '2 days ago']);
        $repeater->add_control('content', ['label' => 'Review', 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'Amazing experience!']);
        $this->add_control('reviews', [
            'type' => \Elementor\Controls_Manager::REPEATER,
            'fields' => $repeater->get_controls(),
            'default' => [
                ['name' => 'Sarah M.', 'rating' => 5, 'date' => '3 days ago', 'content' => 'Best tour ever! Our guide was incredible and the views were breathtaking.'],
                ['name' => 'John D.', 'rating' => 5, 'date' => '1 week ago', 'content' => 'Highly recommend! Everything was perfectly organized.'],
            ]
        ]);
        $this->end_controls_section();
    }

    protected function render()
    {
        $reviews = $this->get_settings_for_display()['reviews'];
        ?>
        <div class="bbt-tour-reviews">
            <h3>⭐ Reviews</h3>
            <div class="bbt-tr-list">
                <?php foreach ($reviews as $r):
                    $avatar = 'https://ui-avatars.com/api/?name=' . urlencode($r['name']) . '&background=F5A623&color=fff';
                    ?>
                    <div class="bbt-tr-item">
                        <div class="bbt-tr-header"><img src="<?php echo esc_url($avatar); ?>" alt="">
                            <div><strong>
                                    <?php echo esc_html($r['name']); ?>
                                </strong><span>
                                    <?php echo esc_html($r['date']); ?>
                                </span></div>
                            <div class="bbt-tr-rating">
                                <?php echo str_repeat('⭐', (int) $r['rating']); ?>
                            </div>
                        </div>
                        <p>
                            <?php echo esc_html($r['content']); ?>
                        </p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <style>
            .bbt-tour-reviews h3 {
                margin: 0 0 20px;
                font-size: 20px
            }

            .bbt-tr-list {
                display: flex;
                flex-direction: column;
                gap: 20px
            }

            .bbt-tr-item {
                background: #fff;
                padding: 25px;
                border-radius: 16px;
                box-shadow: 0 5px 20px rgba(0, 0, 0, .06)
            }

            .bbt-tr-header {
                display: flex;
                align-items: center;
                gap: 15px;
                margin-bottom: 15px
            }

            .bbt-tr-header img {
                width: 50px;
                height: 50px;
                border-radius: 50%
            }

            .bbt-tr-header strong {
                display: block
            }

            .bbt-tr-header span {
                font-size: 12px;
                color: #666
            }

            .bbt-tr-rating {
                margin-left: auto
            }

            .bbt-tr-item p {
                margin: 0;
                color: #555;
                line-height: 1.6
            }
        </style>
        <?php
    }
}
