<?php

/**
 * Workshops page template — San Diego Watercolor Society
 * Slug: workshops
 *
 * @package Starter_Coat
 */

get_header();

// ── Helper ──────────────────────────────────────────────────────────────────
if (!function_exists('sdws_opt')) {
  function sdws_opt($key, $fallback = '') {
    if (!function_exists('get_field')) return $fallback;
    $val = get_field($key, 'option');
    return ($val !== false && $val !== '') ? $val : $fallback;
  }
}

$ws_intro   = sdws_opt('workshops_intro',          'SDWS workshops are led by nationally recognized instructors and open to all skill levels. Members receive discounted rates on all sessions.');
$email_reg  = sdws_opt('workshops_email_registrar', 'registrar@sdws.org');
$email_dir  = sdws_opt('workshops_email_director',  'workshops@sdws.org');
?>

<main id="primary" class="site-main">

  <!-- Page header -->
  <section class="sdws-section sdws-section--bordered-bottom">
    <div class="sdws-container">
      <h1 class="sdws-page-title">Workshops</h1>
      <p class="sdws-page-intro">
        <?php echo esc_html($ws_intro); ?>
      </p>
    </div>
  </section>

  <?php
  $format_groups = array(
    array(
      'slug'    => 'in-person',
      'heading' => 'In-Gallery Workshops',
    ),
    array(
      'slug'    => 'zoom',
      'heading' => 'Zoom Workshops',
    ),
    array(
      'slug'    => 'beginner-series',
      'heading' => 'Beginner Series',
    ),
  );

  foreach ( $format_groups as $group ) :
    $workshops = new WP_Query( array(
      'post_type'      => 'sdws_workshop',
      'posts_per_page' => -1,
      'orderby'        => 'meta_value',
      'meta_key'       => 'workshop_date_start',
      'order'          => 'ASC',
      'tax_query'      => array( array(
        'taxonomy' => 'workshop_format',
        'field'    => 'slug',
        'terms'    => $group['slug'],
      ) ),
    ) );

    if ( ! $workshops->have_posts() ) {
      wp_reset_postdata();
      continue;
    }
  ?>

    <section class="sdws-section sdws-section--bordered-bottom">
      <div class="sdws-container">
        <h2 class="sdws-section-heading">
          <?php echo esc_html( $group['heading'] ); ?>
        </h2>
        <div class="sdws-grid-3">
          <?php while ( $workshops->have_posts() ) : $workshops->the_post(); ?>
            <?php get_template_part( 'template-parts/sdws/sdws-card' ); ?>
          <?php endwhile; ?>
        </div>
      </div>
    </section>

  <?php
    wp_reset_postdata();
  endforeach;
  ?>

  <!-- Contact CTA -->
  <?php
  $contact_copy = 'Registration: <a href="mailto:' . esc_attr($email_reg) . '">' . esc_html($email_reg) . '</a>' . "\n\n" .
                  'Workshop Director: <a href="mailto:' . esc_attr($email_dir) . '">' . esc_html($email_dir) . '</a>';

  get_template_part('template-parts/components/cta', null, array(
    'cta' => array(
      'title'          => 'Questions About Workshops?',
      'copy'           => $contact_copy,
      'background'     => 'off-white',
      'layout'         => 'stacked',
      'text_box_style' => 'none',
    ),
  ));
  ?>

</main>

<?php get_footer(); ?>
