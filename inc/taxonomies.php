<?php

/**
 * Taxonomy registration.
 *
 * @package Starter_Coat
 */

if (! defined('ABSPATH')) {
  exit;
}

/**
 * Register custom taxonomies.
 */
function starter_coat_register_taxonomies()
{
  register_taxonomy(
    'project_category',
    array('project'),
    array(
      'labels'            => array(
        'name'          => __('Project Categories', 'starter-coat'),
        'singular_name' => __('Project Category', 'starter-coat'),
      ),
      'public'            => true,
      'hierarchical'      => true,
      'show_admin_column' => true,
      'show_in_rest'      => false,
    )
  );

  register_taxonomy(
    'event_type',
    array('event'),
    array(
      'labels'            => array(
        'name'          => __('Event Types', 'starter-coat'),
        'singular_name' => __('Event Type', 'starter-coat'),
      ),
      'public'            => true,
      'hierarchical'      => true,
      'show_admin_column' => true,
      'show_in_rest'      => false,
    )
  );

  register_taxonomy(
    'faq_topic',
    array('faq'),
    array(
      'labels'            => array(
        'name'          => __('FAQ Topics', 'starter-coat'),
        'singular_name' => __('FAQ Topic', 'starter-coat'),
      ),
      'public'            => true,
      'hierarchical'      => true,
      'show_admin_column' => true,
      'show_in_rest'      => false,
    )
  );
}
add_action('init', 'starter_coat_register_taxonomies');
