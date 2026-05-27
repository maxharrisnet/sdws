<?php

/**
 * Homepage template — San Diego Watercolor Society
 * Content editable at: WP Admin > Pages > (front page)
 *
 * @package Starter_Coat
 */

get_header();

$gf = function_exists('get_field');

// ── Hero fields ─────────────────────────────────────────────────────────────
$hero_eyebrow     = $gf ? (get_field('home_hero_eyebrow')) : '';
$hero_headline    = $gf ? (get_field('home_hero_headline')    ?: 'Watercolor art, community, and excellence in San Diego.') : 'Watercolor art, community, and excellence in San Diego.';
$hero_sub         = $gf ? (get_field('home_hero_subheadline') ?: 'The San Diego Watercolor Society has championed watercolor painting for over 40 years — offering gallery exhibitions, workshops, and a vibrant community for artists at every level.') : 'The San Diego Watercolor Society has championed watercolor painting for over 40 years — offering gallery exhibitions, workshops, and a vibrant community for artists at every level.';
$hero_cta1_text   = $gf ? (get_field('home_hero_cta1_text')  ?: 'Visit the Gallery') : 'Visit the Gallery';
$hero_cta1_url    = $gf ? (get_field('home_hero_cta1_url')   ?: home_url('/exhibitions/')) : home_url('/exhibitions/');
$hero_cta2_text   = $gf ? (get_field('home_hero_cta2_text')  ?: 'Learn About the I-Show') : 'Learn About the I-Show';
$hero_cta2_url    = $gf ? (get_field('home_hero_cta2_url')   ?: home_url('/international/')) : home_url('/international/');

// ── Gallery strip fields ─────────────────────────────────────────────────────
$gallery_visible_raw = $gf ? get_field('home_gallery_visible') : null;
$gallery_visible  = ($gallery_visible_raw === null) ? true : (bool) $gallery_visible_raw;
$gallery_label    = $gf ? get_field('home_gallery_label')    : '';
$gallery_caption  = $gf ? get_field('home_gallery_caption')  : '';
$gallery_images   = $gf ? (get_field('home_gallery_images')  ?: array()) : array();
$gallery_page_url = $gf ? get_field('home_gallery_page_url') : '';

// ── Map section fields ───────────────────────────────────────
$map_label         = $gf ? (get_field('home_map_label')         ?: 'Visit the Gallery') : 'Visit the Gallery';
$map_address       = $gf ? (get_field('home_map_address')       ?: "2825 Dewey Road, Suite 105\nSan Diego, CA 92106") : "2825 Dewey Road, Suite 105\nSan Diego, CA 92106";
$map_directions    = $gf ? (get_field('home_map_directions_url') ?: '') : '';
$map_embed         = $gf ? (get_field('home_map_embed')         ?: '') : '';

// ── I-Show promo fields ──────────────────────────────────────────────────────
$ishow_visible  = $gf ? get_field('home_ishow_visible') : true;
$ishow_image    = $gf ? get_field('home_ishow_image') : null;
$ishow_img_id   = !empty($ishow_image['ID']) ? (int) $ishow_image['ID'] : 0;
$ishow_visible  = ($ishow_visible === false) ? true : (bool) $ishow_visible; // default on
$ishow_eyebrow  = $gf ? (get_field('home_ishow_eyebrow')   ?: 'Now Accepting Entries') : 'Now Accepting Entries';
$ishow_headline = $gf ? (get_field('home_ishow_headline')  ?: '46th International Exhibition') : '46th International Exhibition';
$ishow_dates    = $gf ? (get_field('home_ishow_dates')     ?: 'September 27 – October 31, 2026') : 'September 27 – October 31, 2026';
$ishow_meta     = $gf ? (get_field('home_ishow_meta')      ?: 'Awards: $30,000+ &nbsp;|&nbsp; Juror: Ana Laura Salazar') : 'Awards: $30,000+ &nbsp;|&nbsp; Juror: Ana Laura Salazar';
$ishow_body     = $gf ? (get_field('home_ishow_body')      ?: 'Open to watercolor artists worldwide. Submit via online entry.') : 'Open to watercolor artists worldwide. Submit via online entry.';
$ishow_cta_text = $gf ? (get_field('home_ishow_cta_text')  ?: 'View Exhibition Details') : 'View Exhibition Details';
$ishow_cta_url  = $gf ? (get_field('home_ishow_cta_url')   ?: home_url('/international/')) : home_url('/international/');
?>

