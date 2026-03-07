<?php

/**
 * Testimonials section.
 *
 * @package Starter_Coat
 */

$heading         = starter_coat_get_sub_field('heading', '');
$subtext         = starter_coat_get_sub_field('subtext', '');
$style           = sanitize_html_class((string) starter_coat_get_sub_field('style', 'simple'));
$display_mode    = sanitize_html_class((string) starter_coat_get_sub_field('display_mode', 'grid'));
$columns         = max(1, min(3, (int) starter_coat_get_sub_field('columns', '3')));
$slides_per_view = max(1, min(3, (int) starter_coat_get_sub_field('slides_per_view', '1')));
$show_controls   = (bool) starter_coat_get_sub_field('show_controls', true);
$section_classes = starter_coat_get_section_classes('section--testimonials');
$container_class = starter_coat_get_section_container_class();

$cards = array();
if (function_exists('have_rows') && call_user_func('have_rows', 'items')) {
  while (call_user_func('have_rows', 'items')) {
    call_user_func('the_row');

    $cards[] = array(
      'type'          => 'testimonial',
      'style'         => $style,
      'quote'         => (string) starter_coat_get_sub_field('quote', ''),
      'name'          => (string) starter_coat_get_sub_field('name', ''),
      'info_line_one' => (string) starter_coat_get_sub_field('info_line_one', ''),
      'info_line_two' => (string) starter_coat_get_sub_field('info_line_two', ''),
      'photo'         => starter_coat_get_sub_field('photo', null),
    );
  }
}

if (empty($cards)) {
  return;
}
?>
<section class="<?php echo esc_attr($section_classes); ?>">
  <div class="<?php echo esc_attr($container_class); ?>">
    <?php if ('carousel' === $display_mode) : ?>
      <?php
      get_template_part(
        'template-parts/components/carousel',
        null,
        array(
          'carousel' => array(
            'id'              => 'testimonials-' . wp_unique_id(),
            'heading'         => $heading,
            'subtext'         => $subtext,
            'variant'         => 'testimonials',
            'slides_per_view' => $slides_per_view,
            'show_controls'   => $show_controls,
            'items'           => $cards,
          ),
        )
      );
      ?>
    <?php else : ?>
      <div class="c-testimonials-grid c-testimonials-grid--cols-<?php echo esc_attr((string) $columns); ?>">
        <?php if ($heading) : ?>
          <h2 class="c-testimonials-grid__heading"><?php echo esc_html($heading); ?></h2>
        <?php endif; ?>

        <?php if ($subtext) : ?>
          <p class="c-testimonials-grid__subtext"><?php echo esc_html($subtext); ?></p>
        <?php endif; ?>

        <div class="c-testimonials-grid__items">
          <?php foreach ($cards as $card) : ?>
            <?php get_template_part('template-parts/components/card', null, array('card' => $card)); ?>
          <?php endforeach; ?>
        </div>
      </div>
    <?php endif; ?>
  </div>
</section>