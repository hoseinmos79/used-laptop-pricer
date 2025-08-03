<?php
/**
 * Plugin Name: Used Laptop Pricer
 * Plugin URI: https://github.com/hoseinmos/used-laptop-pricer
 * Description: افزونه تخمین قیمت لپ‌تاپ‌های دست دوم با انتخاب مدل قطعات
 * Version: 3.4
 * Author: hoseinmos
 * Author URI: https://github.com/hoseinmos
 * Text Domain: used-laptop-pricer
 * Domain Path: /languages
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('ULP_PLUGIN_URL', plugin_dir_url(__FILE__));
define('ULP_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('ULP_PLUGIN_VERSION', '3.4');

/**
 * Main plugin class
 */
class UsedLaptopPricer {
    
    public function __construct() {
        add_action('init', array($this, 'init'));
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
        add_action('admin_enqueue_scripts', array($this, 'admin_enqueue_scripts'));
        add_action('admin_menu', array($this, 'add_admin_menu'));
        add_action('wp_ajax_ulp_calculate_price', array($this, 'calculate_price'));
        add_action('wp_ajax_nopriv_ulp_calculate_price', array($this, 'calculate_price'));
        add_shortcode('used_laptop_pricer', array($this, 'render_form'));
        
        // Activation hook
        register_activation_hook(__FILE__, array($this, 'activate'));
    }
    
    /**
     * Initialize plugin
     */
    public function init() {
        // Load text domain for translations
        load_plugin_textdomain('used-laptop-pricer', false, dirname(plugin_basename(__FILE__)) . '/languages');
    }
    
    /**
     * Enqueue frontend scripts and styles
     */
    public function enqueue_scripts() {
        wp_enqueue_style(
            'ulp-style',
            ULP_PLUGIN_URL . 'assets/css/style.css',
            array(),
            ULP_PLUGIN_VERSION
        );
        
        wp_enqueue_script(
            'ulp-form-js',
            ULP_PLUGIN_URL . 'assets/js/form.js',
            array('jquery'),
            ULP_PLUGIN_VERSION,
            true
        );
        
        // Localize script for AJAX
        wp_localize_script('ulp-form-js', 'ulp_ajax', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('ulp_nonce'),
            'strings' => array(
                'calculating' => __('در حال محاسبه...', 'used-laptop-pricer'),
                'error' => __('خطا در محاسبه قیمت', 'used-laptop-pricer')
            )
        ));
    }
    
    /**
     * Enqueue admin scripts and styles
     */
    public function admin_enqueue_scripts($hook) {
        if ('toplevel_page_used-laptop-pricer' !== $hook) {
            return;
        }
        
        wp_enqueue_style(
            'ulp-admin-style',
            ULP_PLUGIN_URL . 'assets/css/style.css',
            array(),
            ULP_PLUGIN_VERSION
        );
        
        wp_enqueue_script(
            'ulp-admin-js',
            ULP_PLUGIN_URL . 'assets/js/admin.js',
            array('jquery'),
            ULP_PLUGIN_VERSION,
            true
        );
    }
    
    /**
     * Add admin menu
     */
    public function add_admin_menu() {
        add_menu_page(
            __('تخمین قیمت لپ‌تاپ', 'used-laptop-pricer'),
            __('لپ‌تاپ پرایسر', 'used-laptop-pricer'),
            'manage_options',
            'used-laptop-pricer',
            array($this, 'admin_page'),
            'dashicons-laptop',
            30
        );
    }
    
    /**
     * Render admin page
     */
    public function admin_page() {
        require_once ULP_PLUGIN_PATH . 'admin/settings-page.php';
    }
    
    /**
     * Render form shortcode
     */
    public function render_form($atts) {
        $atts = shortcode_atts(array(
            'title' => __('تخمین قیمت لپ‌تاپ دست دوم', 'used-laptop-pricer')
        ), $atts);
        
        ob_start();
        include ULP_PLUGIN_PATH . 'templates/form.php';
        return ob_get_clean();
    }
    
    /**
     * Handle AJAX price calculation
     */
    public function calculate_price() {
        // Verify nonce
        if (!wp_verify_nonce($_POST['nonce'], 'ulp_nonce')) {
            wp_die(__('خطای امنیتی', 'used-laptop-pricer'));
        }
        
        // Include calculation logic
        require_once ULP_PLUGIN_PATH . 'includes/calculate-price.php';
        
        $calculator = new ULP_PriceCalculator();
        $result = $calculator->calculate($_POST);
        
        wp_send_json($result);
    }
    
    /**
     * Plugin activation
     */
    public function activate() {
        // Set default options if not exists
        if (!get_option('ulp_cpu_models')) {
            update_option('ulp_cpu_models', array());
        }
        if (!get_option('ulp_ram_models')) {
            update_option('ulp_ram_models', array());
        }
        if (!get_option('ulp_gpu_models')) {
            update_option('ulp_gpu_models', array());
        }
        if (!get_option('ulp_storage_models')) {
            update_option('ulp_storage_models', array());
        }
    }
}

// Initialize plugin
new UsedLaptopPricer();