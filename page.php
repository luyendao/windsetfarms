<?php get_header(); ?>

<?php

  if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

  <?php

    cc_do_title_container();

  ?>
  <div class="section section-content">
    <div class="row">
      <div class="col s12 m12 l12">
        <?php the_content(); ?>
      </div>
    </div>
  </div>
  <?php
    endwhile;
    endif;
  ?>

<?php get_footer(); ?>
