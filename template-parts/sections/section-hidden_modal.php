<?php

/**
 * Hidden modal section (video/form/html) with optional inline trigger button.
 *
 * @package Starter_Coat
 */

$modal_id        = sanitize_html_class((string) starter_coat_get_sub_field('modal_id', ''));
$content_type    = sanitize_key((string) starter_coat_get_sub_field('content_type', 'video'));
$video_embed     = (string) starter_coat_get_sub_field('video_embed_code', '');
$video_url       = (string) starter_coat_get_sub_field('video_url', '');
$form_shortcode  = (string) starter_coat_get_sub_field('form_shortcode', '');
$html_content    = (string) starter_coat_get_sub_field('html_content', '');
$render_trigger  = (bool) starter_coat_get_sub_field('render_trigger', false);
$trigger_label   = (string) starter_coat_get_sub_field('trigger_label', __('Open Modal', 'starter-coat'));
$section_classes = starter_coat_get_section_classes('section--hidden-modal-trigger');
$container_class = starter_coat_get_section_container_class();

if (! $modal_id) {
  return;
}

$modal_content = '';

if ('form' === $content_type && '' !== trim($form_shortcode)) {
  $modal_content = do_shortcode($form_shortcode);
} elseif ('html' === $content_type && '' !== trim($html_content)) {
  $modal_content = do_shortcode($html_content);
} else {
  if ('' !== trim($video_embed)) {
    $modal_content = $video_embed;
  } elseif ($video_url) {
    $oembed = wp_oembed_get($video_url);
    if (is_string($oembed) && '' !== trim($oembed)) {
      $modal_content = $oembed;
    } else {
      $modal_content = '<video controls preload="metadata" playsinline><source src="' . esc_url($video_url) . '"></video>';
    }
  }
}

if ('' === trim($modal_content)) {
  return;
}

if ($render_trigger && '' !== trim($trigger_label)) :
?>
  <section class="<?php echo esc_attr($section_classes); ?>">
    <div class="<?php echo esc_attr($container_class); ?>">
      <button type="button" class="btn btn--primary btn--md" data-modal-target="#<?php echo esc_attr($modal_id); ?>">
        <?php echo esc_html($trigger_label); ?>
      </button>
    </div>
  </section>
<?php
endif;

get_template_part(
  'template-parts/components/modal',
  null,
  array(
    'id'      => $modal_id,
    'content' => $modal_content,
  )
);
