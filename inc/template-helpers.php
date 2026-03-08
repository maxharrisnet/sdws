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
 * Get nav settings from options with safe defaults.
 *
 * @return array<string,mixed>
 */
function starter_coat_get_nav_settings()
{
  $settings = array(
    'variant'         => 'inline',
    'style'           => 'clean',
    'alignment'       => 'between',
    'item_style'      => 'text',
    'item_shape'      => 'soft',
    'dropdown_style'  => 'elevated',
    'fixed'           => true,
    'show_logo'       => true,
    'logo_mode'       => 'custom_logo',
    'logo_image'      => null,
    'logo_mark_image' => null,
    'logo_max_width'  => 180,
    'logo_mark_max_width' => 48,
    'logo_mark_breakpoint' => 1024,
    'show_cta'        => false,
    'cta_link'        => null,
    'cta_style'       => 'primary',
    'banner_enabled'  => false,
    'banner_text'     => '',
    'banner_link'     => null,
    'banner_style'    => 'dark',
  );

  if (! function_exists('get_field')) {
    return $settings;
  }

  $variant_value = (string) call_user_func('get_field', 'sc_nav_variant', 'option');
  $style_value   = (string) call_user_func('get_field', 'sc_nav_style', 'option');

  // Backward compatibility: older installs stored style in sc_nav_variant.
  if (in_array($variant_value, array('clean', 'outlined', 'soft', 'transparent'), true)) {
    $settings['style'] = $variant_value;
    $settings['variant'] = 'inline';
  } else {
    $settings['variant'] = $variant_value ?: $settings['variant'];
    $settings['style'] = $style_value ?: $settings['style'];
  }
  $settings['alignment'] = (string) call_user_func('get_field', 'sc_nav_alignment', 'option') ?: $settings['alignment'];
  $settings['item_style'] = (string) call_user_func('get_field', 'sc_nav_item_style', 'option') ?: $settings['item_style'];
  $settings['item_shape'] = (string) call_user_func('get_field', 'sc_nav_item_shape', 'option') ?: $settings['item_shape'];
  $settings['dropdown_style'] = (string) call_user_func('get_field', 'sc_nav_dropdown_style', 'option') ?: $settings['dropdown_style'];
  $settings['fixed'] = (bool) call_user_func('get_field', 'sc_nav_fixed', 'option');
  $settings['show_logo'] = (bool) call_user_func('get_field', 'sc_nav_show_logo', 'option');
  $settings['logo_mode'] = (string) call_user_func('get_field', 'sc_nav_logo_mode', 'option') ?: $settings['logo_mode'];
  $settings['logo_image'] = call_user_func('get_field', 'sc_nav_logo_image', 'option');
  $settings['logo_mark_image'] = call_user_func('get_field', 'sc_nav_logo_mark_image', 'option');

  $logo_max_width = absint((int) call_user_func('get_field', 'sc_nav_logo_max_width', 'option'));
  if ($logo_max_width > 0) {
    $settings['logo_max_width'] = $logo_max_width;
  }

  $logo_mark_max_width = absint((int) call_user_func('get_field', 'sc_nav_logo_mark_max_width', 'option'));
  if ($logo_mark_max_width > 0) {
    $settings['logo_mark_max_width'] = $logo_mark_max_width;
  }

  $logo_mark_breakpoint = absint((int) call_user_func('get_field', 'sc_nav_logo_mark_breakpoint', 'option'));
  if ($logo_mark_breakpoint > 0) {
    $settings['logo_mark_breakpoint'] = $logo_mark_breakpoint;
  }

  $settings['show_cta'] = (bool) call_user_func('get_field', 'sc_nav_show_cta', 'option');
  $settings['cta_link'] = call_user_func('get_field', 'sc_nav_cta_link', 'option');
  $settings['cta_style'] = (string) call_user_func('get_field', 'sc_nav_cta_style', 'option') ?: $settings['cta_style'];

  $settings['banner_enabled'] = (bool) call_user_func('get_field', 'sc_nav_banner_enabled', 'option');
  $settings['banner_text'] = (string) call_user_func('get_field', 'sc_nav_banner_text', 'option');
  $settings['banner_link'] = call_user_func('get_field', 'sc_nav_banner_link', 'option');
  $settings['banner_style'] = (string) call_user_func('get_field', 'sc_nav_banner_style', 'option') ?: $settings['banner_style'];

  return $settings;
}

/**
 * Get contact information from options.
 *
 * @return array<string,mixed>
 */
function starter_coat_get_contact_info()
{
  if (! function_exists('get_field')) {
    return array(
      'phone'   => '',
      'email'   => '',
      'address' => '',
      'hours'   => '',
    );
  }

  return array(
    'phone'   => (string) call_user_func('get_field', 'sc_contact_phone', 'option'),
    'email'   => (string) call_user_func('get_field', 'sc_contact_email', 'option'),
    'address' => (string) call_user_func('get_field', 'sc_contact_address', 'option'),
    'hours'   => (string) call_user_func('get_field', 'sc_contact_hours', 'option'),
  );
}

