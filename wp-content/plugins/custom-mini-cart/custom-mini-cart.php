<?php
/*
Plugin Name: Custom Mini Cart
Description: A custom WooCommerce mini-cart that auto-updates via AJAX on all pages.
Version: 1.0
Author: Your Name
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

// Enqueue Scripts and Styles
function custom_mini_cart_enqueue_scripts() {
    wp_enqueue_script( 'custom-mini-cart-js', plugin_dir_url( __FILE__ ) . 'custom-mini-cart.js', array( 'jquery' ), '1.0', true );

    // Pass AJAX URL and nonce to JavaScript
    wp_localize_script( 'custom-mini-cart-js', 'customMiniCart', array(
        'ajax_url' => admin_url( 'admin-ajax.php' ),
        'nonce'    => wp_create_nonce( 'custom_mini_cart_nonce' )
    ));

    wp_enqueue_style( 'custom-mini-cart-css', plugin_dir_url( __FILE__ ) . 'custom-mini-cart.css' );
}
add_action( 'wp_enqueue_scripts', 'custom_mini_cart_enqueue_scripts' );

// Render Mini-Cart
function custom_mini_cart_render() {
    ob_start();
    ?>
    <div id="custom-mini-cart">
        <?php woocommerce_mini_cart(); ?>
    </div>
    <?php
    return ob_get_clean();
}

// Add Shortcode for Mini-Cart
function custom_mini_cart_shortcode() {
    return custom_mini_cart_render();
}
add_shortcode( 'custom_mini_cart', 'custom_mini_cart_shortcode' );

// AJAX Handler for Updating Mini-Cart
function custom_mini_cart_ajax_update() {
    // Verify nonce
    check_ajax_referer( 'custom_mini_cart_nonce', 'security' );

    WC()->cart->calculate_totals();
    WC()->cart->maybe_set_cart_cookies();

    ob_start();
    woocommerce_mini_cart();
    $mini_cart = ob_get_clean();

    wp_send_json_success( array( 'mini_cart' => $mini_cart ) );
}
add_action( 'wp_ajax_update_mini_cart', 'custom_mini_cart_ajax_update' );
add_action( 'wp_ajax_nopriv_update_mini_cart', 'custom_mini_cart_ajax_update' );

// Display Mini-Cart Everywhere
function custom_mini_cart_display_everywhere() {
    echo do_shortcode('[custom_mini_cart]');
}
add_action( 'wp_footer', 'custom_mini_cart_display_everywhere' );
