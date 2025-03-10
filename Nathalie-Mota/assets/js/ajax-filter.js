jQuery(function($) {
    // Lorsque l'un des filtres est modifié
    $('.taxonomy-select').on('change', function() {
        var filters = {}; // Objet pour stocker tous les filtres

        // Je récupère tous les filtres de mon CPT UI WP ( on peut donc ajouter via l'interface sans code de nouvelle taxonomie)
        $('.taxonomy-select').each(function() {
            var filterId = $(this).attr('id'); //permet de récuperer tout type de filtre (récupere l'id de chaque select)
            var filterValue = $(this).val();  // récupere la valeur du filtre 
            
            if (filterValue) {
                filters[filterId] = filterValue; // Ajoute le filtre à l'objet filters
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
            url: ajax_filter_obj.ajaxurl, // url utilisé par wp pour les rêquete ajax 
            method: 'POST',   //post pour envoyé les données au serveur 
            data: {
                action: 'filtrer_photos', // // action définie dans le back office 
                filters: filters, // Objet contenant tous les filtres
                photoArray: photoIds  // Liste des photos déjà affichées
            },
            success: function(response) { //reçoit la réponse du serveur 
                $('#photo-display').html(response); //affiche le contenu après la réponse wp sans recahrgement de page 
            }
        });
    });
});


