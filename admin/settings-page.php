<?php
// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ulp_action'])) {
    handle_form_submission();
}

// Get current models
$cpu_models = get_option('ulp_cpu_models', array());
$ram_models = get_option('ulp_ram_models', array());
$gpu_models = get_option('ulp_gpu_models', array());
$storage_models = get_option('ulp_storage_models', array());
?>

<div class="wrap">
    <h1><?php _e('مدیریت مدل‌های قطعات لپ‌تاپ', 'used-laptop-pricer'); ?></h1>
    
    <div class="ulp-admin-container">
        <!-- CPU Models -->
        <div class="ulp-section">
            <h2><?php _e('مدل‌های پردازنده (CPU)', 'used-laptop-pricer'); ?></h2>
            <form method="post" class="ulp-form">
                <input type="hidden" name="ulp_action" value="add_cpu">
                <?php wp_nonce_field('ulp_admin_nonce', 'ulp_nonce'); ?>
                <div class="ulp-form-row">
                    <input type="text" name="model_name" placeholder="<?php _e('نام مدل (مثل: i5-1135G7)', 'used-laptop-pricer'); ?>" required>
                    <input type="number" name="model_price" placeholder="<?php _e('قیمت (تومان)', 'used-laptop-pricer'); ?>" required>
                    <button type="submit" class="button button-primary"><?php _e('افزودن', 'used-laptop-pricer'); ?></button>
                </div>
            </form>
            
            <div class="ulp-models-list">
                <?php foreach ($cpu_models as $model => $price): ?>
                <div class="ulp-model-item">
                    <span class="ulp-model-name"><?php echo esc_html($model); ?></span>
                    <span class="ulp-model-price"><?php echo number_format($price); ?> تومان</span>
                    <form method="post" style="display: inline;">
                        <input type="hidden" name="ulp_action" value="delete_cpu">
                        <input type="hidden" name="model_name" value="<?php echo esc_attr($model); ?>">
                        <?php wp_nonce_field('ulp_admin_nonce', 'ulp_nonce'); ?>
                        <button type="submit" class="button button-small button-link-delete"><?php _e('حذف', 'used-laptop-pricer'); ?></button>
                    </form>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- RAM Models -->
        <div class="ulp-section">
            <h2><?php _e('مدل‌های حافظه (RAM)', 'used-laptop-pricer'); ?></h2>
            <form method="post" class="ulp-form">
                <input type="hidden" name="ulp_action" value="add_ram">
                <?php wp_nonce_field('ulp_admin_nonce', 'ulp_nonce'); ?>
                <div class="ulp-form-row">
                    <input type="text" name="model_name" placeholder="<?php _e('نام مدل (مثل: 8GB DDR4)', 'used-laptop-pricer'); ?>" required>
                    <input type="number" name="model_price" placeholder="<?php _e('قیمت (تومان)', 'used-laptop-pricer'); ?>" required>
                    <button type="submit" class="button button-primary"><?php _e('افزودن', 'used-laptop-pricer'); ?></button>
                </div>
            </form>
            
            <div class="ulp-models-list">
                <?php foreach ($ram_models as $model => $price): ?>
                <div class="ulp-model-item">
                    <span class="ulp-model-name"><?php echo esc_html($model); ?></span>
                    <span class="ulp-model-price"><?php echo number_format($price); ?> تومان</span>
                    <form method="post" style="display: inline;">
                        <input type="hidden" name="ulp_action" value="delete_ram">
                        <input type="hidden" name="model_name" value="<?php echo esc_attr($model); ?>">
                        <?php wp_nonce_field('ulp_admin_nonce', 'ulp_nonce'); ?>
                        <button type="submit" class="button button-small button-link-delete"><?php _e('حذف', 'used-laptop-pricer'); ?></button>
                    </form>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- GPU Models -->
        <div class="ulp-section">
            <h2><?php _e('مدل‌های کارت گرافیک (GPU)', 'used-laptop-pricer'); ?></h2>
            <form method="post" class="ulp-form">
                <input type="hidden" name="ulp_action" value="add_gpu">
                <?php wp_nonce_field('ulp_admin_nonce', 'ulp_nonce'); ?>
                <div class="ulp-form-row">
                    <input type="text" name="model_name" placeholder="<?php _e('نام مدل (مثل: GTX 1650)', 'used-laptop-pricer'); ?>" required>
                    <input type="number" name="model_price" placeholder="<?php _e('قیمت (تومان)', 'used-laptop-pricer'); ?>" required>
                    <button type="submit" class="button button-primary"><?php _e('افزودن', 'used-laptop-pricer'); ?></button>
                </div>
            </form>
            
            <div class="ulp-models-list">
                <?php foreach ($gpu_models as $model => $price): ?>
                <div class="ulp-model-item">
                    <span class="ulp-model-name"><?php echo esc_html($model); ?></span>
                    <span class="ulp-model-price"><?php echo number_format($price); ?> تومان</span>
                    <form method="post" style="display: inline;">
                        <input type="hidden" name="ulp_action" value="delete_gpu">
                        <input type="hidden" name="model_name" value="<?php echo esc_attr($model); ?>">
                        <?php wp_nonce_field('ulp_admin_nonce', 'ulp_nonce'); ?>
                        <button type="submit" class="button button-small button-link-delete"><?php _e('حذف', 'used-laptop-pricer'); ?></button>
                    </form>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Storage Models -->
        <div class="ulp-section">
            <h2><?php _e('مدل‌های حافظه ذخیره‌سازی (Storage)', 'used-laptop-pricer'); ?></h2>
            <form method="post" class="ulp-form">
                <input type="hidden" name="ulp_action" value="add_storage">
                <?php wp_nonce_field('ulp_admin_nonce', 'ulp_nonce'); ?>
                <div class="ulp-form-row">
                    <input type="text" name="model_name" placeholder="<?php _e('نام مدل (مثل: 512GB SSD)', 'used-laptop-pricer'); ?>" required>
                    <input type="number" name="model_price" placeholder="<?php _e('قیمت (تومان)', 'used-laptop-pricer'); ?>" required>
                    <button type="submit" class="button button-primary"><?php _e('افزودن', 'used-laptop-pricer'); ?></button>
                </div>
            </form>
            
            <div class="ulp-models-list">
                <?php foreach ($storage_models as $model => $price): ?>
                <div class="ulp-model-item">
                    <span class="ulp-model-name"><?php echo esc_html($model); ?></span>
                    <span class="ulp-model-price"><?php echo number_format($price); ?> تومان</span>
                    <form method="post" style="display: inline;">
                        <input type="hidden" name="ulp_action" value="delete_storage">
                        <input type="hidden" name="model_name" value="<?php echo esc_attr($model); ?>">
                        <?php wp_nonce_field('ulp_admin_nonce', 'ulp_nonce'); ?>
                        <button type="submit" class="button button-small button-link-delete"><?php _e('حذف', 'used-laptop-pricer'); ?></button>
                    </form>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<?php
