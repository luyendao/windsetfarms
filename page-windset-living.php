<?php /* custom archive page */ ?>
<?php   //redirect product categories to page by slug, our-produce
redirect_product_cat_archive_to_page_by_slug( 'our-produce' );
?>
<?php get_header(); ?>

<?php


$title = 'Windset Living';

cc_do_title_container( $title );

?>
<?php
    get_page_tabs();
?>
<div class="section section-grid">
  <div class="row">
    <?php

    global $wp_query;


    $current_page = get_query_var('page', false);
    $current_paged = get_query_var('paged', false);
    $default_post_types = array( 'post', 'recipes', 'news' );

    $q_vars = isset ( $wp_query->query ) ? $wp_query->query : false ;

    if ( !$current_page ) {
      $current_page = $current_paged;
    }

    if ( !$current_paged ) {
      $current_page = $current_page;
    }

    if ( !$current_page ) {
      $current_page = 1;
    }

    $args = array(
        'page' => $current_page,
        'paged' => $current_page,
        'posts_per_page' => '12',
        'category__in' => $cat,
        'post_type' => $default_post_types,
    );

    $query = new WP_Query( $args );

    $query_posts = isset( $query->posts ) ? $query->posts : false;

    get_posts_grid( $query_posts, true, $current_page );


    /*
     *
     * Because of the two extra social feeder( tweeter and instagram ), the last grid is empty. Fill it out by grabbing one more post from database.
     *
     */
    if( $current_page <= 1 ){

        $additional_args = array(
            'offset' => '12',
            'posts_per_page' => '1',
            'category__in' => $cat,
            'post_type' => $default_post_types,
        );

        $additional_query = new WP_Query( $additional_args );

        $additional_query_posts = isset( $additional_query->posts ) ? $additional_query->posts : false;

        get_posts_grid( $additional_query_posts );
    }

    ?>
</div>

<div class="section section-pagination center">


  <?php

  $max_page = $query->max_num_pages;

  $base = $_SERVER['REQUEST_URI'];
  $base = explode( 'page', $base );
  $base = $base['0'];
  $base = explode( '?', $base );
  $base = $base['0'];
  $base = explode( '/', $base );
  $base = '/'.$base['1'];

//  print_r($base);

  $args = array(
      'base'               => $base . '%_%',
      'format'             => '/%#%',
      'total'              => $max_page,
      'current'            => $current_page,
      'show_all'           => false,
      'end_size'           => 1,
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