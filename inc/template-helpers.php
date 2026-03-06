<?php

/**
 * Template helper functions.
 *
 * @package Starter_Coat
 */

if (! defined('ABSPATH')) {
  exit;
}

/**
 * Get current preset slug.
 *
 * @return string
 */
function starter_coat_get_theme_preset()
{
  $preset = 'jill';

  if (function_exists('get_field')) {
    $acf_preset = call_user_func('get_field', 'sc_theme_preset', 'option');
    if (! empty($acf_preset)) {
      $preset = sanitize_title($acf_preset);
    }
  }

  return $preset;
}

/**
 * Add theme preset class to body.
 *
 * @param string[] $classes Existing classes.
 * @return string[]
 */
function starter_coat_body_classes_with_theme($classes)
{
  $classes[] = 'theme--' . starter_coat_get_theme_preset();

  return $classes;
}
add_filter('body_class', 'starter_coat_body_classes_with_theme');

/**
 * Render section partials from flexible content.
 */
function starter_coat_render_sections()
{
  if (! function_exists('have_rows')) {
    return;
  }

  $has_rows = call_user_func('have_rows', 'sc_sections');

  if (! $has_rows) {
    return;
  }

  while ($has_rows) {
    if (function_exists('the_row')) {
      call_user_func('the_row');
    }

    $layout = function_exists('get_row_layout') ? call_user_func('get_row_layout') : '';
    if (empty($layout)) {
      $has_rows = call_user_func('have_rows', 'sc_sections');
      continue;
    }

    get_template_part('template-parts/sections/section', $layout);
    $has_rows = call_user_func('have_rows', 'sc_sections');
  }
}
