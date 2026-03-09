<?php

/**
 * Starter Coat section seeding debug script.
 *
 * Run with WP-CLI:
 * wp eval-file wp-content/themes/starter-coat/assets/imports/demo/starter-coat-demo-debug-sections.php
 */

if (! defined('ABSPATH')) {
  echo "Run this via WP-CLI eval-file from a WordPress install.\n";
  return;
}

function sc_debug_line($label, $value)
{
  if (is_bool($value)) {
    $value = $value ? 'true' : 'false';
  } elseif (is_null($value)) {
    $value = 'null';
  } elseif (is_array($value)) {
    $value = wp_json_encode($value);
  }

  echo str_pad($label . ':', 34, ' ') . $value . "\n";
}

function sc_debug_section_state($post_id)
{
  $raw_count_meta = get_post_meta($post_id, 'sc_sections', true);
  $raw_rows = function_exists('get_field') ? get_field('sc_sections', $post_id, false) : null;
  $formatted_rows = function_exists('get_field') ? get_field('sc_sections', $post_id, true) : null;

  sc_debug_line('post_id', (int) $post_id);
  sc_debug_line('post_title', get_the_title($post_id));
  sc_debug_line('template', get_post_meta($post_id, '_wp_page_template', true));
  sc_debug_line('meta sc_sections', $raw_count_meta);
  sc_debug_line('meta _sc_sections', get_post_meta($post_id, '_sc_sections', true));

  $raw_count = is_array($raw_rows) ? count($raw_rows) : 0;
  $formatted_count = is_array($formatted_rows) ? count($formatted_rows) : 0;
  sc_debug_line('get_field raw row count', $raw_count);
  sc_debug_line('get_field formatted row count', $formatted_count);

  if (is_array($raw_rows) && ! empty($raw_rows[0]['acf_fc_layout'])) {
    sc_debug_line('first raw layout', $raw_rows[0]['acf_fc_layout']);
  }

  if (is_array($formatted_rows) && ! empty($formatted_rows[0]['acf_fc_layout'])) {
    sc_debug_line('first formatted layout', $formatted_rows[0]['acf_fc_layout']);
  }
}

$target_slugs = array('home-hype-demo', 'home-bav-demo');
$target_ids = array();

foreach ($target_slugs as $slug) {
  $page = get_page_by_path($slug, OBJECT, 'page');
  if ($page instanceof WP_Post) {
    $target_ids[] = (int) $page->ID;
  }
}

if (empty($target_ids)) {
  echo "No target pages found (home-hype-demo / home-bav-demo).\n";
  return;
}

echo "=== Environment ===\n";
sc_debug_line('ACF update_field', function_exists('update_field'));
sc_debug_line('ACF get_field', function_exists('get_field'));
sc_debug_line('ACF acf_get_field', function_exists('acf_get_field'));

$field = function_exists('acf_get_field') ? acf_get_field('field_sc_sections') : null;
sc_debug_line('field_sc_sections found', is_array($field));
if (is_array($field)) {
  $layout_names = array();
  if (! empty($field['layouts']) && is_array($field['layouts'])) {
    foreach ($field['layouts'] as $layout) {
      if (! empty($layout['name'])) {
        $layout_names[] = (string) $layout['name'];
      }
    }
  }
  sc_debug_line('field name', isset($field['name']) ? $field['name'] : '');
  sc_debug_line('layout count', count($layout_names));
  sc_debug_line('layouts', implode(', ', $layout_names));
}

echo "\n=== Before Write ===\n";
foreach ($target_ids as $target_id) {
  sc_debug_section_state($target_id);
  echo "---\n";
}

$write_mode = getenv('SC_DEBUG_WRITE') === '1';
sc_debug_line('write mode enabled', $write_mode);

if (! $write_mode) {
  echo "\nRead-only mode: no section data was modified.\n";
  echo "Set SC_DEBUG_WRITE=1 to run the write test block.\n";
  echo "Done.\n";
  return;
}

if (! function_exists('update_field')) {
  echo "Cannot write test rows because ACF update_field() is unavailable in this runtime.\n";
  return;
}

$test_rows = array(
  array(
    'acf_fc_layout'      => 'content_media',
    'layout_mode'        => 'split',
    'kicker'             => 'DEBUG',
    'title'              => 'Section Debug Write Test',
    'content'            => '<p>This row was written by the debug script to verify ACF flexible-content persistence.</p>',
    'ratio'              => '50-50',
    'media_position'     => 'right',
    'image_style'        => 'rounded',
    'image_full_bleed'   => 0,
    'section_width'      => 'container',
    'section_padding'    => 'md',
    'section_background' => 'none',
  ),
  array(
    'acf_fc_layout'      => 'stats',
    'heading'            => 'Debug Stats',
    'intro'              => 'If this appears, sections are persisting correctly.',
    'columns'            => 3,
    'items'              => array(
      array('value' => 1, 'label' => 'Row', 'prefix' => '', 'suffix' => ''),
      array('value' => 2, 'label' => 'Rows', 'prefix' => '', 'suffix' => ''),
      array('value' => 3, 'label' => 'Rows', 'prefix' => '', 'suffix' => ''),
    ),
    'section_padding'    => 'md',
    'section_background' => 'light',
  ),
);

echo "\n=== Write Attempt ===\n";
foreach ($target_ids as $target_id) {
  $result = update_field('field_sc_sections', $test_rows, $target_id);
  sc_debug_line('update_field result for #' . (int) $target_id, $result);
}

echo "\n=== After Write ===\n";
foreach ($target_ids as $target_id) {
  sc_debug_section_state($target_id);
  echo "---\n";
}

echo "Done.\n";
