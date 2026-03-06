<?php

/**
 * Category filter component shell.
 *
 * @package Starter_Coat
 */

$taxonomy = isset($args['taxonomy']) ? $args['taxonomy'] : 'category';
$post_type = isset($args['post_type']) ? $args['post_type'] : 'post';
$target_id = isset($args['target_id']) ? sanitize_html_class($args['target_id']) : 'archive-results';
$terms    = get_terms(
  array(
    'taxonomy'   => $taxonomy,
    'hide_empty' => true,
  )
);
?>
<div class="c-category-filter" data-filter-taxonomy="<?php echo esc_attr($taxonomy); ?>" data-filter-post-type="<?php echo esc_attr($post_type); ?>" data-filter-target="<?php echo esc_attr($target_id); ?>">
  <button class="btn btn--ghost btn--sm is-active" data-filter-term="all"><?php esc_html_e('All', 'starter-coat'); ?></button>
  <?php if (! is_wp_error($terms)) : ?>
    <?php foreach ($terms as $term) : ?>
      <button class="btn btn--ghost btn--sm" data-filter-term="<?php echo esc_attr($term->slug); ?>"><?php echo esc_html($term->name); ?></button>
    <?php endforeach; ?>
  <?php endif; ?>
</div>