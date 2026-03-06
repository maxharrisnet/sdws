<?php

/**
 * Single Event template.
 *
 * @package Starter_Coat
 */

get_header();
?>

<main id="primary" class="site-main section section--lg">
  <div class="container container--narrow">
    <?php while (have_posts()) : the_post(); ?>
      <article <?php post_class('entry entry--event'); ?>>
        <h1><?php the_title(); ?></h1>
        <div class="entry-content"><?php the_content(); ?></div>
      </article>
    <?php endwhile; ?>
  </div>
</main>

<?php
get_footer();
