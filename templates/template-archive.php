<?php

/**
 * Template Name: Archive Overview
 *
 * @package Starter_Coat
 */

get_header();
?>

<main id="primary" class="site-main section section--lg">
  <div class="container">
    <?php while (have_posts()) : the_post(); ?>
      <?php the_title('<h1>', '</h1>'); ?>
      <?php the_content(); ?>
    <?php endwhile; ?>
  </div>
</main>

<?php
get_footer();
