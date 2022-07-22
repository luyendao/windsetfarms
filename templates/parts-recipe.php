<?php

function cc_do_section_recipe( $args = null ) {

  global $fields;

  $field_data = null;

  if ( is_front_page() ) {

    $field_data = isset( $fields['windset_recipes'] ) ? $fields['windset_recipes'] : $false;

  } else {


    $prod_cat = get_category_by_slug( 'products' );
    $prod_cat_id = isset( $prod_cat->term_id ) ? $prod_cat->term_id : false;
    $cats = get_the_category( get_the_ID() );

    $cat = '';

    if ( $cats && $prod_cat_id ) {

      foreach( $cats as $index => $this_cat ) {
        if ( $this_cat->parent == $prod_cat_id ) {
          $cat = isset( $this_cat->term_id ) ? $this_cat->term_id: false;
        }
      }
    }

    if ( $cat ) {

      $field_data = get_posts( array(
        'post_type' => 'recipes',
        'posts_per_page' => '3',
        'orderby' => 'rand',
        'cat' => $cat,
        'fields' => 'ids',
      ));

    } else {

      $field_data = get_posts( array(
        'post_type' => 'recipes',
        'posts_per_page' => '3',
        'orderby' => 'rand',
        'fields' => 'ids',
      ));

    }
  }

  if ( count( $field_data ) > 0 ) {

    ?>
    <div class="section section-recipe-grid">
      <div class="row">

      <?php
        foreach ( $field_data as $key => $recipe ) {

          setup_postdata( $GLOBALS['post'] = $recipe );

          $title = get_the_title();
          $excerpt = get_the_excerpt();

          if ( strlen( $excerpt ) <= 0 ) {
            $excerpt = wp_trim_words( get_the_content(), $num_words = 55, $more = null );
          }

          $url = get_the_permalink();
          $img = cc_get_recipe_thumb( array(
            'post_id' => $recipe,
            'title' => $title,
          ));

          if ( $key == '0' ) {

            $main_img = cc_get_featured_img( array(
              'post_id' => $recipe,
              'size' => 'large',
              'return' => 'url'
            ));

            ?>
            <div class="col s12 m12 l12 main"
               style="background-image: url(<?php echo $main_img; ?>);"/>
               <a href="<?php echo $url;?>" class="full-block">
               </a>
            </div>
            <div class="col s12 m6 l6 side right">
              <div class="upper">
                <h2 class="section-title font-script text-red">
                  Windset Recipes
                </h2>
                <h3 class="recipe-title main">
                  <a href="<?php echo $url;?>">
                    <?php echo $title; ?>
                  </a>
                </h3>
                <div class="des font-serif">
                  <?php echo $excerpt; ?>
                </div>
                <a href="<?php echo $url;?>" title="" class="btn btn-mini uppercase">
                  View Recipe
                </a>
                <br/><br/>
              </div><!-- end upper -->
              <div class="lower">
                <h3>Other Great Windset Recipes</h3>

                <div class="row center">

                  <?php

                    } else {

                      ?>

                      <div class="col s12 m6 l6 center">
                        <a href="<?php echo $url;?>" title="<?php echo $title;?>">
                          <div class="recipe-thumb">
                            <div class="frame"></div>
                            <?php echo $img; ?>
                          </div>
                          <div class="recipe-title">
                            <?php echo $title;?>
                          </div>
                        </a>
                      </div>

                      <?php

                    }



                    if ( $key == '2' || $key + 1 == count( $field_data ) ) {
                    ?>
                    </div><!--end row-->
                  </div><!-- end lower -->
                </div><!-- end side-->
              </div><!-- end main -->
            <?php
          }
          wp_reset_postdata();
        }
      ?>
      </div>
    </div>

    <?php
  }


}

?>
