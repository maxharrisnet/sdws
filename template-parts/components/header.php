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

$logo_max_width = absint( $nav['logo_max_width'] ) ?: 180;
$show_banner    = ! empty( $nav['banner_enabled'] ) && ! empty( $nav['banner_text'] );
$show_cta       = ! empty( $nav['show_cta'] ) && ! empty( $nav['cta_link']['url'] );
$cta_link       = $show_cta ? $nav['cta_link'] : null;
$cta_style      = esc_attr( $nav['cta_style'] ?: 'primary' );
?>

<div class="site-header-shell">

  <?php if ( $show_banner ) :
    $banner_map = array(
      'dark'  => 'background:#000; color:#fff;',
      'light' => 'background:var(--color-off-white,#f8f6f2); color:#000; border-bottom:1px solid #000;',
      'brand' => 'background:var(--color-primary,#3a9aaa); color:#fff;',
    );
    $banner_css = isset( $banner_map[ $nav['banner_style'] ] ) ? $banner_map[ $nav['banner_style'] ] : $banner_map['dark'];
    $banner_lnk = ! empty( $nav['banner_link']['url'] ) ? $nav['banner_link'] : null;
  ?>
  <div class="sdws-top-banner" style="<?php echo esc_attr( $banner_css ); ?> text-align:center; padding:0.5rem 1rem; font-size:0.875rem; font-weight:500;">
    <?php if ( $banner_lnk ) : ?>
      <a href="<?php echo esc_url( $banner_lnk['url'] ); ?>"
        <?php echo ! empty( $banner_lnk['target'] ) ? 'target="' . esc_attr( $banner_lnk['target'] ) . '"' : ''; ?>
        style="color:inherit; text-decoration:underline;">
        <?php echo esc_html( $nav['banner_text'] ); ?>
      </a>
    <?php else : ?>
      <?php echo esc_html( $nav['banner_text'] ); ?>
    <?php endif; ?>
  </div>
  <?php endif; ?>

  <header id="masthead" class="site-header header" role="banner">
    <div class="sdws-container" style="display:flex; align-items:center; justify-content:space-between; height:70px; gap:1.5rem;">

      <!-- Logo -->
      <?php if ( ! empty( $nav['show_logo'] ) ) : ?>
      <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" class="sdws-header__logo-link"
         aria-label="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?> — Home"
         style="flex-shrink:0; display:flex; align-items:center; text-decoration:none;">
        <?php
        $logo_mode     = $nav['logo_mode'] ?: 'custom_logo';
        $rendered_logo = false;

        if ( 'image' === $logo_mode && ! empty( $nav['logo_image']['ID'] ) ) :
          echo wp_get_attachment_image(
            absint( $nav['logo_image']['ID'] ),
            'sc-logo',
            false,
            array(
              'alt'      => esc_attr( get_bloginfo( 'name' ) ) . ' logo',
              'loading'  => 'eager',
              'decoding' => 'async',
              'style'    => 'max-width:' . $logo_max_width . 'px; height:auto; max-height:50px; display:block;',
            )
          );
          $rendered_logo = true;
        elseif ( 'custom_logo' === $logo_mode && has_custom_logo() ) :
          the_custom_logo();
          $rendered_logo = true;
        elseif ( 'site_name' === $logo_mode ) : ?>
          <span style="font-size:1.25rem; font-weight:700; color:#000; line-height:1.2;">
            <?php bloginfo( 'name' ); ?>
          </span>
          <?php $rendered_logo = true;
        endif;

        if ( ! $rendered_logo ) :
          if ( file_exists( STARTER_COAT_PATH . '/assets/images/sdws-logo.jpg' ) ) : ?>
            <img src="<?php echo esc_url( STARTER_COAT_URI . '/assets/images/sdws-logo.jpg' ); ?>"
                 alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?> logo"
                 height="50"
                 style="max-height:50px; width:auto; display:block;"
                 loading="eager" decoding="async">
          <?php else : ?>
            <span style="font-size:1.25rem; font-weight:700; color:#000; line-height:1.2;">
              San Diego<br>Watercolor Society
            </span>
          <?php endif;
        endif; ?>
        <span class="sdws-header__site-title" aria-hidden="true">
          <?php bloginfo( 'name' ); ?>
        </span>
      </a>
      <?php endif; ?>

      <!-- Desktop navigation -->
      <nav id="site-navigation" class="main-navigation sdws-header__nav" aria-label="Primary Menu"
           style="display:flex; align-items:center; gap:0;">
        <?php
        wp_nav_menu( array(
          'theme_location' => 'menu-1',
          'container'      => false,
          'walker'         => new SDWS_Primary_Nav_Walker(),
          'items_wrap'     => '<ul id="%1$s" class="%2$s" style="display:flex; align-items:center; gap:0.125rem; list-style:none; margin:0; padding:0;">%3$s</ul>',
          'fallback_cb'    => false,
        ) );
        ?>
      </nav>

      <!-- Optional nav CTA -->
      <?php if ( $show_cta ) : ?>
      <a href="<?php echo esc_url( $cta_link['url'] ); ?>"
         <?php echo ! empty( $cta_link['target'] ) ? 'target="' . esc_attr( $cta_link['target'] ) . '"' : ''; ?>
         style="flex-shrink:0; padding:0.5rem 1.25rem; font-size:0.875rem; font-weight:600;
                text-decoration:none; color:#fff; background:#000; border:2px solid #000; white-space:nowrap;">
        <?php echo esc_html( $cta_link['title'] ); ?>
      </a>
      <?php endif; ?>

      <!-- Mobile hamburger -->
      <button class="sdws-menu-toggle" aria-controls="sdws-mobile-menu" aria-expanded="false" aria-label="Open menu"
              style="display:none; flex-direction:column; gap:5px; background:none; border:none; cursor:pointer; padding:0.5rem;">
        <span style="display:block; width:24px; height:2px; background:#000;"></span>
        <span style="display:block; width:24px; height:2px; background:#000;"></span>
        <span style="display:block; width:24px; height:2px; background:#000;"></span>
      </button>

    </div><!-- .sdws-container -->
  </header>

  <!-- Mobile menu overlay -->
  <div id="sdws-mobile-menu" class="sdws-mobile-menu" aria-hidden="true"
       style="display:none; position:fixed; inset:0; background:#fff; z-index:500; overflow-y:auto; padding:2rem;">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:3rem; border-bottom:1px solid #000; padding-bottom:1.5rem;">
      <span style="font-size:1.25rem; font-weight:700;">SDWS</span>
      <button class="sdws-menu-close" aria-label="Close menu"
              style="background:none; border:none; cursor:pointer; font-size:1.5rem; line-height:1; padding:0.25rem;">
        ×
      </button>
    </div>
    <?php
    wp_nav_menu( array(
      'theme_location' => 'menu-1',
      'container'      => false,
      'walker'         => new SDWS_Mobile_Nav_Walker(),
      'items_wrap'     => '<ul class="%2$s" style="list-style:none; padding:0; margin:0; display:flex; flex-direction:column; gap:0;">%3$s</ul>',
      'fallback_cb'    => false,
      'depth'          => 2,
    ) );
    ?>
  </div>

