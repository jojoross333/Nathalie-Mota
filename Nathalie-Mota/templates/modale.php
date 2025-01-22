<!-- Modale de contact -->
<div id="modale" class="popup-overlay">
    <div class="popup-contact">
        <div class="popup-header">
            <!-- Bouton de fermeture -->
            <button class="close-btn" aria-label="Fermer la modale">×</button>

            <img class="popup-img" src="<?php echo get_theme_file_uri("/assets/img/contact-header.png"); ?>" alt="Contact Image">
        </div>
        <div class="popup-details">
            <!-- Formulaire de contact -->
            <?php echo do_shortcode('[contact-form-7 id="dc1a1a4" title="Modal contact"]'); ?>
        </div>
    </div>
</div>
