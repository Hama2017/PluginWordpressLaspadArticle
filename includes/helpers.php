<?php
if (!defined('ABSPATH')) exit;

// Returns the URL of the plugin's root directory
if (!function_exists('laspad_plugin_url')) {
    function laspad_plugin_url($path = '') {
        return plugin_dir_url(dirname(__DIR__) . '/laspad-article.php') . ltrim($path, '/');
    }
}

// Returns the absolute path of the plugin's root directory
if (!function_exists('laspad_plugin_path')) {
    function laspad_plugin_path($path = '') {
        return plugin_dir_path(dirname(__DIR__) . '/laspad-article.php') . ltrim($path, '/');
    }
}
