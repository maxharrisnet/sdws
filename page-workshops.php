<?php

/**
 * Workshops page template — San Diego Watercolor Society
 * Slug: workshops
 *
 * @package Starter_Coat
 */

get_header();
?>

<main id="primary" class="site-main">

  <!-- Page header -->
  <section class="sdws-section" style="background:#fff; border-bottom: var(--border); padding-bottom:2.5rem; padding-top:3rem;">
    <div class="sdws-container">
      <h1 style="font-family:var(--font-display); font-size:clamp(2.5rem,5vw,4rem); margin:0 0 1rem; color:#000;">Workshops</h1>
      <p style="font-size:1.125rem; max-width:680px; line-height:1.7; margin:0; color:#000;">
        SDWS workshops are led by nationally recognized instructors and open to all skill levels. Members receive discounted rates on all sessions.
      </p>
    </div>
  </section>

  <?php
  $format_groups = array(
    array(
      'slug'    => 'in-person',
      'heading' => 'In-Gallery Workshops',
    ),
    array(
      'slug'    => 'zoom',
      'heading' => 'Zoom Workshops',
    ),
    array(
      'slug'    => 'beginner-series',
      'heading' => 'Beginner Series',
    ),
  );

  foreach ( $format_groups as $group ) :
    $workshops = new WP_Query( array(
      'post_type'      => 'sdws_workshop',
      'posts_per_page' => -1,
      'orderby'        => 'meta_value',
      'meta_key'       => 'workshop_date_start',
      'order'          => 'ASC',
      'tax_query'      => array( array(
        'taxonomy' => 'workshop_format',
        'field'    => 'slug',
        'terms'    => $group['slug'],
      ) ),
    ) );

    if ( ! $workshops->have_posts() ) {
      wp_reset_postdata();
      continue;
    }
  ?>

    <section class="sdws-section" style="border-bottom: var(--border); background:#fff;">
      <div class="sdws-container">
        <h2 style="font-family:var(--font-display); font-size:2rem; margin:0 0 2rem; padding-bottom:1rem; border-bottom: var(--border);">
          <?php echo esc_html( $group['heading'] ); ?>
        </h2>
        <div class="sdws-grid-3">
          <?php while ( $workshops->have_posts() ) : $workshops->the_post(); ?>
            <?php get_template_part( 'template-parts/sdws/workshop-card' ); ?>
          <?php endwhile; ?>
        </div>
      </div>
    </section>

  <?php
    wp_reset_postdata();
  endforeach;
  ?>

  <!-- Contact block -->
  <section class="sdws-section" style="background: var(--color-off-white);">
    <div class="sdws-container" style="max-width:700px;">
      <h2 style="font-family:var(--font-display); font-size:2rem; margin:0 0 1rem;">Questions About Workshops?</h2>
      <p style="font-size:1rem; line-height:1.7; margin:0 0 0.5rem;">
        Registration: <a href="mailto:registrar@sdws.org" style="color:#000; font-weight:500;">registrar@sdws.org</a>
      </p>
      <p style="font-size:1rem; line-height:1.7; margin:0;">
        Workshop Director: <a href="mailto:workshops@sdws.org" style="color:#000; font-weight:500;">workshops@sdws.org</a>
      </p>
    </div>
  </section>

</main>

<?php get_footer(); ?>
