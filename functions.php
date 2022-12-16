<?php

/**
 * Proper way to enqueue scripts and styles
 */
function windset_scripts() {
  wp_enqueue_style( 'materialize', get_template_directory_uri() . '/css/materialize.min.css');
  wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/css/font-awesome.min.css');
  wp_enqueue_style( 'style', get_template_directory_uri() . '/css/main.css', array(), '4.9.61214311');
  wp_enqueue_script( 'materialize', get_template_directory_uri() . '/js/materialize.min.js', array('jquery'), '1.0.0', true );
  wp_enqueue_script( 'slick', get_template_directory_uri() . '/js/slick.min.js', array('jquery'), '1.0.0', true );
  wp_enqueue_script( 'video', get_template_directory_uri() . '/js/jquery.youtubebackground.js', array('jquery'), '1.0.0', true );
  wp_enqueue_script( 'initial', get_template_directory_uri() . '/js/init.js', array('jquery'), '1.0.0', true );
  wp_enqueue_script( 'social', 'https://static.addtoany.com/menu/page.js', array('jquery'), '1.0.0', true );
  wp_enqueue_script( 'scripts', get_template_directory_uri() . '/js/scripts.js', array('jquery'), '1.0.0', true );

}

add_action( 'wp_enqueue_scripts', 'windset_scripts' );



//Register Menu

add_action( 'after_setup_theme', 'register_my_menu' );
function register_my_menu() {
  register_nav_menu( 'main-menu', __( 'Main Menu', 'kryan' ) );
}




//include libraries
require_once('lib/aq_resizer.php');
require_once('lib/cpt.php');
require_once('lib/theme-support.php');
require_once('lib/theme-functions.php');
require_once('lib/theme-widgets.php');
require_once('lib/page-functions.php');
require_once('lib/single-functions.php');
require_once('lib/search-functions.php');
require_once('lib/archive-functions.php');

//sales tools
require_once('lib/sales/init.php');

//include front-end templates
require_once('templates/parts-title.php');
require_once('templates/parts-front-page.php');
require_once('templates/parts-images.php');
require_once('templates/parts-recipe.php');
require_once('templates/parts-find-stores.php');

// require_once('templates/parts-recipe.php');
