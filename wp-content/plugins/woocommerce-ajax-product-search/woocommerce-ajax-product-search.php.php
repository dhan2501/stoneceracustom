<?php
/*
Plugin Name: WooCommerce AJAX Product Search with Category & Name
Description: A custom WooCommerce product search using the same input field for both category and product name using AJAX.
Version: 1.0
Author: Developer Dhananjay
*/

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Enqueue Scripts and Styles
add_action( 'wp_enqueue_scripts', 'custom_woocommerce_ajax_search_scripts' );
function custom_woocommerce_ajax_search_scripts() {
    wp_enqueue_script( 'ajax-search', plugin_dir_url( __FILE__ ) . 'assets/js/ajax-search.js', array( 'jquery' ), '1.0', true );
    wp_localize_script( 'ajax-search', 'ajax_search_params', array(
        'ajax_url' => admin_url( 'admin-ajax.php' ),
        'nonce'    => wp_create_nonce( 'ajax_search_nonce' ),
    ));
    wp_enqueue_style( 'ajax-search-style', plugin_dir_url( __FILE__ ) . 'assets/css/ajax-search.css' );
}

// Create the Product Search Form
add_shortcode( 'woocommerce_ajax_search_form', 'custom_woocommerce_ajax_search_form' );
function custom_woocommerce_ajax_search_form() {
    ob_start(); ?>
    <form id="woocommerce-ajax-search-form">
        <input type="text" id="search-input" name="search_input" placeholder="Search products by name or category..." />
        <button type="submit">Search</button>
    </form>
    <div id="ajax-search-results"></div>
    <?php
    return ob_get_clean();
}

// Handle AJAX Request
add_action( 'wp_ajax_woocommerce_ajax_product_search', 'woocommerce_ajax_product_search' );
add_action( 'wp_ajax_nopriv_woocommerce_ajax_product_search', 'woocommerce_ajax_product_search' );
function woocommerce_ajax_product_search() {
    // Verify nonce
    if ( !isset( $_POST['nonce'] ) || !wp_verify_nonce( $_POST['nonce'], 'ajax_search_nonce' ) ) {
        die( 'Permission denied' );
    }

    // Get the search input
    $search_input = isset( $_POST['search_input'] ) ? sanitize_text_field( $_POST['search_input'] ) : '';

    // WP_Query arguments
    $args = array(
        'post_type'      => 'product',
        'posts_per_page' => 10,
        's'               => $search_input,
        'tax_query' => array(
            array(
                'taxonomy' => 'product_cat',
                'field'    => 'name',
                'terms'    => $search_input,
                'operator' => 'LIKE', // Partial match for category
            ),
        ),
    );

    // Execute the query
    $query = new WP_Query( $args );

    // Display results
    if ( $query->have_posts() ) {
        while ( $query->have_posts() ) {
            $query->the_post();
            ?>
            <div class="search-result">
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            </div>
            <?php
        }
    } else {
        echo 'No products found.';
    }

    wp_die(); // This is required to terminate the AJAX request
}
