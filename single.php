<?php get_header(); ?>

<?php

  if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

  <?php

    cc_do_title_container();

  ?>
  <div class="section full-width section-anchors no-margin">
    <div class="section-inner">
      <div class="row">
        <div class="col s9 m9 l9">

          <?php get_category_label(); ?>
          <div class="inline-block post-meta uppercase">
            <strong>POSTED BY:</strong>
            <span class="author">
              <?php echo get_the_author_meta( 'nickname' ); ?>
            </span>
          </div>

        </div>
        <div class="col s3 m3 l3 uppercase share-buttons">
          <strong>SHARE ON:</strong>
          <?php 
            $share_text = urlencode ( get_the_title() );
          ?>
          <a href="https://twitter.com/intent/tweet?text=<?php echo $share_text;?>" target="_blank">
            <i class="fa fa-twitter"></i>
          </a>
          <a href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>" target="_blank">
            <i class="fa fa-facebook"></i>
          </a>
        </div>
      </div>
    </div>
  </div>

  <div class="section section-content">
    <div class="row">
      <div class="col s12 m12 l12">
        <?php the_content(); ?>
      </div>
    </div>

        <?php get_author_block(); ?>

  </div>


  <?php
    endwhile;
    endif;
  ?>

<?php get_footer(); ?>
