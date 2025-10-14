# Laspad Article - Plugin WordPress

## Description

Laspad Article est un plugin WordPress puissant qui permet d'afficher une galerie dynamique d'articles scientifiques. Il offre des fonctionnalités avancées de filtrage, de recherche et d'affichage personnalisable. Le plugin se connecte à une base de données pour stocker et gérer les articles, et peut être intégré n'importe où sur votre site via un shortcode simple.

## Fonctionnalités principales

- **Importation de données** : Importez facilement des articles depuis des fichiers CSV
- **Affichage personnalisable** : Affichez vos articles sous forme de grille ou de liste
- **Filtrage avancé** : Filtrez les articles par type, année, auteur, etc.
- **Recherche en temps réel** : Recherchez parmi vos articles instantanément
- **Pagination** : Navigation facile avec pagination intégrée
- **Responsive** : S'adapte parfaitement à tous les appareils
- **Interface d'administration** : Gestion intuitive des articles depuis le tableau de bord WordPress

## Installation

1. Téléchargez le fichier ZIP du plugin
2. Dans votre tableau de bord WordPress, allez dans "Extensions > Ajouter > Téléverser"
3. Sélectionnez le fichier ZIP et cliquez sur "Installer maintenant"
4. Activez le plugin
5. Le plugin créera automatiquement la table nécessaire dans votre base de données

## Configuration

Après l'activation, un nouveau menu "Laspad Articles" apparaîtra dans votre tableau de bord WordPress. Vous pourrez :

- Importer des articles via CSV
- Gérer les articles existants
- Configurer les options d'affichage

## Utilisation

### Shortcode

Pour afficher la galerie d'articles, utilisez le shortcode suivant :

```
[display_articles pagination="12" cards_per_row="3"]
```

**Paramètres :**
- `pagination` : Nombre d'articles à afficher par page (défaut: 12)
- `cards_per_row` : Nombre de cartes par ligne (défaut: 3)

### Importation de données

1. Préparez votre fichier CSV avec les colonnes suivantes :
   - type_article
   - titre
   - annee
   - langue
   - auteur
   - genre_auteur
   - url_article
   - terrain_etude
   - editeur
   - pays

2. Allez dans "Laspad Articles > Importer"
3. Téléversez votre fichier CSV
4. Cliquez sur "Importer"

## Structure des fichiers

```
plugin-wordpress-laspad-article/
├── assets/
│   ├── css/
│   │   ├── admin-page.css
│   │   └── shortcode-template.css
│   ├── js/
│   │   ├── datatable-init.js
│   │   └── listjs-init.js
│   └── vendor/
│       ├── bootstrap-5.0.2-dist/
│       ├── datatables-2.3.4/
│       └── fontawesome-free-7.1.0-web/
├── includes/
│   ├── admin/
│   │   ├── form/
│   │   ├── admin-page-content-list-articles.php
│   │   └── admin-page-content.php
│   ├── database/
│   │   └── create-table.php
│   ├── shortcode/
│   │   ├── articles-template.php
│   │   └── display-articles-shortcode.php
│   └── constants.php
└── laspad-article.php
```

## Personnalisation

### Styles

Vous pouvez personnaliser l'apparence en surchargeant les fichiers CSS dans votre thème. Créez un dossier `laspad-article` dans le répertoire de votre thème et ajoutez-y vos fichiers CSS personnalisés.

### Filtres et actions

Le plugin propose plusieurs hooks pour une personnalisation avancée :


## Dépannage

### Problèmes courants

1. **L'importation échoue**
   - Vérifiez que le fichier CSV est correctement formaté
   - Assurez-vous que les permissions du serveur permettent l'écriture dans le dossier d'upload

2. **Les styles ne s'affichent pas**
   - Vérifiez que les fichiers CSS sont correctement chargés
   - Désactivez le cache si nécessaire

3. **Problèmes de base de données**
   - Vérifiez que la table `wp_laspad_articles` existe
   - Essayez de désactiver et réactiver le plugin pour régénérer la table

## Sécurité

- Toutes les entrées utilisateur sont correctement échappées et validées
- Les appels AJAX incluent des nonces de sécurité
- Les accès aux fonctionnalités d'administration sont protégés par des capacités WordPress

## Performance

Le plugin est optimisé pour les performances avec :
- Chargement paresseux des images
- Mise en cache des requêtes fréquentes
- Code JavaScript optimisé

## Contribution

Les contributions sont les bienvenues ! Pour contribuer :

1. Forkez le dépôt
2. Créez une branche pour votre fonctionnalité
3. Soumettez une pull request

## Licence

Ce plugin est distribué sous licence GPL v2 ou ultérieure.

## Auteurs

- Hamadou BA
- Mouhamadou Lamine BATHILY
- Saliou NGOM

## Support

Pour toute question ou problème, veuillez ouvrir une issue sur le dépôt GitHub.
