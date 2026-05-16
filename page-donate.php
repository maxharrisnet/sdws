<?php

/**
 * Donate page template — San Diego Watercolor Society
 * Slug: donate
 * Content editable at: WP Admin > SDWS Content > Donate
 *
 * @package Starter_Coat
 */

get_header();

// ── Helper ──────────────────────────────────────────────────────────────────
if (!function_exists('sdws_opt')) {
  function sdws_opt($key, $fallback = '') {
    if (!function_exists('get_field')) return $fallback;
    $val = get_field($key, 'option');
    return ($val !== false && $val !== '') ? $val : $fallback;
  }
}

// ── Fields ──────────────────────────────────────────────────────────────────
$headline    = sdws_opt('donate_headline', 'Support SDWS');
$intro       = sdws_opt('donate_intro',   'Your gift sustains a vibrant watercolor arts community in San Diego. Every contribution directly supports:');
$bullets     = function_exists('get_field') ? get_field('donate_bullets', 'option') : array();
$paypal_url  = sdws_opt('donate_paypal_url', 'https://www.paypal.com/ncp/payment/KSDUHVURSRZSJ');
$tax_note    = sdws_opt('donate_tax_note', "SDWS is a 501(c)(3) nonprofit. Tax ID: 95-3153264.\nAll donations are tax-deductible to the extent allowed by law.");

// ── Default bullets ──────────────────────────────────────────────────────────
if (empty($bullets)) {
  $bullets = array(
    array('bullet_text' => 'The <strong>SDWS Gallery</strong> in Balboa Park — free and open to the public year-round, showcasing member and international exhibitions.'),
    array('bullet_text' => '<strong>Classes, workshops, and mentorships</strong> — from beginner Zoom sessions to master workshops with nationally recognized instructors.'),
    array('bullet_text' => '<strong>Plein air painting events</strong> and community programs that bring watercolor into public spaces across San Diego.'),
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
