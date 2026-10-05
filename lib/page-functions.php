<?php


function get_section_slides( $slides ) {

  if ( $slides ) {

    ?>
    <div class="section full-width bg-red section-slides">
      <div class="section-inner">
        <div class="slick-slider fade">
          <?php
            foreach ( $slides as $key => $slide ) {

              $img = isset( $slide['img']['sizes']['medium_large'] ) ? $slide['img']['sizes']['medium_large'] : false;
              $img_w = isset( $slide['img']['sizes']['medium_large-width'] ) ? $slide['img']['sizes']['medium_large-width'] : false;
              $img_h = isset( $slide['img']['sizes']['medium_large-height'] ) ? $slide['img']['sizes']['medium_large-height'] : false;
              $title = isset( $slide['title'] ) ? $slide['title'] : false;
              $subtitle = isset( $slide['subtitle'] ) ? $slide['subtitle'] : false;
              $content = isset( $slide['content'] ) ? $slide['content'] : false;
              $learn_more_link = isset( $slide['learn_more_link'] ) ? $slide['learn_more_link'] : false;

              ?>
              <div class="slick-slide">
                <div class="row">
                  <div class="col s12 m7 l5 right">
                    <div class="content">
                      <h3 class="font-script white-text"><?php echo $title; ?></h3>
                      <h4 class="white-text"><?php echo $subtitle; ?></h4>
                      <div class="des white-text">
                        <?php echo $content; ?>
                      </div>
                    </div>
                  </div>
                  <div class="col s12 m5 l7">
                    <div class="slide-img">
                      <img class="responsive-img img-shadow" width="<?php echo $img_w; ?>" height="<?php echo $img_h; ?>" title="<?php echo $title; ?>"
                        src="<?php echo $img; ?>" />
                    </div>
                  </div>
                </div>
              </div>
              <?php
              }
            ?>
          </div>
        </div>
      </div>
    </div>


    <?php
  }

}


function get_section_greenhouses( $our_greenhouses  = null ) {
  if ( $our_greenhouses ) {

    $bg = isset( $our_greenhouses['img']['sizes']['large'] ) ? $our_greenhouses['img']['sizes']['large'] : false;
    $title = isset( $our_greenhouses['title'] ) ? $our_greenhouses['title'] : false;
    $content = isset( $our_greenhouses['content'] ) ? $our_greenhouses['content'] : false;
    ?>
    <div class="section full-width section-greenhouses white-text">
      <div class="section-bg" style="background-image: url('<?php echo $bg; ?>');">
      </div>
      <div class="section-inner">
        <div class="row">
          <div class="col s10 m8 l8 content">
            <h3 class="white-text font-script"><?php echo $title; ?></h3>
            <?php echo $content; ?>
          </div>
        </div>
      </div>
    </div>

    <?php
  }
}

function get_section_initiatives( $initiatives = null ) {

  if ( $initiatives ) {

    $title = isset( $initiatives['title'] ) ? $initiatives['title'] : false;
    $columns = isset( $initiatives['columns'] ) ? $initiatives['columns'] : false;
    $title_2 = isset( $initiatives['title_2'] ) ? $initiatives['title_2'] : false;
    $content_2 = isset( $initiatives['content_2'] ) ? $initiatives['content_2'] : false;
    ?>
    <div class="section section-initiatives">
      <div class="row">
        <div class="col s12 m12 l12 center">
          <h3 class="font-script red-text">
            <?php echo $title; ?>
          </h3>
          <br/>
        </div>
        <?php
          $num = 0;
          if ( $columns ) {
            foreach ( $columns as $key => $data ) {

              $icon = isset( $data['icon'] ) ? $data['icon'] : false;
              $title = isset( $data['title'] ) ? $data['title'] : false;
              $content = isset( $data['content'] ) ? $data['content'] : false;

              ?>
              <div class="col s12 m4 l4">
                <div class="center">
                  <img class="icon" id="icon-<?php echo $num;?>" width="120" height="120" data-src="<?php echo $icon; ?>" 
                    src="<?php echo get_stylesheet_directory_uri() . '/img/blank.gif';?>" />
                  <h4><?php echo $title; ?></h4>
                </div>
                <div class="des">
                  <?php echo $content; ?>
                </div>
              </div>
              <?php
                $num++;
            }
          }
        ?>
      </div>
      <?php if ( $title_2 || $content_2 ) { ?>
        <div class="section section-col-1">
          <div class="row">
            <div class="col s12 m12 l12 center">

              <h3 class="font-script red-text">
                <?php echo $title_2; ?>
              </h3>
              <div class="des section-content">
                <?php echo $content_2; ?>
              </div>
            </div>
          </div>
        </div>
      <?php }?>
    </div>
    <?php
  }

}

