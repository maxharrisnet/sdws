<?php

/**
 * Three column cards section.
 *
 * @package Starter_Coat
 */
?>
<section class="section section--cards section--lg">
  <div class="container">
    <div class="layout layout--3col">
      <?php if (function_exists('have_rows') && have_rows('items')) : ?>
        <?php
        while (have_rows('items')) :
          the_row();
          $title = get_sub_field('title');
          $copy  = get_sub_field('copy');
        ?>
          <article class="card card--surface">
            <?php if ($title) : ?>
              <h3 class="card__title"><?php echo esc_html($title); ?></h3>
            <?php endif; ?>
            <?php if ($copy) : ?>
              <p><?php echo esc_html($copy); ?></p>
            <?php endif; ?>
          </article>
        <?php endwhile; ?>
      <?php else : ?>
        <?php for ($index = 1; $index <= 3; $index++) : ?>
          <article class="card card--surface">
            <h3 class="card__title"><?php printf(esc_html__('Card %d', 'starter-coat'), $index); ?></h3>
            <p><?php esc_html_e('Add content in the ACF repeater.', 'starter-coat'); ?></p>
          </article>
        <?php endfor; ?>
      <?php endif; ?>
    </div>
  </div>
</section>