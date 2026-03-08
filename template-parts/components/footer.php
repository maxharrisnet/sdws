<?php

/**
 * Site footer component.
 *
 * @package Starter_Coat
 */

$footer_settings = function_exists('starter_coat_get_footer_settings') ? starter_coat_get_footer_settings() : array();
$nav_settings    = function_exists('starter_coat_get_nav_settings') ? starter_coat_get_nav_settings() : array();

$layout          = isset($footer_settings['layout']) ? sanitize_html_class((string) $footer_settings['layout']) : 'simple';
$simple_columns  = isset($footer_settings['simple_columns']) ? sanitize_html_class((string) $footer_settings['simple_columns']) : 'two';
$complex_columns = isset($footer_settings['complex_columns']) ? sanitize_html_class((string) $footer_settings['complex_columns']) : 'three';

$social_links = function_exists('starter_coat_get_social_links') ? starter_coat_get_social_links() : array();
$show_social  = ! empty($footer_settings['show_social']) && ! empty($social_links);

$show_logo = ! empty($footer_settings['show_logo']);
$logo_mode = isset($footer_settings['logo_mode']) ? (string) $footer_settings['logo_mode'] : 'inherit_nav';

if ('inherit_nav' === $logo_mode && ! empty($nav_settings['logo_mode'])) {
  $logo_mode = (string) $nav_settings['logo_mode'];
}

$logo_image = null;
if ('image' === $logo_mode && ! empty($footer_settings['logo_image']) && is_array($footer_settings['logo_image'])) {
  $logo_image = $footer_settings['logo_image'];
} elseif ('image' === $logo_mode && ! empty($nav_settings['logo_image']) && is_array($nav_settings['logo_image'])) {
  $logo_image = $nav_settings['logo_image'];
}

$footer_logo_html = '';
$footer_logo_alt  = get_bloginfo('name');

if ('image' === $logo_mode && is_array($logo_image) && ! empty($logo_image['url'])) {
  $logo_id = isset($logo_image['ID']) ? absint($logo_image['ID']) : 0;

  if (! empty($logo_image['alt'])) {
    $footer_logo_alt = (string) $logo_image['alt'];
  }

  if ($logo_id) {
    $footer_logo_html = wp_get_attachment_image(
      $logo_id,
      'sc-logo',
      false,
      array(
        'class'    => 'footer__logo-image',
        'loading'  => 'lazy',
        'decoding' => 'async',
      )
    );
  } else {
    $footer_logo_html = '<img class="footer__logo-image" src="' . esc_url((string) $logo_image['url']) . '" alt="' . esc_attr($footer_logo_alt) . '" loading="lazy" decoding="async" />';
  }
} elseif ('custom_logo' === $logo_mode && has_custom_logo()) {
  $custom_logo_id = absint((int) get_theme_mod('custom_logo'));
  if ($custom_logo_id) {
    $custom_logo_alt = get_post_meta($custom_logo_id, '_wp_attachment_image_alt', true);
    if (is_string($custom_logo_alt) && '' !== $custom_logo_alt) {
      $footer_logo_alt = $custom_logo_alt;
    }

    $footer_logo_html = wp_get_attachment_image(
      $custom_logo_id,
      'sc-logo',
      false,
      array(
        'class'    => 'footer__logo-image',
        'loading'  => 'lazy',
        'decoding' => 'async',
      )
    );
  }
}

$main_menu_location = '';
if (has_nav_menu('footer-main')) {
  $main_menu_location = 'footer-main';
} elseif (has_nav_menu('menu-footer')) {
  $main_menu_location = 'menu-footer';
}

$has_main_menu  = ! empty($footer_settings['show_main_menu']) && '' !== $main_menu_location;
$has_legal_menu = ! empty($footer_settings['show_legal_menu']) && has_nav_menu('footer-legal');

$column_locations = array('footer-col-1', 'footer-col-2');
if ('three' === $complex_columns) {
  $column_locations[] = 'footer-col-3';
}

$has_complex_columns = false;
foreach ($column_locations as $column_location) {
  if (has_nav_menu($column_location)) {
    $has_complex_columns = true;
    break;
  }
}

$legal_links = array();
if (! empty($footer_settings['legal_links']) && is_array($footer_settings['legal_links'])) {
  foreach ($footer_settings['legal_links'] as $legal_link_row) {
    if (! is_array($legal_link_row) || empty($legal_link_row['link']) || ! is_array($legal_link_row['link'])) {
      continue;
    }

    if (empty($legal_link_row['link']['url']) || empty($legal_link_row['link']['title'])) {
      continue;
    }

    $legal_links[] = $legal_link_row['link'];
  }
}