function get_section_col_2( $cols  = null, $full_width = '' ) {

  if ( $cols ) :

    $title = isset( $cols['title'] ) ? $cols['title'] : false;
    $content_left = isset( $cols['content_left'] ) ? $cols['content_left'] : false;
    $content_right = isset( $cols['content_right'] ) ? $cols['content_right'] : false;

    ?>
    <div class="section section-col-2 <?php echo $full_width; ?>">
      <div class="row">
        <div class="col s12 m12 l12 center">
          <h3 class="font-script red-text">
            <?php echo $title; ?>
          </h3>
          <?php if( $intro ) : ?>
              <div>
                <?php echo $intro; ?>
              </div>
          <?php endif; ?>
        </div>
        <div class="col s12 m6 l6 font-serif">
            <?php echo $content_left; ?>
        </div>
        <div class="col s12 m6 l6 font-serif">
            <?php echo $content_right; ?>
        </div>
      </div>
    </div>
    <?php

  endif;

}

function get_facilities_section( $cols  = null ) {

  if ( $cols ) :

    $title = isset( $cols['title'] ) ? $cols['title'] : false;
    $intro = isset( $cols['intro'] ) ? $cols['intro'] : false;
    $content_left = isset( $cols['content_left'] ) ? $cols['content_left'] : false;
    $content_right = isset( $cols['content_right'] ) ? $cols['content_right'] : false;
    $content_images_left = isset( $cols['content_images_left'] ) ? $cols['content_images_left']: false;
    $content_images_right = isset( $cols['content_images_right'] ) ? $cols['content_images_right'] : false;
	
	$content_images_left_desc = isset( $cols['description_left'] ) ? $cols['description_left']: false;
	$content_images_right_desc = isset( $cols['description_right'] ) ? $cols['description_right'] : false;
	
	

    ?>
    <div class="section section-facilities-header section-col-2">
      <div class="row">
        <div class="col s12 m12 l12 center">
          <h3 class="font-script red-text">
            <?php echo $title; ?>
          </h3>
          <?php if( $intro ) : ?>
              <div class="font-serif">
                <?php echo $intro; ?>
              </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
    <div class="section section-facilities full-width">
      <div class="row">
        <div class="col s12 m6 l6 font-serif" style="padding-left: 0; padding-right: 1.5rem;">
	    
		<?php get_content( $content_images_left, $content_left, $content_images_left_desc ); ?>
        </div>
        <div class="col s12 m6 l6 font-serif" style="padding-left:1.5rem; padding-right: 0;">
            <?php get_content( $content_images_right, $content_right, $content_images_right_desc ); ?>
        </div>
      </div>
    </div>
    <?php

  endif;

}

