<?php

function cc_do_section_recipe( $args = null ) {
  global $fields;
  $field_data = array();

  // 1. Logic to fetch recipe IDs
  if ( isset( $fields['windset_recipes'] ) ) {
    $field_data = $fields['windset_recipes'];
  } else {
    $prod_cat = get_category_by_slug( 'products' );
    $prod_cat_id = isset( $prod_cat->term_id ) ? $prod_cat->term_id : false;
    $cats = get_the_category( get_the_ID() );
    $cat = '';

    if ( $cats && $prod_cat_id ) {
      foreach( $cats as $index => $this_cat ) {
        if ( $this_cat->parent == $prod_cat_id ) {
          $cat = isset( $this_cat->term_id ) ? $this_cat->term_id : false;
        }
      }
    }

    $query_args = array(
      'post_type'      => 'recipes',
      'posts_per_page' => 3,
      'orderby'        => 'rand',
      'fields'         => 'ids',
    );

    if ( $cat ) {
      $query_args['cat'] = $cat;
    }

    $field_data = get_posts( $query_args );
  }

  // 2. Normalize $field_data
  if ( empty( $field_data ) ) {
    $field_data = array();
  } elseif ( is_object( $field_data ) && isset( $field_data->ID ) ) {
    $field_data = array( $field_data->ID );
  } elseif ( is_numeric( $field_data ) ) {
    $field_data = array( absint( $field_data ) );
  } elseif ( is_string( $field_data ) ) {
    $parts = preg_split( '/[,\s]+/', $field_data );
    $field_data = array_values( array_filter( array_map( 'absint', (array) $parts ) ) );
  } elseif ( ! is_array( $field_data ) ) {
    $field_data = array();
  }

  if ( ! empty( $field_data ) ) {
    ?>
    <div class="section section-recipe-grid">
      <div class="row">
      <?php
        foreach ( $field_data as $key => $recipe ) {
          // Resolve the ID and fetch the specific post object
          $recipe_id = ( is_object( $recipe ) && isset( $recipe->ID ) ) ? $recipe->ID : absint( $recipe );
          $post_obj  = get_post( $recipe_id );

          if ( ! $post_obj ) {
            continue;
          }

          // Use ID-specific functions to prevent "Main Loop" link hijacking
          $title   = get_the_title( $recipe_id );
          $url     = get_permalink( $recipe_id );
          $excerpt = $post_obj->post_excerpt;

          if ( empty( $excerpt ) ) {
            $excerpt = wp_trim_words( $post_obj->post_content, 55 );
          }

          $img = cc_get_recipe_thumb( array(
            'post_id' => $recipe_id,
            'title'   => $title,
          ));

          // FIRST RECIPE (Feature)
          if ( $key == 0 ) {
            $main_img = cc_get_featured_img( array(
              'post_id' => $recipe_id,
              'size'    => 'large',
              'return'  => 'url'
            ));
            ?>
            <div class="col s12 m12 l12 main" style="background-image: url(<?php echo esc_url($main_img); ?>);">
               <a href="<?php echo esc_url($url); ?>" class="full-block"></a>
            </div>
            
            <div class="col s12 m6 l6 side right">
              <div class="upper">
                <h2 class="section-title font-script text-red">Windset Recipes</h2>
                <h3 class="recipe-title main">
                  <a href="<?php echo esc_url($url); ?>"><?php echo esc_html($title); ?></a>
                </h3>
                <div class="des font-serif"><?php echo wp_kses_post($excerpt); ?></div>
                <a href="<?php echo esc_url($url); ?>" class="btn btn-mini uppercase">View Recipe</a>
                <br/><br/>
              </div>

              <div class="lower">
                <h3>Other Great Windset Recipes</h3>
                <div class="row center">
            <?php
          } else {
            // SECOND & THIRD RECIPES (Thumbs)
            ?>
            <div class="col s12 m6 l6 center">
              <a href="<?php echo esc_url($url); ?>" title="<?php echo esc_attr($title); ?>">
                <div class="recipe-thumb">
                  <div class="frame"></div>
                  <?php echo $img; // Expected to return HTML ?>
                </div>
                <div class="recipe-title"><?php echo esc_html($title); ?></div>
              </a>
            </div>
            <?php
          }

          // Close side wrappers if this is the last item or the 3rd item
          if ( $key == 2 || $key + 1 == count( $field_data ) ) {
            ?>
                </div></div></div><?php
          }
        }
      ?>
      </div>
    </div>
    <?php
  }
}
add_shortcode('_windset_recipes_acf', 'cc_do_section_recipe');


