<?php

/**
 * Flexible card component.
 *
 * @package Starter_Coat
 */

$title = isset($args['title']) ? $args['title'] : get_the_title();
$copy  = isset($args['copy']) ? $args['copy'] : get_the_excerpt();
$pill  = isset($args['pill']) ? $args['pill'] : '';
?>
<article class="card card--surface c-flexible-card">
  <?php if ($pill) : ?>
    <span class="c-flexible-card__pill"><?php echo esc_html($pill); ?></span>
  <?php endif; ?>
  <h3 class="card__title"><?php echo esc_html($title); ?></h3>
  <?php if ($copy) : ?>
    <p><?php echo esc_html($copy); ?></p>
  <?php endif; ?>
</article>