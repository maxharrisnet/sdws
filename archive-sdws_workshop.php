<?php

/**
 * Archive template for sdws_workshop CPT.
 *
 * @package Starter_Coat
 */

get_header();

$gf        = function_exists('get_field');
$ws_title  = $gf ? (get_field('workshops_hero_title', 'option') ?: 'Workshops') : 'Workshops';
$ws_intro  = $gf ? get_field('workshops_intro', 'option') : '';
$email_reg = $gf ? (get_field('workshops_email_registrar', 'option') ?: 'registrar@sdws.org') : 'registrar@sdws.org';
$email_dir = $gf ? (get_field('workshops_email_director',  'option') ?: 'workshops@sdws.org') : 'workshops@sdws.org';
?>

<main id="primary" class="site-main">

  <section class="sdws-section sdws-section--bordered-bottom">
    <div class="sdws-container">
      <h1 class="sdws-page-title"><?php echo esc_html($ws_title); ?></h1>
      <?php if ($ws_intro) : ?>
        <div class="sdws-page-intro"><?php echo wp_kses_post($ws_intro); ?></div>
      <?php endif; ?>
    </div>
  </section>

  <?php
  $formats = get_terms(array(
    'taxonomy'   => 'workshop_format',
    'hide_empty' => true,
    'orderby'    => 'term_order',
    'order'      => 'ASC',
  ));
  ?>

  <?php if (! is_wp_error($formats) && count($formats) > 1) : ?>
    <nav class="sdws-format-nav" aria-label="Workshop formats">
      <div class="sdws-container">
        <ul class="sdws-format-nav__list">
          <?php foreach ($formats as $format) : ?>
            <li><a href="#format-<?php echo esc_attr($format->slug); ?>"><?php echo esc_html($format->name); ?></a></li>
          <?php endforeach; ?>
        </ul>
      </div>
    </nav>
  <?php endif; ?>

  <?php
  if (! is_wp_error($formats) && ! empty($formats)) :
    foreach ($formats as $format) :
      $workshops = new WP_Query(array(
        'post_type'      => 'sdws_workshop',
        'posts_per_page' => -1,
        'orderby'        => 'meta_value',
        'meta_key'       => 'workshop_date_start',
        'order'          => 'ASC',
        'tax_query'      => array(array(
          'taxonomy' => 'workshop_format',
          'field'    => 'term_id',
          'terms'    => $format->term_id,
        )),
      ));

      if (! $workshops->have_posts()) {
        wp_reset_postdata();
        continue;
      }
  ?>

      <section id="format-<?php echo esc_attr($format->slug); ?>" class="sdws-section">
        <div class="sdws-container">
          <div class="sdws-format-header sdws-format-header--full<?php echo $format->description ? ' sdws-format-header--has-description' : ''; ?>">
            <h2 class="sdws-section-heading">
              <?php echo esc_html($format->name); ?>
            </h2>
            <?php if ($format->description) : ?>
              <p class="sdws-format-description">
                <?php echo wp_kses_post($format->description); ?>
              </p>
            <?php endif; ?>
          </div>
          <div class="sdws-grid-3">
            <?php while ($workshops->have_posts()) : $workshops->the_post(); ?>
              <?php get_template_part('template-parts/sdws/sdws-card'); ?>
            <?php endwhile; ?>
          </div>
        </div>
      </section>

    <?php
      wp_reset_postdata();
    endforeach;
  else : ?>

    <section class="sdws-section">
      <div class="sdws-container">
        <p class="sdws-workshops-empty">Workshop listings coming soon.</p>
      </div>
    </section>

  <?php endif; ?>

  <!-- Contact CTA -->
  <?php
  $contact_copy = 'Registration: <a href="mailto:' . esc_attr($email_reg) . '">' . esc_html($email_reg) . '</a>' . "\n\n" .
    'Workshop Director: <a href="mailto:' . esc_attr($email_dir) . '">' . esc_html($email_dir) . '</a>';

  get_template_part('template-parts/components/cta', null, array(
    'cta' => array(
      'title' => 'Questions About Workshops?',
      'copy'  => $contact_copy,
    ),
  ));
  ?>

</main>

<?php get_footer(); ?>