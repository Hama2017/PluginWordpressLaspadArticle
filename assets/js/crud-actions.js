/**
 * JavaScript pour gérer les interactions CRUD
 */

(function($) {
    'use strict';

    $(document).ready(function() {

        /**
         * Validation du formulaire d'article
         */
        $('#laspad-article-form').on('submit', function(e) {
            var isValid = true;
            var errorMessage = '';

            // Validation de l'année
            var annee = parseInt($('#annee').val());
            var currentYear = new Date().getFullYear();
            if (annee < 1900 || annee > currentYear + 5) {
                isValid = false;
                errorMessage += 'L\'année doit être entre 1900 et ' + (currentYear + 5) + '.\n';
            }

            // Validation de l'URL
            var url = $('#url_article').val();
            var urlPattern = /^https?:\/\/.+/i;
            if (!urlPattern.test(url)) {
                isValid = false;
                errorMessage += 'L\'URL doit commencer par http:// ou https://.\n';
            }

            if (!isValid) {
                e.preventDefault();
                alert('Erreur de validation:\n\n' + errorMessage);
                return false;
            }

            // Afficher un loader pendant la soumission
            var submitBtn = $(this).find('button[type="submit"]');
            var originalText = submitBtn.html();
            submitBtn.prop('disabled', true);
            submitBtn.html('<i class="fas fa-spinner fa-spin"></i> Enregistrement...');

            // Note: Le formulaire sera soumis normalement après cette fonction
            // Le bouton sera réactivé au chargement de la page suivante
        });

        /**
         * Confirmation de suppression améliorée
         */
        $('.laspad-btn-delete').on('click', function(e) {
            var articleTitle = $(this).closest('tr').find('td:nth-child(3) strong').text();
            var confirmMessage = 'Êtes-vous sûr de vouloir supprimer cet article ?\n\n';
            confirmMessage += 'Titre: ' + articleTitle + '\n\n';
            confirmMessage += 'Cette action est irréversible !';

            if (!confirm(confirmMessage)) {
                e.preventDefault();
                return false;
            }
        });

        /**
         * Animation des boutons d'action
         */
        $('.laspad-btn-action').hover(
            function() {
                $(this).css('transform', 'scale(1.1)');
            },
            function() {
                $(this).css('transform', 'scale(1)');
            }
        );

        /**
         * Scroll vers le formulaire quand on clique sur "Ajouter"
         */
        if (window.location.href.indexOf('action=edit') > -1) {
            $('html, body').animate({
                scrollTop: $('#laspad-article-form').offset().top - 50
            }, 500);
        }

        /**
         * Auto-dismiss des messages après 5 secondes
         */
        setTimeout(function() {
            $('.settings-error').fadeOut('slow');
        }, 5000);

        /**
         * Confirmation avant de quitter la page avec un formulaire modifié
         */
        var formModified = false;
        $('#laspad-article-form input, #laspad-article-form select, #laspad-article-form textarea').on('change', function() {
            formModified = true;
        });

        $('#laspad-article-form').on('submit', function() {
            formModified = false;
        });

        $(window).on('beforeunload', function() {
            if (formModified) {
                return 'Vous avez des modifications non enregistrées. Voulez-vous vraiment quitter cette page ?';
            }
        });

        /**
         * Prévisualisation de l'URL
         */
        $('#url_article').on('blur', function() {
            var url = $(this).val();
            if (url && !url.match(/^https?:\/\//i)) {
                $(this).val('https://' + url);
            }
        });

        /**
         * Capitalisation automatique du premier caractère
         */
        $('#titre, #auteur, #editeur').on('blur', function() {
            var value = $(this).val();
            if (value.length > 0) {
                $(this).val(value.charAt(0).toUpperCase() + value.slice(1));
            }
        });

    });

})(jQuery);
