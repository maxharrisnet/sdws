<?php

/**
 * FAQ archive template.
 *
 * @package Starter_Coat
 */

get_header();
?>

<main id="primary" class="site-main section section--lg">
  <div class="container container--narrow">
    <header class="page-header">
      <?php the_archive_title('<h1 class="page-title">', '</h1>'); ?>
    </header>
    <?php if (have_posts()) : ?>
      <div class="stack stack--md">
        <?php while (have_posts()) : the_post(); ?>
          <details class="expandable-item">
            <summary><?php the_title(); ?></summary>
            <div class="expandable-item__body"><?php the_content(); ?></div>
          </details>
        <?php endwhile; ?>
      </div>
      <?php the_posts_navigation(); ?>
    <?php endif; ?>
  </div>
</main>

<?php
get_footer();
