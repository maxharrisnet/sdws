<?php

/**
 * International Exhibition page template — San Diego Watercolor Society
 * Slug: international
 *
 * @package Starter_Coat
 */

get_header();
?>

<main id="primary" class="site-main">

  <!-- Hero block -->
  <section class="sdws-section sdws-section--teal" style="border-bottom: 2px solid #000;">
    <div class="sdws-container" style="max-width:860px;">
      <p style="font-size:0.8125rem; letter-spacing:0.12em; text-transform:uppercase; font-weight:500; margin-bottom:1rem; color:#fff; opacity:0.8;">
        San Diego Watercolor Society
      </p>
      <h1 style="font-family:var(--font-display); font-size:clamp(2.5rem,5vw,4rem); color:#fff; margin:0 0 1rem; line-height:1.1;">
        46th International Exhibition
      </h1>
      <p style="font-size:1.25rem; color:#fff; font-weight:500; margin:0 0 0.5rem;">
        September 27 – October 31, 2026
      </p>
      <p style="font-size:1rem; color:#fff; margin:0 0 2rem;">
        Awards: $30,000+
      </p>
      <div style="display:flex; gap:1rem; flex-wrap:wrap;">
        <a href="#key-dates" class="sdws-btn sdws-btn--white">View Key Dates</a>
        <a href="#" class="sdws-btn" style="border-color:#fff; color:#fff; background:transparent;">Download Prospectus</a>
      </div>
    </div>
  </section>

  <!-- Introduction -->
  <section class="sdws-section" style="background:#fff; border-bottom: var(--border);">
    <div class="sdws-container" style="max-width:820px;">
      <h2 style="font-family:var(--font-display); font-size:2.25rem; margin:0 0 1.5rem; color:#000;">About the Exhibition</h2>
      <p style="font-size:1.125rem; line-height:1.75; margin:0 0 1rem; color:#000;">
        The San Diego Watercolor Society's Annual International Exhibition is one of the premier juried watercolor exhibitions in the United States. Open to watercolor artists worldwide, the exhibition showcases excellence in the medium and awards over $30,000 in prizes.
      </p>
      <p style="font-size:1.125rem; line-height:1.75; margin:0 0 1rem; color:#000;">
        Works are selected by an internationally recognized juror. All entries must be original watercolor paintings completed within the past three years and not previously exhibited in an SDWS show.
      </p>
      <p style="font-size:1.125rem; line-height:1.75; margin:0; color:#000;">
        The exhibition is free and open to the public at the SDWS Gallery in Balboa Park, San Diego, California.
      </p>
    </div>
  </section>

  <!-- Key Dates -->
  <section id="key-dates" class="sdws-section" style="background: var(--color-off-white); border-bottom: var(--border);">
    <div class="sdws-container" style="max-width:820px;">
      <h2 style="font-family:var(--font-display); font-size:2.25rem; margin:0 0 2rem; color:#000;">Key Dates</h2>
      <table style="width:100%; border-collapse:collapse; font-size:1rem;">
        <tbody>
          <?php
          $dates = array(
            array( 'Online Entry Opens',      'TBD' ),
            array( 'Entry Deadline',           'TBD' ),
            array( 'Jury Date',                'TBD' ),
            array( 'Notification of Results',  'TBD' ),
            array( 'Delivery of Accepted Work','TBD' ),
            array( 'Exhibition Opens',         'September 27, 2026' ),
            array( 'Opening Reception',        'TBD' ),
            array( 'Exhibition Closes',        'October 31, 2026' ),
            array( 'Return of Work',           'TBD' ),
          );
          foreach ( $dates as $row ) :
          ?>
            <tr style="border-top: 1px solid #000;">
              <td style="padding:0.875rem 1.5rem 0.875rem 0; font-weight:500; white-space:nowrap; vertical-align:top;">
                <?php echo esc_html( $row[0] ); ?>
              </td>
              <td style="padding:0.875rem 0; vertical-align:top; color:#000;">
                <?php echo esc_html( $row[1] ); ?>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </section>

  <!-- Juror -->
  <section class="sdws-section" style="background:#fff; border-bottom: var(--border);">
    <div class="sdws-container" style="max-width:820px;">
      <h2 style="font-family:var(--font-display); font-size:2.25rem; margin:0 0 2rem; color:#000;">Juror</h2>
      <div style="display:grid; grid-template-columns:200px 1fr; gap:2.5rem; align-items:start;">
        <!-- Juror photo placeholder -->
        <div style="background:var(--color-sand); aspect-ratio:3/4; display:flex; align-items:center; justify-content:center;">
          <span style="font-size:0.75rem; letter-spacing:0.08em; text-transform:uppercase; opacity:0.4; text-align:center; padding:1rem;">Photo<br>Placeholder</span>
        </div>
        <div>
          <h3 style="font-family:var(--font-display); font-size:2rem; margin:0 0 0.25rem; color:#000;">Ana Laura Salazar</h3>
          <p style="font-size:0.875rem; letter-spacing:0.08em; text-transform:uppercase; font-weight:500; margin:0 0 1.25rem; color:#000;">Juror, 46th International Exhibition</p>
          <p style="font-size:1rem; line-height:1.75; margin:0 0 1rem; color:#000;">
            Ana Laura Salazar is an internationally acclaimed watercolor artist and educator whose work has been exhibited in galleries across the Americas, Europe, and Asia. A signature member of the National Watercolor Society and the American Watercolor Society, her paintings are held in private and corporate collections worldwide.
          </p>
          <p style="font-size:1rem; line-height:1.75; margin:0; color:#000;">
            Salazar is known for her luminous, expressive approach to the medium and her dedication to advancing watercolor as a fine art. She teaches workshops internationally and serves on the faculty of several prominent art institutions.
          </p>
        </div>
      </div>
    </div>
  </section>

  <!-- Links -->
  <section class="sdws-section" style="background: var(--color-aqua-light);">
    <div class="sdws-container" style="max-width:820px;">
      <h2 style="font-family:var(--font-display); font-size:2rem; margin:0 0 1.5rem; color:#000;">Entry Resources</h2>
      <ul style="list-style:none; padding:0; margin:0; display:flex; flex-direction:column; gap:0.75rem;">
        <li>
          <a href="#" class="sdws-btn sdws-btn--outline" style="display:inline-block;">
            Download Prospectus (PDF)
          </a>
        </li>
        <li>
          <a href="#" class="sdws-btn sdws-btn--outline" style="display:inline-block;">
            Framing Requirements (PDF)
          </a>
        </li>
        <li>
          <a href="#" class="sdws-btn sdws-btn--outline" style="display:inline-block;">
            OJS CFE Online Entry Instructions
          </a>
        </li>
      </ul>
    </div>
  </section>

</main>

<?php get_footer(); ?>
