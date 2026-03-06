<?php

/**
 * Template Name: FAQ Page
 *
 * Generic FAQ layout that renders accordion content managed under
 * Company Options and can be reused via the [aera_faq] shortcode.
 *
 * @package Aera_Technology
 */

get_header();

$hero_args = array(
  'hero_title' => get_the_title(),
);

// $hero_description = get_the_excerpt();
if (!empty($hero_description)) {
  $hero_args['hero_text'] = $hero_description;
}

get_template_part('template-parts/components/hero', null, $hero_args);

$faq_data = function_exists('\\Aera\\get_company_faq_data') ? \Aera\get_company_faq_data(get_the_ID()) : array();
$faq_markup = function_exists('Aera\\render_faq_markup') ? \Aera\render_faq_markup($faq_data, array(
  'wrapper_classes' => 'faq faq--page',
  'heading_tag'     => 'h2',
  'id_prefix'       => 'faq',
)) : '';
?>

<main id="primary" class="site-main site-main--faq">
  <div class="template-page">
    <div class="template-page__container">
      <div class="template-page__row">
        <div class="template-page__col template-page__content">
          <?php
          while (have_posts()) :
            the_post();
            the_content();
          endwhile;
          ?>
        </div>
      </div>

      <?php if (!empty($faq_markup)) : ?>
        <div class="faq__wrapper">
          <?php echo $faq_markup; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
          ?>
        </div>
      <?php else : ?>
        <p class="faq__empty"><?php esc_html_e('No FAQs have been added yet.', 'aera'); ?></p>
      <?php endif; ?>
    </div>
  </div>
</main>

<?php
get_footer();
