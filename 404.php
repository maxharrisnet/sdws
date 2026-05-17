<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @package Starter_Coat
 */

get_header();
?>

<main id="primary" class="site-main">
  <section class="sdws-section sdws-section--lg sdws-error-404">
    <div class="sdws-container sdws-container--narrow">
      <p class="sdws-eyebrow"><?php esc_html_e('404', 'starter-coat'); ?></p>
      <h1><?php esc_html_e('Page Not Found', 'starter-coat'); ?></h1>
      <p><?php esc_html_e('The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.', 'starter-coat'); ?></p>

      <div class="sdws-error-404__search">
        <?php get_search_form(); ?>
      </div>

      <p class="sdws-error-404__back">
        <a href="<?php echo esc_url(home_url('/')); ?>" class="sdws-btn sdws-btn--primary">
          <?php esc_html_e('Back to Homepage', 'starter-coat'); ?>
        </a>
      </p>
    </div>
  </section>
</main>

<?php get_footer(); ?>