</div><!-- .site-header-shell -->

<style>
/* Sticky header — overflow hidden prevents child content bursting layout width */
.site-header-shell { position: sticky; top: 0; z-index: 100; overflow: hidden; }
.site-header { background: #fff; border-bottom: 1px solid #f0f0f0; }

/* Site title lockup */
.sdws-header__site-title {
  font-family: var(--font-display);
  font-size: 1rem;
  font-weight: 400;
  letter-spacing: 0.06em;
  color: #000;
  line-height: 1.2;
  margin-left: 0.875rem;
  padding-left: 0.875rem;
  white-space: nowrap;
  /* No divider by default — added via class below */
}

/* Desktop nav — hide hamburger */
@media (min-width: 769px) {
  .sdws-menu-toggle { display: none !important; }
  .sdws-header__nav { display: flex !important; }
}

/* Mobile — hide desktop nav, show hamburger; hide site title */
@media (max-width: 768px) {
  .sdws-header__nav { display: none !important; }
  .sdws-menu-toggle { display: flex !important; }
  .sdws-header__site-title { display: none; }
}

/* Dropdown hover */
.sdws-dropdown:hover .sdws-dropdown__menu,
.sdws-dropdown:focus-within .sdws-dropdown__menu {
  display: block !important;
}

/* Remove border from last dropdown item */
.sdws-dropdown__menu li:last-child a {
  border-bottom: none;
}

/* Active nav link underline */
.sdws-header__nav a[aria-current="page"] {
  border-bottom: 2px solid #000;
}

/* Custom-logo sizing */
.sdws-header__logo-link .custom-logo {
  max-height: 50px;
  width: auto;
  display: block;
}
</style>

<script>
(function () {
  var toggle = document.querySelector('.sdws-menu-toggle');
  var menu   = document.getElementById('sdws-mobile-menu');
  var close  = document.querySelector('.sdws-menu-close');

  if (toggle && menu) {
    toggle.addEventListener('click', function () {
      var open = toggle.getAttribute('aria-expanded') === 'true';
      toggle.setAttribute('aria-expanded', String(!open));
      menu.setAttribute('aria-hidden', String(open));
      menu.style.display = open ? 'none' : 'block';
      document.body.style.overflow = open ? '' : 'hidden';
    });
  }

  if (close && menu) {
    close.addEventListener('click', function () {
      menu.style.display = 'none';
      menu.setAttribute('aria-hidden', 'true');
      if (toggle) toggle.setAttribute('aria-expanded', 'false');
      document.body.style.overflow = '';
    });
  }

  // Dropdown keyboard / click toggle
  document.querySelectorAll('.sdws-dropdown__toggle').forEach(function (btn) {
    btn.addEventListener('click', function () {
      var expanded = btn.getAttribute('aria-expanded') === 'true';
      btn.setAttribute('aria-expanded', String(!expanded));
      var dd = btn.nextElementSibling;
      if (dd) dd.style.display = expanded ? 'none' : 'block';
    });
  });
})();
</script>
