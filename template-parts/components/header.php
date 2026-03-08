<?php

/**
 * Site header component.
 *
 * @package Starter_Coat
 */

$nav_settings = starter_coat_get_nav_settings();

$header_variant = sanitize_html_class((string) $nav_settings['variant']);
$header_style   = sanitize_html_class((string) $nav_settings['style']);
$header_align   = sanitize_html_class((string) $nav_settings['alignment']);
$item_style     = sanitize_html_class((string) $nav_settings['item_style']);
$item_shape     = sanitize_html_class((string) $nav_settings['item_shape']);
$dropdown_style = sanitize_html_class((string) $nav_settings['dropdown_style']);
$logo_mode      = sanitize_html_class((string) $nav_settings['logo_mode']);
$logo_image     = is_array($nav_settings['logo_image']) ? $nav_settings['logo_image'] : null;
$logo_mark_image = is_array($nav_settings['logo_mark_image']) ? $nav_settings['logo_mark_image'] : null;

$show_branding  = ! empty($nav_settings['show_logo']);
$is_fixed       = ! empty($nav_settings['fixed']);
$show_cta       = ! empty($nav_settings['show_cta']) && ! empty($nav_settings['cta_link']['url']) && ! empty($nav_settings['cta_link']['title']);
$show_banner    = ! empty($nav_settings['banner_enabled']) && ! empty($nav_settings['banner_text']);
$social_links   = function_exists('starter_coat_get_social_links') ? starter_coat_get_social_links() : array();
$show_social    = ! empty($nav_settings['show_social']) && ! empty($social_links);

$header_classes = array(
  'site-header',
  'header',
  'header--layout-' . $header_variant,
  'header--style-' . $header_style,
  'header--align-' . $header_align,
  'header--item-' . $item_style,
  'header--round-' . $item_shape,
  'header--dropdown-' . $dropdown_style,
);

$shell_classes = array('site-header-shell');
if ($is_fixed) {
  $shell_classes[] = 'is-fixed';
}

$logo_style = 'max-width:' . absint((int) $nav_settings['logo_max_width']) . 'px;';
$logo_mark_style = 'max-width:' . absint((int) $nav_settings['logo_mark_max_width']) . 'px;';
$logo_mark_breakpoint = absint((int) $nav_settings['logo_mark_breakpoint']);

$primary_logo_html = '';
$logo_mark_html = '';
$primary_logo_alt = get_bloginfo('name');

if ('image' === $logo_mode && ! empty($logo_image['url'])) {
  $logo_image_id = isset($logo_image['ID']) ? absint($logo_image['ID']) : 0;

  if (! empty($logo_image['alt'])) {
    $primary_logo_alt = (string) $logo_image['alt'];
  }

  if ($logo_image_id) {
    $primary_logo_html = wp_get_attachment_image(
      $logo_image_id,
      'sc-logo',
      false,
      array(
        'class'    => 'header__logo-image header__logo-primary',
        'loading'  => 'eager',
        'decoding' => 'async',
      )
    );
  } else {
    $primary_logo_html = '<img class="header__logo-image header__logo-primary" src="' . esc_url((string) $logo_image['url']) . '" alt="' . esc_attr($primary_logo_alt) . '" loading="eager" decoding="async" />';
  }
} elseif ('custom_logo' === $logo_mode && has_custom_logo()) {
  $custom_logo_id = absint((int) get_theme_mod('custom_logo'));
  if ($custom_logo_id) {
    $custom_logo_alt = get_post_meta($custom_logo_id, '_wp_attachment_image_alt', true);
    if (is_string($custom_logo_alt) && '' !== $custom_logo_alt) {
      $primary_logo_alt = $custom_logo_alt;
    }

    $primary_logo_html = wp_get_attachment_image(
      $custom_logo_id,
      'sc-logo',
      false,
      array(
        'class'    => 'header__logo-image header__logo-primary',
        'loading'  => 'eager',
        'decoding' => 'async',
      )
    );
  }
}

