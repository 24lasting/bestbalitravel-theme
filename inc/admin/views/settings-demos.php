<?php
/**
 * Demo Themes Settings Tab
 *
 * @package BestBaliTravel
 */

if (!defined('ABSPATH')) {
    exit;
}

$settings = get_option('bbt_settings', array());
$active_demo = $settings['active_demo'] ?? 'tropical-paradise';

$demos = array(
    'tropical-paradise' => array(
        'name' => 'Tropical Paradise',
        'description' => 'Warm sunset colors with palm leaf decorations. Perfect for adventure-focused travel sites.',
        'colors' => array(
            'primary' => '#FF6B35',
            'secondary' => '#20B2AA',
            'accent' => '#FFD93D',
            'background' => '#FFF8F0',
        ),
        'fonts' => array(
            'heading' => 'Fraunces',
            'body' => 'Outfit',
        ),
        'features' => array('Parallax Hero', 'Floating Cards', 'Wave Patterns'),
        'icon' => '🌴',
    ),
    'ocean-breeze' => array(
        'name' => 'Ocean Breeze',
        'description' => 'Cool navy and aqua with glassmorphism effects. Modern and serene aesthetic.',
        'colors' => array(
            'primary' => '#0A1628',
            'secondary' => '#00D4FF',
            'accent' => '#10B981',
            'background' => '#FFFFFF',
        ),
        'fonts' => array(
            'heading' => 'Space Grotesk',
            'body' => 'Inter',
        ),
        'features' => array('Glass Cards', 'Gradient Mesh', 'Smooth Animations'),
        'icon' => '🌊',
    ),
    'sunset-luxury' => array(
        'name' => 'Sunset Luxury',
        'description' => 'Premium dark theme with gold accents. Sophisticated and exclusive feel.',
        'colors' => array(
            'primary' => '#1A1A2E',
            'secondary' => '#F5A623',
            'accent' => '#FF6B6B',
            'background' => '#0F0F1A',
        ),
        'fonts' => array(
            'heading' => 'Playfair Display',
            'body' => 'Satoshi',
        ),
        'features' => array('Art Deco Patterns', 'Gold Accents', 'Parallax Layers'),
        'icon' => '✨',
    ),
);
?>

