<?php
/**
 * Elementor Premium Header Widget
 * Glassmorphism Design with Tailwind CSS & Alpine.js
 *
 * @package BestBaliTravel
 */

if (!defined('ABSPATH'))
    exit;

class BBT_Widget_Premium_Header extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'bbt-premium-header';
    }
    
    public function get_title()
    {
        return esc_html__('BBT Premium Header', 'bestbalitravel');
    }
    
    public function get_icon()
    {
        return 'eicon-header';
    }
    
    public function get_categories()
    {
        return ['bbt-widgets'];
    }

    protected function register_controls()
    {
        // ============================================
        // LOGO SECTION
        // ============================================
        $this->start_controls_section('section_logo', [
            'label' => esc_html__('Logo', 'bestbalitravel'),
            'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
        ]);

        $this->add_control('logo_type', [
            'label' => esc_html__('Logo Type', 'bestbalitravel'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'options' => [
                'text' => esc_html__('Text Logo', 'bestbalitravel'),
                'image' => esc_html__('Image Logo', 'bestbalitravel'),
            ],
            'default' => 'text',
        ]);

        $this->add_control('logo_text', [
            'label' => esc_html__('Logo Text', 'bestbalitravel'),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => 'BESTBALI TRAVEL',
            'condition' => ['logo_type' => 'text'],
        ]);

        $this->add_control('logo_highlight', [
            'label' => esc_html__('Highlighted Part', 'bestbalitravel'),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => 'BALI',
            'description' => esc_html__('This part will be colored', 'bestbalitravel'),
            'condition' => ['logo_type' => 'text'],
        ]);

        $this->add_control('logo_image', [
            'label' => esc_html__('Logo Image', 'bestbalitravel'),
            'type' => \Elementor\Controls_Manager::MEDIA,
            'condition' => ['logo_type' => 'image'],
        ]);

        $this->add_control('logo_link', [
            'label' => esc_html__('Logo Link', 'bestbalitravel'),
            'type' => \Elementor\Controls_Manager::URL,
            'default' => ['url' => home_url('/')],
        ]);

        $this->end_controls_section();

        // ============================================
        // MENU SECTION
        // ============================================
        $this->start_controls_section('section_menu', [
            'label' => esc_html__('Menu Items', 'bestbalitravel'),
            'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
        ]);

        $repeater = new \Elementor\Repeater();

        $repeater->add_control('menu_label', [
            'label' => esc_html__('Label', 'bestbalitravel'),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => 'Menu Item',
        ]);

        $repeater->add_control('menu_link', [
            'label' => esc_html__('Link', 'bestbalitravel'),
            'type' => \Elementor\Controls_Manager::URL,
        ]);

        $repeater->add_control('has_dropdown', [
            'label' => esc_html__('Has Dropdown', 'bestbalitravel'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
        ]);

        $repeater->add_control('dropdown_items', [
            'label' => esc_html__('Dropdown Items (one per line)', 'bestbalitravel'),
            'type' => \Elementor\Controls_Manager::TEXTAREA,
            'description' => esc_html__('Format: Label|URL', 'bestbalitravel'),
            'placeholder' => "Sub Item 1|/link1\nSub Item 2|/link2",
            'condition' => ['has_dropdown' => 'yes'],
        ]);

        $this->add_control('menu_items', [
            'label' => esc_html__('Menu Items', 'bestbalitravel'),
            'type' => \Elementor\Controls_Manager::REPEATER,
            'fields' => $repeater->get_controls(),
            'default' => [
                ['menu_label' => 'Home', 'menu_link' => ['url' => '/']],
                ['menu_label' => 'Tours', 'menu_link' => ['url' => '/tours/'], 'has_dropdown' => 'yes', 'dropdown_items' => "All Tours|/tours/\nNusa Penida|/tours/?location=nusa-penida\nUbud|/tours/?location=ubud"],
                ['menu_label' => 'Activities', 'menu_link' => ['url' => '/activities/']],
                ['menu_label' => 'About', 'menu_link' => ['url' => '/about/']],
                ['menu_label' => 'Contact', 'menu_link' => ['url' => '/contact/']],
            ],
            'title_field' => '{{{ menu_label }}}',
        ]);

        $this->end_controls_section();

        // ============================================
        // CTA BUTTON
        // ============================================
        $this->start_controls_section('section_cta', [
            'label' => esc_html__('CTA Button', 'bestbalitravel'),
            'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
        ]);

        $this->add_control('show_cta', [
            'label' => esc_html__('Show CTA Button', 'bestbalitravel'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'default' => 'yes',
        ]);

        $this->add_control('cta_text', [
            'label' => esc_html__('Button Text', 'bestbalitravel'),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => 'Book Now',
            'condition' => ['show_cta' => 'yes'],
        ]);

        $this->add_control('cta_link', [
            'label' => esc_html__('Button Link', 'bestbalitravel'),
            'type' => \Elementor\Controls_Manager::URL,
            'condition' => ['show_cta' => 'yes'],
        ]);

        $this->end_controls_section();

        // ============================================
        // STYLE - Header
        // ============================================
        $this->start_controls_section('section_style_header', [
            'label' => esc_html__('Header Style', 'bestbalitravel'),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control('header_bg', [
            'label' => esc_html__('Background Color', 'bestbalitravel'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => 'rgba(255,255,255,0.8)',
        ]);

        $this->add_control('header_blur', [
            'label' => esc_html__('Blur Amount', 'bestbalitravel'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'range' => ['px' => ['min' => 0, 'max' => 30]],
            'default' => ['size' => 20, 'unit' => 'px'],
        ]);

        $this->add_control('header_border', [
            'label' => esc_html__('Border Color', 'bestbalitravel'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => 'rgba(255,255,255,0.3)',
        ]);

        $this->end_controls_section();

        // ============================================
        // STYLE - Logo
        // ============================================
        $this->start_controls_section('section_style_logo', [
            'label' => esc_html__('Logo Style', 'bestbalitravel'),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control('logo_color', [
            'label' => esc_html__('Logo Color', 'bestbalitravel'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#1a1a2e',
        ]);

        $this->add_control('logo_highlight_color', [
            'label' => esc_html__('Highlight Color', 'bestbalitravel'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#f59e0b',
        ]);

        $this->end_controls_section();

        // ============================================
        // STYLE - Menu
        // ============================================
        $this->start_controls_section('section_style_menu', [
            'label' => esc_html__('Menu Style', 'bestbalitravel'),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control('menu_color', [
            'label' => esc_html__('Menu Color', 'bestbalitravel'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#374151',
        ]);

        $this->add_control('menu_hover_color', [
            'label' => esc_html__('Menu Hover Color', 'bestbalitravel'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#f59e0b',
        ]);

        $this->end_controls_section();

        // ============================================
        // STYLE - CTA
        // ============================================
        $this->start_controls_section('section_style_cta', [
            'label' => esc_html__('CTA Style', 'bestbalitravel'),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control('cta_bg', [
            'label' => esc_html__('Button Background', 'bestbalitravel'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#f59e0b',
        ]);

        $this->add_control('cta_color', [
            'label' => esc_html__('Button Text Color', 'bestbalitravel'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#000000',
        ]);

        $this->end_controls_section();
    }

    protected function render()
    {
        $s = $this->get_settings_for_display();
        $logo_link = !empty($s['logo_link']['url']) ? $s['logo_link']['url'] : home_url('/');
        $cta_link = !empty($s['cta_link']['url']) ? $s['cta_link']['url'] : '#';
        $blur = $s['header_blur']['size'] ?? 20;
        ?>

<!-- Tailwind + Alpine -->
<script src="https://cdn.tailwindcss.com"></script>
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

<style>
/* Full width override */
.elementor-widget-bbt-premium-header,
.elementor-widget-bbt-premium-header > .elementor-widget-container {
    width: 100vw !important;
    max-width: none !important;
    margin-left: calc(-50vw + 50%) !important;
    padding: 0 !important;
}
</style>

<header 
    x-data="{ 
        mobileOpen: false, 
        scrolled: false,
        activeDropdown: null
    }"
    @scroll.window="scrolled = window.scrollY > 50"
    :class="scrolled ? 'shadow-lg' : ''"
    class="fixed top-0 left-0 right-0 z-50 transition-all duration-300"
    style="background: <?php echo esc_attr($s['header_bg']); ?>; backdrop-filter: blur(<?php echo esc_attr($blur); ?>px); -webkit-backdrop-filter: blur(<?php echo esc_attr($blur); ?>px); border-bottom: 1px solid <?php echo esc_attr($s['header_border']); ?>;"
>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20">
            
            <!-- Logo -->
            <a href="<?php echo esc_url($logo_link); ?>" class="flex-shrink-0">
                <?php if ($s['logo_type'] === 'image' && !empty($s['logo_image']['url'])): ?>
                    <img src="<?php echo esc_url($s['logo_image']['url']); ?>" alt="Logo" class="h-10 w-auto">
                <?php else: 
                    $text = $s['logo_text'];
                    $highlight = $s['logo_highlight'];
                    $parts = explode($highlight, $text, 2);
                ?>
                    <span class="text-xl font-black tracking-tight" style="color: <?php echo esc_attr($s['logo_color']); ?>;">
                        <?php echo esc_html($parts[0] ?? ''); ?><span style="color: <?php echo esc_attr($s['logo_highlight_color']); ?>;"><?php echo esc_html($highlight); ?></span><?php echo esc_html($parts[1] ?? ''); ?>
                    </span>
                <?php endif; ?>
            </a>
            
            <!-- Desktop Menu -->
            <nav class="hidden lg:flex items-center gap-8">
                <?php foreach ($s['menu_items'] as $index => $item): 
                    $link = !empty($item['menu_link']['url']) ? $item['menu_link']['url'] : '#';
                    $has_dropdown = $item['has_dropdown'] === 'yes';
                ?>
                    <?php if ($has_dropdown): ?>
                    <div 
                        class="relative"
                        @mouseenter="activeDropdown = <?php echo $index; ?>"
                        @mouseleave="activeDropdown = null"
                    >
                        <button 
                            class="flex items-center gap-1 text-sm font-medium transition-colors hover:opacity-80"
                            style="color: <?php echo esc_attr($s['menu_color']); ?>;"
                        >
                            <?php echo esc_html($item['menu_label']); ?>
                            <svg class="w-4 h-4 transition-transform" :class="activeDropdown === <?php echo $index; ?> && 'rotate-180'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                        
                        <div 
                            x-show="activeDropdown === <?php echo $index; ?>"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 translate-y-2"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 translate-y-0"
                            x-transition:leave-end="opacity-0 translate-y-2"
                            class="absolute top-full left-0 mt-2 w-56 bg-white rounded-xl shadow-xl border border-gray-100 overflow-hidden"
                        >
                            <?php
                            $dropdown_items = explode("\n", $item['dropdown_items']);
                            foreach ($dropdown_items as $dd_item):
                                $dd_parts = explode('|', trim($dd_item));
                                if (count($dd_parts) >= 2):
                            ?>
                            <a 
                                href="<?php echo esc_url(trim($dd_parts[1])); ?>" 
                                class="block px-4 py-3 text-sm text-gray-700 hover:bg-amber-50 hover:text-amber-600 transition-colors"
                            >
                                <?php echo esc_html(trim($dd_parts[0])); ?>
                            </a>
                            <?php endif; endforeach; ?>
                        </div>
                    </div>
                    <?php else: ?>
                    <a 
                        href="<?php echo esc_url($link); ?>" 
                        class="text-sm font-medium transition-colors hover:opacity-80"
                        style="color: <?php echo esc_attr($s['menu_color']); ?>;"
                        onmouseover="this.style.color='<?php echo esc_attr($s['menu_hover_color']); ?>'"
                        onmouseout="this.style.color='<?php echo esc_attr($s['menu_color']); ?>'"
                    >
                        <?php echo esc_html($item['menu_label']); ?>
                    </a>
                    <?php endif; ?>
                <?php endforeach; ?>
            </nav>
            
            <!-- Right Side -->
            <div class="flex items-center gap-4">
                <?php if ($s['show_cta'] === 'yes'): ?>
                <a 
                    href="<?php echo esc_url($cta_link); ?>" 
                    class="hidden sm:inline-flex items-center gap-2 px-6 py-2.5 text-sm font-bold rounded-full transition-all duration-300 hover:scale-105 hover:shadow-lg"
                    style="background: <?php echo esc_attr($s['cta_bg']); ?>; color: <?php echo esc_attr($s['cta_color']); ?>;"
                >
                    <?php echo esc_html($s['cta_text']); ?>
                </a>
                <?php endif; ?>
                
                <!-- Mobile Toggle -->
                <button 
                    @click="mobileOpen = !mobileOpen"
                    class="lg:hidden w-10 h-10 flex items-center justify-center rounded-full bg-gray-100 hover:bg-gray-200 transition-colors"
                >
                    <svg x-show="!mobileOpen" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    <svg x-show="mobileOpen" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        </div>
    </div>
    
    <!-- Mobile Menu -->
    <div 
        x-show="mobileOpen"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 -translate-y-4"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-4"
        x-cloak
        class="lg:hidden border-t border-gray-100 bg-white"
    >
        <div class="px-4 py-4 space-y-1">
            <?php foreach ($s['menu_items'] as $item): 
                $link = !empty($item['menu_link']['url']) ? $item['menu_link']['url'] : '#';
            ?>
            <a 
                href="<?php echo esc_url($link); ?>" 
                class="block px-4 py-3 text-base font-medium text-gray-700 hover:bg-gray-50 rounded-lg transition-colors"
            >
                <?php echo esc_html($item['menu_label']); ?>
            </a>
            <?php endforeach; ?>
            
            <?php if ($s['show_cta'] === 'yes'): ?>
            <div class="pt-4">
                <a 
                    href="<?php echo esc_url($cta_link); ?>" 
                    class="block w-full text-center px-6 py-3 font-bold rounded-full"
                    style="background: <?php echo esc_attr($s['cta_bg']); ?>; color: <?php echo esc_attr($s['cta_color']); ?>;"
                >
                    <?php echo esc_html($s['cta_text']); ?>
                </a>
            </div>
            <?php endif; ?>
        </div>
    </div>
</header>

<!-- Spacer for fixed header -->
<div class="h-20"></div>

<?php
    }
}
