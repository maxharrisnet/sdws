<?php

/**
 * Hero section.
 *
 * @package Starter_Coat
 */

$title = function_exists('get_sub_field') ? get_sub_field('title') : '';
$copy  = function_exists('get_sub_field') ? get_sub_field('copy') : '';
?>
<section class="section section--hero section--xl bg-brand text-light">
  <div class="container">
    <?php if ($title) : ?>
      <h1><?php echo esc_html($title); ?></h1>
    <?php endif; ?>
    <?php if ($copy) : ?>
      <div class="section__copy"><?php echo wp_kses_post(wpautop($copy)); ?></div>
    <?php endif; ?>
  </div>
</section>