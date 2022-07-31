<?php get_header(); ?>

<?php

  if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

  <?php


   if (is_front_page()) {
   	echo do_shortcode('[elementor-template id="22731"]');
   } else {
   cc_do_title_container();
   } 

    //extract( $fields );
    $sustainable = isset( $fields['sustainable'] ) ? $fields['sustainable'] : false ;
    $giving = isset( $fields['giving'] ) ? $fields['giving'] : false ;

    cc_do_product_grid();

    cc_do_section_recipe();

    if ( $sustainable )
      cc_magazine_block_twin( $sustainable );

    if ( $giving )
      cc_magazine_block_cover( $giving );


  ?>
  <?php
    endwhile;
    endif;
  ?>

<?php



?>
<?php get_footer(); ?>
