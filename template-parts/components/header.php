<?php

/**
 * SDWS site header.
 *
 * @package Starter_Coat
 */

$logo_path = STARTER_COAT_URI . '/assets/images/sdws-logo.jpg';
?>

<div class="site-header-shell">
  <header id="masthead" class="site-header header" role="banner">
    <div class="sdws-container" style="display:flex; align-items:center; justify-content:space-between; height:70px; gap:1.5rem;">

      <!-- Logo -->
      <a href="<?php echo esc_url( home_url('/') ); ?>" rel="home" class="sdws-header__logo-link" aria-label="<?php bloginfo('name'); ?> — Home"
         style="flex-shrink:0; display:flex; align-items:center; text-decoration:none;">
        <?php if ( file_exists( STARTER_COAT_PATH . '/assets/images/sdws-logo.jpg' ) ) : ?>
          <img src="<?php echo esc_url( $logo_path ); ?>" alt="San Diego Watercolor Society logo" height="50" style="max-height:50px; width:auto; display:block;" loading="eager">
        <?php else : ?>
          <span style="font-family:var(--font-display); font-size:1.25rem; font-weight:400; color:#000; line-height:1.2;">
            San Diego<br>Watercolor Society
          </span>
        <?php endif; ?>
      </a>

      <!-- Desktop navigation -->
      <nav id="site-navigation" class="main-navigation sdws-header__nav" aria-label="Primary Menu"
           style="display:flex; align-items:center; gap:0.25rem; list-style:none; margin:0; padding:0;">
        <ul style="display:flex; align-items:center; gap:0.125rem; list-style:none; margin:0; padding:0;">

          <li>
            <a href="<?php echo esc_url( home_url('/') ); ?>"
               style="padding:0.5rem 0.875rem; font-size:0.9rem; font-weight:400; letter-spacing:0.02em; color:#000; text-decoration:none; display:block;"
               <?php if ( is_front_page() ) echo 'aria-current="page"'; ?>>
              Home
            </a>
          </li>

          <li>
            <a href="<?php echo esc_url( home_url('/donate/') ); ?>"
               style="padding:0.5rem 0.875rem; font-size:0.9rem; font-weight:400; letter-spacing:0.02em; color:#000; text-decoration:none; display:block;"
               <?php if ( is_page('donate') ) echo 'aria-current="page"'; ?>>
              Donate
            </a>
          </li>

          <li>
            <a href="<?php echo esc_url( home_url('/workshops/') ); ?>"
               style="padding:0.5rem 0.875rem; font-size:0.9rem; font-weight:400; letter-spacing:0.02em; color:#000; text-decoration:none; display:block;"
               <?php if ( is_page('workshops') || is_post_type_archive('sdws_workshop') || is_singular('sdws_workshop') ) echo 'aria-current="page"'; ?>>
              Workshops
            </a>
          </li>

          <!-- Exhibitions dropdown -->
          <li class="sdws-dropdown" style="position:relative;">
            <button class="sdws-dropdown__toggle"
                    aria-expanded="false" aria-haspopup="true"
                    style="padding:0.5rem 0.875rem; font-size:0.9rem; font-weight:400; letter-spacing:0.02em; color:#000; background:none; border:none; cursor:pointer; display:flex; align-items:center; gap:0.375rem; font-family:var(--font-body);">
              Exhibitions
              <svg width="10" height="6" viewBox="0 0 10 6" fill="none" aria-hidden="true">
                <path d="M1 1l4 4 4-4" stroke="#000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </button>
            <ul class="sdws-dropdown__menu"
                style="display:none; position:absolute; top:100%; left:0; background:#fff; border:1px solid #000; min-width:220px; list-style:none; margin:0; padding:0; z-index:200;">
              <li>
                <a href="<?php echo esc_url( home_url('/schedule/') ); ?>"
                   style="padding:0.75rem 1rem; font-size:0.9rem; color:#000; text-decoration:none; display:block; border-bottom:1px solid #000;">
                  Exhibition Schedule
                </a>
              </li>
              <li>
                <a href="<?php echo esc_url( home_url('/international/') ); ?>"
                   style="padding:0.75rem 1rem; font-size:0.9rem; color:#000; text-decoration:none; display:block;">
                  International Exhibition
                </a>
              </li>
            </ul>
          </li>

          <li>
            <a href="<?php echo esc_url( home_url('/calendar/') ); ?>"
               style="padding:0.5rem 0.875rem; font-size:0.9rem; font-weight:400; letter-spacing:0.02em; color:#000; text-decoration:none; display:block;"
               <?php if ( is_page('calendar') ) echo 'aria-current="page"'; ?>>
              Calendar
            </a>
          </li>

        </ul>
      </nav>

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
      <span style="font-family:var(--font-display); font-size:1.25rem;">SDWS</span>
      <button class="sdws-menu-close" aria-label="Close menu"
              style="background:none; border:none; cursor:pointer; font-size:1.5rem; line-height:1; padding:0.25rem;">
        ×
      </button>
    </div>
    <ul style="list-style:none; padding:0; margin:0; display:flex; flex-direction:column; gap:0;">
      <?php
      $mobile_links = array(
        'Home'                    => home_url('/'),
        'Donate'                  => home_url('/donate/'),
        'Workshops'               => home_url('/workshops/'),
        'Exhibition Schedule'     => home_url('/schedule/'),
        'International Exhibition'=> home_url('/international/'),
        'Calendar'                => home_url('/calendar/'),
      );
      foreach ($mobile_links as $label => $url) :
      ?>
        <li style="border-bottom:1px solid #000;">
          <a href="<?php echo esc_url($url); ?>"
             style="display:block; padding:1rem 0; font-family:var(--font-display); font-size:1.5rem; color:#000; text-decoration:none;">
            <?php echo esc_html($label); ?>
          </a>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>

</div><!-- .site-header-shell -->

<style>
/* Sticky header */
.site-header-shell { position: sticky; top: 0; z-index: 100; }

/* Desktop nav — hide hamburger */
@media (min-width: 769px) {
  .sdws-menu-toggle { display: none !important; }
  .sdws-header__nav { display: flex !important; }
}

/* Mobile — hide desktop nav, show hamburger */
@media (max-width: 768px) {
  .sdws-header__nav { display: none !important; }
  .sdws-menu-toggle { display: flex !important; }
}

/* Dropdown hover */
.sdws-dropdown:hover .sdws-dropdown__menu,
.sdws-dropdown:focus-within .sdws-dropdown__menu {
  display: block !important;
}

/* Active nav link underline */
.sdws-header__nav a[aria-current="page"],
.sdws-header__nav button[aria-current="page"] {
  border-bottom: 2px solid #000;
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
      if (toggle) {
        toggle.setAttribute('aria-expanded', 'false');
      }
      document.body.style.overflow = '';
    });
  }

  // Dropdown keyboard
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
