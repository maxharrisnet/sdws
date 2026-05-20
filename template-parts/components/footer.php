<?php

/**
 * SDWS site footer.
 *
 * @package Starter_Coat
 */

$address         = get_field('sc_footer_address', 'option')         ?: "SDWS Gallery\nBalboa Park\nSan Diego, California";
$maps_url        = get_field('sc_footer_maps_url', 'option')        ?: 'https://maps.google.com/?q=Balboa+Park+San+Diego+CA';
$show_social     = (bool) get_field('sc_footer_show_social', 'option');
$social_links    = ($show_social && function_exists('starter_coat_get_social_links')) ? starter_coat_get_social_links() : array();
$email_general   = get_field('sc_footer_email_general', 'option')   ?: 'support@sdws.org';
$email_registrar = get_field('sc_footer_email_registrar', 'option') ?: 'registrar@sdws.org';
$email_director  = get_field('sc_footer_email_director', 'option')  ?: 'workshops@sdws.org';
$financial_note  = get_field('sc_footer_financial_note', 'option')  ?: 'Financial support is provided by the City of San Diego.';
$copyright_text  = get_field('sc_footer_copyright_text', 'option')  ?: 'San Diego Watercolor Society | Tax ID: 95-3153264';

?>

<footer id="colophon" class="site-footer" role="contentinfo">
  <div class="sdws-container">

    <div class="sdws-footer__grid">

      <!-- Column 1: Location -->
      <div class="sdws-footer__col">
        <h3 class="sdws-footer__col-heading">Gallery Location</h3>
        <p class="sdws-footer__address">
          <?php echo nl2br(esc_html($address)); ?>
        </p>
        <a href="<?php echo esc_url($maps_url); ?>"
          target="_blank" rel="noopener"
          class="sdws-footer__directions-link">
          Get Directions →
        </a>
      </div>

      <!-- Column 2: Quick Links -->
      <div class="sdws-footer__col">
        <h3 class="sdws-footer__col-heading">Quick Links</h3>
        <?php
        if (has_nav_menu('footer-col-1')) :
          wp_nav_menu(array(
            'theme_location' => 'footer-col-1',
            'container'      => false,
            'walker'         => new SDWS_Footer_Nav_Walker(),
            'items_wrap'     => '<ul class="sdws-footer__links">%3$s</ul>',
            'depth'          => 1,
            'fallback_cb'    => false,
          ));
        else :
          $fallback_links = array(
            'Home'                     => home_url('/'),
            'Workshops'                => home_url('/workshops/'),
            'Exhibition Schedule'      => home_url('/schedule/'),
            'International Exhibition' => home_url('/international/'),
            'Calendar'                 => home_url('/calendar/'),
            'Donate'                   => home_url('/donate/'),
          );
        ?>
          <ul class="sdws-footer__links">
            <?php foreach ($fallback_links as $label => $url) : ?>
              <li><a href="<?php echo esc_url($url); ?>" class="sdws-footer__link"><?php echo esc_html($label); ?></a></li>
            <?php endforeach; ?>
          </ul>
        <?php endif; ?>
      </div>

      <!-- Column 3: Contact -->
      <div class="sdws-footer__col">
        <h3 class="sdws-footer__col-heading">Contact</h3>
        <ul class="sdws-footer__contact-list">
          <li class="sdws-footer__contact-item">
            <span class="sdws-footer__contact-label">General</span>
            <a href="mailto:<?php echo esc_attr($email_general); ?>" class="sdws-footer__link"><?php echo esc_html($email_general); ?></a>
          </li>
          <li class="sdws-footer__contact-item">
            <span class="sdws-footer__contact-label">Workshops</span>
            <a href="mailto:<?php echo esc_attr($email_registrar); ?>" class="sdws-footer__link"><?php echo esc_html($email_registrar); ?></a>
          </li>
          <li class="sdws-footer__contact-item">
            <span class="sdws-footer__contact-label">Workshop Director</span>
            <a href="mailto:<?php echo esc_attr($email_director); ?>" class="sdws-footer__link"><?php echo esc_html($email_director); ?></a>
          </li>
        </ul>
      </div>

    </div>

    <?php if (! empty($social_links)) : ?>
      <div class="sdws-footer__social">
        <span class="sdws-footer__social-label"><?php esc_html_e('Follow Us', 'starter-coat'); ?></span>
        <ul class="sdws-footer__social-list">
          <?php
          $social_labels = array(
            'facebook'  => 'Facebook',
            'instagram' => 'Instagram',
            'twitter'   => 'Twitter / X',
            'bluesky'   => 'BlueSky',
            'youtube'   => 'YouTube',
            'linkedin'  => 'LinkedIn',
            'tiktok'    => 'TikTok',
            'pinterest' => 'Pinterest',
            'github'    => 'GitHub',
          );
          foreach ($social_links as $platform => $url) :
            $label = isset($social_labels[$platform]) ? $social_labels[$platform] : ucfirst($platform);
          ?>
            <li>
              <a href="<?php echo esc_url($url); ?>"
                target="_blank" rel="noopener noreferrer"
                class="sdws-footer__social-link"
                aria-label="<?php echo esc_attr($label); ?>">
                <?php echo esc_html($label); ?>
              </a>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>
    <?php endif; ?>

    <div class="sdws-footer__bottom">
      <div class="sdws-footer__legal">
        <p class="sdws-footer__financial-note"><?php echo esc_html($financial_note); ?></p>
        <p class="sdws-footer__copyright">&copy; <?php echo esc_html(gmdate('Y')); ?> <?php echo esc_html($copyright_text); ?></p>
      </div>
      <ul class="sdws-footer__util-links">
        <li><a href="<?php echo esc_url(get_privacy_policy_url() ?: '#'); ?>" class="sdws-footer__util-link">Privacy Policy</a></li>
        <li><a href="#" class="sdws-footer__util-link">Opt-Out</a></li>
        <li><a href="mailto:<?php echo esc_attr($email_general); ?>?subject=Website Problem Report" class="sdws-footer__util-link">Report Website Problems</a></li>
      </ul>
    </div>

  </div>
</footer>