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

// Récupère le post précédent
$previous_post = get_previous_post();
if ($previous_post) {
    $previous_id = $previous_post->ID;
    $previous_img = get_the_post_thumbnail_url($previous_post, 'thumbnail');
    $previous_link = get_permalink($previous_post);
} else {
    $previous_post = get_posts(['numberposts' => 1, 'post_type' => 'photo', 'orderby' => 'date', 'order' => 'DESC'])[0];
    $previous_id = $previous_post->ID;
    $previous_img = get_the_post_thumbnail_url($previous_post, 'thumbnail');
    $previous_link = get_permalink($previous_post);
}

// Récupère le post suivant
$next_post = get_next_post();
if ($next_post) {
    $next_id = $next_post->ID;
    $next_img = get_the_post_thumbnail_url($next_post, 'thumbnail');
    $next_link = get_permalink($next_post);
} else {
    $next_post = get_posts(['numberposts' => 1, 'post_type' => 'photo', 'orderby' => 'date', 'order' => 'ASC'])[0];
    $next_id = $next_post->ID;
    $next_img = get_the_post_thumbnail_url($next_post, 'thumbnail');
    $next_link = get_permalink($next_post);
}
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
            <button id="ref-btn" data-ref="<?php echo $reference; ?>">Contact</button>
        </div>

        <!-- Section des miniatures et flèches -->
        <div class="navigationPhoto">
            <a href="<?php echo get_permalink($post->ID); ?>" class="miniature-link" id="miniaturePhoto"></a>
            <div class="arrowNav">
                <?php if (!empty($previous_id)) : ?>
                    <img class="arrow arrow-left" src="<?php echo get_template_directory_uri() . '/assets/img/left_arrow.png'; ?>" alt="Photo précédente" data-thumbnail-url="<?php echo $previous_img; ?>" data-target-url="<?php echo esc_url($previous_link); ?>">
                <?php endif; ?>

                <?php if (!empty($next_id)) : ?>
                    <img class="arrow arrow-right" src="<?php echo get_template_directory_uri() . '/assets/img/right_arrow.png'; ?>" alt="Photo suivante" data-thumbnail-url="<?php echo $next_img; ?>" data-target-url="<?php echo esc_url($next_link); ?>">
                <?php endif; ?>
            </div>
        </div>
    </div>


    <!-- Section des photos apparentées -->
    <div class="related-photos">
        <h3>Vous aimerez aussi</h3>
        <div class="related-photos-list">
            <?php
            // Récupérer la première catégorie de la photo
            $category_ids = wp_list_pluck($categories, 'term_id');
            
            // Inclure le fichier load.php pour afficher les photos apparentées
            // Ajouter un argument pour récupérer uniquement les photos de la même catégorie et exclure la photo actuelle
            $args = array(
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
            );
            
            // Appeler la fonction pour afficher les photos apparentées en passant les arguments
            afficher_photos_catalogue($args); // load pour effet survol et appliquer a tous 

            ?>
        </div>
    </div>


</section>

<?php get_footer(); ?>
