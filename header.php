<!DOCTYPE html>
<html lang="en">
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
	<title><?php bloginfo( 'name' );?><?php wp_title(); ?> </title>
	<meta name="description" content="<?php bloginfo( 'description' ) ?>" />
	<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
	<link rel="icon" type="image/png" href="/favicon-32x32.png" sizes="32x32">
	<link rel="icon" type="image/png" href="/favicon-16x16.png" sizes="16x16">
	<link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
	<meta name="theme-color" content="#ffffff">
	<!--[if lt IE 9]>
	<script src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/html5.js"></script>
	<![endif]-->
	<?php
    wp_head();
  ?>
</head>
<body <?php body_class(); ?>>

  <a class="hide back-to-top">
    <i class="fa fa-chevron-up"></i>
    TOP
  </a>

  <div class="header">
    <div class="container">
      <nav class="transparent desktop hide-on-small-only row" role="navigation">
        <div class="col m12 logo-container">
          <div class="logo">
            <a href="<?php bloginfo( 'url' );?>" title="<?php bloginfo( 'name' );?>">
              <img width="154" height="231"
              src="<?php bloginfo( 'url' );?>/logo-windset.png"
							srcset="<?php bloginfo( 'url' );?>/logo-windset@2x.png 2x"
              alt="logo"/>
            </a>
          </div>
        </div>
        <div class="col m12 nav-container">
        <?php


          ob_start();
          dynamic_sidebar( 'nav-translation' );
          $ajax_translator = ob_get_clean();

          if ( is_dev() ) {

              $ajax_translator = '
              <div id="translator-dropdown-jquery-container" class="testy translator-dropdown-container translator-dropdown-container-custom translator-dropdown-jquery translator-dropdown-floating-left translator-dropdown-names translator-dropdown-hover translator-dropdown-low-res">
                  <div class="translator-dropdown-sub-container">
                      <div class="translator-dropdown-body">
                          <p class="translator-dropdown-current-language"><span>English</span>
                          </p><em class="translator-dropdown-current-language-arrow"></em>
                          <div class="translator-dropdown-languages-list">
                              <p class="translator-dropdown-completed"><a href="javascript:;" title="English" class="translator-dropdown-language-en"><span>English</span></a>
                              </p>
                              <p><a href="javascript:;" title="Français" class="translator-dropdown-language-fr"><span>Français</span></a>
                              </p>
                              <p><a href="javascript:;" title="Español" class="translator-dropdown-language-es"><span>Español</span></a>
                              </p>
                              <p><a href="javascript:;" title="日本語" class="translator-dropdown-language-ja"><span>日本語</span></a>
                              </p>
                          </div>
                      </div>
                  </div>
              </div>
              ';
          }

          $s = get_query_var( 's', false );
          $class = '';

          if ( $s )
            $class = "active";

          $search = '
          <li class="item-search">
            <div class="select-language">
              '. $ajax_translator . '
            </div>
            <div class="button-search ' . $class . '">
              <i class="fa fa-search"></i>
              ' . get_search_form( false ) . '
            </div>
          </li>';


          $defaults = array(
            'theme_location'  => 'main-menu',
            'menu'            => '',
            'container'       => 'div',
            'container_class' => 'nav-wrapper desktop-menu',
            'container_id'    => '',
            'menu_class'      => '',
            'menu_id'         => '',
            'echo'            => true,
            'fallback_cb'     => 'wp_page_menu',
            'before'          => '',
            'after'           => '',
            'link_before'     => '',
            'link_after'      => '',
            'items_wrap'      => '<ul id="%1$s" class="hide-on-small-only %2$s">%3$s' . $search .'</ul>',
            'depth'           => 0,
            'walker'          => ''
          );

          wp_nav_menu( $defaults );

          ?>
        </div>
      </nav>

      <div class="mobile-menu hide-on-med-and-up">
        <div class="logo">
          <a href="<?php bloginfo( 'url' );?>" title="<?php bloginfo( 'name' );?>">
              <img width="77" height="116" src="<?php bloginfo( 'url' );?>/logo-windset.png" alt="logo"/>
          </a>
        </div>
      </div>
      <nav class="transparent mobile-menu hide-on-med-and-up" role="navigation">
        <a href="#" data-activates="mobile-menu" class="button-collapse">
          <i class="fa fa-bars" aria-hidden="true"></i>
        </a>
        <?php

          $mobile = array(
          'theme_location'  => 'main-menu',
          'menu'            => '',
          'container'       => '',
          'container_class' => '',
          'container_id'    => '',
          'menu_class'      => 'side-nav collapsible',
          'menu_id'         => 'mobile-menu',
          'echo'            => true,
          'fallback_cb'     => 'wp_page_menu',
          'before'          => '',
          'after'           => '',
          'link_before'     => '',
          'link_after'      => '',
          'items_wrap'      => '<ul id="%1$s" class="%2$s">
            <li class="menu-logo">
              <a href="' . site_url() . '" title="Home">
                  <img width="154" height="231" src="' . site_url() . '/logo-windset.png" alt="logo"/>
              </a>
            </li>
            %3$s
          </ul>',
          'depth'           => 0,
          'walker'          => ''
          );

          wp_nav_menu( $mobile );
        ?>
      </nav>
    </div>
  </div>
