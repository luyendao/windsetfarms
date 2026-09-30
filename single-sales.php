  <!DOCTYPE html>
  <html lang="en">
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
    <title><?php bloginfo( 'name' );?><?php wp_title(); ?> </title>
    <meta name="description" content="<?php bloginfo( 'description' ) ?>" />
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" href="/favicon-32x32.png" sizes="32x32">
    <link rel="icon" type="image/png" href="/favicon-16x16.png" sizes="16x16">
    <link rel="manifest" href="/manifest.json">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="theme-color" content="#ffffff">
    <!--[if lt IE 9]>
    <script src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/html5.js"></script>
    <![endif]-->
    <?php
      wp_head();
    ?>
  </head>
  <body <?php body_class(); ?>>

    <a class="hide back-to-top">
      <i class="fa fa-chevron-up"></i>
      TOP
    </a>

    <?php

      if ( have_posts() ) : while ( have_posts() ) : the_post();

        $auth = false;
        $link = get_field('share_link');
        $access_given = isset ( $_GET['access'] ) ? $_GET['access'] : false;
        $link_offset = strpos( $link, 'access=' ) + 7;
        $access_db = substr( $link, $link_offset );

        if ( current_user_can( 'edit_posts', get_the_ID() ) ) {
          $auth = true;
        }

        if ( $access_given == $access_db ) {
          $auth = true;
        }

        if ( ! $auth ) {
          wp_redirect( site_url() );
          exit;
        }


        $img = '';

        if ( has_post_thumbnail() ) {

          ob_start();
          the_post_thumbnail_url( 'large' );
          $img = ob_get_clean();

        } else {

          $front_page = get_option( 'page_on_front' );

          $thumb_id = get_post_thumbnail_id( $front_page );
          $thumb_url_array = wp_get_attachment_image_src($thumb_id, 'large', true);
          $img = $thumb_url_array[0];

        }

        global $fields;

        $prepared_for = isset( $fields['sales_for'] ) ? $fields['sales_for'] : false;
        $prepared_by  = isset( $fields['sales_by'] ) ? $fields['sales_by'] : false;
        $sales_phone  = isset( $fields['sales_phone'] ) ? $fields['sales_phone'] : false;
        $products     = isset( $fields['products'] ) ? $fields['products'] : false;
        $subtotal     = isset( $fields['subtotal'] ) ? $fields['subtotal'] : false;
        $adjustments  = isset( $fields['adjustments'] ) ? $fields['adjustments'] : false;
        $total        = isset( $fields['total'] ) ? $fields['total'] : false;
        $notes        = isset( $fields['notes'] ) ? $fields['notes'] : false;

        ?>
        <div class="header" style="background-image: url(<?php echo $img;?>); background-size: cover;">
          <div class="container">
            <div class="row">
              <div class="col s12 m12 l12">

                <div class="logo">
                  <a href="<?php bloginfo( 'url' );?>" title="<?php bloginfo( 'name' );?>">
                    <img width="154" height="231"
                    src="<?php bloginfo( 'url' );?>/logo-windset.png"
                    srcset="<?php bloginfo( 'url' );?>/logo-windset@2x.png 2x"
                    alt="logo"/>
                  </a>
                </div>


                <?php if ( $auth ) { ?>
                  <div class="left-align letterhead">
                    <div class="prepared-for ">
                      Prepared for:
                    </div>
                    <div class="client font-sans">
                      <?php echo $prepared_for; ?>
                    </div>
                    <div class="by font-serif">
                      <span class="date">
                        <?php the_time('F j, Y'); ?>
                      </span>
                      <span class="name">
                        by <?php echo $prepared_by; ?> <?php echo $sales_phone; ?>
                      </span>
                    </div>
                  </div>
                <?php } else { ?>
                  <div class="left-align letterhead">
                    <div class="prepared-for ">
                      Please login to preview
                    </div>
                  </div>
                <?php } ?>
              </div>
            </div>
          </div>
          <div class="overlay"></div>
        </div>

        <div class="show-for-print">
          <div class="bg">
            <img class="responsive-img" src="<?php echo $img;?>" />
          </div>
        </div>


        <?php if ( $auth ) { ?>



        <div class="section section-content">
          <div class="row">
            <div class="col s12 m12 l12">
              <h2>Product Information</h2>
              <div class="order-details">
                <?php the_content(); ?>
              </div>

              <?php if ( $products ) { ?>
                <div class="products">


                  <!-- Header -->
                  <div class="row product-sale-header font-sans uppercase">
                    <div class="col s10 m10 l10">
                      PRODUCT
                    </div>
                    <div class="col s2 m2 l2 right-align">
                      PRICE PER CASE
                    </div>
                  </div>



                  <hr>


                  <!-- Products -->

                  <?php
                    foreach ( $products as $i => $item ) {

                      /*
                       *
                       * Products come with different sizes
                       *
                       */
                      $product             = $item['product'][0];

                      
                      $product_id          = $product->ID;
                      $product_name        = $product->post_title;
                      $product_url         = get_the_permalink( $product_id );
                      $product_description = $product->post_content;
                      $product_sizes       = get_field( 'product_sizes', $product_id );

                      $primary_size = ( isset( $product_sizes[0] ) ) ? $product_sizes[0] : false;

                      foreach($product_sizes as $i => $size){
                        if($item['size'] == $size['weight']){
                          $primary_size = $size;
                        }
                      }
                      
                      $product_pricing     = $item['pricing'];
                      $product_shipping    = $item['shipping'];

                      if( isset( $primary_size ) ){

                        $logo             = $primary_size['product_logo']['url'];
                        $image            = $primary_size['img']['sizes']['large'];
                        $weight           = $primary_size['weight'];
                        $availability     = $primary_size['available_from'];
                        $origin           = $primary_size['origin'];
                        $details          = $primary_size['details'];
                        $related_products = $primary_size['related'];
                        $units            = isset( $primary_size['units'] ) ? $primary_size['units'] : [];
                        $primary_unit     = isset( $units[0] ) ? $units[0] : false;
                        $primary_unit_image  = isset( $primary_unit['unit_img']['sizes']['large'] ) ? $primary_unit['unit_img']['sizes']['large'] : $image;
                        $primary_unit_size = ( $primary_unit ) ? $primary_unit['unit_size'] : '';
                        $primary_unit_description = ( $primary_unit ) ? $primary_unit['unit_description'] : '';
                     ?>


                      <!-- Price -->
                      <?php if( $product_pricing ) { ?>
                        <div class="row negative-margin">
                          <div class="col s12 m12 l12 pricing font-sans bold" style="color: #F44336;">
                              $<?php echo $product_pricing; ?>
                          </div>
                        </div>
                      <?php } ?>

                      <!-- Content -->
                      <div class="row">
                        <div class="col s12 m12 l12">

                          <section class="main-content" data-product-id="<?php echo $product_id; ?>">
                              <div class="row negative-margin flex-equal-height">

                                <div class="col s12 m4 l4" style="position: relative;">
                                  <div class="sale-image-container">
                                    <img class="responsive-img negative-margin" src="<?php echo $primary_unit_image; ?>" title="<?php echo $product_name; ?>">
                                    <p class="right-align">
                                      <span class="font-sans bold uppercase">
                                        <?php echo $primary_unit_size; ?>
                                      </span>
                                        <img src="<?php echo get_template_directory_uri() . '/img/popup.jpg'; ?>" class="btn-trigger-popup"   data-product-id="<?php echo $product_id; ?>" data-size-id="0">
                                    </p>
                                  </div>
                                </div>

                                <div class="col s12 m8 l8">
                                    <!--

                                        Product Header & Meta

                                    -->
                                    <div class="product-sale-detail font-sans">
                                      <div class="row negative-margin">
                                        <div class="col s12 m12 l12">
                                          <div class="name">
                                            <?php if ( !empty( $logo ) ) { ?>
                                              <img class="responsive-img product-logo" src="<?php echo $logo; ?>" title="<?php echo $product_name; ?>">
                                            <?php } else { ?>
                                              <div class="no-logo">
                                                <h2><?php echo $product_name; ?></h2>
                                              </div>
                                            <?php } ?>
                                          </div>

                                          <div class="meta font-sans">
                                            <?php if ( $weight ) { ?>
                                              <span class="size"><?php echo $weight; ?></span>
                                            <?php } ?>
                                            <?php if ( $availability ) { ?>
                                              <span class="availability"><?php echo $availability; ?></span>
                                            <?php } ?>
                                            <?php if ( $origin ) { ?>
                                              <span class="origin">Country of Origin: <?php echo $origin; ?></span>
                                            <?php } ?>
                                          </div>



                                          <div class="negative-margin">
                                            <div class="des font-serif" style="margin: 10px 0;">
                                              <?php
                                              if ( ! empty( $details ) ) {
                                                foreach ( $details as $detail ) {
                                                  $label = isset( $detail['label'] ) ? $detail['label'] : false;
                                                  $info  = isset( $detail['info'] )  ? $detail['info'] : false;

                                                  if ( $label ) {
                                                    ?>
                                                    <div class="row">
                                                      <div class="col s5 m6 l5">
                                                        <?php echo $label; ?>
                                                      </div>
                                                      <div class="col s7 m6 l7">
                                                        <?php echo $info; ?>
                                                      </div>
                                                    </div>
                                                    <?php
                                                  }
                                                }
                                              }
                                              ?>
                                            </div>

                                            <?php if ( ! count( $product_sizes ) > 1 ) { ?>                     <div class="related-products row uppercase">

                                                <div class="col s12 m12 l12 font-sans">
                                                  <span class="uppercase">Also Available in:</span>
                                                  <?php
                                                  /// TODO
                                                  foreach ( $product_sizes as $i => $item ) {
                                                    if( $i != $primary_size_idx ){
                                                      $name = isset( $item['weight'] ) ? $item['weight'] : false;

                                                      if ( !empty( $name ) ) {
                                                        ?>
                                                        <a href="<?php echo $product_url; ?>#available-sizes"><?php echo $name; ?></a>
                                                        <?php
                                                      }
                                                    }                                                    
                                                  }
                                                  ?>
                                                </div>
                                              </div>
                                            <?php } ?>

                                            <?php if ( ! empty( $related_products ) ) { ?>
                                              <div class="related-products row uppercase">

                                                <div class="col s12 m12 l12 font-sans">
                                                  <span class="uppercase">Related Products:</span>
                                                  <?php
                                                  foreach ( $related_products as $id ) {

                                                    $p_name = get_the_title( $id );
                                                    $p_url = get_the_permalink( $id );

                                                    if ( !empty( $p_name ) ) {
                                                      ?>
                                                      <a href="<?php echo $p_url; ?>#available-sizes"><?php echo $p_name; ?></a>
                                                      <?php
                                                    }
                                                  }
                                                  ?>
                                                </div>
                                              </div>
                                            <?php } ?>


                                            <div class="product-links row">
                                              <div class="col s12 m12 l12 font-sans">
                                                <a href="<?php echo $product_url; ?>" class="uppercase">
                                                  Product Description
                                                </a>
                                              </div>
                                            </div>


                                              <div class="row negative-margin">
                                                <div class="col s12 m12 l12 right-align font-sans uppercase bold" style="font-size: 15px;">
                                                  <?php
                                                    // If nothing is printed, the enlargement button sits on a wrong position - TODO
                                                    echo ( ! empty( $product_shipping ) ) ? "Shipping: $product_shipping" : "&nbsp;";
                                                  ?>
                                                </div>
                                              </div>

                                          </div>


                                        </div>
                                      </div>
                                    </div>


                                </div>
                              </div>

                              <div class="related-sizes negative-margin">
                                <br>
                                <hr>
                                <br>
                                <div class="row negative-margin">
                                    <?php
                                      $number_of_empty_columns = 7 - count( $units );

                                      // add offsets.
                                      if( $number_of_empty_columns > 0 ){
                                        $offset = "offset-l" . $number_of_empty_columns * 2;
                                        $offset .= " offset-m" . $number_of_empty_columns * 2;
                                      }
                                    ?>
                                    <?php
                                      foreach( $units as $idx => $unit ) {
                                        if( $idx > 0 ){
                                          $unit_img = $unit['unit_img']['sizes']['large'];
                                          $unit_size = $unit['unit_size'];
                                      ?>
                                          <div class="col s4 m2 l2 <?php echo $offset; ?> right-align">
                                              <img src="<?php echo $unit_img; ?>" class="responsive-img">
                                              <span class="font-sans bold uppercase"><?php echo $unit_size; ?></span>
                                              <img class="btn-trigger-popup" src="<?php echo get_template_directory_uri() . '/img/popup.jpg'; ?>"   data-product-id="<?php echo $product_id; ?>" data-size-id="<?php echo $idx; ?>">
                                          </div>
                                      <?php
                                        $offset = ''; // One time use only
                                        }  
                                      }
                                    ?>


                                </div>
                                <br>
                                <hr>
                                <br>
                              </div>

                          </section>



                          <!-- Pop up contents -->
                          <?php
                            foreach( $units as $idx => $unit ) {
                              $unit_img = $unit['unit_img']['sizes']['large'];
                              $unit_description = $unit['unit_description'];
                            ?>
                              <section class="product-popup" data-product-id="<?php echo $product_id; ?>" data-size-id="<?php echo $idx ?>">
                                <div class="row">
                                  <div class="col s12 m12 l12 right-align">
                                    <img src="<?php echo $unit_img; ?>" class="responsive-img">
                                    <span class="right-align bold font-sans uppercase">
                                        <?php echo $unit_description; ?>
                                        &nbsp;<img class="btn-close-popup" src="<?php echo get_template_directory_uri() . '/img/close-popup.jpg'; ?>" width="20px;">
                                    </span>
                                  </div>
                                </div>
                              </section>
                          <?php
                            }
                          ?>
                        </div>
                      </div>

                    <?php
                      }
                    }
                  ?>
                    <div class="notes">
                      <div class="uppercase title">Notes</div>
                        <div class="des font-serif">
                          <?php echo $notes; ?>
                        </div>
                      </div>
                    </div>
                    <?php
                  }
                ?>
            </div>
          </div>
        </div>

        <?php if ( ! empty( $link ) ) { ?>
          <div class="section section-share-doc print-hide">
            <div class="row">
              <div class="col s12 m12 l12">
                <div class="share-doc">
                  <i class="fa fa-share-alt"></i> Share this document:
                  <input type="text" value="<?php echo $link; ?>"
                    onmouseover="this.focus()"
                    onclick="this.setSelectionRange(0, this.value.length)"
                    onfocus="this.setSelectionRange(0, this.value.length)" autofocus>
                </div>
              </div>
            </div>
          </div>
        <?php
          }
        }
      endwhile;
      endif;
    ?>

  <?php get_footer(); ?>