/**
 * Get social media links from options.
 *
 * @return array<string,mixed>
 */
function starter_coat_get_social_links()
{
  if (! function_exists('get_field')) {
    return array();
  }

  $links = array(
    'facebook'  => (string) call_user_func('get_field', 'sc_social_facebook', 'option'),
    'twitter'   => (string) call_user_func('get_field', 'sc_social_twitter', 'option'),
    'instagram' => (string) call_user_func('get_field', 'sc_social_instagram', 'option'),
    'linkedin'  => (string) call_user_func('get_field', 'sc_social_linkedin', 'option'),
    'youtube'   => (string) call_user_func('get_field', 'sc_social_youtube', 'option'),
    'tiktok'    => (string) call_user_func('get_field', 'sc_social_tiktok', 'option'),
    'pinterest' => (string) call_user_func('get_field', 'sc_social_pinterest', 'option'),
    'github'    => (string) call_user_func('get_field', 'sc_social_github', 'option'),
  );

  // Filter out empty values.
  return array_filter($links);
}

/**
 * Get global footer CTA settings.
 *
 * @return array<string,mixed>
 */
function starter_coat_get_global_cta_settings()
{
  $settings = array(
    'enabled'                => false,
    'eyebrow'                => '',
    'title'                  => '',
    'subheading'             => '',
    'copy'                   => '',
    'action_mode'            => 'buttons',
    'form_shortcode'         => '',
    'button_primary'         => null,
    'button_primary_style'   => 'primary',
    'button_secondary'       => null,
    'button_secondary_style' => 'ghost',
    'layout'                 => 'stacked',
    'split_ratio'            => 'two-thirds',
    'width'                  => 'container',
    'background'             => 'none',
    'text_box_style'         => 'surface',
  );

  if (! function_exists('get_field')) {
    return $settings;
  }

  $settings['enabled'] = (bool) call_user_func('get_field', 'sc_global_cta_enabled', 'option');
  $settings['eyebrow'] = (string) call_user_func('get_field', 'sc_global_cta_eyebrow', 'option');
  $settings['title'] = (string) call_user_func('get_field', 'sc_global_cta_title', 'option');
  $settings['subheading'] = (string) call_user_func('get_field', 'sc_global_cta_subheading', 'option');
  $settings['copy'] = (string) call_user_func('get_field', 'sc_global_cta_paragraph', 'option');
  $settings['action_mode'] = (string) call_user_func('get_field', 'sc_global_cta_action_mode', 'option') ?: $settings['action_mode'];
  $settings['form_shortcode'] = (string) call_user_func('get_field', 'sc_global_cta_form_shortcode', 'option');
  $settings['button_primary'] = call_user_func('get_field', 'sc_global_cta_button_primary', 'option');
  $settings['button_primary_style'] = (string) call_user_func('get_field', 'sc_global_cta_button_primary_style', 'option') ?: $settings['button_primary_style'];
  $settings['button_secondary'] = call_user_func('get_field', 'sc_global_cta_button_secondary', 'option');
  $settings['button_secondary_style'] = (string) call_user_func('get_field', 'sc_global_cta_button_secondary_style', 'option') ?: $settings['button_secondary_style'];
  $settings['layout'] = (string) call_user_func('get_field', 'sc_global_cta_layout', 'option') ?: $settings['layout'];
  $settings['split_ratio'] = (string) call_user_func('get_field', 'sc_global_cta_split_ratio', 'option') ?: $settings['split_ratio'];
  $settings['width'] = (string) call_user_func('get_field', 'sc_global_cta_width', 'option') ?: $settings['width'];
  $settings['background'] = (string) call_user_func('get_field', 'sc_global_cta_background', 'option') ?: $settings['background'];
  $settings['text_box_style'] = (string) call_user_func('get_field', 'sc_global_cta_text_box_style', 'option') ?: $settings['text_box_style'];

  return $settings;
}

/**
 * Get page-level CTA settings when override is enabled.
 *
 * @param int $post_id Post ID.
 * @return array<string,mixed>|null
 */
