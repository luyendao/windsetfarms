<?php get_header(); ?>

<?php

  if ( have_posts() ) : while ( have_posts() ) : the_post();

    cc_do_title_container();

    global $fields;

    $product_image = isset( $fields['product_image']['sizes']['medium_large'] ) ? $fields['product_image']['sizes']['medium_large'] : false;
    $product_sizes = isset( $fields['product_sizes'] ) ? $fields['product_sizes'] : false;
    $product_info = isset( $fields['product_info'] ) ? $fields['product_info'] : false;
    $do_not_translate = ( has_category('organics' ) ) ? 'dont-translate' : '';

    ?>
    <div class="section <?php echo $do_not_translate; ?>">
      <div class="row">
        <div class="col s12 m4 l4 right">
          <?php if ( $product_image ) { ?>
            <img class="responsive-img" src="<?php echo $product_image; ?>" title="<?php the_title();?>" />
          <?php } ?>
        </div>
        <div class="col s12 m8 l8">
          <div class="hentry drop-caps pad-left font-serif">
            <?php the_content() ;?>
          </div>
        </div>
      </div>
      <hr/>
    </div>

    <?php if ( $product_sizes ) { ?>
    <div id="available-sizes" class="section product-sizes <?php echo $do_not_translate; ?>">
        <div class="row">

        <?php 
        
        $product_count = count($product_sizes);

            if ($product_count == 1 && get_field('product_asset')) {
              $product_header =  '<div class="col s12 m6 l6 py-6 product-size-count-1">';
            }
            elseif ($product_count > 1 && get_field('product_asset')) {
            $product_header =  '<div class="col s12 m6 l6 center py-6 product-size-count-many">'; 
            }
            elseif (isset($product_sizes) && !get_field('product_asset')) {
              $product_header =  '<div class="col s12 m12 l12 center py-6 product-size-count-many">'; 
            }        

        echo $product_header;

        
        ?>

            <div class="product-size-wrapper">
              <h2 class="tiny">Available Sizes</h2>

              <?php foreach ( $product_sizes as $size ) {
                $weight = isset( $size['weight'] ) ? $size['weight'] : false;
                $size_img = isset( $size['img']['sizes']['large'] ) ? $size['img']['sizes']['large'] : false;
                ?>
                <div class="size">
                  <img class="responsive-img" src="<?php echo $size_img; ?>" />
                  <div class="weight"><?php echo $weight; ?></div>
                </div>
              <?php } ?>
            </div>

          </div>


            <div class="col s12 m6 l6 center py-6 video-embed">
                <?php echo get_field('product_asset') ?>
            </div>
          


        </div>
        <hr/>
      </div>
    <?php } ?>

    <?php if ( $product_info ) {

      $characteristics = isset( $product_info['0']['characteristics'] ) ? $product_info['0']['characteristics'] : false;
      $flavour = isset( $product_info['0']['flavour'] ) ? $product_info['0']['flavour'] : false;
      $nutrition = isset( $product_info['0']['nutrition'] ) ? $product_info['0']['nutrition'] : false;
      $nutrition_info = isset( $product_info['0']['nutrition_info']['sizes']['medium'] ) ? $product_info['0']['nutrition_info']['sizes']['medium'] : false;
      $storage = isset( $product_info['0']['storage'] ) ? $product_info['0']['storage'] : false;



      ?>
    <div class="section product-info <?php echo $do_not_translate; ?>">
        <div class="row">
          <div class="col s12 m4 l4 info">
            <h2 class="tiny font-sans">Characteristics</h2>
            <p><?php echo $characteristics ;?></p>
            <br/><br/>
            <h2 class="tiny font-sans">Flavour &amp; Texture</h2>
            <p><?php echo $flavour ;?></p>
          </div>
          <div class="col s12 m4 l4 info">
            <h2 class="tiny font-sans">Nutrition</h2>
            <?php echo $nutrition ;?>

            <?php if ( $nutrition_info ) { ?>
              <a class="uppercase text-red underline modal-trigger font-sans" href="#nutrition-info">
                Full nutrition info
              </a>

              <!-- Modal Structure -->
              <div id="nutrition-info" class="modal">
                <div class="modal-content">
                  <img class="responsive-img" src="<?php echo $nutrition_info; ?>" title="Nutrition Info"/>
                </div>
              </div>
            <?php } ?>

          </div>
          <div class="col s12 m4 l4 info">
            <h2 class="tiny font-sans">Storage</h2>
            <?php echo $storage ;?>
          </div>

        </div>
      </div>
    <?php } ?>

    <?php

    cc_do_section_recipe();

    cc_do_section_find_stores();

    endwhile;
    endif;
  ?>

<?php get_footer(); ?>
