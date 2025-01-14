// jQuery(document).ready(function($) {
//     $('.custom-add-to-wishlist').on('click', function(e) {
//         e.preventDefault();

//         let button = $(this);
//         let productId = button.data('product-id');

//         $.post(wishlist_ajax.ajax_url, {
//             action: 'toggle_wishlist',
//             product_id: productId
//         }, function(response) {
//             if (response.success) {
//                 let isAdded = response.data.is_added;

//                 let heartIcon = button.find('.wishlist-heart');
//                 if (isAdded) {
//                     heartIcon.removeClass('empty-heart').addClass('filled-heart').html('&#9829;'); // Filled heart
//                 } else {
//                     heartIcon.removeClass('filled-heart').addClass('empty-heart').html('&#9825;'); // Empty heart
//                 }
//             } else {
//                 alert('Failed to update wishlist.');
//             }
//         });
//     });
// });
