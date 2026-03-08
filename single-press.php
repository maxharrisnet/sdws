<?php

/**
 * Press single template.
 *
 * Redirects to external URL when configured.
 *
 * @package Starter_Coat
 */

if (! defined('ABSPATH')) {
  exit;
}

$external_url = function_exists('get_field') ? (string) call_user_func('get_field', 'sc_press_external_url', get_the_ID()) : '';

if ('' !== $external_url) {
  wp_safe_redirect(esc_url_raw($external_url), 302);
  exit;
}

wp_safe_redirect(get_post_type_archive_link('press') ?: home_url('/'), 302);
exit;
