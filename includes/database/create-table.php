<?php
/**
 * Fonction pour créer la table des articles LASPAD
 */

if (!defined('ABSPATH')) {
    exit;
}

function laspad_article_create_table() {
    global $wpdb;
    
    // Récupérer le nom de la table depuis les constantes
    $table_name = LASPAD_TABLE_NAME;
    
    // Récupérer le charset et collation de WordPress
    $charset_collate = $wpdb->get_charset_collate();
    
    // SQL pour créer la table
    $sql = "CREATE TABLE IF NOT EXISTS $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        type_article varchar(255) NOT NULL,
        titre varchar(500) NOT NULL,
        annee int(4) NOT NULL,
        langue varchar(100) NOT NULL,
        auteur varchar(500) NOT NULL,
        genre_auteur varchar(50) NOT NULL,
        url_article varchar(1000) NOT NULL,
        terrain_etude varchar(500) NOT NULL,
        editeur varchar(255) NOT NULL,
        pays varchar(100) NOT NULL,
        PRIMARY KEY (id),
        KEY idx_annee (annee),
        KEY idx_langue (langue),
        KEY idx_pays (pays),
        KEY idx_type (type_article)
    ) $charset_collate;";
    
    // Charger la fonction dbDelta pour créer/mettre à jour la table
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    
    // Exécuter la requête SQL
    dbDelta($sql);
    
    // Vérifier si la table a été créée avec succès
    if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") === $table_name) {
        return true;
    }
    
    return false;
}
