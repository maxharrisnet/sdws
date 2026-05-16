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
      <?php echo wp_get_attachment_image(
        absint($image),
        'sc-card-header',
        false,
        array(
          'loading'  => 'lazy',
          'decoding' => 'async',
          'sizes'    => '(min-width: 1200px) 400px, (min-width: 768px) 33vw, 100vw',
        )
      ); ?>
    </div>
  <?php endforeach; ?>
</div>