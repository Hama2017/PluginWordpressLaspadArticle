<?php
/**
 * Formulaire d'ajout et de modification d'articles
 */

if (!defined('ABSPATH')) exit;

// Récupérer l'article si on est en mode édition
$edit_mode = false;
$article = null;

if (isset($_GET['action']) && $_GET['action'] === 'edit' && isset($_GET['article_id'])) {
    $edit_mode = true;
    $article_id = intval($_GET['article_id']);
    $article = laspad_get_article_by_id($article_id);
}

// Afficher les messages selon les paramètres GET
if (isset($_GET['message'])) {
    switch ($_GET['message']) {
        case 'added':
            echo '<div class="laspad-alert success">
                <i class="fas fa-check-circle"></i>
                <strong>Succès !</strong><br>
                L\'article a été ajouté avec succès.
            </div>';
            break;
        case 'updated':
            echo '<div class="laspad-alert success">
                <i class="fas fa-check-circle"></i>
                <strong>Succès !</strong><br>
                L\'article a été modifié avec succès.
            </div>';
            break;
        case 'deleted':
            echo '<div class="laspad-alert success">
                <i class="fas fa-check-circle"></i>
                <strong>Succès !</strong><br>
                L\'article a été supprimé avec succès.
            </div>';
            break;
        case 'error':
            $error_details = isset($_GET['error_details']) ? esc_html($_GET['error_details']) : 'Une erreur est survenue.';
            echo '<div class="laspad-alert error">
                <i class="fas fa-exclamation-circle"></i>
                <strong>Erreur !</strong><br>
                ' . $error_details . '
            </div>';
            break;
    }
}
?>

