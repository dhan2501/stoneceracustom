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


/*
*Ajax search by redpishi.com
*https://redpishi.com/wordpress-tutorials/live-ajax-search-in-wordpress/
*/
add_shortcode( 'asearch', 'asearch_func' );
function asearch_func( $atts ) {
    $atts = shortcode_atts( array(
        // 'source' => 'page,post,product',
		'source' => 'product,product_cat',
        'image' => 'true'
    ), $atts, 'asearch' );
static $asearch_first_call = 1;
$source = $atts["source"];
$image = $atts["image"];
$sForam = '<div class="search_bar">
    <form class="asearch" id="asearch'.$asearch_first_call.'" action="/" method="get" autocomplete="off">
        <input type="text" name="s" placeholder="Search ..." id="keyword" class="input_search" onkeyup="searchFetch(this)"><button id="mybtn">🔍</button>
    </form><div class="search_result" id="datafetch" style="display: none;">
        <ul>
            <li>Please wait..</li>
        </ul>
    </div></div>';
$java = '<script>
function searchFetch(e) {
var datafetch = e.parentElement.nextSibling
if (e.value.trim().length > 0) { datafetch.style.display = "block"; } else { datafetch.style.display = "none"; }
const searchForm = e.parentElement;	
e.nextSibling.value = "Please wait..."
var formdata'.$asearch_first_call.' = new FormData(searchForm);
formdata'.$asearch_first_call.'.append("source", "'.$source.'") 
formdata'.$asearch_first_call.'.append("image", "'.$image.'") 
formdata'.$asearch_first_call.'.append("action", "asearch") 
AjaxAsearch(formdata'.$asearch_first_call.',e) 
}
async function AjaxAsearch(formdata,e) {
  const url = "'.admin_url("admin-ajax.php").'?action=asearch";
  const response = await fetch(url, {
      method: "POST",
      body: formdata,
  });
  const data = await response.text();
if (data){	e.parentElement.nextSibling.innerHTML = data}else  {
e.parentElement.nextSibling.innerHTML = `<ul><a href="#"><li>Sorry, nothing found</li></a></ul>`
}}	
document.addEventListener("click", function(e) { if (document.activeElement.classList.contains("input_search") == false ) { [...document.querySelectorAll("div.search_result")].forEach(e => e.style.display = "none") } else {if  (e.target.value.trim().length > 0) { e.target.parentElement.nextSibling.style.display = "block"}} })
</script>';
$css = '<style>form.asearch {display: flex;flex-wrap: nowrap;border: 1px solid #d6d6d6;border-radius: 5px;padding: 3px 5px;}
form.asearch button#mybtn {padding: 5px;cursor: pointer;background: none;}
form.asearch input#keyword {border: none;}
div#datafetch {
    background: white;
    z-index: 10;
    position: absolute;
    max-height: 425px;
    overflow: auto;
    box-shadow: 0px 15px 15px #00000036;
    right: 0;
    left: 0;
    top: 50px;
}
div.search_bar {
    width: 600px!important;
    max-width: 90%!important;
    position: relative;
}

div.search_result ul a li {
    margin: 0px;
    padding: 5px 0px;
    padding-inline-start: 18px;
    color: #3f3f3f;
    font-weight: bold;
}
div.search_result li {
    margin-inline-start: 20px;
}
div.search_result ul {
    padding: 13px 0px 0px 0px;
    list-style: none;
    margin: auto;
}

div.search_result ul a {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 5px;
}
div.search_result ul a:hover {
    background-color: #f3f3f3;
}
.asearch input#keyword {
    width: 100%;
}
</style>';
if ( $asearch_first_call == 1 ){	
	 $asearch_first_call++;
	 return "{$sForam}{$java}{$css}"; } elseif  ( $asearch_first_call > 1 ) {
		$asearch_first_call++;
		return "{$sForam}"; }}

add_action('wp_ajax_asearch' , 'asearch');
add_action('wp_ajax_nopriv_asearch','asearch');
function asearch(){
    $the_query = new WP_Query( array( 'posts_per_page' => 10, 's' => esc_attr( $_POST['s'] ), 'post_type' =>  explode(",", esc_attr( $_POST['source'] )))  );
    if( $the_query->have_posts() ) :
        echo '<ul>';
        while( $the_query->have_posts() ): $the_query->the_post(); ?>
            <a href="<?php echo esc_url( post_permalink() ); ?>"><li><?php the_title();?></li>
<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'single-post-thumbnail' );?>                               
<?php if ( $image[0] && trim(esc_attr( $_POST['image'] )) == "true" ) {  ?>  <img src="<?php the_post_thumbnail_url('thumbnail'); ?>" style="height: 60px;padding: 0px 5px;"> <?php }  ?> </a>
        <?php endwhile;
       echo '</ul>';
        wp_reset_postdata();  
    endif;
    die();
}