<main id="primary" class="site-main">
  <div class="sdws-hero-image">
    <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/sdws-home-hero.png'); ?>" alt="Collage of watercolor artworks by SDWS members">
  </div>
  <!-- ======================== HERO ======================== -->
  <section class="sdws-section sdws-section--bordered-bottom">
    <div class="sdws-container">
      <?php if ($hero_eyebrow) : ?>
        <p class="sdws-eyebrow"><?php echo esc_html($hero_eyebrow); ?></p>
      <?php endif; ?>
      <h1 class="sdws-hero-title"><?php echo esc_html($hero_headline); ?></h1>
      <?php if ($hero_sub) : ?>
        <p class="sdws-hero__sub"><?php echo esc_html($hero_sub); ?></p>
      <?php endif; ?>
      <div class="sdws-hero__actions">
        <a href="<?php echo esc_url($hero_cta1_url); ?>" class="sdws-btn sdws-btn--teal">
          <?php echo esc_html($hero_cta1_text); ?>
        </a>
        <?php if ($hero_cta2_text && $hero_cta2_url) : ?>
          <a href="<?php echo esc_url($hero_cta2_url); ?>" class="sdws-btn sdws-btn--outline">
            <?php echo esc_html($hero_cta2_text); ?>
          </a>
        <?php endif; ?>
      </div>
    </div>
  </section>


  <!-- ================== GALLERY GRID ================== -->
  <?php if ($gallery_visible && !empty($gallery_images)) : ?>
  <section class="sdws-gallery-section sdws-section--bordered-bottom">
    <?php if ($gallery_label || $gallery_caption || $gallery_page_url) : ?>
      <div class="sdws-container sdws-gallery-section__header">
        <?php if ($gallery_label || $gallery_caption) : ?>
          <div class="sdws-gallery-section__meta">
            <?php if ($gallery_label) : ?>
              <p class="sdws-gallery-section__label"><?php echo esc_html($gallery_label); ?></p>
            <?php endif; ?>
            <?php if ($gallery_caption) : ?>
              <p class="sdws-gallery-section__caption"><?php echo esc_html($gallery_caption); ?></p>
            <?php endif; ?>
          </div>
        <?php endif; ?>
        <?php if ($gallery_page_url) : ?>
          <a href="<?php echo esc_url($gallery_page_url); ?>" class="sdws-gallery-section__view-all">View Gallery</a>
        <?php endif; ?>
      </div>
    <?php endif; ?>
    <div class="sdws-gallery-grid">
      <?php
      $gi = 0;
      $display_images = array_slice($gallery_images, 0, 12);

      if (!empty($display_images)) :
        foreach ($display_images as $img_id) :
          $img_id   = (int) $img_id;
          $full_src = wp_get_attachment_image_src($img_id, 'large');
          $full_url = $full_src ? $full_src[0] : '';
          $alt      = get_post_meta($img_id, '_wp_attachment_image_alt', true) ?: '';
      ?>
          <div class="sdws-gallery-grid__item" data-gallery-index="<?php echo $gi++; ?>">
            <a class="sdws-gallery-grid__link" href="<?php echo esc_url($full_url); ?>"
               data-lightbox="gallery"
               data-lightbox-alt="<?php echo esc_attr($alt); ?>">
              <?php echo wp_get_attachment_image($img_id, 'sc-profile-square-lg', false, array(
                'class'    => 'sdws-img-crop sdws-img-square',
                'alt'      => $alt,
                'loading'  => 'lazy',
                'decoding' => 'async',
                'sizes'    => '(min-width: 1200px) 17vw, (min-width: 768px) 25vw, 50vw',
              )); ?>
            </a>
          </div>
      <?php
        endforeach;
      else :
        for ($i = 0; $i < 12; $i++) :
      ?>
          <div class="sdws-gallery-grid__item sdws-gallery-grid__item--placeholder" data-gallery-index="<?php echo $i; ?>"></div>
      <?php
        endfor;
      endif;
      ?>
    </div>
  </section>
  <?php endif; ?>

  <!-- ================ I-SHOW PROMO BLOCK ================ -->
  <?php if ($ishow_visible) : ?>
    <section class="sdws-section sdws-section--teal sdws-section--bordered-bottom">
      <div class="sdws-container">
        <div class="sdws-ishow__layout<?php echo $ishow_img_id ? ' sdws-ishow--with-image' : ''; ?>">

          <?php if ($ishow_img_id) : ?>
            <div class="sdws-ishow__img-col">
              <?php echo wp_get_attachment_image($ishow_img_id, 'large', false, array(
                'class'    => 'sdws-ishow__img',
                'loading'  => 'lazy',
                'decoding' => 'async',
                'sizes'    => '(min-width: 768px) 280px, 80vw',
                'alt'      => $ishow_headline,
              )); ?>
            </div>
          <?php endif; ?>

          <div class="sdws-ishow__content">
            <p class="sdws-eyebrow"><?php echo esc_html($ishow_eyebrow); ?></p>
            <h2 class="sdws-ishow-title"><?php echo esc_html($ishow_headline); ?></h2>
            <?php if ($ishow_dates) : ?>
              <p class="sdws-ishow-dates"><?php echo esc_html($ishow_dates); ?></p>
            <?php endif; ?>
            <?php if ($ishow_meta) : ?>
              <p class="sdws-ishow-meta"><?php echo wp_kses_post($ishow_meta); ?></p>
            <?php endif; ?>
            <?php if ($ishow_body) : ?>
              <p class="sdws-ishow-body"><?php echo esc_html($ishow_body); ?></p>
            <?php endif; ?>
            <a href="<?php echo esc_url($ishow_cta_url); ?>" class="sdws-btn sdws-btn--white">
              <?php echo esc_html($ishow_cta_text); ?>
            </a>
          </div>

        </div>
      </div>
    </section>
  <?php endif; ?>



  <!-- ============== FLEXIBLE CONTENT SECTIONS ============== -->
  <?php
  // Render the sc_sections flexible content from the static front page (if one is set).
  // Client adds/reorders sections at WP Admin > Pages > [Home page] > Page Sections.
  $front_page_id = (int) get_option('page_on_front');
  if ($front_page_id && function_exists('have_rows') && function_exists('starter_coat_render_sections')) {
    $front_page_post = get_post($front_page_id);
    if ($front_page_post) {
      $saved_post = $GLOBALS['post'] ?? null;
      $GLOBALS['post'] = $front_page_post;
      setup_postdata($front_page_post);
      starter_coat_render_sections();
      if ($saved_post) {
        $GLOBALS['post'] = $saved_post;
        setup_postdata($saved_post);
      }
    }
  }
  ?>

  <!-- ================ UPCOMING EVENTS GRID ================ -->
  <section class="sdws-section sdws-section--bordered-bottom">
    <div class="sdws-container">
      <div class="sdws-section-header">
        <h2 class="sdws-section-header__title">What's Coming Up</h2>
        <div class="sdws-section-header__actions">
          <a href="<?php echo esc_url(home_url('/workshops/')); ?>" class="sdws-btn sdws-btn--outline">All Workshops</a>
          <a href="<?php echo esc_url(home_url('/schedule/')); ?>" class="sdws-btn sdws-btn--outline">All Exhibitions</a>
        </div>
      </div>
      <?php
      $today = date('Ymd');

      $workshop_posts = get_posts(array(
        'post_type'      => 'sdws_workshop',
        'posts_per_page' => 10,
        'meta_key'       => 'workshop_date_start',
        'meta_query'     => array(array(
          'key'     => 'workshop_date_start',
          'value'   => $today,
          'compare' => '>=',
          'type'    => 'CHAR',
        )),
        'orderby' => 'meta_value',
        'order'   => 'ASC',
      ));

      $exhibition_posts = get_posts(array(
        'post_type'      => 'sdws_exhibition',
        'posts_per_page' => 10,
        'meta_key'       => 'exhibition_show_dates_start',
        'meta_query'     => array(array(
          'key'     => 'exhibition_show_dates_start',
          'value'   => $today,
          'compare' => '>=',
          'type'    => 'CHAR',
        )),
        'orderby' => 'meta_value',
        'order'   => 'ASC',
      ));

      $all_items = array_merge($workshop_posts, $exhibition_posts);
      usort($all_items, function ($a, $b) {
        $key_a = 'sdws_workshop' === get_post_type($a) ? 'workshop_date_start' : 'exhibition_show_dates_start';
        $key_b = 'sdws_workshop' === get_post_type($b) ? 'workshop_date_start' : 'exhibition_show_dates_start';
        $date_a = get_post_meta($a->ID, $key_a, true) ?: '99999999';
        $date_b = get_post_meta($b->ID, $key_b, true) ?: '99999999';
        return strcmp($date_a, $date_b);
      });
      $all_items = array_slice($all_items, 0, 3);
      ?>
      <?php if ($all_items) : ?>
        <div class="sdws-grid-3">
          <?php foreach ($all_items as $post) :
            setup_postdata($post);
            get_template_part('template-parts/sdws/sdws-card');
          endforeach;
          wp_reset_postdata(); ?>
        </div>
      <?php else : ?>
        <p class="sdws-empty-state">Events and workshops coming soon.</p>
      <?php endif; ?>
    </div>
  </section>

  <!-- ==================== MAP SECTION ===================== -->
  <?php if ($map_embed) : ?>
    <section class="sdws-map-section">
      <div class="sdws-map-section__inner">
        <div class="sdws-map-section__info">
          <p class="sdws-map-section__label"><?php echo esc_html($map_label); ?></p>
          <h2 class="sdws-map-section__org">San Diego Watercolor Society</h2>
          <?php if ($map_address) : ?>
            <address class="sdws-map-section__address">
              <?php echo nl2br(esc_html($map_address)); ?>
            </address>
          <?php endif; ?>
          <?php if ($map_directions) : ?>
            <a href="<?php echo esc_url($map_directions); ?>" class="sdws-map-section__directions" target="_blank" rel="noopener">
              Get Directions →
            </a>
          <?php endif; ?>
        </div>
        <div class="sdws-map-section__map">
          <?php echo $map_embed; // phpcs:ignore WordPress.Security.EscapeOutput -- admin-controlled iframe embed
          ?>
        </div>
      </div>
    </section>
  <?php endif; ?>

</main>

<?php get_footer(); ?>