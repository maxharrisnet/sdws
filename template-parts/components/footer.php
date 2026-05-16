<?php

/**
 * SDWS site footer.
 *
 * @package Starter_Coat
 */

$address1       = get_field('sc_footer_address_line1', 'option')   ?: 'SDWS Gallery';
$address2       = get_field('sc_footer_address_line2', 'option')   ?: 'Balboa Park, San Diego, California';
$maps_url       = get_field('sc_footer_maps_url', 'option')        ?: 'https://maps.google.com/?q=Balboa+Park+San+Diego+CA';
$email_general  = get_field('sc_footer_email_general', 'option')   ?: 'support@sdws.org';
$email_registrar = get_field('sc_footer_email_registrar', 'option') ?: 'registrar@sdws.org';
$email_director = get_field('sc_footer_email_director', 'option')  ?: 'workshops@sdws.org';
$financial_note = get_field('sc_footer_financial_note', 'option')  ?: 'Financial support is provided by the City of San Diego.';
$copyright_text = get_field('sc_footer_copyright_text', 'option')  ?: 'San Diego Watercolor Society | Tax ID: 95-3153264';

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
          <?php echo esc_html($address1); ?><br>
          <?php echo esc_html($address2); ?>
        </p>
        <a href="<?php echo esc_url($maps_url); ?>"
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
        <?php
        $footer_menu_location = has_nav_menu( 'footer-col-1' ) ? 'footer-col-1' : ( has_nav_menu( 'footer-main' ) ? 'footer-main' : '' );
        if ( $footer_menu_location ) :
          wp_nav_menu( array(
            'theme_location' => $footer_menu_location,
            'container'      => false,
            'walker'         => new SDWS_Footer_Nav_Walker(),
            'items_wrap'     => '<ul class="%2$s" style="list-style:none; padding:0; margin:0; display:flex; flex-direction:column; gap:0.625rem;">%3$s</ul>',
            'depth'          => 1,
            'fallback_cb'    => false,
          ) );
        else :
          // Fallback when no menu is assigned yet
          $fallback_links = array(
            'Home'                     => home_url( '/' ),
            'Workshops'                => home_url( '/workshops/' ),
            'Exhibition Schedule'      => home_url( '/schedule/' ),
            'International Exhibition' => home_url( '/international/' ),
            'Calendar'                 => home_url( '/calendar/' ),
            'Donate'                   => home_url( '/donate/' ),
          );
        ?>
        <ul style="list-style:none; padding:0; margin:0; display:flex; flex-direction:column; gap:0.625rem;">
          <?php foreach ( $fallback_links as $label => $url ) : ?>
            <li>
              <a href="<?php echo esc_url( $url ); ?>"
                 style="font-size:0.9375rem; color:#fff; text-decoration:none; opacity:0.85;">
                <?php echo esc_html( $label ); ?>
              </a>
            </li>
          <?php endforeach; ?>
        </ul>
        <?php endif; ?>
      </div>

      <!-- Column 3: Contact -->
      <div>
        <h3 style="font-family:var(--font-body); font-size:0.75rem; letter-spacing:0.12em; text-transform:uppercase; font-weight:500; color:#fff; margin:0 0 1.25rem; opacity:0.6;">
          Contact
        </h3>
        <ul style="list-style:none; padding:0; margin:0; display:flex; flex-direction:column; gap:0.75rem;">
          <li>
            <span style="font-size:0.8rem; text-transform:uppercase; letter-spacing:0.08em; opacity:0.6; display:block; margin-bottom:0.2rem;">General</span>
            <a href="mailto:<?php echo esc_attr($email_general); ?>" style="font-size:0.9375rem; color:#fff; text-decoration:none;"><?php echo esc_html($email_general); ?></a>
          </li>
          <li>
            <span style="font-size:0.8rem; text-transform:uppercase; letter-spacing:0.08em; opacity:0.6; display:block; margin-bottom:0.2rem;">Workshops</span>
            <a href="mailto:<?php echo esc_attr($email_registrar); ?>" style="font-size:0.9375rem; color:#fff; text-decoration:none;"><?php echo esc_html($email_registrar); ?></a>
          </li>
          <li>
            <span style="font-size:0.8rem; text-transform:uppercase; letter-spacing:0.08em; opacity:0.6; display:block; margin-bottom:0.2rem;">Workshop Director</span>
            <a href="mailto:<?php echo esc_attr($email_director); ?>" style="font-size:0.9375rem; color:#fff; text-decoration:none;"><?php echo esc_html($email_director); ?></a>
          </li>
        </ul>
      </div>

    </div>
    <!-- /3-column grid -->

    <!-- Financial support & copyright -->
    <div style="display:flex; flex-wrap:wrap; justify-content:space-between; align-items:start; gap:1rem;">
      <div>
        <p style="font-size:0.875rem; color:#fff; opacity:0.6; margin:0 0 0.375rem; line-height:1.6;">
          <?php echo esc_html($financial_note); ?>
        </p>
        <p style="font-size:0.8125rem; color:#fff; opacity:0.5; margin:0;">
          &copy; <?php echo esc_html(gmdate('Y')); ?> <?php echo esc_html($copyright_text); ?>
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
          <a href="mailto:<?php echo esc_attr($email_general); ?>?subject=Website Problem Report"
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
