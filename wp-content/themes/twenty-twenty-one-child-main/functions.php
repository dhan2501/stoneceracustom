<?php

/**
 * Load child theme style
 */
add_action( 'wp_enqueue_scripts', 'twentytwentyone_child_enqueue_styles' );
function twentytwentyone_child_enqueue_styles() {
	wp_enqueue_style(
		'twentytwentyone-child-style',
		get_stylesheet_uri(),
		array( 'twenty-twenty-one-style' ),
		wp_get_theme()->get( '1.0.0' )
	);
}

/**
 * Add a custom body class for this theme
 */
add_filter( 'body_class', 'twentytwentyone_child_body_class' );
function twentytwentyone_child_body_class( $classes ) {
	$classes[] = 'learn-wordpress';

	return $classes;
}


/*ACF Custom fields*/

if( function_exists('acf_add_options_page') ) {
	
	acf_add_options_page(array(
		'page_title' 	=> 'Theme General Settings',
		'menu_title'	=> 'Theme Settings',
		'menu_slug' 	=> 'theme-general-settings',
		'capability'	=> 'edit_posts',
		'redirect'		=> false
	));
	
	acf_add_options_sub_page(array(
		'page_title' 	=> 'Theme Header Settings',
		'menu_title'	=> 'Header',
		'parent_slug'	=> 'theme-general-settings',
	));
	
	acf_add_options_sub_page(array(
		'page_title' 	=> 'Theme Footer Settings',
		'menu_title'	=> 'Footer',
		'parent_slug'	=> 'theme-general-settings',
	));

	acf_add_options_sub_page(array(
		'page_title' 	=> 'Theme Social Media Settings',
		'menu_title'	=> 'Social Media',
		'parent_slug'	=> 'theme-general-settings',
	));

	acf_add_options_sub_page(array(
		'page_title' 	=> 'Theme Contact Details Settings',
		'menu_title'	=> 'Contact Details',
		'parent_slug'	=> 'theme-general-settings',
	));

	
}

/* Support Woocommerce Plugin */
function mytheme_add_woocommerce_support() {
    add_theme_support( 'woocommerce' );
}
add_action( 'after_setup_theme', 'mytheme_add_woocommerce_support' );



// Add 'Add to Wishlist' button with heart icon on product pages
// add_action( 'woocommerce_after_add_to_cart_button', 'custom_add_wishlist_button_with_heart' );
// add_action( 'woocommerce_before_shop_loop_item_title', 'custom_add_wishlist_button_with_heart', 15 );
// // Add 'Add to Wishlist' button with heart icon to product loop
// add_action( 'woocommerce_after_shop_loop_item', 'custom_add_wishlist_button_with_heart', 15 );


// function custom_add_wishlist_button_with_heart() {
//     global $product;

//     // Check if the product is already in the wishlist
//     $is_in_wishlist = false;
//     if ( is_user_logged_in() ) {
//         $user_id = get_current_user_id();
//         $wishlist = get_user_meta( $user_id, 'custom_wishlist', true ) ?: [];
//         $is_in_wishlist = in_array( $product->get_id(), $wishlist );
//     } else {
//         session_start();
//         $wishlist = $_SESSION['custom_wishlist'] ?? [];
//         $is_in_wishlist = in_array( $product->get_id(), $wishlist );
//     }

//     // Output the button with the appropriate heart icon
//     echo '<a href="#" class="custom-add-to-wishlist" data-product-id="' . esc_attr( $product->get_id() ) . '">';
//     echo $is_in_wishlist 
//         ? '<span class="wishlist-heart filled-heart">&#9829;</span>' 
//         : '<span class="wishlist-heart empty-heart">&#9825;</span>';
//     echo '</a>';
// }


// // Handle AJAX request to toggle product in wishlist
// add_action( 'wp_ajax_toggle_wishlist', 'custom_handle_toggle_wishlist' );
// add_action( 'wp_ajax_nopriv_toggle_wishlist', 'custom_handle_toggle_wishlist' );

// function custom_handle_toggle_wishlist() {
//     if ( isset( $_POST['product_id'] ) ) {
//         $product_id = intval( $_POST['product_id'] );
//         $is_added = false;

