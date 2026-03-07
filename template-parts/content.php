<?php

/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Starter_Coat
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
  <?php if (! starter_coat_has_singular_hero(get_the_ID())) : ?>
    <header class="entry-header">
      <?php
      if (is_singular()) :
        the_title('<h1 class="entry-title">', '</h1>');
      else :
        the_title('<h2 class="entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h2>');
      endif;

      if ('post' === get_post_type()) :
      ?>
        <div class="entry-meta">
          <?php
          starter_coat_posted_on();
          starter_coat_posted_by();
          ?>
        </div><!-- .entry-meta -->
      <?php endif; ?>
    </header><!-- .entry-header -->
  <?php endif; ?>

  <?php starter_coat_post_thumbnail(); ?>

  <div class="entry-content">
    <?php
    the_content(
      sprintf(
        wp_kses(
          /* translators: %s: Name of current post. Only visible to screen readers */
          __('Continue reading<span class="screen-reader-text"> "%s"</span>', 'starter-coat'),
          array(
            'span' => array(
              'class' => array(),
            ),
          )
        ),
        wp_kses_post(get_the_title())
      )
    );

    wp_link_pages(
      array(
        'before' => '<div class="page-links">' . esc_html__('Pages:', 'starter-coat'),
        'after'  => '</div>',
      )
    );
    ?>
  </div><!-- .entry-content -->

  <footer class="entry-footer">
    <?php starter_coat_entry_footer(); ?>
  </footer><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->