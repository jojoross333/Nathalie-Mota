<div class="photo-item" data-photo-id="<?php the_ID(); ?>">
    <a href="<?php the_permalink(); ?>">
        <?php if (has_post_thumbnail()) { 
            the_post_thumbnail('medium');
        } ?>
    </a>
</div>