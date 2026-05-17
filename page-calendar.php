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
      <h1 style="font-size:clamp(2.5rem,5vw,4rem); margin:0 0 1rem; color:#000;">Calendar</h1>
      <p style="font-size:1.125rem; max-width:620px; line-height:1.7; margin:0; color:#000;">
        Stay up to date with SDWS exhibitions, receptions, workshops, and community events.
      </p>
    </div>
  </section>

  <!-- Calendar embed -->
  <section class="sdws-section sdws-calendar-section" style="background:#fff; padding-top:0; padding-bottom:0;">
    <?php if (function_exists('tribe_get_events')) : ?>
      <iframe
        id="sdws-calendar-iframe"
        data-tec-events-ece-iframe="true"
        src="<?php echo esc_url(get_field('calendar_embed_url', 'option')); ?>"
        frameborder="0"
        title="SDWS Events Calendar"
        style="display:block; width:100%;"></iframe>

      <?php
      $google_fonts_url = 'https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,500;0,9..40,700;1,9..40,400&display=swap';
      $calendar_css = <<<'CSS'
/* ── Reset ─────────────────────────────────────────────────────── */
*, *::before, *::after { border-radius: 0 !important; box-sizing: border-box; }

/* ── Container sizing ──────────────────────────────────────────── */
.tribe-common-l-container,
.tribe-events-l-container {

}

/* ── Fonts ──────────────────────────────────────────────────────── */
body, .tribe-common, .tribe-events,
.tribe-common *, .tribe-events * {
  font-family: 'DM Sans', sans-serif !important;
}
.tribe-events-pro-summary__event-title,
.tribe-events-calendar-list__event-title {
  font-family: 'DM Serif Display', serif !important;
}

/* ── Top-bar header: teal color block ──────────────────────────── */
/* Collapse any spacing between the teal bar and the day-of-week row */
.tribe-events-header {
  margin-bottom: 0 !important;
  padding-bottom: 0 !important;
}
.tribe-events-calendar-month {
  margin-top: 0 !important;
}

.tribe-events-c-top-bar {
  background-color: #3a9aaa;
  padding: 1.75rem 2rem;
  display: flex;
  align-items: center;
  gap: 1.25rem;
}

/* Month/year button */
.tribe-events-c-top-bar__datepicker-button {
  background: transparent;
  border: none;
  color: #fff !important;
  cursor: pointer;
  padding: 0;
  display: flex;
  align-items: center;
  gap: 0.5rem;
}
.tribe-events-c-top-bar__datepicker-desktop {
  font-family: 'DM Sans', sans-serif !important;
  font-size: clamp(1.125rem, 2.5vw, 1.5rem) !important;
  font-weight: 700 !important;
  letter-spacing: 0.06em;
  text-transform: uppercase;
  color: #fff !important;
  line-height: 1;
}
/* Caret icon */
.tribe-events-c-top-bar__datepicker-button .tribe-common-c-svgicon path,
.tribe-events-c-top-bar__datepicker-button .tribe-common-c-svgicon__svg-fill {
  fill: #fff !important;
}

/* Prev/next arrow buttons */
.tribe-events-c-top-bar__nav-link {
  background: transparent;
  border: 1px solid rgba(255,255,255,0.5);
  color: #fff;
  padding: 0.3rem 0.5rem;
  cursor: pointer;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  transition: border-color 0.15s, background 0.15s;
}
.tribe-events-c-top-bar__nav-link:hover:not([disabled]) {
  background: rgba(255,255,255,0.15);
  border-color: #fff;
}
.tribe-events-c-top-bar__nav-link[disabled] { opacity: 0.35; }
.tribe-events-c-top-bar__nav-link .tribe-common-c-svgicon path {
  fill: #fff !important;
}

/* "This Month" button */
.tribe-events-c-top-bar__today-button {
  font-size: 0.75rem !important;
  font-weight: 600 !important;
  letter-spacing: 0.08em;
  text-transform: uppercase;
  color: #fff !important;
  border: 1px solid rgba(255,255,255,0.6) !important;
  background: transparent !important;
  padding: 0.3rem 0.75rem !important;
  text-decoration: none;
  white-space: nowrap;
  transition: background 0.15s, border-color 0.15s;
}
.tribe-events-c-top-bar__today-button:hover {
  background: rgba(255,255,255,0.15) !important;
  border-color: #fff !important;
}

