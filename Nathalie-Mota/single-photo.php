<?php get_header(); ?>

<?php
// Récupère l'image de la photo
$photo = get_the_post_thumbnail(null, 'full');
// Récupère le titre de la photo
$title = get_the_title();
// Récupère la référence de la photo
$reference = get_field('reference');
// Récupère le champs personnalisé "type"
$type = get_field('type');
// Récupère la taxonomie "Catégorie"
$categories = get_the_terms( $post->ID, 'categorie' );
// Récupère la taxonomie "Format"
$formats = get_the_terms( $post->ID, 'format' );
?>

<section class="page-photo">
    <div class="photo-content">
        <div class="bloc-photo">
            <?php echo $photo; ?> <!-- la photo -->
        </div>

        <div class="infos-bloc">  <!-- bloc des infos à récupérer -->
            <h2 class="title-infos"><?php echo esc_html($title); ?></h2>
            <p class="txt-infos">Référence : <?php echo $reference; ?></p>
            <p class="txt-infos">Type : <?php echo $type; ?></p>
            <p class="txt-infos">Année : <?php echo get_the_date(); ?></p>
            <p class="txt-infos">Catégorie : <?php foreach( $categories as $category ) {
                echo $category->name;
                } ?>
            </p>
            <p class="txt-infos">Format : <?php foreach( $formats as $format ) {
                echo $format->name;
                } ?>
            </p>    
        </div>
    </div>

    <!-- Bloc contact -->
    <div class="contact-content">
        <div class="contact-ref">
            <p class="interesse">Cette photo vous intéresse ?</p>
            <button id="contact-btn" data-ref="<?php echo $reference; ?>">Contact</button>
        </div>
    </div>

    <!-- Section des photos apparentées -->
    <div class="related-photos">
        <h3>Vous aimerez aussi</h3>
        <div class="related-photos-list">
            <?php
            // Récupérer la première catégorie de la photo
            $category_ids = wp_list_pluck($categories, 'term_id');
            
            // Effectuer une requête WP_Query pour récupérer les photos de la même catégorie
            $related_query = new WP_Query(array(
                'post_type' => 'photo',
                'posts_per_page' => 2, // Limiter à 2 photos seulement
                'post__not_in' => array(get_the_ID()), // Exclure la photo actuelle
                'tax_query' => array(
                    array(
                        'taxonomy' => 'categorie',
                        'field' => 'id',
                        'terms' => $category_ids,
                        'operator' => 'IN',
                    )
                ),
            ));

            // Si des photos sont trouvées
            if ($related_query->have_posts()) :
                while ($related_query->have_posts()) : $related_query->the_post();
                    ?>
                    <div class="related-photo-item">
                        <a href="<?php the_permalink(); ?>">
                            <?php if (has_post_thumbnail()) { 
                                the_post_thumbnail('full');
                            } ?>
                        </a>
                    </div>
                    <?php
                endwhile;
            else :
                echo '<p>Aucune photo apparentée trouvée.</p>';
            endif;

            // Réinitialiser les données de la requête
            wp_reset_postdata();
            ?>
        </div>
    </div>

</section>

<?php get_footer(); ?>
