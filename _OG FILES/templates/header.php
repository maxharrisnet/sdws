<?php

/**
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Aera_Technology
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>

<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="profile" href="https://gmpg.org/xfn/11">

  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
  <?php
  wp_body_open();
  $background_classes = 'background';
  $background_active = aera_is_background_active();

  if ($background_active && is_front_page()) {
    $background_classes .= ' isHome';
  }
  ?>
  <div id="app" class="site">
    <a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e('Skip to content', 'aera'); ?></a>

    <div class="<?php echo esc_attr($background_classes); ?>" data-background data-background-active="<?php echo $background_active ? 'true' : 'false'; ?>" aria-hidden="true"></div>

    <header class="header" id="headnav" data-header>
      <?php \Aera\render_banner(); ?>
      <div class="header__container">
        <div class="header__content">
          <div class="header__bar" id="logo">
            <a class="header__logo" href="<?php echo esc_url(home_url('/')); ?>" rel="home" aria-label="<?php esc_attr_e('Aera Technology', 'aera'); ?>">
              <?php
              $logo = get_theme_mod('custom_logo');
              if ($logo) {
                echo wp_get_attachment_image(
                  $logo,
                  'logo',
                  false,
                  array(
                    'class'   => 'header__logoImage',
                    'alt'     => get_bloginfo('name'),
                    'loading' => 'eager',
                    'width'   => 240,
                    'height'  => 102,
                  )
                );
              } else {
                $logo_src = get_template_directory_uri() . '/assets/images/aera-logo.svg';
                ?>
                <img src="<?php echo esc_url($logo_src); ?>" class="header__logoImage" alt="<?php bloginfo('name'); ?>" loading="eager" width="160" height="36" />
              <?php } ?>
            </a>
            <button class="header__toggle" type="button" data-nav-toggle aria-controls="primary-navigation" aria-expanded="false">
              <span class="header__toggleLine"></span>
              <span class="header__toggleLine"></span>
              <span class="header__toggleLine"></span>
              <span class="screen-reader-text"><?php esc_html_e('Toggle navigation', 'aera'); ?></span>
            </button>
          </div>

          <!-- TODO: See if we need this at all -->
          <!-- <div class="header__overlay" data-nav-overlay></div> -->

          <nav class="header__navigation" aria-label="<?php esc_attr_e('Primary navigation', 'aera'); ?>" data-nav-panel>
            <div class="header__navBackground" aria-hidden="true">
              <svg class="Header_svg_1A_1E" x="0" y="0" width="100%" height="100%" viewBox="0 0 100 1000" preserveAspectRatio="none">
                <path fill="#f7f9fa" d="M100,0L100,0H0c0,0,0,118,0,249c0,146,0,138,0,249c0,112.9,0,85,0,278c0,87.1,0,224,0,224h100V0" data-original="M100,0C100,0,0,118,0,249c0,146,34,150,65,249c33.7,107.8,35,85,35,278c0,87.1,0,224,0,224l0,0V0L100,0z"></path>
              </svg>
            </div>

            <div class="header__navlist">
              <?php
              wp_nav_menu(
                array(
                  'theme_location' => 'primary',
                  'menu_id'        => 'primary-navigation',
                  'container'      => false,
                  'menu_class'     => 'navigation__list',
                  'depth'          => 2,
                  'fallback_cb'    => '__return_false',
                  'walker'         => new \Aera\Navigation_Walker(),
                )
              );
              ?>
            </div>

            <div class="header__social">
              <?php
              if (has_nav_menu('primary-utility')) {
                wp_nav_menu(
                  array(
                    'theme_location' => 'primary-utility',
                    'container'      => false,
                    'menu_class'     => 'header__utility header__utility--mobile',
                    'depth'          => 1,
                    'fallback_cb'    => false,
                  )
                );
              }
              ?>
            </div>
          </nav>

          <div class="header__demo" id="meetAera-desktop">
            <?php
            if (has_nav_menu('primary-utility')) {
              wp_nav_menu(
                array(
                  'theme_location' => 'primary-utility',
                  'container'      => false,
                  'menu_class'     => 'header__utility',
                  'depth'          => 1,
                  'fallback_cb'    => false,
                )
              );
            } else {
            ?>
              <a class="button button--outline" href="<?php echo esc_url(home_url('/demo')); ?>">
                <?php esc_html_e('Schedule Demo', 'aera'); ?>
              </a>
            <?php
            }
            ?>
          </div>
        </div>
      </div>
    </header>