<?php

/**
 * Two-column forms section.
 *
 * @package Starter_Coat
 */

$heading              = (string) starter_coat_get_sub_field('heading', '');
$subtext              = (string) starter_coat_get_sub_field('subtext', '');
$left_intro           = (string) starter_coat_get_sub_field('left_intro', '');
$left_form_shortcode  = (string) starter_coat_get_sub_field('left_form_shortcode', '');
$right_intro          = (string) starter_coat_get_sub_field('right_intro', '');
$right_form_shortcode = (string) starter_coat_get_sub_field('right_form_shortcode', '');
$section_classes      = starter_coat_get_section_classes('section--forms-two-col');
$container_class      = starter_coat_get_section_container_class();

if ('' === trim($left_form_shortcode) && '' === trim($right_form_shortcode)) {
  return;
}
?>
<section class="<?php echo esc_attr($section_classes); ?>">
  <div class="<?php echo esc_attr($container_class); ?>">
    <div class="c-forms-two-col">
      <?php if ($heading) : ?>
        <h2 class="c-forms-two-col__heading"><?php echo esc_html($heading); ?></h2>
      <?php endif; ?>

      <?php if ($subtext) : ?>
        <p class="c-forms-two-col__subtext"><?php echo esc_html($subtext); ?></p>
      <?php endif; ?>

      <div class="layout layout--2col layout--2col-even c-forms-two-col__grid">
        <div class="c-forms-two-col__col">
          <?php if ('' !== trim($left_intro)) : ?>
            <div class="richtext c-forms-two-col__intro"><?php echo wp_kses_post($left_intro); ?></div>
          <?php endif; ?>
          <?php get_template_part('template-parts/components/form', null, array('shortcode' => $left_form_shortcode)); ?>
        </div>

        <div class="c-forms-two-col__col">
          <?php if ('' !== trim($right_intro)) : ?>
            <div class="richtext c-forms-two-col__intro"><?php echo wp_kses_post($right_intro); ?></div>
          <?php endif; ?>
          <?php get_template_part('template-parts/components/form', null, array('shortcode' => $right_form_shortcode)); ?>
        </div>
      </div>
    </div>
  </div>
</section>