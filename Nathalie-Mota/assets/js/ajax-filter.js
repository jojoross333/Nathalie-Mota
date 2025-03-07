jQuery(function($) {
    // Lorsque l'un des filtres est modifié
    $('.taxonomy-select').on('change', function() {
        var filters = {}; // Objet pour stocker tous les filtres

        // Je récupère tous les filtres de mon CPT UI WP ( on peut donc ajouter via l'interface sans code de nouvelle taxonomie)
        $('.taxonomy-select').each(function() {
            var filterId = $(this).attr('id'); // Catégories, formats du cpt ui.
            var filterValue = $(this).val();  // Valeur du filtre (par exemple, la catégorie sélectionnée)
            
            if (filterValue) {
                filters[filterId] = filterValue; // Ajouter le filtre à l'objet filters
            }
        });

        // Récupérer les IDs des photos déjà affichées (pour éviter la duplication)
        var photoIds = [];
        $('.photo-item').each(function() {
            var photoId = $(this).data('photo-id');
            if (photoId) {
                photoIds.push(photoId);  // Ajoute cet ID au tableau photoIds
            }
        });

        // Ici je fais appel a ajax pour la rêquete a WP (mon functions.php)
        $.ajax({
            url: ajax_filter_obj.ajaxurl,
            method: 'POST',
            data: {
                action: 'filtrer_photos', // Action côté PHP
                filters: filters, // Objet contenant tous les filtres
                photoArray: photoIds  // Liste des photos déjà affichées
            },
            success: function(response) {
                $('#photo-display').html(response); // Remplace le contenu avec les photos filtrées
        
            }
        });
    });
});


