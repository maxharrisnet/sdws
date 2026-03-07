<?php

/**
 * Two column feature section.
 *
 * @package Starter_Coat
 */

$kicker          = starter_coat_get_sub_field('kicker', '');
$title           = starter_coat_get_sub_field('title', '');
$copy            = starter_coat_get_sub_field('copy', '');
$ratio           = starter_coat_get_sub_field('ratio', '50-50');
$media_position  = starter_coat_get_sub_field('media_position', 'left');
$media_image     = starter_coat_get_sub_field('media_image', null);
$button          = starter_coat_get_sub_field('button', null);
$section_classes = starter_coat_get_section_classes('section--feature');
$container_class = starter_coat_get_section_container_class();
?>
<section class="<?php echo esc_attr($section_classes); ?>">
  <div class="<?php echo esc_attr($container_class); ?>">
    <div class="layout layout--2col <?php echo '66-33' === $ratio ? 'layout--2col-wide' : 'layout--2col-even'; ?> <?php echo 'right' === $media_position ? 'layout--reverse' : ''; ?>">
      <div class="feature__media image image--rounded">
        <?php if (! empty($media_image['url'])) : ?>
          <img src="<?php echo esc_url($media_image['url']); ?>" alt="<?php echo esc_attr($media_image['alt'] ?? ''); ?>" loading="lazy" />
        <?php endif; ?>
      </div>
      <div class="feature__content">
        <?php if ($kicker) : ?>
          <p class="eyebrow"><?php echo esc_html($kicker); ?></p>
        <?php endif; ?>
        <?php if ($title) : ?>
          <h2><?php echo esc_html($title); ?></h2>
        <?php endif; ?>
        <?php if ($copy) : ?>
          <p><?php echo esc_html($copy); ?></p>
        <?php endif; ?>
        <?php if (! empty($button['url']) && ! empty($button['title'])) : ?>
          <a class="btn btn--primary btn--md" href="<?php echo esc_url($button['url']); ?>" <?php echo ! empty($button['target']) ? 'target="' . esc_attr($button['target']) . '"' : ''; ?>>
            <?php echo esc_html($button['title']); ?>
          </a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>