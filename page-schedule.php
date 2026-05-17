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
  <section class="sdws-section sdws-section--bordered-bottom">
    <div class="sdws-container">
      <h1 class="sdws-page-title">Current and Upcoming Exhibitions</h1>
      <p class="sdws-page-intro">
        SDWS exhibitions are held at the SDWS Gallery in Liberty Station, San Diego. All exhibitions are free and open to the public during gallery hours.
      </p>
    </div>
  </section>

  <!-- Exhibition loop -->
  <section class="sdws-section">
    <div class="sdws-container">
      <?php
      $exhibitions = new WP_Query(array(
        'post_type'      => 'sdws_exhibition',
        'posts_per_page' => -1,
        'meta_key'       => 'exhibition_show_dates_start',
        'orderby'        => 'meta_value',
        'order'          => 'ASC',
      ));
      ?>

      <?php if ($exhibitions->have_posts()) : ?>
        <div class="sdws-exhibition-list">
          <?php while ($exhibitions->have_posts()) : $exhibitions->the_post(); ?>
            <?php get_template_part('template-parts/sdws/sdws-card', null, array('layout' => 'horizontal')); ?>
          <?php endwhile; ?>
        </div>
        <?php wp_reset_postdata(); ?>
      <?php else : ?>
        <p class="sdws-empty-notice">Exhibition listings coming soon.</p>
      <?php endif; ?>
    </div>
  </section>

</main>

<?php get_footer(); ?>