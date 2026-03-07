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

$show_branding  = ! empty($nav_settings['show_logo']);
$is_fixed       = ! empty($nav_settings['fixed']);
$show_cta       = ! empty($nav_settings['show_cta']) && ! empty($nav_settings['cta_link']['url']) && ! empty($nav_settings['cta_link']['title']);
$show_banner    = ! empty($nav_settings['banner_enabled']) && ! empty($nav_settings['banner_text']);

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

if ($is_fixed) {
  $header_classes[] = 'is-fixed';
}

$logo_style = 'max-width:' . absint((int) $nav_settings['logo_max_width']) . 'px;';
?>
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
        <?php if ('image' === $logo_mode && ! empty($logo_image['url'])) : ?>
          <a class="header__logo-link" href="<?php echo esc_url(home_url('/')); ?>" rel="home" style="<?php echo esc_attr($logo_style); ?>">
            <img class="header__logo-image" src="<?php echo esc_url($logo_image['url']); ?>" alt="<?php echo esc_attr($logo_image['alt'] ?? get_bloginfo('name')); ?>" />
          </a>
        <?php elseif ('site_name' === $logo_mode) : ?>
          <a class="header__logo-link" href="<?php echo esc_url(home_url('/')); ?>" rel="home" style="<?php echo esc_attr($logo_style); ?>">
            <span class="header__site-name"><?php bloginfo('name'); ?></span>
          </a>
        <?php else : ?>
          <?php if (has_custom_logo()) : ?>
            <div class="header__logo-custom" style="<?php echo esc_attr($logo_style); ?>"><?php the_custom_logo(); ?></div>
          <?php else : ?>
            <a class="header__logo-link" href="<?php echo esc_url(home_url('/')); ?>" rel="home" style="<?php echo esc_attr($logo_style); ?>">
              <span class="header__site-name"><?php bloginfo('name'); ?></span>
            </a>
          <?php endif; ?>
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
    </nav>
  </div>
</header>