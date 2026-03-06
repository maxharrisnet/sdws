<?php

/**
 * Template Name: Contact
 *
 * @package Starter_Coat
 */

get_header();
?>

<main id="primary" class="site-main">
  <section class="section section--lg">
    <div class="container container--narrow">
      <?php while (have_posts()) : the_post(); ?>
        <h1><?php the_title(); ?></h1>
        <?php the_content(); ?>
      <?php endwhile; ?>
    </div>
  </section>
</main>

<?php
get_footer();
