<?php

/**
 * SDWS site header.
 *
 * Pulls logo, CTA, and banner from Theme Settings → Navigation (ACF options).
 * Primary menu is driven by the "Primary" (menu-1) menu location.
 *
 * @package Starter_Coat
 */

$nav = starter_coat_get_nav_settings();

$logo_max_width = absint($nav['logo_max_width']) ?: 180;
$show_banner    = ! empty($nav['banner_enabled']) && ! empty($nav['banner_text']);
$show_cta       = ! empty($nav['show_cta']) && ! empty($nav['cta_link']['url']);
$cta_link       = $show_cta ? $nav['cta_link'] : null;
$cta_style      = esc_attr($nav['cta_style'] ?: 'primary');
?>

<div class="site-header-shell">

  <?php if ($show_banner) :
    $banner_style_map = array(
      'dark'  => 'dark',
      'light' => 'light',
      'brand' => 'brand',
    );
    $banner_modifier = isset($banner_style_map[$nav['banner_style']]) ? $banner_style_map[$nav['banner_style']] : 'dark';
    $banner_lnk = ! empty($nav['banner_link']['url']) ? $nav['banner_link'] : null;
  ?>
    <div class="sdws-top-banner sdws-top-banner--<?php echo esc_attr($banner_modifier); ?>">
      <?php if ($banner_lnk) : ?>
        <a href="<?php echo esc_url($banner_lnk['url']); ?>"
          <?php echo ! empty($banner_lnk['target']) ? 'target="' . esc_attr($banner_lnk['target']) . '"' : ''; ?>
          class="sdws-top-banner__link">
          <?php echo esc_html($nav['banner_text']); ?>
        </a>
      <?php else : ?>
        <?php echo esc_html($nav['banner_text']); ?>
      <?php endif; ?>
    </div>
  <?php endif; ?>

  <header id="masthead" class="site-header header" role="banner">
    <div class="sdws-container sdws-header__inner">

      <!-- Logo -->
      <?php if (! empty($nav['show_logo'])) : ?>
        <a href="<?php echo esc_url(home_url('/')); ?>" rel="home" class="sdws-header__logo-link"
          aria-label="<?php echo esc_attr(get_bloginfo('name')); ?> — Home">
          <?php
          $logo_mode     = $nav['logo_mode'] ?: 'custom_logo';
          $rendered_logo = false;

          if ('image' === $logo_mode && ! empty($nav['logo_image']['ID'])) :
            echo wp_get_attachment_image(
              absint($nav['logo_image']['ID']),
              'sc-logo',
              false,
              array(
                'alt'      => esc_attr(get_bloginfo('name')) . ' logo',
                'loading'  => 'eager',
                'decoding' => 'async',
                'class'    => 'sdws-header__logo-img',
                // max-width is a dynamic PHP value — must stay inline
                'style'    => 'max-width:' . $logo_max_width . 'px',
              )
            );
            $rendered_logo = true;
          elseif ('custom_logo' === $logo_mode && has_custom_logo()) :
            the_custom_logo();
            $rendered_logo = true;
          elseif ('site_name' === $logo_mode) : ?>
            <span class="sdws-header__site-name">
              <?php bloginfo('name'); ?>
            </span>
            <?php $rendered_logo = true;
          endif;

          if (! $rendered_logo) :
            if (file_exists(STARTER_COAT_PATH . '/assets/images/sdws-logo.jpg')) : ?>
              <img src="<?php echo esc_url(STARTER_COAT_URI . '/assets/images/sdws-logo.jpg'); ?>"
                alt="<?php echo esc_attr(get_bloginfo('name')); ?> logo"
                height="50"
                class="sdws-header__logo-img-fallback"
                loading="eager" decoding="async">
            <?php else : ?>
              <span class="sdws-header__site-name">
                San Diego<br>Watercolor Society
              </span>
          <?php endif;
          endif; ?>
          <span class="sdws-header__site-title" aria-hidden="true">
            <?php bloginfo('name'); ?>
          </span>
        </a>
      <?php endif; ?>

      <!-- Desktop navigation -->
      <nav id="site-navigation" class="main-navigation sdws-header__nav" aria-label="Primary Menu">
        <?php
        wp_nav_menu(array(
          'theme_location' => 'menu-1',
          'container'      => false,
          'walker'         => new SDWS_Primary_Nav_Walker(),
          'items_wrap'     => '<ul id="%1$s" class="%2$s sdws-header__nav-list">%3$s</ul>',
          'fallback_cb'    => false,
        ));
        ?>
      </nav>

      <!-- Optional nav CTA -->
      <?php if ($show_cta) : ?>
        <a href="<?php echo esc_url($cta_link['url']); ?>"
          <?php echo ! empty($cta_link['target']) ? 'target="' . esc_attr($cta_link['target']) . '"' : ''; ?>
          class="sdws-header__cta">
          <?php echo esc_html($cta_link['title']); ?>
        </a>
      <?php endif; ?>

      <!-- Mobile hamburger -->
      <button class="sdws-menu-toggle" aria-controls="sdws-mobile-menu" aria-expanded="false" aria-label="Open menu">
        <span class="sdws-menu-toggle__bar"></span>
        <span class="sdws-menu-toggle__bar"></span>
        <span class="sdws-menu-toggle__bar"></span>
      </button>

    </div><!-- .sdws-container -->
  </header>

  <!-- Mobile menu overlay -->
  <div id="sdws-mobile-menu" class="sdws-mobile-menu" aria-hidden="true">
    <div class="sdws-mobile-menu__header">
      <span class="sdws-mobile-menu__title">SDWS</span>
      <button class="sdws-menu-close" aria-label="Close menu">
        &times;
      </button>
    </div>
    <?php
    wp_nav_menu(array(
      'theme_location' => 'menu-1',
      'container'      => false,
      'walker'         => new SDWS_Mobile_Nav_Walker(),
      'items_wrap'     => '<ul class="%2$s sdws-mobile-nav-list">%3$s</ul>',
      'fallback_cb'    => false,
      'depth'          => 2,
    ));
    ?>
  </div>

</div><!-- .site-header-shell -->

<script>
  (function() {
    var toggle = document.querySelector('.sdws-menu-toggle');
    var menu = document.getElementById('sdws-mobile-menu');
    var close = document.querySelector('.sdws-menu-close');

    if (toggle && menu) {
      toggle.addEventListener('click', function() {
        var open = toggle.getAttribute('aria-expanded') === 'true';
        toggle.setAttribute('aria-expanded', String(!open));
        menu.setAttribute('aria-hidden', String(open));
        menu.style.display = open ? 'none' : 'block';
        document.body.style.overflow = open ? '' : 'hidden';
      });
    }

    if (close && menu) {
      close.addEventListener('click', function() {
        menu.style.display = 'none';
        menu.setAttribute('aria-hidden', 'true');
        if (toggle) toggle.setAttribute('aria-expanded', 'false');
        document.body.style.overflow = '';
      });
    }

    // Dropdown keyboard / click toggle
    document.querySelectorAll('.sdws-dropdown__toggle').forEach(function(btn) {
      btn.addEventListener('click', function() {
        var expanded = btn.getAttribute('aria-expanded') === 'true';
        btn.setAttribute('aria-expanded', String(!expanded));
        var dd = btn.nextElementSibling;
        if (dd) dd.style.display = expanded ? 'none' : 'block';
      });
    });
  })();
</script>
