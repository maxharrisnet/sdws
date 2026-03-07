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

    // Hero is now a dedicated singular/archive component, not a flexible section.
    if ('hero' === $layout) {
      $has_rows = call_user_func('have_rows', 'sc_sections');
      continue;
    }

    $section_template = STARTER_COAT_PATH . '/template-parts/sections/section-' . $layout . '.php';
    if (! file_exists($section_template)) {
      $has_rows = call_user_func('have_rows', 'sc_sections');
      continue;
    }

    get_template_part('template-parts/sections/section', $layout);
    $has_rows = call_user_func('have_rows', 'sc_sections');
  }
}

/**
 * Safe wrapper for ACF sub field reads.
 *
 * @param string $name Sub field name.
 * @param mixed  $default Default value.
 * @return mixed
 */
function starter_coat_get_sub_field($name, $default = '')
{
  if (! function_exists('get_sub_field')) {
    return $default;
  }

  $value = call_user_func('get_sub_field', $name);
  if (null === $value || '' === $value) {
    return $default;
  }

  return $value;
}

/**
 * Build section utility classes from shared sub fields.
 *
 * @param string $base Base section class.
 * @return string
 */
function starter_coat_get_section_classes($base)
{
  $width   = sanitize_html_class((string) starter_coat_get_sub_field('section_width', 'container'));
  $padding = sanitize_html_class((string) starter_coat_get_sub_field('section_padding', 'lg'));
  $bg      = sanitize_html_class((string) starter_coat_get_sub_field('section_background', 'none'));
  $extra   = trim((string) starter_coat_get_sub_field('section_class', ''));

  $classes = array(
    'section',
    $base,
    'section--' . $padding,
  );

  if ('none' !== $bg) {
    $classes[] = 'bg-' . $bg;
  }

  if (! empty($extra)) {
    $classes[] = sanitize_html_class($extra);
  }

  return implode(' ', array_filter($classes));
}

/**
 * Get container class variant from section sub field.
 *
 * @return string
 */
function starter_coat_get_section_container_class()
{
  $width = starter_coat_get_sub_field('section_width', 'container');

  if ('full' === $width) {
    return 'container container--full';
  }

  if ('narrow' === $width) {
    return 'container container--narrow';
  }

  return 'container';
}

/**
 * Return whether singular hero is enabled.
 *
 * @param int $post_id Optional post ID.
 * @return bool
 */
function starter_coat_has_singular_hero($post_id = 0)
{
  if (! function_exists('get_field')) {
    return false;
  }

  $post_id = $post_id ? absint($post_id) : get_the_ID();
  if (! $post_id) {
    return false;
  }

  return (bool) call_user_func('get_field', 'sc_hero_enabled', $post_id);
}

/**
 * Build singular hero data array from ACF fields.
 *
 * @param int $post_id Optional post ID.
 * @return array<string,mixed>
 */
function starter_coat_get_singular_hero_data($post_id = 0)
{
  $post_id = $post_id ? absint($post_id) : get_the_ID();
  if (! $post_id) {
    return array('enabled' => false);
  }

  $post_type = get_post_type($post_id);
  $context   = 'page' === $post_type ? 'page' : 'entry';

  if (! function_exists('get_field')) {
    return array('enabled' => false);
  }

  $enabled = (bool) call_user_func('get_field', 'sc_hero_enabled', $post_id);
  if (! $enabled) {
    return array('enabled' => false);
  }

  $default_variant = 'page' === $context ? 'page-centered' : 'entry-centered';

  return array(
    'enabled'                => true,
    'context'                => $context,
    'variant'                => (string) call_user_func('get_field', 'sc_hero_variant', $post_id) ?: $default_variant,
    'eyebrow'                => (string) call_user_func('get_field', 'sc_hero_eyebrow', $post_id),
    'title'                  => (string) call_user_func('get_field', 'sc_hero_title', $post_id) ?: get_the_title($post_id),
    'subheading'             => (string) call_user_func('get_field', 'sc_hero_subheading', $post_id),
    'copy'                   => (string) call_user_func('get_field', 'sc_hero_paragraph', $post_id),
    'text_box_style'         => (string) call_user_func('get_field', 'sc_hero_text_box_style', $post_id) ?: 'none',
    'button_primary'         => call_user_func('get_field', 'sc_hero_button_primary', $post_id),
    'button_primary_style'   => (string) call_user_func('get_field', 'sc_hero_button_primary_style', $post_id) ?: 'primary',
    'button_secondary'       => call_user_func('get_field', 'sc_hero_button_secondary', $post_id),
    'button_secondary_style' => (string) call_user_func('get_field', 'sc_hero_button_secondary_style', $post_id) ?: 'ghost',
    'media_type'             => (string) call_user_func('get_field', 'sc_hero_media_type', $post_id) ?: 'none',
    'media_position'         => (string) call_user_func('get_field', 'sc_hero_media_position', $post_id) ?: 'right',
    'image'                  => call_user_func('get_field', 'sc_hero_image', $post_id),
    'image_style'            => (string) call_user_func('get_field', 'sc_hero_image_style', $post_id) ?: 'rounded',
    'video_embed'            => (string) call_user_func('get_field', 'sc_hero_video_embed', $post_id),
    'video_url'              => (string) call_user_func('get_field', 'sc_hero_video_url', $post_id),
    'form_shortcode'         => (string) call_user_func('get_field', 'sc_hero_form_shortcode', $post_id),
    'form_provider'          => (string) call_user_func('get_field', 'sc_hero_form_provider', $post_id) ?: 'generic',
    'form_id'                => (string) call_user_func('get_field', 'sc_hero_form_id', $post_id),
    'background'             => (string) call_user_func('get_field', 'sc_hero_background', $post_id) ?: 'none',
    'full_height'            => (bool) call_user_func('get_field', 'sc_hero_full_height', $post_id),
  );
}

