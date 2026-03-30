<?php
/**
 * Elementor Premium Footer Widget
 * Modern Design with Full Customization
 *
 * @package BestBaliTravel
 */

if (!defined('ABSPATH'))
    exit;

class BBT_Widget_Premium_Footer extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'bbt-premium-footer';
    }
    
    public function get_title()
    {
        return esc_html__('BBT Premium Footer', 'bestbalitravel');
    }
    
    public function get_icon()
    {
        return 'eicon-footer';
    }
    
    public function get_categories()
    {
        return ['bbt-widgets'];
    }

    protected function register_controls()
    {
        // ============================================
        // COMPANY INFO
        // ============================================
        $this->start_controls_section('section_company', [
            'label' => esc_html__('Company Info', 'bestbalitravel'),
            'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
        ]);

        $this->add_control('company_name', [
            'label' => esc_html__('Company Name', 'bestbalitravel'),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => 'BEST BALI TRAVEL',
        ]);

        $this->add_control('company_highlight', [
            'label' => esc_html__('Highlighted Part', 'bestbalitravel'),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => 'BALI',
        ]);

        $this->add_control('company_description', [
            'label' => esc_html__('Description', 'bestbalitravel'),
            'type' => \Elementor\Controls_Manager::TEXTAREA,
            'default' => 'Explore Bali the Right Way. We provide the best tour experiences with local guides, personalized service, and unforgettable memories.',
        ]);

        $this->add_control('company_logo', [
            'label' => esc_html__('Logo (Optional)', 'bestbalitravel'),
            'type' => \Elementor\Controls_Manager::MEDIA,
        ]);

        $this->end_controls_section();

        // ============================================
        // QUICK LINKS
        // ============================================
        $this->start_controls_section('section_links', [
            'label' => esc_html__('Quick Links', 'bestbalitravel'),
            'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
        ]);

        $this->add_control('links_title', [
            'label' => esc_html__('Section Title', 'bestbalitravel'),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => 'Quick Links',
        ]);

        $this->add_control('quick_links', [
            'label' => esc_html__('Links (one per line)', 'bestbalitravel'),
            'type' => \Elementor\Controls_Manager::TEXTAREA,
            'default' => "All Tours|/tours/\nActivities|/activities/\nHoneymoon|/tour-type/honeymoon/\nAirport Transfer|/tour-type/airport-transfer/\nAbout Us|/about/\nContact|/contact/",
            'description' => esc_html__('Format: Label|URL', 'bestbalitravel'),
        ]);

        $this->end_controls_section();

        // ============================================
        // DESTINATIONS
        // ============================================
        $this->start_controls_section('section_destinations', [
            'label' => esc_html__('Destinations', 'bestbalitravel'),
            'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
        ]);

        $this->add_control('destinations_title', [
            'label' => esc_html__('Section Title', 'bestbalitravel'),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => 'Destinations',
        ]);

        $this->add_control('destinations', [
            'label' => esc_html__('Destinations (one per line)', 'bestbalitravel'),
            'type' => \Elementor\Controls_Manager::TEXTAREA,
            'default' => "Kintamani|/tours/?location=kintamani\nUbud|/tours/?location=ubud\nUluwatu|/tours/?location=uluwatu\nNusa Penida|/tours/?location=nusa-penida\nKarangasem|/tours/?location=karangasem\nSingaraja|/tours/?location=singaraja",
            'description' => esc_html__('Format: Label|URL', 'bestbalitravel'),
        ]);

        $this->end_controls_section();

        // ============================================
        // CONTACT INFO
        // ============================================
        $this->start_controls_section('section_contact', [
            'label' => esc_html__('Contact Info', 'bestbalitravel'),
            'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
        ]);

        $this->add_control('contact_title', [
            'label' => esc_html__('Section Title', 'bestbalitravel'),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => 'Contact Us',
        ]);

        $this->add_control('phone', [
            'label' => esc_html__('Phone', 'bestbalitravel'),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => '+62 878 5480 6011',
        ]);

        $this->add_control('email', [
            'label' => esc_html__('Email', 'bestbalitravel'),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => 'info@bestbalitravel.com',
        ]);

        $this->add_control('address', [
            'label' => esc_html__('Address', 'bestbalitravel'),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => 'Bali, Indonesia',
        ]);

        $this->end_controls_section();

        // ============================================
        // SOCIAL MEDIA
        // ============================================
        $this->start_controls_section('section_social', [
            'label' => esc_html__('Social Media', 'bestbalitravel'),
            'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
        ]);

        $this->add_control('facebook', ['label' => 'Facebook URL', 'type' => \Elementor\Controls_Manager::URL]);
        $this->add_control('instagram', ['label' => 'Instagram URL', 'type' => \Elementor\Controls_Manager::URL]);
        $this->add_control('tiktok', ['label' => 'TikTok URL', 'type' => \Elementor\Controls_Manager::URL]);
        $this->add_control('youtube', ['label' => 'YouTube URL', 'type' => \Elementor\Controls_Manager::URL]);
        $this->add_control('whatsapp', ['label' => 'WhatsApp Number', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '6287854806011']);

        $this->end_controls_section();

        // ============================================
        // COPYRIGHT
        // ============================================
        $this->start_controls_section('section_copyright', [
            'label' => esc_html__('Copyright', 'bestbalitravel'),
            'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
        ]);

        $this->add_control('copyright_text', [
            'label' => esc_html__('Copyright Text', 'bestbalitravel'),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => '© ' . date('Y') . ' BEST BALI TRAVEL. All Rights Reserved.',
        ]);

        $this->add_control('footer_links', [
            'label' => esc_html__('Footer Links', 'bestbalitravel'),
            'type' => \Elementor\Controls_Manager::TEXTAREA,
            'default' => "Privacy Policy|/privacy-policy/\nTerms & Conditions|/terms/\nRefund Policy|/refund-policy/",
        ]);

        $this->end_controls_section();

        // ============================================
        // STYLE - Colors
        // ============================================
        $this->start_controls_section('section_style', [
            'label' => esc_html__('Colors', 'bestbalitravel'),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control('bg_color', [
            'label' => esc_html__('Background', 'bestbalitravel'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#1a1a2e',
        ]);

        $this->add_control('text_color', [
            'label' => esc_html__('Text Color', 'bestbalitravel'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => 'rgba(255,255,255,0.7)',
        ]);

        $this->add_control('heading_color', [
            'label' => esc_html__('Heading Color', 'bestbalitravel'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#ffffff',
        ]);

        $this->add_control('accent_color', [
            'label' => esc_html__('Accent Color', 'bestbalitravel'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#f59e0b',
        ]);

        $this->add_control('link_hover_color', [
            'label' => esc_html__('Link Hover', 'bestbalitravel'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#ffffff',
        ]);

        $this->end_controls_section();
    }

    protected function render()
    {
        $s = $this->get_settings_for_display();
        ?>

<!-- Tailwind -->
<script src="https://cdn.tailwindcss.com"></script>

<style>
/* Full width override */
.elementor-widget-bbt-premium-footer,
.elementor-widget-bbt-premium-footer > .elementor-widget-container {
    width: 100vw !important;
    max-width: none !important;
    margin-left: calc(-50vw + 50%) !important;
    padding: 0 !important;
}
</style>

<footer style="background: <?php echo esc_attr($s['bg_color']); ?>; color: <?php echo esc_attr($s['text_color']); ?>;">
    
    <!-- Main Footer -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10">
            
            <!-- Company Info -->
            <div class="lg:col-span-1">
                <?php if (!empty($s['company_logo']['url'])): ?>
                    <img src="<?php echo esc_url($s['company_logo']['url']); ?>" alt="Logo" class="h-10 w-auto mb-5">
                <?php else: 
                    $name = $s['company_name'];
                    $hl = $s['company_highlight'];
                    $parts = explode($hl, $name, 2);
                ?>
                    <div class="text-xl font-black mb-5" style="color: <?php echo esc_attr($s['heading_color']); ?>;">
                        <?php echo esc_html($parts[0] ?? ''); ?><span style="color: <?php echo esc_attr($s['accent_color']); ?>;"><?php echo esc_html($hl); ?></span><?php echo esc_html($parts[1] ?? ''); ?>
                    </div>
                <?php endif; ?>
                
                <p class="text-sm leading-relaxed mb-6"><?php echo esc_html($s['company_description']); ?></p>
                
                <!-- Social Icons -->
                <div class="flex items-center gap-3">
                    <?php if (!empty($s['facebook']['url'])): ?>
                    <a href="<?php echo esc_url($s['facebook']['url']); ?>" target="_blank" class="w-10 h-10 flex items-center justify-center rounded-full bg-white/10 hover:bg-white/20 transition-colors">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/></svg>
                    </a>
                    <?php endif; ?>
                    <?php if (!empty($s['instagram']['url'])): ?>
                    <a href="<?php echo esc_url($s['instagram']['url']); ?>" target="_blank" class="w-10 h-10 flex items-center justify-center rounded-full bg-white/10 hover:bg-white/20 transition-colors">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37z" fill="none" stroke="currentColor" stroke-width="2"/><circle cx="17.5" cy="6.5" r="1.5"/></svg>
                    </a>
                    <?php endif; ?>
                    <?php if (!empty($s['tiktok']['url'])): ?>
                    <a href="<?php echo esc_url($s['tiktok']['url']); ?>" target="_blank" class="w-10 h-10 flex items-center justify-center rounded-full bg-white/10 hover:bg-white/20 transition-colors">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M19.59 6.69a4.83 4.83 0 01-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 01-5.2 1.74 2.89 2.89 0 012.31-4.64 2.93 2.93 0 01.88.13V9.4a6.84 6.84 0 00-1-.05A6.33 6.33 0 005 20.1a6.34 6.34 0 0010.86-4.43v-7a8.16 8.16 0 004.77 1.52v-3.4a4.85 4.85 0 01-1-.1z"/></svg>
                    </a>
                    <?php endif; ?>
                    <?php if (!empty($s['youtube']['url'])): ?>
                    <a href="<?php echo esc_url($s['youtube']['url']); ?>" target="_blank" class="w-10 h-10 flex items-center justify-center rounded-full bg-white/10 hover:bg-white/20 transition-colors">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M22.54 6.42a2.78 2.78 0 00-1.94-2C18.88 4 12 4 12 4s-6.88 0-8.6.46a2.78 2.78 0 00-1.94 2A29 29 0 001 11.75a29 29 0 00.46 5.33A2.78 2.78 0 003.4 19c1.72.46 8.6.46 8.6.46s6.88 0 8.6-.46a2.78 2.78 0 001.94-2 29 29 0 00.46-5.25 29 29 0 00-.46-5.33z"/><polygon points="9.75 15.02 15.5 11.75 9.75 8.48 9.75 15.02" fill="#1a1a2e"/></svg>
                    </a>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Quick Links -->
            <div>
                <h4 class="text-base font-bold mb-5" style="color: <?php echo esc_attr($s['heading_color']); ?>;"><?php echo esc_html($s['links_title']); ?></h4>
                <ul class="space-y-3">
                    <?php
                    $links = explode("\n", $s['quick_links']);
                    foreach ($links as $link):
                        $parts = explode('|', trim($link));
                        if (count($parts) >= 2):
                    ?>
                    <li>
                        <a href="<?php echo esc_url(trim($parts[1])); ?>" class="text-sm hover:translate-x-1 inline-block transition-transform" style="color: inherit;" onmouseover="this.style.color='<?php echo esc_attr($s['link_hover_color']); ?>'" onmouseout="this.style.color='inherit'">
                            <?php echo esc_html(trim($parts[0])); ?>
                        </a>
                    </li>
                    <?php endif; endforeach; ?>
                </ul>
            </div>
            
            <!-- Destinations -->
            <div>
                <h4 class="text-base font-bold mb-5" style="color: <?php echo esc_attr($s['heading_color']); ?>;"><?php echo esc_html($s['destinations_title']); ?></h4>
                <ul class="space-y-3">
                    <?php
                    $dests = explode("\n", $s['destinations']);
                    foreach ($dests as $dest):
                        $parts = explode('|', trim($dest));
                        if (count($parts) >= 2):
                    ?>
                    <li>
                        <a href="<?php echo esc_url(trim($parts[1])); ?>" class="text-sm hover:translate-x-1 inline-block transition-transform" style="color: inherit;" onmouseover="this.style.color='<?php echo esc_attr($s['link_hover_color']); ?>'" onmouseout="this.style.color='inherit'">
                            <?php echo esc_html(trim($parts[0])); ?>
                        </a>
                    </li>
                    <?php endif; endforeach; ?>
                </ul>
            </div>
            
            <!-- Contact -->
            <div>
                <h4 class="text-base font-bold mb-5" style="color: <?php echo esc_attr($s['heading_color']); ?>;"><?php echo esc_html($s['contact_title']); ?></h4>
                <ul class="space-y-4">
                    <?php if (!empty($s['phone'])): ?>
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 mt-0.5 flex-shrink-0" style="color: <?php echo esc_attr($s['accent_color']); ?>;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        <span class="text-sm"><?php echo esc_html($s['phone']); ?></span>
                    </li>
                    <?php endif; ?>
                    <?php if (!empty($s['email'])): ?>
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 mt-0.5 flex-shrink-0" style="color: <?php echo esc_attr($s['accent_color']); ?>;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        <span class="text-sm"><?php echo esc_html($s['email']); ?></span>
                    </li>
                    <?php endif; ?>
                    <?php if (!empty($s['address'])): ?>
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 mt-0.5 flex-shrink-0" style="color: <?php echo esc_attr($s['accent_color']); ?>;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <span class="text-sm"><?php echo esc_html($s['address']); ?></span>
                    </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
    
    <!-- Bottom Bar -->
    <div class="border-t" style="border-color: rgba(255,255,255,0.1);">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                <p class="text-sm"><?php echo esc_html($s['copyright_text']); ?></p>
                
                <div class="flex flex-wrap items-center justify-center gap-4 md:gap-6">
                    <?php
                    $flinks = explode("\n", $s['footer_links']);
                    foreach ($flinks as $flink):
                        $parts = explode('|', trim($flink));
                        if (count($parts) >= 2):
                    ?>
                    <a href="<?php echo esc_url(trim($parts[1])); ?>" class="text-sm hover:underline" style="color: inherit;" onmouseover="this.style.color='<?php echo esc_attr($s['link_hover_color']); ?>'" onmouseout="this.style.color='inherit'">
                        <?php echo esc_html(trim($parts[0])); ?>
                    </a>
                    <?php endif; endforeach; ?>
                </div>
            </div>
        </div>
    </div>
    
    <!-- WhatsApp Float Button -->
    <?php if (!empty($s['whatsapp'])): ?>
    <a 
        href="https://wa.me/<?php echo esc_attr($s['whatsapp']); ?>" 
        target="_blank"
        class="fixed bottom-6 right-6 w-14 h-14 flex items-center justify-center bg-green-500 hover:bg-green-600 text-white rounded-full shadow-lg hover:scale-110 transition-all z-50"
    >
        <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
    </a>
    <?php endif; ?>
</footer>

<?php
    }
}
