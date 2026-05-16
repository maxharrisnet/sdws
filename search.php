<?php
/**
 * The template for displaying search results pages.
 *
 * @package Starter_Coat
 */

get_header();
?>

<main id="primary" class="site-main">
  <section class="section section--md">
    <div class="container">
      <header class="section__header" style="text-align:center;margin-bottom:var(--space-xl);">
        <p class="eyebrow"><?php esc_html_e('Search Results', 'starter-coat'); ?></p>
        <h1><?php printf(esc_html__('Results for: %s', 'starter-coat'), '<span>' . get_search_query() . '</span>'); ?></h1>
      </header>

      <?php if (have_posts()) : ?>
        <div class="layout layout--3col">
          <?php
          while (have_posts()) :
            the_post();
            get_template_part('template-parts/sdws/sdws-card');
          endwhile;
          ?>
        </div>

        <?php get_template_part('template-parts/components/pagination'); ?>

      <?php else : ?>
        <?php get_template_part('template-parts/content', 'none'); ?>
      <?php endif; ?>
    </div>
  </section>
</main>

<?php
get_footer();
