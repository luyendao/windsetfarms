<?php

function get_author_block() {

  global $post;

  $created_by = 'Blog Post By';

  if ( $post->post_type == 'recipes' ) {
    $created_by = 'Recipe Created By';
  }

  ?>
  <div class="chef section-author">
    <div class="row">
      <div class="col s12 m5 l3">
        <?php
          $user_id = get_the_author_meta('ID');
          $user_info = get_userdata( $user_id );

          $username = $user_info->user_login;
          $metas = get_user_meta( $user_id );

          $name = isset( $metas['nickname']['0'] ) ? $metas['nickname']['0']  : false;
          $twitter = isset( $metas['twitter']['0'] ) ? $metas['twitter']['0']  : false;
          $facebook = isset( $metas['facebook']['0']  ) ? $metas['facebook']['0']  : false;
          $brief_bio = isset( $metas['brief_bio']['0']  ) ? $metas['brief_bio']['0']  : false;
          $title = isset( $metas['title']['0']  ) ? $metas['title']['0']  : false;
          $twitter_name = preg_replace("/(https*:\/\/(.*)twitter.com\/)/i", "", $twitter);

          $avatar =  get_avatar( $user_id, '512' );
          $author_link = site_url() . '/in-the-kitchen/#' . $username;
        ?>
        <div class="thumb">
          <a href="<?php echo $author_link; ?>">
            <?php echo $avatar; ?>
          </a>
        </div>
      </div>
      <div class="col s12 m7 l9 bio">
        <h4><?php echo $created_by; ?></h4>
        <div class="author">
          <a href="<?php echo $author_link; ?>" itemprop="author">
            <?php echo $name; ?>
          </a>
        </div>
        <div class="des">
          <?php echo $brief_bio; ?>
        </div>
        <div class="follow">
          <div class="a2a_kit a2a_default_style a2a_follow">
            <?php if ( $facebook ) { ?>
              <a class="a2a_button_facebook" href="<?php echo $facebook; ?>">Follow</a>
            <?php } ?>
            <?php if ( $twitter ) { ?>
              <a class="a2a_button_twitter" href="<?php echo $twitter; ?>">Follow @<?php echo $twitter_name; ?></a>
            <?php } ?>
          </div>

        </div>
      </div>
    </div>
  </div><!--chef-->
  <?php
}


function get_category_label( $post_type = null ) {

  $cats = get_the_category();

  if ( !$post_type )
    $post_type = get_post_type();

  foreach ( $cats as $i => $cat ) {
    if ( $cat->parent == 0 ) {
      unset( $cats[$i] );
    }
  }
  $cats = array_values( $cats );

  if ( isset( $cats['0'] ) ) {

    $this_cat = $cats['0'];
    $name = $this_cat->name;
    $url = get_term_link( $this_cat );
    ?>
    <a href="<?php echo $url; ?>">
      <div class="bg-<?php echo $post_type;?> cat-label inline-block">
        <?php echo $name; ?>
      </div>
    </a>
    <?php
  }


}


function contact_form_7_placeholders ( $form_html ) {

  $name = 'name="your-name"';
  $email = 'name="your-email"';

  $form_html = str_replace( $name, $name . ' placeholder="Your Name"', $form_html );
  $form_html = str_replace( $email, $email . ' placeholder="youremail@mail.com"', $form_html );

  return $form_html;
}

add_filter( 'the_content', 'add_placeholder_for_contact', 100 );

function add_placeholder_for_contact( $content ) {

   if ( is_page('talk-to-us') ) {

     $content = contact_form_7_placeholders( $content );

   }

   return $content;
}

?>