if (! empty($logo_mark_image['url'])) {
  $logo_mark_id = isset($logo_mark_image['ID']) ? absint($logo_mark_image['ID']) : 0;
  $logo_mark_alt = isset($logo_mark_image['alt']) && '' !== (string) $logo_mark_image['alt'] ? (string) $logo_mark_image['alt'] : $primary_logo_alt;

  if ($logo_mark_id) {
    $logo_mark_html = wp_get_attachment_image(
      $logo_mark_id,
      'sc-logo-mark',
      false,
      array(
        'class'    => 'header__logo-image header__logo-mark',
        'loading'  => 'eager',
        'decoding' => 'async',
        'style'    => $logo_mark_style,
      )
    );
  } else {
    $logo_mark_html = '<img class="header__logo-image header__logo-mark" src="' . esc_url((string) $logo_mark_image['url']) . '" alt="' . esc_attr($logo_mark_alt) . '" style="' . esc_attr($logo_mark_style) . '" loading="eager" decoding="async" />';
  }
}
?>
<div class="<?php echo esc_attr(implode(' ', $shell_classes)); ?>" data-fixed="<?php echo $is_fixed ? 'true' : 'false'; ?>" data-logo-mark-breakpoint="<?php echo esc_attr($logo_mark_breakpoint); ?>">
  <?php if ($show_banner) : ?>
    <div class="header-banner header-banner--<?php echo esc_attr($nav_settings['banner_style']); ?>">
      <div class="container header-banner__inner">
        <?php if (! empty($nav_settings['banner_link']['url']) && ! empty($nav_settings['banner_link']['title'])) : ?>
          <a href="<?php echo esc_url($nav_settings['banner_link']['url']); ?>" class="header-banner__link" <?php echo ! empty($nav_settings['banner_link']['target']) ? 'target="' . esc_attr($nav_settings['banner_link']['target']) . '"' : ''; ?>>
            <span class="header-banner__text"><?php echo esc_html($nav_settings['banner_text']); ?></span>
            <span class="header-banner__cta"><?php echo esc_html($nav_settings['banner_link']['title']); ?></span>
          </a>
        <?php else : ?>
          <p class="header-banner__text"><?php echo esc_html($nav_settings['banner_text']); ?></p>
        <?php endif; ?>
      </div>
    </div>
  <?php endif; ?>

  <header id="masthead" class="<?php echo esc_attr(implode(' ', $header_classes)); ?>" data-fixed="<?php echo $is_fixed ? 'true' : 'false'; ?>">
    <div class="container header__inner">
      <?php if ($show_branding) : ?>
        <div class="header__branding">
          <?php if ($primary_logo_html) : ?>
            <a class="header__logo-link" href="<?php echo esc_url(home_url('/')); ?>" rel="home" style="<?php echo esc_attr($logo_style); ?>">
              <?php echo $primary_logo_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
              ?>

              <?php if ($logo_mark_html) : ?>
                <?php echo $logo_mark_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                ?>
              <?php endif; ?>
            </a>
          <?php elseif ('site_name' === $logo_mode) : ?>
            <a class="header__logo-link" href="<?php echo esc_url(home_url('/')); ?>" rel="home" style="<?php echo esc_attr($logo_style); ?>">
              <span class="header__site-name"><?php bloginfo('name'); ?></span>
            </a>
          <?php else : ?>
            <a class="header__logo-link" href="<?php echo esc_url(home_url('/')); ?>" rel="home" style="<?php echo esc_attr($logo_style); ?>">
              <span class="header__site-name"><?php bloginfo('name'); ?></span>
            </a>
          <?php endif; ?>
        </div>
      <?php endif; ?>

      <button class="header__menu-toggle menu-toggle" aria-controls="primary-menu" aria-expanded="false" aria-label="<?php esc_attr_e('Toggle menu', 'starter-coat'); ?>">
        <span class="menu-toggle__line" aria-hidden="true"></span>
        <span class="menu-toggle__line" aria-hidden="true"></span>
        <span class="menu-toggle__line" aria-hidden="true"></span>
        <span class="screen-reader-text"><?php esc_html_e('Menu', 'starter-coat'); ?></span>
      </button>

      <nav id="site-navigation" class="main-navigation header__nav" aria-label="<?php esc_attr_e('Primary Menu', 'starter-coat'); ?>">
        <?php
        wp_nav_menu(
          array(
            'theme_location' => 'menu-1',
            'menu_id'        => 'primary-menu',
            'menu_class'     => 'header__menu',
            'container'      => false,
          )
        );
        ?>

        <?php if ($show_cta) : ?>
          <a class="header__cta btn btn--<?php echo esc_attr($nav_settings['cta_style']); ?> btn--sm" href="<?php echo esc_url($nav_settings['cta_link']['url']); ?>" <?php echo ! empty($nav_settings['cta_link']['target']) ? 'target="' . esc_attr($nav_settings['cta_link']['target']) . '"' : ''; ?>>
            <?php echo esc_html($nav_settings['cta_link']['title']); ?>
          </a>
        <?php endif; ?>

        <?php if ($show_social) : ?>
          <div class="header__social" aria-label="<?php esc_attr_e('Social Media Links', 'starter-coat'); ?>">
            <?php
            get_template_part(
              'template-parts/components/social-links',
              null,
              array(
                'style' => (string) $nav_settings['social_style'],
                'size'  => 'sm',
              )
            );
            ?>
          </div>
        <?php endif; ?>
      </nav>
    </div>
  </header>
</div>