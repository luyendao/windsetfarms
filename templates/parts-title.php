<?php

function cc_do_title_container( $title = null ) {

  global $fields;

  $heading_subtitle = isset( $fields['heading_subtitle'] ) ? $fields['heading_subtitle'] : false;
  $banner_title = isset( $fields['banner_title'] ) ? $fields['banner_title'] : false;
  $banner_subtitle = isset( $fields['banner_subtitle'] ) ? $fields['banner_subtitle'] : false;
  $background_video = isset( $fields['background_video'] ) ? $fields['background_video'] : false;

  $img = '';
  $h1_class = '';
  $do_not_translate = false;

  if ( is_front_page() )
    $h1_class = 'font-script';

  if ( !is_front_page() )
    $h1_class = 'font-script medium';

  if ( is_home() ) {

    $front_page = get_option( 'page_for_posts' );

    $thumb_id = get_post_thumbnail_id( $front_page );
    $thumb_url_array = wp_get_attachment_image_src($thumb_id, 'large', true);
    $img = $thumb_url_array[0];

  } else if ( has_post_thumbnail() ) {

    ob_start();
    the_post_thumbnail_url( 'large' );
    $img = ob_get_clean();

  } else {

    $front_page = get_option( 'page_on_front' );

    if ( is_home() )
      $front_page = get_option( 'page_for_posts' );

    $thumb_id = get_post_thumbnail_id( $front_page );
    $thumb_url_array = wp_get_attachment_image_src($thumb_id, 'large', true);
    $img = $thumb_url_array[0];

  }

  if ( is_singular() ) {
      $title = get_the_title();
      if( has_category('organics') || is_singular('recipes') ){
          $do_not_translate = true;
      }
      // For Roasted Tomato Soup post
      if( get_the_ID() === 721 ){
          $do_not_translate = false;
      }
  }

  if ( is_category() ) {
    $title = get_the_archive_title();

    $title = str_replace( 'Category:', '', $title );
    $title = str_replace( 'Recipe', 'Recipes', $title );

    // Should grab the news header image from front page, not the latest post's featured image
    $front_page = get_option( 'page_on_front' );
    $thumb_id = get_post_thumbnail_id( $front_page );
    $thumb_url_array = wp_get_attachment_image_src($thumb_id, 'large', true);
    $img = $thumb_url_array[0];

  }


  if ( $banner_title ) {
    $title = $banner_title;
  }

  if ( $banner_subtitle ) {
    $heading_subtitle = $banner_subtitle;
  }


  $title = str_replace( '®', '<sup class="tiny">®</sup>', $title );
  $title = str_replace( '&reg;', '<sup class="tiny">&reg;</sup>', $title );
  $title = str_replace( '™', '<sup class="tiny">™</sup>', $title );
  $title = str_replace( '&trade;', '<sup class="tiny">&trade;</sup>', $title );

  ?>

  <?php
    $video_id = get_video_id( $background_video );

    if ( $video_id ) {
      ?>
      <div class="bg-video hide">
        <div class="video" data-id="<?php echo $video_id; ?>">
        </div>
        <div class="btn-video-close">
          <i class="fa fa-close"></i>
        </div>
      </div>
      <?php
    }
  ?>
  
      <div class="full-width title-container <?php echo ( $do_not_translate ) ? 'dont-translate' : ''; ?>">


    <?php
      $is_overlay_disabled = get_field('disable_overlay', get_the_ID());
      $display_as_image_block = get_field( 'display_as_image_block', get_the_ID() );
      if( ! $is_overlay_disabled ){
    ?>
      <div class="overlay"></div>
    <?php
      }
    ?>

    <?php if( is_front_page() ) : ?>
        <div class="home-tagline"></div>
    <?php else : ?>
        <?php if( !$display_as_image_block ) : ?>
        <h1 class="<?php echo $h1_class; ?>"><?php echo $title;?></h1>
        <?php endif; ?> 
		  
	<?php endif ?>



 
    <?php if ( $heading_subtitle ) : ?>
      <div class="subtitle"><?php echo $heading_subtitle; ?></div>
    <?php endif; ?>

    <?php if ( $background_video ) : ?>
      <div class="video-controls center">
        <div class="btn-play">
          <div class="btn-icon">
            <i class="fa fa-play" aria-hidden="true"></i>
          </div>
          <div class="center btn-text">
            PLAY VIDEO
          </div>
        </div>
      </div>
    <?php endif; ?>
    <div class="bg" style="background-image: url(<?php echo $img;?>);" />
    </div>

  </div>
  <?php

}
