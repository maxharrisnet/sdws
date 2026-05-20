<?php

/**
 * Plan Your Visit page template — San Diego Watercolor Society
 * Slug: visit
 *
 * @package Starter_Coat
 */

get_header();

$has_acf = function_exists('get_field');

$contact = function_exists('starter_coat_get_contact_info') ? starter_coat_get_contact_info() : array();
$address = ! empty($contact['address']) ? $contact['address'] : "2825 Dewey Road, Suite 105\nSan Diego, CA 92106";
$phone   = ! empty($contact['phone'])   ? $contact['phone']   : '';

$building_img_id  = $has_acf ? absint(get_field('visit_building_image_id', 'option')) : 0;
$building_img_url = get_template_directory_uri() . '/assets/images/pages/sdws-bldg.jpg';

$map_address = str_replace("\n", ' ', $address);

?>

<main id="primary" class="site-main">

  <!-- Page header -->
  <section class="sdws-section sdws-section--teal">
    <div class="sdws-container">
      <p class="sdws-eyebrow">Gallery</p>
      <h1 class="sdws-page-title">Plan Your Visit</h1>
      <p class="sdws-visit__header-intro">
        The San Diego Watercolor Society hosts rotating gallery exhibitions and receptions — a combination of solo shows featuring nationally and internationally recognized artists, and juried art exhibitions.
      </p>
    </div>
  </section>

  <!-- Photo + Info split -->
  <div class="sdws-visit__split">

    <!-- Building photo -->
    <div class="sdws-visit__photo-col">
      <?php if ($building_img_id) : ?>
        <?php
        echo wp_get_attachment_image($building_img_id, 'sc-card-header-featured', false, array(
          'class'   => 'sdws-visit__photo',
          'loading' => 'lazy',
          'decoding' => 'async',
          'alt'     => 'San Diego Watercolor Society gallery building at Liberty Station',
          'sizes'   => '(min-width: 1024px) 55vw, 100vw',
        ));
        ?>
      <?php else : ?>
        <img
          src="<?php echo esc_url($building_img_url); ?>"
          alt="San Diego Watercolor Society gallery building at Liberty Station"
          class="sdws-visit__photo"
          loading="lazy"
          decoding="async"
          width="1440"
          height="1800"
        >
      <?php endif; ?>
    </div>

    <!-- Info panel -->
    <div class="sdws-visit__detail-col">

      <div class="sdws-visit__detail-inner">

        <div class="sdws-visit__detail-block">
          <h2 class="sdws-visit__label">Gallery Hours</h2>
          <dl class="sdws-visit__hours">
            <div class="sdws-visit__hours-row">
              <dt class="sdws-visit__hours-day">Thursday &ndash; Sunday</dt>
              <dd class="sdws-visit__hours-time">11:00 AM &ndash; 3:00 PM</dd>
            </div>
            <div class="sdws-visit__hours-row sdws-visit__hours-row--closed">
              <dt class="sdws-visit__hours-day">Monday &ndash; Wednesday</dt>
              <dd class="sdws-visit__hours-time">Closed</dd>
            </div>
          </dl>
          <p class="sdws-visit__caveat">
            Please check the <a href="<?php echo esc_url(get_permalink(get_page_by_path('calendar'))); ?>">calendar</a> for exceptions due to holidays and special events.
          </p>
        </div>

        <div class="sdws-visit__detail-block">
          <h2 class="sdws-visit__label">Admission</h2>
          <p class="sdws-visit__admission-free">Free to the public</p>
        </div>

        <?php if ($address) : ?>
          <div class="sdws-visit__detail-block">
            <h2 class="sdws-visit__label">Location</h2>
            <address class="sdws-visit__address">
              <?php echo wp_kses_post(nl2br(esc_html($address))); ?>
            </address>
            <a
              href="https://maps.google.com/?q=<?php echo rawurlencode($map_address); ?>"
              class="sdws-visit__directions-link"
              target="_blank"
              rel="noopener noreferrer"
            >Get Directions &rarr;</a>
          </div>
        <?php endif; ?>

        <?php if ($phone) : ?>
          <div class="sdws-visit__detail-block">
            <h2 class="sdws-visit__label">Contact</h2>
            <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $phone)); ?>" class="sdws-visit__phone-link">
              <?php echo esc_html($phone); ?>
            </a>
          </div>
        <?php endif; ?>

      </div><!-- .sdws-visit__detail-inner -->

    </div><!-- .sdws-visit__detail-col -->

  </div><!-- .sdws-visit__split -->

  <!-- Map — full width, flush -->
  <div class="sdws-visit__map-wrap">
    <?php
    get_template_part('template-parts/components/map-embed', null, array(
      'address'     => $map_address,
      'layout_mode' => 'one-col',
      'map_height'  => 440,
      'map_width'   => 'full',
    ));
    ?>
  </div>

  <!-- CTA -->
  <?php
  $page_cta = function_exists('starter_coat_get_page_cta_override') ? starter_coat_get_page_cta_override(get_the_ID()) : null;
  $GLOBALS['sdws_cta_rendered'] = true;

  $active_cta = ($page_cta !== null && ! empty($page_cta['enabled'])) ? $page_cta : array(
    'title'                  => 'See What\'s On Now',
    'copy'                   => 'Browse current and upcoming exhibitions, member shows, and special events at the SDWS Gallery.',
    'background'             => 'sand',
    'layout'                 => 'stacked',
    'text_box_style'         => 'none',
    'button_primary'         => array(
      'title' => 'View Exhibitions',
      'url'   => esc_url(get_permalink(get_page_by_path('schedule'))),
    ),
    'button_primary_style'   => 'primary',
    'button_secondary'       => array(
      'title' => 'View Calendar',
      'url'   => esc_url(get_permalink(get_page_by_path('calendar'))),
    ),
    'button_secondary_style' => 'outline',
  );

  get_template_part('template-parts/components/cta', null, array('cta' => $active_cta));
  ?>

</main>

<?php get_footer(); ?>
