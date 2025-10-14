<?php
/**
 * TEST IMPORT CSV - À SUPPRIMER APRÈS TEST
 */

// Charger WordPress
require_once('../../../wp-load.php');

// Charger les constantes
require_once('includes/constants.php');

// Charger la fonction
require_once('includes/admin/form/insert-data-csv-to-table.php');

// Chemin vers votre CSV (adapter selon votre fichier)
$csv_file = __DIR__ . '/prodp_base_2025_final_completed.csv';

echo '<html><head><meta charset="UTF-8">';
echo '<link rel="stylesheet" href="assets/css/admin-page.css">';
echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">';
echo '</head><body style="padding: 20px; font-family: Arial, sans-serif;">';

echo '<h1>Test d\'import CSV</h1>';
echo '<p><strong>Fichier :</strong> ' . basename($csv_file) . '</p>';

// Appeler la fonction
laspad_article_insert_data_csv_to_table($csv_file);

echo '</body></html>';