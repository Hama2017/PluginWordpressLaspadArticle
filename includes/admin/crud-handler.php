<?php
/**
 * Gestionnaire CRUD pour les articles LASPAD
 * Gère les opérations Create, Read, Update et Delete
 */

if (!defined('ABSPATH')) exit;

/**
 * Traiter l'ajout d'un nouvel article
 */
function laspad_handle_add_article() {
    if (!isset($_POST['laspad_add_article']) || !isset($_POST['_wpnonce_laspad_add'])) {
        return;
    }

    // Vérifier le nonce pour la sécurité
    if (!wp_verify_nonce($_POST['_wpnonce_laspad_add'], 'laspad_add_article')) {
        wp_die('Action non autorisée');
    }

    global $wpdb;
    $table_name = LASPAD_TABLE_NAME;

    // Récupérer et nettoyer les données
    $data = array(
        'type_article' => sanitize_text_field($_POST['type_article']),
        'titre' => sanitize_text_field($_POST['titre']),
        'annee' => intval($_POST['annee']),
        'langue' => sanitize_text_field($_POST['langue']),
        'auteur' => sanitize_text_field($_POST['auteur']),
        'genre_auteur' => sanitize_text_field($_POST['genre_auteur']),
        'url_article' => esc_url_raw($_POST['url_article']),
        'terrain_etude' => sanitize_text_field($_POST['terrain_etude']),
        'editeur' => sanitize_text_field($_POST['editeur']),
        'pays' => sanitize_text_field($_POST['pays'])
    );

    // Insérer dans la base de données
    $result = $wpdb->insert($table_name, $data);

    if ($result) {
        add_settings_error(
            'laspad_messages',
            'laspad_message',
            'Article ajouté avec succès!',
            'success'
        );
    } else {
        add_settings_error(
            'laspad_messages',
            'laspad_message',
            'Erreur lors de l\'ajout de l\'article.',
            'error'
        );
    }
}

/**
 * Traiter la modification d'un article
 */
function laspad_handle_edit_article() {
    if (!isset($_POST['laspad_edit_article']) || !isset($_POST['_wpnonce_laspad_edit'])) {
        return;
    }

    // Vérifier le nonce pour la sécurité
    if (!wp_verify_nonce($_POST['_wpnonce_laspad_edit'], 'laspad_edit_article')) {
        wp_die('Action non autorisée');
    }

    global $wpdb;
    $table_name = LASPAD_TABLE_NAME;
    $article_id = intval($_POST['article_id']);

    // Récupérer et nettoyer les données
    $data = array(
        'type_article' => sanitize_text_field($_POST['type_article']),
        'titre' => sanitize_text_field($_POST['titre']),
        'annee' => intval($_POST['annee']),
        'langue' => sanitize_text_field($_POST['langue']),
        'auteur' => sanitize_text_field($_POST['auteur']),
        'genre_auteur' => sanitize_text_field($_POST['genre_auteur']),
        'url_article' => esc_url_raw($_POST['url_article']),
        'terrain_etude' => sanitize_text_field($_POST['terrain_etude']),
        'editeur' => sanitize_text_field($_POST['editeur']),
        'pays' => sanitize_text_field($_POST['pays'])
    );

    // Mettre à jour dans la base de données
    $result = $wpdb->update(
        $table_name,
        $data,
        array('id' => $article_id)
    );

    if ($result !== false) {
        add_settings_error(
            'laspad_messages',
            'laspad_message',
            'Article modifié avec succès!',
            'success'
        );
    } else {
        add_settings_error(
            'laspad_messages',
            'laspad_message',
            'Erreur lors de la modification de l\'article.',
            'error'
        );
    }
}

/**
 * Traiter la suppression d'un article
 */
function laspad_handle_delete_article() {
    if (!isset($_GET['action']) || $_GET['action'] !== 'delete') {
        return;
    }

    if (!isset($_GET['article_id']) || !isset($_GET['_wpnonce'])) {
        return;
    }

    // Vérifier le nonce pour la sécurité
    if (!wp_verify_nonce($_GET['_wpnonce'], 'laspad_delete_article_' . $_GET['article_id'])) {
        wp_die('Action non autorisée');
    }

    global $wpdb;
    $table_name = LASPAD_TABLE_NAME;
    $article_id = intval($_GET['article_id']);

    // Supprimer de la base de données
    $result = $wpdb->delete($table_name, array('id' => $article_id));

    if ($result) {
        add_settings_error(
            'laspad_messages',
            'laspad_message',
            'Article supprimé avec succès!',
            'success'
        );
    } else {
        add_settings_error(
            'laspad_messages',
            'laspad_message',
            'Erreur lors de la suppression de l\'article.',
            'error'
        );
    }

    // Rediriger pour éviter la resoumission du formulaire
    wp_redirect(admin_url('admin.php?page=laspad-article'));
    exit;
}

/**
 * Récupérer un article par son ID
 */
function laspad_get_article_by_id($article_id) {
    global $wpdb;
    $table_name = LASPAD_TABLE_NAME;

    $article = $wpdb->get_row(
        $wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $article_id)
    );

    return $article;
}

// Hook pour traiter les actions
add_action('admin_init', 'laspad_handle_add_article');
add_action('admin_init', 'laspad_handle_edit_article');
add_action('admin_init', 'laspad_handle_delete_article');
