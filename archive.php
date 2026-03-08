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
        $card_style = 'post';
        if ('project' === get_post_type()) {
          $card_style = 'project';
        } elseif ('press' === get_post_type()) {
          $card_style = 'press';
        }
        get_template_part('template-parts/components/archive-card', null, array('style' => $card_style));
      endwhile;
      echo '</div>';

      the_posts_navigation();

    else :

      get_template_part('template-parts/content', 'none');

    endif;
    ?>

  </div>
</main><!-- #main -->

<?php
get_footer();
