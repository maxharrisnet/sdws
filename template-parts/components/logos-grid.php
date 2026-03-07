<?php

/**
 * Logo grid component.
 *
 * @package Starter_Coat
 */

$logos   = isset($args['logos']) && is_array($args['logos']) ? $args['logos'] : array();
$heading = isset($args['heading']) ? (string) $args['heading'] : '';
$subtext = isset($args['subtext']) ? (string) $args['subtext'] : '';
$columns = isset($args['columns']) ? (int) $args['columns'] : 4;

$columns = max(2, min(6, $columns));

if (empty($logos)) {
  return;
}
?>
<div class="c-logo-grid">
  <?php if ($heading) : ?>
    <h2 class="c-logo-grid__heading"><?php echo esc_html($heading); ?></h2>
  <?php endif; ?>

  <?php if ($subtext) : ?>
    <p class="c-logo-grid__subtext"><?php echo esc_html($subtext); ?></p>
  <?php endif; ?>

  <div class="c-logo-grid__items c-logo-grid__items--cols-<?php echo esc_attr((string) $columns); ?>">
    <?php foreach ($logos as $logo) : ?>
      <?php
      $image = isset($logo['image']) && is_array($logo['image']) ? $logo['image'] : array();
      $image_id = isset($image['ID']) ? absint($image['ID']) : 0;
      $link  = isset($logo['link']) && is_array($logo['link']) ? $logo['link'] : array();

      if (empty($image['url'])) {
        continue;
      }

      $alt = ! empty($image['alt']) ? (string) $image['alt'] : '';
      ?>
      <div class="c-logo-grid__item">
        <?php if (! empty($link['url'])) : ?>
          <a class="c-logo-grid__logo" href="<?php echo esc_url($link['url']); ?>" <?php echo ! empty($link['target']) ? 'target="' . esc_attr($link['target']) . '"' : ''; ?> aria-label="<?php echo esc_attr(! empty($link['title']) ? $link['title'] : __('Logo link', 'starter-coat')); ?>">
            <?php if ($image_id) : ?>
              <?php echo wp_get_attachment_image($image_id, 'sc-logo', false, array('loading' => 'lazy', 'decoding' => 'async', 'sizes' => '(min-width: 1200px) 180px, (min-width: 768px) 22vw, 40vw')); ?>
            <?php else : ?>
              <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($alt); ?>" loading="lazy" decoding="async" />
            <?php endif; ?>
          </a>
        <?php else : ?>
          <div class="c-logo-grid__logo">
            <?php if ($image_id) : ?>
              <?php echo wp_get_attachment_image($image_id, 'sc-logo', false, array('loading' => 'lazy', 'decoding' => 'async', 'sizes' => '(min-width: 1200px) 180px, (min-width: 768px) 22vw, 40vw')); ?>
            <?php else : ?>
              <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($alt); ?>" loading="lazy" decoding="async" />
            <?php endif; ?>
          </div>
        <?php endif; ?>
      </div>
    <?php endforeach; ?>
  </div>
</div>