<?php

// Add Wishlist Button Over Product Image
add_action( 'woocommerce_before_shop_loop_item_title', 'custom_wishlist_button_over_image', 15 );

function custom_wishlist_button_over_image() {
    global $product;

    $is_in_wishlist = custom_is_in_wishlist( $product->get_id() );

    echo '<div class="custom-wishlist-wrapper">';
    echo '<a href="#" class="custom-add-to-wishlist" data-product-id="' . esc_attr( $product->get_id() ) . '">';
    echo $is_in_wishlist 
        ? '<span class="wishlist-heart filled-heart">&#9829;</span>' 
        : '<span class="wishlist-heart empty-heart">&#9825;</span>';
    // echo $is_in_wishlist 
    //     ? '<span class="wishlist-heart filled-heart"><i class="fa fa-heart" aria-hidden="true"></i></span>' 
    //     : '<span class="wishlist-heart empty-heart"><i class="fa fa-heart-o" aria-hidden="true"></i></span>';
    echo '</a>';
    echo '</div>';
}

// Check if Product is in Wishlist
function custom_is_in_wishlist( $product_id ) {
    if ( is_user_logged_in() ) {
        $user_id = get_current_user_id();
        $wishlist = get_user_meta( $user_id, 'custom_wishlist', true ) ?: [];
        return in_array( $product_id, $wishlist );
    } else {
        session_start();
        $wishlist = $_SESSION['custom_wishlist'] ?? [];
        return in_array( $product_id, $wishlist );
    }
}

// Display Wishlist Counter in Header
// add_action( 'wp_head', 'custom_add_wishlist_count_to_header' );
add_shortcode('tophead-wishlist', 'custom_add_wishlist_count_to_header');
function custom_add_wishlist_count_to_header() {
    echo '<div class="wishlist-header">
        <a href="' . site_url( '/wishlist' ) . '">
            <span class="wishlist-icon">&#9829;</span>
            <span class="wishlist-count">' . custom_get_wishlist_count() . '</span>
        </a>
    </div>';
}

// Get Wishlist Count
function custom_get_wishlist_count() {
    if ( is_user_logged_in() ) {
        $user_id = get_current_user_id();
        $wishlist = get_user_meta( $user_id, 'custom_wishlist', true ) ?: [];
        return count( $wishlist );
    } else {
        session_start();
        $wishlist = $_SESSION['custom_wishlist'] ?? [];
        return count( $wishlist );
    }
}



// Enqueue Wishlist JavaScript
add_action( 'wp_enqueue_scripts', 'custom_enqueue_wishlist_scripts' );

function custom_enqueue_wishlist_scripts() {
    wp_enqueue_script( 'custom-wishlist', plugin_dir_url( __FILE__ ) . '../assets/js/wishlist.js', [ 'jquery' ], null, true );
    wp_localize_script( 'custom-wishlist', 'wishlist_ajax', [
        'ajax_url' => admin_url( 'admin-ajax.php' )
    ] );
}



// Add 'Add to Wishlist' button over product image on Product Details Page
add_action( 'woocommerce_single_product_summary', 'custom_add_wishlist_button_single_product', 30 );

function custom_add_wishlist_button_single_product() {
    global $product;

    // Check if the product is already in the wishlist
    $is_in_wishlist = false;
    if ( is_user_logged_in() ) {
        $user_id = get_current_user_id();
        $wishlist = get_user_meta( $user_id, 'custom_wishlist', true ) ?: [];
        $is_in_wishlist = in_array( $product->get_id(), $wishlist );
    } else {
        session_start();
        $wishlist = $_SESSION['custom_wishlist'] ?? [];
        $is_in_wishlist = in_array( $product->get_id(), $wishlist );
    }

    // Output the button with the appropriate heart icon
    echo '<div class="custom-wishlist-wrapper">';
    echo '<a href="#" class="custom-add-to-wishlist" data-product-id="' . esc_attr( $product->get_id() ) . '">';
    echo $is_in_wishlist 
        ? '<span class="wishlist-heart filled-heart">&#9829;</span>' 
        : '<span class="wishlist-heart empty-heart">&#9825;</span>';
    echo '</a>';
    echo '</div>';
}
