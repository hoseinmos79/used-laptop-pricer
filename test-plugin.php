<?php
/**
 * Test file for Used Laptop Pricer Plugin
 * This file can be used to test basic functionality
 */

// Simulate WordPress environment for testing
if (!defined('ABSPATH')) {
    define('ABSPATH', dirname(__FILE__) . '/');
}

// Test function to verify plugin structure
function test_ulp_plugin() {
    echo "=== Used Laptop Pricer Plugin Test ===\n";
    
    // Check if main plugin file exists
    if (file_exists('used-laptop-pricer.php')) {
        echo "✅ Main plugin file exists\n";
    } else {
        echo "❌ Main plugin file missing\n";
    }
    
    // Check if admin settings page exists
    if (file_exists('admin/settings-page.php')) {
        echo "✅ Admin settings page exists\n";
    } else {
        echo "❌ Admin settings page missing\n";
    }
    
    // Check if form template exists
    if (file_exists('templates/form.php')) {
        echo "✅ Form template exists\n";
    } else {
        echo "❌ Form template missing\n";
    }
    
    // Check if calculation logic exists
    if (file_exists('includes/calculate-price.php')) {
        echo "✅ Price calculation logic exists\n";
    } else {
        echo "❌ Price calculation logic missing\n";
    }
    
    // Check if CSS file exists
    if (file_exists('assets/css/style.css')) {
        echo "✅ CSS styles exist\n";
    } else {
        echo "❌ CSS styles missing\n";
    }
    
    // Check if JavaScript files exist
    if (file_exists('assets/js/form.js')) {
        echo "✅ Frontend JavaScript exists\n";
    } else {
        echo "❌ Frontend JavaScript missing\n";
    }
    
    if (file_exists('assets/js/admin.js')) {
        echo "✅ Admin JavaScript exists\n";
    } else {
        echo "❌ Admin JavaScript missing\n";
    }
    
    echo "\n=== Plugin Structure Test Complete ===\n";
}

// Run test if this file is executed directly
if (basename(__FILE__) === basename($_SERVER['SCRIPT_NAME'])) {
    test_ulp_plugin();
}
?>