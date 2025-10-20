<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Add a menu item to the WordPress admin dashboard
function laspad_article_add_menu_to_admin_dashboard() {
    add_menu_page(
        'Laspad Article Admin',              // Page title
        'Laspad Article CSV',                // Menu title
        'manage_options',                    // Required capability
        'laspad-article',                    // Page slug
        'laspad_article_admin_page_content', // Callback function for page content
        'dashicons-upload',                  // Menu icon
        20                                   // Menu position
    );
}

// Display the admin page content
function laspad_article_admin_page_content() {
    // Include the script that handles the CSV upload process
    require_once laspad_plugin_path('includes/admin/form/handle-csv-upload.php');

    // Include the admin page HTML content
    require_once laspad_plugin_path('includes/admin/admin-page-content.php');
}

// Enqueue scripts and styles only on the plugin's admin page
function laspad_article_enqueue_assets_admin_page() {
    // Check if the current screen is the plugin's admin page
    $screen = get_current_screen();
    if (!isset($screen->id) || $screen->id !== 'toplevel_page_laspad-article') {
        return;
    }

    // Enqueue jQuery
    wp_enqueue_script(
        'jquery',
        laspad_plugin_url('assets/vendor/jquery-3.7.1.min.js'),
        array(),
        '3.7.1',
        true
    );

    // Enqueue Bootstrap CSS
    wp_enqueue_style(
        'bootstrap-css',
        laspad_plugin_url('assets/vendor/bootstrap-5.0.2-dist/css/bootstrap.min.css'),
        array(),
        '5.0.2'
    );
    
    // Enqueue Bootstrap JS
    wp_enqueue_script(
        'bootstrap-js',
        laspad_plugin_url('assets/vendor/bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js'),
        array('jquery'),
        '5.0.2',
        true
    );

    // Enqueue DataTables JS
    wp_enqueue_script(
        'datatable-js',
        laspad_plugin_url('assets/vendor/datatables-2.3.4/datatables.min.js'),
        array('jquery'),
        '2.3.4',
        true
    );

    // Enqueue DataTables CSS
    wp_enqueue_style(
        'datatable-css',
        laspad_plugin_url('assets/vendor/datatables-2.3.4/datatables.min.css'),
        array(),
        '2.3.4'
    );

    // Enqueue admin page custom CSS
    wp_enqueue_style(
        'admin-page-css',
        laspad_plugin_url('assets/css/admin-page.css'),
        array(),
        '1.0.0'
    );

    // Enqueue Font Awesome CSS
    wp_enqueue_style(
        'fontawesome-css',
        laspad_plugin_url('assets/vendor/fontawesome-free-7.1.0-web/css/all.min.css'),
        array(),
        '7.1.0'
    );

    // Initialize DataTables
    wp_enqueue_script(
        'laspad-datatable-init',
        laspad_plugin_url('assets/js/datatable-init.js'),
        array('datatable-js'),
        '1.0',
        true
    );

    // Enqueue CRUD actions JavaScript
    wp_enqueue_script(
        'laspad-crud-actions',
        laspad_plugin_url('assets/js/crud-actions.js'),
        array('jquery'),
        '1.0',
        true
    );
}

// Register admin menu and enqueue assets
add_action('admin_menu', 'laspad_article_add_menu_to_admin_dashboard');
add_action('admin_enqueue_scripts', 'laspad_article_enqueue_assets_admin_page');
?>
