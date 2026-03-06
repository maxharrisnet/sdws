<?php

/**
 * Social buttons component.
 *
 * @package Starter_Coat
 */

$links = isset($args['links']) && is_array($args['links']) ? $args['links'] : array();
?>
<div class="c-social-buttons layout">
  <?php foreach ($links as $link) : ?>
    <a class="btn btn--ghost btn--sm" href="<?php echo esc_url($link['url'] ?? '#'); ?>">
      <?php echo esc_html($link['label'] ?? ''); ?>
    </a>
  <?php endforeach; ?>
</div>