//         if ( is_user_logged_in() ) {
//             $user_id = get_current_user_id();
//             $wishlist = get_user_meta( $user_id, 'custom_wishlist', true ) ?: [];

//             if ( in_array( $product_id, $wishlist ) ) {
//                 $wishlist = array_diff( $wishlist, [ $product_id ] );
//                 $is_added = false;
//             } else {
//                 $wishlist[] = $product_id;
//                 $is_added = true;
//             }

//             update_user_meta( $user_id, 'custom_wishlist', $wishlist );
//         } else {
//             session_start();
//             $wishlist = $_SESSION['custom_wishlist'] ?? [];

//             if ( in_array( $product_id, $wishlist ) ) {
//                 $wishlist = array_diff( $wishlist, [ $product_id ] );
//                 $is_added = false;
//             } else {
//                 $wishlist[] = $product_id;
//                 $is_added = true;
//             }

//             $_SESSION['custom_wishlist'] = $wishlist;
//         }

//         wp_send_json_success( [ 'is_added' => $is_added ] );
//     }

//     wp_send_json_error( [ 'message' => 'Failed to toggle wishlist.' ] );
//     wp_die();
// }


// // Enqueue JavaScript for Wishlist functionality
// add_action( 'wp_enqueue_scripts', 'custom_enqueue_wishlist_scripts' );

// function custom_enqueue_wishlist_scripts() {
//     wp_enqueue_script( 'custom-wishlist', get_stylesheet_directory_uri() . '/assets/js/wishlist.js', [ 'jquery' ], null, true );

//     wp_localize_script( 'custom-wishlist', 'wishlist_ajax', [
//         'ajax_url' => admin_url( 'admin-ajax.php' ),
//     ] );
// }



// Add 'Add to Wishlist' button with heart icon to product loop
// add_action( 'woocommerce_after_shop_loop_item', 'custom_add_wishlist_button_loop', 15 );

// function custom_add_wishlist_button_loop() {
//     global $product;

//     // Check if the product is already in the wishlist
//     $is_in_wishlist = false;
//     if ( is_user_logged_in() ) {
//         $user_id = get_current_user_id();
//         $wishlist = get_user_meta( $user_id, 'custom_wishlist', true ) ?: [];
//         $is_in_wishlist = in_array( $product->get_id(), $wishlist );
//     } else {
//         session_start();
//         $wishlist = $_SESSION['custom_wishlist'] ?? [];
//         $is_in_wishlist = in_array( $product->get_id(), $wishlist );
//     }

//     // Output the button with the appropriate heart icon
//     echo '<a href="#" class="custom-add-to-wishlist" data-product-id="' . esc_attr( $product->get_id() ) . '">';
//     echo $is_in_wishlist 
//         ? '<span class="wishlist-heart filled-heart">&#9829;</span>' 
//         : '<span class="wishlist-heart empty-heart">&#9825;</span>';
//     echo '</a>';
// }



// Add 'Add to Wishlist' button over product image in the product loop
// add_action( 'woocommerce_before_shop_loop_item_title', 'custom_add_wishlist_icon_over_image', 15 );

// function custom_add_wishlist_icon_over_image() {
//     global $product;

//     // Check if the product is already in the wishlist
//     $is_in_wishlist = false;
//     if ( is_user_logged_in() ) {
//         $user_id = get_current_user_id();
//         $wishlist = get_user_meta( $user_id, 'custom_wishlist', true ) ?: [];
//         $is_in_wishlist = in_array( $product->get_id(), $wishlist );
//     } else {
//         session_start();
//         $wishlist = $_SESSION['custom_wishlist'] ?? [];
//         $is_in_wishlist = in_array( $product->get_id(), $wishlist );
//     }

//     // Output the button with the appropriate heart icon
//     echo '<div class="custom-wishlist-wrapper">';
//     echo '<a href="#" class="custom-add-to-wishlist" data-product-id="' . esc_attr( $product->get_id() ) . '">';
//     echo $is_in_wishlist 
//         ? '<span class="wishlist-heart filled-heart">&#9829;</span>' 
//         : '<span class="wishlist-heart empty-heart">&#9825;</span>';
//     echo '</a>';
//     echo '</div>';
// }

// Allow SVG upload
function allow_svg_upload($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'allow_svg_upload');