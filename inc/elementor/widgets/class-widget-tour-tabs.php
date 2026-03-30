<?php
if (!defined('ABSPATH'))
    exit;

class BBT_Widget_Tour_Tabs extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'bbt-tour-tabs';
    }
    public function get_title()
    {
        return esc_html__('Tour Tabs', 'bestbalitravel');
    }
    public function get_icon()
    {
        return 'eicon-tabs';
    }
    public function get_categories()
    {
        return ['bbt-widgets'];
    }

    protected function register_controls()
    {
        $this->start_controls_section('section_tabs', ['label' => 'Tabs']);
        $repeater = new \Elementor\Repeater();
        $repeater->add_control('title', ['label' => 'Title', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Tab']);
        $repeater->add_control('icon', ['label' => 'Icon', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '📍']);
        $repeater->add_control('category', ['label' => 'Tour Category Slug', 'type' => \Elementor\Controls_Manager::TEXT]);
        $this->add_control('tabs', [
            'type' => \Elementor\Controls_Manager::REPEATER,
            'fields' => $repeater->get_controls(),
            'default' => [
                ['title' => 'Popular', 'icon' => '🔥', 'category' => ''],
                ['title' => 'Adventure', 'icon' => '🏔️', 'category' => 'adventure'],
                ['title' => 'Culture', 'icon' => '🛕', 'category' => 'culture'],
                ['title' => 'Beach', 'icon' => '🏖️', 'category' => 'beach'],
            ]
        ]);
        $this->add_control('posts_per_tab', ['label' => 'Tours per Tab', 'type' => \Elementor\Controls_Manager::NUMBER, 'default' => 4]);
        $this->end_controls_section();
    }

    protected function render()
    {
        $s = $this->get_settings_for_display();
        $tabs = $s['tabs'];
        ?>
        <div class="bbt-tour-tabs">
            <div class="bbt-tabs-nav">
                <?php foreach ($tabs as $i => $tab): ?>
                    <button class="bbt-tab-btn <?php echo $i === 0 ? 'active' : ''; ?>" data-tab="tab-<?php echo $i; ?>">
                        <span>
                            <?php echo $tab['icon']; ?>
                        </span>
                        <?php echo esc_html($tab['title']); ?>
                    </button>
                <?php endforeach; ?>
            </div>
            <div class="bbt-tabs-content">
                <?php foreach ($tabs as $i => $tab):
                    $args = ['post_type' => 'tour', 'posts_per_page' => $s['posts_per_tab']];
                    if (!empty($tab['category']))
                        $args['tax_query'] = [['taxonomy' => 'tour_type', 'field' => 'slug', 'terms' => $tab['category']]];
                    $q = new \WP_Query($args);
                    ?>
                    <div class="bbt-tab-panel <?php echo $i === 0 ? 'active' : ''; ?>" id="tab-<?php echo $i; ?>">
                        <div class="bbt-tab-grid">
                            <?php if ($q->have_posts()):
                                while ($q->have_posts()):
                                    $q->the_post();
                                    $price = function_exists('bbt_get_tour_price') ? bbt_get_tour_price() : 'Rp 450,000';
                                    ?>
                                    <a href="<?php the_permalink(); ?>" class="bbt-tab-card">
                                        <div class="bbt-tc-img">
                                            <?php if (has_post_thumbnail())
                                                the_post_thumbnail('medium');
                                            else
                                                echo '<img src="https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=400">'; ?>
                                        </div>
                                        <div class="bbt-tc-info">
                                            <h4>
                                                <?php the_title(); ?>
                                            </h4><span>
                                                <?php echo esc_html($price); ?>
                                            </span>
                                        </div>
                                    </a>
                                <?php endwhile;
                                wp_reset_postdata(); endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <style>
            .bbt-tabs-nav {
                display: flex;
                gap: 10px;
                margin-bottom: 30px;
                flex-wrap: wrap
            }

            .bbt-tab-btn {
                padding: 12px 24px;
                background: #f5f5f5;
                border: none;
                border-radius: 30px;
                font-size: 14px;
                font-weight: 600;
                cursor: pointer;
                transition: all .3s ease
            }

            .bbt-tab-btn.active,
            .bbt-tab-btn:hover {
                background: #F5A623;
                color: #000
            }

            .bbt-tab-panel {
                display: none
            }

            .bbt-tab-panel.active {
                display: block;
                animation: bbtTabFade .4s ease
            }

            @keyframes bbtTabFade {
                from {
                    opacity: 0
                }

                to {
                    opacity: 1
                }
            }

            .bbt-tab-grid {
                display: grid;
                grid-template-columns: repeat(4, 1fr);
                gap: 20px
            }

            .bbt-tab-card {
                background: #fff;
                border-radius: 16px;
                overflow: hidden;
                text-decoration: none;
                color: inherit;
                box-shadow: 0 5px 20px rgba(0, 0, 0, .08);
                transition: transform .3s ease
            }

            .bbt-tab-card:hover {
                transform: translateY(-8px)
            }

            .bbt-tc-img {
                height: 160px;
                overflow: hidden
            }

            .bbt-tc-img img {
                width: 100%;
                height: 100%;
                object-fit: cover
            }

            .bbt-tc-info {
                padding: 15px
            }

            .bbt-tc-info h4 {
                margin: 0 0 5px;
                font-size: 14px
            }

            .bbt-tc-info span {
                color: #F5A623;
                font-weight: 700
            }

            @media(max-width:768px) {
                .bbt-tab-grid {
                    grid-template-columns: repeat(2, 1fr)
                }
            }
        </style>
        <script>
            document.querySelectorAll('.bbt-tab-btn').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    document.querySelectorAll('.bbt-tab-btn').forEach(function (b) { b.classList.remove('active') });
                    document.querySelectorAll('.bbt-tab-panel').forEach(function (p) { p.classList.remove('active') });
                    this.classList.add('active');
                    document.getElementById(this.dataset.tab).classList.add('active');
                });
            });
        </script>
        <?php
    }
}
