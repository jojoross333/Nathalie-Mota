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
                
                // Réappliquer le style grid pour s'assurer que les photos sont bien affichées en grille
                $('#photo-display').css('display', 'grid'); 
                $('#photo-display').css('grid-template-columns', 'repeat(2, 1fr)'); // Assure que la grille reste en 2 colonnes
                $('#photo-display').css('gap', '20px'); // Espace entre les photos
            }
        });
    });
});


