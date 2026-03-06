<?php

/**
 * Archive card component.
 *
 * @package Starter_Coat
 */

$style = isset($args['style']) ? sanitize_html_class($args['style']) : 'post';
?>
<article <?php post_class('c-archive-card c-archive-card--' . $style); ?>>
  <a class="c-archive-card__link" href="<?php the_permalink(); ?>">
    <?php if (has_post_thumbnail()) : ?>
      <div class="c-archive-card__media"><?php the_post_thumbnail('large'); ?></div>
    <?php endif; ?>
    <div class="c-archive-card__body">
      <h3 class="c-archive-card__title"><?php the_title(); ?></h3>
      <div class="c-archive-card__excerpt"><?php the_excerpt(); ?></div>
    </div>
  </a>
</article>