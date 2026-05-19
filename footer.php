<?php

/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Starter_Coat
 */

?>

<?php
// Page-level CTA: show only when the override is explicitly enabled on this page/post.
// Skipped when the page template has already rendered the CTA in-page (e.g. donate).
if (empty($GLOBALS['sdws_cta_rendered']) && function_exists('starter_coat_get_page_cta_override')) {
  $sdws_cta = starter_coat_get_page_cta_override(get_the_ID());
  if ($sdws_cta !== null && ! empty($sdws_cta['enabled'])) {
    get_template_part('template-parts/components/cta', null, array('cta' => $sdws_cta));
  }
}
?>
<?php get_template_part('template-parts/components/footer'); ?>
</div><!-- #page -->

<button class="back-to-top" aria-label="<?php esc_attr_e('Back to top', 'starter-coat'); ?>" hidden>
  <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
    <polyline points="18 15 12 9 6 15" />
  </svg>
</button>

<?php wp_footer(); ?>

</body>

</html>