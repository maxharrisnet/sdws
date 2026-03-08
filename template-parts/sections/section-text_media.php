<?php

/**
 * Single column text/media section.
 *
 * @package Starter_Coat
 */

$content          = starter_coat_get_sub_field('content', '');
$media_image      = starter_coat_get_sub_field('media_image', null);
$image_style      = sanitize_html_class((string) starter_coat_get_sub_field('image_style', 'soft'));
$media_position   = starter_coat_get_sub_field('media_position', 'right');
$section_width    = (string) starter_coat_get_sub_field('section_width', 'container');
$image_full_bleed = (bool) starter_coat_get_sub_field('image_full_bleed', false) && 'full' === $section_width;
$section_classes  = starter_coat_get_section_classes('section--text-media');
$container_class  = starter_coat_get_section_container_class();
$layout_classes   = array(
  'layout',
  'layout--2col',
  'layout--2col-even',
);

if ('left' === $media_position) {
  $layout_classes[] = 'layout--reverse';
}

if ($image_full_bleed) {
  $layout_classes[] = 'layout--media-full-bleed';
}
?>
<section class="<?php echo esc_attr($section_classes); ?>">
  <div class="<?php echo esc_attr($container_class); ?>">
    <div class="<?php echo esc_attr(implode(' ', $layout_classes)); ?>">
      <div class="richtext">
        <?php echo wp_kses_post($content); ?>
      </div>

      <?php if (! empty($media_image['url'])) : ?>
        <figure class="image image--<?php echo esc_attr($image_style); ?>">
          <img src="<?php echo esc_url($media_image['url']); ?>" alt="<?php echo esc_attr($media_image['alt'] ?? ''); ?>" loading="lazy" />
        </figure>
      <?php endif; ?>
    </div>
  </div>
</section>