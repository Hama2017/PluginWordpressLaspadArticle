document.addEventListener('DOMContentLoaded', function () {
    // Vérification des données fournies par WordPress
    const dataObj = typeof laspadData !== 'undefined' ? laspadData : null;

    if (!dataObj) {
        console.error('Erreur : données LASPAD manquantes. Vérifie wp_localize_script().');
        return;
    }

    const containerId = 'publications-' + dataObj.targetId;
    const data = dataObj.publications || [];
    const paginationShortcode = dataObj.pagination || 6;
    const cardsPerRow = dataObj.cardsPerRow || 3;

    const container = document.getElementById(containerId);
    if (!container) {
        console.error('Container introuvable pour ID :', containerId);
        return;
    }

    // Déterminer les classes de colonnes Bootstrap
    const cardColClass = {
        2: 'col-md-6 col-lg-6',
        3: 'col-md-6 col-lg-4',
        4: 'col-md-6 col-lg-3',
        6: 'col-md-6 col-lg-2'
    }[cardsPerRow] || 'col-md-6 col-lg-4';

    // --- HTML Injection ---
    const listEl = container.querySelector('.list');
    listEl.innerHTML = data.map((item, i) => `
      <div class="${cardColClass} card-wrapper" style="animation-delay: ${i * 0.05}s;">
        <div class="card h-100">
          <div class="card-body">
            <span class="card-badge type_article">${item.type_article || 'Autre'}</span>
            <h5 class="card-title"><span class="titre">${item.titre || 'Sans titre'}</span></h5>
            <p class="card-text">
              <strong><i class="fa fa-user"></i> Author:</strong> <span class="auteur">${item.auteur || 'N/A'}</span><br>
              <strong><i class="fa fa-calendar"></i> Year:</strong> <span class="annee">${item.annee || 'N/A'}</span><br>
              <strong><i class="fa fa-language"></i> Language:</strong> <span class="langue">${item.langue || 'N/A'}</span><br>
              <strong><i class="fa fa-globe"></i> Country:</strong> <span class="pays">${item.pays || 'N/A'}</span><br>
              <strong><i class="fa fa-mountain"></i> Field of Study:</strong> <span class="terrain_etude">${item.terrain_etude || 'N/A'}</span><br>
              <strong><i class="fa fa-building"></i> Publisher:</strong> <span class="editeur">${item.editeur || 'N/A'}</span>
            </p>
            <a href="${item.url_article || '#'}" target="_blank" class="btn btn-outline-primary btn-sm">
              <i class="fa fa-book-open"></i> View Article
            </a>
          </div>
        </div>
      </div>
    `).join('');

    // --- Initialize List.js ---
    const options = {
        valueNames: ['titre', 'auteur', 'type_article', 'annee', 'langue', 'pays', 'terrain_etude', 'editeur'],
        page: paginationShortcode,
        pagination: true
    };

    const publicationList = new List(containerId, options);

    // Prevent scrolling on pagination click
    const pagination = container.querySelector('.pagination');
    if (pagination) {
        pagination.addEventListener('click', e => {
            if (e.target.tagName === 'A') e.preventDefault();
        });
    }

    // --- Dynamic Filter Setup ---
    const makeSelectOptions = (id, field) => {
        const select = container.querySelector(`#${id}`);
        if (!select) return;
        const values = [...new Set(data.map(d => d[field]).filter(Boolean))];
        if (field === 'annee') values.sort((a, b) => b - a);
        else values.sort();
        values.forEach(v => {
            const opt = document.createElement('option');
            opt.value = v;
            opt.textContent = v;
            select.appendChild(opt);
        });
    };

    makeSelectOptions('filter-type', 'type_article');
    makeSelectOptions('filter-annee', 'annee');
    makeSelectOptions('filter-langue', 'langue');
    makeSelectOptions('filter-editeur', 'editeur');
    makeSelectOptions('filter-pays', 'pays');

    // --- Results Count ---
    const resultsInfo = container.querySelector('#results-info');
    const noResults = container.querySelector('#no-results');

    function updateResultsCount() {
        const count = publicationList.matchingItems.length;
        if (count === 0) {
            noResults.style.display = 'block';
            resultsInfo.style.display = 'none';
        } else {
            noResults.style.display = 'none';
            resultsInfo.style.display = 'inline-block';
            resultsInfo.textContent = `${count} result${count > 1 ? 's' : ''} found`;
        }
    }

    publicationList.on('updated', () => {
        updateResultsCount();
        const cards = container.querySelectorAll('.card-wrapper');
        cards.forEach((el, i) => {
            el.style.animation = 'none';
            el.style.opacity = '1';
            setTimeout(() => {
                el.style.animation = `laspadFadeInUp 0.6s ease both`;
                el.style.animationDelay = `${i * 0.05}s`;
            }, 10);
        });
    });

    updateResultsCount();

    // --- Apply Filters ---
    function applyFilters() {
        const type = container.querySelector('#filter-type')?.value || '';
        const annee = container.querySelector('#filter-annee')?.value || '';
        const langue = container.querySelector('#filter-langue')?.value || '';
        const editeur = container.querySelector('#filter-editeur')?.value || '';
        const pays = container.querySelector('#filter-pays')?.value || '';

        publicationList.filter(item => {
            const v = item.values();

            const matchType = !type || (v.type_article && v.type_article.trim() === type.trim());
            const matchAnnee = !annee || (v.annee && String(v.annee).trim() === String(annee).trim());
            const matchLangue = !langue || (v.langue && v.langue.trim() === langue.trim());
            const matchEditeur = !editeur || (v.editeur && v.editeur.trim() === editeur.trim());
            const matchPays = !pays || (v.pays && v.pays.trim() === pays.trim());

            return matchType && matchAnnee && matchLangue && matchEditeur && matchPays;
        });
    }

    // Bind filter change events
    ['filter-type', 'filter-annee', 'filter-langue', 'filter-editeur', 'filter-pays'].forEach(id => {
        const select = container.querySelector(`#${id}`);
        if (select) select.addEventListener('change', applyFilters);
    });

    // --- Text search filter ---
    const searchInput = container.querySelector('.search');
    if (searchInput) {
        searchInput.addEventListener('keyup', function () {
            const searchValue = this.value;
            publicationList.search(searchValue);
            applyFilters();
        });
    }
});
