<?php

/**
 * Front page showcase template.
 *
 * @package Starter_Coat
 */

get_header();
?>

<main id="primary" class="site-main">
  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
      <?php starter_coat_render_singular_hero(get_the_ID()); ?>
      <?php if (function_exists('have_rows') && call_user_func('have_rows', 'sc_sections')) : ?>
        <?php starter_coat_render_sections(); ?>
      <?php else : ?>
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
        
      <?php endif; ?>
  <?php endwhile;
  endif; ?>
</main>

<?php
get_footer();
