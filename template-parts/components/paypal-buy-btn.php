<?php
/**
 * PayPal Buy Now button component.
 *
 * Args:
 *   price         float   — painting price in USD
 *   title         string  — painting title
 *   artist        string  — artist name (optional, appended to item_name)
 *   paypal_client_id  string  — PayPal Client ID from developer.paypal.com (stored in options)
 *   sold              bool    — if true, show SOLD badge instead of button
 *   button_class      string  — extra CSS classes on the button wrapper (optional)
 */

$price            = floatval($args['price'] ?? 0);
$title            = sanitize_text_field($args['title'] ?? '');
$artist           = sanitize_text_field($args['artist'] ?? '');
$paypal_client_id = sanitize_text_field($args['paypal_client_id'] ?? '');
$sold             = ! empty($args['sold']);
$button_class     = sanitize_html_class($args['button_class'] ?? '');

$item_name = $title . ($artist ? ' by ' . $artist : '');

if ($sold) : ?>
  <p class="sdws-painting-sold-badge">SOLD</p>

<?php elseif (! $paypal_client_id) : ?>
  <p class="sdws-painting-no-price">Contact to purchase</p>

<?php elseif (! $price) : ?>
  <p class="sdws-painting-no-price">Contact for pricing</p>

<?php else :
  static $ppcp_instance = 0;
  $ppcp_instance++;
  $button_id = 'sdws-paypal-btn-' . $ppcp_instance;
?>
  <div id="<?php echo esc_attr($button_id); ?>" class="sdws-paypal-btn-wrap<?php echo $button_class ? ' ' . esc_attr($button_class) : ''; ?>"></div>

  <script>
    (function () {
      var containerId = <?php echo wp_json_encode('#' . $button_id); ?>;
      var price       = <?php echo wp_json_encode(number_format($price, 2, '.', '')); ?>;
      var itemName    = <?php echo wp_json_encode($item_name); ?>;

      function renderButton() {
        if (typeof paypal === 'undefined' || ! paypal.Buttons) {
          setTimeout(renderButton, 100);
          return;
        }
        paypal.Buttons({
          style: {
            layout: 'horizontal',
            color:  'blue',
            shape:  'rect',
            label:  'buynow',
            tagline: false,
          },
          createOrder: function (data, actions) {
            return actions.order.create({
              purchase_units: [{
                description: itemName,
                amount: {
                  value: price,
                  currency_code: 'USD',
                },
              }],
            });
          },
          onApprove: function (data, actions) {
            return actions.order.capture().then(function () {
              var wrap = document.querySelector(containerId);
              if (wrap) {
                var msg = document.createElement('p');
                msg.className = 'sdws-paypal-success';
                msg.textContent = "Thank you! Your payment was received. We’ll be in touch shortly.";
                wrap.textContent = '';
                wrap.appendChild(msg);
              }
            });
          },
        }).render(containerId);
      }

      renderButton();
    }());
  </script>
<?php endif;
