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
    wp_enqueue_style('nathalie-mota-style', get_template_directory_uri() . '/assets/css/theme.css', array(), 1.1);
    
    // Charger le script JavaScript modale
    wp_enqueue_script('modale', get_template_directory_uri() . '/assets/js/scripts.js', array(), null, true);

    // Charger le script pour le bouton "Charger plus" (load-more.js)
    wp_enqueue_script('load-more', get_template_directory_uri() . '/assets/js/load-more.js', array('jquery'), null, true);

    // Localiser le script pour passer l'URL d'AJAX à JavaScript
    wp_localize_script('load-more', 'MyAjax', array(
        'ajaxurl' => admin_url('admin-ajax.php')  // URL pour l'appel AJAX
    ));
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
    $default_args = array(
        'post_type' => 'photo',
        'posts_per_page' => 8,   // Nombre de photos à afficher par défaut
    );
    $args = array_merge($default_args, $args);  // Fusionner les arguments si des filtres sont passés

    // La requête WP_Query pour récupérer les photos
    $photo_query = new WP_Query($args);

    if ($photo_query->have_posts()) :
        echo '<div class="photo-gallery">';
        while ($photo_query->have_posts()) : $photo_query->the_post();
            ?>
            <div class="photo-item">
                <a href="<?php the_permalink(); ?>">
                    <?php if (has_post_thumbnail()) {
                        the_post_thumbnail('medium'); // Affiche la miniature de la photo
                    } ?>
                </a>
            </div>
            <?php
        endwhile;
        echo '</div>';
        wp_reset_postdata();  // Réinitialiser les données de la requête
    else :
        echo '<p>Aucune photo trouvée.</p>';
    endif;
}

// -------Action AJAX pour filtrer les photos----------------------------------------

add_action('wp_ajax_filtrer_photos', 'filtrer_photos');  // Pour les utilisateurs connectés
add_action('wp_ajax_nopriv_filtrer_photos', 'filtrer_photos');  // Pour les utilisateurs non connectés

function filtrer_photos() {
    // Récupérer les filtres envoyés via AJAX
    $filters = isset($_POST['filters']) ? $_POST['filters'] : [];

    // Paramètres de base de la requête WP_Query pour récupérer les photos filtrées
    $args = array(
        'post_type' => 'photo',  // Le type de post
        'posts_per_page' => 8,   // Nombre de photos à afficher
        'orderby' => 'date',     // Trier par date
        'order' => 'DESC',       // Par ordre décroissant
        'tax_query' => array(),  // Initialisation du tableau des filtres taxonomies
    );

    // Ajouter les filtres dynamiques (catégorie, format, année) dans la requête
    foreach ($filters as $taxonomy => $value) {
        if (!empty($value)) {
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
        while ($query->have_posts()) : $query->the_post();
            ?>
            <div class="photo-item">
                <a href="<?php the_permalink(); ?>">
                    <?php if (has_post_thumbnail()) {
                        the_post_thumbnail('medium');
                    } ?>
                </a>
            </div>
            <?php
        endwhile;
        wp_reset_postdata();
    else :
        echo '<p>Aucune photo trouvée.</p>';
    endif;

    die(); // Terminer l'exécution après la réponse AJAX
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


// ------------Action AJAX pour charger plus de photos---------------

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
        // Inclure le fichier 'load.php' pour chaque photo
        while ($query->have_posts()) : $query->the_post();
            get_template_part('templates/load');  // Charger le bloc photo
        endwhile;
        wp_reset_postdata();
    else :
        echo 'Aucune photo trouvée.';
    endif;

    die(); // Terminer l'exécution après la réponse AJAX
}
