<?php

/**
 * Video embed section with optional modal playback.
 *
 * @package Starter_Coat
 */

$heading         = (string) starter_coat_get_sub_field('heading', '');
$intro           = (string) starter_coat_get_sub_field('intro', '');
$video_embed     = (string) starter_coat_get_sub_field('video_embed_code', '');
$video_url       = (string) starter_coat_get_sub_field('video_url', '');
$open_in_modal   = (bool) starter_coat_get_sub_field('open_in_modal', false);
$modal_id        = sanitize_html_class((string) starter_coat_get_sub_field('modal_id', ''));
$button_label    = (string) starter_coat_get_sub_field('button_label', __('Watch Video', 'starter-coat'));
$section_classes = starter_coat_get_section_classes('section--video-embed');
$container_class = starter_coat_get_section_container_class();

$embed_html = '';
if ('' !== trim($video_embed)) {
  $embed_html = $video_embed;
} elseif ($video_url) {
  $oembed = wp_oembed_get($video_url);
  if (is_string($oembed) && '' !== trim($oembed)) {
    $embed_html = $oembed;
  } else {
    $embed_html = '<video controls preload="metadata" playsinline><source src="' . esc_url($video_url) . '"></video>';
  }
}

if ('' === trim($embed_html)) {
  return;
}

$render_inline = ! $open_in_modal || '' === $modal_id;
?>
<section class="<?php echo esc_attr($section_classes); ?>">
  <div class="<?php echo esc_attr($container_class); ?>">
    <div class="c-video-embed">
      <?php if ($heading) : ?>
        <h2 class="c-video-embed__heading"><?php echo esc_html($heading); ?></h2>
      <?php endif; ?>

      <?php if ($intro) : ?>
        <p class="c-video-embed__intro"><?php echo esc_html($intro); ?></p>
      <?php endif; ?>

      <?php if ($render_inline) : ?>
        <div class="c-video-embed__frame">
          <?php echo $embed_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
          ?>
        </div>
      <?php else : ?>
        <div class="c-video-embed__actions">
          <button type="button" class="btn btn--primary btn--md" data-modal-target="#<?php echo esc_attr($modal_id); ?>">
            <?php echo esc_html($button_label ?: __('Watch Video', 'starter-coat')); ?>
          </button>
        </div>
        <?php
        get_template_part(
          'template-parts/components/modal',
          null,
          array(
            'id'      => $modal_id,
            'content' => '<div class="c-video-embed__frame">' . $embed_html . '</div>',
          )
        );
        ?>
      <?php endif; ?>
    </div>
  </div>
</section>