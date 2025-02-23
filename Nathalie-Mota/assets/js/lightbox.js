jQuery(document).ready(function($) {
    // Cacher la lightbox au départ
    $('#lightbox-overlay').hide();

    // Fonction pour activer la lightbox pour chaque photo
    function activateLightbox() {
        // Ouvrir la lightbox au clic sur le plein écran
        $('.full-screen').on('click', function(e) {
            e.preventDefault();

            const imageSrc = $(this).data('image');
            const reference = $(this).data('reference');
            const category = $(this).data('category');

            // Mettre à jour le contenu de la lightbox
            $('#lightbox-image').attr('src', imageSrc);
            $('#photo-reference').text('Référence : ' + reference);
            $('#photo-category').text('Catégorie : ' + category);

            // Afficher la lightbox
            $('#lightbox-overlay').fadeIn();
        });
    }

    // Initialiser la lightbox pour les éléments existants
    activateLightbox();

    // Lorsque de nouvelles photos sont chargées via AJAX, réappliquer la lightbox
    $(document).ajaxComplete(function() {
        activateLightbox(); // Réactive la lightbox sur les nouvelles photos ajoutées via AJAX
    });

    // Fermer la lightbox
    $('#close-lightbox').on('click', function() {
        $('#lightbox-overlay').fadeOut();
    });

    // Navigation dans la lightbox (Précédente et Suivante)
    let currentIndex = 0;

    $('#prev-photo').on('click', function() {
        currentIndex--;
        if (currentIndex < 0) currentIndex = $('.photo-item').length - 1;
        updateLightboxImage(currentIndex);
    });

    $('#next-photo').on('click', function() {
        currentIndex++;
        if (currentIndex >= $('.photo-item').length) currentIndex = 0;
        updateLightboxImage(currentIndex);
    });

    function updateLightboxImage(index) {
        const photo = $('.photo-item').eq(index);
        const imageSrc = photo.find('.full-screen').data('image');
        const reference = photo.find('.full-screen').data('reference');
        const category = photo.find('.full-screen').data('category');

        $('#lightbox-image').attr('src', imageSrc);
        $('#photo-reference').text('Référence : ' + reference);
        $('#photo-category').text('Catégorie : ' + category);
    }
});
