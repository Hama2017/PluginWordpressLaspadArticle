 <?php if (!defined('ABSPATH')) exit;  ?>
 <div class="laspad-table-container">
            <?php
            global $wpdb;
            $table_name = LASPAD_TABLE_NAME;
            $resultats = $wpdb->get_results("SELECT * FROM $table_name ORDER BY id DESC");

            if ($resultats) :
            ?>
                <div class="laspad-table-header">
                    <h2 class="laspad-table-title">
                        <i class="fas fa-newspaper"></i>
                        Articles importés
                    </h2>
                    <span class="laspad-badge-count">
                        <i class="fas fa-database"></i>
                        <?php echo count($resultats); ?> articles
                    </span>
                </div>

                <div class="table-responsive">
                    <table id="articles-datatable" class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th><i class="fas fa-hashtag"></i> ID</th>
                                <th><i class="fas fa-tag"></i> Type</th>
                                <th><i class="fas fa-heading"></i> Titre</th>
                                <th><i class="fas fa-calendar"></i> Année</th>
                                <th><i class="fas fa-language"></i> Langue</th>
                                <th><i class="fas fa-user"></i> Auteur</th>
                                <th><i class="fas fa-link"></i> URL</th>
                                <th><i class="fas fa-map-marker-alt"></i> Terrain</th>
                                <th><i class="fas fa-building"></i> Éditeur</th>
                                <th><i class="fas fa-flag"></i> Pays</th>
                            </tr>
                        </thead>
                        <tbody>
                           <?php
                           //TODO: Liste table data and escape output values for security
                           // Use a foreach loop to iterate over $resultats
                           // Loop through each article and display its details in a table row
                           // Use esc_html() or esc_url() as appropriate to sanitize output
                           // Example: echo esc_html($article->titre);
                           ?>
                        </tbody>
                    </table>
                </div>
            <?php else : ?>
                <div class="laspad-alert">
                    <i class="fas fa-info-circle"></i>
                    <div>
                        <strong>Aucun article importé</strong><br>
                        Commencez par importer votre premier fichier CSV pour voir les articles ici.
                    </div>
                </div>
            <?php endif; ?>
        </div>