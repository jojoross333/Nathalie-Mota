jQuery(document).ready(function($) {
    // Lorsque l'utilisateur clique sur "Charger plus"
    $('#btnLoad-more').on('click', function() {
        load_more_photos();
    });

    // Fonction pour charger plus de photos via AJAX
    function load_more_photos() {
        const category = $('#categorie').val();  // Récupère la catégorie sélectionnée
        const format = $('#format').val();       // Récupère le format sélectionné
        const year = $('#annee').val();          // Récupère l'année sélectionnée

        // Récupère les IDs des photos déjà affichées (y compris les nouvelles photos chargées)
        const photoIds = [];
        $('.photo-item').each(function() {
            const photoId = $(this).data('photo-id');  // Récupère l'ID de chaque photo
            if(photoId) {
                photoIds.push(photoId);  // Ajoute cet ID au tableau photoIds
            }
        });

        console.log(photoIds);  // Affiche les IDs des photos déjà présentes dans la console

        $.ajax({
            url: MyAjax.ajaxurl,  // URL d'AJAX
            type: 'POST',
            data: {
                action: 'load_more_photos',  // Action côté PHP
                photoArray: photoIds,  // Liste des photos déjà affichées pour éviter les doublons
                category: category,
                year: year,
                format: format
            },
            success: function(response) {
                if (response) {
                    // Ajoute les nouvelles photos au container
                    $('#photo-display').append(response);
                } else {
                    // Si aucune photo n'est trouvée, masque le bouton
                    $('#btnLoad-more').hide();
                }
            },
            error: function(error) {
                console.log('Error:', error);
            }
        });
    }
});
