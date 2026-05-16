<?php

/**
 * Single exhibition template — San Diego Watercolor Society
 *
 * @package Starter_Coat
 */

get_header();

while (have_posts()) : the_post();
  get_template_part('template-parts/sdws/exhibition-card');
endwhile;
?>

<main id="primary" class="site-main">
  <div style="max-width:var(--max-width); margin:0 auto; padding:var(--space-section) 2rem;">
    <?php
    rewind_posts();
    while (have_posts()) : the_post();
      get_template_part('template-parts/sdws/exhibition-card');
      echo '<div style="margin-top:2rem; font-size:1.0625rem; line-height:1.8; color:#000;">';
      the_content();
      echo '</div>';
    endwhile;
    ?>
  </div>
</main>

<?php get_footer(); ?>