function starter_coat_get_page_cta_override($post_id)
{
  if (! function_exists('get_field')) {
    return null;
  }

  $post_id = absint($post_id);
  if (! $post_id) {
    return null;
  }

  $override = (bool) call_user_func('get_field', 'sc_page_cta_override', $post_id);
  if (! $override) {
    return null;
  }

  return array(
    'enabled'                => (bool) call_user_func('get_field', 'sc_page_cta_enabled', $post_id),
    'eyebrow'                => (string) call_user_func('get_field', 'sc_page_cta_eyebrow', $post_id),
    'title'                  => (string) call_user_func('get_field', 'sc_page_cta_title', $post_id),
    'subheading'             => (string) call_user_func('get_field', 'sc_page_cta_subheading', $post_id),
    'copy'                   => (string) call_user_func('get_field', 'sc_page_cta_paragraph', $post_id),
    'action_mode'            => (string) call_user_func('get_field', 'sc_page_cta_action_mode', $post_id),
    'form_shortcode'         => (string) call_user_func('get_field', 'sc_page_cta_form_shortcode', $post_id),
    'button_primary'         => call_user_func('get_field', 'sc_page_cta_button_primary', $post_id),
    'button_primary_style'   => (string) call_user_func('get_field', 'sc_page_cta_button_primary_style', $post_id),
    'button_secondary'       => call_user_func('get_field', 'sc_page_cta_button_secondary', $post_id),
    'button_secondary_style' => (string) call_user_func('get_field', 'sc_page_cta_button_secondary_style', $post_id),
    'layout'                 => (string) call_user_func('get_field', 'sc_page_cta_layout', $post_id),
    'split_ratio'            => (string) call_user_func('get_field', 'sc_page_cta_split_ratio', $post_id),
    'width'                  => (string) call_user_func('get_field', 'sc_page_cta_width', $post_id),
    'background'             => (string) call_user_func('get_field', 'sc_page_cta_background', $post_id),
    'text_box_style'         => (string) call_user_func('get_field', 'sc_page_cta_text_box_style', $post_id),
  );
}

/**
 * Build CTA data with page overrides applied to global defaults.
 *
 * @param int $post_id Optional post ID.
 * @return array<string,mixed>
 */
function starter_coat_get_footer_cta_data($post_id = 0)
{
  $cta = starter_coat_get_global_cta_settings();

  if (! is_singular()) {
    return $cta;
  }

  $post_id = $post_id ? absint($post_id) : get_the_ID();
  if (! $post_id) {
    return $cta;
  }

  $override = starter_coat_get_page_cta_override($post_id);
  if (! is_array($override)) {
    return $cta;
  }

  $cta['enabled'] = $override['enabled'];

  foreach ($override as $key => $value) {
    if ('enabled' === $key) {
      continue;
    }

    if (is_array($value) && ! empty($value)) {
      $cta[$key] = $value;
      continue;
    }

    if (is_string($value) && '' !== $value) {
      $cta[$key] = $value;
    }
  }

  return $cta;
}

/**
 * Render global/page CTA above footer.
 */
function starter_coat_render_footer_cta()
{
  $cta = starter_coat_get_footer_cta_data();

  if (empty($cta['enabled'])) {
    return;
  }

  $action_mode = isset($cta['action_mode']) ? (string) $cta['action_mode'] : 'buttons';
  $has_button = (! empty($cta['button_primary']['url']) && ! empty($cta['button_primary']['title'])) || (! empty($cta['button_secondary']['url']) && ! empty($cta['button_secondary']['title']));
  $has_form = 'form' === $action_mode && ! empty($cta['form_shortcode']);

  if (empty($cta['title']) && empty($cta['copy']) && ! $has_button && ! $has_form) {
    return;
  }

  get_template_part('template-parts/components/cta', null, array('cta' => $cta));
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

  $nav_settings = starter_coat_get_nav_settings();

  if (! empty($nav_settings['fixed'])) {
    $classes[] = 'has-fixed-header';
  }

  if (! empty($nav_settings['banner_enabled'])) {
    $classes[] = 'has-top-banner';
  }

  if (! empty($nav_settings['logo_mark_image']['url'])) {
    $classes[] = 'has-logo-mark';
  }

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
  $padding       = sanitize_html_class((string) starter_coat_get_sub_field('section_padding', 'normal'));
  $bg            = sanitize_html_class((string) starter_coat_get_sub_field('section_background', 'none'));
  $content_width = sanitize_html_class((string) starter_coat_get_sub_field('section_content_width', 'inherit'));
  $extra         = trim((string) starter_coat_get_sub_field('section_class', ''));

  // Normalize editor-friendly values and legacy values to shared utility classes.
  if ('small' === $padding) {
    $padding = 'sm';
  } elseif ('normal' === $padding) {
    $padding = 'md';
  } elseif ('large' === $padding) {
    $padding = 'lg';
  }

  $classes = array(
    'section',
    $base,
    'section--' . $padding,
  );

  if ('none' !== $bg) {
    $classes[] = 'bg-' . $bg;
  }

  if (in_array($content_width, array('container', 'wide', 'narrow'), true)) {
    $classes[] = 'section--content-' . $content_width;
  }

  if (! empty($extra)) {
    $classes[] = sanitize_html_class($extra);
  }

  return implode(' ', array_filter($classes));
}

/**
 * Get container class variant from section sub field.
 *
 * @param string $width Optional width override: container, narrow, or full.
 * @return string
 */
function starter_coat_get_section_container_class($width = '')
{
  $width = $width ? sanitize_key((string) $width) : sanitize_key((string) starter_coat_get_sub_field('section_width', 'container'));

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
