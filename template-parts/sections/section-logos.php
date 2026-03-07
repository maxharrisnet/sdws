<?php

/**
 * Logo grid flexible section.
 *
 * @package Starter_Coat
 */

$heading         = starter_coat_get_sub_field('heading', '');
$subtext         = starter_coat_get_sub_field('subtext', '');
$columns         = (int) starter_coat_get_sub_field('columns', '4');
$section_classes = starter_coat_get_section_classes('section--logos');
$container_class = starter_coat_get_section_container_class();
$logos           = array();

if (function_exists('have_rows') && call_user_func('have_rows', 'logos')) {
  while (call_user_func('have_rows', 'logos')) {
    call_user_func('the_row');

    $logos[] = array(
      'image' => starter_coat_get_sub_field('image', null),
      'link'  => starter_coat_get_sub_field('link', null),
    );
  }
}
?>
<section class="<?php echo esc_attr($section_classes); ?>">
  <div class="<?php echo esc_attr($container_class); ?>">
    <?php
    get_template_part(
      'template-parts/components/logos-grid',
      null,
      array(
        'heading' => $heading,
        'subtext' => $subtext,
        'columns' => $columns,
        'logos'   => $logos,
      )
    );
    ?>
  </div>
</section>