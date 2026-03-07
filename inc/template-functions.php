<?php

/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Starter_Coat
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function starter_coat_body_classes($classes)
{
  // Adds a class of hfeed to non-singular pages.
  if (! is_singular()) {
    $classes[] = 'hfeed';
  }

  // Adds a class of no-sidebar when there is no sidebar present.
  if (! is_active_sidebar('sidebar-1')) {
    $classes[] = 'no-sidebar';
  }

  return $classes;
}
add_filter('body_class', 'starter_coat_body_classes');

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function starter_coat_pingback_header()
{
  if (is_singular() && pings_open()) {
    printf('<link rel="pingback" href="%s">', esc_url(get_bloginfo('pingback_url')));
  }
}
add_action('wp_head', 'starter_coat_pingback_header');

/**
 * Allow SVG uploads for theme branding assets.
 *
 * @param array<string,string> $mimes Allowed mime types.
 * @return array<string,string>
 */
function starter_coat_allow_svg_uploads($mimes)
{
  $mimes['svg'] = 'image/svg+xml';
  $mimes['svgz'] = 'image/svg+xml';

  return $mimes;
}
add_filter('upload_mimes', 'starter_coat_allow_svg_uploads');

/**
 * Render fallback favicon from Theme Settings when Site Icon is not set.
 */
function starter_coat_render_favicon()
{
  if (function_exists('has_site_icon') && has_site_icon()) {
    return;
  }

  if (! function_exists('get_field')) {
    return;
  }

  $favicon = call_user_func('get_field', 'sc_site_favicon', 'option');
  if (! is_array($favicon) || empty($favicon['url'])) {
    return;
  }

  $mime = '';
  if (! empty($favicon['mime_type']) && is_string($favicon['mime_type'])) {
    $mime = $favicon['mime_type'];
  }

  echo '<link rel="icon" href="' . esc_url($favicon['url']) . '"' . ($mime ? ' type="' . esc_attr($mime) . '"' : '') . '>';
}
add_action('wp_head', 'starter_coat_render_favicon', 20);
