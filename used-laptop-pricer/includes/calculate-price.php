<?php
// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Price Calculator Class
 */
class ULP_PriceCalculator {
    
    /**
     * Calculate total price based on selected components
     */
    public function calculate($data) {
        // Sanitize input data
        $brand = sanitize_text_field($data['brand']);
        $model = sanitize_text_field($data['model']);
        $cpu = sanitize_text_field($data['cpu']);
        $ram = sanitize_text_field($data['ram']);
        $gpu = sanitize_text_field($data['gpu']);
        $storage = sanitize_text_field($data['storage']);
        $description = sanitize_textarea_field($data['description']);
        
        // Validate required fields
        if (empty($brand) || empty($model) || empty($cpu) || empty($ram) || empty($gpu) || empty($storage)) {
            return array(
                'success' => false,
                'message' => __('لطفاً تمام فیلدهای ضروری را پر کنید.', 'used-laptop-pricer')
            );
        }
        
        // Get component prices from options
        $cpu_models = get_option('ulp_cpu_models', array());
        $ram_models = get_option('ulp_ram_models', array());
        $gpu_models = get_option('ulp_gpu_models', array());
        $storage_models = get_option('ulp_storage_models', array());
        
        // Calculate component prices
        $cpu_price = isset($cpu_models[$cpu]) ? $cpu_models[$cpu] : 0;
        $ram_price = isset($ram_models[$ram]) ? $ram_models[$ram] : 0;
        $gpu_price = isset($gpu_models[$gpu]) ? $gpu_models[$gpu] : 0;
        $storage_price = isset($storage_models[$storage]) ? $storage_models[$storage] : 0;
        
        // Calculate total price
        $total_price = $cpu_price + $ram_price + $gpu_price + $storage_price;
        
        // Apply depreciation factor for used laptops (typically 60-80% of new price)
        $depreciation_factor = 0.7; // 70% of new price
        $final_price = round($total_price * $depreciation_factor);
        
        // Prepare price breakdown
        $breakdown = array(
            'cpu' => array(
                'name' => $cpu,
                'price' => $cpu_price,
                'depreciated_price' => round($cpu_price * $depreciation_factor)
            ),
            'ram' => array(
                'name' => $ram,
                'price' => $ram_price,
                'depreciated_price' => round($ram_price * $depreciation_factor)
            ),
            'gpu' => array(
                'name' => $gpu,
                'price' => $gpu_price,
                'depreciated_price' => round($gpu_price * $depreciation_factor)
            ),
            'storage' => array(
                'name' => $storage,
                'price' => $storage_price,
                'depreciated_price' => round($storage_price * $depreciation_factor)
            )
        );
        
        // Format prices for display
        $formatted_breakdown = array();
        foreach ($breakdown as $component => $data) {
            if ($data['price'] > 0) {
                $formatted_breakdown[] = array(
                    'component' => $this->get_component_name($component),
                    'model' => $data['name'],
                    'original_price' => number_format($data['price']),
                    'depreciated_price' => number_format($data['depreciated_price'])
                );
            }
        }
        
        return array(
            'success' => true,
            'total_price' => $final_price,
            'formatted_price' => number_format($final_price),
            'breakdown' => $formatted_breakdown,
            'laptop_info' => array(
                'brand' => $brand,
                'model' => $model,
                'description' => $description
            ),
            'depreciation_factor' => $depreciation_factor * 100
        );
    }
    
    /**
     * Get Persian component names
     */
    private function get_component_name($component) {
        $names = array(
            'cpu' => __('پردازنده', 'used-laptop-pricer'),
            'ram' => __('حافظه', 'used-laptop-pricer'),
            'gpu' => __('کارت گرافیک', 'used-laptop-pricer'),
            'storage' => __('حافظه ذخیره‌سازی', 'used-laptop-pricer')
        );
        
        return isset($names[$component]) ? $names[$component] : $component;
    }
}