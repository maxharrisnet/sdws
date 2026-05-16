<?php

/**
 * CTA component.
 *
 * @package Starter_Coat
 */

$cta = isset($args['cta']) && is_array($args['cta']) ? $args['cta'] : array();

// Backward-compatible fallback for older direct args usage.
if (empty($cta)) {
  $cta = array(
    'enabled'                => true,
    'title'                  => isset($args['title']) ? (string) $args['title'] : '',
    'copy'                   => isset($args['copy']) ? (string) $args['copy'] : '',
    'action_mode'            => 'buttons',
    'form_shortcode'         => '',
    'button_primary'         => isset($args['button']) ? $args['button'] : null,
    'button_primary_style'   => isset($args['variant']) ? sanitize_html_class((string) $args['variant']) : 'primary',
    'button_secondary'       => null,
    'button_secondary_style' => 'ghost',
    'layout'                 => 'stacked',
    'split_ratio'            => 'two-thirds',
    'width'                  => 'container',
    'background'             => 'none',
    'text_box_style'         => 'surface',
  );
}

$eyebrow      = isset($cta['eyebrow']) ? (string) $cta['eyebrow'] : '';
$title        = isset($cta['title']) ? (string) $cta['title'] : '';
$subheading   = isset($cta['subheading']) ? (string) $cta['subheading'] : '';
$copy         = isset($cta['copy']) ? (string) $cta['copy'] : '';
$layout       = isset($cta['layout']) ? sanitize_html_class((string) $cta['layout']) : 'stacked';
$split_ratio  = isset($cta['split_ratio']) ? sanitize_html_class((string) $cta['split_ratio']) : 'two-thirds';
$width        = isset($cta['width']) ? sanitize_html_class((string) $cta['width']) : 'container';
$background   = isset($cta['background']) ? sanitize_html_class((string) $cta['background']) : 'none';
$text_box     = isset($cta['text_box_style']) ? sanitize_html_class((string) $cta['text_box_style']) : 'surface';
$action_mode  = isset($cta['action_mode']) ? sanitize_html_class((string) $cta['action_mode']) : 'buttons';
$form_shortcode = isset($cta['form_shortcode']) ? (string) $cta['form_shortcode'] : '';

$button_primary         = isset($cta['button_primary']) && is_array($cta['button_primary']) ? $cta['button_primary'] : array();
$button_secondary       = isset($cta['button_secondary']) && is_array($cta['button_secondary']) ? $cta['button_secondary'] : array();
$button_primary_style   = isset($cta['button_primary_style']) ? sanitize_html_class((string) $cta['button_primary_style']) : 'primary';
$button_secondary_style = isset($cta['button_secondary_style']) ? sanitize_html_class((string) $cta['button_secondary_style']) : 'ghost';

$has_primary = ! empty($button_primary['url']) && ! empty($button_primary['title']);
$has_secondary = ! empty($button_secondary['url']) && ! empty($button_secondary['title']);
$has_buttons = $has_primary || $has_secondary;
$has_form = 'form' === $action_mode && '' !== trim($form_shortcode);

if (! $title && ! $copy && ! $has_buttons && ! $has_form) {
  return;
}

$container_class = 'sdws-container';
if ('narrow' === $width) {
  $container_class = 'sdws-container sdws-container--narrow';
} elseif ('full' === $width) {
  $container_class = 'sdws-container sdws-container--full';
}

$section_classes = array('sdws-section', 'c-cta-band', 'c-cta-band--layout-' . $layout);
if ('none' !== $background) {
  $section_classes[] = 'sdws-section--' . $background;
}
?>
<section class="<?php echo esc_attr(implode(' ', $section_classes)); ?>">
  <div class="<?php echo esc_attr($container_class); ?>">
    <div class="c-cta c-cta--layout-<?php echo esc_attr($layout); ?> c-cta--ratio-<?php echo esc_attr($split_ratio); ?> c-cta--box-<?php echo esc_attr($text_box); ?>">
      <div class="c-cta__content">
        <?php if ($eyebrow) : ?>
          <p class="eyebrow"><?php echo esc_html($eyebrow); ?></p>
        <?php endif; ?>

        <?php if ($title) : ?>
          <h2 class="c-cta__title"><?php echo esc_html($title); ?></h2>
        <?php endif; ?>

        <?php if ($subheading) : ?>
          <p class="c-cta__subheading"><?php echo esc_html($subheading); ?></p>
        <?php endif; ?>

        <?php if ($copy) : ?>
          <div class="c-cta__copy"><?php echo wp_kses_post(wpautop($copy)); ?></div>
        <?php endif; ?>
      </div>

      <?php if ($has_form) : ?>
        <div class="c-cta__form">
          <?php echo do_shortcode($form_shortcode); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
          ?>
        </div>
      <?php elseif ($has_buttons) : ?>
        <div class="c-cta__actions">
          <?php
          // Map boilerplate style names to SDWS equivalents.
          $style_map = array('ghost' => 'outline', 'secondary' => 'outline');
          $primary_cls   = isset($style_map[$button_primary_style])   ? $style_map[$button_primary_style]   : $button_primary_style;
          $secondary_cls = isset($style_map[$button_secondary_style]) ? $style_map[$button_secondary_style] : $button_secondary_style;
          ?>
          <?php if ($has_primary) : ?>
            <a class="sdws-btn sdws-btn--<?php echo esc_attr($primary_cls); ?>" href="<?php echo esc_url($button_primary['url']); ?>" <?php echo ! empty($button_primary['target']) ? 'target="' . esc_attr($button_primary['target']) . '"' : ''; ?>>
              <?php echo esc_html($button_primary['title']); ?>
            </a>
          <?php endif; ?>

          <?php if ($has_secondary) : ?>
            <a class="sdws-btn sdws-btn--<?php echo esc_attr($secondary_cls); ?>" href="<?php echo esc_url($button_secondary['url']); ?>" <?php echo ! empty($button_secondary['target']) ? 'target="' . esc_attr($button_secondary['target']) . '"' : ''; ?>>
              <?php echo esc_html($button_secondary['title']); ?>
            </a>
          <?php endif; ?>
        </div>
      <?php endif; ?>
    </div>
  </div>
</section>