<div class="laspad-card mt-4">
    <div class="laspad-card-icon <?php echo $edit_mode ? 'orange' : 'teal'; ?>">
        <i class="fas <?php echo $edit_mode ? 'fa-edit' : 'fa-plus-circle'; ?>"></i>
    </div>
    <h2 class="laspad-card-title">
        <i class="fas <?php echo $edit_mode ? 'fa-edit' : 'fa-plus'; ?>"></i>
        <?php echo $edit_mode ? 'Modifier un article' : 'Ajouter un article manuellement'; ?>
    </h2>

    <?php if ($edit_mode && !$article): ?>
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-triangle"></i>
            Article introuvable.
        </div>
    <?php else: ?>
        <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" class="laspad-article-form" id="laspad-article-form">
            <?php
            if ($edit_mode) {
                wp_nonce_field('laspad_edit_article', '_wpnonce_laspad_edit');
                echo '<input type="hidden" name="action" value="laspad_edit_article">';
            } else {
                wp_nonce_field('laspad_add_article', '_wpnonce_laspad_add');
                echo '<input type="hidden" name="action" value="laspad_add_article">';
            }
            ?>

            <?php if ($edit_mode): ?>
                <input type="hidden" name="article_id" value="<?php echo esc_attr($article->id); ?>">
            <?php endif; ?>

            <div class="row g-3">
                <!-- Type d'article -->
                <div class="col-md-6">
                    <label for="type_article" class="form-label">
                        <i class="fas fa-tag"></i> Type d'article *
                    </label>
                    <input type="text"
                           class="form-control"
                           id="type_article"
                           name="type_article"
                           value="<?php echo $edit_mode ? esc_attr($article->type_article) : ''; ?>"
                           required
                           placeholder="Ex: Article scientifique, Thèse, etc.">
                </div>

                <!-- Titre -->
                <div class="col-md-6">
                    <label for="titre" class="form-label">
                        <i class="fas fa-heading"></i> Titre *
                    </label>
                    <input type="text"
                           class="form-control"
                           id="titre"
                           name="titre"
                           value="<?php echo $edit_mode ? esc_attr($article->titre) : ''; ?>"
                           required
                           placeholder="Titre complet de l'article">
                </div>

                <!-- Année -->
                <div class="col-md-4">
                    <label for="annee" class="form-label">
                        <i class="fas fa-calendar"></i> Année *
                    </label>
                    <input type="number"
                           class="form-control"
                           id="annee"
                           name="annee"
                           value="<?php echo $edit_mode ? esc_attr($article->annee) : date('Y'); ?>"
                           required
                           min="1900"
                           max="<?php echo date('Y') + 5; ?>"
                           placeholder="Ex: 2024">
                </div>

                <!-- Langue -->
                <div class="col-md-4">
                    <label for="langue" class="form-label">
                        <i class="fas fa-language"></i> Langue *
                    </label>
                    <input type="text"
                           class="form-control"
                           id="langue"
                           name="langue"
                           value="<?php echo $edit_mode ? esc_attr($article->langue) : ''; ?>"
                           required
                           placeholder="Ex: Français, Anglais, etc.">
                </div>

                <!-- Genre auteur -->
                <div class="col-md-4">
                    <label for="genre_auteur" class="form-label">
                        <i class="fas fa-venus-mars"></i> Genre auteur *
                    </label>
                    <select class="form-control" id="genre_auteur" name="genre_auteur" required>
                        <option value="">Sélectionnez...</option>
                        <option value="Homme" <?php echo ($edit_mode && $article->genre_auteur === 'Homme') ? 'selected' : ''; ?>>Homme</option>
                        <option value="Femme" <?php echo ($edit_mode && $article->genre_auteur === 'Femme') ? 'selected' : ''; ?>>Femme</option>
                    </select>
                </div>

                <!-- Auteur -->
                <div class="col-md-6">
                    <label for="auteur" class="form-label">
                        <i class="fas fa-user"></i> Auteur(s) *
                    </label>
                    <input type="text"
                           class="form-control"
                           id="auteur"
                           name="auteur"
                           value="<?php echo $edit_mode ? esc_attr($article->auteur) : ''; ?>"
                           required
                           placeholder="Nom complet de l'auteur ou des auteurs">
                </div>

                <!-- URL -->
                <div class="col-md-6">
                    <label for="url_article" class="form-label">
                        <i class="fas fa-link"></i> URL de l'article *
                    </label>
                    <input type="url"
                           class="form-control"
                           id="url_article"
                           name="url_article"
                           value="<?php echo $edit_mode ? esc_url($article->url_article) : ''; ?>"
                           required
                           placeholder="https://example.com/article">
                </div>

                <!-- Terrain d'étude -->
                <div class="col-md-4">
                    <label for="terrain_etude" class="form-label">
                        <i class="fas fa-map-marker-alt"></i> Terrain d'étude *
                    </label>
                    <input type="text"
                           class="form-control"
                           id="terrain_etude"
                           name="terrain_etude"
                           value="<?php echo $edit_mode ? esc_attr($article->terrain_etude) : ''; ?>"
                           required
                           placeholder="Ex: Dakar, Sénégal">
                </div>

                <!-- Éditeur -->
                <div class="col-md-4">
                    <label for="editeur" class="form-label">
                        <i class="fas fa-building"></i> Éditeur *
                    </label>
                    <input type="text"
                           class="form-control"
                           id="editeur"
                           name="editeur"
                           value="<?php echo $edit_mode ? esc_attr($article->editeur) : ''; ?>"
                           required
                           placeholder="Nom de l'éditeur">
                </div>

                <!-- Pays -->
                <div class="col-md-4">
                    <label for="pays" class="form-label">
                        <i class="fas fa-flag"></i> Pays *
                    </label>
                    <input type="text"
                           class="form-control"
                           id="pays"
                           name="pays"
                           value="<?php echo $edit_mode ? esc_attr($article->pays) : ''; ?>"
                           required
                           placeholder="Ex: Sénégal">
                </div>
            </div>

            <div class="d-flex gap-2 mt-4">
                <button type="submit"
                        class="laspad-btn laspad-btn-link">
                    <i class="fas <?php echo $edit_mode ? 'fa-save' : 'fa-plus-circle'; ?>"></i>
                    <?php echo $edit_mode ? 'Enregistrer les modifications' : 'Ajouter l\'article'; ?>
                </button>

                <?php if ($edit_mode): ?>
                    <a href="<?php echo admin_url('admin.php?page=laspad-article'); ?>"
                       class="btn btn-secondary">
                        <i class="fas fa-times"></i> Annuler
                    </a>
                <?php endif; ?>
            </div>

            <small class="text-muted mt-2 d-block">
                <i class="fas fa-info-circle"></i> Les champs marqués d'un * sont obligatoires
            </small>
        </form>
    <?php endif; ?>
</div>
