<?php
/*
 * Template Name: Plan Your Visit
 */

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

$eyebrow    = $has_acf ? (get_field('visit_eyebrow')    ?: 'Gallery') : 'Gallery';
$hero_intro = $has_acf ? (get_field('visit_hero_intro') ?: '') : '';

$building_img_id  = $has_acf ? absint(get_field('visit_building_image')) : 0;
$building_img_url = get_template_directory_uri() . '/assets/images/pages/sdws-bldg.jpg';

$info_cards = $has_acf ? (get_field('visit_info_cards') ?: array()) : array();

$default_cards = array(
  array(
    'card_heading' => 'Gallery Hours',
    'card_content' => '<p>Tuesday – Saturday: 11am – 3pm<br>Sunday &amp; Monday: Closed</p><p>The gallery closes between exhibitions. Check the calendar for current show dates.</p>',
  ),
  array(
    'card_heading' => 'Admission',
    'card_content' => '<p>Free admission. All are welcome.</p>',
  ),
  array(
    'card_heading' => 'Location &amp; Parking',
    'card_content' => '<p>2825 Dewey Road, Suite 105, Building 202<br>San Diego, CA 92106</p><p>Free parking is available in the NTC Liberty Station lot.</p>',
  ),
  array(
    'card_heading' => 'Contact',
    'card_content' => '<p><a href="mailto:support@sdws.org">support@sdws.org</a></p>',
  ),
);

if (empty($info_cards)) {
  $info_cards = $default_cards;
}

$map_address = str_replace("\n", ' ', $address);
?>

<main id="primary" class="site-main">

  <!-- Page header -->
  <section class="sdws-section sdws-section--teal">
    <div class="sdws-container">
      <p class="sdws-eyebrow"><?php echo esc_html($eyebrow); ?></p>
      <h1 class="sdws-page-title"><?php the_title(); ?></h1>
      <?php if ($hero_intro) : ?>
        <p class="sdws-visit__header-intro">
          <?php echo esc_html($hero_intro); ?>
        </p>
      <?php endif; ?>
    </div>
  </section>

  <!-- Photo + Info split -->
  <div class="sdws-visit__split">

    <!-- Building photo -->
    <div class="sdws-visit__photo-col">
      <?php if ($building_img_id) : ?>
        <?php echo wp_get_attachment_image($building_img_id, 'sc-card-header-featured', false, array(
          'class'    => 'sdws-visit__photo',
          'loading'  => 'lazy',
          'decoding' => 'async',
          'alt'      => 'San Diego Watercolor Society gallery building at Liberty Station',
          'sizes'    => '(min-width: 1024px) 55vw, 100vw',
        )); ?>
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

    <!-- Info cards -->
    <div class="sdws-visit__detail-col">
      <div class="sdws-visit__detail-inner">
        <?php foreach ($info_cards as $card) :
          $heading = ! empty($card['card_heading']) ? $card['card_heading'] : '';
          $content = ! empty($card['card_content']) ? $card['card_content'] : '';
          if (! $heading && ! $content) continue;
        ?>
          <div class="sdws-visit__info-card">
            <?php if ($heading) : ?>
              <h2 class="sdws-visit__info-card-heading"><?php echo esc_html($heading); ?></h2>
            <?php endif; ?>
            <?php if ($content) : ?>
              <div class="sdws-visit__info-card-body">
                <?php echo wp_kses_post($content); ?>
              </div>
            <?php endif; ?>
          </div>
        <?php endforeach; ?>
      </div>
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
