<?php

/**
 * Expandable list component.
 *
 * @package Starter_Coat
 */

$items = isset($args['items']) && is_array($args['items']) ? $args['items'] : array();

if (empty($items)) {
  $items = array(
    array('title' => __('Question one', 'starter-coat'), 'copy' => __('Answer one.', 'starter-coat')),
    array('title' => __('Question two', 'starter-coat'), 'copy' => __('Answer two.', 'starter-coat')),
  );
}
?>
<div class="c-expandable-list stack stack--md">
  <?php foreach ($items as $item) : ?>
    <details class="expandable-item">
      <summary><?php echo esc_html($item['title']); ?></summary>
      <div class="expandable-item__body"><?php echo esc_html($item['copy']); ?></div>
    </details>
  <?php endforeach; ?>
</div>