function product_info_modal_shortcode() {
    global $fields;

    $product_info   = isset($fields['product_info']) ? $fields['product_info'] : false;
    $nutrition_info = isset($product_info[0]['nutrition_info']['sizes']['medium']) 
                        ? $product_info[0]['nutrition_info']['sizes']['medium'] 
                        : false;

    if (!$nutrition_info) {
        return '';
    }

    ob_start(); ?>
    <a class="uppercase text-red underline modal-trigger font-sans" href="#nutrition-info">
      Full nutrition info
    </a>

    <div id="nutrition-info" class="modal">
        <div class="modal-content">
            <img class="responsive-img" src="<?php echo esc_url($nutrition_info); ?>" alt="Nutrition Info" />
        </div>
    </div>
    <?php 
    return ob_get_clean();
}
add_shortcode('nutrition_info_modal', 'product_info_modal_shortcode');


/* ==========================================================
 * NEW HOMEPAGE – recipe cards (fork of cc_do_section_recipe)
 * Same recipe selection as the original, new 3-card layout
 * that reuses the archive card classes (.section-grid .grid-post)
 * so the category ribbon colours in main.css still apply.
 * ========================================================== */

/**
 * Recipe IDs for the homepage: the ACF "Windset Recipes" field,
 * or 3 random recipes (matching the post's product category if it has one).
 */
function cc_get_home_recipe_ids( $limit = 3 ) {
  global $fields;

  $ids = array();

  if ( ! empty( $fields['windset_recipes'] ) ) {
    $ids = $fields['windset_recipes'];
  } else {
    $query_args = array(
      'post_type'      => 'recipes',
      'posts_per_page' => $limit,
      'orderby'        => 'rand',
      'fields'         => 'ids',
    );

    $prod_cat    = get_category_by_slug( 'products' );
    $prod_cat_id = isset( $prod_cat->term_id ) ? $prod_cat->term_id : false;
    $cats        = get_the_category( get_the_ID() );

    if ( $cats && $prod_cat_id ) {
      foreach ( $cats as $this_cat ) {
        if ( $this_cat->parent == $prod_cat_id ) {
          $query_args['cat'] = $this_cat->term_id;
        }
      }
    }

    $ids = get_posts( $query_args );
  }

  // Normalise: relationship fields can return objects, IDs or a single value
  $ids = is_array( $ids ) ? $ids : array( $ids );
  $ids = array_map( function ( $r ) {
    return ( is_object( $r ) && isset( $r->ID ) ) ? $r->ID : absint( $r );
  }, $ids );

  return array_slice( array_values( array_filter( $ids ) ), 0, $limit );
}

/**
 * Output the 3 recipe cards (image, course ribbon, Recipe Series badge, title)
 */
function cc_do_home_recipe_cards( $limit = 3 ) {

  $recipe_ids = cc_get_home_recipe_ids( $limit );

  if ( empty( $recipe_ids ) ) {
    return;
  }

  $recipes_parent = get_category_by_slug( 'recipes' );
  $recipes_parent = isset( $recipes_parent->term_id ) ? $recipes_parent->term_id : 0;
  $series_slug    = 'recipe-series';
  $series_badge   = get_template_directory_uri() . '/img/recipe-series.jpg';
  // Course categories under "Recipes" (appetizer, entree, sides…) – the "-recipe" product ones are skipped
  ?>
  <div class="ws-home-recipes__cards section-grid">
    <div class="row">
      <?php foreach ( $recipe_ids as $recipe_id ) {

        if ( get_post_status( $recipe_id ) !== 'publish' ) {
          continue;
        }

        $title  = get_the_title( $recipe_id );
        $url    = get_permalink( $recipe_id );
        $img    = get_the_post_thumbnail( $recipe_id, 'medium_large', array( 'loading' => 'lazy' ) );
        $cats   = get_the_category( $recipe_id );
        $course = false;
        $series = false;

        foreach ( $cats as $cat ) {
          if ( $cat->slug === $series_slug ) {
            $series = $cat;
          } elseif ( ! $course && $cat->parent == $recipes_parent && substr( $cat->slug, -7 ) !== '-recipe' ) {
            $course = $cat;
          }
        }
        ?>
        <div class="col s12 m4 l4">
          <div class="grid-post ws-recipe-card">

            <?php if ( $course || $series ) { ?>
              <div class="category-wrapper">
                <?php if ( $course ) { ?>
                  <a href="<?php echo esc_url( get_category_link( $course->term_id ) ); ?>" class="category bg-<?php echo esc_attr( $course->slug ); ?>">
                    <?php echo esc_html( $course->name ); ?>
                  </a>
                <?php } ?>
                <?php if ( $series ) { ?>
                  <a href="<?php echo esc_url( get_category_link( $series->term_id ) ); ?>" class="category recipe-series">
                    <img src="<?php echo esc_url( $series_badge ); ?>" alt="<?php echo esc_attr( $series->name ); ?>" width="130" height="93">
                  </a>
                <?php } ?>
              </div>
            <?php } ?>

            <a href="<?php echo esc_url( $url ); ?>">
              <div class="post-thumb"><?php echo $img; ?></div>
              <div class="post-title"><?php echo esc_html( $title ); ?></div>
            </a>

          </div>
        </div>
      <?php } ?>
    </div>
  </div>
  <?php
}
