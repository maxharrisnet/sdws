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
 * Sanitize SVG uploads by stripping dangerous elements and attributes.
 *
 * @param array $file File data from wp_handle_upload_prefilter.
 * @return array
 */
function starter_coat_sanitize_svg_upload($file)
{
  if ($file['type'] !== 'image/svg+xml') {
    return $file;
  }

  $content = file_get_contents($file['tmp_name']);
  if ($content === false) {
    $file['error'] = __('Could not read SVG file.', 'starter-coat');
    return $file;
  }

  // Strip XML processing instructions and DOCTYPE.
  $content = preg_replace('/<\?xml[^>]*\?>/i', '', $content);
  $content = preg_replace('/<!DOCTYPE[^>]*>/i', '', $content);

  // Remove dangerous elements.
  $dangerous_tags = array('script', 'foreignObject', 'set', 'animate', 'animateTransform', 'animateMotion');
  foreach ($dangerous_tags as $tag) {
    $content = preg_replace('/<' . $tag . '\b[^>]*>.*?<\/' . $tag . '>/is', '', $content);
    $content = preg_replace('/<' . $tag . '\b[^>]*\/>/is', '', $content);
  }

  // Remove on* event attributes.
  $content = preg_replace('/\s+on\w+\s*=\s*(["\']).*?\1/is', '', $content);
  $content = preg_replace('/\s+on\w+\s*=\s*[^\s>]+/is', '', $content);

  // Remove javascript: URLs in href/xlink:href attributes.
  $content = preg_replace('/\s+(href|xlink:href)\s*=\s*(["\'])\s*javascript:.*?\2/is', '', $content);

  file_put_contents($file['tmp_name'], $content);

  return $file;
}
add_filter('wp_handle_upload_prefilter', 'starter_coat_sanitize_svg_upload');

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
