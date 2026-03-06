<?php

/**
 * Single Project template.
 *
 * @package Starter_Coat
 */

get_header();
?>

<main id="primary" class="site-main section section--lg">
  <div class="container container--narrow">
    <?php while (have_posts()) : the_post(); ?>
      <article <?php post_class('entry entry--project'); ?>>
        <h1><?php the_title(); ?></h1>
        <?php starter_coat_post_thumbnail(); ?>
        <div class="entry-content"><?php the_content(); ?></div>
      </article>
    <?php endwhile; ?>
  </div>
</main>

<?php
get_footer();
