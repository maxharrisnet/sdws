<?php

/**
 * Related posts component.
 *
 * Displays 3 posts of the same type, preferring same taxonomy term.
 *
 * @package Starter_Coat
 */

$current_id = get_the_ID();
$post_type  = get_post_type();
$count      = 3;

// Determine the primary taxonomy for this post type.
$taxonomies = get_object_taxonomies($post_type, 'objects');
$tax_slug   = '';
$term_slugs = array();
foreach ($taxonomies as $tax) {
  if ($tax->public && $tax->hierarchical) {
    $terms = get_the_terms($current_id, $tax->name);
    if (! empty($terms) && ! is_wp_error($terms)) {
      $tax_slug   = $tax->name;
      $term_slugs = wp_list_pluck($terms, 'slug');
      break;
    }
  }
}

$args = array(
  'post_type'      => $post_type,
  'posts_per_page' => $count,
  'post_status'    => 'publish',
  'post__not_in'   => array($current_id),
);

if ($tax_slug && $term_slugs) {
  $args['tax_query'] = array(
    array(
      'taxonomy' => $tax_slug,
      'field'    => 'slug',
      'terms'    => $term_slugs,
    ),
  );
}

$related = new WP_Query($args);

// Fallback: if not enough results, query without taxonomy filter.
if ($related->found_posts < $count && $tax_slug) {
  $exclude = array($current_id);
  if ($related->have_posts()) {
    $exclude = array_merge($exclude, wp_list_pluck($related->posts, 'ID'));
  }

  $fallback = new WP_Query(array(
    'post_type'      => $post_type,
    'posts_per_page' => $count - $related->found_posts,
    'post_status'    => 'publish',
    'post__not_in'   => $exclude,
    'orderby'        => 'rand',
  ));

  $related->posts       = array_merge($related->posts, $fallback->posts);
  $related->post_count  = count($related->posts);
  $related->found_posts = $related->post_count;
}

if (! $related->have_posts()) {
  wp_reset_postdata();
  return;
}

$card_style = 'post';
if ('project' === $post_type) {
  $card_style = 'project';
} elseif ('press' === $post_type) {
  $card_style = 'press';
}
?>
<section class="section section--md related-posts">
  <div class="container">
    <h2 class="related-posts__heading"><?php esc_html_e('Related', 'starter-coat'); ?></h2>
    <div class="layout layout--3col">
      <?php
      while ($related->have_posts()) :
        $related->the_post();
        get_template_part('template-parts/sdws/sdws-card');
      endwhile;
      ?>
    </div>
  </div>
</section>
<?php
wp_reset_postdata();