/**
 * Render singular hero component.
 *
 * @param int $post_id Optional post ID.
 */
function starter_coat_render_singular_hero($post_id = 0)
{
  $hero = starter_coat_get_singular_hero_data($post_id);
  if (empty($hero['enabled'])) {
    return;
  }

  get_template_part('template-parts/components/hero', null, array('hero' => $hero));
}

/**
 * Build archive hero configuration by matching post type in options repeater.
 *
 * @param string $post_type Post type key.
 * @return array<string,mixed>
 */
function starter_coat_get_archive_hero_data($post_type)
{
  if (! function_exists('have_rows')) {
    return array('enabled' => false);
  }

  $target_type = sanitize_key((string) $post_type);
  $has_rows    = call_user_func('have_rows', 'sc_archive_hero_items', 'option');

  if (! $has_rows) {
    return array('enabled' => false);
  }

  while ($has_rows) {
    if (function_exists('the_row')) {
      call_user_func('the_row');
    }

    $row_post_type = function_exists('get_sub_field') ? sanitize_key((string) call_user_func('get_sub_field', 'post_type')) : '';
    if ($target_type !== $row_post_type) {
      $has_rows = call_user_func('have_rows', 'sc_archive_hero_items', 'option');
      continue;
    }

    return array(
      'enabled'                => (bool) call_user_func('get_sub_field', 'enabled'),
      'context'                => 'archive',
      'variant'                => (string) call_user_func('get_sub_field', 'variant') ?: 'archive-centered',
      'eyebrow'                => (string) call_user_func('get_sub_field', 'eyebrow'),
      'title'                  => (string) call_user_func('get_sub_field', 'title') ?: post_type_archive_title('', false),
      'subheading'             => (string) call_user_func('get_sub_field', 'subheading'),
      'copy'                   => (string) call_user_func('get_sub_field', 'paragraph'),
      'text_box_style'         => (string) call_user_func('get_sub_field', 'text_box_style') ?: 'none',
      'button_primary'         => call_user_func('get_sub_field', 'button_primary'),
      'button_primary_style'   => (string) call_user_func('get_sub_field', 'button_primary_style') ?: 'primary',
      'button_secondary'       => call_user_func('get_sub_field', 'button_secondary'),
      'button_secondary_style' => (string) call_user_func('get_sub_field', 'button_secondary_style') ?: 'ghost',
      'media_type'             => (string) call_user_func('get_sub_field', 'media_type') ?: 'none',
      'media_position'         => (string) call_user_func('get_sub_field', 'media_position') ?: 'right',
      'image'                  => call_user_func('get_sub_field', 'image'),
      'image_style'            => (string) call_user_func('get_sub_field', 'image_style') ?: 'rounded',
      'video_embed'            => (string) call_user_func('get_sub_field', 'video_embed'),
      'video_url'              => (string) call_user_func('get_sub_field', 'video_url'),
      'form_shortcode'         => (string) call_user_func('get_sub_field', 'form_shortcode'),
      'form_provider'          => (string) call_user_func('get_sub_field', 'form_provider') ?: 'generic',
      'form_id'                => (string) call_user_func('get_sub_field', 'form_id'),
      'background'             => (string) call_user_func('get_sub_field', 'background') ?: 'none',
      'full_height'            => (bool) call_user_func('get_sub_field', 'full_height'),
    );
  }

  return array('enabled' => false);
}

/**
 * Render archive hero for current queried archive.
 */
function starter_coat_render_archive_hero()
{
  $post_type = 'post';
  if (is_post_type_archive()) {
    $queried = get_queried_object();
    if (isset($queried->name)) {
      $post_type = sanitize_key((string) $queried->name);
    }
  }

  $hero = starter_coat_get_archive_hero_data($post_type);
  if (empty($hero['enabled'])) {
    return;
  }

  get_template_part('template-parts/components/hero', null, array('hero' => $hero));
}

/**
 * Check if archive hero exists and is enabled for current archive context.
 *
 * @return bool
 */
function starter_coat_has_archive_hero()
{
  $post_type = 'post';
  if (is_post_type_archive()) {
    $queried = get_queried_object();
    if (isset($queried->name)) {
      $post_type = sanitize_key((string) $queried->name);
    }
  }

  $hero = starter_coat_get_archive_hero_data($post_type);
  return ! empty($hero['enabled']);
}
