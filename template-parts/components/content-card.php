<?php

/**
 * Generic content card component.
 *
 * @package Starter_Coat
 */

$card = isset($args['card']) && is_array($args['card']) ? $args['card'] : array();

$eyebrow = isset($card['eyebrow']) ? (string) $card['eyebrow'] : '';
$title   = isset($card['title']) ? (string) $card['title'] : '';
$copy    = isset($card['copy']) ? (string) $card['copy'] : '';
$image   = isset($card['image']) && is_array($card['image']) ? $card['image'] : array();
$button  = isset($card['button']) && is_array($card['button']) ? $card['button'] : array();

if (! $title && ! $copy && empty($image['url'])) {
  return;
}
?>
<article class="card card--surface c-content-card">
  <?php if (! empty($image['url'])) : ?>
    <figure class="c-content-card__media image image--soft">
      <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt'] ?? $title); ?>" loading="lazy" decoding="async" />
    </figure>
  <?php endif; ?>

  <div class="c-content-card__body">
    <?php if ($eyebrow) : ?>
      <p class="eyebrow"><?php echo esc_html($eyebrow); ?></p>
    <?php endif; ?>

    <?php if ($title) : ?>
      <h3 class="card__title"><?php echo esc_html($title); ?></h3>
    <?php endif; ?>

    <?php if ($copy) : ?>
      <p><?php echo esc_html($copy); ?></p>
    <?php endif; ?>

    <?php if (! empty($button['url']) && ! empty($button['title'])) : ?>
      <a class="btn btn--ghost btn--sm" href="<?php echo esc_url($button['url']); ?>" <?php echo ! empty($button['target']) ? 'target="' . esc_attr($button['target']) . '"' : ''; ?>>
        <?php echo esc_html($button['title']); ?>
      </a>
    <?php endif; ?>
  </div>
</article>