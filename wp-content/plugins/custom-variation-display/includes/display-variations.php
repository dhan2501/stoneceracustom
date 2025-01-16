<?php
// Hook to modify the product loop content.
// add_action( 'woocommerce_after_shop_loop_item', 'custom_display_variations_on_shop', 15 );
add_shortcode('custom-variations-on-shop','custom_display_variations_on_shop');
function custom_display_variations_on_shop() {
    global $product;

    // Check if the product is variable.
    if ( $product->is_type( 'variable' ) ) {
        $attributes = $product->get_variation_attributes();
        $variations = $product->get_available_variations();

        echo '<form class="variations_form cart" method="post" enctype="multipart/form-data">';
        echo '<div class="variations">';

        // Display variation attributes.
        foreach ( $attributes as $attribute_name => $options ) {
            echo '<div class="variation-select">';
            echo '<label for="' . esc_attr( $attribute_name ) . '">' . wc_attribute_label( $attribute_name ) . '</label>';
            echo '<select name="attribute_' . esc_attr( $attribute_name ) . '" class="variation-select-dropdown">';
            echo '<option value="">' . __( 'Choose an option', 'woocommerce' ) . '</option>';

            foreach ( $options as $option ) {
                echo '<option value="' . esc_attr( $option ) . '">' . esc_html( $option ) . '</option>';
            }

            echo '</select>';
            echo '</div>';
        }

        // Quantity and Add to Cart button.
        echo '<div class="quantity">';
        echo '<label for="quantity">' . __( 'Quantity', 'woocommerce' ) . '</label>';
        echo '<input type="number" name="quantity" value="1" min="1">';
        echo '</div>';
        echo '<button type="submit" class="button add-to-cart" data-product_id="' . esc_attr( $product->get_id() ) . '">' . __( 'Add to Cart', 'woocommerce' ) . '</button>';
        echo '</div>';
        echo '</form>';
    }
}



add_action( 'wp_ajax_add_variable_product_to_cart', 'custom_add_variable_to_cart' );
add_action( 'wp_ajax_nopriv_add_variable_product_to_cart', 'custom_add_variable_to_cart' );

function custom_add_variable_to_cart() {
    $product_id = isset( $_POST['product_id'] ) ? intval( $_POST['product_id'] ) : 0;
    $quantity = isset( $_POST['quantity'] ) ? intval( $_POST['quantity'] ) : 1;
    $variations = isset( $_POST['variations'] ) ? $_POST['variations'] : [];

    if ( $product_id > 0 && ! empty( $variations ) ) {
        $cart_item_key = WC()->cart->add_to_cart( $product_id, $quantity, 0, $variations );

        if ( $cart_item_key ) {
            wp_send_json_success([ 'message' => 'Product added to cart!' ]);
        } else {
            wp_send_json_error([ 'message' => 'Failed to add product to cart.' ]);
        }
    } else {
        wp_send_json_error([ 'message' => 'Invalid product or variations.' ]);
    }
}


// Change "Select options" text to "View Product"
add_filter( 'woocommerce_product_add_to_cart_text', 'custom_change_select_options_text', 10, 2 );

function custom_change_select_options_text( $text, $product ) {
    // Check if the product is variable
    if ( $product->is_type( 'variable' ) ) {
        return __( 'View Product', 'woocommerce' );
    }
    return $text;
}