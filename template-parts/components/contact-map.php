<?php

/**
 * Contact and map component.
 *
 * @package Starter_Coat
 */

$map_embed = isset($args['map_embed']) ? (string) $args['map_embed'] : '';
?>
<div class="c-contact-map layout layout--2col layout--2col-even">
  <div class="c-contact-map__content">
    <?php if (! empty($args['content'])) : ?>
      <?php echo wp_kses_post($args['content']); ?>
    <?php endif; ?>
  </div>
  <div class="c-contact-map__map image image--soft">
    <?php if ($map_embed) : ?>
      <?php echo wp_kses_post($map_embed); ?>
    <?php endif; ?>
  </div>
</div>