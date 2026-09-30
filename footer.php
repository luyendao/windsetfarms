        <?php wp_footer(); ?>

      <?php if ( ! is_front_page() ) : // homepage has its own Get Social section ?>
      <div class="section full-width socials">

            <div class="row">


                            <?php
                              $social = get_field( 'social_media', 'option' );
                              $social = $social['0'];
                              $twitter = isset( $social['twitter'] ) ? $social['twitter'] : false;
                              $pinterest = isset( $social['pinterest'] ) ? $social['pinterest'] : false;
                              $facebook = isset( $social['facebook'] ) ? $social['facebook'] : false;
                              $instagram = isset( $social['instagram'] ) ? $social['instagram'] : false;
                              $youtube = isset( $social['youtube'] ) ? $social['youtube'] : false;
                              $linkedin = isset( $social['linkedin'] ) ? $social['linkedin'] : false;

                              $social_icons_path = get_template_directory_uri() . '/img/';
                            ?>


                            <div class="socials-grid">
                            <?php if ( $facebook ) { ?>
                              <a class="social-link" href="<?php echo $facebook; ?>" target="_blank"><img src="<?php echo $social_icons_path; ?>icon-facebook.png"></a>
                            <?php } ?>

                            <?php if ( $instagram ) { ?>
                              <a class="social-link" href="<?php echo $instagram; ?>" target="_blank"><img src="<?php echo $social_icons_path; ?>icon-instagram.png"></a>
                            <?php } ?>

                            <?php if ( $linkedin ) { ?>
                              <a class="social-link" href="<?php echo $linkedin; ?>" target="_blank"><img src="<?php echo $social_icons_path; ?>icon-linkedin.png"></a>
                            <?php } ?>                            
                            </div>

              </div>

      </div>
      <?php endif; ?>


        <div class="section section-partners full-width no-margin">
          <div class="section-inner">
            <div class="row">
              <div class="col s12 m12 l12 center">
                <?php

                  $frontpage_id = get_option( 'page_on_front' );
                  $footer_partners = get_field( 'footer_partners', $frontpage_id );

                  if ( !empty( $footer_partners ) ) {

                    foreach ( $footer_partners as $key => $partner ) {

                      $logo = $partner['logo'];
                      $logo_url = isset( $logo['sizes']['large'] ) ?  $logo['sizes']['large'] : false;
                      $width = isset( $logo['sizes']['large-width'] ) ?  $logo['sizes']['large-width'] : false;
                      $height = isset( $logo['sizes']['large-height'] ) ? $logo['sizes']['large-height'] : false ;
                      $link = isset( $partner['link'] ) ? $partner['link'] : '#';

                      if ( $logo_url ) {
                        ?>
                        <a href="<?php echo $link; ?>">
                          <img width="<?php echo $width; ?>" height="<?php echo $height; ?>" src="<?php echo $logo_url; ?>" />
                        </a>
                        <?php
                      }
                    }
                  }
                ?>
              </div>
            </div>
          </div>
        </div>

        <footer class="section footer full-width no-margin">
          <div class="upper">
            <div class="section-inner">
              <div class="row">

                <div class="col s12 m7 l7 footer-brand">
                  <a class="footer-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php bloginfo( 'name' ); ?>">
                    <img width="154" height="231"
                      src="<?php bloginfo( 'url' ); ?>/logo-windset.png"
                      srcset="<?php bloginfo( 'url' ); ?>/logo-windset@2x.png 2x"
                      alt="<?php bloginfo( 'name' ); ?>"/>
                  </a>
                  <img class="footer-ladybug" src="<?php echo esc_url( get_template_directory_uri() . '/img/ladybug.png' ); ?>" width="471" height="355" alt="" aria-hidden="true"/>
                </div>

                <div class="col s12 m5 l5">
                  <div class="col s12 m12 l12">
                    <h3 class="uppercase">Questions? Get in touch</h3>
                    <?php
                      $contact = get_field( 'contact', 'option' );

                      $contact = $contact['0'];
                      $name = isset( $contact['name'] ) ? $contact['name']  : false;
                      $address = isset( $contact['address'] ) ? $contact['address']  : false;
                      $map = isset( $contact['map']['address'] ) ? $contact['map']['address']  : false;
                      $phone = isset( $contact['phone'] ) ? $contact['phone']  : false;
                      $fax = isset( $contact['fax'] ) ? $contact['fax']  : false;
                      $email = isset( $contact['email'] ) ? $contact['email']  : false;
                      $email_text = isset( $contact['email_text'] ) ? $contact['email_text']  : false;
                    ?>
                    <?php if ( $name ) { ?>
                      <h4>Windset Farms HQ, Canada</h4>
                    <?php } ?>
                  </div>

                  <div class="row contact">
                    <div class="col s12 m6 l6">
                      <?php if ( $address ) { ?>
                        <?php echo $address; ?>
                      <?php } ?>

                      <?php if ( $map ) {

                        $map_address = str_replace( ' ', '+', $map);
                        $map_address = str_replace( ',', '', $map_address );
                        $dir_link = 'https://www.google.com/maps/dir//' . $map_address;
                        ?>
                        <a href="<?php echo $dir_link; ?>">Map &amp; Directions</a><br/>

                      <?php } ?>


                    </div>
                    <div class="col s12 m6 l6">
                      <?php if ( $phone ) { ?>
                        T: <?php echo $phone; ?><br/>
                      <?php } ?>
                      <?php if ( $fax ) { ?>
                        F: <?php echo $fax; ?><br/>
                      <?php } ?>
                      <?php if ( $email ) { ?>
                        E: <a href="mailto:<?php echo $email; ?>">
                          <?php echo $email_text; ?>
                          </a><br/>
                      <?php } ?>
                    </div>
                  </div>
                </div>
              </div>

            </div>
          </div>

          <div class="lower">
            <div class="section-inner">
              <div class="row">

                <div class="col s12 m7 l7 copyright">
                  <div class="col s12 m12 l12">
                    <a href="<?php bloginfo('url')?>">&copy; <?php echo date('Y'); ?> <?php bloginfo('name')?></a>. All Rights Reserved<br/>
                  </div>
                </div>


              </div>
          </div>
</footer>

    </body>
    
    <!-- vlq8tml -->
    <script src="https://use.typekit.net/ifl3ypf.js"></script>
    <script>try{Typekit.load({ async: true });}catch(e){}</script>

    <script>
     (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
     (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
     m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
     })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

     ga('create', 'UA-71590471-1', 'auto');
     ga('send', 'pageview');

    </script>
    
</html>
