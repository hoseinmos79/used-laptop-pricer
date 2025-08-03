<?php
// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Get component models from options
$cpu_models = get_option('ulp_cpu_models', array());
$ram_models = get_option('ulp_ram_models', array());
$gpu_models = get_option('ulp_gpu_models', array());
$storage_models = get_option('ulp_storage_models', array());
?>

<div class="ulp-container">
    <div class="ulp-form-wrapper">
        <h2 class="ulp-form-title"><?php echo esc_html($atts['title']); ?></h2>
        
        <form id="ulp-pricing-form" class="ulp-form">
            <div class="ulp-form-row">
                <div class="ulp-form-group">
                    <label for="ulp-brand"><?php _e('برند لپ‌تاپ', 'used-laptop-pricer'); ?> *</label>
                    <input type="text" id="ulp-brand" name="brand" required 
                           placeholder="<?php _e('مثل: Dell, HP, Lenovo', 'used-laptop-pricer'); ?>">
                </div>
                
                <div class="ulp-form-group">
                    <label for="ulp-model"><?php _e('مدل لپ‌تاپ', 'used-laptop-pricer'); ?> *</label>
                    <input type="text" id="ulp-model" name="model" required 
                           placeholder="<?php _e('مثل: Inspiron 15 3000', 'used-laptop-pricer'); ?>">
                </div>
            </div>
            
            <div class="ulp-form-row">
                <div class="ulp-form-group">
                    <label for="ulp-cpu"><?php _e('پردازنده (CPU)', 'used-laptop-pricer'); ?> *</label>
                    <select id="ulp-cpu" name="cpu" required>
                        <option value=""><?php _e('انتخاب کنید', 'used-laptop-pricer'); ?></option>
                        <?php foreach ($cpu_models as $model => $price): ?>
                        <option value="<?php echo esc_attr($model); ?>" data-price="<?php echo esc_attr($price); ?>">
                            <?php echo esc_html($model); ?> (<?php echo number_format($price); ?> تومان)
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="ulp-form-group">
                    <label for="ulp-ram"><?php _e('حافظه (RAM)', 'used-laptop-pricer'); ?> *</label>
                    <select id="ulp-ram" name="ram" required>
                        <option value=""><?php _e('انتخاب کنید', 'used-laptop-pricer'); ?></option>
                        <?php foreach ($ram_models as $model => $price): ?>
                        <option value="<?php echo esc_attr($model); ?>" data-price="<?php echo esc_attr($price); ?>">
                            <?php echo esc_html($model); ?> (<?php echo number_format($price); ?> تومان)
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            
            <div class="ulp-form-row">
                <div class="ulp-form-group">
                    <label for="ulp-gpu"><?php _e('کارت گرافیک (GPU)', 'used-laptop-pricer'); ?> *</label>
                    <select id="ulp-gpu" name="gpu" required>
                        <option value=""><?php _e('انتخاب کنید', 'used-laptop-pricer'); ?></option>
                        <?php foreach ($gpu_models as $model => $price): ?>
                        <option value="<?php echo esc_attr($model); ?>" data-price="<?php echo esc_attr($price); ?>">
                            <?php echo esc_html($model); ?> (<?php echo number_format($price); ?> تومان)
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="ulp-form-group">
                    <label for="ulp-storage"><?php _e('حافظه ذخیره‌سازی', 'used-laptop-pricer'); ?> *</label>
                    <select id="ulp-storage" name="storage" required>
                        <option value=""><?php _e('انتخاب کنید', 'used-laptop-pricer'); ?></option>
                        <?php foreach ($storage_models as $model => $price): ?>
                        <option value="<?php echo esc_attr($model); ?>" data-price="<?php echo esc_attr($price); ?>">
                            <?php echo esc_html($model); ?> (<?php echo number_format($price); ?> تومان)
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            
            <div class="ulp-form-row">
                <div class="ulp-form-group ulp-full-width">
                    <label for="ulp-description"><?php _e('توضیحات اضافی', 'used-laptop-pricer'); ?></label>
                    <textarea id="ulp-description" name="description" rows="4" 
                              placeholder="<?php _e('توضیحات مربوط به وضعیت لپ‌تاپ، سال تولید، و سایر مشخصات...', 'used-laptop-pricer'); ?>"></textarea>
                </div>
            </div>
            
            <div class="ulp-form-row">
                <div class="ulp-form-group ulp-full-width">
                    <button type="submit" id="ulp-calculate-btn" class="ulp-submit-btn">
                        <?php _e('محاسبه قیمت', 'used-laptop-pricer'); ?>
                    </button>
                </div>
            </div>
        </form>
        
        <!-- Price Result Display -->
        <div id="ulp-price-result" class="ulp-price-result" style="display: none;">
            <div class="ulp-price-header">
                <h3><?php _e('قیمت تخمینی لپ‌تاپ', 'used-laptop-pricer'); ?></h3>
            </div>
            <div class="ulp-price-content">
                <div class="ulp-price-amount">
                    <span id="ulp-total-price">0</span>
                    <span class="ulp-currency">تومان</span>
                </div>
                <div class="ulp-price-breakdown" id="ulp-price-breakdown">
                    <!-- Price breakdown will be populated by JavaScript -->
                </div>
            </div>
        </div>
        
        <!-- Loading Indicator -->
        <div id="ulp-loading" class="ulp-loading" style="display: none;">
            <div class="ulp-spinner"></div>
            <p><?php _e('در حال محاسبه قیمت...', 'used-laptop-pricer'); ?></p>
        </div>
        
        <!-- Error Display -->
        <div id="ulp-error" class="ulp-error" style="display: none;">
            <p id="ulp-error-message"></p>
        </div>
    </div>
</div>