function get_content( $content_images, $content, $content_desc ){    
    if( $content_images ) :
?>
    <div class="content-images">
        <div class="content-main-image-preview">

	<?php
                if( isset( $content_images[0] ) ) :
            ?>
                <div class="main-image-preview">
					<?php echo $content; ?>
                    <img src="<?php echo $content_images[0]['image']['url']; ?>" style="width: 100%;">

                </div>
            <?php endif; ?>
            <div class="content-other-image-previews">
                <?php
                    foreach( $content_images as $i => $image ) :
                        if( $i > 0 ) :
                ?>
                            <div class="other-image-preview">
                                <img src="<?php echo $image['image']['url']; ?>" style="width: 100%;">
                            </div>
                <?php  
                        endif;
                    endforeach;
                ?>
				
            </div>
			
					<div class="main-image-location">
                        <?php
                            echo ( isset( $content_images[0]['location'] ) )
                                    ? $content_images[0]['location']
                                    : '';
                        ?>
                    </div> 
			
        </div>
    </div>
<?php
    endif;
}

function get_section_divider() {
  ?>
  <div class="section section-divider">
    <div class="row">
      <div class="col s12 m12 l12">
        <hr/>
      </div>
    </div>
  </div>
  <?php
}


function get_section_pest( $pest  = null ) {

  if ( $pest ) {

    $bg = isset( $pest['img']['sizes']['large'] ) ? $pest['img']['sizes']['large'] : false;
    $title = isset( $pest['title'] ) ? $pest['title'] : false;
    $subtitle = isset( $pest['subtitle'] ) ? $pest['subtitle'] : false;
    $content = isset( $pest['content'] ) ? $pest['content'] : false;
    ?>
    <div class="section full-width section-pest white-text">
      <div class="section-bg" style="background-image: url('<?php echo $bg; ?>');">
      </div>
      <div class="section-inner">
        <div class="row">
          <div class="col s10 m8 l8 content">
            <h3 class="white-text font-script"><?php echo $title; ?></h3>
            <h4 class="white-text"><?php echo $subtitle; ?></h4>
            <div class="des">
              <?php echo $content; ?>
            </div>
          </div>
        </div>
      </div>
    </div>

    <?php
  }
}

function get_section_col_1( $col  = null ) {

  if ( $col ) {

    $title = isset( $col['title'] ) ? $col['title'] : false;
    $content = isset( $col['content'] ) ? $col['content'] : false;
    ?>
    <div class="section section-col-1">
      <div class="row">
        <div class="col s12 m12 l12 center">

          <h3 class="font-script red-text">
            <?php echo $title; ?>
          </h3>
          <div class="des section-content">
            <?php echo $content; ?>
          </div>
        </div>
      </div>
    </div>
    <?php
  }
}


function get_section_packaging( $packaging = null  ) {

  if ( $packaging ) {

    $img = isset( $packaging['image']['sizes']['medium_large'] ) ? $packaging['image']['sizes']['medium_large'] : false;
    $img_h = isset( $packaging['image']['sizes']['medium_large-height'] ) ? $packaging['image']['sizes']['medium_large-height'] : false;
    $img_w = isset( $packaging['image']['sizes']['medium_large-width'] ) ? $packaging['image']['sizes']['medium_large-width'] : false;
    $subtitle = isset( $packaging['subtitle'] ) ? $packaging['subtitle'] : false;
    $content = isset( $packaging['content'] ) ? $packaging['content'] : false;
    $title = isset( $packaging['title'] ) ? $packaging['title'] : false;

    ?>
    <div class="section full-width bg-red section-packaging">
      <div class="section-inner">
        <div class="row">
          <div class="col s12 m8 l8 right">
            <div class="content">
              <h3 class="font-script white-text"><?php echo $title; ?></h3>
              <h4 class="white-text"><?php echo $subtitle; ?></h4>
              <div class="des white-text">
                <?php echo $content; ?>
              </div>
            </div>
          </div>
          <div class="col s12 m4 l4">
            <div class="bleed-both">
              <img class="responsive-img" width="<?php echo $img_w; ?>" height="<?php echo $img_h; ?>" title="<?php echo $title; ?>"
                src="<?php echo $img; ?>" />
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php

  }

}

