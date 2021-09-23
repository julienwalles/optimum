<!DOCTYPE html>

<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>

    <header class="header">
        <a href="<?php echo home_url( '/' ); ?>">
            <img src="<?php echo get_template_directory_uri(); ?>/images/logo.png" alt="Logo" style="width:100%;">
        </a>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <div class="collapse navbar-collapse" id="navbarSupportedContent">     
                        <?php 
                        wp_nav_menu(array( 
                        'theme_location' => 'header', 
                        'depth'          => 2,
                        'container'      => 'false', // afin d'éviter d'avoir une div autour 
                        'menu_class'     => 'navtop navbar mr-auto', // ma classe personnalisée 
                        'fallback_cb'    => 'wp_bootstrap_navwalker::fallback',
                        'walker'         => new wp_bootstrap_navwalker() )); 
                    ?>
                </div>
            </div>
        </nav>

    </header>