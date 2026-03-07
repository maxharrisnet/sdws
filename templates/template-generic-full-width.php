<?php

/**
 * Template Name: Generic - Full Width
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
    get_template_part('template-parts/content', 'page');
  endwhile;
  ?>
</main>

<?php
get_footer();