/* ── Day-of-week header row: black block ───────────────────────── */
.tribe-events-calendar-month__header {
  background: #000;
}
.tribe-events-calendar-month__header-column {
  font-size: 0.8125rem !important;
  font-weight: 900 !important;
  letter-spacing: 0.18em;
  text-transform: uppercase;
  color: #fff !important;
  padding: 1rem 0.75rem !important;
  text-align: center;
}
.tribe-events-calendar-month__header-column-title { color: #fff !important; }

/* ── Calendar grid ─────────────────────────────────────────────── */
.tribe-events-calendar-month__day {
  border-right: 1px solid #d0ccc8;
  border-bottom: 1px solid #d0ccc8;
}

/* ── Date number ───────────────────────────────────────────────── */
.tribe-events-calendar-month__day-date {
  font-size: 1.375rem !important;
  font-weight: 400 !important;
  line-height: 1 !important;
  margin: 0 !important;
  padding: 0.6rem 0.75rem 0.4rem !important;
  font-family: 'DM Serif Display', serif !important;
}
.tribe-events-calendar-month__day-date-daynum { display: block; }
.tribe-events-calendar-month__day-date-link {
  color: #000;
  text-decoration: none;
  font-size: inherit !important;
}
.tribe-events-calendar-month__day-date-link:hover { color: #3a9aaa; }

/* ── Past days ─────────────────────────────────────────────────── */
.tribe-events-calendar-month__day--past .tribe-events-calendar-month__day-cell--desktop {
  background: #f0ede8;
}
.tribe-events-calendar-month__day--past .tribe-events-calendar-month__day-date-link { color: #999; }

/* ── Cells WITH events: teal color block ───────────────────────── */
.tribe-events-calendar-month__day-cell--desktop:has(.tribe-events-calendar-month__calendar-event) {
  background-color: #3a9aaa;
}
.tribe-events-calendar-month__day-cell--desktop:has(.tribe-events-calendar-month__calendar-event)
  .tribe-events-calendar-month__day-date,
.tribe-events-calendar-month__day-cell--desktop:has(.tribe-events-calendar-month__calendar-event)
  .tribe-events-calendar-month__day-date-link {
  color: #fff;
}
.tribe-events-calendar-month__day-cell--desktop:has(.tribe-events-calendar-month__calendar-event)
  .tribe-events-calendar-month__day-date-link:hover {
  color: rgba(255,255,255,0.75);
}

/* ── Today: subtle border-bottom, no fill ──────────────────────── */
.tribe-events-calendar-month__day--current .tribe-events-calendar-month__day-cell--desktop {
  border-bottom: 3px solid #3a9aaa;
}
.tribe-events-calendar-month__day--current
  .tribe-events-calendar-month__day-date-link {
  color: #3a9aaa;
  font-weight: 700;
}
/* today + has events: teal tile already shows, just bold the date */
.tribe-events-calendar-month__day--current
  .tribe-events-calendar-month__day-cell--desktop:has(.tribe-events-calendar-month__calendar-event)
  .tribe-events-calendar-month__day-date-link {
  color: #fff;
  font-weight: 700;
}

/* ── Event items ───────────────────────────────────────────────── */
.tribe-events-calendar-month__calendar-event {
  padding: 0 0.75rem 0.5rem;
}
.tribe-events-calendar-month__calendar-event-title {
  font-size: 0.8125rem !important;
  font-weight: 600 !important;
  line-height: 1.35 !important;
}
.tribe-events-calendar-month__calendar-event-title-link {
  color: #fff !important;
  text-decoration: none;
}
.tribe-events-calendar-month__calendar-event-title-link:hover { text-decoration: underline; }
.tribe-events-calendar-month__calendar-event-datetime { display: none; }

/* ── View switcher ─────────────────────────────────────────────── */
.tribe-events-c-view-selector__list-item-link {
  font-size: 0.75rem;
  font-weight: 600;
  letter-spacing: 0.08em;
  text-transform: uppercase;
  border: 1px solid rgba(255,255,255,0.6);
  color: #fff;
  background: transparent;
  padding: 0.3rem 0.75rem;
  text-decoration: none;
}
.tribe-events-c-view-selector__list-item-link--is-active,
.tribe-events-c-view-selector__list-item-link:hover {
  background: rgba(255,255,255,0.2);
  border-color: #fff;
}

/* ── List view ─────────────────────────────────────────────────── */
.tribe-events-calendar-list__event-row { border-top: 1px solid #000; padding: 1.5rem 1.5rem; }
.tribe-events-calendar-list__event-title {
  font-size: clamp(1.25rem, 2.5vw, 1.75rem) !important;
  font-weight: 400 !important;
  margin: 0 0 0.25rem !important;
}
.tribe-events-calendar-list__event-title-link { color: #000; text-decoration: none; }
.tribe-events-calendar-list__event-title-link:hover { color: #3a9aaa; }
.tribe-events-calendar-list__event-datetime,
.tribe-events-calendar-list__event-date-tag-datetime {
  font-size: 0.8125rem;
  font-weight: 600;
  letter-spacing: 0.06em;
  text-transform: uppercase;
  color: #000;
}
.tribe-events-calendar-list__event-cost { color: #c4703a; font-weight: 700; }

/* ── Mobile dot ────────────────────────────────────────────────── */
.tribe-events-calendar-month__mobile-events-icon--event::before {
  background-color: #3a9aaa !important;
}

/* ── Date picker popup ─────────────────────────────────────────── */
.datepicker.datepicker-dropdown {
  background: #fff;
  border: 1px solid #000 !important;
  box-shadow: none !important;
  padding: 1.25rem 1rem;
  min-width: 240px;
  font-family: 'DM Sans', sans-serif;
}
/* Year / decade navigation row */
.datepicker .datepicker-switch {
  font-family: 'DM Sans', sans-serif;
  font-size: 0.875rem;
  font-weight: 700;
  letter-spacing: 0.06em;
  text-transform: uppercase;
  color: #000;
  background: transparent;
  border: none;
  cursor: pointer;
}
.datepicker .prev,
.datepicker .next {
  background: transparent;
  border: 1px solid #000;
  color: #000;
  cursor: pointer;
  padding: 0.2rem 0.5rem;
  font-size: 0.75rem;
}
.datepicker .prev:hover,
.datepicker .next:hover {
  background: #000;
  color: #fff;
}
/* Month grid */
.datepicker .datepicker-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 0.375rem;
  margin-top: 0.75rem;
}
.datepicker .month {
  font-family: 'DM Sans', sans-serif;
  font-size: 0.8125rem;
  font-weight: 500;
  color: #000;
  background: transparent;
  border: 1px solid transparent;
  padding: 0.5rem 0.25rem;
  cursor: pointer;
  text-align: center;
  transition: background 0.12s, color 0.12s;
}
.datepicker .month:hover { background: #f0ede8; }
.datepicker .month.past { color: #999; }
/* Current calendar month */
.datepicker .month.current {
  border-color: #3a9aaa;
  color: #3a9aaa;
  font-weight: 700;
}
/* Active / selected month */
.datepicker .month.active,
.datepicker .month.focused.active {
  background: #3a9aaa !important;
  color: #fff !important;
  border-color: #3a9aaa !important;
}
/* Year and decade buttons follow same pattern */
.datepicker .year,
.datepicker .decade,
.datepicker .century {
  font-family: 'DM Sans', sans-serif;
  font-size: 0.8125rem;
  font-weight: 500;
  color: #000;
  background: transparent;
  border: 1px solid transparent;
  padding: 0.4rem;
  cursor: pointer;
  text-align: center;
}
.datepicker .year:hover,
.datepicker .decade:hover,
.datepicker .century:hover { background: #f0ede8; }
.datepicker .year.active,
.datepicker .decade.active,
.datepicker .century.active {
  background: #3a9aaa !important;
  color: #fff !important;
}
.datepicker .year.current,
.datepicker .decade.current,
.datepicker .century.current {
  border-color: #3a9aaa;
  color: #3a9aaa;
  font-weight: 700;
}
.datepicker .year.past,
.datepicker .decade.past { color: #999; }

/* ── Category labels ───────────────────────────────────────────── */
.tribe-event-categories a {
  font-size: 0.6875rem;
  font-weight: 700;
  letter-spacing: 0.1em;
  text-transform: uppercase;
  color: #3a9aaa;
  text-decoration: none;
}
CSS;
      ?>
      <script>
        (function() {
          var iframe = document.getElementById('sdws-calendar-iframe');
          if (!iframe) return;

          function injectStyles() {
            try {
              var doc = iframe.contentDocument || iframe.contentWindow.document;
              if (!doc || !doc.head) return;

              // Inject Google Fonts link if not already present
              if (!doc.getElementById('sdws-cal-fonts')) {
                var link = doc.createElement('link');
                link.id = 'sdws-cal-fonts';
                link.rel = 'stylesheet';
                link.href = <?php echo json_encode($google_fonts_url); ?>;
                doc.head.appendChild(link);
              }

              // Inject or refresh custom styles
              var existing = doc.getElementById('sdws-cal-styles');
              if (existing) existing.remove();
              var style = doc.createElement('style');
              style.id = 'sdws-cal-styles';
              style.textContent = <?php echo json_encode($calendar_css); ?>;
              doc.head.appendChild(style);
            } catch (e) {
              console.warn('SDWS calendar style injection failed:', e);
            }
          }

          // Initial inject after load
          if (iframe.contentDocument && iframe.contentDocument.readyState === 'complete') {
            injectStyles();
          } else {
            iframe.addEventListener('load', injectStyles);
          }

          // Re-inject after TEC AJAX navigation swaps the DOM
          iframe.addEventListener('load', injectStyles);
        }());
      </script>
    <?php else : ?>
      <div class="sdws-container" style="padding-top:3rem; padding-bottom:3rem;">
        <p style="color:#000; opacity:0.5; font-size:1rem;">
          The Events Calendar plugin is not active. Please install and activate it to display the calendar.
          <br><a href="<?php echo esc_url(admin_url('plugin-install.php?s=the-events-calendar&tab=search&type=term')); ?>" style="color:#000; font-weight:500;">Install The Events Calendar →</a>
        </p>
      </div>
    <?php endif; ?>
  </section>

</main>

<?php get_footer(); ?>