<?php

/**
 * Unified content/media section.
 *
 * @package Starter_Coat
 */

$layout_mode      = (string) starter_coat_get_sub_field('layout_mode', 'split');
$kicker           = (string) starter_coat_get_sub_field('kicker', '');
$title            = (string) starter_coat_get_sub_field('title', '');
$content          = (string) starter_coat_get_sub_field('content', '');
$media_image      = starter_coat_get_sub_field('media_image', null);
$ratio            = (string) starter_coat_get_sub_field('ratio', '50-50');
$media_position   = (string) starter_coat_get_sub_field('media_position', 'right');
$stack_order      = (string) starter_coat_get_sub_field('stack_order', 'text-media');
$image_style      = sanitize_html_class((string) starter_coat_get_sub_field('image_style', 'rounded'));
$section_width    = (string) starter_coat_get_sub_field('section_width', 'container');
$image_full_bleed = (bool) starter_coat_get_sub_field('image_full_bleed', false) && 'full' === $section_width;
$section_classes  = starter_coat_get_section_classes('section--content-media');
$container_class  = starter_coat_get_section_container_class();
$buttons          = array();

if (function_exists('have_rows') && call_user_func('have_rows', 'cta_buttons')) {
  while (call_user_func('have_rows', 'cta_buttons')) {
    call_user_func('the_row');

    $button_link  = starter_coat_get_sub_field('button_link', null);
    $button_style = sanitize_html_class((string) starter_coat_get_sub_field('button_style', 'primary'));

    if (! empty($button_link['url']) && ! empty($button_link['title'])) {
      $buttons[] = array(
        'link'  => $button_link,
        'style' => $button_style,
      );
    }
  }
}

$has_text  = '' !== trim($kicker) || '' !== trim($title) || '' !== trim(wp_strip_all_tags($content));
$has_media = is_array($media_image) && (! empty($media_image['ID']) || ! empty($media_image['url']));

if (! $has_text && ! $has_media && empty($buttons)) {
  return;
}

$layout_classes = array('c-content-media');
if ('split' === $layout_mode) {
  $layout_classes[] = 'layout';
  $layout_classes[] = 'layout--2col';
  $layout_classes[] = '66-33' === $ratio ? 'layout--2col-wide' : 'layout--2col-even';

  if ('left' === $media_position) {
    $layout_classes[] = 'layout--reverse';
  }

  if ($image_full_bleed) {
    $layout_classes[] = 'layout--media-full-bleed';
  }
} else {
  $layout_classes[] = 'stack';
  $layout_classes[] = 'stack--md';
  $layout_classes[] = 'c-content-media--stacked';

  if ('media-text' === $stack_order) {
    $layout_classes[] = 'c-content-media--stacked-media-first';
  }
}
?>
<section class="<?php echo esc_attr($section_classes); ?>">
  <div class="<?php echo esc_attr($container_class); ?>">
    <div class="<?php echo esc_attr(implode(' ', $layout_classes)); ?>">
      <div class="c-content-media__text richtext">
        <?php if ($kicker) : ?>
          <p class="eyebrow"><?php echo esc_html($kicker); ?></p>
        <?php endif; ?>

        <?php if ($title) : ?>
          <h2><?php echo esc_html($title); ?></h2>
        <?php endif; ?>

        <?php if ($content) : ?>
          <?php echo wp_kses_post($content); ?>
        <?php endif; ?>

        <?php if (! empty($buttons)) : ?>
          <div class="c-content-media__buttons">
            <?php foreach ($buttons as $button) : ?>
              <?php
              $style = 'ghost' === $button['style'] ? 'ghost' : 'primary';
              $link  = $button['link'];
              ?>
              <a class="btn btn--<?php echo esc_attr($style); ?> btn--md" href="<?php echo esc_url((string) $link['url']); ?>" <?php echo ! empty($link['target']) ? 'target="' . esc_attr((string) $link['target']) . '" rel="noopener"' : ''; ?>>
                <?php echo esc_html((string) $link['title']); ?>
              </a>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </div>

      <?php if ($has_media) : ?>
        <figure class="c-content-media__media image image--<?php echo esc_attr($image_style); ?>">
          <?php if (! empty($media_image['ID'])) : ?>
            <?php
            echo wp_get_attachment_image(
              (int) $media_image['ID'],
              'large',
              false,
              array(
                'loading' => 'lazy',
                'alt'     => isset($media_image['alt']) ? (string) $media_image['alt'] : '',
              )
            );
            ?>
          <?php elseif (! empty($media_image['url'])) : ?>
            <img src="<?php echo esc_url((string) $media_image['url']); ?>" alt="<?php echo esc_attr(isset($media_image['alt']) ? (string) $media_image['alt'] : ''); ?>" loading="lazy" />
          <?php endif; ?>
        </figure>
      <?php endif; ?>
    </div>
  </div>
</section>
