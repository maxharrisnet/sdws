<?php

/**
 * Sticky banner component.
 *
 * @package Starter_Coat
 */

if (empty($args['message'])) {
  return;
}
?>
<div class="c-sticky-banner" role="status">
  <div class="container">
    <p><?php echo esc_html($args['message']); ?></p>
  </div>
</div>