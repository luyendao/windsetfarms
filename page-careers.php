<?php /* Template Name: Careers */ ?>
<?php get_header(); ?>

<?php

  if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

  <?php

    cc_do_title_container();

    global $fields;
    $app = isset( $fields['general_application'] ) ?  $fields['general_application'] : false;
    $form = isset( $fields['careers_application_form'] ) ?  $fields['careers_application_form'] : false;
    $locations = isset( $fields['locations'] ) ?  $fields['locations'] : false;
    $careers = isset( $fields['careers'] ) ?  $fields['careers'] : false;
  ?>
  <div class="section section-content">
    <div class="row">
      <div class="col s12 m12 l12 drop-caps">
        <?php the_content(); ?>
      </div>
    </div>
    <div class="row">
      <div class="col s12 m12 l12">
        <br/>
        <hr/>
        <br/>
      </div>
    </div>

    <div class="row">
        <div class="col s12 m12 l12">
            <table class="table-career-list">
                <thead>
                    <tr class="red">
                        <td colspan="3">Career Opportunities</td>
                    </tr>
                    <tr class="grey">
                        <td>Title</td>
                        <td>Job ID #</td>
                        <td>Location</td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if( $careers ):
                            foreach( $careers as $idx => $career ):
                    ?>
                            <tr class="career-list" data-career-index="<?php echo $idx; ?>">
                                <td><?php echo $career['title']; ?></td>
                                <td><?php echo $career['job_id']; ?></td>
                                <td><?php echo $career['location']; ?></td>
                            </tr>
                    <?php
                            endforeach;
                        endif;
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php if( $careers ): ?>
        <div class="row">
            <div class="col s12 m12 l12">
                <?php foreach( $careers as $idx => $career ): ?>
                <div class="career-content" data-career-index="<?php echo $idx; ?>">
                    <div class="text-right">
                        <a class="btn-close-career-content"> Close <span class="btn-close-career-content-icon">&#9746;</span></a>
                    </div>
                    <h4 class="career-title"><?php echo $career['title']; ?></h4>
                    <h5>Location: <?php echo $career['location']; ?></h5>
                    <?php echo $career['description']; ?>
                    <h5>Job ID: <?php echo $career['job_id']; ?></h5>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="row">
            <div class="col s12 m12 l12">
                <br/>
                <hr/>
                <br/>
            </div>
        </div>


    <?php endif; ?>




    <div class="row">
      <div class="col s12 m12 l12">
        <h3>General Application</h3>
      </div>
      <div class="col s12 m6 l6">
        <?php echo $app; ?>
      </div>
      <div class="col s12 m6 l6">
        <?php
          if ( $form ) {

            $form_html = do_shortcode ( $form );

            $find = '<option value=""></option>';
            $options = '';

            if ( $locations ) {

              $options .= '<option selected="selected" value="" disabled=disabled">Select Windset Farms Locations</option>';

              foreach ( $locations as $key => $location ) {
                $name = isset( $location['name'] ) ? $location['name'] : false;
                $email = isset( $location['email'] ) ? $location['email'] : false;
                $options .= '<option value="' . $name . '" data-email="' . $email . '">' . $name . '</option>';
              }

            }

            $form_html = contact_form_7_placeholders ( $form_html );
            $form_html = str_replace( $find, $options, $form_html );

            echo $form_html;

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
