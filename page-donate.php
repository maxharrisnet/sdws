<?php

/**
 * Donate page template — San Diego Watercolor Society
 * Slug: donate
 * Content editable at: WP Admin > Pages > Donate
 *
 * @package Starter_Coat
 */

get_header();

$headline    = function_exists('get_field') ? (get_field('donate_headline')   ?: 'THANK YOU for considering a donation to the San Diego Watercolor Society.') : 'THANK YOU for considering a donation to the San Diego Watercolor Society.';
$intro       = function_exists('get_field') ? (get_field('donate_intro')      ?: 'A gift from you can help SDWS enrich lives through experiencing watermedia painting.')  : 'A gift from you can help SDWS enrich lives through experiencing watermedia painting.';
$bullets     = function_exists('get_field') ? (get_field('donate_bullets')    ?: array()) : array();
$paypal_url  = function_exists('get_field') ? (get_field('donate_paypal_url') ?: 'https://www.paypal.com/ncp/payment/KSDUHVURSRZSJ') : 'https://www.paypal.com/ncp/payment/KSDUHVURSRZSJ';
$tax_note    = function_exists('get_field') ? (get_field('donate_tax_note')   ?: "SDWS is a 501(c)(3) nonprofit. Tax ID: 95-3153264.\nAll donations are tax-deductible to the extent allowed by law.") : "SDWS is a 501(c)(3) nonprofit. Tax ID: 95-3153264.\nAll donations are tax-deductible to the extent allowed by law.";

if (empty($bullets)) {
  $bullets = array(
    array('bullet_text' => 'The free SDWS Gallery offers monthly Member Exhibits, Special Exhibits and the Annual International Exhibition, which attracts hundreds of exceptional artists from all over the world.'),
    array('bullet_text' => 'Painting classes are available for elementary school children and adult painters at all skill levels.'),
    array('bullet_text' => 'Each week, community residents and SDWS members experience plein air painting at beautiful sites throughout San Diego County.'),
  );
}
?>

<main id="primary" class="site-main">

  <section class="sdws-section sdws-section--lg sdws-donate">
    <div class="sdws-container">

      <h1 class="sdws-page-title">
        <?php echo esc_html($headline); ?>
      </h1>

      <?php if ($intro) : ?>
        <p class="sdws-page-intro sdws-donate__intro">
          <?php echo esc_html($intro); ?>
        </p>
      <?php endif; ?>

      <?php if (!empty($bullets)) : ?>
        <ul class="sdws-donate-bullets">
          <?php foreach ($bullets as $item) : ?>
            <li class="sdws-donate-bullets__item">
              <span class="sdws-donate-bullets__arrow" aria-hidden="true">→</span>
              <span><?php echo wp_kses_post($item['bullet_text']); ?></span>
            </li>
          <?php endforeach; ?>
        </ul>
      <?php endif; ?>

      <?php if ($paypal_url) : ?>
        <div class="sdws-donate-btn">
          <a href="<?php echo esc_url($paypal_url); ?>"
            target="_blank"
            rel="noopener noreferrer"
            class="sdws-btn sdws-btn--teal sdws-btn--lg">
            Donate via PayPal
          </a>
        </div>
      <?php endif; ?>

      <?php if ($tax_note) : ?>
        <p class="sdws-donate-tax-note">
          <?php echo nl2br(esc_html($tax_note)); ?>
        </p>
      <?php endif; ?>

    </div>
  </section>

</main>

<?php get_footer(); ?>
