<?php

/**
 * Gallery component.
 *
 * @package Starter_Coat
 */

$images = isset($args['images']) && is_array($args['images']) ? $args['images'] : array();
?>
<div class="c-gallery layout layout--3col">
  <?php foreach ($images as $image) : ?>
    <div class="c-gallery__item image image--rounded">
      <?php echo wp_get_attachment_image(absint($image), 'large'); ?>
    </div>
  <?php endforeach; ?>
</div>