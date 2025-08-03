jQuery(document).ready(function($) {
    
    // Admin form enhancements
    $('.ulp-form').on('submit', function(e) {
        var modelName = $(this).find('input[name="model_name"]').val();
        var modelPrice = $(this).find('input[name="model_price"]').val();
        
        // Basic validation
        if (!modelName || !modelPrice) {
            e.preventDefault();
            alert('لطفاً نام مدل و قیمت را وارد کنید.');
            return false;
        }
        
        // Price validation
        if (isNaN(modelPrice) || modelPrice <= 0) {
            e.preventDefault();
            alert('لطفاً قیمت معتبر وارد کنید.');
            return false;
        }
        
        // Show loading state
        $(this).find('button[type="submit"]').prop('disabled', true).text('در حال ذخیره...');
    });
    
    // Delete confirmation
    $('.button-link-delete').on('click', function(e) {
        if (!confirm('آیا از حذف این مدل اطمینان دارید؟')) {
            e.preventDefault();
            return false;
        }
    });
    
    // Auto-format price input
    $('input[name="model_price"]').on('input', function() {
        var value = $(this).val().replace(/[^\d]/g, '');
        if (value) {
            $(this).val(parseInt(value).toLocaleString());
        }
    });
    
    // Price input focus handler
    $('input[name="model_price"]').on('focus', function() {
        var value = $(this).val().replace(/[^\d]/g, '');
        $(this).val(value);
    });
    
    // Price input blur handler
    $('input[name="model_price"]').on('blur', function() {
        var value = $(this).val().replace(/[^\d]/g, '');
        if (value) {
            $(this).val(parseInt(value).toLocaleString());
        }
    });
    
    // Show success message if updated parameter exists
    if (window.location.search.includes('updated=true')) {
        showSuccessMessage('تنظیمات با موفقیت ذخیره شد.');
    }
    
    function showSuccessMessage(message) {
        var successDiv = $('<div class="notice notice-success is-dismissible"><p>' + message + '</p></div>');
        $('.wrap h1').after(successDiv);
        
        // Auto-dismiss after 3 seconds
        setTimeout(function() {
            successDiv.fadeOut();
        }, 3000);
    }
    
    // Enhanced form validation
    $('.ulp-form input').on('blur', function() {
        validateAdminField($(this));
    });
    
    function validateAdminField(field) {
        var value = field.val();
        var fieldName = field.attr('name');
        
        if (fieldName === 'model_name') {
            if (!value || value.length < 2) {
                field.addClass('ulp-error-field');
                return false;
            }
        } else if (fieldName === 'model_price') {
            var numericValue = value.replace(/[^\d]/g, '');
            if (!numericValue || parseInt(numericValue) <= 0) {
                field.addClass('ulp-error-field');
                return false;
            }
        }
        
        field.removeClass('ulp-error-field');
        return true;
    }
    
    // Keyboard shortcuts
    $(document).on('keydown', function(e) {
        // Ctrl+S to save (prevent default browser save)
        if (e.ctrlKey && e.key === 's') {
            e.preventDefault();
            $('.ulp-form:visible').submit();
        }
    });
    
    // Auto-save draft functionality (optional)
    var autoSaveTimer;
    $('.ulp-form input, .ulp-form textarea').on('input', function() {
        clearTimeout(autoSaveTimer);
        autoSaveTimer = setTimeout(function() {
            // Could implement auto-save functionality here
            console.log('Auto-save triggered');
        }, 2000);
    });
    
    // Enhanced UX: Focus first empty field
    $('.ulp-form').each(function() {
        var firstEmptyField = $(this).find('input[value=""]').first();
        if (firstEmptyField.length) {
            firstEmptyField.focus();
        }
    });
    
    // Bulk operations (future enhancement)
    $('.ulp-bulk-select').on('change', function() {
        var isChecked = $(this).is(':checked');
        $(this).closest('.ulp-section').find('.ulp-model-checkbox').prop('checked', isChecked);
    });
    
    // Search functionality (future enhancement)
    $('.ulp-search-input').on('input', function() {
        var searchTerm = $(this).val().toLowerCase();
        var section = $(this).closest('.ulp-section');
        
        section.find('.ulp-model-item').each(function() {
            var modelName = $(this).find('.ulp-model-name').text().toLowerCase();
            if (modelName.includes(searchTerm)) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });
});