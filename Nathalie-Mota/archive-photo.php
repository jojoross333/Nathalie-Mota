<?php
get_header(); // Inclure le header

if (have_posts()) :
    echo '<h1>Mes Photos</h1>'; // Titre de la page

    while (have_posts()) : the_post();
        // Afficher un extrait de chaque photo
        ?>
        <div class="photo-item">
            <h2><?php the_title(); ?></h2>
            <a href="<?php the_permalink(); ?>">
                <?php if (has_post_thumbnail()) {
                    the_post_thumbnail(); // Afficher la miniature
                } ?>
            </a>
        </div>
        <?php
    endwhile;

    // Pagination si nécessaire
    the_posts_pagination();
else :
    echo '<p>Aucune photo trouvée.</p>';
endif;

get_footer(); // Inclure le footer
?>