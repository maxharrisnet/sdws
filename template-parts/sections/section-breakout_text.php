<?php

/**
 * Breakout text section.
 *
 * @package Starter_Coat
 */

$content         = starter_coat_get_sub_field('content', '');
$text_align      = sanitize_html_class((string) starter_coat_get_sub_field('text_align', 'center'));
$text_size       = sanitize_html_class((string) starter_coat_get_sub_field('text_size', 'lg'));
$button_label    = (string) starter_coat_get_sub_field('button_label', '');
$button_link     = starter_coat_get_sub_field('button_link', null);
$modal_target_id = sanitize_html_class((string) starter_coat_get_sub_field('modal_target_id', ''));
$section_classes = starter_coat_get_section_classes('section--breakout-text');
$container_class = starter_coat_get_section_container_class();

if ('' === trim((string) $content)) {
  return;
}

$modal_target = $modal_target_id ? '#' . $modal_target_id : '';
?>
<section class="<?php echo esc_attr($section_classes); ?>">
  <div class="<?php echo esc_attr($container_class); ?>">
    <div class="c-breakout-text c-breakout-text--<?php echo esc_attr($text_align); ?> c-breakout-text--<?php echo esc_attr($text_size); ?>">
      <div class="c-breakout-text__content richtext">
        <?php echo wp_kses_post($content); ?>
      </div>

      <?php if ($button_label && $modal_target) : ?>
        <button type="button" class="btn btn--primary btn--md" data-modal-target="<?php echo esc_attr($modal_target); ?>">
          <?php echo esc_html($button_label); ?>
        </button>
      <?php elseif ($button_label && ! empty($button_link['url'])) : ?>
        <a
          class="btn btn--primary btn--md"
          href="<?php echo esc_url($button_link['url']); ?>"
          <?php echo ! empty($button_link['target']) ? 'target="' . esc_attr($button_link['target']) . '" rel="noopener"' : ''; ?>>
          <?php echo esc_html($button_label); ?>
        </a>
      <?php endif; ?>
    </div>
  </div>
</section>
