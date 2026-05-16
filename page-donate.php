<?php

/**
 * Donate page template — San Diego Watercolor Society
 * Slug: donate
 *
 * @package Starter_Coat
 */

get_header();
?>

<main id="primary" class="site-main">

  <section class="sdws-section sdws-section--lg" style="background:#fff;">
    <div class="sdws-container" style="max-width:680px; text-align:center;">

      <h1 style="font-family:var(--font-display); font-size:clamp(2.5rem,5vw,4rem); margin:0 0 1.5rem; color:#000;">
        Support SDWS
      </h1>

      <p style="font-size:1.125rem; line-height:1.75; margin:0 0 2rem; color:#000;">
        Your gift sustains a vibrant watercolor arts community in San Diego. Every contribution directly supports:
      </p>

      <ul style="list-style:none; padding:0; margin:0 0 2.5rem; text-align:left; display:inline-block;">
        <li style="padding:0.75rem 0; border-top: 1px solid #000; font-size:1.0625rem; line-height:1.6; display:flex; gap:1rem; align-items:start;">
          <span style="font-size:1.25rem; flex-shrink:0; margin-top:0.1em;">→</span>
          <span>The <strong>SDWS Gallery</strong> in Balboa Park — free and open to the public year-round, showcasing member and international exhibitions.</span>
        </li>
        <li style="padding:0.75rem 0; border-top: 1px solid #000; font-size:1.0625rem; line-height:1.6; display:flex; gap:1rem; align-items:start;">
          <span style="font-size:1.25rem; flex-shrink:0; margin-top:0.1em;">→</span>
          <span><strong>Classes, workshops, and mentorships</strong> — from beginner Zoom sessions to master workshops with nationally recognized instructors.</span>
        </li>
        <li style="padding:0.75rem 0; border-top: 1px solid #000; border-bottom: 1px solid #000; font-size:1.0625rem; line-height:1.6; display:flex; gap:1rem; align-items:start;">
          <span style="font-size:1.25rem; flex-shrink:0; margin-top:0.1em;">→</span>
          <span><strong>Plein air painting events</strong> and community programs that bring watercolor into public spaces across San Diego.</span>
        </li>
      </ul>

      <div class="sdws-donate-btn">
        <a href="https://www.paypal.com/ncp/payment/KSDUHVURSRZSJ"
           target="_blank"
           rel="noopener noreferrer"
           class="sdws-btn sdws-btn--teal"
           style="font-size:1.125rem; padding:1.125rem 2.75rem;">
          Donate via PayPal
        </a>
      </div>

      <p style="margin-top:1.5rem; font-size:0.875rem; color:#000; opacity:0.6;">
        SDWS is a 501(c)(3) nonprofit. Tax ID: 95-3153264.<br>
        All donations are tax-deductible to the extent allowed by law.
      </p>

    </div>
  </section>

</main>

<?php get_footer(); ?>
