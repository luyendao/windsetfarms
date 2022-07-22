<?php


add_action( 'widgets_init', 'windset_widgets_init' );

function windset_widgets_init() {
  register_sidebar( array(
    'name' => __( 'Navigation Translation', 'windset' ),
    'id' => 'nav-translation',
    'description' => __( 'Widgets in this area will be shown on the navigation bar.', 'windset' ),
    'before_widget' => '',
    'after_widget'  => '',
    'before_title'  => '<div class="hide">',
    'after_title'   => '</div>',
  ) );

}

?>