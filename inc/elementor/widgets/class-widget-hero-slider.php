<?php
/**
 * Elementor Hero Slider Widget
 * Premium Full-Width Design - Clean & Modern UI/UX
 *
 * @package BestBaliTravel
 */

if (!defined('ABSPATH')) {
    exit;
}

class BBT_Widget_Hero_Slider extends \Elementor\Widget_Base
{

    public function get_name()
    {
        return 'bbt-hero-slider';
    }

    public function get_title()
    {
        return esc_html__('BBT Hero Slider', 'bestbalitravel');
    }

    public function get_icon()
    {
        return 'eicon-slides';
    }

    public function get_categories()
    {
        return array('bbt-widgets');
    }

    public function get_keywords()
    {
        return array('hero', 'slider', 'banner', 'carousel', 'bali');
    }

    protected function register_controls()
    {
        $this->start_controls_section(
            'section_slides',
            array(
                'label' => esc_html__('Slides', 'bestbalitravel'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            )
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control('slide_image', array(
            'label' => esc_html__('Background Image', 'bestbalitravel'),
            'type' => \Elementor\Controls_Manager::MEDIA,
            'default' => array('url' => \Elementor\Utils::get_placeholder_image_src()),
        ));

        $repeater->add_control('slide_title', array(
            'label' => esc_html__('Title', 'bestbalitravel'),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => esc_html__('Discover Bali', 'bestbalitravel'),
            'label_block' => true,
        ));

        $repeater->add_control('slide_subtitle', array(
            'label' => esc_html__('Subtitle', 'bestbalitravel'),
            'type' => \Elementor\Controls_Manager::TEXTAREA,
            'default' => esc_html__('Experience the magic of the Island of Gods', 'bestbalitravel'),
        ));

        $repeater->add_control('slide_button_text', array(
            'label' => esc_html__('Button Text', 'bestbalitravel'),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => esc_html__('Explore Tours', 'bestbalitravel'),
        ));

        $repeater->add_control('slide_button_link', array(
            'label' => esc_html__('Button Link', 'bestbalitravel'),
            'type' => \Elementor\Controls_Manager::URL,
            'placeholder' => esc_html__('https://your-link.com', 'bestbalitravel'),
        ));

        $this->add_control('slides', array(
            'label' => esc_html__('Slides', 'bestbalitravel'),
            'type' => \Elementor\Controls_Manager::REPEATER,
            'fields' => $repeater->get_controls(),
            'default' => array(
                array(
                    'slide_title' => esc_html__('Discover Paradise', 'bestbalitravel'),
                    'slide_subtitle' => esc_html__('Unforgettable tours and authentic experiences', 'bestbalitravel'),
                    'slide_button_text' => esc_html__('Explore Tours', 'bestbalitravel'),
                ),
                array(
                    'slide_title' => esc_html__('Adventure Awaits', 'bestbalitravel'),
                    'slide_subtitle' => esc_html__('From sunrise treks to sunset cruises', 'bestbalitravel'),
                    'slide_button_text' => esc_html__('View Activities', 'bestbalitravel'),
                ),
            ),
            'title_field' => '{{{ slide_title }}}',
        ));

        $this->end_controls_section();

        $this->start_controls_section(
            'section_settings',
            array(
                'label' => esc_html__('Settings', 'bestbalitravel'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            )
        );

        $this->add_control('autoplay', array(
            'label' => esc_html__('Autoplay', 'bestbalitravel'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'default' => 'yes',
        ));

        $this->add_control('autoplay_speed', array(
            'label' => esc_html__('Autoplay Speed (ms)', 'bestbalitravel'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'default' => 6000,
            'condition' => array('autoplay' => 'yes'),
        ));

        $this->add_control('show_search', array(
            'label' => esc_html__('Show Search', 'bestbalitravel'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'default' => 'yes',
        ));

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $slides = $settings['slides'];
        if (empty($slides)) return;

        $autoplay = 'yes' === $settings['autoplay'];
        $speed = intval($settings['autoplay_speed']);
        $show_search = 'yes' === $settings['show_search'];
        $total = count($slides);
        
        $locations = get_terms(array('taxonomy' => 'tour_location', 'hide_empty' => true));
        $types = get_terms(array('taxonomy' => 'tour_type', 'hide_empty' => true));
        ?>

<!-- Dependencies -->
<script src="https://cdn.tailwindcss.com"></script>
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

<style>
/* Full Width Override */
.elementor-widget-bbt-hero-slider,
.elementor-widget-bbt-hero-slider > .elementor-widget-container {
    margin: 0 !important;
    padding: 0 !important;
    max-width: none !important;
    width: 100vw !important;
    margin-left: calc(-50vw + 50%) !important;
}

/* Ken Burns */
@keyframes kenburns {
    0% { transform: scale(1); }
    100% { transform: scale(1.08); }
}

/* Progress animation */
@keyframes fillProgress {
    from { transform: scaleX(0); }
    to { transform: scaleX(1); }
}
</style>

<div 
    x-data="{
        current: 0,
        total: <?php echo $total; ?>,
        auto: <?php echo $autoplay ? 'true' : 'false'; ?>,
        speed: <?php echo $speed; ?>,
        timer: null,
        searchOpen: false,
        
        init() {
            if (this.auto) this.play();
        },
        play() {
            this.timer = setInterval(() => this.next(), this.speed);
        },
        pause() {
            clearInterval(this.timer);
        },
        next() {
            this.current = (this.current + 1) % this.total;
        },
        prev() {
            this.current = (this.current - 1 + this.total) % this.total;
        },
        go(i) {
            this.current = i;
            if (this.auto) { this.pause(); this.play(); }
        }
    }"
    @mouseenter="pause()"
    @mouseleave="auto && play()"
    class="relative w-screen h-screen min-h-[500px] max-h-[1000px] overflow-hidden bg-black"
>
    <!-- SLIDES -->
    <?php foreach ($slides as $i => $slide): 
        $img = !empty($slide['slide_image']['url']) ? $slide['slide_image']['url'] : 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=1920';
        $link = !empty($slide['slide_button_link']['url']) ? $slide['slide_button_link']['url'] : '#';
    ?>
    <div 
        x-show="current === <?php echo $i; ?>"
        x-transition:enter="transition ease-out duration-1000"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-500"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="absolute inset-0"
    >
        <!-- Background -->
        <div 
            class="absolute inset-0 bg-cover bg-center"
            style="background-image: url('<?php echo esc_url($img); ?>'); animation: kenburns 25s ease-in-out infinite alternate;"
        ></div>
        
        <!-- Overlay -->
        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-black/40"></div>
        
        <!-- Content -->
        <div class="relative h-full flex items-center justify-center px-6 sm:px-10 lg:px-20">
            <div class="text-center max-w-4xl">
                <!-- Badge -->
                <div 
                    x-show="current === <?php echo $i; ?>"
                    x-transition:enter="transition duration-500 delay-200"
                    x-transition:enter-start="opacity-0 -translate-y-4"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    class="flex items-center justify-center gap-4 mb-8"
                >
                    <span class="w-16 h-px bg-gradient-to-r from-transparent to-amber-500"></span>
                    <span class="text-amber-400 text-xs sm:text-sm font-semibold tracking-[0.25em] uppercase">Best Bali Travel</span>
                    <span class="w-16 h-px bg-gradient-to-l from-transparent to-amber-500"></span>
                </div>
                
                <!-- Title -->
                <h1 
                    x-show="current === <?php echo $i; ?>"
                    x-transition:enter="transition duration-700 delay-300"
                    x-transition:enter-start="opacity-0 translate-y-10"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    class="text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-black text-white leading-none mb-6"
                ><?php echo esc_html($slide['slide_title']); ?></h1>
                
                <!-- Subtitle -->
                <p 
                    x-show="current === <?php echo $i; ?>"
                    x-transition:enter="transition duration-700 delay-[400ms]"
                    x-transition:enter-start="opacity-0 translate-y-8"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    class="text-base sm:text-lg md:text-xl text-white/70 max-w-xl mx-auto mb-10"
                ><?php echo esc_html($slide['slide_subtitle']); ?></p>
                
                <!-- Button -->
                <?php if (!empty($slide['slide_button_text'])): ?>
                <div
                    x-show="current === <?php echo $i; ?>"
                    x-transition:enter="transition duration-700 delay-500"
                    x-transition:enter-start="opacity-0 translate-y-6"
                    x-transition:enter-end="opacity-100 translate-y-0"
                >
                    <a 
                        href="<?php echo esc_url($link); ?>"
                        class="inline-flex items-center gap-3 px-8 sm:px-10 py-4 sm:py-5 bg-amber-500 hover:bg-amber-400 text-black font-bold text-base sm:text-lg transition-all duration-300 hover:gap-5"
                    >
                        <?php echo esc_html($slide['slide_button_text']); ?>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
    
    <!-- NAVIGATION ARROWS - Circular, Large, Visible -->
    <button 
        @click="prev()"
        class="absolute left-4 sm:left-8 top-1/2 -translate-y-1/2 z-30 w-14 h-14 sm:w-16 sm:h-16 flex items-center justify-center rounded-full bg-white/20 hover:bg-white/40 backdrop-blur-sm border border-white/30 text-white transition-all duration-300 hover:scale-110"
        aria-label="Previous slide"
    >
        <svg class="w-7 h-7 sm:w-8 sm:h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
        </svg>
    </button>
    
    <button 
        @click="next()"
        class="absolute right-4 sm:right-8 top-1/2 -translate-y-1/2 z-30 w-14 h-14 sm:w-16 sm:h-16 flex items-center justify-center rounded-full bg-white/20 hover:bg-white/40 backdrop-blur-sm border border-white/30 text-white transition-all duration-300 hover:scale-110"
        aria-label="Next slide"
    >
        <svg class="w-7 h-7 sm:w-8 sm:h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
        </svg>
    </button>
    
    <!-- PAGINATION - Modern Line Style -->
    <div class="absolute bottom-32 sm:bottom-36 left-1/2 -translate-x-1/2 z-30 flex items-center gap-4">
        <?php foreach ($slides as $i => $slide): ?>
        <button 
            @click="go(<?php echo $i; ?>)"
            class="group relative h-12 flex flex-col items-center justify-end gap-2"
        >
            <!-- Number -->
            <span 
                :class="current === <?php echo $i; ?> ? 'text-amber-400' : 'text-white/40 group-hover:text-white/70'"
                class="text-xs font-mono transition-colors"
            >0<?php echo $i + 1; ?></span>
            
            <!-- Line with progress -->
            <div class="relative w-12 sm:w-16 h-[3px] bg-white/20 overflow-hidden rounded-full">
                <div 
                    x-show="current === <?php echo $i; ?>"
                    class="absolute inset-0 bg-amber-500 origin-left"
                    style="animation: fillProgress <?php echo $speed; ?>ms linear forwards;"
                ></div>
            </div>
        </button>
        <?php endforeach; ?>
    </div>
    
    <?php if ($show_search): ?>
    <!-- SEARCH BOX - Clean & Responsive -->
    <div class="absolute bottom-0 left-0 right-0 z-20">
        
        <!-- Desktop Search -->
        <form action="<?php echo esc_url(home_url('/')); ?>" method="get" class="hidden md:flex bg-white">
            <div class="flex-1 flex items-center gap-4 px-6 lg:px-8 py-5 border-r border-gray-100">
                <div class="w-10 h-10 flex items-center justify-center rounded-full bg-amber-50">
                    <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><circle cx="12" cy="10" r="3"/></svg>
                </div>
                <div class="flex-1 min-w-0">
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider">Location</label>
                    <select name="location" class="w-full text-gray-800 text-sm font-medium bg-transparent border-0 p-0 mt-1 focus:ring-0 cursor-pointer truncate">
                        <option value="">All Destinations</option>
                        <?php if (!is_wp_error($locations)): foreach ($locations as $l): ?>
                        <option value="<?php echo esc_attr($l->slug); ?>"><?php echo esc_html($l->name); ?></option>
                        <?php endforeach; endif; ?>
                    </select>
                </div>
            </div>
            
            <div class="flex-1 flex items-center gap-4 px-6 lg:px-8 py-5 border-r border-gray-100">
                <div class="w-10 h-10 flex items-center justify-center rounded-full bg-amber-50">
                    <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 21l-7-12-7 12M12 3v6"/></svg>
                </div>
                <div class="flex-1 min-w-0">
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider">Type</label>
                    <select name="tour_type" class="w-full text-gray-800 text-sm font-medium bg-transparent border-0 p-0 mt-1 focus:ring-0 cursor-pointer truncate">
                        <option value="">All Types</option>
                        <?php if (!is_wp_error($types)): foreach ($types as $t): ?>
                        <option value="<?php echo esc_attr($t->slug); ?>"><?php echo esc_html($t->name); ?></option>
                        <?php endforeach; endif; ?>
                    </select>
                </div>
            </div>
            
            <div class="flex-1 flex items-center gap-4 px-6 lg:px-8 py-5 border-r border-gray-100">
                <div class="w-10 h-10 flex items-center justify-center rounded-full bg-amber-50">
                    <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
                </div>
                <div class="flex-1 min-w-0">
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider">Date</label>
                    <input type="date" name="tour_date" min="<?php echo date('Y-m-d'); ?>" class="w-full text-gray-800 text-sm font-medium bg-transparent border-0 p-0 mt-1 focus:ring-0 cursor-pointer">
                </div>
            </div>
            
            <button type="submit" class="flex items-center justify-center gap-3 px-10 lg:px-14 bg-amber-500 hover:bg-amber-400 text-black font-bold text-base transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
                <span class="hidden lg:inline">Search</span>
            </button>
            <input type="hidden" name="post_type" value="tour">
        </form>
        
        <!-- Mobile Search - Clean Collapsible -->
        <div class="md:hidden bg-white">
            <!-- Toggle Button -->
            <button 
                @click="searchOpen = !searchOpen"
                class="w-full flex items-center justify-center gap-3 px-6 py-5 font-semibold text-gray-800"
            >
                <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
                <span>Search Tours & Activities</span>
                <svg :class="searchOpen && 'rotate-180'" class="w-4 h-4 text-gray-400 ml-auto transition-transform" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7"/></svg>
            </button>
            
            <!-- Expanded Form -->
            <div 
                x-show="searchOpen"
                x-collapse
                class="border-t border-gray-100"
            >
                <form action="<?php echo esc_url(home_url('/')); ?>" method="get" class="p-5 space-y-4">
                    <!-- Location -->
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Destination</label>
                        <select name="location" class="w-full px-4 py-3.5 bg-gray-50 border-0 rounded-xl text-gray-800 font-medium focus:ring-2 focus:ring-amber-500">
                            <option value="">All Destinations</option>
                            <?php if (!is_wp_error($locations)): foreach ($locations as $l): ?>
                            <option value="<?php echo esc_attr($l->slug); ?>"><?php echo esc_html($l->name); ?></option>
                            <?php endforeach; endif; ?>
                        </select>
                    </div>
                    
                    <!-- Type -->
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Tour Type</label>
                        <select name="tour_type" class="w-full px-4 py-3.5 bg-gray-50 border-0 rounded-xl text-gray-800 font-medium focus:ring-2 focus:ring-amber-500">
                            <option value="">All Types</option>
                            <?php if (!is_wp_error($types)): foreach ($types as $t): ?>
                            <option value="<?php echo esc_attr($t->slug); ?>"><?php echo esc_html($t->name); ?></option>
                            <?php endforeach; endif; ?>
                        </select>
                    </div>
                    
                    <!-- Date -->
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Date</label>
                        <input type="date" name="tour_date" min="<?php echo date('Y-m-d'); ?>" class="w-full px-4 py-3.5 bg-gray-50 border-0 rounded-xl text-gray-800 font-medium focus:ring-2 focus:ring-amber-500">
                    </div>
                    
                    <!-- Submit -->
                    <button type="submit" class="w-full flex items-center justify-center gap-3 px-6 py-4 bg-amber-500 hover:bg-amber-400 text-black font-bold text-base rounded-xl transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
                        Search Tours
                    </button>
                    <input type="hidden" name="post_type" value="tour">
                </form>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<?php
    }
}
