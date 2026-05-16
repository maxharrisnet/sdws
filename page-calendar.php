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
      <?php if (function_exists('tribe_get_events') || shortcode_exists('tribe_events')) : ?>

        <style scoped>
          iframe[data-tec-events-ece-iframe="true"] {
            width: 100%;
            height: calc(100vw + 100px);
            max-width: 100%;
          }

          @media screen and (min-width: 600px) {
            iframe[data-tec-events-ece-iframe="true"] {
              height: 100vw;
            }
          }

          @media screen and (min-width: 853px) {
            iframe[data-tec-events-ece-iframe="true"] {
              height: 1065px;
            }
          }
        </style> <iframe data-tec-events-ece-iframe="true" src="http://sdws.local/calendar-embed/wBsn4PCa0Cz/embed/" frameborder="0"></iframe> <?php else : ?>
        <p style="color:#000; opacity:0.5; font-size:1rem;">
          The Events Calendar plugin is not active. Please install and activate it to display the calendar.
          <br><a href="<?php echo esc_url(admin_url('plugin-install.php?s=the-events-calendar&tab=search&type=term')); ?>" style="color:#000; font-weight:500;">Install The Events Calendar →</a>
        </p>
      <?php endif; ?>
    </div>
  </section>

</main>

<?php get_footer(); ?>