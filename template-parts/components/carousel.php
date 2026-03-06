<?php

/**
 * Carousel component shell.
 *
 * @package Starter_Coat
 */

$slides = isset($args['slides']) && is_array($args['slides']) ? $args['slides'] : array();
?>
<div class="c-carousel" data-carousel>
  <div class="c-carousel__track">
    <?php foreach ($slides as $slide) : ?>
      <div class="c-carousel__slide card">
        <?php echo wp_kses_post($slide); ?>
      </div>
    <?php endforeach; ?>
  </div>
</div>