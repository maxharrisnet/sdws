<?php

/**
 * Starter Coat functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Starter_Coat
 */

if (! defined('STARTER_COAT_VERSION')) {
  define('STARTER_COAT_VERSION', wp_get_theme()->get('Version') ?: '1.0.0');
}

if (! defined('STARTER_COAT_PATH')) {
  define('STARTER_COAT_PATH', get_template_directory());
}

if (! defined('STARTER_COAT_URI')) {
  define('STARTER_COAT_URI', get_template_directory_uri());
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function starter_coat_setup()
{
  /*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on Starter Coat, use a find and replace
		* to change 'starter-coat' to the name of your theme in all the template files.
		*/
  load_theme_textdomain('starter-coat', get_template_directory() . '/languages');

  // Add default posts and comments RSS feed links to head.
  add_theme_support('automatic-feed-links');

  /*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
  add_theme_support('title-tag');

  /*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
  add_theme_support('post-thumbnails');

  register_nav_menus(
    array(
      'menu-1'      => esc_html__('Primary', 'starter-coat'),
      'footer-col-1' => esc_html__('Footer', 'starter-coat'),
    )
  );

  /*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
  add_theme_support(
    'html5',
    array(
      'search-form',
      'comment-form',
      'comment-list',
      'gallery',
      'caption',
      'style',
      'script',
    )
  );

  // Add theme support for selective refresh for widgets.
  add_theme_support('customize-selective-refresh-widgets');

  /**
   * Add support for core custom logo.
   *
   * @link https://codex.wordpress.org/Theme_Logo
   */
  add_theme_support(
    'custom-logo',
    array(
      'height'      => 250,
      'width'       => 250,
      'flex-width'  => true,
      'flex-height' => true,
    )
  );
}
add_action('after_setup_theme', 'starter_coat_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function starter_coat_content_width()
{
  $GLOBALS['content_width'] = apply_filters('starter_coat_content_width', 640);
}
add_action('after_setup_theme', 'starter_coat_content_width', 0);


/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if (defined('JETPACK__VERSION')) {
  require get_template_directory() . '/inc/jetpack.php';
}

require STARTER_COAT_PATH . '/inc/assets.php';
require STARTER_COAT_PATH . '/inc/editor.php';
require STARTER_COAT_PATH . '/inc/nav-walkers.php';
require STARTER_COAT_PATH . '/inc/ajax.php';
require STARTER_COAT_PATH . '/inc/separator-shapes.php';
require STARTER_COAT_PATH . '/inc/template-helpers.php';
require STARTER_COAT_PATH . '/inc/media.php';

/**
 * Security hardening — post-hack measures.
 */
add_filter('xmlrpc_enabled', '__return_false');
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'rsd_link');

/**
 * Admin notice when Starter Coat Core plugin is not active.
 */
function starter_coat_core_plugin_notice()
{
  if (is_plugin_active('starter-coat-core/starter-coat-core.php')) {
    return;
  }

  echo '<div class="notice notice-warning"><p>';
  echo esc_html__('Starter Coat theme requires the Starter Coat Core plugin for custom post types, taxonomies, and ACF fields.', 'starter-coat');
  echo '</p></div>';
}
add_action('admin_notices', 'starter_coat_core_plugin_notice');

/**
 * Force single-tribe_events.php for TEC event singles, bypassing TEC's own
 * template_include hook (priority 50). Runs at priority 100.
 */
add_filter('template_include', function ($template) {
  if (is_singular('tribe_events')) {
    $theme_tpl = locate_template('single-tribe_events.php');
    if ($theme_tpl) {
      return $theme_tpl;
    }
  }
  return $template;
}, 100);
