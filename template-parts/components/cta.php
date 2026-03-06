<?php

/**
 * CTA component.
 *
 * @package Starter_Coat
 */

$title   = isset($args['title']) ? $args['title'] : '';
$copy    = isset($args['copy']) ? $args['copy'] : '';
$button  = isset($args['button']) ? $args['button'] : null;
$variant = isset($args['variant']) ? sanitize_html_class($args['variant']) : 'primary';
$size    = isset($args['size']) ? sanitize_html_class($args['size']) : 'md';

if (! $title && ! $copy && empty($button)) {
  return;
}
?>
<div class="c-cta c-cta--<?php echo esc_attr($variant); ?>">
  <?php if ($title) : ?>
    <h3 class="c-cta__title"><?php echo esc_html($title); ?></h3>
  <?php endif; ?>

  <?php if ($copy) : ?>
    <div class="c-cta__copy"><?php echo wp_kses_post(wpautop($copy)); ?></div>
  <?php endif; ?>

  <?php if (! empty($button['url']) && ! empty($button['title'])) : ?>
    <a class="btn btn--<?php echo esc_attr($variant); ?> btn--<?php echo esc_attr($size); ?>" href="<?php echo esc_url($button['url']); ?>" <?php echo ! empty($button['target']) ? 'target="' . esc_attr($button['target']) . '"' : ''; ?>>
      <?php echo esc_html($button['title']); ?>
    </a>
  <?php endif; ?>
</div>