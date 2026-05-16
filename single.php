<?php

/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Starter_Coat
 */

get_header();
?>

<main id="primary" class="site-main">

  <?php
  while (have_posts()) :
    the_post();

    starter_coat_render_singular_hero(get_the_ID());
    get_template_part('template-parts/components/breadcrumbs');

    get_template_part('template-parts/content', get_post_type());

    the_post_navigation(
      array(
        'prev_text' => '<span class="nav-subtitle">' . esc_html__('Previous:', 'starter-coat') . '</span> <span class="nav-title">%title</span>',
        'next_text' => '<span class="nav-subtitle">' . esc_html__('Next:', 'starter-coat') . '</span> <span class="nav-title">%title</span>',
      )
    );

    get_template_part('template-parts/components/related-posts');

    // If comments are open or we have at least one comment, load up the comment template.
    if (comments_open() || get_comments_number()) :
      comments_template();
    endif;

  endwhile; // End of the loop.
  ?>

</main><!-- #main -->

<?php
get_footer();
