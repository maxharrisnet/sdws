<?php

/**
 * Stats component.
 *
 * @package Starter_Coat
 */

$items = isset($args['items']) && is_array($args['items']) ? $args['items'] : array();
?>
<div class="c-stats layout layout--4col">
  <?php foreach ($items as $item) : ?>
    <div class="card c-stat">
      <strong class="c-stat__value"><?php echo esc_html($item['value'] ?? ''); ?></strong>
      <p class="c-stat__label"><?php echo esc_html($item['label'] ?? ''); ?></p>
    </div>
  <?php endforeach; ?>
</div>