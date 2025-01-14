<?php

// Handle AJAX request for toggling wishlist
add_action( 'wp_ajax_toggle_wishlist', 'custom_handle_toggle_wishlist' );
add_action( 'wp_ajax_nopriv_toggle_wishlist', 'custom_handle_toggle_wishlist' );

function custom_handle_toggle_wishlist() {
    if ( isset( $_POST['product_id'] ) ) {
        $product_id = intval( $_POST['product_id'] );
        $is_added = false;

        if ( is_user_logged_in() ) {
            $user_id = get_current_user_id();
            $wishlist = get_user_meta( $user_id, 'custom_wishlist', true ) ?: [];

            if ( in_array( $product_id, $wishlist ) ) {
                $wishlist = array_diff( $wishlist, [ $product_id ] );
                $is_added = false;
            } else {
                $wishlist[] = $product_id;
                $is_added = true;
            }

            update_user_meta( $user_id, 'custom_wishlist', $wishlist );
        } else {
            session_start();
            $wishlist = $_SESSION['custom_wishlist'] ?? [];

            if ( in_array( $product_id, $wishlist ) ) {
                $wishlist = array_diff( $wishlist, [ $product_id ] );
                $is_added = false;
            } else {
                $wishlist[] = $product_id;
                $is_added = true;
            }

            $_SESSION['custom_wishlist'] = $wishlist;
        }

        wp_send_json_success( [
            'is_added' => $is_added,
            'wishlist_count' => custom_get_wishlist_count()
        ] );
    }

    wp_send_json_error( [ 'message' => 'Failed to toggle wishlist.' ] );
    wp_die();
}
