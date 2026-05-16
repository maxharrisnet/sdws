<?php

/**
 * Calendar page template — San Diego Watercolor Society
 * Slug: calendar
 *
 * @package Starter_Coat
 */

get_header();
?>

<main id="primary" class="site-main">

  <!-- Page header -->
  <section class="sdws-section" style="background:#fff; border-bottom: var(--border); padding-bottom:2.5rem; padding-top:3rem;">
    <div class="sdws-container">
      <h1 style="font-family:var(--font-display); font-size:clamp(2.5rem,5vw,4rem); margin:0 0 1rem; color:#000;">Calendar</h1>
      <p style="font-size:1.125rem; max-width:620px; line-height:1.7; margin:0; color:#000;">
        Stay up to date with SDWS exhibitions, receptions, workshops, and community events.
      </p>
    </div>
  </section>

  <!-- Calendar embed -->
  <section class="sdws-section" style="background:#fff;">
    <div class="sdws-container">
      <?php if ( function_exists( 'tribe_get_events' ) || shortcode_exists( 'tribe_events' ) ) : ?>
        <?php echo do_shortcode( '[tribe_events]' ); ?>
      <?php else : ?>
        <p style="color:#000; opacity:0.5; font-size:1rem;">
          The Events Calendar plugin is not active. Please install and activate it to display the calendar.
          <br><a href="<?php echo esc_url( admin_url( 'plugin-install.php?s=the-events-calendar&tab=search&type=term' ) ); ?>" style="color:#000; font-weight:500;">Install The Events Calendar →</a>
        </p>
      <?php endif; ?>
    </div>
  </section>

</main>

<?php get_footer(); ?>
