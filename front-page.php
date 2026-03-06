<?php

/**
 * Front page showcase template.
 *
 * @package Starter_Coat
 */

get_header();
?>

<main id="primary" class="site-main">
  <section class="section section--hero section--xl bg-brand text-light">
    <div class="container">
      <p class="eyebrow"><?php esc_html_e('Starter Theme Showcase', 'starter-coat'); ?></p>
      <h1><?php esc_html_e('ACF-first WordPress base with reusable components', 'starter-coat'); ?></h1>
      <p><?php esc_html_e('Use this page to validate tokens, spacing scales, and section/component variants.', 'starter-coat'); ?></p>
      <?php
      get_template_part(
        'template-parts/components/cta',
        null,
        array(
          'title'  => __('Primary CTA', 'starter-coat'),
          'copy'   => __('Buttons support size and variant modifiers.', 'starter-coat'),
          'button' => array(
            'title' => __('Get Started', 'starter-coat'),
            'url'   => '#',
          ),
        )
      );
      ?>
    </div>
  </section>

  <?php get_template_part('template-parts/sections/section-feature'); ?>
  <?php get_template_part('template-parts/sections/section-cards'); ?>
  <?php get_template_part('template-parts/sections/section-text_media'); ?>
</main>

<?php
get_footer();
