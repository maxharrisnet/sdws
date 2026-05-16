<?php

/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Starter_Coat
 */

get_header();
?>

<main id="primary" class="site-main section section--lg">
  <?php starter_coat_render_archive_hero(); ?>
  <div class="container">

    <?php if (have_posts()) : ?>

      <?php if (! starter_coat_has_archive_hero()) : ?>
        <header class="page-header">
          <?php
          the_archive_title('<h1 class="page-title">', '</h1>');
          the_archive_description('<div class="archive-description">', '</div>');
          ?>
        </header><!-- .page-header -->
      <?php endif; ?>

    <?php
      /* Start the Loop */
      echo '<div class="layout layout--3col">';
      while (have_posts()) :
        the_post();
        get_template_part('template-parts/sdws/sdws-card');
      endwhile;
      echo '</div>';

      get_template_part('template-parts/components/pagination');

    else :

      get_template_part('template-parts/content', 'none');

    endif;
    ?>

  </div>
</main><!-- #main -->

<?php
get_footer();
