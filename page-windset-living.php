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
        'category__in' => '1',
        'post_type' => $default_post_types,
    );

    $query = new WP_Query( $args );

    $query_posts = isset( $query->posts ) ? $query->posts : false;


    $intro_text = get_field('intro_copy');

    $intro_copy = sprintf('<div class="col s12 m12 l12 des">%s</div>', $intro_text);

    $embed_social_combined_feed = '<div class="embedsocial-hashtag" data-ref="db1bf8dc01a304e4a682160fa8c7cc2a54b7c45c"></div> <script> (function(d, s, id) { var js; if (d.getElementById(id)) {return;} js = d.createElement(s); js.id = id; js.src = "https://embedsocial.com/cdn/ht.js"; d.getElementsByTagName("head")[0].appendChild(js); }(document, "script", "EmbedSocialHashtagScript"));</script>';

    echo $intro_copy;

    // Echo embed social widget on first page only
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;	
    

	  echo sprintf('<div id="social-media-feed" class="col s12 m12 l12" style="margin-top:45px;"><h5 class="center uppercase" style="font-weight:600; color: #000;">Windset Social</h5>%s</div>',$embed_social_combined_feed);

    ?>

	  </div> <!-- Close Row -->

    <div class="row" id="news-feed">
      <h5 class="center uppercase" style="font-weight:600; color: #000; margin-bottom:30px;">Windset News</h5>
  

    <?php 
      echo sprintf('<div>%s</div>', get_posts_grid( $query_posts, true, $current_page ));
    ?>
    </div>


  </div> <!-- Close Section -->

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

$big = 999999999; // need an unlikely integer
 
echo paginate_links( array(
    'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
    'format' => '?paged=%#%',
    'current' => max( 1, get_query_var('paged') ),
    'total' => $query->max_num_pages
) );

?>

</div>


<?php get_footer(); ?>
