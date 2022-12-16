<?php

add_action('after_switch_theme', 'flush_rewrite_rules');
add_action('switch_theme', 'flush_rewrite_rules');


function custom_rewrite_basic() {
  add_rewrite_rule('^author/(.+?)/page/([0-9]+)/?', 'index.php?author_name=$matches[1]&page=$matches[2]', 'top');
  add_rewrite_rule('^category/(.+?)/page/([0-9]+)/?', 'index.php?category_name=$matches[1]&paged=$matches[2]', 'top');
  add_rewrite_rule('^category/(.+?)/paged/([0-9]+)/?', 'index.php?category_name=$matches[1]&paged=$matches[2]', 'top');
  //add_rewrite_rule('^windset-living/page/([0-9]+)/?', 'index.php?pagename=windset-living&page=$matches[1]', 'top');
  //add_rewrite_rule('^windset-living/paged/([0-9]+)/?', 'index.php?pagename=windset-living&page=$matches[1]', 'top');
  add_rewrite_rule('^recipes/page/([0-9]+)/?', 'index.php?pagename=recipes&page=$matches[1]', 'top');
  add_rewrite_rule('^recipes/paged/([0-9]+)/?', 'index.php?pagename=recipes&page=$matches[1]', 'top');
}
add_action('init', 'custom_rewrite_basic');


function redirect_product_cat_archive_to_page_by_slug( $page_slug = 'our-produce' ) {

  if ( $page_slug ) {

    $cat = get_query_var('cat');
    $product_cat = get_category_by_slug( 'products' )->term_id;

    if ( cat_is_ancestor_of( $product_cat , $cat ) || is_post_type_archive( 'products' ) ) {

      //redirect to our-produce#category-slug
      $cat_object = get_category( $cat );
      $cat_slug = $cat_object->slug;
      $url = get_permalink( get_page_by_path( 'our-produce') );
      $url .= '#' . $cat_slug;

      wp_redirect( $url );

      exit;

    }

  }

}


function get_posts_grid( $posts = null, $has_feeds = false, $current_page = 1 ) {

  if ( $posts ) {

    foreach ( $posts as $key => $post ) {

      if ( !$post->ID ) {
        continue;
      }

      $post_id = $post->ID;
      $title = $post->post_title;
      $post_type = $post->post_type;
      $img = get_the_post_thumbnail( $post_id, 'medium' );
      $img_url = get_the_post_thumbnail_url( $post_id, 'large' );
      $url = get_permalink( $post_id );
      $prod_cat = get_category_by_slug( 'products' );
      $thumb_setting = get_field( 'set_as_thumbnail', $post_id );
      $thumb_setting = get_field( 'set_as_thumbnail', $post_id );
      $display_as_image_block = get_field( 'display_as_image_block', $post_id );

      $use_thumb = true;
      $prod_cat_id = isset( $prod_cat->term_id ) ? $prod_cat->term_id : false;
      $cats = get_the_category( $post_id );
      $category = 'Windset';
      $cat_class = '';
      $cat_url = '';

      if ( $prod_cat_id ) {

        foreach( $cats as $index => $this_cat ) {

          $cat_url = '';
          //if the category parent is not a product category and this category is not a parent category
          if ( $this_cat->parent !== $prod_cat_id && $this_cat->parent !== 0 ) {

            $category = isset( $this_cat->name ) ? $this_cat->name : '';
            $cat_class = isset( $this_cat->slug ) ? 'bg-' . $this_cat->slug : '';
            $cat_class .= ' bg-' . $post_type;
            $cat_url = get_category_link( $this_cat->term_id );
          }
        }
      }

      if ( strlen( $category ) == 0 ) {
        $category = isset( $cats['0']->name ) ? $cats['0']->name : '';
      }

      setup_postdata( $post );
      $no_thumb = '';

      if ( !$img || ( $post_type == 'post' && $thumb_setting !== 'Featured Image' ) ) {
        $no_thumb = 'no-thumb';
        $use_thumb = false;
      }

      $legacy_feed_on = false;


      if( $legacy_feed_on && $has_feeds && $current_page <= 1 ) {
        /**
         *
         *
         *
         * Twitter
         *
         *
         *
         */
        if( $key == 0 ){
          ?>
          <div class="col s12 m6 l4 grid-col">
            <div class="grid-post">
              <div style="position:relative;">
                <div class="widget-feeder-header">
                  <a href="https://twitter.com/windsetfarms" class="btn-link-to-social-media btn-link-black" target="_blank">Tweets</a>
                </div>
				<div style="padding-left: 15px;">
	                <?php echo do_shortcode('[fts_twitter twitter_name=windsetfarms twitter_height=320px tweets_count=6 cover_photo=no stats_bar=yes show_retweets=no show_replies=no]'); ?>
				</div>
              </div>

            </div>
          </div>
      <?php
        }
        /**
         *
         *
         *
         * Instagram
         *
         *
         *
         */
        if( $key == 1 ){
      ?>
          <div class="col s12 m6 l4 grid-col">
            <div class="grid-post">
              <div style="position:relative;">
                <?php echo do_shortcode('[fts_instagram instagram_id=17841400425829031 access_token=IGQVJYZAGxlYU83MmpYTlFYdXFkQ3JUamFPMXMxMFZAKV0hEM3hfNkVjTlpIYTlJeVJUbWtPeElPMDhnY0tLS2hublIzakgwNE1FMjdlWkdHWXZAGc045V0tGeEgxM0pIX2tCb1ZAmQVRR pics_count=1 type=basic super_gallery=yes columns=3 force_columns=no space_between_photos=1px icon_size=65px hide_date_likes_comments=no]'); ?>
                <div class="widget-feeder-header widget-feeder-header-absolute">
                  <img class="widget-feeder-icon" src="<?php echo get_template_directory_uri(); ?>/img/widget-feeder-header.jpg">
                  Windsetfarms » <a href="https://www.instagram.com/windsetfarms" class="btn-link-to-social-media btn-link-blue" target="_blank">Follow</a>
                </div>
              </div>

            </div>
          </div>
      <?php
        }
      }
      ?>

      <?php if( !$display_as_image_block ) { ?>
      <div class="col s12 m6 l4 grid-col">
        <div class="grid-post <?php echo $no_thumb; ?>">

          <a href="<?php echo $cat_url; ?>" class="category <?php echo $cat_class; ?>">
            <?php echo $category; ?>
          </a>

          <a href="<?php echo $url; ?>">

            <?php if ( $use_thumb ) { ?>

            <div class="post-thumb">
              <?php echo $img; ?>
            </div>
            <div class="post-title">
              <?php echo $title;?>
            </div>

            <?php } else { ?>

              <div class="post-title">
                <?php echo $title;?>
              </div>
              <div class="post-excerpt font-serif">
                <?php echo get_the_excerpt($post_id);?>
              </div>

            <?php } ?>

          </a>
        </div>
      </div>
      <?php } else { ?>

        <div class="col s12 m6 l4 grid-col">
          <a href="<?php echo $url; ?>">
            <div class="grid-post" style="background-image: url(<?php echo $img_url; ?>); background-size: cover; background-position: center center">

            </div>
          </a>
        </div>

      <?php } ?>
      <?php
    }
    wp_reset_postdata();
  }



}

