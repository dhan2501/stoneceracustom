<?php
/**
 * Plugin Name: WooCommerce AJAX Product Search by Name and Category
 * Description: Adds an AJAX product search to WooCommerce with product name and category search.
 * Version: 1.0
 * Author: Your Name
 * License: GPL2
 */

// Hook to initialize the AJAX search functionality
function wcas_enqueue_scripts() {
    wp_enqueue_script('wcas-ajax-search', plugin_dir_url(__FILE__) . 'ajax-search.js', array('jquery'), null, true);
    wp_localize_script('wcas-ajax-search', 'wcas_params', array(
        'wcas_nonce' => wp_create_nonce('wcas_nonce'),
        'wcas_ajax_url' => admin_url('admin-ajax.php'),
    ));
    wp_enqueue_style('wcas-style', plugin_dir_url(__FILE__) . 'style.css');
}
add_action('wp_enqueue_scripts', 'wcas_enqueue_scripts');

// AJAX callback to search products
function wcas_ajax_search() {
    // Verify nonce
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'wcas_nonce')) {
        die('Permission denied');
    }

    $search_query = sanitize_text_field($_POST['query']);
    $args = array(
        'post_type' => 'product',
        'posts_per_page' => -1, // Get all matching products
        's' => $search_query,
        'post_status' => 'publish',
        'tax_query' => array(
            'relation' => 'OR',
            array(
                'taxonomy' => 'product_cat',
                'field'    => 'name',
                'terms'    => $search_query,
                'operator' => 'LIKE',
            ),
        ),
    );

    $products = new WP_Query($args);
    
    if ($products->have_posts()) {
        while ($products->have_posts()) {
            $products->the_post();
            $product = wc_get_product(get_the_ID());
            echo '<div class="product-item">';
            echo '<a href="' . get_permalink() . '">' . get_the_title() . '</a>';
            echo '<span class="price">' . $product->get_price_html() . '</span>';
            echo '</div>';
        }
    } else {
        echo '<p>No products found</p>';
    }

    wp_die(); // Important: Ends the AJAX request
}
add_action('wp_ajax_nopriv_wcas_search', 'wcas_ajax_search');
add_action('wp_ajax_wcas_search', 'wcas_ajax_search');