function get_section_sponsors( $sponsor_block = null ) {

  if ( $sponsor_block ) {

    $title = isset( $sponsor_block['title'] ) ? $sponsor_block['title'] : false;
    $sponsors = isset( $sponsor_block['sponsors'] ) ? $sponsor_block['sponsors'] : false;
    $content = isset( $sponsor_block['content'] ) ? $sponsor_block['content'] : false;

    ?>
    <div class="section section-sponsors">
      <div class="row">
        <div class="col s12 m12 l12 center">
          <h3 class="font-script red-text">
            <?php echo $title; ?>
          </h3>
        </div>
      </div>

      <div class="row sponsor-content">
        <div class="col s12 m12 l12 font-serif center">
          <?php echo $content;?>
        </div>
      </div>

      <div class="row">
        <div class="col s12 m12 l12 center sponsors">

          <?php foreach ( (array) $sponsors as $key => $sponsor ) {

            $logo  = isset( $sponsor['logo'] ) ? $sponsor['logo'] : false;
            $img   = isset( $logo['sizes']['medium'] ) ? $logo['sizes']['medium'] : ( isset( $logo['url'] ) ? $logo['url'] : false );
            $img_w = isset( $logo['sizes']['medium-width'] ) ? $logo['sizes']['medium-width'] : '';
            $img_h = isset( $logo['sizes']['medium-height'] ) ? $logo['sizes']['medium-height'] : '';
            $name  = isset( $sponsor['name'] ) ? trim( $sponsor['name'] ) : '';
            $alt   = $name ? $name : ( ! empty( $logo['alt'] ) ? $logo['alt'] : ( ! empty( $logo['title'] ) ? $logo['title'] : 'Community partner' ) );

            if ( ! $img ) {
              continue;
            }
            ?>
            <div class="sponsor">
              <div class="sponsor-logo">
                <img src="<?php echo esc_url( $img ); ?>" alt="<?php echo esc_attr( $alt ); ?>" loading="lazy"
                  <?php if ( $img_w && $img_h ) { ?>width="<?php echo (int) $img_w; ?>" height="<?php echo (int) $img_h; ?>"<?php } ?>>
              </div>
              <?php if ( $name ) { ?>
                <div class="name"><?php echo esc_html( $name ); ?></div>
              <?php } ?>
            </div>
          <?php } ?>
        </div>
      </div>
    </div>
    <?php

  }

}

function get_section_news() {

  $args = array(
    'post_type' => 'post',
    'posts_per_page' => '80',
    'category_name' => 'news',
    'fields' => 'ids',
  );

  $news = new WP_Query( $args );

  if ( $news->posts ) :
    ?>
    <div class="section full-width section-news">
      <div class="section-inner news-inner">
        <div class="row">
          <div class="row">
            <div class="col s12 m12 l12 center">
              <h3 class="font-script red-text">
                News &amp; Press
              </h3>
            </div>
          </div>
          <div class="col s12 m2 l2 years">

            <?php

              foreach ( $news->posts as $key => $post_id ) {

                $year = get_the_date('Y', $post_id);
                $year_prev = $year;
                $class = '';

                if ( $key == 0 )
                  $class = 'active';

                if ( $key > 0 ) {
                  $year_prev = get_the_date( 'Y', $news->posts[ $key-1 ] );
                }

                if ( $key == 0 || $year !== $year_prev ) {
                  ?>
                  <a href="#" class="btn-year <?php echo $class; ?>" data-year="<?php echo $year; ?>"><?php echo $year; ?>
                    <span class="arrow"></span>
                    <span class="arrow-shadow"></span>
                  </a>
                  <?php
                }
              }
            ?>
          </div>

          <div class="col s12 m10 l10 right news">
            <div class="news-inner font-serif">
              <div class="row">
                <?php foreach ( $news->posts as $key => $post_id ) {

                  $year = get_the_date('Y', $post_id);
                  $date = get_the_date('F j, Y', $post_id);
                  $class = 'news-' . $year;
                  $hide = '';

                  if ( $year < date('Y') )
                    $hide = 'hide';
                  ?>
                  <div class="col s6 m6 l6 news-block <?php echo $class;?> <?php echo $hide; ?>">
                    <div class="des title">
                      <a href="<?php echo get_the_permalink( $post_id ); ?>">
                        <?php echo get_the_title( $post_id ); ?>
                      </a>
                    </div>
                    <div class="date">
                      <?php echo $date; ?>
                    </div>
                  </div>
                <?php } ?>
              </div>
            </div>
          </div>


        </div>
      </div>
    </div>
    <?php
  endif;

}

