<?php
/**
 * Product "showcase" layout (replaces the Elementor Pro single-product templates
 * used for Aria, Festiva and SNAP).
 *
 * Loaded by single-products.php when the product has a Hero Background Image
 * (ACF: Product > Custom Template Fields). Everything is driven by ACF:
 *   hero_background_image, hero_title_image          → hero
 *   section_background_image, section_title_image    → story section
 *   post content                                     → story copy
 *   recipe_image (+ first of windset_recipes)        → linked recipe photo
 *   award_image                                      → right-column badge (optional)
 *   sash_overlay_image + sash_position               → callout / stripe
 *   product_sizes                                    → Available Sizes
 *   product_info + accent_color                      → info band
 *   windset_recipes                                  → recipe grid (cc_do_section_recipe)
 *
 * Styles: css/product-showcase.css · Image lightbox: js/product-showcase.js
 */

global $fields;

$img = function ( $name, $size = 'full' ) use ( &$fields ) {
  $i = isset( $fields[ $name ] ) ? $fields[ $name ] : false;
  if ( ! is_array( $i ) || empty( $i['url'] ) ) {
    return false;
  }
  $use = ( $size !== 'full' && ! empty( $i['sizes'][ $size ] ) );
  return array(
    'url'    => $use ? $i['sizes'][ $size ] : $i['url'],
    'width'  => $use ? $i['sizes'][ $size . '-width' ] : ( isset( $i['width'] ) ? $i['width'] : '' ),
    'height' => $use ? $i['sizes'][ $size . '-height' ] : ( isset( $i['height'] ) ? $i['height'] : '' ),
    'alt'    => ! empty( $i['alt'] ) ? $i['alt'] : '',
  );
};

$img_tag = function ( $i, $class = '', $alt = '', $lazy = true ) {
  if ( ! $i ) {
    return '';
  }
  return sprintf(
    '<img class="%s" src="%s" alt="%s"%s%s>',
    esc_attr( $class ),
    esc_url( $i['url'] ),
    esc_attr( $i['alt'] ? $i['alt'] : $alt ),
    ( $i['width'] && $i['height'] ) ? sprintf( ' width="%d" height="%d"', $i['width'], $i['height'] ) : '',
    $lazy ? ' loading="lazy"' : ''
  );
};

$title          = get_the_title();
$hero_bg        = $img( 'hero_background_image' );
$hero_title     = $img( 'hero_title_image' );
$section_bg     = $img( 'section_background_image' );
$section_title  = $img( 'section_title_image' );
$recipe_img     = $img( 'recipe_image', 'large' );
$award          = $img( 'award_image' );
$sash           = $img( 'sash_overlay_image' );
$sash_position  = ! empty( $fields['sash_position'] ) ? $fields['sash_position'] : 'recipe_corner';
$accent         = ! empty( $fields['accent_color'] ) ? $fields['accent_color'] : '#d61920';
$sizes          = ! empty( $fields['product_sizes'] ) && is_array( $fields['product_sizes'] ) ? $fields['product_sizes'] : array();
$info           = ! empty( $fields['product_info'][0] ) ? $fields['product_info'][0] : array();
$do_not_translate = has_category( 'organics' ) ? ' dont-translate' : '';

// Recipe photo link: ACF recipe_link, else the first selected Windset Recipe
$recipe_ids = ! empty( $fields['windset_recipes'] ) ? (array) $fields['windset_recipes'] : array();
$first      = ! empty( $fields['recipe_link'] ) ? $fields['recipe_link'] : reset( $recipe_ids );
$first_id   = is_object( $first ) ? $first->ID : absint( $first );
$recipe_url = $first_id ? get_permalink( $first_id ) : '';

$has_aside = $award || ( $sash && $sash_position === 'right_column' );
?>

