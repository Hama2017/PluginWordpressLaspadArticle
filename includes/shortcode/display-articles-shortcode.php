<?php
if (!defined('ABSPATH')) exit;

// Shortcode function to display articles on the frontend
function laspad_display_articles_shortcode($atts) {
    global $wpdb;
    $table_name = LASPAD_TABLE_NAME;

    // Set default shortcode attributes
    $atts = shortcode_atts([
        'pagination' => 12,      // Number of articles per page
        'cards_per_row' => 3,    // Number of cards per row
    ], $atts, 'display_articles');

    // Retrieve all publications from the database, ordered by year (descending)
    $publications = $wpdb->get_results("SELECT * FROM $table_name ORDER BY annee DESC", ARRAY_A);

    // Generate a unique ID for the shortcode instance
    $unique_id = uniqid();

    // Enqueue required assets (CSS/JS) and pass publication data to JavaScript
    laspad_enqueue_assets_and_data($publications, $unique_id, $atts['pagination'], $atts['cards_per_row']);

    // Start output buffering to capture template HTML
    ob_start();

    // Include the HTML template for displaying articles
    include laspad_plugin_path('includes/shortcode/articles-template.php');

    // Return the captured content
    return ob_get_clean();
}

// Register the shortcode [display_articles]
add_shortcode('display_articles', 'laspad_display_articles_shortcode');


// Enqueue frontend assets and localize publication data
function laspad_enqueue_assets_and_data($publications, $unique_id, $pagination, $cards_per_row) {
    // Enqueue Bootstrap CSS
    wp_enqueue_style(
        'laspad-bootstrap',
        laspad_plugin_url("assets/vendor/bootstrap-5.0.2-dist/css/bootstrap.min.css"),
        [],
        '5.0.2'
    );

    // Enqueue Font Awesome CSS
    wp_enqueue_style(
        'fontawesome-css',
        laspad_plugin_url('assets/vendor/fontawesome-free-7.1.0-web/css/all.min.css'),
        [],
        '7.1.0'
    );  

    // Enqueue custom CSS for shortcode layout
    wp_enqueue_style(
        'laspad-shortcode-css',
        laspad_plugin_url('assets/css/shortcode-template.css'),
        ['laspad-bootstrap'],
        '1.0'
    );

    // Enqueue List.js library for filtering and pagination
    wp_enqueue_script(
        'laspad-list',
        laspad_plugin_url("assets/vendor/list-2.3.1.min.js"),
        [],
        '2.3.1',
        true
    );

    // Enqueue initialization script for List.js
    wp_enqueue_script(
        'laspad-list-init',
        laspad_plugin_url('assets/js/listjs-init.js'),
        ['laspad-list'],
        '1.0',
        true
    );

    // Pass PHP data (publications, pagination, etc.) to the JavaScript environment
    wp_localize_script('laspad-list-init', 'laspadData', [
        'targetId' => $unique_id,             // Unique ID for DOM targeting
    ]);
}
