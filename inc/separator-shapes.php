<?php

/**
 * SVG separator shape generators.
 *
 * Each function returns an SVG string with preserveAspectRatio="none"
 * so the shape stretches to full container width.
 *
 * @package Starter_Coat
 */

if (! defined('ABSPATH')) {
  exit;
}

/**
 * Get an SVG separator shape.
 *
 * @param string $shape  Shape slug.
 * @param string $color  CSS color value.
 * @param int    $height Height in pixels.
 * @return string SVG markup.
 */
function starter_coat_get_separator_svg($shape, $color = 'currentColor', $height = 60)
{
  $height = max(20, min(200, (int) $height));

  $shapes = array(
    'concave-arc'    => '<path d="M0,0 Q500,HEIGHT 1000,0 L1000,HEIGHT L0,HEIGHT Z"/>',
    'wave-gentle'    => '<path d="M0,HEIGHT C250,0 750,0 1000,HEIGHT L1000,HEIGHT L0,HEIGHT Z"/>',
    'wave-sharp'     => '<path d="M0,0 C166,HEIGHT 333,HEIGHT 500,0 C666,-HEIGHT_NEG 833,HEIGHT 1000,0 L1000,HEIGHT L0,HEIGHT Z"/>',
    'wave-asymmetric' => '<path d="M0,HEIGHT C200,0 400,0 600,HEIGHT_HALF C800,HEIGHT 900,0 1000,HEIGHT_QUARTER L1000,HEIGHT L0,HEIGHT Z"/>',
    'chevron'        => '<path d="M0,0 L500,HEIGHT L1000,0 L1000,HEIGHT L0,HEIGHT Z"/>',
    'tilt'           => '<path d="M0,HEIGHT L1000,0 L1000,HEIGHT L0,HEIGHT Z"/>',
  );

  if (! isset($shapes[$shape])) {
    return '';
  }

  $path = $shapes[$shape];
  $path = str_replace('HEIGHT_NEG', (string) ($height * 0.3), $path);
  $path = str_replace('HEIGHT_HALF', (string) ($height * 0.5), $path);
  $path = str_replace('HEIGHT_QUARTER', (string) ($height * 0.25), $path);
  $path = str_replace('HEIGHT', (string) $height, $path);

  $svg  = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 ' . $height . '" preserveAspectRatio="none"';
  $svg .= ' style="display:block;width:100%;height:' . $height . 'px;">';
  $svg .= '<g fill="' . esc_attr($color) . '">' . $path . '</g>';
  $svg .= '</svg>';

  return $svg;
}

/**
 * Get the available separator shapes.
 *
 * @return array Shape slug => label.
 */
function starter_coat_get_separator_shapes()
{
  return array(
    'concave-arc'     => __('Concave Arc', 'starter-coat'),
    'wave-gentle'     => __('Wave (Gentle)', 'starter-coat'),
    'wave-sharp'      => __('Wave (Sharp)', 'starter-coat'),
    'wave-asymmetric' => __('Wave (Asymmetric)', 'starter-coat'),
    'chevron'         => __('Chevron', 'starter-coat'),
    'tilt'            => __('Tilt', 'starter-coat'),
  );
}
