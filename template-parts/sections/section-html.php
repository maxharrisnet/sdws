<?php

/**
 * Generic HTML section.
 *
 * @package Starter_Coat
 */

$html_content    = (string) starter_coat_get_sub_field('html_content', '');
$section_classes = starter_coat_get_section_classes('section--html');
$container_class = starter_coat_get_section_container_class();

if ('' === trim($html_content)) {
  return;
}
?>
<section class="<?php echo esc_attr($section_classes); ?>">
  <div class="<?php echo esc_attr($container_class); ?>">
    <div class="richtext c-generic-html">
      <?php echo do_shortcode($html_content); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
    </div>
  </div>
</section>
