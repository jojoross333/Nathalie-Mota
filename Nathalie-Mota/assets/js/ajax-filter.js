jQuery(function($) {
    // Lorsque l'un des filtres est modifié
    $('.taxonomy-select').on('change', function() {
        var filters = {}; // Objet pour stocker tous les filtres

        // Récupérer la valeur de chaque filtre
        $('.taxonomy-select').each(function() {
            var filterId = $(this).attr('id'); // Catégories, formats, etc.
            var filterValue = $(this).val();  // Valeur du filtre (par exemple, la catégorie sélectionnée)
            
            if (filterValue) {
                filters[filterId] = filterValue; // Ajouter le filtre à l'objet filters
            }
        });

        // Effectuer la requête AJAX
        $.ajax({
            url: ajax_filter_obj.ajaxurl,
            method: 'POST',
            data: {
                action: 'filtrer_photos', // Action côté PHP
                filters: filters, // Objet contenant tous les filtres
            },
            success: function(response) {
                $('#photo-display').html(response); // Remplace le contenu avec les photos filtrées
            }
        });
    });
});
