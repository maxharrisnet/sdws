<?php

/**
 * Google Maps embed component.
 *
 * @package Starter_Coat
 */

$address           = isset($args['address']) ? trim((string) $args['address']) : '';
$custom_embed_html = isset($args['custom_embed_html']) ? (string) $args['custom_embed_html'] : '';
$map_height        = isset($args['map_height']) ? absint((int) $args['map_height']) : 420;
$map_width         = isset($args['map_width']) ? sanitize_html_class((string) $args['map_width']) : 'normal';
$layout_mode       = isset($args['layout_mode']) ? sanitize_html_class((string) $args['layout_mode']) : 'two-col';
$ratio             = isset($args['ratio']) ? sanitize_html_class((string) $args['ratio']) : '50-50';
$map_position      = isset($args['map_position']) ? sanitize_html_class((string) $args['map_position']) : 'right';
$content_type      = isset($args['content_type']) ? sanitize_html_class((string) $args['content_type']) : 'text';
$kicker            = isset($args['kicker']) ? (string) $args['kicker'] : '';
$heading           = isset($args['heading']) ? (string) $args['heading'] : '';
$text_content      = isset($args['text_content']) ? (string) $args['text_content'] : '';
$custom_html       = isset($args['custom_html_content']) ? (string) $args['custom_html_content'] : '';

$layout_classes = array('c-map-embed', 'c-map-embed--' . $layout_mode, 'c-map-embed--width-' . $map_width);

if ('two-col' === $layout_mode) {
  $layout_classes[] = 'layout';
  $layout_classes[] = 'layout--2col';
  $layout_classes[] = '66-33' === $ratio ? 'layout--2col-wide' : 'layout--2col-even';

  if ('left' === $map_position) {
    $layout_classes[] = 'layout--reverse';
  }
}

$map_markup = '';
if ('' !== trim($custom_embed_html)) {
  $allowed_tags = wp_kses_allowed_html('post');
  $allowed_tags['iframe'] = array(
    'src'             => true,
    'width'           => true,
    'height'          => true,
    'style'           => true,
    'loading'         => true,
    'allowfullscreen' => true,
    'referrerpolicy'  => true,
    'frameborder'     => true,
    'title'           => true,
  );

  $map_markup = wp_kses($custom_embed_html, $allowed_tags);
} elseif ('' !== $address) {
  $map_src = 'https://www.google.com/maps?q=' . rawurlencode($address) . '&output=embed';
  $map_markup = '<iframe src="' . esc_url($map_src) . '" width="100%" height="100%" loading="lazy" allowfullscreen referrerpolicy="no-referrer-when-downgrade" title="' . esc_attr__('Google Map', 'starter-coat') . '"></iframe>';
}

if ('' === $map_markup) {
  return;
}

$has_content = false;
if ('text' === $content_type) {
  $has_content = '' !== trim($kicker) || '' !== trim($heading) || '' !== trim(wp_strip_all_tags($text_content));
} elseif ('html' === $content_type) {
  $has_content = '' !== trim($custom_html);
}
?>
<div class="<?php echo esc_attr(implode(' ', $layout_classes)); ?>">
  <?php if ('two-col' === $layout_mode && $has_content) : ?>
    <div class="c-map-embed__content richtext">
      <?php if ('text' === $content_type) : ?>
        <?php if ('' !== $kicker) : ?>
          <p class="eyebrow"><?php echo esc_html($kicker); ?></p>
        <?php endif; ?>

        <?php if ('' !== $heading) : ?>
          <h2><?php echo esc_html($heading); ?></h2>
        <?php endif; ?>

        <?php if ('' !== trim($text_content)) : ?>
          <?php echo wp_kses_post($text_content); ?>
        <?php endif; ?>
      <?php elseif ('' !== trim($custom_html)) : ?>
        <?php echo wp_kses_post(do_shortcode($custom_html)); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
        ?>
      <?php endif; ?>
    </div>
  <?php endif; ?>

  <div class="c-map-embed__map" style="--sc-map-height: <?php echo esc_attr((string) max(240, $map_height)); ?>px;">
    <?php echo $map_markup; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
    ?>
  </div>

  <?php if ('one-col' === $layout_mode && $has_content) : ?>
    <div class="c-map-embed__content richtext c-map-embed__content--below">
      <?php if ('text' === $content_type) : ?>
        <?php if ('' !== $kicker) : ?>
          <p class="eyebrow"><?php echo esc_html($kicker); ?></p>
        <?php endif; ?>

        <?php if ('' !== $heading) : ?>
          <h2><?php echo esc_html($heading); ?></h2>
        <?php endif; ?>

        <?php if ('' !== trim($text_content)) : ?>
          <?php echo wp_kses_post($text_content); ?>
        <?php endif; ?>
      <?php elseif ('' !== trim($custom_html)) : ?>
        <?php echo wp_kses_post(do_shortcode($custom_html)); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
        ?>
      <?php endif; ?>
    </div>
  <?php endif; ?>
</div>