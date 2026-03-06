<?php

/**
 * Template Name: Generic - Container
 *
 * @package Starter_Coat
 */

get_header();
?>

<main id="primary" class="site-main section section--lg">
  <div class="container container--narrow">
    <?php
    while (have_posts()) :
      the_post();
      get_template_part('template-parts/content', 'page');
    endwhile;
    ?>
  </div>
</main>

<?php
get_footer();
