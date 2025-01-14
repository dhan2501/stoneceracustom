<?php
/**
 * Plugin Name: Custom Wishlist Plugin
 * Description: A custom plugin to manage a wishlist with heart icons, header counter, and product integration.
 * Version: 1.0
 * Author: Dhananjay Gupta
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

// Include plugin files
include_once plugin_dir_path( __FILE__ ) . 'includes/wishlist-functions.php';
include_once plugin_dir_path( __FILE__ ) . 'includes/wishlist-ajax.php';
include_once plugin_dir_path( __FILE__ ) . 'includes/wishlist-display.php';

