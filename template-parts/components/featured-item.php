<?php

/**
 * Featured item component.
 *
 * @package Starter_Coat
 */

$post_id = isset($args['post_id']) ? absint($args['post_id']) : 0;

if (! $post_id) {
  return;
}
?>
<article class="c-featured-item">
  <a class="c-featured-item__link" href="<?php echo esc_url(get_permalink($post_id)); ?>">
    <?php echo get_the_post_thumbnail($post_id, 'sc-card-header-featured', array('class' => 'c-featured-item__media')); ?>
    <div class="c-featured-item__body">
      <p class="c-featured-item__kicker"><?php esc_html_e('Featured', 'starter-coat'); ?></p>
      <h2 class="c-featured-item__title"><?php echo esc_html(get_the_title($post_id)); ?></h2>
    </div>
  </a>
</article>