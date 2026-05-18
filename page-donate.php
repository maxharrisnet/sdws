<?php

/**
 * Donate page template — San Diego Watercolor Society
 * Slug: donate
 * Content editable at: WP Admin > Pages > Donate
 *
 * @package Starter_Coat
 */

get_header();

$has_acf    = function_exists('get_field');
$headline   = $has_acf ? (get_field('donate_headline')   ?: 'Support the 46th International Exhibition') : 'Support the 46th International Exhibition';
$intro      = $has_acf ? (get_field('donate_intro')      ?: '') : '';
$deadline   = $has_acf ? (get_field('donate_deadline')   ?: 'July 24, 2026') : 'July 24, 2026';
$paypal_url = $has_acf ? (get_field('donate_paypal_url') ?: 'https://www.paypal.com/ncp/payment/KSDUHVURSRZSJ') : 'https://www.paypal.com/ncp/payment/KSDUHVURSRZSJ';
$form_url   = $has_acf ? (get_field('donate_form_url')   ?: 'https://sdws.dreamhosters.com/wp-content/uploads/2026/05/SDWS-IShow-2026-Donation-Form.pdf') : 'https://sdws.dreamhosters.com/wp-content/uploads/2026/05/SDWS-IShow-2026-Donation-Form.pdf';
$tax_note   = $has_acf ? (get_field('donate_tax_note')   ?: "SDWS is a 501(c)(3) nonprofit. Tax ID: 95-3153264.\nAll donations are tax-deductible to the extent allowed by law.") : "SDWS is a 501(c)(3) nonprofit. Tax ID: 95-3153264.\nAll donations are tax-deductible to the extent allowed by law.";

$default_intro = '<p>SDWS volunteers have been busy preparing for the San Diego Watercolor Society\'s 46th International Exhibition to be held during the month of October 2026. Ana Laura Salazar, SDWS will be selecting 105 paintings from some of the best watermedia artists in the world. Typically, we receive 600–800 entries from 20+ countries and 30+ states.</p>'
  . '<p>100% of the artist awards for the International Exhibition are funded through donations. Please consider donating to this year\'s show to help recognize the exceptional artists whose paintings will be exhibited. Everyone who contributes to an award will be acknowledged in the exhibition catalog. There are various ways to donate, and any amount will be very much appreciated.</p>';

if (empty(trim(strip_tags($intro)))) {
  $intro = $default_intro;
}

$cta_copy = 'Donate online via PayPal — please indicate the award you are contributing to in the &ldquo;Award Name&rdquo; box during checkout.'
  . ' Or <a href="' . esc_url($form_url) . '" target="_blank" rel="noopener noreferrer">download the Donations Form</a> and mail a check.';
?>

<main id="primary" class="site-main">

  <!-- Intro -->
  <section class="sdws-section sdws-donate">
    <div class="sdws-container">
      <div class="sdws-donate__intro-wrap">
        <h1 class="sdws-page-title"><?php echo esc_html($headline); ?></h1>
        <div class="sdws-donate__intro sdws-prose">
          <?php echo wp_kses_post($intro); ?>
        </div>
      </div>
    </div>
  </section>

  <!-- Placeholder banner image -->
  <div class="sdws-donate__banner">
    <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/pages/donate-banner.png'); ?>"
      alt="San Diego Watercolor Society — International Exhibition artwork"
      loading="lazy"
      decoding="async"
      class="sdws-donate__banner-img">
  </div>

  <!-- Award sections -->
  <section class="sdws-section">
    <div class="sdws-container">

      <div class="sdws-donate__sections">

        <div class="sdws-donate__award-group">
          <h2 class="sdws-donate__section-title">Present an award in your name</h2>
          <ul class="sdws-donate-list">
            <li><strong>$1,000</strong> — Silver Star Award named for the donor</li>
            <li><strong>$500</strong> — Award named for the donor</li>
          </ul>
        </div>

        <div class="sdws-donate__award-group">
          <h2 class="sdws-donate__section-title">Contribute to an existing group award</h2>
          <p class="sdws-donate__section-note">Donate any amount to one of the following:</p>
          <ul class="sdws-donate-list">
            <li>Board of Directors Award</li>
            <li>Past Presidents Award</li>
            <li>Signature Members Award</li>
            <li>TuesPM Mentor Art Group Award</li>
          </ul>
        </div>

        <div class="sdws-donate__award-group">
          <h2 class="sdws-donate__section-title">Create a new group award</h2>
          <p class="sdws-donate__section-body">Each group member donates smaller amounts that total at least $500. A great way to give together.</p>
        </div>

        <div class="sdws-donate__award-group">
          <h2 class="sdws-donate__section-title">Not part of a group?</h2>
          <p class="sdws-donate__section-note">Contribute individually to:</p>
          <ul class="sdws-donate-list">
            <li>Watermedia Enthusiasts Award — any amount welcome</li>
          </ul>
        </div>

      </div><!-- .sdws-donate__sections -->

      <div class="sdws-donate__deadline">
        <strong>Please send your gift by <?php echo esc_html($deadline); ?></strong> — so your name can be included in the exhibition catalog.
      </div>

    </div>
  </section>

  <!-- How to donate CTA -->
  <?php
  get_template_part('template-parts/components/cta', null, array(
    'cta' => array(
      'title'                  => 'How to Donate',
      'copy'                   => $cta_copy,
      'background'             => 'sand',
      'layout'                 => 'stacked',
      'text_box_style'         => 'none',
      'button_primary'         => array('title' => 'Donate via PayPal', 'url' => $paypal_url, 'target' => '_blank'),
      'button_primary_style'   => 'teal',
      'button_secondary'       => array('title' => 'Download Donations Form', 'url' => $form_url, 'target' => '_blank'),
      'button_secondary_style' => 'outline',
    ),
  ));
  ?>

  <!-- Tax note -->
  <section class="sdws-section sdws-donate__tax-section">
    <div class="sdws-container">
      <p class="sdws-donate-tax-note">
        <?php echo nl2br(esc_html($tax_note)); ?>
      </p>
    </div>
  </section>

</main>

<?php get_footer(); ?>