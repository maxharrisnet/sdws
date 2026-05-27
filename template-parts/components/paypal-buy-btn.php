<?php
/**
 * PayPal Buy Now button component.
 *
 * Args:
 *   price         float   — painting price in USD
 *   title         string  — painting title
 *   artist        string  — artist name (optional, appended to item_name)
 *   paypal_email  string  — merchant PayPal email
 *   button_class  string  — extra CSS classes on the button (optional)
 */

$price        = floatval($args['price'] ?? 0);
$title        = sanitize_text_field($args['title'] ?? '');
$artist       = sanitize_text_field($args['artist'] ?? '');
$paypal_email = sanitize_email($args['paypal_email'] ?? '');
$button_class = sanitize_html_class($args['button_class'] ?? '');

$item_name = $title . ($artist ? ' by ' . $artist : '');

if (! $paypal_email) : ?>
  <p class="sdws-painting-no-price">Contact to purchase</p>
<?php elseif (! $price) : ?>
  <p class="sdws-painting-no-price">Contact for pricing</p>
<?php else : ?>
  <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank" class="sdws-paypal-form">
    <input type="hidden" name="cmd"           value="_xclick">
    <input type="hidden" name="business"      value="<?php echo esc_attr($paypal_email); ?>">
    <input type="hidden" name="item_name"     value="<?php echo esc_attr($item_name); ?>">
    <input type="hidden" name="amount"        value="<?php echo esc_attr(number_format($price, 2, '.', '')); ?>">
    <input type="hidden" name="currency_code" value="USD">
    <input type="hidden" name="no_shipping"   value="1">
    <button type="submit" class="sdws-btn sdws-btn--teal<?php echo $button_class ? ' ' . esc_attr($button_class) : ''; ?>">
      Buy Now — $<?php echo esc_html(number_format($price, 0, '.', ',')); ?>
    </button>
  </form>
<?php endif;
