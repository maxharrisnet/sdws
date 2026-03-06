<?php

/**
 * Hero component template.
 *
 * @package Aera_Technology
 */

namespace Aera;

defined('ABSPATH') || exit;

// Initialize $args if not provided (for backward compatibility)
$args = $args ?? array();

// Priority order for hero data:
// 1. Arguments passed directly (for archive pages, etc.)
// 2. ACF page/post fields (for regular pages)
// 3. ACF Options page fields (for archive defaults)
// 4. Fallback defaults

$hero_title = $args['hero_title'] ?? null;
$hero_title_line_two = $args['hero_title_line_two'] ?? null;
$hero_subtitle = $args['hero_subtitle'] ?? null;
$hero_text = $args['hero_text'] ?? null;
$hero_button_text = $args['hero_button_text'] ?? null;
$hero_button_link = $args['hero_button_link'] ?? null;
$hero_full_height = $args['hero_full_height'] ?? null;
$hero_variation = $args['hero_variation'] ?? null;

// Fallback to ACF page/post fields if arguments not provided
if ($hero_title === null) {
  $hero_title = function_exists('get_field') ? \get_field('hero_title') : null;
}
if ($hero_title_line_two === null) {
  $hero_title_line_two = function_exists('get_field') ? \get_field('hero_title_line_two') : null;
}
if ($hero_subtitle === null) {
  $hero_subtitle = function_exists('get_field') ? \get_field('hero_subtitle') : null;
}
if ($hero_text === null) {
  $hero_text = function_exists('get_field') ? \get_field('hero_text') : null;
}
if ($hero_button_text === null) {
  $hero_button_text = function_exists('get_field') ? \get_field('hero_button_text') : null;
}
if ($hero_button_link === null) {
  $hero_button_link = function_exists('get_field') ? \get_field('hero_button_link') : null;
}
if ($hero_full_height === null) {
  $hero_full_height = function_exists('get_field') ? \get_field('hero_full_height') : null;
}
if ($hero_variation === null) {
  $hero_variation = function_exists('get_field') ? (\get_field('hero_variation') ?: 'default') : 'default';
}

// Build classes
$hero_classes = array('hero');
if ($hero_full_height) {
  $hero_classes[] = 'hero--full-height';
}
if ($hero_variation && 'default' !== $hero_variation) {
  $hero_classes[] = 'hero--' . esc_attr($hero_variation);
}

// Only render if we have at least a title
if (empty($hero_title)) {
  return;
}
?>

<div class="<?php echo esc_attr(implode(' ', $hero_classes)); ?>">
  <div class="hero__container">
    <?php if ($hero_title) : ?>
      <h1 class="hero__title">
        <?php echo wp_kses_post($hero_title); ?>
        <?php if ($hero_title_line_two) : ?>
          <span>
            <br />
            <?php echo wp_kses_post($hero_title_line_two); ?>
          </span>
        <?php endif; ?>
      </h1>
    <?php endif; ?>

    <?php if ($hero_subtitle) : ?>
      <h2 class="hero__subtitle">
        <?php echo wp_kses_post($hero_subtitle); ?>
      </h2>
    <?php endif; ?>

    <?php if ($hero_text) : ?>
      <?php
      // If ACF returned HTML paragraphs (wpautop), add hero__text to those <p> tags.
      if (strpos($hero_text, '<p') !== false) {
        $content = wp_kses_post($hero_text);
        // Append hero__text to existing class attributes on <p>
        $content = preg_replace('/<p([^>]*)class="([^"]*)"([^>]*)>/', '<p$1class="$2 hero__text"$3>', $content);
        // Add class when no class attribute is present on <p>
        $content = preg_replace('/<p(?![^>]*class=)([^>]*)>/', '<p$1 class="hero__text">', $content);
        echo $content; // Already sanitized above
      } else {
        // Plain text: split on newlines and wrap each in hero__text paragraph
        $paragraphs = array_filter(
          array_map('trim', explode("\n", (string) $hero_text)),
          function ($p) {
            return ! empty($p);
          }
        );
        foreach ($paragraphs as $paragraph) {
          echo '<p class="hero__text">' . wp_kses_post($paragraph) . '</p>';
        }
      }
      ?>
    <?php endif; ?>

    <?php if ($hero_button_text && $hero_button_link) : ?>
      <?php
      // Check if link is an anchor (starts with #)
      // For anchor links, add ID for JavaScript handling (e.g., #open-roles -> findCareer)
      $is_anchor = ! empty($hero_button_link) && strpos($hero_button_link, '#') === 0;
      $button_id = $is_anchor ? 'findCareer' : '';
      ?>
      <p class="hero__button">
        <a href="<?php echo esc_url($hero_button_link); ?>" class="hero__button-link" <?php echo $button_id ? ' id="' . esc_attr($button_id) . '"' : ''; ?>>
          <?php echo esc_html($hero_button_text); ?>
        </a>
      </p>
    <?php endif; ?>
  </div>
</div>