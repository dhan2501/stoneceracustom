jQuery(document).ready(function($) {
    $('body').on('click', '.add-to-cart', function(e) {
        e.preventDefault();

        let form = $(this).closest('form');
        let productId = $(this).data('product_id');
        let quantity = form.find('input[name="quantity"]').val() || 1;
        let variations = {};

        // Collect variation data.
        form.find('.variation-select select').each(function() {
            let attributeName = $(this).attr('name');
            let attributeValue = $(this).val();
            variations[attributeName] = attributeValue;
        });

        // Validate variations are selected.
        if (Object.values(variations).includes("")) {
            alert('Please select all options.');
            return;
        }

        // Send AJAX request to add the product to the cart.
        $.post(ajaxAddToCart.ajax_url, {
            action: 'add_variable_product_to_cart',
            product_id: productId,
            quantity: quantity,
            variations: variations,
        }, function(response) {
            if (response.success) {
                alert(response.data.message);
                // Optionally update the cart count or display a success message.
                // window.location.href = response.data.cart_url;
                location.reload();
            } else {
                alert(response.data.message);
            }
        });
    });
});
