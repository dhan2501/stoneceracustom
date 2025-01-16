jQuery(document).ready(function($) {
    // Add to cart
    $('.add-to-cart-button').on('click', function(e) {
        e.preventDefault();

        var product_id = $(this).data('product-id');
        var quantity = $(this).data('quantity') || 1;

        $.ajax({
            url: custom_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'custom_add_to_cart',
                product_id: product_id,
                quantity: quantity,
            },
            success: function(response) {
                if (response.success) {
                    $('.cart-count').text(response.data.cart_count);
                    $('.custom-bucket').html(response.data.bucket_html);
                } else {
                    alert('Error: ' + response.data);
                }
            },
            error: function() {
                alert('An error occurred.');
            },
        });
    });

    // Update bucket on cart page quantity change
    $('body').on('change', '.woocommerce-cart-form input.qty', function() {
        $.ajax({
            url: custom_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'custom_update_bucket',
            },
            success: function(response) {
                if (response.success) {
                    $('.cart-count').text(response.data.cart_count);
                    $('.custom-bucket').html(response.data.bucket_html);
                }
            },
            error: function() {
                alert('An error occurred while updating the cart.');
            },
        });
    });
});


