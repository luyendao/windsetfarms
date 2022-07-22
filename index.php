<?php get_header(); ?>

<?php

  //redirect product categories to page by slug, our-produce
  redirect_product_cat_archive_to_page_by_slug( 'our-produce' );

  if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

  <?php

    cc_do_title_container();

  ?>
  <?php
    endwhile;
    endif;
  ?>

<?php get_footer(); ?>
