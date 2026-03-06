<?php

/**
 * Custom post type registration.
 *
 * @package Starter_Coat
 */

if (! defined('ABSPATH')) {
  exit;
}

/**
 * Register reusable project post type.
 */
function starter_coat_register_post_types()
{
  $common_supports = array('title', 'editor', 'thumbnail', 'excerpt', 'revisions');

  register_post_type(
    'project',
    array(
      'labels'       => array(
        'name'          => __('Projects', 'starter-coat'),
        'singular_name' => __('Project', 'starter-coat'),
      ),
      'public'       => true,
      'has_archive'  => true,
      'menu_icon'    => 'dashicons-portfolio',
      'rewrite'      => array('slug' => 'projects'),
      'show_in_rest' => false,
      'supports'     => $common_supports,
    )
  );

  register_post_type(
    'event',
    array(
      'labels'       => array(
        'name'          => __('Events', 'starter-coat'),
        'singular_name' => __('Event', 'starter-coat'),
      ),
      'public'       => true,
      'has_archive'  => true,
      'menu_icon'    => 'dashicons-calendar-alt',
      'rewrite'      => array('slug' => 'events'),
      'show_in_rest' => false,
      'supports'     => $common_supports,
    )
  );

  register_post_type(
    'faq',
    array(
      'labels'       => array(
        'name'          => __('FAQs', 'starter-coat'),
        'singular_name' => __('FAQ', 'starter-coat'),
      ),
      'public'       => true,
      'has_archive'  => true,
      'menu_icon'    => 'dashicons-editor-help',
      'rewrite'      => array('slug' => 'faq'),
      'show_in_rest' => false,
      'supports'     => array('title', 'editor', 'revisions'),
    )
  );

  register_post_type(
    'profile',
    array(
      'labels'       => array(
        'name'          => __('Profiles', 'starter-coat'),
        'singular_name' => __('Profile', 'starter-coat'),
      ),
      'public'       => true,
      'has_archive'  => true,
      'menu_icon'    => 'dashicons-id',
      'rewrite'      => array('slug' => 'profiles'),
      'show_in_rest' => false,
      'supports'     => array('title', 'editor', 'thumbnail', 'revisions'),
    )
  );
}
add_action('init', 'starter_coat_register_post_types');
