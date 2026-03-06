<?php

/**
 * Site footer component.
 *
 * @package Starter_Coat
 */

$footer_variant = isset($args['variant']) ? sanitize_html_class($args['variant']) : 'default';
?>
<footer id="colophon" class="site-footer footer footer--<?php echo esc_attr($footer_variant); ?>">
  <div class="container footer__inner">
    <?php
    wp_nav_menu(
      array(
        'theme_location' => 'menu-footer',
        'menu_id'        => 'footer-menu',
        'fallback_cb'    => false,
      )
    );
    ?>
    <p class="footer__meta">&copy; <?php echo esc_html(gmdate('Y')); ?> <?php bloginfo('name'); ?></p>
  </div>
</footer>