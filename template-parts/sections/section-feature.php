<?php

/**
 * Two column feature section.
 *
 * @package Starter_Coat
 */

$ratio = function_exists('get_sub_field') ? get_sub_field('ratio') : '50-50';
?>
<section class="section section--feature section--lg">
  <div class="container">
    <div class="layout layout--2col <?php echo '66-33' === $ratio ? 'layout--2col-wide' : 'layout--2col-even'; ?>">
      <div class="feature__media image image--rounded"></div>
      <div class="feature__content">
        <h2><?php esc_html_e('Feature title', 'starter-coat'); ?></h2>
        <p><?php esc_html_e('Flexible content for text and media pairings.', 'starter-coat'); ?></p>
      </div>
    </div>
  </div>
</section>