<?php

/**
 * Profile archive template.
 *
 * @package Starter_Coat
 */

get_header();
?>

<main id="primary" class="site-main section section--lg">
  <div class="container">
    <header class="page-header">
      <?php the_archive_title('<h1 class="page-title">', '</h1>'); ?>
    </header>
    <?php if (have_posts()) : ?>
      <div class="layout layout--4col">
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
