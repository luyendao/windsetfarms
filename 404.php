  <?php

    if ( get_query_var( 'cat', false ) ) {

      include_once( locate_template( 'archive.php') );

    } else {

      get_header();
      cc_do_title_container('Page not found');

      ?>
      <div class="section section-content">
        <div class="row">
          <div class="col s12 m12 l12">
            Sorry, the page you were looking for cannot be found.<br/>
            Please try search the site again or <a href="<?php echo site_url(); ?>">click here to go back to our home page</a>.<br/>
            <br/>
            <h3>Search by Keyword</h3>
            <?php get_search_form(); ?>
            <br/>
            <br/>
            <br/>
          </div>
        </div>
      </div>

    <?php
    get_footer();
  }

?>
