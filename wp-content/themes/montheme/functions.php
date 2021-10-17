<?php

// Ajouter la prise en charge des images mises en avant
add_theme_support( 'post-thumbnails' );

// Ajouter automatiquement le titre du site dans l'en-tête du site
add_theme_support( 'title-tag' );
// add_theme_support( 'menus' );

// // ajouter les feuilles de style et cdn bootstrap 4.6
// function optimum_add_style() {

//         wp_enqueue_style('style', get_stylesheet_uri() );
      
//         wp_enqueue_style( 'bootstrapcss','https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css', false, null );

//         wp_enqueue_script( 'bootstapjs', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js',
//     array('jquery'), false, true);
// }

// add_action ("wp_enqueue_scripts", 'optimum_add_style');

/***********************************************************************************/

function optimum_add_style() 
{
    wp_enqueue_style('style', get_stylesheet_uri() );
    wp_enqueue_style( 'bootstrapcss','https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css', false, null );
    wp_enqueue_script( 'bootstapjs', 'https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js',
array('jquery'), false, true);
}
add_action ("wp_enqueue_scripts", 'optimum_add_style');

/**************************************************************************************/

// ajouter un menu 
function add_menu() 
{
    register_nav_menu('header', __('en-tête menu'));
}
add_action( 'init', 'add_menu' );


/*************************************************************************************/

function montheme_menu_class($classes) 
{
    $classes[] = 'nav-item';
    return $classes;
}
add_filter('nav_menu_css_class', 'montheme_menu_class');


/**************************************************************************************/

function montheme_menu_link_class($atts) 
{
    $atts[] = 'nav-link';
    return $atts;
}
add_filter('nav_menu_css_class', 'montheme_menu_link_class');


/***************************************************************************************/

function montheme_sidebar() 
{
    register_sidebar([
        'id' => 'homepage',
        'name' => 'Sidebar Accueil'
    ]);
}
add_action ('init', 'montheme_sidebar');

/*****************************************************************************************/

function  register_navwalker() 
{   
    require_once  get_template_directory(). '/class-wp-bootstrap-navwalker.php' ;    
}
add_action ( 'after_setup_theme' , 'register_navwalker' );


/********************************************************************************************/
