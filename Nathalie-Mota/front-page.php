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

<?php get_header(); ?>

<section class="hero">
    <h1>nathalie mota</h1>
    <h2>test</h2>
    <div class="hero-banner">
        <p>ceci est un testdhzaudhoazudhbozaubdzaudzod</p>
    </div>
</section>

<section class="photo-gallery">
    <h2>Mes Photos</h2>
    <?php
    // La requête pour obtenir les articles de type "photo"
    $args = array(
        'post_type' => 'photo', // Nom de votre CPT
        'posts_per_page' => 15, // Nombre de posts à afficher
    );
    $photo_query = new WP_Query($args);

    if ($photo_query->have_posts()) :
        while ($photo_query->have_posts()) : $photo_query->the_post();
            ?>
            <div class="photo-item">
                <h3><?php the_title(); ?></h3>
                <?php if (has_post_thumbnail()) {
                    the_post_thumbnail('medium'); // Affiche la miniature
                } ?>
                <a href="<?php the_permalink(); ?>">Voir la photo</a>
            </div>
            <?php
        endwhile;
        wp_reset_postdata(); // Réinitialiser les données de la requête
    else :
        echo '<p>Aucune photo trouvée.</p>';
    endif;
    ?>
</section>

<?php get_footer(); ?>

