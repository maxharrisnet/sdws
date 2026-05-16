<?php

/**
 * Reusable hero component for singular and archive contexts.
 *
 * @package Starter_Coat
 */

$hero = isset($args['hero']) && is_array($args['hero']) ? $args['hero'] : array();

$context         = isset($hero['context']) ? sanitize_html_class((string) $hero['context']) : 'page';
$variant         = isset($hero['variant']) ? sanitize_html_class((string) $hero['variant']) : 'page-centered';
$eyebrow         = isset($hero['eyebrow']) ? (string) $hero['eyebrow'] : '';
$title           = isset($hero['title']) ? (string) $hero['title'] : '';
$subheading      = isset($hero['subheading']) ? (string) $hero['subheading'] : '';
$copy            = isset($hero['copy']) ? (string) $hero['copy'] : '';
$text_box_style  = isset($hero['text_box_style']) ? sanitize_html_class((string) $hero['text_box_style']) : 'none';
$button_primary  = isset($hero['button_primary']) && is_array($hero['button_primary']) ? $hero['button_primary'] : array();
$button_secondary = isset($hero['button_secondary']) && is_array($hero['button_secondary']) ? $hero['button_secondary'] : array();
$button_primary_style = isset($hero['button_primary_style']) ? sanitize_html_class((string) $hero['button_primary_style']) : 'primary';
$button_secondary_style = isset($hero['button_secondary_style']) ? sanitize_html_class((string) $hero['button_secondary_style']) : 'ghost';
$media_type      = isset($hero['media_type']) ? sanitize_html_class((string) $hero['media_type']) : 'none';
$image           = isset($hero['image']) && is_array($hero['image']) ? $hero['image'] : array();
$image_id        = isset($image['ID']) ? absint($image['ID']) : 0;
$image_style     = isset($hero['image_style']) ? sanitize_html_class((string) $hero['image_style']) : 'rounded';
$video_embed     = isset($hero['video_embed']) ? (string) $hero['video_embed'] : '';
$video_url       = isset($hero['video_url']) ? (string) $hero['video_url'] : '';
$form_shortcode  = isset($hero['form_shortcode']) ? (string) $hero['form_shortcode'] : '';
$form_provider   = isset($hero['form_provider']) ? sanitize_html_class((string) $hero['form_provider']) : 'generic';
$form_id         = isset($hero['form_id']) ? (string) $hero['form_id'] : '';
$background      = isset($hero['background']) ? sanitize_html_class((string) $hero['background']) : 'none';
$media_position  = isset($hero['media_position']) ? sanitize_html_class((string) $hero['media_position']) : 'right';
$full_height     = ! empty($hero['full_height']);

if (empty($title) && empty($copy) && empty($subheading)) {
  return;
}

$section_classes = array('section', 'c-hero', 'c-hero--' . $context, 'c-hero--' . $variant);
if ('none' !== $background) {
  $section_classes[] = 'bg-' . $background;
}
if (in_array($background, array('dark', 'brand'), true)) {
  $section_classes[] = 'text-light';
}
if ($full_height || 'page-fullheight' === $variant) {
  $section_classes[] = 'c-hero--fullheight';
}
?>
<section class="<?php echo esc_attr(implode(' ', $section_classes)); ?>">
  <div class="container">
    <div class="c-hero__inner c-hero__inner--media-<?php echo esc_attr($media_position); ?>">
      <div class="c-hero__content <?php echo 'none' !== $text_box_style ? 'c-hero__content--' . esc_attr($text_box_style) : ''; ?>">
        <?php if (! empty($eyebrow)) : ?>
          <p class="eyebrow"><?php echo esc_html($eyebrow); ?></p>
        <?php endif; ?>

        <h1 class="c-hero__title"><?php echo esc_html($title); ?></h1>

        <?php if (! empty($subheading)) : ?>
          <p class="c-hero__subheading"><?php echo esc_html($subheading); ?></p>
        <?php endif; ?>

        <?php if (! empty($copy)) : ?>
          <div class="c-hero__copy"><?php echo wp_kses_post(wpautop($copy)); ?></div>
        <?php endif; ?>

        <?php if (! empty($button_primary['url']) || ! empty($button_secondary['url'])) : ?>
          <div class="c-hero__actions">
            <?php if (! empty($button_primary['url']) && ! empty($button_primary['title'])) : ?>
              <a class="btn btn--<?php echo esc_attr($button_primary_style); ?> btn--md" href="<?php echo esc_url($button_primary['url']); ?>" <?php echo ! empty($button_primary['target']) ? 'target="' . esc_attr($button_primary['target']) . '"' : ''; ?>>
                <?php echo esc_html($button_primary['title']); ?>
              </a>
            <?php endif; ?>

            <?php if (! empty($button_secondary['url']) && ! empty($button_secondary['title'])) : ?>
              <a class="btn btn--<?php echo esc_attr($button_secondary_style); ?> btn--md" href="<?php echo esc_url($button_secondary['url']); ?>" <?php echo ! empty($button_secondary['target']) ? 'target="' . esc_attr($button_secondary['target']) . '"' : ''; ?>>
                <?php echo esc_html($button_secondary['title']); ?>
              </a>
            <?php endif; ?>
          </div>
        <?php endif; ?>
      </div>

      <?php if ('image' === $media_type && ! empty($image['url'])) : ?>
        <figure class="c-hero__media image image--<?php echo esc_attr($image_style); ?>">
          <?php if ($image_id) : ?>
            <?php
            echo wp_get_attachment_image(
              $image_id,
              'sc-hero',
              false,
              array(
                'class'         => 'c-hero__image',
                'loading'       => 'eager',
                'fetchpriority' => 'high',
                'decoding'      => 'async',
                'sizes'         => '(min-width: 1200px) 560px, (min-width: 768px) 45vw, 100vw',
              )
            );
            ?>
          <?php else : ?>
            <img class="c-hero__image" src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr(isset($image['alt']) ? $image['alt'] : ''); ?>" loading="lazy" decoding="async" />
          <?php endif; ?>
        </figure>
      <?php endif; ?>

      <?php if ('video' === $media_type && (! empty($video_embed) || ! empty($video_url))) : ?>
        <div class="c-hero__media c-hero__media--video">
          <?php if (! empty($video_embed)) : ?>
            <?php echo wp_kses_post($video_embed); ?>
          <?php else : ?>
            <video controls preload="metadata" playsinline>
              <source src="<?php echo esc_url($video_url); ?>" />
            </video>
          <?php endif; ?>
        </div>
      <?php endif; ?>

      <?php if ('form' === $media_type) : ?>
        <div class="c-hero__media c-hero__media--form">
          <?php if (! empty($form_shortcode)) : ?>
            <?php echo do_shortcode($form_shortcode); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
            ?>
          <?php elseif (! empty($form_id) && 'wpforms' === $form_provider) : ?>
            <?php echo do_shortcode('[wpforms id="' . esc_attr($form_id) . '"]'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
            ?>
          <?php elseif (! empty($form_id) && 'hubspot' === $form_provider) : ?>
            <div class="c-hero__hubspot-form" data-hubspot-form-id="<?php echo esc_attr($form_id); ?>"></div>
          <?php elseif (! empty($form_id)) : ?>
            <div class="c-hero__generic-form" data-form-id="<?php echo esc_attr($form_id); ?>"></div>
          <?php endif; ?>
        </div>
      <?php endif; ?>
    </div>
  </div>
</section>