<div class="wrap bbt-demos-wrap">
    <h1 class="bbt-demos-title">
        <span class="dashicons dashicons-art"></span>
        <?php esc_html_e('Demo Themes', 'bestbalitravel'); ?>
    </h1>

    <p class="bbt-demos-description">
        <?php esc_html_e('Choose a pre-designed theme style for your website. Each theme includes unique colors, typography, and animations.', 'bestbalitravel'); ?>
    </p>

    <div class="bbt-demos-grid">
        <?php foreach ($demos as $key => $demo):
            $is_active = ($active_demo === $key);
            ?>
            <div class="bbt-demo-card <?php echo $is_active ? 'active' : ''; ?>" data-demo="<?php echo esc_attr($key); ?>">
                <!-- Demo Preview -->
                <div class="bbt-demo-preview" style="background: <?php echo esc_attr($demo['colors']['background']); ?>;">
                    <div class="bbt-demo-preview-header"
                        style="background: <?php echo esc_attr($demo['colors']['primary']); ?>;"></div>
                    <div class="bbt-demo-preview-content">
                        <div class="bbt-preview-hero"
                            style="background: linear-gradient(135deg, <?php echo esc_attr($demo['colors']['primary']); ?>, <?php echo esc_attr($demo['colors']['secondary']); ?>);">
                        </div>
                        <div class="bbt-preview-cards">
                            <div class="bbt-preview-card"
                                style="border-top: 3px solid <?php echo esc_attr($demo['colors']['accent']); ?>;"></div>
                            <div class="bbt-preview-card"
                                style="border-top: 3px solid <?php echo esc_attr($demo['colors']['accent']); ?>;"></div>
                            <div class="bbt-preview-card"
                                style="border-top: 3px solid <?php echo esc_attr($demo['colors']['accent']); ?>;"></div>
                        </div>
                    </div>
                    <span class="bbt-demo-icon">
                        <?php echo esc_html($demo['icon']); ?>
                    </span>
                    <?php if ($is_active): ?>
                        <span class="bbt-demo-active-badge">
                            <?php esc_html_e('Active', 'bestbalitravel'); ?>
                        </span>
                    <?php endif; ?>
                </div>

                <!-- Demo Info -->
                <div class="bbt-demo-info">
                    <h3 class="bbt-demo-name">
                        <?php echo esc_html($demo['name']); ?>
                    </h3>
                    <p class="bbt-demo-description">
                        <?php echo esc_html($demo['description']); ?>
                    </p>

                    <!-- Color Palette -->
                    <div class="bbt-demo-colors">
                        <?php foreach ($demo['colors'] as $color): ?>
                            <span class="bbt-color-dot" style="background: <?php echo esc_attr($color); ?>;"
                                title="<?php echo esc_attr($color); ?>"></span>
                        <?php endforeach; ?>
                    </div>

                    <!-- Fonts -->
                    <div class="bbt-demo-fonts">
                        <span class="dashicons dashicons-editor-textcolor"></span>
                        <?php echo esc_html($demo['fonts']['heading'] . ' + ' . $demo['fonts']['body']); ?>
                    </div>

                    <!-- Features -->
                    <div class="bbt-demo-features">
                        <?php foreach ($demo['features'] as $feature): ?>
                            <span class="bbt-feature-tag">
                                <?php echo esc_html($feature); ?>
                            </span>
                        <?php endforeach; ?>
                    </div>

                    <!-- Actions -->
                    <div class="bbt-demo-actions">
                        <button type="button" class="button bbt-preview-demo" data-demo="<?php echo esc_attr($key); ?>">
                            <span class="dashicons dashicons-visibility"></span>
                            <?php esc_html_e('Preview', 'bestbalitravel'); ?>
                        </button>
                        <?php if (!$is_active): ?>
                            <button type="button" class="button button-primary bbt-activate-demo"
                                data-demo="<?php echo esc_attr($key); ?>">
                                <span class="dashicons dashicons-yes"></span>
                                <?php esc_html_e('Activate', 'bestbalitravel'); ?>
                            </button>
                        <?php else: ?>
                            <button type="button" class="button button-primary" disabled>
                                <span class="dashicons dashicons-yes-alt"></span>
                                <?php esc_html_e('Active', 'bestbalitravel'); ?>
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Demo Import Section -->
    <div class="bbt-import-section">
        <h2>
            <?php esc_html_e('Import Demo Content', 'bestbalitravel'); ?>
        </h2>
        <p>
            <?php esc_html_e('Import sample tours, pages, and settings to quickly set up your website.', 'bestbalitravel'); ?>
        </p>

        <div class="bbt-import-options">
            <label class="bbt-import-option">
                <input type="checkbox" name="import_tours" value="1" checked>
                <span class="bbt-option-content">
                    <span class="dashicons dashicons-palmtree"></span>
                    <strong>
                        <?php esc_html_e('Sample Tours', 'bestbalitravel'); ?>
                    </strong>
                    <small>
                        <?php esc_html_e('6 tours with images', 'bestbalitravel'); ?>
                    </small>
                </span>
            </label>

            <label class="bbt-import-option">
                <input type="checkbox" name="import_pages" value="1" checked>
                <span class="bbt-option-content">
                    <span class="dashicons dashicons-admin-page"></span>
                    <strong>
                        <?php esc_html_e('Pages', 'bestbalitravel'); ?>
                    </strong>
                    <small>
                        <?php esc_html_e('Home, About, Contact', 'bestbalitravel'); ?>
                    </small>
                </span>
            </label>

            <label class="bbt-import-option">
                <input type="checkbox" name="import_menus" value="1" checked>
                <span class="bbt-option-content">
                    <span class="dashicons dashicons-menu"></span>
                    <strong>
                        <?php esc_html_e('Menus', 'bestbalitravel'); ?>
                    </strong>
                    <small>
                        <?php esc_html_e('Navigation menus', 'bestbalitravel'); ?>
                    </small>
                </span>
            </label>

            <label class="bbt-import-option">
                <input type="checkbox" name="import_widgets" value="1" checked>
                <span class="bbt-option-content">
                    <span class="dashicons dashicons-welcome-widgets-menus"></span>
                    <strong>
                        <?php esc_html_e('Widgets', 'bestbalitravel'); ?>
                    </strong>
                    <small>
                        <?php esc_html_e('Sidebar widgets', 'bestbalitravel'); ?>
                    </small>
                </span>
            </label>
        </div>

        <button type="button" class="button button-hero button-primary bbt-import-demo-content">
            <span class="dashicons dashicons-download"></span>
            <?php esc_html_e('Import Demo Content', 'bestbalitravel'); ?>
        </button>

        <div class="bbt-import-progress" style="display: none;">
            <div class="bbt-progress-bar">
                <div class="bbt-progress-fill"></div>
            </div>
            <span class="bbt-progress-text">
                <?php esc_html_e('Importing...', 'bestbalitravel'); ?>
            </span>
        </div>
    </div>
