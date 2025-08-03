jQuery(document).ready(function($) {
    
    // Form submission handler
    $('#ulp-pricing-form').on('submit', function(e) {
        e.preventDefault();
        
        // Show loading indicator
        showLoading();
        
        // Get form data
        var formData = {
            action: 'ulp_calculate_price',
            nonce: ulp_ajax.nonce,
            brand: $('#ulp-brand').val(),
            model: $('#ulp-model').val(),
            cpu: $('#ulp-cpu').val(),
            ram: $('#ulp-ram').val(),
            gpu: $('#ulp-gpu').val(),
            storage: $('#ulp-storage').val(),
            description: $('#ulp-description').val()
        };
        
        // Send AJAX request
        $.ajax({
            url: ulp_ajax.ajax_url,
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                hideLoading();
                
                if (response.success) {
                    displayPriceResult(response);
                } else {
                    showError(response.message || ulp_ajax.strings.error);
                }
            },
            error: function(xhr, status, error) {
                hideLoading();
                showError(ulp_ajax.strings.error);
                console.error('AJAX Error:', error);
            }
        });
    });
    
    /**
     * Show loading indicator
     */
    function showLoading() {
        $('#ulp-loading').show();
        $('#ulp-price-result').hide();
        $('#ulp-error').hide();
        $('#ulp-calculate-btn').prop('disabled', true).text(ulp_ajax.strings.calculating);
    }
    
    /**
     * Hide loading indicator
     */
    function hideLoading() {
        $('#ulp-loading').hide();
        $('#ulp-calculate-btn').prop('disabled', false).text('محاسبه قیمت');
    }
    
    /**
     * Display price calculation result
     */
    function displayPriceResult(data) {
        // Update total price
        $('#ulp-total-price').text(data.formatted_price);
        
        // Build price breakdown
        var breakdownHtml = '<div class="ulp-breakdown-title">جزئیات قیمت:</div>';
        breakdownHtml += '<div class="ulp-breakdown-items">';
        
        data.breakdown.forEach(function(item) {
            breakdownHtml += '<div class="ulp-breakdown-item">';
            breakdownHtml += '<span class="ulp-breakdown-component">' + item.component + ':</span>';
            breakdownHtml += '<span class="ulp-breakdown-model">' + item.model + '</span>';
            breakdownHtml += '<span class="ulp-breakdown-price">' + item.depreciated_price + ' تومان</span>';
            breakdownHtml += '</div>';
        });
        
        breakdownHtml += '</div>';
        breakdownHtml += '<div class="ulp-depreciation-note">';
        breakdownHtml += '<small>قیمت با در نظر گرفتن ' + data.depreciation_factor + '% ارزش دست دوم محاسبه شده است.</small>';
        breakdownHtml += '</div>';
        
        $('#ulp-price-breakdown').html(breakdownHtml);
        
        // Show result
        $('#ulp-price-result').show();
        
        // Scroll to result
        $('html, body').animate({
            scrollTop: $('#ulp-price-result').offset().top - 50
        }, 500);
    }
    
    /**
     * Show error message
     */
    function showError(message) {
        $('#ulp-error-message').text(message);
        $('#ulp-error').show();
        
        // Scroll to error
        $('html, body').animate({
            scrollTop: $('#ulp-error').offset().top - 50
        }, 500);
    }
    
    /**
     * Real-time price preview (optional enhancement)
     */
    $('.ulp-form select').on('change', function() {
        var totalPreview = 0;
        var depreciationFactor = 0.7;
        
        $('.ulp-form select option:selected').each(function() {
            var price = $(this).data('price');
            if (price) {
                totalPreview += parseInt(price);
            }
        });
        
        // Only show preview if all components are selected
        if ($('.ulp-form select').length === $('.ulp-form select option:selected[data-price]').length) {
            var depreciatedPrice = Math.round(totalPreview * depreciationFactor);
            $('#ulp-total-price').text(depreciatedPrice.toLocaleString());
            $('#ulp-price-result').show();
        }
    });
    
    /**
     * Form validation
     */
    $('.ulp-form input, .ulp-form select').on('blur', function() {
        validateField($(this));
    });
    
    function validateField(field) {
        var value = field.val();
        var isRequired = field.prop('required');
        
        if (isRequired && !value) {
            field.addClass('ulp-error-field');
            return false;
        } else {
            field.removeClass('ulp-error-field');
            return true;
        }
    }
    
    /**
     * Clear form
     */
    $('.ulp-form').on('reset', function() {
        $('#ulp-price-result').hide();
        $('#ulp-error').hide();
        $('.ulp-form input, .ulp-form select').removeClass('ulp-error-field');
    });
});