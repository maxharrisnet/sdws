<?php

/**
 * Single Event template.
 *
 * @package Starter_Coat
 */

get_header();
?>

<main id="primary" class="site-main section section--lg">
  <?php while (have_posts()) : the_post(); ?>
    <?php starter_coat_render_singular_hero(get_the_ID()); ?>
    <div class="container container--narrow">
      <article <?php post_class('entry entry--event'); ?>>
        <?php if (! starter_coat_has_singular_hero(get_the_ID())) : ?>
          <h1><?php the_title(); ?></h1>
        <?php endif; ?>
        <div class="entry-content"><?php the_content(); ?></div>
      </article>
    </div>
  <?php endwhile; ?>
</main>

<?php
get_footer();