$copyright_text = isset($footer_settings['copyright_text']) ? trim((string) $footer_settings['copyright_text']) : '';
?>
<footer id="colophon" class="site-footer footer footer--layout-<?php echo esc_attr($layout); ?> footer--simple-<?php echo esc_attr($simple_columns); ?>">
  <div class="container footer__inner">
    <?php if ('complex' === $layout) : ?>
      <div class="footer__complex">
        <div class="footer__brand-column">
          <?php if ($show_logo) : ?>
            <a class="footer__logo-link" href="<?php echo esc_url(home_url('/')); ?>" rel="home">
              <?php if ($footer_logo_html) : ?>
                <?php echo $footer_logo_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
                ?>
              <?php else : ?>
                <span class="footer__site-name"><?php bloginfo('name'); ?></span>
              <?php endif; ?>
            </a>
          <?php endif; ?>

          <?php if ($show_social) : ?>
            <div class="footer__social" aria-label="<?php esc_attr_e('Social Media Links', 'starter-coat'); ?>">
              <?php
              get_template_part(
                'template-parts/components/social-links',
                null,
                array(
                  'style' => isset($footer_settings['social_style']) ? (string) $footer_settings['social_style'] : 'icon',
                  'size'  => 'sm',
                )
              );
              ?>
            </div>
          <?php endif; ?>
        </div>

        <?php if ($has_complex_columns || $has_main_menu) : ?>
          <div class="footer__menu-columns footer__menu-columns--<?php echo esc_attr($complex_columns); ?>">
            <?php
            foreach ($column_locations as $column_index => $column_location) {
              if (! has_nav_menu($column_location)) {
                continue;
              }

              $column_label = sprintf(
                /* translators: %d: footer column number. */
                __('Footer Column %d', 'starter-coat'),
                absint($column_index + 1)
              );
            ?>
              <nav class="footer__menu-group" aria-label="<?php echo esc_attr($column_label); ?>">
                <?php
                wp_nav_menu(
                  array(
                    'theme_location' => $column_location,
                    'container'      => false,
                    'menu_class'     => 'footer__menu',
                    'fallback_cb'    => false,
                  )
                );
                ?>
              </nav>
            <?php
            }
            ?>

            <?php if ($has_main_menu) : ?>
              <nav class="footer__menu-group" aria-label="<?php esc_attr_e('Footer Menu', 'starter-coat'); ?>">
                <?php
                wp_nav_menu(
                  array(
                    'theme_location' => $main_menu_location,
                    'container'      => false,
                    'menu_class'     => 'footer__menu',
                    'fallback_cb'    => false,
                  )
                );
                ?>
              </nav>
            <?php endif; ?>
          </div>
        <?php endif; ?>
      </div>
    <?php else : ?>
      <div class="footer__simple footer__simple--<?php echo esc_attr($simple_columns); ?>">
        <div class="footer__brand-column">
          <?php if ($show_logo) : ?>
            <a class="footer__logo-link" href="<?php echo esc_url(home_url('/')); ?>" rel="home">
              <?php if ($footer_logo_html) : ?>
                <?php echo $footer_logo_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
                ?>
              <?php else : ?>
                <span class="footer__site-name"><?php bloginfo('name'); ?></span>
              <?php endif; ?>
            </a>
          <?php endif; ?>

          <?php if ($show_social) : ?>
            <div class="footer__social" aria-label="<?php esc_attr_e('Social Media Links', 'starter-coat'); ?>">
              <?php
              get_template_part(
                'template-parts/components/social-links',
                null,
                array(
                  'style' => isset($footer_settings['social_style']) ? (string) $footer_settings['social_style'] : 'icon',
                  'size'  => 'sm',
                )
              );
              ?>
            </div>
          <?php endif; ?>
        </div>

        <?php if ('two' === $simple_columns && $has_main_menu) : ?>
          <nav class="footer__menu-group" aria-label="<?php esc_attr_e('Footer Menu', 'starter-coat'); ?>">
            <?php
            wp_nav_menu(
              array(
                'theme_location' => $main_menu_location,
                'container'      => false,
                'menu_class'     => 'footer__menu',
                'fallback_cb'    => false,
              )
            );
            ?>
          </nav>
        <?php endif; ?>
      </div>
    <?php endif; ?>

    <div class="footer__bottom">
      <p class="footer__meta">&copy; <?php echo esc_html(gmdate('Y')); ?> <?php bloginfo('name'); ?><?php if ('' !== $copyright_text) : ?>. <?php echo esc_html($copyright_text); ?><?php endif; ?></p>

      <?php if ($has_legal_menu || ! empty($legal_links)) : ?>
        <div class="footer__legal">
          <?php if ($has_legal_menu) : ?>
            <nav class="footer__legal-menu" aria-label="<?php esc_attr_e('Legal Links', 'starter-coat'); ?>">
              <?php
              wp_nav_menu(
                array(
                  'theme_location' => 'footer-legal',
                  'container'      => false,
                  'menu_class'     => 'footer__legal-list',
                  'fallback_cb'    => false,
                )
              );
              ?>
            </nav>
          <?php endif; ?>

          <?php if (! empty($legal_links)) : ?>
            <ul class="footer__legal-list footer__legal-list--extra">
              <?php foreach ($legal_links as $legal_link) : ?>
                <li>
                  <a href="<?php echo esc_url((string) $legal_link['url']); ?>" <?php echo ! empty($legal_link['target']) ? 'target="' . esc_attr((string) $legal_link['target']) . '"' : ''; ?>><?php echo esc_html((string) $legal_link['title']); ?></a>
                </li>
              <?php endforeach; ?>
            </ul>
          <?php endif; ?>
        </div>
      <?php endif; ?>
    </div>
  </div>
</footer>