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
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    
    <?php wp_head(); ?>
</head>
<body>
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

    <main>
       
