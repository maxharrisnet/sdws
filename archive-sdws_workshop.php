<?php

/**
 * Archive template for sdws_workshop CPT.
 *
 * @package Starter_Coat
 */

get_header();
?>

<main id="primary" class="site-main">

  <section class="sdws-section sdws-section--bordered-bottom">
    <div class="sdws-container">
      <h1 class="sdws-page-title">Upcoming Workshops</h1>
      <p class="sdws-page-intro">
        <?php esc_html_e( 'SDWS workshops are led by nationally recognized instructors and open to all skill levels. Members receive discounted rates on all sessions.', 'starter-coat' ); ?>
      </p>
    </div>
  </section>

  <?php if ( have_posts() ) : ?>

    <section class="sdws-section">
      <div class="sdws-container">

        <div class="sdws-grid-3">
          <?php
          while ( have_posts() ) :
            the_post();
            get_template_part( 'template-parts/sdws/sdws-card' );
          endwhile;
          ?>
        </div>

        <?php get_template_part( 'template-parts/components/pagination' ); ?>

      </div>
    </section>

  <?php else : ?>

    <section class="sdws-section">
      <div class="sdws-container">
        <?php get_template_part( 'template-parts/content', 'none' ); ?>
      </div>
    </section>

  <?php endif; ?>

</main>

<?php get_footer(); ?>
