<?php /* custom archive page */ ?>
<?php   //redirect product categories to page by slug, our-produce
  redirect_product_cat_archive_to_page_by_slug( 'our-produce' );
?>
<?php get_header(); ?>

  <?php


    $title = 'Windset Living';
    if( is_home() ){
        $title = 'Recipes';
    }
    cc_do_title_container( $title );

?>
<?php
    get_page_tabs();
    $current_category = $wp_query->get_queried_object();
        if( $current_category->slug != 'news' ){ 
?>
    <div class="section section-anchors full-width no-margin">
      <div class="section-inner">
        <?php get_archive_filters(); ?>
      </div>
    </div>
<?php
    }
?>

    <div class="section section-grid">
      <div class="row">
        <?php

          global $wp_query;

          $current_page = get_query_var('page', false);
          $current_paged = get_query_var('paged', false);
          $default_post_types = array( 'post', 'recipes' );

          $q_vars = isset ( $wp_query->query ) ? $wp_query->query : false ;
          $q_args = array();

          //if this is a search, add page post type
          if ( isset( $q_vars['s'] ) ) {
            $default_post_types = array( 'post', 'page', 'products', 'recipes' );
          }
          if( is_home() ){
            $default_post_types = array( 'recipes' ); 
          }

          foreach ( $q_vars as $key => $var ) {
            $q_args[$key] = $var;
          }

          if ( !$current_page ) {
            $current_page = $current_paged;
          }

          if ( !$current_paged ) {
            $current_page = $current_page;
          }

          if ( !$current_page ) {
            $current_page = 1;
          }

          if ( is_page() )
            $cat = '';

          $args = array(
            'page' => $current_page,
            'paged' => $current_page,
            'posts_per_page' => '12',
            'category__in' => $cat,
            'post_type' => $default_post_types,
          );

          $args = array_merge( $args, $q_args );

          $query = new WP_Query( $args );

          $query_posts = isset( $query->posts ) ? $query->posts : false;

          get_posts_grid( $query_posts );
        ?>
      </div>
    </div>

    <div class="section section-pagination center">


    <?php

      $max_page = $query->max_num_pages;

      $base = $_SERVER['REQUEST_URI'];
      $base = explode( 'page', $base );
      $base = $base['0'];
      $base = explode( '?', $base );
      $base = $base['0'];

      $args = array(
        'base'               => $base . '%_%',
        'format'             => 'page/%#%',
        'total'              => $max_page,
        'current'            => $current_page,
        'show_all'           => false,
        'end_size'           => 3,
        'mid_size'           => 2,
        'prev_next'          => true,
        'prev_text'          => __('« Previous'),
        'next_text'          => __('Next »'),
        'type'               => 'plain',
        'add_args'           => false,
        'add_fragment'       => '',
        'before_page_number' => '',
        'after_page_number'  => ''
      ); ?>

      <?php echo paginate_links( $args ); ?>

    </div>
<?php get_footer(); ?>
