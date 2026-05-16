<?php

/**
 * Numbered pagination component.
 *
 * @package Starter_Coat
 */

global $wp_query;

if ($wp_query->max_num_pages < 2) {
  return;
}

$links = paginate_links(array(
  'mid_size'  => 2,
  'prev_text' => '&larr; ' . __('Previous', 'starter-coat'),
  'next_text' => __('Next', 'starter-coat') . ' &rarr;',
  'type'      => 'array',
));

if (empty($links)) {
  return;
}
?>
<nav class="pagination" aria-label="<?php esc_attr_e('Pagination', 'starter-coat'); ?>">
  <div class="pagination__list">
    <?php foreach ($links as $link) : ?>
      <?php echo $link; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- paginate_links output ?>
    <?php endforeach; ?>
  </div>
</nav>
