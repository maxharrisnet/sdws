<?php

/**
 * Event archive template.
 *
 * @package Starter_Coat
 */

get_header();
?>

<main id="primary" class="site-main section section--lg">
  <?php starter_coat_render_archive_hero(); ?>
  <div class="container">
    <?php if (! starter_coat_has_archive_hero()) : ?>
      <header class="page-header">
        <?php the_archive_title('<h1 class="page-title">', '</h1>'); ?>
      </header>
    <?php endif; ?>
    <?php if (have_posts()) : ?>
      <div class="layout layout--3col">
        <?php while (have_posts()) : the_post(); ?>
          <?php get_template_part('template-parts/components/archive-card', null, array('style' => 'post')); ?>
        <?php endwhile; ?>
      </div>
      <?php the_posts_navigation(); ?>
    <?php endif; ?>
  </div>
</main>

<?php
get_footer();
