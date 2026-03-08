<?php

/**
 * Template Name: Archive Overview
 *
 * @package Starter_Coat
 */

get_header();
?>

<main id="primary" class="site-main section section--lg">
  <div class="container">
    <?php while (have_posts()) : the_post(); ?>
      <?php starter_coat_render_singular_hero(get_the_ID()); ?>
      <?php
      $post_type      = function_exists('get_field') ? call_user_func('get_field', 'sc_archive_post_type') : 'post';
      $post_type      = $post_type ? $post_type : 'post';
      $featured_item  = function_exists('get_field') ? absint(call_user_func('get_field', 'sc_archive_featured_item')) : 0;
      $taxonomy       = function_exists('get_field') ? sanitize_key((string) call_user_func('get_field', 'sc_archive_taxonomy')) : '';
      $items_per_page = function_exists('get_field') ? absint(call_user_func('get_field', 'sc_archive_items_per_page')) : 12;
      $items_per_page = $items_per_page ? $items_per_page : 12;

      $query = new WP_Query(
        array(
          'post_type'      => $post_type,
          'posts_per_page' => $items_per_page,
          'post_status'    => 'publish',
          'post__not_in'   => $featured_item ? array($featured_item) : array(),
        )
      );
      ?>

      <?php if (! starter_coat_has_singular_hero(get_the_ID())) : ?>
        <?php the_title('<h1>', '</h1>'); ?>
      <?php endif; ?>
      <?php the_content(); ?>

      <?php if ($featured_item) : ?>
        <?php get_template_part('template-parts/components/featured-item', null, array('post_id' => $featured_item)); ?>
      <?php endif; ?>

      <?php
      if (! empty($taxonomy) && taxonomy_exists($taxonomy)) {
        get_template_part(
          'template-parts/components/category-filter',
          null,
          array(
            'taxonomy'  => $taxonomy,
            'post_type' => $post_type,
            'target_id' => 'archive-results',
          )
        );
      }
      ?>

      <div id="archive-results" class="layout layout--3col">
        <?php if ($query->have_posts()) : ?>
          <?php while ($query->have_posts()) : $query->the_post(); ?>
            <?php
            $card_style = 'post';
            if ('project' === $post_type) {
              $card_style = 'project';
            } elseif ('press' === $post_type) {
              $card_style = 'press';
            }
            get_template_part('template-parts/components/archive-card', null, array('style' => $card_style));
            ?>
          <?php endwhile; ?>
          <?php wp_reset_postdata(); ?>
        <?php else : ?>
          <p><?php esc_html_e('No items found.', 'starter-coat'); ?></p>
        <?php endif; ?>
      </div>
    <?php endwhile; ?>
  </div>
</main>

<?php
get_footer();
