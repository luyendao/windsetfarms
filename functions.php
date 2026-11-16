<?php

/**
 * Proper way to enqueue scripts and styles
 */
function windset_scripts() {
  wp_enqueue_style( 'materialize', get_template_directory_uri() . '/css/materialize.min.css');
  wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/css/font-awesome.min.css');
  wp_enqueue_style( 'style', get_template_directory_uri() . '/css/main.css', array(), '1.12331139');
  //wp_enqueue_style( 'typekit', 'https://use.typekit.net/ifl3ypf.css', array(), '1.0');
  wp_enqueue_script( 'materialize', get_template_directory_uri() . '/js/materialize.min.js', array('jquery'), '1.0.0', true );
  wp_enqueue_script( 'slick', get_template_directory_uri() . '/js/slick.min.js', array('jquery'), '1.0.0', true );
  wp_enqueue_script( 'video', get_template_directory_uri() . '/js/jquery.youtubebackground.js', array('jquery'), '1.0.0', true );
  wp_enqueue_script( 'initial', get_template_directory_uri() . '/js/init.js', array('jquery'), '1.0.0', true );
  wp_enqueue_script( 'social', 'https://static.addtoany.com/menu/page.js', array('jquery'), '1.0.0', true );
  wp_enqueue_script( 'scripts', get_template_directory_uri() . '/js/scripts.js', array('jquery'), '1.0.0', true );

  // Festiva landing page (page-festiva-cherry-tomato-medley.php): own stylesheet + Typekit
  // (Sofia Pro), and none of the theme's header/menu scripts – the page has no site header.
  if ( is_page( 'festiva-cherry-tomato-medley' ) ) {
    $fl_css = get_template_directory() . '/css/festiva-landing.css';
    wp_enqueue_style( 'typekit-sofia', 'https://use.typekit.net/ifl3ypf.css', array(), null );
    wp_enqueue_style( 'windset-festiva-landing', get_template_directory_uri() . '/css/festiva-landing.css', array( 'style' ), file_exists( $fl_css ) ? filemtime( $fl_css ) : null );
    foreach ( array( 'initial', 'scripts', 'video', 'slick', 'materialize' ) as $handle ) {
      wp_dequeue_script( $handle );
    }
  }

  // Product showcase layout (products with a Hero Background Image)
  if ( is_singular( 'products' ) && function_exists( 'get_field' ) && get_field( 'hero_background_image', get_queried_object_id() ) ) {
    $ps_css = get_template_directory() . '/css/product-showcase.css';
    $ps_js  = get_template_directory() . '/js/product-showcase.js';
    wp_enqueue_style( 'windset-product-showcase', get_template_directory_uri() . '/css/product-showcase.css', array( 'style' ), file_exists( $ps_css ) ? filemtime( $ps_css ) : null );
    wp_enqueue_script( 'windset-product-showcase', get_template_directory_uri() . '/js/product-showcase.js', array(), file_exists( $ps_js ) ? filemtime( $ps_js ) : null, true );
  }

  // New homepage styles (front page only), cache-busted by file modified time
  if ( is_front_page() ) {
    $home_css = get_template_directory() . '/css/home.css';
    wp_enqueue_style( 'windset-home', get_template_directory_uri() . '/css/home.css', array( 'style' ), file_exists( $home_css ) ? filemtime( $home_css ) : null );
    $home_js = get_template_directory() . '/js/home.js';
    wp_enqueue_script( 'windset-home', get_template_directory_uri() . '/js/home.js', array( 'jquery', 'slick' ), file_exists( $home_js ) ? filemtime( $home_js ) : null, true );
  }

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

add_filter( 'big_image_size_threshold', '__return_false' );

