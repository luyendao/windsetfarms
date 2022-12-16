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


    $intro_text = "Immerse yourself in Windset Living, where we discuss everything from the latest trends in agriculture, your favourite recipes, and our commitment to the communities we grow in! We invite you to read through our Windset Living posts or find us on social @windsetfarms. Follow along with Your Friends in Freshness<sup>®</sup>!";

    $intro_copy = sprintf('<div class="col s12 m12 l12 intro-text" style="font-size: 24px; padding: 0 60px 0 60px; text-align:center;"><p style="line-height: 1.3em;font-weight: 300;">%s</p></div>', $intro_text);


    $embed_social_combined_feed = '<div class="embedsocial-hashtag" data-ref="de0987c773b46253398a3479f34ff4002b348f65"></div> <script> (function(d, s, id) { var js; if (d.getElementById(id)) {return;} js = d.createElement(s); js.id = id; js.src = "https://embedsocial.com/cdn/ht.js"; d.getElementsByTagName("head")[0].appendChild(js); }(document, "script", "EmbedSocialHashtagScript")); </script>';

    echo $intro_copy;

    // Echo embed social widget on first page only
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;	
    
    if ( 1== $paged) {
	echo $embed_social_combined_feed;
    }


    get_posts_grid( $query_posts, true, $current_page );


    /*
     *
     * Because of the two extra social feeder( tweeter and instagram ), the last grid is empty. Fill it out by grabbing one more post from database.
     *
     */

/*
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
 */
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
