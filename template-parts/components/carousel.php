<?php

/**
 * Generic carousel component for card content.
 *
 * @package Starter_Coat
 */

$carousel = isset($args['carousel']) && is_array($args['carousel']) ? $args['carousel'] : array();

$id              = isset($carousel['id']) ? sanitize_html_class((string) $carousel['id']) : 'carousel-' . wp_rand(1000, 9999);
$heading         = isset($carousel['heading']) ? (string) $carousel['heading'] : '';
$subtext         = isset($carousel['subtext']) ? (string) $carousel['subtext'] : '';
$slides_per_view = isset($carousel['slides_per_view']) ? max(1, min(3, (int) $carousel['slides_per_view'])) : 1;
$show_controls   = array_key_exists('show_controls', $carousel) ? (bool) $carousel['show_controls'] : true;
$items           = isset($carousel['items']) && is_array($carousel['items']) ? array_values($carousel['items']) : array();
$variant         = isset($carousel['variant']) ? sanitize_html_class((string) $carousel['variant']) : '';

if (empty($items)) {
  return;
}

$carousel_classes = array('c-carousel');

if ($variant) {
  $carousel_classes[] = 'c-carousel--' . $variant;
}

if (1 === count($items)) {
  $carousel_classes[] = 'c-carousel--single';
}
?>
<div id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr(implode(' ', $carousel_classes)); ?>" data-carousel style="--slides-per-view-desktop: <?php echo esc_attr((string) $slides_per_view); ?>;">
  <?php if ($heading || $subtext) : ?>
    <header class="c-carousel__header">
      <?php if ($heading) : ?>
        <h2 class="c-carousel__heading"><?php echo esc_html($heading); ?></h2>
      <?php endif; ?>
      <?php if ($subtext) : ?>
        <p class="c-carousel__subtext"><?php echo esc_html($subtext); ?></p>
      <?php endif; ?>
    </header>
  <?php endif; ?>

  <div class="c-carousel__viewport" data-carousel-viewport>
    <div class="c-carousel__track" data-carousel-track>
      <?php foreach ($items as $item) : ?>
        <div class="c-carousel__slide" data-carousel-slide>
          <?php get_template_part('template-parts/components/card', null, array('card' => $item)); ?>
        </div>
      <?php endforeach; ?>
    </div>
  </div>

  <?php if ($show_controls && count($items) > 1) : ?>
    <div class="c-carousel__controls">
      <button type="button" class="c-carousel__arrow c-carousel__arrow--prev" data-carousel-prev aria-label="<?php esc_attr_e('Previous slide', 'starter-coat'); ?>">
        <?php starter_coat_the_icon('icon-chevron-up', array('class' => 'c-carousel__arrow-icon')); ?>
      </button>
      <button type="button" class="c-carousel__arrow c-carousel__arrow--next" data-carousel-next aria-label="<?php esc_attr_e('Next slide', 'starter-coat'); ?>">
        <?php starter_coat_the_icon('icon-chevron-up', array('class' => 'c-carousel__arrow-icon')); ?>
      </button>
    </div>
  <?php endif; ?>

  <?php if (count($items) > 1) : ?>
    <div class="c-carousel__dots" data-carousel-dots aria-label="<?php esc_attr_e('Slide navigation', 'starter-coat'); ?>">
      <?php foreach ($items as $index => $unused_item) : ?>
        <button
          type="button"
          class="c-carousel__dot"
          data-carousel-dot
          data-slide-index="<?php echo esc_attr((string) $index); ?>"
          aria-label="<?php echo esc_attr(sprintf(__('Go to slide %d', 'starter-coat'), $index + 1)); ?>"
          aria-current="<?php echo 0 === $index ? 'true' : 'false'; ?>"></button>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</div>