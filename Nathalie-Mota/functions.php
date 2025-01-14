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

}

add_action('wp_enqueue_scripts', 'nathalie_mota_scripts');

// Ajouter la prise en charge des images mises en avant
add_theme_support( 'post-thumbnails' );

// Ajouter automatiquement le titre du site dans l'en-tête du site
add_theme_support( 'title-tag' );

function nathalie_mota_register_menus() {
    // Enregistrement du menu du header
    register_nav_menus(
        array(
            'header' => __( 'Menu du Header' ),
            'footer' => __( 'Menu du Footer' ),
        )
    );
}
add_action( 'after_setup_theme', 'nathalie_mota_register_menus' );

