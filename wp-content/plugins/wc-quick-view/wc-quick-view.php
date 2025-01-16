<?php
/**
 * Plugin Name: Quick View for WooCommerce
 * Description: A custom plugin to add quick view functionality to WooCommerce product pages.
 * Version: 1.0
 * Author: Dhananjay
 */

if (!defined('ABSPATH')) exit;

// Enqueue Scripts and Styles
function qvw_enqueue_scripts() {
    wp_enqueue_script('qvw-quick-view-js', plugin_dir_url(__FILE__) . 'assets/js/quick-view.js', ['jquery'], '1.0', true);
    wp_enqueue_style('qvw-quick-view-css', plugin_dir_url(__FILE__) . 'assets/css/quick-view.css');
    wp_localize_script('qvw-quick-view-js', 'qvw_ajax', [
        'ajax_url' => admin_url('admin-ajax.php'),
    ]);
    // Enqueue Bootstrap CSS
    wp_enqueue_style(
        'bootstrap-css',
        'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css',
        [],
        '5.3.0-alpha3'
    );
    wp_enqueue_style(
        'fontawsome-css',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css',
        [],
        'fontawsome'
    );

    // Enqueue Bootstrap JS (with Popper.js for Bootstrap's interactive components)
    wp_enqueue_script(
        'bootstrap-js',
        'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js',
        ['jquery'], // Add jQuery as a dependency if required
        '5.3.0-alpha3',
        true
    );
    wp_enqueue_script( 'ajax-add-to-cart', plugin_dir_url(__FILE__) .  '/assets/js/ajax-add-to-cart.js', array( 'jquery' ), '1.0', true );
    wp_localize_script( 'ajax-add-to-cart', 'ajaxAddToCart', [
        'ajax_url' => admin_url( 'admin-ajax.php' ),
    ] );
}
add_action('wp_enqueue_scripts', 'qvw_enqueue_scripts');

// Add Quick View Button
function qvw_add_quick_view_button() {
    echo '<button class="qvw-quick-view-button" data-product-id="' . get_the_ID() . '">Quick View</button>';
}
add_action('woocommerce_after_shop_loop_item', 'qvw_add_quick_view_button', 15);

