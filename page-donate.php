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

$s1_heading = $has_acf ? (get_field('donate_s1_heading') ?: 'Present an award in your name') : 'Present an award in your name';
$s1_awards  = ($has_acf && get_field('donate_s1_awards')) ? get_field('donate_s1_awards') : array(
  array('amount' => '$1,000', 'name' => 'Silver Star Award', 'meta' => 'Named for the donor'),
  array('amount' => '$500',   'name' => 'Award',             'meta' => 'Named for the donor'),
);
$s2_heading = $has_acf ? (get_field('donate_s2_heading') ?: 'Contribute to an existing group award') : 'Contribute to an existing group award';
$s2_note    = $has_acf ? (get_field('donate_s2_note') ?: 'Donate any amount to one of the following:') : 'Donate any amount to one of the following:';
$s2_awards  = ($has_acf && get_field('donate_s2_awards')) ? get_field('donate_s2_awards') : array(
  array('name' => 'Board of Directors Award'),
  array('name' => 'Past Presidents Award'),
  array('name' => 'Signature Members Award'),
  array('name' => 'TuesPM Mentor Art Group Award'),
);
$s3_heading = $has_acf ? (get_field('donate_s3_heading') ?: 'Create a new group award') : 'Create a new group award';
$s3_body    = $has_acf ? (get_field('donate_s3_body') ?: 'Each group member donates smaller amounts that total at least $500. A great way to give together.') : 'Each group member donates smaller amounts that total at least $500. A great way to give together.';
$s4_heading = $has_acf ? (get_field('donate_s4_heading') ?: 'Not part of a group?') : 'Not part of a group?';
$s4_note    = $has_acf ? (get_field('donate_s4_note') ?: 'Contribute individually to:') : 'Contribute individually to:';
$s4_awards  = ($has_acf && get_field('donate_s4_awards')) ? get_field('donate_s4_awards') : array(
  array('name' => 'Watermedia Enthusiasts Award', 'meta' => 'Any amount welcome'),
);
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
        <a href="#donate-now" class="sdws-btn sdws-btn--teal">Donate Now</a>
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

        <!-- Section 1: Donor-named awards -->
        <div class="sdws-donate__award-section">
          <h2 class="sdws-donate__section-title"><?php echo esc_html($s1_heading); ?></h2>
          <div class="sdws-donate__award-row">
            <?php foreach ($s1_awards as $award) : ?>
              <div class="sdws-donate__award-box">
                <?php if (! empty($award['amount'])) : ?>
                  <span class="sdws-donate__award-amount"><?php echo esc_html($award['amount']); ?></span>
                <?php endif; ?>
                <span class="sdws-donate__award-name"><?php echo esc_html($award['name']); ?></span>
                <?php if (! empty($award['meta'])) : ?>
                  <span class="sdws-donate__award-meta"><?php echo esc_html($award['meta']); ?></span>
                <?php endif; ?>
              </div>
            <?php endforeach; ?>
          </div>
        </div>

        <!-- Section 2: Existing group awards -->
        <div class="sdws-donate__award-section">
          <h2 class="sdws-donate__section-title"><?php echo esc_html($s2_heading); ?></h2>
          <p class="sdws-donate__section-note"><?php echo esc_html($s2_note); ?></p>
          <div class="sdws-donate__award-row">
            <?php foreach ($s2_awards as $award) : ?>
              <div class="sdws-donate__award-box">
                <span class="sdws-donate__award-name"><?php echo esc_html($award['name']); ?></span>
              </div>
            <?php endforeach; ?>
          </div>
        </div>

        <!-- Section 3: Create a group award -->
        <div class="sdws-donate__award-group">
          <h2 class="sdws-donate__section-title"><?php echo esc_html($s3_heading); ?></h2>
          <p class="sdws-donate__section-body"><?php echo esc_html($s3_body); ?></p>
        </div>

        <!-- Section 4: Individual / open awards -->
        <div class="sdws-donate__award-section">
          <h2 class="sdws-donate__section-title"><?php echo esc_html($s4_heading); ?></h2>
          <p class="sdws-donate__section-note"><?php echo esc_html($s4_note); ?></p>
          <div class="sdws-donate__award-row">
            <?php foreach ($s4_awards as $award) : ?>
              <div class="sdws-donate__award-box sdws-donate__award-box--wide">
                <span class="sdws-donate__award-name"><?php echo esc_html($award['name']); ?></span>
                <?php if (! empty($award['meta'])) : ?>
                  <span class="sdws-donate__award-meta"><?php echo esc_html($award['meta']); ?></span>
                <?php endif; ?>
              </div>
            <?php endforeach; ?>
          </div>
        </div>

      </div><!-- .sdws-donate__sections -->

      <div class="sdws-donate__deadline">
        <strong>Please send your gift by <?php echo esc_html($deadline); ?></strong> — so your name can be included in the exhibition catalog.
      </div>

    </div>
  </section>

  <!-- How to donate CTA -->
  <div id="donate-now">
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
  </div><!-- #donate-now -->

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