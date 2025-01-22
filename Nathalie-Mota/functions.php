<?php 
/**
 * Nathalie-theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Nathalie-theme
 */

function nathalie_mota_scripts() {
    // Chargement du thème
    wp_enqueue_style('nathalie-mota-style', get_template_directory_uri() . '/assets/css/theme.css', array(), 1.1);
    //chargement de scripts.js
    wp_enqueue_script('modale', get_template_directory_uri() . '/assets/js/scripts.js', array(), null, true);

}

add_action('wp_enqueue_scripts', 'nathalie_mota_scripts');

function create_post_type_photo() {
    register_post_type('photo',
        array(
            'labels' => array(
                'name' => __('Photos'),
                'singular_name' => __('Photo')
            ),
            'public' => true,
            'has_archive' => true,
            'supports' => array('title', 'editor', 'thumbnail'), // Indique ce qui doit être supporté (titre, contenu, vignettes)
            'rewrite' => array('slug' => 'photo'), // Permalien, selon vos besoins
        )
    );
}
add_action('init', 'create_post_type_photo');

function create_photo_taxonomy() {
    register_taxonomy(
        'categorie_photo', // Ou vous pouvez garder 'categorie' si vous préférez
        'photo', // Post type auquel elle est associée
        array(
            'label' => __('Catégories de Photos'),
            'rewrite' => array('slug' => 'categorie'),
            'hierarchical' => true, // Permet de créer des catégories parent/enfant
        )
    );
}
add_action('init', 'create_photo_taxonomy');