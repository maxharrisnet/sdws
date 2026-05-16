<?php

/**
 * Asset loading.
 *
 * @package Starter_Coat
 */

if (! defined('ABSPATH')) {
  exit;
}

/**
 * Build a version token from filemtime.
 *
 * @param string $path Absolute file path.
 * @return string
 */
function starter_coat_asset_version($path)
{
  if (file_exists($path)) {
    return (string) filemtime($path);
  }

  return STARTER_COAT_VERSION;
}

/**
 * Enqueue frontend scripts and styles.
 */
function starter_coat_enqueue_assets()
{
  $compiled_css_path = STARTER_COAT_PATH . '/assets/css/theme.css';
  $compiled_css_uri  = STARTER_COAT_URI . '/assets/css/theme.css';

  if (file_exists($compiled_css_path)) {
    wp_enqueue_style('starter-coat-theme', $compiled_css_uri, array(), starter_coat_asset_version($compiled_css_path));
  } else {
    wp_enqueue_style('starter-coat-style', get_stylesheet_uri(), array(), STARTER_COAT_VERSION);
    wp_style_add_data('starter-coat-style', 'rtl', 'replace');
  }

  $compiled_js_path = STARTER_COAT_PATH . '/assets/js/dist/theme.js';
  $compiled_js_uri  = STARTER_COAT_URI . '/assets/js/dist/theme.js';

  if (file_exists($compiled_js_path)) {
    wp_enqueue_script('starter-coat-theme', $compiled_js_uri, array(), starter_coat_asset_version($compiled_js_path), true);
  } else {
    wp_enqueue_script('starter-coat-navigation', STARTER_COAT_URI . '/js/navigation.js', array(), STARTER_COAT_VERSION, true);
  }

  wp_localize_script(
    file_exists($compiled_js_path) ? 'starter-coat-theme' : 'starter-coat-navigation',
    'starterCoat',
    array(
      'ajaxUrl' => admin_url('admin-ajax.php'),
      'nonce'   => wp_create_nonce('starter-coat'),
    )
  );

  // SDWS overrides — loaded after theme.css so they cascade correctly
  $sdws_css_path = STARTER_COAT_PATH . '/assets/css/sdws.css';
  $sdws_css_uri  = STARTER_COAT_URI . '/assets/css/sdws.css';
  wp_enqueue_style('sdws', $sdws_css_uri, array('starter-coat-theme'), starter_coat_asset_version($sdws_css_path));

  if (is_singular() && comments_open() && get_option('thread_comments')) {
    wp_enqueue_script('comment-reply');
  }
}
add_action('wp_enqueue_scripts', 'starter_coat_enqueue_assets');

/**
 * Get the Google Fonts URL for the active theme preset.
 *
 * @return string
 */
function starter_coat_google_fonts_url()
{
  $families = array(
    'DM+Serif+Display:ital,wght@0,400;1,400',
    'DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;1,9..40,400',
  );

  return 'https://fonts.googleapis.com/css2?' . implode('&', array_map(function ($f) {
    return 'family=' . $f;
  }, $families)) . '&display=swap';
}

/**
 * Enqueue Google Fonts stylesheet.
 */
function starter_coat_enqueue_google_fonts()
{
  wp_enqueue_style('starter-coat-google-fonts', starter_coat_google_fonts_url(), array(), null);
}
add_action('wp_enqueue_scripts', 'starter_coat_enqueue_google_fonts');

/**
 * Add preconnect hints for Google Fonts.
 */
function starter_coat_google_fonts_preconnect()
{
  echo '<link rel="preconnect" href="https://fonts.googleapis.com">' . "\n";
  echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";
}
add_action('wp_head', 'starter_coat_google_fonts_preconnect', 1);
