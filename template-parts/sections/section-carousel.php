<?php

/**
 * Flexible carousel section.
 *
 * @package Starter_Coat
 */

$heading         = starter_coat_get_sub_field('heading', '');
$subtext         = starter_coat_get_sub_field('subtext', '');
$slides_per_view = max(1, min(3, (int) starter_coat_get_sub_field('slides_per_view', '1')));
$show_controls   = (bool) starter_coat_get_sub_field('show_controls', true);
$section_classes = starter_coat_get_section_classes('section--carousel');
$container_class = starter_coat_get_section_container_class();

$items = array();
if (function_exists('have_rows') && call_user_func('have_rows', 'items')) {
  while (call_user_func('have_rows', 'items')) {
    call_user_func('the_row');

    $card_type = sanitize_key((string) starter_coat_get_sub_field('card_type', 'testimonial'));

    if ('content' === $card_type) {
      $items[] = array(
        'type'    => 'content',
        'eyebrow' => (string) starter_coat_get_sub_field('eyebrow', ''),
        'title'   => (string) starter_coat_get_sub_field('title', ''),
        'copy'    => (string) starter_coat_get_sub_field('copy', ''),
        'image'   => starter_coat_get_sub_field('image', null),
        'button'  => starter_coat_get_sub_field('button', null),
      );
      continue;
    }

    $items[] = array(
      'type'          => 'testimonial',
      'style'         => sanitize_html_class((string) starter_coat_get_sub_field('testimonial_style', 'feature')),
      'quote'         => (string) starter_coat_get_sub_field('quote', ''),
      'name'          => (string) starter_coat_get_sub_field('name', ''),
      'info_line_one' => (string) starter_coat_get_sub_field('info_line_one', ''),
      'info_line_two' => (string) starter_coat_get_sub_field('info_line_two', ''),
      'photo'         => starter_coat_get_sub_field('photo', null),
    );
  }
}

if (empty($items)) {
  return;
}
?>
<section class="<?php echo esc_attr($section_classes); ?>">
  <div class="<?php echo esc_attr($container_class); ?>">
    <?php
    get_template_part(
      'template-parts/components/carousel',
      null,
      array(
        'carousel' => array(
          'id'              => 'carousel-' . wp_unique_id(),
          'heading'         => $heading,
          'subtext'         => $subtext,
          'slides_per_view' => $slides_per_view,
          'show_controls'   => $show_controls,
          'items'           => $items,
        ),
      )
    );
    ?>
  </div>
</section>