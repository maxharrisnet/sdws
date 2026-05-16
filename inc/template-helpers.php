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
 * Get current color scheme slug.
 *
 * @return string
 */
function starter_coat_get_color_scheme()
{
  $scheme = 'preset';

  if (function_exists('get_field')) {
    $acf_scheme = call_user_func('get_field', 'sc_color_scheme', 'option');
    if (! empty($acf_scheme)) {
      $scheme = sanitize_title($acf_scheme);
    }
  }

  return $scheme;
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
    'show_social'     => false,
    'social_style'    => 'icon',
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
  $raw_fixed = call_user_func('get_field', 'sc_nav_fixed', 'option');
  if (null !== $raw_fixed) {
    $settings['fixed'] = (bool) $raw_fixed;
  }
  $raw_show_logo = call_user_func('get_field', 'sc_nav_show_logo', 'option');
  if (null !== $raw_show_logo) {
    $settings['show_logo'] = (bool) $raw_show_logo;
  }
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

  $raw_show_cta = call_user_func('get_field', 'sc_nav_show_cta', 'option');
  if (null !== $raw_show_cta) {
    $settings['show_cta'] = (bool) $raw_show_cta;
  }
  $settings['cta_link'] = call_user_func('get_field', 'sc_nav_cta_link', 'option');
  $settings['cta_style'] = (string) call_user_func('get_field', 'sc_nav_cta_style', 'option') ?: $settings['cta_style'];
  $raw_show_social = call_user_func('get_field', 'sc_nav_show_social', 'option');
  if (null !== $raw_show_social) {
    $settings['show_social'] = (bool) $raw_show_social;
  }
  $settings['social_style'] = (string) call_user_func('get_field', 'sc_nav_social_style', 'option') ?: $settings['social_style'];

  $raw_banner = call_user_func('get_field', 'sc_nav_banner_enabled', 'option');
  if (null !== $raw_banner) {
    $settings['banner_enabled'] = (bool) $raw_banner;
  }
  $settings['banner_text'] = (string) call_user_func('get_field', 'sc_nav_banner_text', 'option');
  $settings['banner_link'] = call_user_func('get_field', 'sc_nav_banner_link', 'option');
  $settings['banner_style'] = (string) call_user_func('get_field', 'sc_nav_banner_style', 'option') ?: $settings['banner_style'];

  return $settings;
}

/**
 * Get footer settings from options with safe defaults.
 *
 * @return array<string,mixed>
 */
