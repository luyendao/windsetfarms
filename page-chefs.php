<?php /* Template Name: Chefs */ ?>
<?php get_header(); ?>

<?php

  if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

  <?php

    cc_do_title_container();


    global $fields;

    $chefs = isset ( $fields['chefs'] ) ? $fields['chefs'] : false;

  ?>

  <?php 
    get_page_tabs();
  ?>

  <div class="section section-chefs">
    <div class="row">
      <div class="col s12 m12 l12">

        <?php
          if ( $chefs ) {

            foreach ( $chefs as $key => $chef ) {

              $user_id = isset( $chef['ID'] ) ? $chef['ID'] : false;
              $meta = get_user_meta( $user_id );


              $user_info = get_userdata( $user_id );
              $username = $user_info->user_login;

              $metas = get_user_meta( $user_id );
              $name = isset( $metas['nickname']['0'] ) ? $metas['nickname']['0'] : false;
              $first_name = isset( $metas['first_name']['0'] ) ? $metas['first_name']['0']  : false;
              $twitter = isset( $metas['twitter']['0'] ) ? $metas['twitter']['0']  : false;
              $facebook = isset( $metas['facebook']['0']  ) ? $metas['facebook']['0']  : false;
              $instagram = isset( $metas['instagram']['0']  ) ? $metas['instagram']['0']  : false;
              $des = isset( $metas['description']['0']  ) ? $metas['description']['0']  : false;
              $full_title = isset( $metas['full_title']['0']  ) ? $metas['full_title']['0']  : false;
              $twitter_name = preg_replace("/(https*:\/\/(.*)twitter.com\/)/i", "", $twitter);

              $avatar =  get_avatar( $user_id, '512' );
              $author_link = site_url() . '/chefs/#' . $username;
              $post_link = get_author_posts_url( $user_id );

              ?>
              <div class="chef-bio">
                <div class="row">
                  <div class="col s12 m4 l4">
                    <div class="avatar">
                      <?php echo $avatar; ?>
                    </div>
                    <div class="follow center">
                      <h5>Follow Chef <?php echo $first_name; ?> on:</h5>
                      <div class="social">
                        <?php if ( $twitter ) { ?>
                          <a href="<?php echo $twitter; ?>" target="_blank">
                            <i class="fa fa-twitter"></i>
                          </a>
                        <?php } ?>
                        <?php if ( $facebook ) { ?>
                          <a href="<?php echo $facebook; ?>" target="_blank">
                            <i class="fa fa-facebook"></i>
                          </a>
                        <?php } ?>
                        <?php if ( $instagram ) { ?>
                          <a href="<?php echo $instagram; ?>" target="_blank">
                            <i class="fa fa-instagram"></i>
                          </a>
                        <?php } ?>

                      </div>
                    </div>
                  </div>
                  <div class="col s12 m8 l8">
                    <h3><?php echo $name; ?></h3>
                    <h4><?php echo $full_title; ?></h4>
                    <div class="des">
                      <?php echo wpautop( $des ); ?>
                    </div>
                    <div class="see-more">
                      <a href="<?php echo $post_link;?>" class="uppercase">
                        SEE CHEF <?php echo $first_name; ?>'s RECIPES
                      </a>
                    </div>
                  </div>

                  <?php if ( $key <= count($chefs) - 2 ) { ?>
                    <div class="col s12 m12 l12">
                      <hr/>
                    </div>
                  <?php } ?>
                </div>
              </div>
              <?php

            }
          }
        ?>
      </div>
    </div>
  </div>
  <?php
    endwhile;
    endif;
  ?>

<?php get_footer(); ?>