/**
 * Handle form submissions
 */
function handle_form_submission() {
    if (!wp_verify_nonce($_POST['ulp_nonce'], 'ulp_admin_nonce')) {
        wp_die(__('خطای امنیتی', 'used-laptop-pricer'));
    }
    
    $action = sanitize_text_field($_POST['ulp_action']);
    $model_name = sanitize_text_field($_POST['model_name']);
    $model_price = intval($_POST['model_price']);
    
    switch ($action) {
        case 'add_cpu':
            $cpu_models = get_option('ulp_cpu_models', array());
            $cpu_models[$model_name] = $model_price;
            update_option('ulp_cpu_models', $cpu_models);
            break;
            
        case 'delete_cpu':
            $cpu_models = get_option('ulp_cpu_models', array());
            unset($cpu_models[$model_name]);
            update_option('ulp_cpu_models', $cpu_models);
            break;
            
        case 'add_ram':
            $ram_models = get_option('ulp_ram_models', array());
            $ram_models[$model_name] = $model_price;
            update_option('ulp_ram_models', $ram_models);
            break;
            
        case 'delete_ram':
            $ram_models = get_option('ulp_ram_models', array());
            unset($ram_models[$model_name]);
            update_option('ulp_ram_models', $ram_models);
            break;
            
        case 'add_gpu':
            $gpu_models = get_option('ulp_gpu_models', array());
            $gpu_models[$model_name] = $model_price;
            update_option('ulp_gpu_models', $gpu_models);
            break;
            
        case 'delete_gpu':
            $gpu_models = get_option('ulp_gpu_models', array());
            unset($gpu_models[$model_name]);
            update_option('ulp_gpu_models', $gpu_models);
            break;
            
        case 'add_storage':
            $storage_models = get_option('ulp_storage_models', array());
            $storage_models[$model_name] = $model_price;
            update_option('ulp_storage_models', $storage_models);
            break;
            
        case 'delete_storage':
            $storage_models = get_option('ulp_storage_models', array());
            unset($storage_models[$model_name]);
            update_option('ulp_storage_models', $storage_models);
            break;
    }
    
    // Redirect to prevent form resubmission
    wp_redirect(admin_url('admin.php?page=used-laptop-pricer&updated=true'));
    exit;
}
?>