<?php

/**
 * Editor policies.
 *
 * @package Starter_Coat
 */

if (! defined('ABSPATH')) {
  exit;
}

/**
 * Determine if block editor should be disabled for a post type.
 *
 * @param string $post_type Post type slug.
 * @return bool
 */
function starter_coat_disable_block_editor_for_type($post_type)
{
  $disabled_post_types = array(
    'page',
    'project',
    'event',
    'faq',
    'profile',
  );

  return in_array($post_type, $disabled_post_types, true);
}

/**
 * Disable Gutenberg for selected post types.
 *
 * @param bool   $use_block_editor Current state.
 * @param string $post_type Post type slug.
 * @return bool
 */
function starter_coat_use_block_editor_for_post_type($use_block_editor, $post_type)
{
  if (starter_coat_disable_block_editor_for_type($post_type)) {
    return false;
  }

  return $use_block_editor;
}
add_filter('use_block_editor_for_post_type', 'starter_coat_use_block_editor_for_post_type', 10, 2);

/**
 * Temporarily hide the default content editor on Pages.
 */
function starter_coat_hide_page_content_editor()
{
  remove_post_type_support('page', 'editor');
}
add_action('init', 'starter_coat_hide_page_content_editor', 20);

/**
 * Keep frontend clean when blocks are not used on page/CPT templates.
 */
function starter_coat_dequeue_block_styles()
{
  if (is_admin()) {
    return;
  }

  if (is_page() || is_singular(array('project', 'event', 'faq', 'profile'))) {
    wp_dequeue_style('wp-block-library');
    wp_dequeue_style('wp-block-library-theme');
    wp_dequeue_style('global-styles');
  }
}
add_action('wp_enqueue_scripts', 'starter_coat_dequeue_block_styles', 100);
