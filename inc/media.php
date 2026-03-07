<?php

/**
 * Media sizes, defaults, and icon helpers.
 *
 * @package Starter_Coat
 */

if (! defined('ABSPATH')) {
  exit;
}

/**
 * Register custom image sizes used by theme components.
 */
function starter_coat_register_media_sizes()
{
  // Profile and author portraits.
  add_image_size('sc-profile-square-sm', 320, 320, true);
  add_image_size('sc-profile-square-lg', 640, 640, true);

  // Hero component images.
  add_image_size('sc-hero', 1920, 1080, true);
  add_image_size('sc-hero-md', 1280, 720, true);

  // Brand logos.
  add_image_size('sc-logo', 480, 180, false);
  add_image_size('sc-logo-mark', 200, 200, true);

  // Card media headers.
  add_image_size('sc-card-header', 960, 600, true);
  add_image_size('sc-card-header-featured', 1440, 900, true);
}
add_action('after_setup_theme', 'starter_coat_register_media_sizes', 20);

/**
 * Expose custom image sizes in the media modal size picker.
 *
 * @param array<string,string> $sizes Existing image sizes.
 * @return array<string,string>
 */
function starter_coat_image_size_names($sizes)
{
  $custom_sizes = array(
    'sc-profile-square-sm'    => __('Profile Square - Small', 'starter-coat'),
    'sc-profile-square-lg'    => __('Profile Square - Large', 'starter-coat'),
    'sc-hero'                 => __('Hero - Desktop', 'starter-coat'),
    'sc-hero-md'              => __('Hero - Medium', 'starter-coat'),
    'sc-logo'                 => __('Logo', 'starter-coat'),
    'sc-logo-mark'            => __('Logo Mark (Square)', 'starter-coat'),
    'sc-card-header'          => __('Card Header', 'starter-coat'),
    'sc-card-header-featured' => __('Card Header - Featured', 'starter-coat'),
  );

  return array_merge($sizes, $custom_sizes);
}
add_filter('image_size_names_choose', 'starter_coat_image_size_names');

/**
 * Set media setting defaults when the theme is activated.
 */
function starter_coat_set_default_media_options()
{
  $defaults = array(
    'thumbnail_size_w'    => 480,
    'thumbnail_size_h'    => 480,
    'thumbnail_crop'      => 1,
    'medium_size_w'       => 768,
    'medium_size_h'       => 0,
    'medium_large_size_w' => 1280,
    'large_size_w'        => 1920,
    'large_size_h'        => 0,
  );

  foreach ($defaults as $option => $value) {
    update_option($option, $value);
  }
}
add_action('after_switch_theme', 'starter_coat_set_default_media_options');

/**
 * Return normalized icon slug.
 *
 * @param string $icon Icon key from template usage.
 * @return string
 */
function starter_coat_normalize_icon_name($icon)
{
  $icon = strtolower((string) $icon);
  $icon = preg_replace('/[^a-z0-9\-_]/', '', $icon);

  return is_string($icon) ? $icon : '';
}

/**
 * Build absolute file path for a theme SVG icon.
 *
 * @param string $icon Icon slug.
 * @return string
 */
function starter_coat_get_icon_path($icon)
{
  $slug = starter_coat_normalize_icon_name($icon);
  if ('' === $slug) {
    return '';
  }

  $path = STARTER_COAT_PATH . '/assets/icons/' . $slug . '.svg';

  return file_exists($path) ? $path : '';
}

/**
 * Return inline SVG markup for a theme icon file.
 *
 * @param string               $icon Icon slug.
 * @param array<string,mixed> $args Render arguments.
 * @return string
 */
function starter_coat_get_icon_svg($icon, $args = array())
{
  $defaults = array(
    'class'      => '',
    'title'      => '',
    'decorative' => true,
  );
  $args = wp_parse_args($args, $defaults);

  $path = starter_coat_get_icon_path($icon);
  if ('' === $path) {
    return '';
  }

  static $cache = array();
  if (! isset($cache[$path])) {
    $raw = (string) file_get_contents($path);
    $raw = preg_replace('/<\?xml[^>]*>\s*/i', '', $raw);
    $raw = preg_replace('/<!doctype[^>]*>\s*/i', '', (string) $raw);
    $cache[$path] = is_string($raw) ? trim($raw) : '';
  }

  $svg = $cache[$path];
  if ('' === $svg || false === strpos($svg, '<svg')) {
    return '';
  }

  $title = trim((string) $args['title']);
  $icon_class = trim((string) $args['class']);
  $decorative = ! empty($args['decorative']);

  $title_markup = '';
  if (! $decorative && '' !== $title) {
    $title_markup = '<title>' . esc_html($title) . '</title>';
  }

  $aria_attrs = $decorative
    ? ' aria-hidden="true" focusable="false"'
    : ' role="img" aria-label="' . esc_attr($title ?: starter_coat_normalize_icon_name($icon)) . '" focusable="false"';

  if ('' !== $icon_class) {
    if (preg_match('/\sclass="([^"]*)"/i', $svg, $class_match)) {
      $merged = trim($class_match[1] . ' ' . $icon_class);
      $svg = preg_replace('/\sclass="([^"]*)"/i', ' class="' . esc_attr($merged) . '"', $svg, 1);
    } else {
      $svg = preg_replace('/<svg\b/i', '<svg class="' . esc_attr($icon_class) . '"', $svg, 1);
    }
  }

  $svg = preg_replace('/<svg\b([^>]*)>/i', '<svg$1' . $aria_attrs . '>', $svg, 1);

  if ('' !== $title_markup) {
    $svg = preg_replace('/<svg\b[^>]*>/i', '$0' . $title_markup, $svg, 1);
  }

  return is_string($svg) ? $svg : '';
}

/**
 * Echo inline SVG markup for an icon.
 *
 * @param string               $icon Icon slug.
 * @param array<string,mixed> $args Render arguments.
 */
function starter_coat_the_icon($icon, $args = array())
{
  echo starter_coat_get_icon_svg($icon, $args); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}

/**
 * Return a list of available icon slugs in /assets/icons.
 *
 * @return string[]
 */
function starter_coat_get_available_icons()
{
  $glob = glob(STARTER_COAT_PATH . '/assets/icons/*.svg');
  if (! is_array($glob)) {
    return array();
  }

  $icons = array();
  foreach ($glob as $path) {
    $name = pathinfo($path, PATHINFO_FILENAME);
    if (is_string($name) && '' !== $name) {
      $icons[] = $name;
    }
  }

  sort($icons);

  return $icons;
}
