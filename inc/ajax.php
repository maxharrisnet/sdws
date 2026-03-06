<?php

/**
 * AJAX handlers.
 *
 * @package Starter_Coat
 */

if (! defined('ABSPATH')) {
  exit;
}

/**
 * Filter posts by taxonomy term.
 */
function starter_coat_ajax_filter_posts()
{
  check_ajax_referer('starter-coat', 'nonce');

  $post_type = isset($_POST['postType']) ? sanitize_key(wp_unslash($_POST['postType'])) : 'post';
  $taxonomy  = isset($_POST['taxonomy']) ? sanitize_key(wp_unslash($_POST['taxonomy'])) : '';
  $term      = isset($_POST['term']) ? sanitize_title(wp_unslash($_POST['term'])) : 'all';

  $args = array(
    'post_type'      => $post_type,
    'posts_per_page' => 12,
    'post_status'    => 'publish',
  );

  if ($taxonomy && 'all' !== $term) {
    $args['tax_query'] = array(
      array(
        'taxonomy' => $taxonomy,
        'field'    => 'slug',
        'terms'    => $term,
      ),
    );
  }

  $query = new WP_Query($args);

  ob_start();

  if ($query->have_posts()) {
    while ($query->have_posts()) {
      $query->the_post();
      $style = 'project' === $post_type ? 'project' : 'post';
      get_template_part('template-parts/components/archive-card', null, array('style' => $style));
    }
  } else {
    echo '<p>' . esc_html__('No items found.', 'starter-coat') . '</p>';
  }

  wp_reset_postdata();

  wp_send_json_success(
    array(
      'html' => ob_get_clean(),
    )
  );
}
add_action('wp_ajax_starter_coat_filter_posts', 'starter_coat_ajax_filter_posts');
add_action('wp_ajax_nopriv_starter_coat_filter_posts', 'starter_coat_ajax_filter_posts');
