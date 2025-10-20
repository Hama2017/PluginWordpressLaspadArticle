<?php
/**
 * Fichier de débogage pour tester l'insertion CRUD
 * À utiliser temporairement pour diagnostiquer les problèmes
 */

if (!defined('ABSPATH')) exit;

// Activer le mode debug
add_action('admin_init', 'laspad_debug_crud', 1);

function laspad_debug_crud() {
    // Vérifier si on essaie d'ajouter un article
    if (isset($_POST['laspad_add_article'])) {
        error_log('=== LASPAD DEBUG: Tentative d\'ajout d\'article ===');
        error_log('POST data: ' . print_r($_POST, true));

        // Vérifier le nonce
        if (isset($_POST['_wpnonce_laspad_add'])) {
            $nonce_check = wp_verify_nonce($_POST['_wpnonce_laspad_add'], 'laspad_add_article');
            error_log('Nonce check result: ' . ($nonce_check ? 'OK' : 'FAILED'));
        } else {
            error_log('Nonce not found in POST data');
        }

        // Vérifier la table
        global $wpdb;
        $table_name = LASPAD_TABLE_NAME;
        error_log('Table name: ' . $table_name);

        // Vérifier si la table existe
        $table_exists = $wpdb->get_var("SHOW TABLES LIKE '$table_name'");
        error_log('Table exists: ' . ($table_exists ? 'YES' : 'NO'));

        // Compter les articles actuels
        $count = $wpdb->get_var("SELECT COUNT(*) FROM $table_name");
        error_log('Current articles count: ' . $count);
    }
}

// Afficher les erreurs de base de données
add_action('admin_notices', 'laspad_show_db_errors');

function laspad_show_db_errors() {
    global $wpdb;
    if ($wpdb->last_error) {
        echo '<div class="notice notice-error"><p><strong>Erreur SQL:</strong> ' . esc_html($wpdb->last_error) . '</p></div>';
    }
}
