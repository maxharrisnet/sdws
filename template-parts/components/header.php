<?php

/**
 * Site header component.
 *
 * @package Starter_Coat
 */

$header_variant = isset($args['variant']) ? sanitize_html_class($args['variant']) : 'default';
?>
<header id="masthead" class="site-header header header--<?php echo esc_attr($header_variant); ?>">
  <div class="container header__inner">
    <div class="header__branding">
      <?php the_custom_logo(); ?>
      <a class="header__site-name" href="<?php echo esc_url(home_url('/')); ?>" rel="home"><?php bloginfo('name'); ?></a>
    </div>

    <button class="header__menu-toggle menu-toggle" aria-controls="primary-menu" aria-expanded="false">
      <?php esc_html_e('Menu', 'starter-coat'); ?>
    </button>

    <nav id="site-navigation" class="main-navigation header__nav" aria-label="<?php esc_attr_e('Primary Menu', 'starter-coat'); ?>">
      <?php
      wp_nav_menu(
        array(
          'theme_location' => 'menu-1',
          'menu_id'        => 'primary-menu',
        )
      );
      ?>
    </nav>
  </div>
</header>