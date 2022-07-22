<?php get_header(); ?>

<?php

  if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

  <?php

    cc_do_title_container();

    global $fields;

    $difficulty = isset( $fields['difficulty'] ) ? $fields['difficulty'] : false;
    $ingradient_thumb = isset( $fields['ingradient_thumb']['sizes']['medium'] ) ? $fields['ingradient_thumb']['sizes']['medium'] : false;
    $time = isset( $fields['time'] ) ? $fields['time'] : false;
    $serves = isset( $fields['serves'] ) ? $fields['serves'] : false;
    $pdf = isset( $fields['pdf'] ) ? $fields['pdf'] : false;
    $ingradients = isset( $fields['ingradients'] ) ? $fields['ingradients'] : false;
    $instructions = isset( $fields['instructions'] ) ? $fields['instructions'] : false;

    $timestamp = strtotime( date( 'Y-m-d') . ' ' . $time );
    $time_iso = 'PT' .  date( 'G',  $timestamp ) . 'H' . date( 'i',  $timestamp ) . 'M';

    ?>

    <div class="section section-anchors full-width no-margin <?php echo ( get_the_ID() != 721 ) ? 'dont-translate' : ''; ?>">

      <div class="section-inner">

        <div class="row">
          <div class="col s12 m7 l8">

            <?php if ( $difficulty ) { ?>
              <div class="recipe-meta inline-block uppercase">
                Difficulty: <span class=""><?php echo $difficulty; ?></span>
              </div>
            <?php } ?>

            <?php if ( $time ) { ?>
              <div class="recipe-meta inline-block uppercase">
                Time: <span class="uppercase"><?php echo $time; ?></span>

              </div>
            <?php } ?>

            <?php if ( $serves ) { ?>
              <div class="recipe-meta inline-block uppercase">
                <div class="serves">
                    Serves: <span class="uppercase"><?php echo $serves; ?></span>
                </div>
                <div class="reversed-serves" style="display:none;">
                    <span class="uppercase"><?php echo $serves; ?></span> Serves
                </div>
              </div>
            <?php } ?>

          </div>
          <div class="col s12 m5 l4 print-hide">
            <div class="inline-block">
              <?php if ( $pdf ) { ?>

                <a href="<?php echo $pdf; ?>" target="_blank" class="btn btn-mini white-text waves-effect waves-light uppercase">
                  Download Recipe
                </a>
              <?php } else { ?>
              <button onclick="javascript:window.print();" class="btn btn-mini white-text waves-effect waves-light uppercase">
                Print Recipe
              </button>
              <?php } ?>
            </div>
            <div class="inline-block share">
              <div class="a2a_kit a2a_kit_size_32 a2a_default_style">
                <a class="a2a_button_pinterest a2a_counter"></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="section section-recipe  <?php echo ( get_the_ID() != 721 ) ? 'dont-translate' : ''; ?>" itemscope itemtype="https://schema.org/Recipe">
      <meta itemprop="image" content="<?php the_post_thumbnail_url( 'medium' ); ?>" />
      <meta itemprop="name" content="<?php the_title(); ?>" />
      <meta itemprop="totalTime" content="<?php echo $time_iso; ?>" />

      <div class="row">
        <div class="col s12 m4 l3 side">
          <?php if ( $ingradients ) {

            foreach ( $ingradients as $key => $ingradient ) {

              $title = isset( $ingradient['title'] ) ? $ingradient['title'] : 'Ingredients';
              $sub_items = isset( $ingradient['ingredients'] ) ? $ingradient['ingredients'] : false;
              $sub_items = str_replace( '<li', '<li itemprop="recipeIngredient"', $sub_items );
              ?>
              <h2 class="medium bold"><?php echo $title; ?></h2>

              <div class="ingredients font-serif">
                <?php echo $sub_items; ?>
              </div>

              <?php


            }
          }

        ?>

        <div class="ingredient-thumb">
          <img class="responsive-img" src="<?php echo $ingradient_thumb; ?>" title="ingredient" />
        </div>

        </div>
        <div class="col s12 m8 l9 main">
          <div class="des" itemprop="description">
            <?php the_content(); ?>
          </div>

          <?php
            if ( $instructions ) {

              echo '<h2>Instructions</h2>';

              foreach ( $instructions as $key => $instruction ) {

                $title = isset( $instruction['title'] ) ? $instruction['title'] : false;
                $sub_items = isset( $instruction['instructions'] ) ? $instruction['instructions'] : false;

                ?>
                <h3 class="medium bold"><?php echo $title; ?></h3>

                <div class="ingredients font-serif" itemprop="recipeInstructions" itemscope itemtype="https://schema.org/ItemList">
                  <?php echo $sub_items; ?>
                </div>

                <?php

              }
            }
          ?>

          <?php get_author_block(); ?>

        </div>
      </div>
    </div><!-- section recipe -->

    <?php

      $cat = get_query_var('cat', null);

      $related = get_posts( array(

        'posts_per_page' => '3',
        'orderby' => 'rand',
        'post_type' => 'recipes',
        'cat' => 'cat',
        'post__not_in' => array( get_the_ID() ),
      ));


      if ( $related ) {
        ?>
        <div class="section section-related section-grid">
          <div class="row">

            <div class="col s12 m12 l12 center">
              <hr />
              <h3 class="small">Related Recipes</h3>
            </div>

            <?php get_posts_grid( $related ); ?>
          </div>
        </div>
        <?php
      }
    ?>

  <?php

    endwhile;
    endif;
  ?>

<?php



?>
<?php get_footer(); ?>
