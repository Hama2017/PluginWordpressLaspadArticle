<div class="container my-5" id="publications-<?php echo esc_attr($unique_id); ?>">
  
  <!-- Filtres -->
  <div class="row filters" style="padding: 20px;">
    <div class="col-md text-center align-self-en">
      <label><i class="fa fa-search"></i> Recherche</label>
      <input class="search form-control" placeholder="Rechercher (titre, auteur, terrain...)">
    </div>
    <div class="col-md text-center align-self-end">
      <label><i class="fa fa-tags"></i> Type</label>
      <select id="filter-type" class="form-select"><option value="">Tous types</option></select>
    </div>
    <div class="col-md text-center align-self-en">
      <label><i class="fa fa-calendar"></i> Année</label>
      <select id="filter-annee" class="form-select"><option value="">Toutes années</option></select>
    </div>
    <div class="col-md text-center align-self-en">
      <label><i class="fa fa-language"></i> Langue</label>
      <select id="filter-langue" class="form-select"><option value="">Toutes langues</option></select>
    </div>
    <div class="col-md text-center align-self-en">
      <label><i class="fa fa-building"></i> Éditeur</label>
      <select id="filter-editeur" class="form-select"><option value="">Tous éditeurs</option></select>
    </div>
    <div class="col-md text-center align-self-en">
      <label><i class="fa fa-globe"></i> Pays</label>
      <select id="filter-pays" class="form-select"><option value="">Tous pays</option></select>
    </div>
  </div>

  <!-- Résultats -->
  <div class="mb-3" id="results-info"></div>
  <div class="row list g-3"></div>
  <div class="no-results" id="no-results">Aucun résultat trouvé.</div>

  <!-- Pagination -->
  <ul class="pagination" style="margin-top: 40px;"></ul>
</div>
