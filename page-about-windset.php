<?php /* Template Name: Our Story */ ?>
<?php get_header(); ?>

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

  <?php

    cc_do_title_container();

    global $fields;

    $intro_img = isset( $fields['intro_image']['url'] ) ? $fields['intro_image']['url'] : false;
    $intro_img = cc_get_resized_img( array(
      'url' => $intro_img,
      'size' => array( '700', 999 ),
    ));
  ?>
  <div class="section section-about">
    <div class="row">
      <div class="col s12 m7 l7 drop-caps font-serif">
        <?php the_content(); ?>
      </div>
      <div class="col s12 m5 l5 intro-bg">
        <?php echo $intro_img; ?>
      </div>
    </div>
  </div>


<?php
    $facilities_block_2_col = isset( $fields['facilities_block_2_col'] ) ? $fields['facilities_block_2_col'] : false;

    if ( isset( $facilities_block_2_col['0'] ) ) {
      get_facilities_section( $facilities_block_2_col['0']);
    }
?>

  <div class="section section-logos">
    <?php 
        $logos = isset( $fields['logos'] ) ? $fields['logos'] : false;
        if( $logos ) :
    ?>
        <ul class="logos">
            <?php foreach( $logos as $logo ) : ?>
                <li class="logo"><img src="<?php echo $logo['logo']['url']; ?>"></li>
            <?php endforeach; ?>
        </ul>
    <?php
        endif;
    ?>
  </div>


  <?php

    $slides = isset( $fields['slides'] ) ? $fields['slides'] : false;

    if ( $slides ) {
      get_section_slides( $slides );
    }

    $block_2_col = isset( $fields['block_2_col'] ) ? $fields['block_2_col'] : false;

    if ( isset( $block_2_col['0'] ) ) {
      get_section_col_2( $block_2_col['0'] );
    }


    $sponsors = isset( $fields['sponsors'] ) ? $fields['sponsors'] : false;

    if ( isset( $sponsors['0'] ) ) {
      get_section_sponsors( $sponsors['0'] );
    }

//    get_section_news();

    $media = isset( $fields['media'] ) ? $fields['media'] : false;

    get_section_col_1( $media['0'] );

  ?>


<?php  endwhile;  endif; ?>

<?php get_footer(); ?>