function starter_coat_get_footer_settings()
{
  $settings = array(
    'layout'          => 'simple',
    'simple_columns'  => 'two',
    'complex_columns' => 'three',
    'show_logo'       => true,
    'logo_mode'       => 'inherit_nav',
    'logo_image'      => null,
    'show_social'     => true,
    'social_style'    => 'icon',
    'show_main_menu'  => true,
    'show_legal_menu' => true,
    'legal_links'     => array(),
    'copyright_text'  => __('All rights reserved.', 'starter-coat'),
  );

  if (! function_exists('get_field')) {
    return $settings;
  }

  $settings['layout'] = (string) call_user_func('get_field', 'sc_footer_layout', 'option') ?: $settings['layout'];
  $settings['simple_columns'] = (string) call_user_func('get_field', 'sc_footer_simple_columns', 'option') ?: $settings['simple_columns'];
  $settings['complex_columns'] = (string) call_user_func('get_field', 'sc_footer_complex_columns', 'option') ?: $settings['complex_columns'];

  $show_logo = call_user_func('get_field', 'sc_footer_show_logo', 'option');
  if (null !== $show_logo) {
    $settings['show_logo'] = (bool) $show_logo;
  }

  $settings['logo_mode'] = (string) call_user_func('get_field', 'sc_footer_logo_mode', 'option') ?: $settings['logo_mode'];
  $settings['logo_image'] = call_user_func('get_field', 'sc_footer_logo_image', 'option');

  $show_social = call_user_func('get_field', 'sc_footer_show_social', 'option');
  if (null !== $show_social) {
    $settings['show_social'] = (bool) $show_social;
  }

  $settings['social_style'] = (string) call_user_func('get_field', 'sc_footer_social_style', 'option') ?: $settings['social_style'];

  $show_main_menu = call_user_func('get_field', 'sc_footer_show_main_menu', 'option');
  if (null !== $show_main_menu) {
    $settings['show_main_menu'] = (bool) $show_main_menu;
  }

  $show_legal_menu = call_user_func('get_field', 'sc_footer_show_legal_menu', 'option');
  if (null !== $show_legal_menu) {
    $settings['show_legal_menu'] = (bool) $show_legal_menu;
  }

  $legal_links = call_user_func('get_field', 'sc_footer_legal_links', 'option');
  if (is_array($legal_links)) {
    $settings['legal_links'] = $legal_links;
  }

  $copyright_text = (string) call_user_func('get_field', 'sc_footer_copyright_text', 'option');
  if ('' !== $copyright_text) {
    $settings['copyright_text'] = $copyright_text;
  }

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
  $classes[] = 'scheme--' . starter_coat_get_color_scheme();

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

    $sep_top    = starter_coat_get_sub_field('separator_top_enabled', false);
    $sep_bottom = starter_coat_get_sub_field('separator_bottom_enabled', false);

    if ($sep_top || $sep_bottom) {
      ob_start();
      get_template_part('template-parts/sections/section', $layout);
      $html = ob_get_clean();

      // Inject top separator after opening <section ...>
      if ($sep_top) {
        ob_start();
        starter_coat_render_separator_top();
        $sep_top_html = ob_get_clean();
        $html = preg_replace('/(<section[^>]*>)/', '$1' . $sep_top_html, $html, 1);
      }

      // Inject bottom separator before closing </section>
      if ($sep_bottom) {
        ob_start();
        starter_coat_render_separator_bottom();
        $sep_bottom_html = ob_get_clean();
        $pos = strrpos($html, '</section>');
        if (false !== $pos) {
          $html = substr_replace($html, $sep_bottom_html . '</section>', $pos, strlen('</section>'));
        }
      }

      echo $html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    } else {
      get_template_part('template-parts/sections/section', $layout);
    }

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

  $sep_top    = starter_coat_get_sub_field('separator_top_enabled', false);
  $sep_bottom = starter_coat_get_sub_field('separator_bottom_enabled', false);
  if ($sep_top || $sep_bottom) {
    $classes[] = 'has-separator';
  }
  if ($sep_top) {
    $classes[] = 'has-separator--top';
  }
  if ($sep_bottom) {
    $classes[] = 'has-separator--bottom';
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
 * Get the CSS color value for a separator color slug.
 *
 * @param string $slug Color slug.
 * @return string CSS color value.
 */
function starter_coat_get_separator_color($slug)
{
  $map = array(
    'white' => 'var(--color-white, #ffffff)',
    'light' => 'var(--color-surface-50, #f8fafc)',
    'dark'  => 'var(--color-ink-900, #0f172a)',
    'brand' => 'var(--color-brand, #335cfa)',
    'muted' => 'var(--color-surface-100, #f1f5f9)',
  );

  return isset($map[$slug]) ? $map[$slug] : $map['white'];
}

/**
 * Render the top section separator if enabled.
 */
function starter_coat_render_separator_top()
{
  if (! starter_coat_get_sub_field('separator_top_enabled', false)) {
    return;
  }

  $shape  = starter_coat_get_sub_field('separator_top_shape', 'wave-gentle');
  $height = (int) starter_coat_get_sub_field('separator_top_height', 60);
  $color  = starter_coat_get_separator_color(starter_coat_get_sub_field('separator_top_color', 'white'));
  $flip   = starter_coat_get_sub_field('separator_top_flip', false);

  $svg = starter_coat_get_separator_svg($shape, $color, $height);
  if (empty($svg)) {
    return;
  }

  $classes = 'section-separator section-separator--top';
  if ($flip) {
    $classes .= ' section-separator--flip';
  }

  echo '<div class="' . esc_attr($classes) . '" style="--separator-height:' . esc_attr($height) . 'px" aria-hidden="true">';
  echo $svg; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- trusted SVG
  echo '</div>';
}

/**
 * Render the bottom section separator if enabled.
 */
function starter_coat_render_separator_bottom()
{
  if (! starter_coat_get_sub_field('separator_bottom_enabled', false)) {
    return;
  }

  $shape  = starter_coat_get_sub_field('separator_bottom_shape', 'wave-gentle');
  $height = (int) starter_coat_get_sub_field('separator_bottom_height', 60);
  $color  = starter_coat_get_separator_color(starter_coat_get_sub_field('separator_bottom_color', 'white'));
  $flip   = starter_coat_get_sub_field('separator_bottom_flip', false);

  $svg = starter_coat_get_separator_svg($shape, $color, $height);
  if (empty($svg)) {
    return;
  }

  $classes = 'section-separator section-separator--bottom';
  if ($flip) {
    $classes .= ' section-separator--flip';
  }

  echo '<div class="' . esc_attr($classes) . '" style="--separator-height:' . esc_attr($height) . 'px" aria-hidden="true">';
  echo $svg; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- trusted SVG
  echo '</div>';
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
