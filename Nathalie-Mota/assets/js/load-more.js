jQuery(document).ready(function($) {
    $('#btnLoad-more').on('click', function() {
        load_more_photos(); // Ta fonction pour charger plus de photos
    });

    function load_more_photos() {
        const category = $('#categorie').val();
        const format = $('#format').val();
        const year = $('#annee').val();

        // Récupérer les IDs des photos déjà affichées (pour éviter les doublons)
        const photoIds = [];
        $('.photo-item').each(function() {
            const photoId = $(this).data('photo-id');
            if(photoId) {
                photoIds.push(photoId);
            }
        });

        $.ajax({
            url: MyAjax.ajaxurl,
            type: 'POST',
            data: {
                action: 'load_more_photos',
                photoArray: photoIds,
                category: category,
                format: format,
                year: year
            },
            success: function(response) {
                if (response) {
                    $('#photo-display').append(response); // Ajouter les nouvelles photos
                    // Forcer le recalcul de la mise en page grid après ajout
                    $('#photo-display').css('display', 'grid');
                    $('#photo-display').trigger('resize'); // Recalcule la disposition
                } else {
                    $('#btnLoad-more').hide(); // Cacher le bouton si aucune photo n'est trouvée
                }
            },
            error: function(error) {
                console.log('Erreur AJAX : ', error);
            }
        });
    }
});


