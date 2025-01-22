<?php
get_header(); // Inclure le header

if (have_posts()) :
    while (have_posts()) : the_post();
        ?>
        <div class="single-photo">
            <h1><?php the_title(); ?></h1>
            <?php
            if (has_post_thumbnail()) {
                the_post_thumbnail('large'); // Afficher la miniature en grande taille
            }
            ?>
            <div class="photo-content">
                <?php the_content(); // Afficher le contenu de la photo ?>
            </div>
        </div>
        <?php
    endwhile; 
else :
    echo '<p>Aucune photo trouvé.</p>';
endif;

get_footer(); // Inclure le footer
?>