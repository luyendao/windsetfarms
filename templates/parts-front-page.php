<?php

function cc_do_product_grid() {

  global $fields;

  $products_title = isset( $fields['products_title'] ) ? $fields['products_title'] : false;
  $products_subtitle = isset( $fields['products_subtitle'] ) ? $fields['products_subtitle'] : false;
  $product_cats = isset( $fields['product_cats'] ) ? $fields['product_cats'] : false;

  if ( $products_title ) {


    ?>
    <div class="section section-product-grid">

      <h2 class="center uppercase"><?php echo $products_title; ?></h2>

      <?php if ( $products_subtitle ) { ?>
        <div class="section-subtitle center font-serif">
          <?php echo $products_subtitle; ?>
        </div>
      <?php } ?>

    <?php
      if ( !empty( $product_cats ) ) {
          $num_of_product_cats = count( $product_cats );
          $center_grid = ( $num_of_product_cats % 3 === 1 ) ? " offset-m4 offset-l4" : "";
    ?>
        <div class="row">

          <?php foreach ( $product_cats as $key => $cat ) {

            $cat_id = isset( $cat->term_id ) ? $cat->term_id : false;
            $name = isset( $cat->name ) ? $cat->name : false;
            $cat_img = get_field( 'prod_cat_img', 'category_' . $cat_id );

            $img_med = isset( $cat_img['sizes']['medium_large'] ) ? $cat_img['sizes']['medium_large'] : false;
            $h = isset( $cat_img['sizes']['medium_large-height'] ) ? $cat_img['sizes']['medium_large-height'] : false;
            $w = isset( $cat_img['sizes']['medium_large-width'] ) ? $cat_img['sizes']['medium_large-width'] : false;

            $cat_url = get_term_link( $cat );

            ?>
            <div class="col s6 m4 l4 center product-cat <?php echo ( $key + 1 == $num_of_product_cats ) ? $center_grid : ''; ?>">
              <div class="product-item">
                <?php if ( $img_med ) { ?>
                  <a href="<?php echo $cat_url; ?>">
                    <img class="responsive-img" src="<?php echo $img_med;?>" width="<?php echo $w;?>" height="<?php echo $h;?>">
                  </a>
                <?php } ?>
                <div class="cat-name uppercase">
                  <a href="<?php echo $cat_url; ?>">
                    <?php echo $name; ?>
                  </a>
                </div>
              </div>
            </div>
          <?php } ?>
        </div>
        <div class="row" style="margin-top: 3em;">
          <div class="col s12 m12 l12 center">
            <a class="btn waves-effect waves-light" href="<?php echo get_permalink( get_page_by_path('our-produce') ); ?>">
              View All Products
            </a>
          </div>
        </div>
      <?php } ?>
    </div>
    <?php

  }

}


function cc_magazine_block_twin( $field_data = null ) {

  if ( $field_data ) {

    ?>

    <div class="section full-width bg-red bleed-twin section-info">
      <div class="section-inner">

        <?php
          foreach ( $field_data as $key => $data ) {

            $section_title = isset( $data['section_title'] ) ? $data['section_title'] : false;
            $section_content = isset( $data['section_content'] ) ? $data['section_content'] : false;
            $img = isset( $data['img']['url'] ) ? $data['img']['url'] : false;
            $video_link = isset( $data['video_link'] ) ? $data['video_link'] : '#';
            $learn_more = isset( $data['learn_more'] ) ? $data['learn_more'] : false;
            $video_id = get_video_id( $video_link );

            $img_resized = cc_get_resized_img( array(
              'url' => $img,
              'size' => array( 600, 999 ),
            ));

            if ( $key == 0 ) {
              ?>

                <div class="row upper">
                  <div class="col s12 m6 l6 right img equal-height video-controls">

                    <?php if ( $video_id ) { ?>
                    <!-- Modal Trigger -->
                      <a class="modal-play-trigger btn-play large" href="#video-<?php echo $key; ?>">
                        <div class="btn-icon">
                          <i class="fa fa-play"></i>
                        </div>
                      </a>
                      <?php echo $img_resized; ?>
                    <?php } else { ?>
                      <?php echo $img_resized; ?>
                    <?php } ?>
                  </div>
                  <div class="col s12 m6 l6 content equal-height">
                    <h2 class="font-script"><?php echo $section_title; ?></h2>
                    <div class="des">
                      <?php echo $section_content; ?>
                    </div>

                    <?php if ( $learn_more ) { ?>
                      <a class="btn invert" href="<?php echo $learn_more;?>">Learn More</a>
                    <?php } ?>

                  </div>
                </div>

                <?php if ( $video_id ) { ?>
                <!-- Modal Structure -->
                <div id="video-<?php echo $key; ?>" class="modal">
                  <div class="modal-content">

                    <div class="btn-video-close modal-close">
                      <i class="fa fa-close"></i>
                    </div>

                    <div class="video" data-id="<?php echo $video_id; ?>">
                    </div>

                  </div>
                </div>
                <?php } ?>
              <?php
            }

            if ( $key > 0 ) {

              ?>
              <div class="row lower">
                <div class="col s12 m6 l6 img equal-height">
                  <img src="<?php echo $data['img']['sizes']['large']; ?>" />
                </div>
                <div class="col s12 m6 l6 content equal-height">
                  <h3 class="font-sans">
                    <?php echo $section_title; ?>
                  </h3>
                  <div class="des">
                    <?php echo $section_content; ?>
                  </div>

                  <?php if ( $learn_more ) { ?>
                    <a class="btn invert" href="<?php echo $learn_more;?>">Learn More</a>
                  <?php } ?>

                  <br/><br/>
                </div>
              </div>

              <?php
            }
          }
        ?>
      </div>
     </div>
    <?php
  }

}

function cc_magazine_block_cover( $data = null ) {

  $data = isset( $data['0'] ) ? $data['0'] : false;

  if ( $data ) {

    $bg = isset( $data['bg'] ) ? $data['bg'] : false;
    $bg_large = isset( $data['bg']['url'] ) ? $data['bg']['url'] : false;
    $title = isset( $data['title'] ) ? $data['title'] : false;
    $subtitle = isset( $data['subtitle'] ) ? $data['subtitle'] : false;
    $content = isset( $data['content'] ) ? $data['content'] : false;
    $button_link = isset( $data['button_link'] ) ? $data['button_link'] : false;
    $button_text = isset( $data['button_text'] ) ? $data['button_text'] : 'Learn More';


    ?>
    <div class="section full-width no-margin cover m-none-bg s-none-bg"
      style="background-image: url(<?php echo $bg_large;?>);">
      <div class="section-inner">

        <div class="row">
          <div class="col s12 m9 l6">
            <h2 class="font-script text-red"><?php echo $title;?></h2>
            <h3 class=""><?php echo $subtitle;?></h2>
            <div class="des font-serif">
              <?php echo $content; ?>
            </div>
            <?php if ( $button_link ) { ?>
              <a href="<?php echo $button_link; ?>" class="btn btn-mini"><?php echo $button_text; ?></a>
            <?php } ?>
          </div>
        </div>

      </div>
    </div>

    <?php
  }
}
?>
