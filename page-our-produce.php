<?php /* Template Name: Our Produce */ ?>

<?php
  get_header();

  if ( have_posts() ) : while ( have_posts() ) : the_post();

    cc_do_title_container();

    global $fields;

    if ( !$fields ) :
      $products_page    = get_page_by_path('our-produce');
      $products_page_id = $products_page->ID;
      $fields           = get_fields( $products_page_id );
    endif;

    $featured_products = isset( $fields['featured_products'] ) ? $fields['featured_products'] : false;

    if ( $featured_products ) :
      $p_number = count( $featured_products ) + 1.5;
      $width    = 'style="width: ' . number_format( 100 / $p_number, 2, '.', '') . '%;"';
      ?>
      <div class="section full-width section-anchors no-margin">
        <div class="section-inner center product-anchors">
          <a href="#all-produce" class="inline-block" <?php echo $width; ?> >All Produce</a>
          <?php
            foreach ( $featured_products as $key => $p_data ) :

              $category = isset( $p_data['category'] ) ? $p_data['category'] : false;
              $des = isset( $p_data['category_description'] ) ? $p_data['category_description'] : false;

              if ( $category ) :
                $slug = $category->slug;
                $name = $category->name;
                ?>
                <a href="#<?php echo $slug;?>" class="inline-block" <?php echo $width; ?> >
                  <?php echo $name;?>
                  <div class="indicator"></div>
                  <div class="indicator-white"></div>
                  <div class="indicator-shadow"></div>
                </a>
                <?php
              endif;
            endforeach;
          ?>
        </div>
      </div>

      <a href="#all-produce" class="anchor"></a>
      <div class="section section-products scrollspy">
        <?php
          foreach ( $featured_products as $key => $p_data ) :

            $category = isset( $p_data['category'] ) ? $p_data['category'] : false;
            $des      = isset( $p_data['category_description'] ) ? $p_data['category_description'] : false;
            $products = isset( $p_data['products'] ) ? $p_data['products'] : false;

            if ( $category ) :
              $cat_id = $category->term_id;
              $slug = $category->slug;
              $name = $category->name;
        ?>
              <div class="row section-<?php echo strtolower($name); ?>">
                <div class="col s12 m12 l12 center">
                  <a id="<?php echo $slug; ?>" class="anchor"></a>
                  <h2 class="uppercase"><?php echo $name; ?></h2>
                  <div class="des">
                    <?php echo $des; ?>
                  </div>
                </div>
              </div>
              <div class="row product-list section-<?php echo strtolower($name); ?>">
                <?php
                  $products_count = count( $products );

                  if ( $products_count ) :

                    foreach ( $products as $i => $product ) :

                      $product_id = $product->ID;
                      $product_name = $product->post_title;
                      $sizes = get_field( 'product_sizes', $product_id );
                      $tabs = '';
                      $url = get_permalink( $product->ID );
                      $sizes_count = count( $sizes );
                ?>
                    <div class="col s6 m4 l3 <?php if ( $products_count == 1 ) echo 'product-center' ;?>  <?php if ( $products_count == 2 && $i == 0 ) echo 'offset-l3 offset-m2'; ?>">
                        <div class="product product-<?php echo $product_id; ?>" data-id="<?php echo $product_id; ?>">
                          <div class="images carousel carousel-slider carousel-<?php echo $product_id; ?> center" data-indicators="true">
                            <?php foreach ( $sizes as $i => $size ) :

                              $size_slug = 'product-' . $product_id . '-' . $i;
                              $weight = isset( $size['weight'] ) ? $size['weight'] : false;
                              $img = isset( $size['img']['url'] ) ? $size['img']['url'] : false;


                              $img_resized = cc_get_resized_img( array(
                                'url' => $img,
                                'size' => array( '600' ),
                                'post_id' => $product_id,
                              ));


                              $active = '';
                              $display = 'style="display:none;"';

                              if ( $i == '0' ) {
                                $active = 'active';
                                $display = '';
                              }

                              $cols = 's6';

                              if ( $sizes_count == 1 )
                                $cols = 's12';

                              $tabs .= '
                                <li class="tab ' . $active .'">
                                  <div data-href="#' . $size_slug .'">
                                    ' . $weight .'
                                  </div>
                                  <div class="indicator"></div>
                                </li>
                              ';

                              ?>
                              <a href="<?php echo $url;?>" class="carousel-item">
                                <div id="<?php echo $size_slug; ?>" class="valign" <?php //echo $display; ?>>
                                  <?php echo $img_resized; ?>
                                </div>
                              </a>
                            <?php endforeach; ?>
                          </div>
                          <div class="name">
                            <a href="<?php echo $url;?>">
                              <?php echo $product_name; ?>
                            </a>
                          </div>
                          <hr/>
                          <ul class="weights center">
                            <?php echo $tabs; ?>
                          </ul>
                        </div>
                      </div>
                <?php
                    endforeach;
                  endif;
                ?>
              </div>
        <?php
            endif;
          endforeach;
        ?>
      </div>
<?php
      endif;
    endwhile;
  endif;
?>
<?php get_footer(); ?>
