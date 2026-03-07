<?php

/**
 * Template Name: Contact
 *
 * @package Starter_Coat
 */

get_header();
?>

<main id="primary" class="site-main">
  <?php while (have_posts()) : the_post(); ?>
    <?php starter_coat_render_singular_hero(get_the_ID()); ?>
    <section class="section section--lg">
      <div class="container container--narrow">
        <?php if (! starter_coat_has_singular_hero(get_the_ID())) : ?>
          <h1><?php the_title(); ?></h1>
        <?php endif; ?>

        <?php
        $intro = function_exists('get_field') ? call_user_func('get_field', 'sc_contact_intro') : '';
        if (! empty($intro)) {
          echo wp_kses_post($intro);
        } else {
          the_content();
        }
        ?>

        <?php
        get_template_part(
          'template-parts/components/contact-map',
          null,
          array(
            'content'   => '',
            'map_embed' => function_exists('get_field') ? call_user_func('get_field', 'sc_contact_map_embed') : '',
          )
        );

        get_template_part(
          'template-parts/components/form',
          null,
          array(
            'shortcode' => function_exists('get_field') ? call_user_func('get_field', 'sc_contact_form_shortcode') : '',
          )
        );
        ?>
      </div>
    </section>

    <?php
    if (function_exists('have_rows') && call_user_func('have_rows', 'sc_sections')) {
      starter_coat_render_sections();
    }
    ?>
  <?php endwhile; ?>
</main>

<?php
get_footer();