function get_video_id( $link = false ) {

  $video_id = false;

  if ( $link ) {

    $extra_arg_position = strpos( $link, '&' );
    $id_begin_position = strpos( $link, 'v=' ) + 2;
    $id_end_position = $extra_arg_position - $id_begin_position;

    if ( $id_end_position > 0 ) {
      $video_id = substr( $link, $id_begin_position, $id_end_position );
    } else {
      $video_id = substr( $link, $id_begin_position );
    }

  }

  return $video_id;
}



function get_page_tabs(){
?>

    <div class="section full-width section-anchors section-page-navigation no-margin">
        <div class="section-inner center">
            <?php
                wp_nav_menu( array( 
                    'theme_location' => 'page-navigation', 
                    'container_class' => 'custom-menu-class'
                ) ); 
            ?>
        </div>
    </div>
<?php
}

function get_services($services) {
  foreach($services as $service) :
    $title = isset($service['service']) ? $service['service'] : '';
    $description = isset($service['service_description']) ? $service['service_description'] : '';
?>
    <h4><?php echo $title; ?></h4>
    <p><?php echo $description; ?></p>
<?php
  endforeach;
}

// Shortcode: [product_info key="flavour"]
function get_product_info( $atts ) {
    $atts = shortcode_atts( array(
        'key'    => '',
        'post_id'=> '',
    ), $atts );

    if ( empty( $atts['key'] ) ) {
        return '';
    }

    // Get the correct post ID (current product, or override via post_id="")
    $post_id = ! empty( $atts['post_id'] ) ? intval( $atts['post_id'] ) : get_the_ID();

    if ( ! $post_id ) {
        return '';
    }

    /**
     * 1️⃣ Fetch $product_info for this product
     * 
     * If you're using ACF:
     *   - Field name: product_info
     *   - Likely a repeater/array
     */
    if ( function_exists( 'get_field' ) ) {
        $product_info = get_field( 'product_info', $post_id );
    } else {
        // Fallback to regular post meta if NOT using ACF
        $product_info = get_post_meta( $post_id, 'product_info', true );
    }

    if ( empty( $product_info ) || ! is_array( $product_info ) ) {
        return '';
    }

    // Most likely your data lives in $product_info[0]
    $data = isset( $product_info[0] ) ? $product_info[0] : $product_info;

    if ( ! is_array( $data ) ) {
        return '';
    }

    // Support dot-notation: e.g. "nutrition_info.sizes.medium"
    $keys = explode( '.', $atts['key'] );

    foreach ( $keys as $k ) {
        if ( isset( $data[ $k ] ) ) {
            $data = $data[ $k ];
        } else {
            return ''; // key not found
        }
    }

    // If the final thing is still an array, you can decide how to output it
    if ( is_array( $data ) ) {
        // Example: comma-separated if it's a simple list
        if ( array_values( $data ) === $data ) {
            return esc_html( implode( ', ', $data ) );
        }

        // Default: JSON (for debugging or dev)
        return esc_html( wp_json_encode( $data ) );
    }

    return  $data;
}
add_shortcode( 'product_info', 'get_product_info' );




