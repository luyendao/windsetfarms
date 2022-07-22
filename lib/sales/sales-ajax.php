<?php

add_action( 'admin_enqueue_scripts', 'admin_ajax_script' );

function admin_ajax_script($hook) {

  global $post;

  if ( $hook == 'post-new.php' || $hook == 'post.php' ) {
    if ( 'sales' === $post->post_type ) {           

      //wp_enqueue_style( 'sales-tool', get_template_directory_uri() . '/lib/sales/sales-admin.css' );
      //wp_enqueue_script( 'sales-tool', get_template_directory_uri() . '/lib/sales/sales-admin.js', array('jquery'), '1.0.0', false );      

      // in JavaScript, object properties are accessed as ajax_object.ajax_url, ajax_object.we_value
      //wp_localize_script( 'sales-tool', 'ajax_object',
        //array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) 
      //);

      add_ajax_nonce();

    }
  }
}

function add_ajax_nonce() {

  add_meta_box( 
    'sales_nonce', 'Sales Nonce', 'add_ajax_nonce_field', null, 'side', 'low', null 
  );

}

function add_ajax_nonce_field() {

  $sales_nonce = wp_create_nonce( 'get_data' );

  ?> 
  <input class="sales_nonce" type="hidden" value="<?php echo $sales_nonce; ?>" />
  <?php
}



add_action( 'wp_ajax_get_product_json', 'get_product_json' );

function get_product_json() {
  

  check_ajax_referer( 'get_data', 'secret' );

  $post_id = isset( $_POST['post_id'] ) ? sanitize_text_field( $_POST['post_id'] ) : false;
  $data_json = get_product_meta_from_db( $post_id );

  echo $data_json;
  
  wp_die();

}


function get_product_meta_from_db( $post_id = null ) {

  $data = array();
 

  if ( $post_id ) {

    $data = array(
      'post_id' => $post_id,
      'sizes' => get_field('product_sizes', $post_id),
    );

  }


  $data_json = json_encode( $data );

  return $data_json;
}
