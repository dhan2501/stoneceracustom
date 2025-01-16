jQuery(document).ready(function ($) {
    $('.qvw-quick-view-button').on('click', function () {
        let productId = $(this).data('product-id');
        $.ajax({
            url: qvw_ajax.ajax_url,
            method: 'POST',
            data: {
                action: 'qvw_load_quick_view',
                product_id: productId,
            },
            beforeSend: function () {
                // You can add a loader here
            },
            success: function (response) {
                // Display the quick view popup
                $('body').append('<div class="qvw-popup-overlay"></div><div class="qvw-popup">' + response + '</div>');
            },
        });
    });

    // Close the popup
    $('body').on('click', '.qvw-popup-overlay', function () {
        $('.qvw-popup, .qvw-popup-overlay').remove();
    });
});


// jQuery(document).ready(function ($) {
//     // Update variation ID when attributes are selected
//     $('body').on('change', '.variation-select', function () {
//         const selectedVariations = {};
//         $('.variation-select').each(function () {
//             const attributeName = $(this).attr('name');
//             const selectedValue = $(this).val();
//             if (selectedValue) {
//                 selectedVariations[attributeName] = selectedValue;
//             }
//         });

//         // Match selected variations to available variations
//         let matchedVariation = null;
//         if (typeof quickViewVariations !== 'undefined') {
//             matchedVariation = quickViewVariations.find(variation => {
//                 return Object.keys(selectedVariations).every(key => {
//                     return variation.attributes[key] === selectedVariations[key];
//                 });
//             });
//         }

//         // Set the variation ID
//         if (matchedVariation) {
//             $('.variation_id').val(matchedVariation.variation_id);
//         } else {
//             $('.variation_id').val(''); // Clear variation ID if no match
//         }
//     });

//     // Handle form submission for Add to Cart
//     $('body').on('submit', '.variations_form', function (e) {
//         if (!$('.variation_id').val()) {
//             e.preventDefault();
//             alert('Please select all required options before adding to the cart.');
//         }
//     });
// });

jQuery(document).ready(function ($) {
    // Handle variation selection
    $('body').on('change', '.variation-select', function () {
        const selectedVariations = {};
        $('.variation-select').each(function () {
            const attributeName = $(this).attr('name');
            const selectedValue = $(this).val();
            if (selectedValue) {
                selectedVariations[attributeName] = selectedValue;
            }
        });

        // Match selected variations to available variations
        let matchedVariation = null;
        if (typeof quickViewVariations !== 'undefined') {
            matchedVariation = quickViewVariations.find(variation => {
                return Object.keys(selectedVariations).every(key => {
                    return variation.attributes[key] === selectedVariations[key];
                });
            });
        }

        // Set the variation ID
        if (matchedVariation) {
            $('.variation_id').val(matchedVariation.variation_id);
        } else {
            $('.variation_id').val('');
        }
    });

    // Handle Add to Cart button click
    $('body').on('click', '.quick-view-add-to-cart', function (e) {
        e.preventDefault();

        const productId = $('input[name="product_id"]').val();
        const variationId = $('.variation_id').val();

        // Gather selected variations
        const variation = {};
        $('.variation-select').each(function () {
            const attributeName = $(this).attr('name');
            const selectedValue = $(this).val();
            if (selectedValue) {
                variation[attributeName] = selectedValue;
            }
        });

        // Validate selection
        if (!variationId) {
            alert('Please select all required options before adding to the cart.');
            return;
        }

        // Send AJAX request
        $.ajax({
            url: wc_add_to_cart_params.ajax_url,
            type: 'POST',
            data: {
                action: 'qvw_add_to_cart',
                product_id: productId,
                variation_id: variationId,
                variation: variation,
                quantity: 1,
            },
            success: function (response) {
                if (response.success) {
                    alert(response.data.message);
                    $('.cart-count').text(response.data.cart_count);
                    $('.cart-total').text(response.data.cart_total);
                } else {
                    alert(response.data.message);
                }
            },
            error: function () {
                alert('An error occurred while adding the product to the cart.');
            },
        });
    });
});