function get_archive_filters() {

  $query_cat = get_query_var( 'cat', false );

  $product_cat = get_category_by_slug( 'recipes' );
  $product_cat_id = isset( $product_cat->term_id ) ? $product_cat->term_id : false;
  $recipes_cats = get_terms( array(
    'taxonomy' => 'category',
    'child_of' => $product_cat_id,
    'hide_empty' => true,
  ));
  $recipe_cat_url = get_term_link( $product_cat );

  $blog_cat = get_category_by_slug( 'blog' );
  $blog_cat_id = isset( $blog_cat->term_id ) ? $blog_cat->term_id : false;
  $blog_cats = get_terms( array(
    'taxonomy' => 'category',
    'child_of' => $blog_cat_id,
    'hide_empty' => true,
  ));
  $blog_cat_url = get_term_link( $blog_cat );

  ?>
  <div class="row">
    <div class="col s12 m12 l12 center cat-filter">
      <span class="label uppercase">FILTER BY:</span>

      <select class="browser-default" onchange="if (this.value) window.location.href=this.value">
        <option value="<?php echo $recipe_cat_url; ?>">All Recipes</option>
        <?php foreach ( $recipes_cats as $i => $r_cat ) {

          $selected = '';

          if ( $r_cat->term_id == $query_cat )
            $selected = 'selected="selected"';

          $cat_name = isset( $r_cat->name ) ? $r_cat->name : false;

          $cat_name = str_replace( 'Recipe', 'Recipes', $cat_name );
          $url = get_term_link( $r_cat );

          ?>
          <option value="<?php echo $url; ?>" <?php echo $selected; ?>><?php echo $cat_name; ?></option>
        <?php } ?>
      </select>

      <select class="browser-default" onchange="if (this.value) window.location.href=this.value">
        <option value="<?php echo $blog_cat_url; ?>">All Posts</option>
        <?php foreach ( $blog_cats as $i => $blog_cat ) {

          $selected = '';

          if ( $blog_cat->term_id == $query_cat )
            $selected = 'selected="selected"';

          $cat_name = isset( $blog_cat->name ) ? $blog_cat->name : false;
          $url = get_term_link( $blog_cat );

          ?>
          <option value="<?php echo $url; ?>" <?php echo $selected; ?>><?php echo $cat_name; ?></option>
        <?php } ?>
      </select>

     </div>
   </div>
  <?php
}
?>
