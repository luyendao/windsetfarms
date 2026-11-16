<?php
/**
 * Festiva™ Cherry Tomato Medley – standalone landing page (/festiva-cherry-tomato-medley/).
 *
 * Replaces the Elementor Canvas version. Intentionally has NO site header/footer.
 * Copy and images are hardcoded (no ACF). Styles: css/festiva-landing.css
 * (enqueued in functions.php for this page only).
 *
 * WordPress uses this file automatically for the page with this slug, as long as
 * the page's Template setting is "Default template" (not "Elementor Canvas").
 */

$up = trailingslashit( content_url( 'uploads' ) );

$recipe = function ( $slug ) {
  $post = get_page_by_path( $slug, OBJECT, 'recipes' );
  return $post ? get_permalink( $post ) : home_url( '/recipe/' . $slug . '/' );
};

$recipes = array(
  array(
    'title' => 'Roasted Tomato<br> Tray Baked Salmon',
    'img'   => '2025/07/WF_Website_Recipe-Series-1440x1080-Roasted-Pepper-Tomato-Salad.jpg',
    'url'   => $recipe( 'roasted-pepper-tomato-tray-baked-salmon' ),
  ),
  array(
    'title' => 'Tomato Goat Cheese<br> Asparagus Salad',
    'img'   => '2016/10/WF_Recipe-1440x1080_Tomato-Asparagus-1440x1080.jpg',
    'url'   => $recipe( 'grilled-asparagus-and-panzanella-salad' ),
  ),
  array(
    'title' => 'Tomato &amp; Kale Salad<br> with Chickpeas',
    'img'   => '2016/10/WF_Recipe-1440x1080_Tomato-Kale-Salad-1440x1080.jpg',
    'url'   => $recipe( 'tomato-and-kale-salad-with-chickpeas' ),
  ),
);

$brand = '<strong>Festiva&trade; Cherry Tomato Medley</strong>';
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php wp_head(); ?>
</head>
<body <?php body_class( 'festiva-landing' ); ?>>
<?php wp_body_open(); ?>

<main class="fl">

  <!-- 1. Hero -->
  <section class="fl-hero" style="background-image: url(<?php echo esc_url( $up . '2026/01/sa-hero-bg.jpg' ); ?>);">
    <div class="fl-inner">
      <div class="fl-hero__top">
        <a class="fl-hero__logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="Windset Farms">
          <img src="<?php echo esc_url( $up . '2026/01/sa-logo.png' ); ?>" alt="Windset Farms" width="297" height="385">
        </a>
        <h1 class="fl-hero__mark">
          <img src="<?php echo esc_url( $up . '2026/01/sa-h1-logomark.png' ); ?>" alt="Festiva™ Cherry Tomato Medley" width="564" height="438">
        </h1>
      </div>

      <div class="fl-hero__body">
        <h2 class="fl-hero__title">
          <img src="<?php echo esc_url( $up . '2026/01/sa-h1-title.png' ); ?>" alt="Vibrant Gems Bursting With Flavor!" width="577" height="192">
        </h2>
        <div class="fl-text">
          <p>Join the flavor festivities with <?php echo $brand; ?>. This exclusive cherry tomato medley features a range of captivating and classic cherry colors that will light up your taste buds with each juicy, sweet bite! Make every day worth celebrating with <?php echo $brand; ?>!</p>
        </div>
        <img class="fl-hero__cutout" src="<?php echo esc_url( $up . '2026/01/sa-cutout2.png' ); ?>" alt="" width="631" height="531" loading="lazy">
      </div>
    </div>
  </section>

  <!-- 2. Quick recipes -->
  <section class="fl-recipes">
    <div class="fl-inner">
      <h2 class="fl-recipes__title">
        <img src="<?php echo esc_url( $up . '2026/01/sa-quick-recipes-title.png' ); ?>" alt="Quick Recipes" width="360" height="71" loading="lazy">
      </h2>
      <div class="fl-recipes__grid">
        <?php foreach ( $recipes as $r ) { ?>
          <a class="fl-recipe" href="<?php echo esc_url( $r['url'] ); ?>">
            <img src="<?php echo esc_url( $up . $r['img'] ); ?>" alt="<?php echo esc_attr( wp_strip_all_tags( str_replace( '<br>', ' ', $r['title'] ) ) ); ?>" loading="lazy">
            <h3><?php echo wp_kses( $r['title'], array( 'br' => array() ) ); ?></h3>
          </a>
        <?php } ?>
      </div>
    </div>
  </section>

  <!-- 3. Packaging / sizes -->
  <section class="fl-sizes" style="background-image: url(<?php echo esc_url( $up . '2026/01/sa-footer-bg-2.jpg' ); ?>);">
    <div class="fl-sizes__intro">
      <div class="fl-text">
        <p>Tiny bursts of sweetness that pack a big wow! Enjoy these vibrant, greenhouse grown <?php echo $brand; ?> showstoppers with spot-on flavor – poppable and sweet!</p>
      </div>
      <img class="fl-sizes__badge" src="<?php echo esc_url( $up . '2026/01/sa-footer-cutout.png' ); ?>" alt="Super Sweet!" width="202" height="174" loading="lazy">
    </div>

    <div class="fl-sizes__cta">
      <h2 class="fl-sizes__title">
        <img src="<?php echo esc_url( $up . '2026/01/sa-footer-title.png' ); ?>" alt="Available in Multiple Sizes!" width="437" height="165" loading="lazy">
      </h2>
      <div class="fl-text">
        <p><?php echo $brand; ?> comes in convenient 1 lb and 1.5 lb packs!</p>
      </div>
      <?php
        $festiva_product = get_page_by_path( 'festiva-cherry-tomato-medley', OBJECT, 'products' );
        $festiva_url     = $festiva_product ? get_permalink( $festiva_product ) : home_url( '/products/festiva-cherry-tomato-medley/' );
      ?>
      <a class="fl-btn" href="<?php echo esc_url( $festiva_url ); ?>">Learn More</a>
    </div>
  </section>

</main>

<?php wp_footer(); ?>
</body>
</html>
