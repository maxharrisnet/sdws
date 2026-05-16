<?php

/**
 * SDWS site footer.
 *
 * @package Starter_Coat
 */

?>

<footer id="colophon" class="site-footer" role="contentinfo"
        style="background:#000; color:#fff; padding:4rem 0 2rem;">
  <div class="sdws-container">

    <!-- 3-column grid -->
    <div style="display:grid; grid-template-columns:repeat(3,1fr); gap:3rem; margin-bottom:3rem; border-bottom:1px solid #333; padding-bottom:3rem;">

      <!-- Column 1: Location -->
      <div>
        <h3 style="font-family:var(--font-body); font-size:0.75rem; letter-spacing:0.12em; text-transform:uppercase; font-weight:500; color:#fff; margin:0 0 1.25rem; opacity:0.6;">
          Gallery Location
        </h3>
        <p style="font-size:0.9375rem; line-height:1.7; color:#fff; margin:0 0 0.75rem;">
          SDWS Gallery<br>
          Balboa Park<br>
          San Diego, California
        </p>
        <a href="https://maps.google.com/?q=Balboa+Park+San+Diego+CA"
           target="_blank" rel="noopener"
           style="font-size:0.875rem; color:#fff; font-weight:500; text-decoration:none; border-bottom:1px solid #fff;">
          Get Directions →
        </a>
      </div>

      <!-- Column 2: Quick Links -->
      <div>
        <h3 style="font-family:var(--font-body); font-size:0.75rem; letter-spacing:0.12em; text-transform:uppercase; font-weight:500; color:#fff; margin:0 0 1.25rem; opacity:0.6;">
          Quick Links
        </h3>
        <ul style="list-style:none; padding:0; margin:0; display:flex; flex-direction:column; gap:0.625rem;">
          <?php
          $quick_links = array(
            'Home'                    => home_url('/'),
            'Workshops'               => home_url('/workshops/'),
            'Exhibition Schedule'     => home_url('/schedule/'),
            'International Exhibition'=> home_url('/international/'),
            'Calendar'                => home_url('/calendar/'),
            'Donate'                  => home_url('/donate/'),
          );
          foreach ($quick_links as $label => $url) :
          ?>
            <li>
              <a href="<?php echo esc_url($url); ?>"
                 style="font-size:0.9375rem; color:#fff; text-decoration:none; opacity:0.85;">
                <?php echo esc_html($label); ?>
              </a>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>

      <!-- Column 3: Contact -->
      <div>
        <h3 style="font-family:var(--font-body); font-size:0.75rem; letter-spacing:0.12em; text-transform:uppercase; font-weight:500; color:#fff; margin:0 0 1.25rem; opacity:0.6;">
          Contact
        </h3>
        <ul style="list-style:none; padding:0; margin:0; display:flex; flex-direction:column; gap:0.75rem;">
          <li>
            <span style="font-size:0.8rem; text-transform:uppercase; letter-spacing:0.08em; opacity:0.6; display:block; margin-bottom:0.2rem;">General</span>
            <a href="mailto:support@sdws.org" style="font-size:0.9375rem; color:#fff; text-decoration:none;">support@sdws.org</a>
          </li>
          <li>
            <span style="font-size:0.8rem; text-transform:uppercase; letter-spacing:0.08em; opacity:0.6; display:block; margin-bottom:0.2rem;">Workshops</span>
            <a href="mailto:registrar@sdws.org" style="font-size:0.9375rem; color:#fff; text-decoration:none;">registrar@sdws.org</a>
          </li>
          <li>
            <span style="font-size:0.8rem; text-transform:uppercase; letter-spacing:0.08em; opacity:0.6; display:block; margin-bottom:0.2rem;">Workshop Director</span>
            <a href="mailto:workshops@sdws.org" style="font-size:0.9375rem; color:#fff; text-decoration:none;">workshops@sdws.org</a>
          </li>
        </ul>
      </div>

    </div>
    <!-- /3-column grid -->

    <!-- Financial support & copyright -->
    <div style="display:flex; flex-wrap:wrap; justify-content:space-between; align-items:start; gap:1rem;">
      <div>
        <p style="font-size:0.875rem; color:#fff; opacity:0.6; margin:0 0 0.375rem; line-height:1.6;">
          Financial support is provided by the City of San Diego.
        </p>
        <p style="font-size:0.8125rem; color:#fff; opacity:0.5; margin:0;">
          &copy; <?php echo esc_html(gmdate('Y')); ?> San Diego Watercolor Society &nbsp;|&nbsp; Tax ID: 95-3153264
        </p>
      </div>
      <ul style="list-style:none; padding:0; margin:0; display:flex; flex-wrap:wrap; gap:1.25rem; align-items:center;">
        <li>
          <a href="<?php echo esc_url( get_privacy_policy_url() ?: '#' ); ?>"
             style="font-size:0.8125rem; color:#fff; opacity:0.6; text-decoration:none;">
            Privacy Policy
          </a>
        </li>
        <li>
          <a href="#" style="font-size:0.8125rem; color:#fff; opacity:0.6; text-decoration:none;">
            Opt-Out
          </a>
        </li>
        <li>
          <a href="mailto:support@sdws.org?subject=Website Problem Report"
             style="font-size:0.8125rem; color:#fff; opacity:0.6; text-decoration:none;">
            Report Website Problems
          </a>
        </li>
      </ul>
    </div>

  </div><!-- .sdws-container -->
</footer>

<style>
@media (max-width: 768px) {
  .site-footer .sdws-container > div:first-child {
    grid-template-columns: 1fr !important;
  }
}
</style>
