<?php

/**
 * Exhibition schedule page template — San Diego Watercolor Society
 * Slug: schedule
 *
 * @package Starter_Coat
 */

get_header();
?>

<main id="primary" class="site-main">

  <!-- Page header -->
  <section class="sdws-section" style="background:#fff; border-bottom: var(--border); padding-bottom:2.5rem; padding-top:3rem;">
    <div class="sdws-container">
      <h1 style="font-size:clamp(2.5rem,5vw,4rem); margin:0 0 1rem; color:#000;">
        Current and Upcoming Exhibitions
      </h1>
      <p style="font-size:1.125rem; max-width:680px; line-height:1.7; margin:0; color:#000;">
        SDWS exhibitions are held at the SDWS Gallery in Balboa Park, San Diego. All exhibitions are free and open to the public during gallery hours.
      </p>
    </div>
  </section>

  <!-- Exhibition loop -->
  <section class="sdws-section" style="background:#fff;">
    <div class="sdws-container">
      <?php
      $exhibitions = new WP_Query( array(
        'post_type'      => 'sdws_exhibition',
        'posts_per_page' => -1,
        'meta_key'       => 'exhibition_show_dates_start',
        'orderby'        => 'meta_value',
        'order'          => 'ASC',
      ) );
      ?>

      <?php if ( $exhibitions->have_posts() ) : ?>
        <div class="sdws-grid-2">
          <?php while ( $exhibitions->have_posts() ) : $exhibitions->the_post(); ?>
            <?php get_template_part( 'template-parts/sdws/sdws-card' ); ?>
          <?php endwhile; ?>
        </div>
        <?php wp_reset_postdata(); ?>
      <?php else : ?>
        <p style="color:#000; opacity:0.5;">Exhibition listings coming soon.</p>
      <?php endif; ?>
    </div>
  </section>

</main>

<?php get_footer(); ?>
