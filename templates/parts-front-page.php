<?php

/**
 * @param bool $show_heading  false = output only the product grid + button (heading supplied by the caller)
 */
function cc_do_product_grid( $show_heading = true ) {

  global $fields;

  $products_title = isset( $fields['products_title'] ) ? $fields['products_title'] : false;
  $products_subtitle = isset( $fields['products_subtitle'] ) ? $fields['products_subtitle'] : false;
  $product_cats = isset( $fields['product_cats'] ) ? $fields['product_cats'] : false;

  if ( $products_title || ! $show_heading ) {


    ?>
    <div class="section section-product-grid">

      <?php if ( $show_heading ) { ?>
      <h2 class="center uppercase"><?php echo $products_title; ?></h2>
      <?php } ?>

      <?php if ( $show_heading && $products_subtitle ) { ?>
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


/* ==========================================================
 * NEW HOMEPAGE (2026)
 * Styles: css/home.css (enqueued on the front page in functions.php)
 * ========================================================== */

// Temporary: YouTube link for the intro video embed
define( 'WS_HOME_VIDEO_URL', 'https://www.youtube.com/watch?v=hFCOXcIPJQY' );

/**
 * Section 1 – Hero: self-hosted looping, muted background video (full width, 700px tall)
 * Swap the placeholder files in /video/ for the final footage.
 */
function cc_do_home_hero() {

  $video_dir = get_template_directory_uri() . '/video/';
  $video_mp4 = $video_dir . 'hero-placeholder.mp4';
  $poster    = $video_dir . 'hero-placeholder.jpg';
  ?>
  <section class="ws-home-hero">
    <video class="ws-home-hero__video"
      autoplay muted loop playsinline preload="auto"
      poster="<?php echo esc_url( $poster ); ?>"
      aria-hidden="true">
      <source src="<?php echo esc_url( $video_mp4 ); ?>" type="video/mp4">
    </video>
  </section>
  <?php
}

/**
 * Homepage ACF helpers
 */

// Get a Homepage ACF field from the global $fields (set in theme-functions.php), with a fallback
function cc_home_field( $name, $fallback = '' ) {
  global $fields;
  $value = isset( $fields[ $name ] ) ? $fields[ $name ] : '';
  return ( is_string( $value ) && trim( $value ) !== '' ) ? $value : $fallback;
}

// Heading text: allows <br> for manual line breaks and superscripts ® / ™
function cc_home_format_title( $text ) {
  return wp_kses( cc_home_sup_marks( $text ), array( 'br' => array(), 'sup' => array() ) );
}

// Wrap ® / ™ in <sup> (single pass, skipped if the editor already added <sup>)
function cc_home_sup_marks( $text ) {
  if ( stripos( $text, '<sup' ) !== false ) {
    return $text;
  }
  $text = preg_replace( '/(®|&reg;|&#174;)/u', '<sup>&reg;</sup>', $text );
  return preg_replace( '/(™|&trade;|&#8482;)/u', '<sup>&trade;</sup>', $text );
}

// Textarea copy (ACF "Automatically add paragraphs" is on, so it arrives wrapped in <p>)
function cc_home_format_copy( $text ) {
  if ( stripos( $text, '<p' ) === false ) {
    $text = wpautop( $text );
  }
  return wp_kses_post( cc_home_sup_marks( $text ) );
}

// ACF image field (array, ID or URL return) → array( url, width, height, alt, caption ), with a fallback URL
function cc_home_image( $name, $fallback_url = '', $size = 'full' ) {
  global $fields;
  $img = isset( $fields[ $name ] ) ? $fields[ $name ] : false;
  $out = array( 'url' => $fallback_url, 'width' => '', 'height' => '', 'alt' => '', 'caption' => '' );

  if ( is_numeric( $img ) ) {
    $img = function_exists( 'acf_get_attachment' ) ? acf_get_attachment( $img ) : false;
  }

  if ( is_array( $img ) && ! empty( $img['url'] ) ) {
    $use_size = ( $size !== 'full' && ! empty( $img['sizes'][ $size ] ) );
    $out['url']     = $use_size ? $img['sizes'][ $size ] : $img['url'];
    $out['width']   = $use_size ? $img['sizes'][ $size . '-width' ]  : ( isset( $img['width'] ) ? $img['width'] : '' );
    $out['height']  = $use_size ? $img['sizes'][ $size . '-height' ] : ( isset( $img['height'] ) ? $img['height'] : '' );
    $out['alt']     = isset( $img['alt'] ) ? $img['alt'] : '';
    $out['caption'] = isset( $img['caption'] ) ? $img['caption'] : '';
  } elseif ( is_string( $img ) && $img !== '' ) {
    $out['url'] = $img;
  }

  return $out;
}

/**
 * Section 2 – Intro: heading, copy, embedded video, Learn More button
 */
function cc_do_home_intro( $video_url = WS_HOME_VIDEO_URL ) {

  // ACF: Homepage > Heading Title / Heading Subtitle (fallbacks = current design copy)
  $title    = cc_home_field( 'heading_title', 'Your Friends<br> in Freshness&reg;' );
  $copy     = cc_home_field( 'heading_subtitle', "Founded in 1996, Windset Farms is one of North America's leading greenhouse vegetable growers with a vision to grow sustainable food for our planet, every day of the year." );
  $btn_url  = cc_home_field( 'heading_learn_more_link', '#' );
  $btn_text = 'Learn More';

  $video_id = get_video_id( $video_url );
  ?>
  <section class="ws-home-intro">
    <div class="ws-home-intro__inner">

      <h1 class="ws-home-intro__title"><?php echo cc_home_format_title( $title ); ?></h1>

      <div class="ws-home-intro__copy"><?php echo cc_home_format_copy( $copy ); ?></div>

      <?php if ( $video_id ) { ?>
        <div class="ws-home-intro__video">
          <iframe
            src="<?php echo esc_url( 'https://www.youtube.com/embed/' . $video_id . '?rel=0&modestbranding=1' ); ?>"
            title="Windset Farms – Your Friends in Freshness"
            frameborder="0"
            loading="lazy"
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
            allowfullscreen></iframe>
        </div>
      <?php } ?>

      <div class="ws-home-intro__cta">
        <a class="btn waves-effect waves-light" href="<?php echo esc_url( $btn_url ); ?>"><?php echo esc_html( $btn_text ); ?></a>
      </div>

    </div>
  </section>
  <?php
}

/**
 * Section 3 – Sustainability: tomato background, heading, founders photo, copy, Learn More
 */
function cc_do_home_sustainability() {

  $img_dir = get_template_directory_uri() . '/img/home/';

  // ACF: Homepage > Sustainability fields (fallbacks = current design content)
  $title    = cc_home_field( 'sustainability_title', 'Innovation Rooted in Sustainability' );
  $bg       = cc_home_image( 'sustainability_background_image', $img_dir . 'sustainability-bg.jpg' );
  $photo    = cc_home_image( 'sustainability_knockout_image', $img_dir . 'newell-brothers.jpg' );
  $subtitle = cc_home_field( 'sustainability_subsection_title', 'Growing great food, better.' );
  $copy     = cc_home_field( 'sustainability_subsection_copy',
    "At Windset Farms&reg;, innovation has always been rooted in sustainability. Our leading-edge greenhouse technology, advanced growing systems and responsible practices help us use our resources more efficiently while growing premium, flavorful vegetables year-round. From water and energy management to crop production and plant health, we&rsquo;re always looking for smarter ways to grow while reducing our environmental impact.\n\n" .
    "But technology is only part of the equation. It&rsquo;s our people &ndash; our family and our team &ndash; who bring these systems to life. With 30 years of experience and a shared passion for growing great food, we combine innovation, knowledge and care to continually improve how we grow. Together, we&rsquo;re looking ahead to a more efficient and sustainable future."
  );

  // Caption: the image's Media Library caption if set, otherwise the design default
  $photo_caption = $photo['caption'] ? $photo['caption'] : 'John &amp; Steven Newell';
  $photo_alt     = $photo['alt'] ? $photo['alt'] : 'John and Steven Newell in a Windset Farms greenhouse';

  $btn_url  = cc_home_field( 'sustainability_subsection_learn_more_link', '#' );
  $btn_text = 'Learn More';
  ?>
  <section class="ws-home-sustain" style="background-image: url(<?php echo esc_url( $bg['url'] ); ?>);">

    <h2 class="ws-home-sustain__title"><?php echo cc_home_format_title( $title ); ?></h2>

    <figure class="ws-home-sustain__photo">
      <img src="<?php echo esc_url( $photo['url'] ); ?>"
        <?php if ( $photo['width'] && $photo['height'] ) { ?>width="<?php echo (int) $photo['width']; ?>" height="<?php echo (int) $photo['height']; ?>"<?php } ?>
        loading="lazy" alt="<?php echo esc_attr( $photo_alt ); ?>">
      <figcaption><?php echo wp_kses( $photo_caption, array() ); ?></figcaption>
    </figure>

    <div class="ws-home-sustain__inner">
      <div class="ws-home-sustain__content">
        <h3 class="ws-home-sustain__subtitle"><?php echo cc_home_format_title( $subtitle ); ?></h3>

        <div class="ws-home-sustain__copy"><?php echo cc_home_format_copy( $copy ); ?></div>

        <a class="btn waves-effect waves-light" href="<?php echo esc_url( $btn_url ); ?>"><?php echo esc_html( $btn_text ); ?></a>
      </div>
    </div>

  </section>
  <?php
}

/**
 * Section 4 – Greenhouse Grown: heading + intro, then the existing ACF product grid
 */
function cc_do_home_products() {

  // ACF: Homepage > Products Title / Products Subtitle (fallbacks = current design copy)
  $title = cc_home_field( 'products_title', 'Greenhouse<br> Grown' );
  $copy  = cc_home_field( 'products_subtitle', 'From our farm to your table, Windset Farms&reg; grows fresh greenhouse grown tomatoes, peppers, cucumbers and specialty greenhouse vegetables.' );
  ?>
  <section class="ws-home-products">
    <div class="ws-home-products__header">
      <h2 class="ws-home-products__title"><?php echo cc_home_format_title( $title ); ?></h2>
      <div class="ws-home-products__copy"><?php echo cc_home_format_copy( $copy ); ?></div>
    </div>

    <?php cc_do_product_grid( false ); ?>
  </section>
  <?php
}

/**
 * Section 5 – Fresh Flavor: heading, copy, Learn More over the food photo, then recipe cards
 */
function cc_do_home_recipes() {

  // ACF: Homepage > Windset Recipes fields (fallbacks = current design content)
  $bg    = cc_home_image( 'windset_background_image', get_template_directory_uri() . '/img/home/fresh-flavor-bg.jpg' );
  $title = cc_home_field( 'windset_recipes_title', 'Fresh Flavor' );
  $copy  = cc_home_field( 'windset_recipes_copy', 'At Windset Farms&reg;, freshness comes first. Explore our delicious and nutritious recipes the whole family will enjoy.' );
  $btn_url  = cc_home_field( 'windset_recipes_learn_more_link', '#' );
  $btn_text = 'Learn More';
  ?>
  <section class="ws-home-recipes">
    <div class="ws-home-recipes__hero" style="background-image: url(<?php echo esc_url( $bg['url'] ); ?>);">
      <div class="ws-home-recipes__header">
        <h2 class="ws-home-recipes__title"><?php echo cc_home_format_title( $title ); ?></h2>
        <div class="ws-home-recipes__copy"><?php echo cc_home_format_copy( $copy ); ?></div>
        <a class="btn waves-effect waves-light" href="<?php echo esc_url( $btn_url ); ?>"><?php echo esc_html( $btn_text ); ?></a>
      </div>
    </div>

    <?php cc_do_home_recipe_cards( 3 ); ?>
  </section>
  <?php
}

/**
 * Section 6 – Get Social: heading, social icons (same ACF options + icons as footer.php), EmbedSocial feed
 */
function cc_do_home_social() {

  $title = 'Get Social';

  $social    = get_field( 'social_media', 'option' );
  $social    = isset( $social['0'] ) ? $social['0'] : array();
  $icon_path = get_template_directory_uri() . '/img/';

  // Same order as the footer
  $networks = array(
    'facebook'  => 'Facebook',
    'instagram' => 'Instagram',
    'linkedin'  => 'LinkedIn',
  );
  ?>
  <section class="ws-home-social">
    <div class="ws-home-social__header">
      <h2 class="ws-home-social__title"><?php echo esc_html( $title ); ?></h2>

      <div class="ws-home-social__icons">
        <?php foreach ( $networks as $key => $label ) {
          if ( empty( $social[ $key ] ) ) {
            continue;
          } ?>
          <a class="social-link" href="<?php echo esc_url( $social[ $key ] ); ?>" target="_blank" rel="noopener">
            <img src="<?php echo esc_url( $icon_path . 'icon-' . $key . '.png' ); ?>" alt="<?php echo esc_attr( 'Windset Farms on ' . $label ); ?>">
          </a>
        <?php } ?>
      </div>
    </div>

    <div class="ws-home-social__feed">
      <div class="embedsocial-hashtag" data-ref="e254f71449e8b30c53f0c0e140f208d8cd6f7cc2"></div>
      <script>
        (function(d, s, id) {
          var js;
          if (d.getElementById(id)) {return;}
          js = d.createElement(s);
          js.id = id;
          js.src = "https://embedsocial.com/cdn/ht.js";
          d.getElementsByTagName("head")[0].appendChild(js);
        }(document, "script", "EmbedSocialHashtagScript"));
      </script>
    </div>
  </section>
  <?php
}

?>
