<?php

/**
 * Map embed section.
 *
 * @package Starter_Coat
 */

$section_classes = starter_coat_get_section_classes('section--map-embed');
$container_class = starter_coat_get_section_container_class();

$args = array(
  'layout_mode'        => (string) starter_coat_get_sub_field('layout_mode', 'two-col'),
  'address'            => (string) starter_coat_get_sub_field('address', ''),
  'custom_embed_html'  => (string) starter_coat_get_sub_field('custom_embed_html', ''),
  'map_height'         => (int) starter_coat_get_sub_field('map_height', 420),
  'map_width'          => (string) starter_coat_get_sub_field('map_width', 'normal'),
  'ratio'              => (string) starter_coat_get_sub_field('ratio', '50-50'),
  'map_position'       => (string) starter_coat_get_sub_field('map_position', 'right'),
  'content_type'       => (string) starter_coat_get_sub_field('content_type', 'text'),
  'kicker'             => (string) starter_coat_get_sub_field('kicker', ''),
  'heading'            => (string) starter_coat_get_sub_field('heading', ''),
  'text_content'       => (string) starter_coat_get_sub_field('text_content', ''),
  'custom_html_content' => (string) starter_coat_get_sub_field('custom_html_content', ''),
);

if ('' === trim($args['address']) && '' === trim($args['custom_embed_html'])) {
  return;
}
?>
<section class="<?php echo esc_attr($section_classes); ?>">
  <div class="<?php echo esc_attr($container_class); ?>">
    <?php get_template_part('template-parts/components/map-embed', null, $args); ?>
  </div>
</section>