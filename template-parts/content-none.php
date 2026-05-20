<?php
/**
 * Template part for displaying a message that posts cannot be found.
 *
 * @package Starter_Coat
 */
?>

<section class="section section--lg no-results">
  <div class="container container--narrow container--centered">
    <h2><?php esc_html_e('Nothing Found', 'starter-coat'); ?></h2>

    <?php if (is_home() && current_user_can('publish_posts')) : ?>
      <p>
        <?php
        printf(
          wp_kses(
            __('Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'starter-coat'),
            array('a' => array('href' => array()))
          ),
          esc_url(admin_url('post-new.php'))
        );
        ?>
      </p>
    <?php elseif (is_search()) : ?>
      <p><?php esc_html_e('Nothing matched your search terms. Try different keywords.', 'starter-coat'); ?></p>
      <?php get_search_form(); ?>
    <?php else : ?>
      <p><?php esc_html_e('It seems we can\'t find what you\'re looking for. Try searching.', 'starter-coat'); ?></p>
      <?php get_search_form(); ?>
    <?php endif; ?>
  </div>
</section>
