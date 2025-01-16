jQuery(document).ready(function($) {
    $('body').on('click', '.add-to-cart', function(e) {
        e.preventDefault();

        let form = $(this).closest('form');
        let productId = $(this).data('product_id');
        let quantity = form.find('input[name="quantity"]').val() || 1;
        let variations = {};

        // Collect variation data.
        form.find('.variation-select-dropdown').each(function() {
            let attributeName = $(this).attr('name');
            let attributeValue = $(this).val();
            variations[attributeName] = attributeValue;
        });

        // Validate variations.
        if (Object.values(variations).includes("")) {
            alert('Please select all options.');
            return;
        }

        // Send AJAX request.
        $.post(customVariationAjax.ajax_url, {
            action: 'add_variable_product_to_cart',
            product_id: productId,
            quantity: quantity,
            variations: variations,
        }, function(response) {
            if (response.success) {
                alert('Product added to cart!');
                location.reload();
            } else {
                alert(response.data.message);
            }
        });
    });
});
