<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title>Nathalie Mota</title>
    
    <?php wp_head(); ?>
</head>

    <header>
        <div class="header_content">
            <div class="logo">
                <a href="<?php echo home_url( '/' ); ?>" aria-label="page d'accueil">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/logo.png" alt="Logo">
                </a>
            </div>
        </div>
            
        <nav class="main-nav">
            <?php wp_nav_menu(array('theme_location' => 'header')); ?>
        </nav>

        <div class="burger-menu" id="burger-menu">
            <span class="line"></span>
            <span class="line"></span>
            <span class="line"></span>
        </div>
    </header>
       
