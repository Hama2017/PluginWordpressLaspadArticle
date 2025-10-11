<?php if (!defined('ABSPATH')) exit; ?>
<div class="laspad-admin-container">
    <div class="wrap container">
        <!-- En-tête moderne -->
        <div class="laspad-header">
            <div class="d-flex align-items-center flex-wrap gap-3">
                <img src="<?php echo esc_url(laspad_plugin_url('assets/images/laspad-logo.png')); ?>"
                     alt="Laspad Logo" class="laspad-logo">
                <div>
                    <h1 class="laspad-title">
                        <i class="fas fa-file-csv"></i>
                        Importation d'articles scientifiques
                    </h1>
                </div>
            </div>
        </div>

        <!-- Cards principales -->
        <div class="row g-4 mb-4">
            <!-- Card Import CSV -->
            <div class="col-lg-6">
                <div class="laspad-card">
                    <div class="laspad-card-icon orange">
                        <i class="fas fa-cloud-upload-alt"></i>
                    </div>
                    <h2 class="laspad-card-title">
                        <i class="fas fa-upload"></i> Importer un fichier CSV
                    </h2>
                    <p class="text-muted mb-4">
                        Téléversez votre fichier CSV contenant les articles scientifiques. 
                        Le système détectera automatiquement les colonnes et importera les données.
                    </p>
                    <?php include laspad_plugin_path("includes/admin/form/admin-page-content-form.php") ?>
                </div>
            </div>

            <!-- Card Shortcode -->
            <div class="col-lg-6">
                <div class="laspad-card">
                    <div class="laspad-card-icon teal">
                        <i class="fas fa-code"></i>
                    </div>
                    <h2 class="laspad-card-title">
                        <i class="fas fa-terminal"></i> Code court (shortcode)
                    </h2>
                    <p class="text-muted">
                        Copiez et collez ce shortcode dans n'importe quelle page ou article WordPress :
                    </p>
                    
                    <div class="laspad-shortcode-box">
                        <button class="laspad-copy-btn mt-5" onclick="copyShortcode()">
                            <i class="fas fa-copy"></i> Copier
                        </button>
                        <code>[display_articles cards_per_row="4" pagination="12"]</code>
                    </div>

                    <div class="mt-4">
                        <h5 style="color: var(--laspad-dark); font-weight: 600; margin-bottom: 1rem;">
                            <i class="fas fa-cog" style="color: var(--laspad-teal);"></i> Paramètres disponibles
                        </h5>
                        <ul class="list-unstyled" style="line-height: 1.8;">
                            <li>
                                <i class="fas fa-chevron-right" style="color: var(--laspad-orange); margin-right: 0.5rem;"></i>
                                <strong>cards_per_row</strong> : Nombre de cartes par ligne (2, 3, 4, 6)
                            </li>
                            <li>
                                <i class="fas fa-chevron-right" style="color: var(--laspad-orange); margin-right: 0.5rem;"></i>
                                <strong>pagination</strong> : Articles affichés par page (défaut : 5)
                            </li>
                        </ul>
                    </div>

                    <div class="alert alert-success mt-3" style="border-left: 4px solid var(--laspad-teal); border-radius: 8px;">
                        <i class="fas fa-magic"></i> 
                        Ce shortcode génère un <strong>carrousel dynamique</strong> avec filtres avancés
                    </div>
                </div>
            </div>
        </div>

        <!-- Table des articles -->
       <?php include laspad_plugin_path("includes/admin/admin-page-content-list-articles.php") ?>
    </div>
</div>

<script>

function copyShortcode() {
   // TODO: Implement the copy to clipboard functionality for the shortcode
   // show alert on success or failure
   // Example: alert('Shortcode copied to clipboard!');

}


</script>