<div class="ws-product<?php echo $do_not_translate; ?>" style="--ws-accent: <?php echo esc_attr( $accent ); ?>;">

  <!-- Hero -->
  <section class="ws-product__hero"<?php if ( $hero_bg ) { ?> style="background-image: url(<?php echo esc_url( $hero_bg['url'] ); ?>);"<?php } ?>>
    <h1 class="ws-product__hero-title">
      <?php if ( $hero_title ) {
        echo $img_tag( $hero_title, '', $title, false );
      } else {
        echo esc_html( $title );
      } ?>
    </h1>
  </section>

  <!-- Story -->
  <?php
  // Section is at least as tall as its background artwork (shown up to 1440px wide, like the old template)
  $story_style = '';
  if ( $section_bg ) {
    $story_style = 'background-image: url(' . esc_url( $section_bg['url'] ) . ');';
    if ( $section_bg['width'] && $section_bg['height'] ) {
      $story_style .= ' --ws-story-ratio: ' . round( $section_bg['height'] / $section_bg['width'], 4 ) . ';';
    }
  }
  ?>
  <section class="ws-product__story ws-sash--<?php echo esc_attr( $sash_position ); ?>"<?php if ( $story_style ) { ?> style="<?php echo esc_attr( $story_style ); ?>"<?php } ?>>
    <div class="ws-product__inner ws-product__story-grid<?php echo $has_aside ? ' has-aside' : ''; ?>">

      <div class="ws-product__story-main">
        <?php if ( $section_title ) { ?>
          <h2 class="ws-product__section-title"><?php echo $img_tag( $section_title, '', $title ); ?></h2>
        <?php } ?>

        <div class="ws-product__copy font-serif">
          <?php the_content(); ?>
        </div>

        <?php if ( $recipe_img ) { ?>
          <figure class="ws-product__recipe">
            <?php if ( $recipe_url ) { ?><a href="<?php echo esc_url( $recipe_url ); ?>"><?php } ?>
              <?php echo $img_tag( $recipe_img, '', $first_id ? get_the_title( $first_id ) : 'Recipe' ); ?>
            <?php if ( $recipe_url ) { ?></a><?php } ?>
            <?php if ( $sash && $sash_position === 'recipe_corner' ) {
              echo $img_tag( $sash, 'ws-product__sash', '' );
            } ?>
          </figure>
        <?php } ?>
      </div>

      <?php if ( $has_aside ) { ?>
        <aside class="ws-product__story-aside">
          <?php echo $img_tag( $award, 'ws-product__award', 'Award' ); ?>
          <?php if ( $sash && $sash_position === 'right_column' ) {
            echo $img_tag( $sash, 'ws-product__sash', '' );
          } ?>
        </aside>
      <?php } ?>
    </div>

    <?php if ( $sash && $sash_position === 'section_bottom_left' ) {
      echo $img_tag( $sash, 'ws-product__sash ws-product__sash--edge', '' );
    } ?>
  </section>

  <?php if ( $sizes ) { ?>
  <!-- Available sizes -->
  <section class="ws-product__sizes" id="available-sizes">
    <div class="ws-product__inner">
      <h3 class="ws-product__sizes-title">Available Sizes</h3>
      <p class="ws-product__sizes-hint">( Click image to see larger product )</p>

      <div class="ws-product__sizes-grid">
        <?php foreach ( $sizes as $size ) {
          $s_img = ! empty( $size['img'] ) && is_array( $size['img'] ) ? $size['img'] : false;
          if ( ! $s_img ) {
            continue;
          }
          $thumb  = ! empty( $s_img['sizes']['medium_large'] ) ? $s_img['sizes']['medium_large'] : $s_img['url'];
          $weight = isset( $size['weight'] ) ? $size['weight'] : '';
          ?>
          <figure class="ws-product__size">
            <a href="<?php echo esc_url( $s_img['url'] ); ?>" class="js-ws-image-lightbox" aria-label="<?php echo esc_attr( 'View larger: ' . $title . ' ' . $weight ); ?>">
              <img src="<?php echo esc_url( $thumb ); ?>" alt="<?php echo esc_attr( trim( $title . ' ' . $weight ) ); ?>" loading="lazy">
            </a>
            <?php if ( $weight ) { ?><figcaption><?php echo esc_html( $weight ); ?></figcaption><?php } ?>
          </figure>
        <?php } ?>
      </div>
    </div>
  </section>
  <?php } ?>

  <?php if ( $info ) {
    $nutrition_img = ! empty( $info['nutrition_info']['sizes']['medium'] ) ? $info['nutrition_info']['sizes']['medium'] : false;
    ?>
  <!-- Characteristics / Flavour / Nutrition / Storage -->
  <section class="ws-product__info">
    <div class="ws-product__inner ws-product__info-grid">
      <div class="ws-product__info-col">
        <?php if ( ! empty( $info['characteristics'] ) ) { ?>
          <h4>Characteristics</h4>
          <div class="ws-product__info-text"><?php echo wp_kses_post( wpautop( $info['characteristics'] ) ); ?></div>
        <?php } ?>
        <?php if ( ! empty( $info['flavour'] ) ) { ?>
          <h4 class="ws-product__info-spaced">Flavour</h4>
          <div class="ws-product__info-text"><?php echo wp_kses_post( wpautop( $info['flavour'] ) ); ?></div>
        <?php } ?>
      </div>

      <div class="ws-product__info-col">
        <?php if ( ! empty( $info['nutrition'] ) ) { ?>
          <h4>Nutrition</h4>
          <div class="ws-product__info-text"><?php echo wp_kses_post( $info['nutrition'] ); ?></div>
        <?php } ?>
        <?php if ( $nutrition_img ) { ?>
          <a class="uppercase underline modal-trigger font-sans ws-product__nutrition-link" href="#nutrition-info">Full nutrition info</a>
          <div id="nutrition-info" class="modal">
            <div class="modal-content">
              <img class="responsive-img" src="<?php echo esc_url( $nutrition_img ); ?>" alt="<?php echo esc_attr( $title . ' nutrition information' ); ?>">
            </div>
          </div>
        <?php } ?>
      </div>

      <div class="ws-product__info-col">
        <?php if ( ! empty( $info['storage'] ) ) { ?>
          <h4>Storage</h4>
          <div class="ws-product__info-text"><?php echo wp_kses_post( wpautop( $info['storage'] ) ); ?></div>
        <?php } ?>
      </div>
    </div>
  </section>
  <?php } ?>

</div>

<?php
// Recipe grid (same as the old Elementor template's [_windset_recipes_acf] shortcode)
cc_do_section_recipe();
