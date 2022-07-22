<?php

//set global variables

add_action( 'the_post', 'set_global_acf_fields' );

$fields = false;

function set_global_acf_fields( $fields ) {

  global $fields;

  if ( is_singular() || is_front_page() ) {

    if ( function_exists( 'get_fields' ) )
      $fields = get_fields( get_the_ID() );

  }

  return $fields;

}

function is_dev() {

  $site_url = site_url();
  $is_dev = false;

  if ( strpos( $site_url, 'localhost') ) {
    $is_dev = true;
  }
  return $is_dev;
}

function cc_get_field( $field_name = false ) {

  global $fields;

  $data = array();

  if ( $fields && $field_name ) {

    $data = ( isset( $fields[ $field_name ] ) ) ?
      $fields[ $field_name ] : false;

  }

  return $data;

}


function cc_get_featured_img( $args = null ) {

  $html = '';

  if ( $args ) {

    $post_id = isset( $args['post_id'] ) ?  $args['post_id'] : get_the_ID();
    $title = isset( $args['title'] ) ?  $args['title'] : false;
    $size = isset( $args['size'] ) ?  $args['size'] : 'medium';
    $return = isset( $args['return'] ) ?  $args['return'] : 'html';

    //get the image src
    $feat_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), $size );

    //set img variables
    $url = isset( $feat_image['0'] ) ? $feat_image['0'] : false;
    $width = isset( $feat_image['1'] ) ? $feat_image['1'] : false;
    $height = isset( $feat_image['2'] ) ? $feat_image['2'] : false;

    if ( $url ) {
      $html .= '
        <img class="responsive-img" width="' . $width . '" height="' . $height . '" src="' . $url .'" title="' . $title .'"
        />
      ';
    }

    if ( $return == 'url' )
      $html = $url;

  }

  return $html;
}

function cc_get_recipe_thumb( $args ) {

  $html = '';

  if ( $args ) {

    $post_id = isset( $args['post_id'] ) ?  $args['post_id'] : get_the_ID();
    $title = isset( $args['title'] ) ?  $args['title'] : false;
    $size = isset( $args['size'] ) ?  $args['size'] : 'medium';
    $return = isset( $args['return'] ) ?  $args['return'] : 'html';


    //get the image src
    $recipe_thumb = get_field('recipe_thumb', $post_id);

    //set img variables
    $url = isset( $recipe_thumb['url'] ) ? $recipe_thumb['url'] : false;
    $width = isset( $recipe_thumb['width'] ) ? $recipe_thumb['width'] : false;
    $height = isset( $recipe_thumb['height'] ) ? $recipe_thumb['height'] : false;

    if ( $url ) {
      $html .= '
        <img class="responsive-img" width="' . $width . '" height="' . $height . '" src="' . $url .'" title="' . $title .'"
        />';
    }

    if ( $return == 'url' )
      $html = $url;

  }

  return $html;
}


function cc_get_resized_img( $args = null ) {

  $html = '';

  if ( $args ) {

    $post_id = isset( $args['post_id'] ) ? $args['post_id'] : get_the_ID();
    $url = isset( $args['url'] ) ? $args['url'] : false;
    $title = isset( $args['title'] ) ?  $args['title'] : false;
    $width =isset( $args['size']['0'] ) ?  $args['size']['0']  : 600;
    $height =isset( $args['size']['1'] ) ?  $args['size']['1']  : 999;
    $crop = isset( $args['crop'] ) ?  $args['crop'] : false;
    $return = isset( $args['return'] ) ?  $args['return'] : 'html';


    if ( $url ) {

      $url_resized = aq_resize( $url, $width, $height, $crop , $single = true, $upscale = true );

      if ( $url_resized ) {

        $html .= '
          <img class="responsive-img" width="' . $width . '" height="' . $height . '" src="' . $url_resized .'" title="' . $title .'"
          />';
      }

      if ( $return == 'url' )
        $html = $url_resized;

    }

  }

  return $html;
}

function cc_mime_types($mimes) {
  $mimes['svg'] = 'image/svg+xml';
  return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');


?>
