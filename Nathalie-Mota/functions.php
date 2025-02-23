<?php 
/**
 * Nathalie-theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Nathalie-theme
 */

// Enqueue Scripts et Styles

function nathalie_mota_scripts() {
    // Charger le CSS du thème
    wp_enqueue_style('nathalie-mota-style', get_template_directory_uri() . '/assets/css/theme.css', array(), '1.1');

    // Charger le script JavaScript modale
    wp_enqueue_script('modale', get_template_directory_uri() . '/assets/js/scripts.js', array('jquery'), null, true);

    // Charger le script pour le bouton "Charger plus" (load-more.js)
    wp_enqueue_script('load-more', get_template_directory_uri() . '/assets/js/load-more.js', array('jquery'), null, true);
    
    // Localiser le script pour passer l'URL d'AJAX à JavaScript
    wp_localize_script('load-more', 'MyAjax', array(
        'ajaxurl' => admin_url('admin-ajax.php')  // URL pour l'appel AJAX
    ));

    // Ajouter Select2 via CDN
    wp_enqueue_style('select2-style', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css');
    wp_enqueue_script('select2-script', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js', array('jquery'), null, true);

    // Ajouter le fichier select2.js personnalisé
    wp_enqueue_script('select2-custom', get_template_directory_uri() . '/assets/js/selec2.js', array('jquery', 'select2-script'), null, true);

    // Enqueue le script de la lightbox
    wp_enqueue_script('lightbox', get_template_directory_uri() . '/assets/js/lightbox.js', array('jquery'), null, true);

}
add_action('wp_enqueue_scripts', 'nathalie_mota_scripts');


// -------------------Création du Custom Post Type "photo"-----------

function create_post_type_photo() {
    register_post_type('photo', array(
        'labels' => array(
            'name' => __('Photos'),
            'singular_name' => __('Photo'),
        ),
        'public' => true,
        'has_archive' => true,
        'supports' => array('title', 'editor', 'thumbnail'),
        'rewrite' => array('slug' => 'photo'),
    ));
}

add_action('init', 'create_post_type_photo');

// ------Création des taxonomies : Catégorie et Format---------------

function create_photo_taxonomy() {
    // Taxonomie "Catégorie"
    register_taxonomy('categorie', 'photo', array(
        'label' => __('Catégories de Photos'),
        'rewrite' => array('slug' => 'categorie'),
        'hierarchical' => true,
    ));

    // Taxonomie "Format"
    register_taxonomy('format', 'photo', array(
        'label' => __('Formats de Photos'),
        'rewrite' => array('slug' => 'format'),
        'hierarchical' => true,
    ));
}

add_action('init', 'create_photo_taxonomy');

// Fonction pour afficher les photos dans la galerie (front-page.php)-----------------------

function afficher_photos_catalogue($args = array()) {
    // Définir les arguments de la requête
    $default_args = array(
        'post_type' => 'photo',         // CPT 'photo'
        'posts_per_page' => 8,          // Nombre de photos par page
    );
    $args = array_merge($default_args, $args);  // Fusionner les arguments si des filtres sont passés

    // La requête WP_Query pour récupérer les photos
    $photo_query = new WP_Query($args);

    if ($photo_query->have_posts()) :
        echo '<div class="photo-display">';  // Utiliser 'photo-display' ici pour la cohérence
        while ($photo_query->have_posts()) : $photo_query->the_post();

            // Inclure le fichier load.php pour afficher chaque photo
            include(get_template_directory() . '/templates/load.php'); 

        endwhile;
        echo '</div>';
    else :
        echo '<p>Aucune photo trouvée.</p>';
    endif;

    wp_reset_postdata();  // Réinitialiser les données de la requête
}


// -------Action AJAX pour filtrer les photos----------------------------------------

// ------ Action AJAX pour filtrer les photos -------
add_action('wp_ajax_filtrer_photos', 'filtrer_photos');
add_action('wp_ajax_nopriv_filtrer_photos', 'filtrer_photos');

function filtrer_photos() {
    // Récupérer les filtres envoyés via AJAX
    $filters = isset($_POST['filters']) ? $_POST['filters'] : [];

    // Paramètres de base de la requête WP_Query pour récupérer les photos filtrées
    $args = array(
        'post_type' => 'photo',  // Le type de post
        'posts_per_page' => 8,   // Nombre de photos à afficher
        'orderby' => 'date',     // Trier par date par défaut
        'order' => 'DESC',       // Par ordre décroissant
        'tax_query' => array(),  // Initialisation du tableau des filtres taxonomies
    );

    // Vérifier si le filtre "Trier par" est passé dans les filtres
    if (isset($filters['annee'])) {
        $args['order'] = $filters['annee'];  // soit 'ASC' soit 'DESC'
    }

    // Ajouter les filtres dynamiques (catégorie, format, année) dans la requête
    foreach ($filters as $taxonomy => $value) {
        if (!empty($value) && $taxonomy !== 'annee') {
            if ($taxonomy === 'annee') {
                $args['year'] = $value; // Filtrer par année
            } else {
                $args['tax_query'][] = array(
                    'taxonomy' => $taxonomy,  // Catégorie, format, etc.
                    'field' => 'slug',
                    'terms' => $value,
                    'operator' => 'IN',
                );
            }
        }
    }

    // Exécuter la requête WP_Query avec les filtres
    $query = new WP_Query($args);

    if ($query->have_posts()) :
        echo '<div class="photo-display">';  // Ajout de la div "photo-display"
        while ($query->have_posts()) : $query->the_post();
            // Inclure le fichier load.php pour afficher chaque photo
            include(get_template_directory() . '/templates/load.php');
        endwhile;
        echo '</div>';
    else :
        echo '<p>Aucune photo trouvée.</p>';
    endif;

    die();  // Terminer l'exécution après la réponse AJAX
}


//-------- Enqueue le script AJAX pour les filtres------------------

add_action('wp_enqueue_scripts', 'enqueue_ajax_filter_script');

function enqueue_ajax_filter_script() {
    wp_enqueue_script('ajax-filter', get_template_directory_uri() . '/assets/js/ajax-filter.js', array('jquery'), null, true);

    // Localiser le script pour passer l'URL d'AJAX à JavaScript
    wp_localize_script('ajax-filter', 'ajax_filter_obj', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
    ));
}


// ------------Action AJAX pour charger plus de photos---------------__________________________________

// ------- Action AJAX pour charger plus de photos -------
add_action('wp_ajax_load_more_photos', 'load_more_photos');
add_action('wp_ajax_nopriv_load_more_photos', 'load_more_photos');

function load_more_photos() {
    // Récupérer les paramètres passés par AJAX
    $category = isset($_POST['category']) ? $_POST['category'] : '';
    $format = isset($_POST['format']) ? $_POST['format'] : '';
    $year = isset($_POST['year']) ? $_POST['year'] : '';
    $photoArray = isset($_POST['photoArray']) ? $_POST['photoArray'] : [];  // Liste des photos déjà affichées

    // Paramètres de la requête WP_Query pour récupérer les photos filtrées
    $args = array(
        'post_type' => 'photo',
        'posts_per_page' => 8,  // Nombre de photos à charger
        'orderby' => 'date',
        'order' => 'ASC',
        'tax_query' => array(),
    );

    // Ajouter les filtres pour la catégorie, le format, l'année
    if ($category) {
        $args['tax_query'][] = array(
            'taxonomy' => 'categorie',
            'field' => 'slug',
            'terms' => $category,
            'operator' => 'IN',
        );
    }

    if ($format) {
        $args['tax_query'][] = array(
            'taxonomy' => 'format',
            'field' => 'slug',
            'terms' => $format,
            'operator' => 'IN',
        );
    }

    if ($year) {
        $args['year'] = $year;
    }

    // Si nous avons déjà des photos affichées, exclure celles-ci
    if (!empty($photoArray)) {
        $args['post__not_in'] = $photoArray;  // Exclure les photos déjà affichées
    }

    // Exécuter la requête WP_Query
    $query = new WP_Query($args);

    if ($query->have_posts()) :
        // Afficher la nouvelle div contenant les photos
        echo '<div class="photo-display">';  // Ajoute cette div pour englober toutes les photos
        while ($query->have_posts()) : $query->the_post();
            // Inclure le fichier load.php pour afficher chaque photo
            include(get_template_directory() . '/templates/load.php');
        endwhile;
        echo '</div>';  // Fermeture de la div .photo-display
    else :
        echo 'Aucune photo trouvée.';
    endif;

    die(); // Terminer l'exécution après la réponse AJAX
    wp_reset_postdata();
}


function enqueue_photo_navigation_script() {
    // Enqueue votre script
    wp_enqueue_script('miniature-script', get_template_directory_uri() . '/assets/js/miniature.js', array('jquery'), null, true);

    // Localiser les variables PHP et les passer à JavaScript
    $all_thumbnails = [];
    $all_photo_ids = [];

    // Récupérer toutes les photos
    $all_photos_query = new WP_Query(array(
        'post_type' => 'photo',
        'posts_per_page' => -1,  // Charger toutes les photos
        'orderby' => 'date',
        'order' => 'ASC'
    ));

    // Stocker les informations dans les tableaux
    if ($all_photos_query->have_posts()) :
        while ($all_photos_query->have_posts()) : $all_photos_query->the_post();
            $all_thumbnails[] = get_the_post_thumbnail_url(get_the_ID(), 'thumbnail');
            $all_photo_ids[] = get_permalink(get_the_ID());
        endwhile;
    endif;

    wp_reset_postdata();

    // Localiser les variables et les transmettre au script JS
    wp_localize_script('miniature-script', 'photoData', array(
        'thumbnails' => $all_thumbnails,
        'photo_ids' => $all_photo_ids
    ));
}
add_action('wp_enqueue_scripts', 'enqueue_photo_navigation_script');


