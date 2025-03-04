<!-- Modale de contact -->
<div id="modale" class="popup-overlay">
    <div class="popup-contact">
        <div class="popup-header">
            <img class="popup-img" src="<?php echo get_theme_file_uri("/assets/img/contact-header.png"); ?>" alt="Contact Image">
        </div>
        <div class="popup-details">
            <!-- Formulaire de contact -->
            <?php echo do_shortcode('[contact-form-7 id="dc1a1a4" title="Modal contact"]'); ?>
            
            <!-- Champ caché pour la référence -->
            <input type="hidden" name="your-ref" id="your-ref">
        </div>
    </div>
</div>
