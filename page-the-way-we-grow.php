<?php /* Template Name: The Way We Grow */ ?>
<?php get_header(); ?>

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

<?php

  cc_do_title_container();

  global $fields;

  $intro_img = isset( $fields['intro_image']['sizes']['medium_large'] ) ? $fields['intro_image']['sizes']['medium_large'] : false;
  $intro_width = isset( $fields['intro_image']['sizes']['medium_large-width'] ) ? $fields['intro_image']['sizes']['medium_large-width'] : false;
  $intro_height = isset( $fields['intro_image']['sizes']['medium_large-height'] ) ? $fields['intro_image']['sizes']['medium_large-height'] : false;
?>
<div class="section section-intro">
  <div class="row">
    <div class="col s12 m7 l6 intro-text">
      <?php the_content(); ?>
    </div>
    <div class="col s12 m5 l6">
      <div class="intro-img bleed-bottom">
        <img class="responsive-img bleed-bottom" width="<?php echo $intro_width; ?>" height="<?php echo $intro_height; ?>"
          title="introduction" src="<?php echo $intro_img; ?>" />
      </div>
    </div>
  </div>
</div>

<?php

  $our_greenhouses = isset( $fields['our_greenhouses'] ) ? $fields['our_greenhouses'] : false;
  $our_greenhouses = $our_greenhouses['0'];

  if ( $our_greenhouses ) {

    get_section_greenhouses( $our_greenhouses );

  }

  $initiatives = isset( $fields['initiatives'] ) ? $fields['initiatives'] : false;
  $initiatives = $initiatives['0'];

  if ( $initiatives ) {

    get_section_initiatives( $initiatives );

  }

  $food_safety = isset( $fields['food_safety'] ) ? $fields['food_safety'] : false;
  $food_safety = $food_safety['0'];

  if ( $initiatives && $food_safety ) {

    get_section_divider();

  }

  if ( $food_safety ) {

    get_section_col_2( $food_safety );

  }


  $pest = isset( $fields['pest_management'] ) ? $fields['pest_management'] : false;
  $pest = $pest['0'];

  if ( $pest ) {

    get_section_pest( $pest );

  }

  $storage = isset( $fields['storage'] ) ? $fields['storage'] : false;
  $storage = $storage['0'];

  if ( $storage ) {

    get_section_col_1( $storage );

  }


  $packaging = isset( $fields['packaging'] ) ? $fields['packaging'] : false;
  $packaging = $packaging['0'];

  if ( $packaging ) {

    get_section_packaging( $packaging );

  }



?>
<?php

  endwhile;
  endif;

  //print_r( $fields );
?>
<?php



?>
<?php get_footer(); ?>
