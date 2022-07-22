<?php

function cc_do_section_find_stores() {

  $post_id = get_the_ID();
  $commodity = wp_get_post_terms( $post_id, 'commodity' );
  $commodity_id = isset( $commodity['0']->term_id ) ? $commodity['0']->term_id : false;
  $edit_link = get_edit_term_link( $commodity_id, 'commodity', 'products' );

  $locations = get_terms( array(
      'taxonomy' => 'location',
      'hide_empty' => false,
  ));

  $locations_sorted = array();

  foreach ( $locations as $i => $location ) {
    if ( $location->parent == 0 ) {
      $c_id = $location->term_id;
      $locations_sorted[ $c_id ] = $location;
      $locations_sorted[ $c_id ]->states = array();
    }
  }

  foreach ( $locations as $i => $location ) {
    if ( $location->parent !== 0 ) {
      $p_id = $location->parent;
      $locations_sorted[ $p_id ]->states[] = $location;
    }
  }

  if ( $commodity_id && false ) { // hide store locator
    $find = get_field( 'stores', 'commodity_' . $commodity_id );

    if ( $find ) {
      ?>
      <div class="section section-stores full-width">
        <div class="bg-red">
          <div class="section-inner">
            <div class="row">
              <div class="col s12 m12 l12 center">
                <div class="find">
                  <h3 class="white-text">Find <?php the_title(); ?> at your nearest grocery store</h3>


                    <div class="input-field inline-block left-align">
                      <label class="white-text uppercase">location</label>
                      <select class="select select-country">
                        <option value="" disabled>Select a location</option>
                        <?php foreach ( $locations_sorted as $i => $location ) {

                          $c_id = $location->term_id;
                          $name = $location->name;
                          ?>
                          <option value="<?php echo $c_id ; ?>"><?php echo $name; ?></option>
                          <?php

                        } ?>
                      </select>
                    </div>


                    <div class="input-field inline-block left-align">
                      <label class="white-text uppercase">Province / State</label>

                      <?php
                        $counter = 0;
                        foreach ( $locations_sorted as $i => $location ) {

                          $class = "hide";
                          if ( $counter == 0 )
                            $class = '';

                          $c_id = $location->term_id;
                          $name = $location->name;
                          $states = $location->states;
                          $class .= ' country-' . $c_id;
                          ?>
                          <select class="select select-states <?php echo $class; ?>">
                            <option value="" disabled>Select a Province/State</option>
                            <?php

                              foreach ( $states as $key => $state ) {

                                $s_id = $state->term_id;
                                $name = $state->name;
                                $selected = '';

                                if ( $name == 'British Columbia' ) {
                                  $selected = 'selected="selected"';
                                }
                                ?>
                                <option value="<?php echo $s_id ; ?>" <?php echo $selected; ?>><?php echo $name; ?></option>
                                <?php
                              }

                            ?>
                          </select>
                          <?php
                          $counter++;
                        }
                      ?>

                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="bottom-arrow">
              <div class="white inline-block strip strip-left">
                <div class="triangle triangle-left"></div>
              </div>

              <div class="white inline-block strip strip-right">
                <div class="triangle triangle-right"></div>
              </div>
            </div>
          </div>

          <div class="section-inner">
            <div class="stores">
              <div class="row des">

                <?php

                  foreach ( $find as $index => $store ) {
                    $name = isset( $store['store']->name ) ?  $store['store']->name : false;
                    $states = isset( $store['states'] ) ? $store['states'] : false;
                    $states_array = array();

                    foreach ( $states as $state ) {
                      $states_array[] = $state->name;
                    }

                    if ( $states_array ) {
                      $states = implode( ',', $states_array );

                      $hide = 'hide';

                      if ( strpos( $states, 'British Columbia') !== false )  {
                        $hide = '';
                      }

                      ?>

                      <div class="col s6 m4 l4 store <?php echo $hide; ?>" data-states="<?php echo $states; ?>">
                        <?php echo $name; ?>
                      </div>

                    <?php
                    }
                  }

                ?>
                <div class="col s12 m12 l12 hide no-match center" data-states="none">
                  No stores found in the selected province or state yet.
                </div>
              </div>

              <?php if ( current_user_can( 'edit_posts' ) ) { ?>
                <div class="row hover-visible">
                  <div class="col s12 m12 l12">
                    <div class="center">
                      <a href="<?php echo $edit_link; ?>">
                        <i class="fa fa-edit"></i> Edit Store Locations
                      </a>
                    </div>
                  </div>
                </div>
              <?php } ?>

            </div>
          </div>
        </div>
      </div>
      <?php

    }
  }

}

?>