</div>

<style>
    .bbt-demos-wrap {
        max-width: 1400px;
    }

    .bbt-demos-title {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 24px;
        margin-bottom: 10px;
    }

    .bbt-demos-description {
        font-size: 15px;
        color: #666;
        margin-bottom: 30px;
    }

    .bbt-demos-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(380px, 1fr));
        gap: 25px;
        margin-bottom: 40px;
    }

    .bbt-demo-card {
        background: #fff;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        border: 3px solid transparent;
    }

    .bbt-demo-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.12);
    }

    .bbt-demo-card.active {
        border-color: #f5a623;
    }

    .bbt-demo-preview {
        position: relative;
        height: 200px;
        padding: 15px;
        overflow: hidden;
    }

    .bbt-demo-preview-header {
        height: 25px;
        border-radius: 6px 6px 0 0;
        margin-bottom: 10px;
    }

    .bbt-demo-preview-content {
        background: rgba(255, 255, 255, 0.9);
        border-radius: 0 0 6px 6px;
        height: calc(100% - 35px);
        padding: 10px;
    }

    .bbt-preview-hero {
        height: 50%;
        border-radius: 4px;
        margin-bottom: 10px;
    }

    .bbt-preview-cards {
        display: flex;
        gap: 8px;
    }

    .bbt-preview-card {
        flex: 1;
        height: 40px;
        background: #fff;
        border-radius: 4px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
    }

    .bbt-demo-icon {
        position: absolute;
        top: 15px;
        right: 15px;
        font-size: 32px;
        filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.2));
    }

    .bbt-demo-active-badge {
        position: absolute;
        top: 15px;
        left: 15px;
        padding: 4px 12px;
        background: #10b981;
        color: #fff;
        font-size: 12px;
        font-weight: 600;
        border-radius: 20px;
    }

    .bbt-demo-info {
        padding: 20px;
    }

    .bbt-demo-name {
        margin: 0 0 8px;
        font-size: 20px;
        color: #1e3a5f;
    }

    .bbt-demo-description {
        color: #666;
        font-size: 14px;
        line-height: 1.5;
        margin-bottom: 15px;
    }

    .bbt-demo-colors {
        display: flex;
        gap: 8px;
        margin-bottom: 12px;
    }

    .bbt-color-dot {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        border: 2px solid #fff;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
        cursor: pointer;
    }

    .bbt-demo-fonts {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 13px;
        color: #666;
        margin-bottom: 12px;
    }

    .bbt-demo-features {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        margin-bottom: 15px;
    }

    .bbt-feature-tag {
        padding: 4px 10px;
        background: #f0f0f0;
        border-radius: 20px;
        font-size: 11px;
        color: #555;
    }

    .bbt-demo-actions {
        display: flex;
        gap: 10px;
    }

    .bbt-demo-actions .button {
        display: flex;
        align-items: center;
        gap: 5px;
        flex: 1;
        justify-content: center;
    }

    /* Import Section */
    .bbt-import-section {
        background: #fff;
        border-radius: 16px;
        padding: 30px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    }

    .bbt-import-section h2 {
        margin-top: 0;
    }

    .bbt-import-options {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
        margin: 20px 0;
    }

    .bbt-import-option {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 15px;
        background: #f9f9f9;
        border: 2px solid #e0e0e0;
        border-radius: 10px;
        cursor: pointer;
        transition: all 0.2s;
    }

    .bbt-import-option:hover {
        border-color: #f5a623;
    }

    .bbt-import-option:has(input:checked) {
        border-color: #f5a623;
        background: #fffbf5;
    }

    .bbt-option-content {
        display: flex;
        flex-direction: column;
    }

    .bbt-option-content .dashicons {
        color: #f5a623;
        margin-bottom: 5px;
    }

    .bbt-option-content strong {
        font-size: 14px;
    }

    .bbt-option-content small {
        color: #666;
        font-size: 12px;
    }

    .bbt-import-demo-content {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 15px 30px !important;
        font-size: 15px !important;
    }

    .bbt-import-progress {
        margin-top: 20px;
    }

    .bbt-progress-bar {
        height: 10px;
        background: #e0e0e0;
        border-radius: 5px;
        overflow: hidden;
    }

    .bbt-progress-fill {
        height: 100%;
        width: 0%;
        background: linear-gradient(90deg, #f5a623, #ff6b6b);
        border-radius: 5px;
        transition: width 0.3s;
    }

    .bbt-progress-text {
        display: block;
        margin-top: 8px;
        font-size: 13px;
        color: #666;
    }
</style>

<script>
    jQuery(document).ready(function ($) {
        // Activate Demo
        $('.bbt-activate-demo').on('click', function () {
            var demo = $(this).data('demo');
            var $btn = $(this);

            $btn.prop('disabled', true).text('Activating...');

            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                    action: 'bbt_activate_demo',
                    demo: demo,
                    nonce: '<?php echo wp_create_nonce('bbt_admin_nonce'); ?>'
            },
                success: function (response) {
                    if (response.success) {
                        location.reload();
                    } else {
                        alert('Error: ' + response.data.message);
                        $btn.prop('disabled', false).text('Activate');
                    }
                }
            });
        });

        // Preview Demo
        $('.bbt-preview-demo').on('click', function () {
            var demo = $(this).data('demo');
            window.open('<?php echo home_url('?bbt_demo_preview='); ?>' + demo, '_blank');
        });

        // Import Demo Content
        $('.bbt-import-demo-content').on('click', function () {
            var $btn = $(this);
            var $progress = $('.bbt-import-progress');
            var $fill = $('.bbt-progress-fill');
            var $text = $('.bbt-progress-text');

            $btn.prop('disabled', true);
            $progress.show();

            // Simulate progress
            var progress = 0;
            var interval = setInterval(function () {
                progress += Math.random() * 15;
                if (progress > 90) progress = 90;
                $fill.css('width', progress + '%');
            }, 500);

            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                    action: 'bbt_import_demo_content',
                    tours: $('[name="import_tours"]').is(':checked') ? 1 : 0,
                    pages: $('[name="import_pages"]').is(':checked') ? 1 : 0,
                    menus: $('[name="import_menus"]').is(':checked') ? 1 : 0,
                    widgets: $('[name="import_widgets"]').is(':checked') ? 1 : 0,
                    nonce: '<?php echo wp_create_nonce('bbt_admin_nonce'); ?>'
            },
                success: function (response) {
                    clearInterval(interval);
                    $fill.css('width', '100%');

                    if (response.success) {
                        $text.text('✓ Import completed successfully!');
                        setTimeout(function () {
                            location.reload();
                        }, 1500);
                    } else {
                        $text.text('✗ Error: ' + response.data.message);
                        $btn.prop('disabled', false);
                    }
                },
                error: function () {
                    clearInterval(interval);
                    $text.text('✗ Import failed. Please try again.');
                    $btn.prop('disabled', false);
                }
            });
        });
    });
</script>