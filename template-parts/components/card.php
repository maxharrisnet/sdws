<?php

/**
 * Generic card dispatcher component.
 *
 * @package Starter_Coat
 */

$card = isset($args['card']) && is_array($args['card']) ? $args['card'] : array();
$type = isset($card['type']) ? sanitize_key((string) $card['type']) : 'content';

if ('testimonial' === $type) {
  get_template_part(
    'template-parts/components/testimonial-card',
    null,
    array(
      'testimonial' => $card,
    )
  );
  return;
}

get_template_part(
  'template-parts/components/content-card',
  null,
  array(
    'card' => $card,
  )
);
