<?php

/**
 * Archive template for sdws_exhibition CPT.
 *
 * @package Starter_Coat
 */

get_header();

$gf        = function_exists('get_field');
$ex_title  = $gf ? (get_field('exhibitions_hero_title', 'option') ?: 'Exhibition Schedule') : 'Exhibition Schedule';
$ex_intro  = $gf ? get_field('exhibitions_hero_intro', 'option') : '';
?>

<main id="primary" class="site-main">

  <section class="sdws-section sdws-section--bordered-bottom">
    <div class="sdws-container">
      <h1 class="sdws-page-title"><?php echo esc_html($ex_title); ?></h1>
      <?php if ($ex_intro) : ?>
        <div class="sdws-page-intro"><?php echo wp_kses_post($ex_intro); ?></div>
      <?php endif; ?>
    </div>
  </section>

  <?php if ( have_posts() ) : ?>

    <section class="sdws-section">
      <div class="sdws-container">

        <div class="sdws-grid-2">
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
