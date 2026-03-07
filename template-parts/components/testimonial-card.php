<?php

/**
 * Testimonial card component.
 *
 * @package Starter_Coat
 */

$testimonial = isset($args['testimonial']) && is_array($args['testimonial']) ? $args['testimonial'] : array();
$style       = isset($testimonial['style']) ? sanitize_html_class((string) $testimonial['style']) : 'simple';

$quote         = isset($testimonial['quote']) ? (string) $testimonial['quote'] : '';
$name          = isset($testimonial['name']) ? (string) $testimonial['name'] : '';
$info_line_one = isset($testimonial['info_line_one']) ? (string) $testimonial['info_line_one'] : '';
$info_line_two = isset($testimonial['info_line_two']) ? (string) $testimonial['info_line_two'] : '';
$photo         = isset($testimonial['photo']) && is_array($testimonial['photo']) ? $testimonial['photo'] : array();
$photo_id      = isset($photo['ID']) ? (int) $photo['ID'] : 0;

$photo_alt = isset($photo['alt']) && is_string($photo['alt']) && '' !== $photo['alt']
  ? $photo['alt']
  : $name;

if (! $quote && ! $name) {
  return;
}
?>
<article class="c-testimonial-card c-testimonial-card--<?php echo esc_attr($style); ?>">
  <?php if ('feature' === $style) : ?>
    <span class="c-testimonial-card__quote-icon c-testimonial-card__quote-icon--open" aria-hidden="true">
      <?php starter_coat_the_icon('icon-quote', array('class' => 'c-testimonial-card__quote-svg')); ?>
    </span>
  <?php endif; ?>

  <?php if ($photo_id > 0 || ! empty($photo['url'])) : ?>
    <div class="c-testimonial-card__photo-wrap">
      <?php if ($photo_id > 0) : ?>
        <?php
        echo wp_get_attachment_image(
          $photo_id,
          'sc-profile-square-sm',
          false,
          array(
            'class'    => 'c-testimonial-card__photo',
            'alt'      => $photo_alt,
            'loading'  => 'lazy',
            'decoding' => 'async',
          )
        );
        ?>
      <?php else : ?>
        <img class="c-testimonial-card__photo" src="<?php echo esc_url($photo['url']); ?>" alt="<?php echo esc_attr($photo_alt); ?>" loading="lazy" decoding="async" />
      <?php endif; ?>
    </div>
  <?php endif; ?>

  <?php if ($quote) : ?>
    <blockquote class="c-testimonial-card__quote">
      <p><?php echo esc_html($quote); ?></p>
    </blockquote>
  <?php endif; ?>

  <?php if ($name || $info_line_one || $info_line_two) : ?>
    <footer class="c-testimonial-card__meta">
      <?php if ($name) : ?>
        <p class="c-testimonial-card__name"><?php echo esc_html($name); ?></p>
      <?php endif; ?>
      <?php if ($info_line_one) : ?>
        <p class="c-testimonial-card__line"><?php echo esc_html($info_line_one); ?></p>
      <?php endif; ?>
      <?php if ($info_line_two) : ?>
        <p class="c-testimonial-card__line"><?php echo esc_html($info_line_two); ?></p>
      <?php endif; ?>
    </footer>
  <?php endif; ?>

  <?php if ('feature' === $style) : ?>
    <span class="c-testimonial-card__quote-icon c-testimonial-card__quote-icon--close" aria-hidden="true">
      <?php starter_coat_the_icon('icon-quote', array('class' => 'c-testimonial-card__quote-svg')); ?>
    </span>
  <?php endif; ?>
</article>