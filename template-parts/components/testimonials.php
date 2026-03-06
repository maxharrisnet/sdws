<?php

/**
 * Testimonials component.
 *
 * @package Starter_Coat
 */

$items = isset($args['items']) && is_array($args['items']) ? $args['items'] : array();
?>
<div class="c-testimonials layout layout--3col">
  <?php foreach ($items as $item) : ?>
    <blockquote class="card">
      <p><?php echo esc_html($item['quote'] ?? ''); ?></p>
      <cite><?php echo esc_html($item['author'] ?? ''); ?></cite>
    </blockquote>
  <?php endforeach; ?>
</div>