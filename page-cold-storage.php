<?php /* Template Name: The Way We Grow */ ?>
<?php get_header(); ?>

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

<?php
  cc_do_title_container();

  global $fields;
  $warehouses = isset( $fields['warehouses'] ) ? $fields['warehouses'] : false;
  $our_services = isset( $fields['our_services'] ) ? $fields['our_services'] : false;
  $warehouse_background = isset( $fields['warehouse_background'] ) ? $fields['warehouse_background'] : false;
?>

<div class="section section-intro">

  <div class="row">
    <div class="col s12 m12 l12 intro-text center-align">
      <?php the_content(); ?>
    </div>
  </div>

  <div class="row">
    <?php 
      foreach($warehouses as $warehouse) : 
        $info = isset($warehouse['info']) ? $warehouse['info'] : '';
        $image = isset($warehouse['image']['sizes']['medium_large']) ? $warehouse['image']['sizes']['medium_large'] : '';
    ?>
      <div class="col s12 m4 l4 warehouse">
        <div class="title center-align"><?php echo $info; ?></div>
        <div><img src="<?php echo $image; ?>" class="responsive-img"></div>
      </div>
    <?php endforeach; ?>
    </div>
  </div>

</div>

<div class="section full-width margin-tb padding-tb cover m-none-bg s-none-bg" style="background-image: url(<?php echo $warehouse_background['url']; ?>);">
  <div class="row">
    <div class="col offset-l2 l8">
        <h2 class="section-title font-script text-red margin-bottom-20">Our Services</h2>
    </div>
  </div>
  <div class="row">
    <div class="col offset-l2 l2">
      <?php get_services(  array_slice($our_services, 0, 2) ); ?>
    </div>
    <div class="col l2">
      <?php get_services(  array_slice($our_services, -2) ); ?>
      <img src="<?php echo get_template_directory_uri() . '/img/certificates.png'; ?>" class="responsvie-img">
    </div>
  </div>
</div>

<div class="row margin-bottom-40">
  <div class="col s12 offset-l3 l6">
    <div>
      <h2>Contact Us</h2>
      <p>For information on our cold or cooler storage services or to discover our industry competitive rates, call us at <a href="tel:16049407700">(604) 940-7700</a>.</p>
    </div>
    <?php echo do_shortcode('[contact-form-7 id="6675" title="Cold Storage"]'); ?>
  </div>
</div>

<?php
  endwhile;
  endif;
?>
<?php get_footer(); ?>
