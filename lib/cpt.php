<?php


//Registering Custom Post Type
add_action( 'init', 'my_cpt_init', 100 );
function my_cpt_init() {

    $args = array(
        'label'              => 'Products',
        'description'        => __( 'Products', 'windset' ),
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true, //dashboard menu slug
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'products' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'menu_icon'          => 'dashicons-screenoptions',
        'taxonomies'         => array('post_tag', 'category'),
        'menu_position'      => 20,
        'show_in_nav_menus'  => true,
        'supports'           => array( 'title', 'editor',  'thumbnail', 'excerpt' )
    );

    register_post_type( 'products', $args );

    $args = array(
        'label'              => 'Recipes',
        'description'        => __( 'Recipes', 'windset' ),
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true, //dashboard menu slug
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'recipe' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'menu_icon'          => 'dashicons-media-spreadsheet',
        'taxonomies'         => array('post_tag', 'category'),
        'menu_position'      => 20,
        'show_in_nav_menus'  => true,
        'supports'           => array( 'title', 'editor',  'thumbnail', 'excerpt', 'author' )
    );

    register_post_type( 'recipes', $args );

    $args = array(
        'label'              => 'Sales Sheets',
        'description'        => __( 'Sales Sheets', 'windset' ),
        'public'             => true,
        'exclude_from_search' => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true, //dashboard menu slug
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'sales' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'menu_icon'          => 'dashicons-list-view',
        'taxonomies'         => array(),
        'menu_position'      => 20,
        'show_in_nav_menus'  => true,
        'supports'           => array( 'title', 'editor', 'author' )
    );

    register_post_type( 'sales', $args );

}


/* register taxnomonies for post types */

add_action( 'init', 'product_taxonomies', 0 );

function product_taxonomies() {

  // Add new taxonomy, make it hierarchical (like categories)
  $args = array(
    'hierarchical'      => true,
    'public'          => false,
    'label'            => 'Commodities',
    'labels'    => array(
      'name'              => _x( 'Commodities', 'taxonomy general name', 'windset' ),
  		'singular_name'     => _x( 'Commodity', 'taxonomy singular name', 'windset' ),
  		'search_items'      => __( 'Search Commodities', 'windset' ),
  		'all_items'         => __( 'All Commodities', 'windset' ),
  		'parent_item'       => __( 'Parent Commodity', 'windset' ),
  		'parent_item_colon' => __( 'Parent Commodity:', 'windset' ),
  		'edit_item'         => __( 'Edit Commodity', 'windset' ),
  		'update_item'       => __( 'Update Commodity', 'windset' ),
  		'add_new_item'      => __( 'Add New Commodity', 'windset' ),
  		'new_item_name'     => __( 'New Commodity Name', 'windset' ),
  		'menu_name'         => __( 'Commodities', 'windset' ),
    ),
    'show_ui'           => true,
    'show_admin_column' => true,
    'query_var'         => true,
    'rewrite'           => array( 'slug' => 'commodity' ),
    'show_in_nav_menus'  => false,
  );

  register_taxonomy( 'commodity', array( 'products' ), $args );
  register_taxonomy_for_object_type( 'commodity', 'products' );

}

add_action( 'init', 'store_taxonomies', 0 );

function store_taxonomies() {

  // Add new taxonomy, make it hierarchical (like categories)
  $args = array(
    'hierarchical'      => false,
    'public'          => false,
    'label'            => 'Stores',
    'label'            => 'Stores',
    'labels'    => array(
      'name'              => _x( 'Stores', 'taxonomy general name', 'windset' ),
  		'singular_name'     => _x( 'Store', 'taxonomy singular name', 'windset' ),
  		'search_items'      => __( 'Search Stores', 'windset' ),
  		'all_items'         => __( 'All Stores', 'windset' ),
  		'parent_item'       => __( 'Parent Store', 'windset' ),
  		'parent_item_colon' => __( 'Parent Store:', 'windset' ),
  		'edit_item'         => __( 'Edit Store', 'windset' ),
  		'update_item'       => __( 'Update Store', 'windset' ),
  		'add_new_item'      => __( 'Add New Store', 'windset' ),
  		'new_item_name'     => __( 'New Store Name', 'windset' ),
  		'menu_name'         => __( 'Stores', 'windset' ),
    ),
    'show_ui'           => true,
    'show_admin_column' => true,
    'query_var'         => true,
    'rewrite'           => array( 'slug' => 'store' ),
    'show_in_nav_menus'  => false,
  );

  register_taxonomy( 'store', array( 'products' ), $args );
  register_taxonomy_for_object_type( 'store', 'products' );

}

add_action( 'init', 'country_taxonomies', 0 );

function country_taxonomies() {

  // Add new taxonomy, make it hierarchical (like categories)
  $args = array(
    'hierarchical'      => true,
    'public'          => false,
    'label'            => 'Locations',
    'label'            => 'Locations',
    'labels'    => array(
      'name'              => _x( 'Locations', 'taxonomy general name', 'windset' ),
  		'singular_name'     => _x( 'Location', 'taxonomy singular name', 'windset' ),
  		'search_items'      => __( 'Search Locations', 'windset' ),
  		'all_items'         => __( 'All Location', 'windset' ),
  		'parent_item'       => __( 'Parent Location', 'windset' ),
  		'parent_item_colon' => __( 'Parent Location:', 'windset' ),
  		'edit_item'         => __( 'Edit Location', 'windset' ),
  		'update_item'       => __( 'Update Location', 'windset' ),
  		'add_new_item'      => __( 'Add New Location', 'windset' ),
  		'new_item_name'     => __( 'New Location Name', 'windset' ),
  		'menu_name'         => __( 'Locations', 'windset' ),
    ),
    'show_ui'           => true,
    'show_admin_column' => true,
    'query_var'         => true,
    'rewrite'           => array( 'slug' => 'location' ),
    'show_in_nav_menus'  => true,
  );

  register_taxonomy( 'location', array( 'products' ), $args );
  register_taxonomy_for_object_type( 'location', 'products' );

}


//hide non-public taxonomy in admin sidebar
add_action('admin_head', 'hide_non_public_taxonomy');

function hide_non_public_taxonomy() {
  echo '<style>
    #tagsdiv-store,
    #countrydiv,
    #locationdiv {
      display: none;
    }
  </style>';
}
