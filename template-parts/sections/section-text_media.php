<?php

/**
 * Single column text/media section.
 *
 * @package Starter_Coat
 */

$content = function_exists('get_sub_field') ? get_sub_field('content') : '';
?>
<section class="section section--text-media section--lg">
  <div class="container container--narrow richtext">
    <?php echo wp_kses_post($content); ?>
  </div>
</section>