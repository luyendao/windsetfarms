<?php get_header(); ?>

<?php

  if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

  <?php


/* ---- Legacy front page output – disabled while the new homepage is built ----
if (is_front_page()) {

	$value = get_field( "slideshow_shortcode");
	
	echo do_shortcode($value);
	//echo do_shortcode('[elementor-template id="31247"]');
   } else {
   cc_do_title_container();
   } 

   echo do_shortcode('[elementor-template id="36041"]');

    //extract( $fields );
    $sustainable = isset( $fields['sustainable'] ) ? $fields['sustainable'] : false ;
    $giving = isset( $fields['giving'] ) ? $fields['giving'] : false ;

    cc_do_product_grid();

    cc_do_section_recipe();

    if ( $sustainable )
      cc_magazine_block_twin( $sustainable );

    if ( $giving )
      cc_magazine_block_cover( $giving );
    ---- end legacy front page output ---- */

    // New homepage sections (templates/parts-front-page.php)
    cc_do_home_hero();
    cc_do_home_intro();
    cc_do_home_sustainability();
    cc_do_home_products();
    cc_do_home_slider();
    cc_do_home_recipes();
    cc_do_home_social();



  ?>
  <?php
    endwhile;
    endif;
  ?>

<?php



?>
<?php get_footer(); ?>