// AJAX Handler for Quick View
function qvw_load_quick_view() {
    $product_id = intval($_POST['product_id']);
    $product = wc_get_product($product_id);  

    if ($product) {
        $average_rating = $product->get_average_rating();
        $review_count = $product->get_review_count();
        $rating_html = wc_get_rating_html($average_rating);
        $people_viewing = rand(5, 25); 
        ?>
        <div class="qvw-product-quick-view">            
            <h2>Quick View</h2>
            <div class="container">
                <div class="row">
                    <div class="col-6">
                        <div class="quick_product_img">
                        <?= $product->get_image(); ?>
                        </div>                    
                    </div>
                    <div class="col-6">
                        <h3><?= $product->get_name(); ?></h3>
                        <?php
                            // Add Rating HTML
                            if ($review_count > 0) {
                                echo '<div class="product-rating">';
                                echo $rating_html;
                                echo '<span> (' . $review_count . ' reviews)</span>';
                                echo '</div>';
                            }
                            // Add the "People are viewing" section
                            echo '        <div class="people-viewing">';
                            echo '          <p><i class="fa fa-eye"></i> ' . $people_viewing . ' people are viewing this right now</p>';
                            echo '        </div>';
                          
                            // // Display variations for variable products
                            // if ($product->is_type('variable')) {
                            //     $attributes = $product->get_variation_attributes();
                            //     $available_variations = $product->get_available_variations();

                            //     echo '<div class="product-variations">';
                            //     foreach ($attributes as $attribute_name => $options) {
                            //         $attribute_label = wc_attribute_label($attribute_name);
                            //         echo '<div class="variation-group">';
                            //         echo '<h5>' . esc_html($attribute_label) . ':</h5>';
                            //         echo '<select name="' . esc_attr($attribute_name) . '" class="variation-select">';
                            //         echo '<option value="">Choose ' . esc_html($attribute_label) . '</option>';
                            //         foreach ($options as $option) {
                            //             echo '<option value="' . esc_attr($option) . '">' . esc_html($option) . '</option>';
                            //         }
                            //         echo '</select>';
                            //         echo '</div>';
                            //     }
                            //     echo '</div>';
                            // }
                            // Add the quantity field
                            // echo '<div class="quantity-field">';
                            // woocommerce_quantity_input([
                            //     'input_name'  => 'quantity',
                            //     'input_value' => 1, // Default quantity
                            //     'min_value'   => 1, // Minimum value
                            //     'max_value'   => $product->get_max_purchase_quantity(), // Maximum value based on product settings
                            // ]);
                            // echo '</div>';
                        ?>
                        <p><?= wc_price($product->get_price()); ?></p>
                        <p><?= $product->get_short_description(); ?></p>
                        <?php
                     if ( $product->is_type( 'variable' ) ) {
                        $variations = $product->get_available_variations();
                        $attributes = $product->get_variation_attributes();
                        ?>
                        <form class="variations_form cart" method="post" enctype="multipart/form-data">
                            <div class="variations">
                                <?php foreach ( $attributes as $attribute_name => $options ) : ?>
                                    <div class="variation-select">
                                        <label for="<?php echo esc_attr( $attribute_name ); ?>">
                                            <?php echo wc_attribute_label( $attribute_name ); ?>
                                        </label>
                                        <select name="attribute_<?php echo esc_attr( $attribute_name ); ?>" class="variation-select">
                                            <option value=""><?php _e( 'Choose an option', 'woocommerce' ); ?></option>
                                            <?php foreach ( $options as $option ) : ?>
                                                <option value="<?php echo esc_attr( $option ); ?>">
                                                    <?php echo esc_html( $option ); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <div class="quantity">
                                <label for="quantity"><?php _e( 'Quantity', 'woocommerce' ); ?></label>
                                <input type="number" name="quantity" value="1" min="1">
                            </div>
                            <button type="submit" class="button add-to-cart" data-product_id="<?php echo esc_attr( $product->get_id() ); ?>">
                                <?php _e( 'Add to Cart', 'woocommerce' ); ?>
                            </button>
                        </form>
                        <?php
                    } else {
                        // Default add-to-cart button for simple products.
                        woocommerce_template_loop_add_to_cart();
                    }
                    ?>
                    </div>
                </div>
            </div>
        </div>
            
            
        </div>
        <?php
    } else {
        echo '<p>Product not found!</p>';
    }
    wp_die();
}
add_action('wp_ajax_qvw_load_quick_view', 'qvw_load_quick_view');
add_action('wp_ajax_nopriv_qvw_load_quick_view', 'qvw_load_quick_view');


function add_variable_product_to_cart() {
    $product_id = isset( $_POST['product_id'] ) ? intval( $_POST['product_id'] ) : 0;
    $quantity = isset( $_POST['quantity'] ) ? intval( $_POST['quantity'] ) : 1;
    $variations = isset( $_POST['variations'] ) ? $_POST['variations'] : [];

    if ( $product_id > 0 && ! empty( $variations ) ) {
        $cart_item_key = WC()->cart->add_to_cart( $product_id, $quantity, 0, $variations );

        if ( $cart_item_key ) {
            wp_send_json_success([
                'message' => 'Product added to cart!',
                'cart_url' => wc_get_cart_url(),
            ]);
        } else {
            wp_send_json_error([ 'message' => 'Failed to add product to cart.' ]);
        }
    } else {
        wp_send_json_error([ 'message' => 'Invalid product or variations.' ]);
    }
}
add_action( 'wp_ajax_add_variable_product_to_cart', 'add_variable_product_to_cart' );
add_action( 'wp_ajax_nopriv_add_variable_product_to_cart', 'add_variable_product_to_cart' );
