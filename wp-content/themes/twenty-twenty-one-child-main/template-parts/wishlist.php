<?php
/* Template Name: Wishlist */

get_header();

// if ( is_user_logged_in() ) {
//     $user_id = get_current_user_id();
//     $wishlist = get_user_meta( $user_id, 'custom_wishlist', true ) ?: [];
// } else {
//     if ( ! session_id() ) {
//         session_start();
//     }
//     $wishlist = $_SESSION['custom_wishlist'] ?? [];
// }

// echo '<h1>Your Wishlist</h1>';

// if ( ! empty( $wishlist ) ) {
//     echo '<ul class="wishlist-products">';
//     foreach ( $wishlist as $product_id ) {
//         $product = wc_get_product( $product_id );
//         echo '<li>';
//         echo '<a href="' . get_permalink( $product_id ) . '">' . $product->get_name() . '</a>';
//         echo '</li>';
//     }
//     echo '</ul>';
// } else {
//     echo '<p>Your wishlist is empty.</p>';
// }



echo do_shortcode('[custom_wishlist]');

get_footer();