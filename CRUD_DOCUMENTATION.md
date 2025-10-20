# Documentation CRUD - Laspad Article Plugin

## Fonctionnalités ajoutées

### 1. Formulaire d'ajout manuel d'articles

Un formulaire complet a été ajouté à la page d'administration permettant d'ajouter manuellement des articles à la base de données sans passer par l'import CSV.

**Champs du formulaire:**
- Type d'article (texte)
- Titre (texte)
- Année (numéro, entre 1900 et l'année en cours + 5)
- Langue (texte)
- Genre auteur (sélection: Homme, Femme, Autre)
- Auteur(s) (texte)
- URL de l'article (URL valide)
- Terrain d'étude (texte)
- Éditeur (texte)
- Pays (texte)

**Validations:**
- Tous les champs sont obligatoires
- L'année doit être valide
- L'URL doit commencer par http:// ou https://
- Protection CSRF avec nonce WordPress

### 2. Modification d'articles

Chaque ligne du tableau contient un bouton "Modifier" (icône crayon bleu) qui permet de:
- Charger les données de l'article dans le formulaire
- Modifier tous les champs
- Enregistrer les modifications

**Accès:** Cliquez sur l'icône de modification dans la colonne "Actions" du tableau.

### 3. Suppression d'articles

Chaque ligne du tableau contient un bouton "Supprimer" (icône poubelle rouge) qui permet de:
- Supprimer définitivement un article
- Confirmation JavaScript avant suppression
- Protection CSRF avec nonce WordPress

**Accès:** Cliquez sur l'icône de suppression dans la colonne "Actions" du tableau.

### 4. Colonne Actions dans le tableau

Une nouvelle colonne "Actions" a été ajoutée au tableau DataTable avec:
- Bouton Modifier (bleu)
- Bouton Supprimer (rouge)
- Tooltips au survol
- Animations CSS

## Fichiers créés

### 1. `/includes/admin/crud-handler.php`
Gestionnaire principal des opérations CRUD:
- `laspad_handle_add_article()` - Traite l'ajout d'articles
- `laspad_handle_edit_article()` - Traite la modification d'articles
- `laspad_handle_delete_article()` - Traite la suppression d'articles
- `laspad_get_article_by_id()` - Récupère un article par ID

### 2. `/includes/admin/form/article-form.php`
Formulaire d'ajout et de modification:
- Formulaire HTML complet avec validation
- Mode ajout et mode édition
- Intégration Bootstrap
- Icônes FontAwesome

### 3. `/assets/js/crud-actions.js`
JavaScript pour les interactions:
- Validation client du formulaire
- Confirmation de suppression améliorée
- Animations des boutons
- Auto-dismiss des messages après 5 secondes
- Prévention de la perte de données non enregistrées
- Capitalisation automatique
- Prévisualisation URL

### 4. Modifications CSS dans `/assets/css/admin-page.css`
Styles ajoutés pour:
- Formulaire d'article
- Boutons d'action (modifier/supprimer)
- Messages de succès/erreur
- Animations et transitions
- Responsive design

## Fichiers modifiés

### 1. `/laspad-article.php`
- Inclusion du gestionnaire CRUD

### 2. `/includes/admin/admin-page.php`
- Correction du slug de page (laspad-article)
- Ajout du script JavaScript crud-actions.js

### 3. `/includes/admin/admin-page-content.php`
- Inclusion du formulaire d'ajout/modification

### 4. `/includes/admin/admin-page-content-list-articles.php`
- Ajout de la colonne "Actions"
- Boutons Modifier et Supprimer pour chaque ligne

## Sécurité

Toutes les opérations CRUD sont sécurisées avec:
- **Nonces WordPress** pour la protection CSRF
- **Sanitization** de toutes les entrées utilisateur
- **Prepared statements** pour les requêtes SQL
- **Vérification des capacités** (manage_options)
- **Échappement** des sorties HTML

## Messages utilisateur

Le système affiche des messages clairs:
- ✅ "Article ajouté avec succès!"
- ✅ "Article modifié avec succès!"
- ✅ "Article supprimé avec succès!"
- ❌ Messages d'erreur en cas de problème

Les messages disparaissent automatiquement après 5 secondes.

## Utilisation

### Ajouter un article
1. Accédez à "Laspad Article CSV" dans le menu WordPress
2. Remplissez le formulaire "Ajouter un article manuellement"
3. Cliquez sur "Ajouter l'article"

### Modifier un article
1. Dans le tableau des articles, cliquez sur l'icône de modification (crayon bleu)
2. Le formulaire se remplit avec les données de l'article
3. Modifiez les champs souhaités
4. Cliquez sur "Enregistrer les modifications"

### Supprimer un article
1. Dans le tableau des articles, cliquez sur l'icône de suppression (poubelle rouge)
2. Confirmez la suppression dans la boîte de dialogue
3. L'article est supprimé définitivement

## Améliorations futures possibles

- Export des articles en CSV
- Import/Export JSON
- Recherche avancée avec filtres
- Édition en masse
- Historique des modifications
- Corbeille (soft delete)
- API REST pour les articles
- Duplicate article
- Trier les colonnes

## Support

Pour toute question ou problème, contactez l'équipe de développement:
- Hamadou BA
- Mouhamadou Lamine BATHILY
- Saliou NGOM
