<?php
if (!defined('ABSPATH')) exit;

// Access the global WordPress database object
global $wpdb;

// Define the name of the custom database table for Laspad articles
define('LASPAD_TABLE_NAME', $wpdb->prefix . 'laspad_articles');

// Define the plugin name constant
define('LASPAD_PLUGIN_NAME', 'Laspad Article');
