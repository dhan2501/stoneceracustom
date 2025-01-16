<?php
/*
Plugin Name: Custom Variation Display
Description: Show product variations on the WooCommerce shop page.
Version: 1.0
Author: Developer Dhananjay Gupta
*/

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Hook to initialize the plugin.
add_action( 'plugins_loaded', 'custom_variation_display_init' );

function custom_variation_display_init() {
    if ( class_exists( 'WooCommerce' ) ) {
        require_once plugin_dir_path( __FILE__ ) . 'includes/display-variations.php';
    }
}


add_action( 'wp_enqueue_scripts', 'custom_variation_enqueue_scripts' );
function custom_variation_enqueue_scripts() {
    wp_enqueue_script( 'custom-variation-script', plugin_dir_url( __FILE__ ) . 'assets/js/custom-variation.js', array( 'jquery' ), '1.0', true );
    wp_localize_script( 'custom-variation-script', 'customVariationAjax', array(
        'ajax_url' => admin_url( 'admin-ajax.php' ),
    ));
}
