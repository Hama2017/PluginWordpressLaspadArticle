<?php
if (!defined('ABSPATH')) exit;

// Charger les constantes
if (!defined('LASPAD_TABLE_NAME')) {
    $constants_file = dirname(dirname(dirname(__FILE__))) . '/constants.php';
    if (file_exists($constants_file)) {
        require_once $constants_file;
    } else {
        global $wpdb;
        define('LASPAD_TABLE_NAME', $wpdb->prefix . 'laspad_articles');
    }
}

function laspad_article_insert_data_csv_to_table($file_path) {
    global $wpdb;
    
    // Vérifier la constante
    if (!defined('LASPAD_TABLE_NAME')) {
        echo '<div class="laspad-alert error">
            <i class="fas fa-exclamation-circle"></i>
            Erreur : Configuration de la table manquante.
        </div>';
        return;
    }
    
    // Vérifier le fichier
    if (!file_exists($file_path)) {
        echo '<div class="laspad-alert error">
            <i class="fas fa-exclamation-circle"></i>
            Erreur : Fichier CSV introuvable.
        </div>';
        return;
    }
    
    // Ouvrir le fichier
    $handle = fopen($file_path, 'r');
    if ($handle === false) {
        echo '<div class="laspad-alert error">
            <i class="fas fa-exclamation-circle"></i>
            Erreur : Impossible d\'ouvrir le fichier CSV.
        </div>';
        return;
    }
    
    // Lire les en-têtes
    $headers = fgetcsv($handle, 0, ',');
    if ($headers === false) {
        fclose($handle);
        echo '<div class="laspad-alert error">
            <i class="fas fa-exclamation-circle"></i>
            Erreur : Fichier CSV vide ou mal formaté.
        </div>';
        return;
    }
    
    // Nettoyer les en-têtes
    $headers = array_map(function($header) {
        return trim(str_replace("\xEF\xBB\xBF", '', $header));
    }, $headers);
    
    // Mapping des colonnes
    $column_mapping = array(
        'Type' => 'type_article',
        'Titre' => 'titre',
        'Année de publication' => 'annee',
        'Langue' => 'langue',
        'Auteur' => 'auteur',
        'Genre de l\'auteur' => 'genre_auteur',
        'Url' => 'url_article',
        'Terrain d\'etude' => 'terrain_etude',
        'Editeur' => 'editeur',
        'Pays' => 'pays'
    );
    
    $success_count = 0;
    $error_count = 0;
    $errors = array();
    $line_number = 1;
    $table_name = LASPAD_TABLE_NAME;
    
    $wpdb->show_errors(false);
    $wpdb->query('START TRANSACTION');
    
    // Traiter chaque ligne
    while (($data = fgetcsv($handle, 0, ',')) !== false) {
        $line_number++;
        
        if (count($headers) !== count($data)) {
            $error_count++;
            if (count($errors) < 10) {
                $errors[] = "Ligne $line_number : Nombre de colonnes incorrect";
            }
            continue;
        }
        
        $row = array_combine($headers, $data);
        $insert_data = array();
        
        foreach ($column_mapping as $csv_column => $db_column) {
            if (isset($row[$csv_column])) {
                $value = trim($row[$csv_column]);
                
                if ($db_column === 'annee') {
                    $value = intval($value);
                    if ($value < 1900 || $value > 2100) {
                        $value = 0;
                    }
                }
                
                $insert_data[$db_column] = sanitize_text_field($value);
            } else {
                $insert_data[$db_column] = '';
            }
        }
        
        if (empty($insert_data['titre']) || empty($insert_data['type_article'])) {
            $error_count++;
            if (count($errors) < 10) {
                $errors[] = "Ligne $line_number : Champs obligatoires manquants";
            }
            continue;
        }
        
        $result = $wpdb->insert(
            $table_name,
            $insert_data,
            array('%s', '%s', '%d', '%s', '%s', '%s', '%s', '%s', '%s', '%s')
        );
        
        if ($result === false) {
            $error_count++;
            if (count($errors) < 10) {
                $errors[] = "Ligne $line_number : " . $wpdb->last_error;
            }
        } else {
            $success_count++;
        }
    }
    
    $wpdb->query('COMMIT');
    $wpdb->show_errors(true);
    fclose($handle);
    
    // Afficher les résultats
    if ($success_count > 0 && $error_count === 0) {
        echo '<div class="laspad-alert success">
            <i class="fas fa-check-circle"></i>
            <strong>Import réussi !</strong><br>
            ' . number_format($success_count) . ' article(s) importé(s) avec succès.
        </div>';
    } elseif ($success_count > 0 && $error_count > 0) {
        echo '<div class="laspad-alert warning">
            <i class="fas fa-exclamation-triangle"></i>
            <strong>Import partiellement réussi</strong><br>
            ' . number_format($success_count) . ' article(s) importé(s).<br>
            ' . number_format($error_count) . ' erreur(s).
        </div>';
        
        if (!empty($errors)) {
            echo '<div class="laspad-alert error"><strong>Erreurs :</strong><ul>';
            foreach ($errors as $error) {
                echo '<li>' . esc_html($error) . '</li>';
            }
            if ($error_count > count($errors)) {
                echo '<li>... et ' . ($error_count - count($errors)) . ' autres</li>';
            }
            echo '</ul></div>';
        }
    } else {
        echo '<div class="laspad-alert error">
            <i class="fas fa-times-circle"></i>
            <strong>Échec de l\'import</strong>
        </div>';
        
        if (!empty($errors)) {
            echo '<div class="laspad-alert error"><ul>';
            foreach ($errors as $error) {
                echo '<li>' . esc_html($error) . '</li>';
            }
            echo '</ul></div>';
        }
    }
    
    // Statistiques
    echo '<div class="laspad-import-stats">
        <div class="stat-item">
            <span class="stat-label">Total traité :</span>
            <span class="stat-value">' . number_format($success_count + $error_count) . '</span>
        </div>
        <div class="stat-item success">
            <span class="stat-label">Réussis :</span>
            <span class="stat-value">' . number_format($success_count) . '</span>
        </div>
        <div class="stat-item error">
            <span class="stat-label">Erreurs :</span>
            <span class="stat-value">' . number_format($error_count) . '</span>
        </div>
    </div>';
}