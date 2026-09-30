<?php


add_theme_support( 'post-thumbnails' ); 

//add_image_size( string $name, int $width, int $height, bool|array $crop = false )
add_image_size( 'recipe_thumb', 300, 225, true);


if( function_exists('acf_add_options_page') ) {
  
  acf_add_options_page(array(
    'page_title'  => 'Windset Theme Settings',
    'menu_title'  => 'Theme Settings',
    'menu_slug'   => 'theme-general-settings',
    'capability'  => 'edit_posts',
    'redirect'    => false
  ));
  
}


if( !function_exists('windset_custom_page_navigation') ) {
    function windset_custom_page_navigation() {
        register_nav_menu('page-navigation',__( 'Page Navigation' ));
    }
}
add_action( 'init', 'windset_custom_page_navigation' );

?>
