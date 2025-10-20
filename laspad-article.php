<?php
/**
* Plugin Name: Laspad Article
* Description: Affichez un carrousel dynamique d'articles scientifiques, alimenté par un fichier CSV téléversé, avec des options de filtrage, et intégrable partout sur votre site WordPress via un code court.
* Version:     1.0.0
* Author:      Hamadou BA, Mouhamadou Lamine BATHILY & Saliou NGOM
* Text Domain: laspad-article
*/

// Security check to prevent direct access to the file
if ( ! defined( 'ABSPATH' ) ) exit;

// Include helper functions
require_once plugin_dir_path(__FILE__) . 'includes/helpers.php';

require_once laspad_plugin_path('includes/constants.php');

// Function to create the database table upon plugin activation
require_once laspad_plugin_path('includes/database/create-table.php');

// Function to run on plugin activation
function laspad_article_install() {
    laspad_article_create_table();
}

// Hook the installation function to the plugin activation event
register_activation_hook(__FILE__, 'laspad_article_install');

// Include the admin page file
require_once plugin_dir_path( __FILE__ ) . 'includes/admin/admin-page.php';

// Include CRUD handler
require_once laspad_plugin_path('includes/admin/crud-handler.php');

// Include debug file (commenté en production - décommenter pour déboguer)
// require_once laspad_plugin_path('includes/admin/debug-crud.php');

require_once laspad_plugin_path('includes/shortcode/display-articles-shortcode.php');

