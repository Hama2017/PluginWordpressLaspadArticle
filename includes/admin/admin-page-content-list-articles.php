<?php if (!defined('ABSPATH')) exit; ?>

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
                    <?php foreach ($resultats as $article) : ?>
                        <tr>
                            <td><?php echo esc_html($article->id); ?></td>
                            
                            <td>
                                <span class="badge bg-primary">
                                    <?php echo esc_html($article->type_article); ?>
                                </span>
                            </td>
                            
                            <td>
                                <strong><?php echo esc_html($article->titre); ?></strong>
                            </td>
                            
                            <td>
                                <span class="badge bg-info">
                                    <?php echo esc_html($article->annee); ?>
                                </span>
                            </td>
                            
                            <td><?php echo esc_html($article->langue); ?></td>
                            
                            <td>
                                <i class="fas fa-user-circle"></i>
                                <?php echo esc_html($article->auteur); ?>
                            </td>
                            
                            <td>
                                <?php if (!empty($article->url_article)) : ?>
                                    <a href="<?php echo esc_url($article->url_article); ?>" 
                                       target="_blank" 
                                       class="btn btn-sm btn-outline-primary"
                                       rel="noopener noreferrer">
                                        <i class="fas fa-external-link-alt"></i> Voir
                                    </a>
                                <?php else : ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>
                            
                            <td><?php echo esc_html($article->terrain_etude); ?></td>
                            
                            <td><?php echo esc_html($article->editeur); ?></td>
                            
                            <td>
                                <span class="badge bg-success">
                                    <?php echo esc_html($article->pays); ?>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
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