<?php

/**
 * CTA band component.
 * Fixed style: sand/tan background, centered text, optional buttons.
 * Only these fields are used: title, copy, eyebrow, button_primary,
 * button_primary_style, button_secondary, button_secondary_style.
 *
 * @package Starter_Coat
 */

$cta = isset($args['cta']) && is_array($args['cta']) ? $args['cta'] : array();

// ACF-driven CTAs pass an 'enabled' flag — skip when explicitly disabled.
if (array_key_exists('enabled', $cta) && empty($cta['enabled'])) {
  return;
}

$eyebrow = isset($cta['eyebrow']) ? (string) $cta['eyebrow'] : '';
$title   = isset($cta['title'])   ? (string) $cta['title']   : '';
$copy    = isset($cta['copy'])    ? (string) $cta['copy']    : '';

$button_primary         = isset($cta['button_primary'])   && is_array($cta['button_primary'])   ? $cta['button_primary']   : array();
$button_secondary       = isset($cta['button_secondary']) && is_array($cta['button_secondary']) ? $cta['button_secondary'] : array();
$button_primary_style   = isset($cta['button_primary_style'])   ? sanitize_html_class((string) $cta['button_primary_style'])   : 'primary';
$button_secondary_style = isset($cta['button_secondary_style']) ? sanitize_html_class((string) $cta['button_secondary_style']) : 'outline';

// Map any boilerplate style names to SDWS equivalents.
$style_map     = array('ghost' => 'outline', 'secondary' => 'outline');
$primary_cls   = $style_map[$button_primary_style]   ?? $button_primary_style;
$secondary_cls = $style_map[$button_secondary_style] ?? $button_secondary_style;

$has_primary   = !empty($button_primary['url'])   && !empty($button_primary['title']);
$has_secondary = !empty($button_secondary['url']) && !empty($button_secondary['title']);
$has_buttons   = $has_primary || $has_secondary;

if (!$title && !$copy && !$has_buttons) {
  return;
}
?>
<section class="sdws-section sdws-section--sand sdws-cta">
  <div class="sdws-container">
    <div class="sdws-cta__body">

      <?php if ($eyebrow) : ?>
        <p class="sdws-eyebrow"><?php echo esc_html($eyebrow); ?></p>
      <?php endif; ?>

      <?php if ($title) : ?>
        <h2 class="sdws-cta__title"><?php echo esc_html($title); ?></h2>
      <?php endif; ?>

      <?php if ($copy) : ?>
        <div class="sdws-cta__copy"><?php echo wp_kses_post(wpautop($copy)); ?></div>
      <?php endif; ?>

      <?php if ($has_buttons) : ?>
        <div class="sdws-cta__actions">
          <?php if ($has_primary) : ?>
            <a class="sdws-btn sdws-btn--<?php echo esc_attr($primary_cls); ?>"
               href="<?php echo esc_url($button_primary['url']); ?>"
               <?php echo !empty($button_primary['target']) ? 'target="' . esc_attr($button_primary['target']) . '"' : ''; ?>>
              <?php echo esc_html($button_primary['title']); ?>
            </a>
          <?php endif; ?>
          <?php if ($has_secondary) : ?>
            <a class="sdws-btn sdws-btn--<?php echo esc_attr($secondary_cls); ?>"
               href="<?php echo esc_url($button_secondary['url']); ?>"
               <?php echo !empty($button_secondary['target']) ? 'target="' . esc_attr($button_secondary['target']) . '"' : ''; ?>>
              <?php echo esc_html($button_secondary['title']); ?>
            </a>
          <?php endif; ?>
        </div>
      <?php endif; ?>

    </div>
  </div>
</section>
