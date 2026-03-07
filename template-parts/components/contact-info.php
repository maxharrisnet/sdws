<?php

/**
 * Contact information component (uses global options).
 *
 * @package Starter_Coat
 */

$contact = starter_coat_get_contact_info();
$fields  = isset($args['fields']) && is_array($args['fields']) ? $args['fields'] : array('phone', 'email', 'address', 'hours');
$layout  = isset($args['layout']) ? sanitize_html_class($args['layout']) : 'stacked'; // 'stacked' or 'inline'

// Filter to only show requested fields that have values.
$display_fields = array();
foreach ($fields as $field) {
  if (isset($contact[$field]) && ! empty($contact[$field])) {
    $display_fields[$field] = $contact[$field];
  }
}

if (empty($display_fields)) {
  return;
}

$field_labels = array(
  'phone'   => __('Phone', 'starter-coat'),
  'email'   => __('Email', 'starter-coat'),
  'address' => __('Address', 'starter-coat'),
  'hours'   => __('Hours', 'starter-coat'),
);
?>
<div class="c-contact-info c-contact-info--<?php echo esc_attr($layout); ?>">
  <?php foreach ($display_fields as $field => $value) : ?>
    <div class="c-contact-info__item c-contact-info__item--<?php echo esc_attr($field); ?>">
      <?php if (isset($args['show_labels']) && $args['show_labels']) : ?>
        <span class="c-contact-info__label"><?php echo esc_html($field_labels[$field] ?? ucfirst($field)); ?>:</span>
      <?php endif; ?>
      <div class="c-contact-info__value">
        <?php if ('phone' === $field) : ?>
          <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $value)); ?>">
            <?php echo esc_html($value); ?>
          </a>
        <?php elseif ('email' === $field) : ?>
          <a href="mailto:<?php echo esc_attr($value); ?>">
            <?php echo esc_html($value); ?>
          </a>
        <?php elseif ('address' === $field) : ?>
          <address><?php echo wp_kses_post(nl2br($value)); ?></address>
        <?php else : ?>
          <?php echo wp_kses_post(nl2br($value)); ?>
        <?php endif; ?>
      </div>
    </div>
  <?php endforeach; ?>
</div>