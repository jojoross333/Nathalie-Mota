<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Nathalie-theme
 */
?>

<?php get_header(); ?>   <!-- le header -->
<section>
    <?php get_template_part('/templates/hero'); ?>    <!-- l'entête hero image -->
</section>
<section class="filtres_container">
    <?php get_template_part('templates/filtres'); ?>   <!-- template des filtres -->
</section>

<section id="catalogueContainer">
    <div class="photo-display" id="photo-display">
        <?php afficher_photos_catalogue(); // Affiche les photos par défaut ?>
    </div>
    <!-- Bouton Charger Plus -->
    <div id="load-moreContainer"></div>
    <button id="btnLoad-more">Charger Plus</button>
</section>

<?php get_footer(); ?>

