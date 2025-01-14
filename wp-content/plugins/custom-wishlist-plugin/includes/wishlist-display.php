<?php

// Display Wishlist Content on a Custom Wishlist Page
function custom_display_wishlist() {
    // Check if the user is logged in
    if ( is_user_logged_in() ) {
        $user_id = get_current_user_id();
        $wishlist = get_user_meta( $user_id, 'custom_wishlist', true ) ?: [];
    } else {
        session_start();
        $wishlist = $_SESSION['custom_wishlist'] ?? [];
    }

    // Check if the wishlist is empty
    if ( empty( $wishlist ) ) {
        echo '<p>Your wishlist is empty. Start adding some products!</p>';
    } else {
        echo '<h2>Your Wishlist</h2>';
        echo '<ul class="wishlist-products">';
        
        // Loop through each product in the wishlist
        foreach ( $wishlist as $product_id ) {
            $product = wc_get_product( $product_id );

            // Check if the product exists
            if ( $product ) {
                echo '<li>';
                echo '<a href="' . get_permalink( $product_id ) . '">';
                echo $product->get_image( 'thumbnail' ); // Product image
                echo '<p>' . $product->get_name() . '</p>';
                echo '<p>' . wc_price( $product->get_price() ) . '</p>';
                echo '</a>';

                // Add remove from wishlist button
                echo '<a href="#" class="remove-from-wishlist" data-product-id="' . esc_attr( $product_id ) . '">Remove</a>';
                echo '</li>';
            }
        }
        
        echo '</ul>';
    }
}

// Display Wishlist via a shortcode
function custom_wishlist_shortcode() {
    ob_start();
    custom_display_wishlist();
    return ob_get_clean();
}
add_shortcode( 'custom_wishlist', 'custom_wishlist_shortcode' );

// Handle removal of product from wishlist (AJAX)
add_action( 'wp_ajax_remove_from_wishlist', 'custom_remove_from_wishlist' );
add_action( 'wp_ajax_nopriv_remove_from_wishlist', 'custom_remove_from_wishlist' );

function custom_remove_from_wishlist() {
    if ( isset( $_POST['product_id'] ) ) {
        $product_id = intval( $_POST['product_id'] );

        if ( is_user_logged_in() ) {
            $user_id = get_current_user_id();
            $wishlist = get_user_meta( $user_id, 'custom_wishlist', true ) ?: [];
            
            // Remove the product from the wishlist
            if ( ( $key = array_search( $product_id, $wishlist ) ) !== false ) {
                unset( $wishlist[$key] );
                update_user_meta( $user_id, 'custom_wishlist', $wishlist );
            }
        } else {
            session_start();
            $wishlist = $_SESSION['custom_wishlist'] ?? [];

            // Remove the product from the wishlist
            if ( ( $key = array_search( $product_id, $wishlist ) ) !== false ) {
                unset( $wishlist[$key] );
                $_SESSION['custom_wishlist'] = $wishlist;
            }
        }

        wp_send_json_success();
    }

    wp_send_json_error( [ 'message' => 'Failed to remove product from wishlist.' ] );
    wp_die();
}
