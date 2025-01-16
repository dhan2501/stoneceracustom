<?php
/**
 * Plugin Name: Custom AJAX Add to Cart with Bucket
 * Description: Adds products to the WooCommerce cart using AJAX and displays a bucket in the header.
 * Version: 1.0
 * Author: Dhananjay Gupta
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

// Enqueue necessary scripts and styles
function custom_enqueue_scripts() {
    // wp_enqueue_script(
    //     'custom-ajax-cart',
    //     plugin_dir_url( __FILE__ ) . 'custom-ajax-cart.js',
    //     array( 'jquery' ),
    //     '1.0',
    //     true
    // );

    wp_localize_script( 'custom-ajax-cart', 'custom_ajax', array(
        'ajax_url' => admin_url( 'admin-ajax.php' ),
    ));

    // wp_enqueue_style(
    //     'custom-ajax-cart-style',
    //     plugin_dir_url( __FILE__ ) . 'custom-ajax-cart.css'
    // );
}
add_action( 'wp_enqueue_scripts', 'custom_enqueue_scripts' );

// Handle AJAX add to cart request
function custom_ajax_add_to_cart() {
    $product_id = intval( $_POST['product_id'] );
    $quantity   = intval( $_POST['quantity'] );

    if ( $product_id && $quantity ) {
        WC()->cart->add_to_cart( $product_id, $quantity );
        ob_start();
        custom_render_bucket();
        $bucket_html = ob_get_clean();

        wp_send_json_success( array(
            'cart_count' => WC()->cart->get_cart_contents_count(),
            'bucket_html' => $bucket_html,
        ));
    } else {
        wp_send_json_error( __( 'Failed to add product to cart.', 'woocommerce' ) );
    }
}
add_action( 'wp_ajax_custom_add_to_cart', 'custom_ajax_add_to_cart' );
add_action( 'wp_ajax_nopriv_custom_add_to_cart', 'custom_ajax_add_to_cart' );

// Add bucket to header
function custom_render_bucket() {
    ?>
    <div class="custom-bucket">
        <a href="<?php echo wc_get_cart_url(); ?>" class="bucket-link">
            <!-- 🛒 Cart: <span class="cart-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span> -->
            🛒 <span class="cart-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
        </a>
        <!-- <div class="bucket-content">
            <?php if ( WC()->cart->get_cart_contents_count() > 0 ) : ?>
                <ul>
                    <?php foreach ( WC()->cart->get_cart() as $cart_item ) : ?>
                        <li>
                            <?php echo $cart_item['quantity'] . 'x ' . $cart_item['data']->get_name(); ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <a href="<?php echo wc_get_cart_url(); ?>" class="view-cart">View Cart</a>
            <?php else : ?>
                <p>Your cart is empty.</p>
            <?php endif; ?>
        </div> -->
    </div>
    <?php
}
add_shortcode('bucket', 'custom_render_bucket');
// Hook bucket into header
// function custom_add_bucket_to_header() {
//     add_action( 'wp_footer', 'custom_render_bucket' );
// }
// add_action( 'wp_head', 'custom_add_bucket_to_header' );
