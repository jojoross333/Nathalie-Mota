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

        <div class="infos-bloc">  <!-- bloc des infos a récupérer -->
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
        <div class="contact-content">
            <div class="contact-ref">
                <p class="interesse">Cette photo vous intéresse ?</p>
                <button id="contact-btn" data-ref="<?php echo $reference; ?>">Contact</button>
            </div>
        </div>

</section>

<?php get_footer(); ?>
