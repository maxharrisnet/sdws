<?php

/**
 * Homepage template — San Diego Watercolor Society
 * Content editable at: WP Admin > SDWS Content > Homepage
 *
 * @package Starter_Coat
 */

get_header();

// ── Helper ──────────────────────────────────────────────────────────────────
function sdws_opt($key, $fallback = '')
{
  if (!function_exists('get_field')) return $fallback;
  $val = get_field($key, 'option');
  return ($val !== false && $val !== '') ? $val : $fallback;
}

// ── Hero fields ─────────────────────────────────────────────────────────────
$hero_eyebrow     = sdws_opt('home_hero_eyebrow',      'San Diego Watercolor Society — Est. 1980');
$hero_headline    = sdws_opt('home_hero_headline',     'Watercolor art, community, and excellence in San Diego.');
$hero_sub         = sdws_opt('home_hero_subheadline',  'The San Diego Watercolor Society has championed watercolor painting for over 40 years — offering gallery exhibitions, workshops, and a vibrant community for artists at every level.');
$hero_cta1_text   = sdws_opt('home_hero_cta1_text',   'Visit the Gallery');
$hero_cta1_url    = sdws_opt('home_hero_cta1_url',    home_url('/exhibitions/'));
$hero_cta2_text   = sdws_opt('home_hero_cta2_text',   'Learn About the I-Show');
$hero_cta2_url    = sdws_opt('home_hero_cta2_url',    home_url('/international/'));

// ── Gallery strip fields ─────────────────────────────────────────────────────
$gallery_label     = sdws_opt('home_gallery_label',     'June Member Show');
$gallery_caption   = sdws_opt('home_gallery_caption',   '90+ works on display');
$gallery_shortcode = sdws_opt('home_gallery_shortcode', '');

// ── I-Show promo fields ──────────────────────────────────────────────────────
$ishow_visible  = function_exists('get_field') ? get_field('home_ishow_visible', 'option') : true;
$ishow_visible  = ($ishow_visible === false) ? true : (bool) $ishow_visible; // default on
$ishow_eyebrow  = sdws_opt('home_ishow_eyebrow',   'Now Accepting Entries');
$ishow_headline = sdws_opt('home_ishow_headline',  '46th International Exhibition');
$ishow_dates    = sdws_opt('home_ishow_dates',     'September 27 – October 31, 2026');
$ishow_meta     = sdws_opt('home_ishow_meta',      'Awards: $30,000+ &nbsp;|&nbsp; Juror: Ana Laura Salazar');
$ishow_body     = sdws_opt('home_ishow_body',      'Open to watercolor artists worldwide. Submit via online entry.');
$ishow_cta_text = sdws_opt('home_ishow_cta_text',  'View Exhibition Details');
$ishow_cta_url  = sdws_opt('home_ishow_cta_url',   home_url('/international/'));
?>

<main id="primary" class="site-main">

  <!-- ======================== HERO ======================== -->
  <section class="sdws-section sdws-section--lg" style="background:#fff; border-bottom: var(--border);">
    <div class="sdws-container">
      <p style="font-size:0.8125rem; letter-spacing:0.12em; text-transform:uppercase; font-weight:500; margin-bottom:1.25rem;">
        <?php echo esc_html($hero_eyebrow); ?>
      </p>
      <h1 style="font-family:var(--font-display); font-size:clamp(2.5rem,6vw,4.5rem); line-height:1.1; margin:0 0 1.5rem; color:#000;">
        <?php echo esc_html($hero_headline); ?>
      </h1>
      <?php if ($hero_sub) : ?>
        <p style="font-size:1.125rem; max-width:600px; margin:0 0 2.5rem; line-height:1.7; color:#000;">
          <?php echo esc_html($hero_sub); ?>
        </p>
      <?php endif; ?>
      <div style="display:flex; gap:1rem; flex-wrap:wrap;">
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
  <section>
    <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/sdws-home-hero.png'); ?>" alt="Collage of watercolor artworks by SDWS members" style="width:100%; height:auto; display:block; object-fit:cover;">
  </section>

  <!-- ================== GALLERY STRIP ================== -->
  <!-- <section style="border-bottom: var(--border); overflow:hidden;">
    <div style="padding:2rem 2rem 0; max-width:var(--max-width); margin:0 auto; display:flex; justify-content:space-between; align-items:baseline;">
      <p style="font-size:0.8125rem; letter-spacing:0.1em; text-transform:uppercase; font-weight:500; margin:0;">
        <?php echo esc_html($gallery_label); ?>
      </p>
      <?php if ($gallery_caption) : ?>
        <p style="font-size:0.875rem; margin:0; color:#000;"><?php echo esc_html($gallery_caption); ?></p>
      <?php endif; ?>
    </div>
    <div class="sdws-gallery-strip" style="margin-top:1.5rem;">
      <?php if ($gallery_shortcode) : ?>
        <div class="sdws-gallery-shortcode">
          <?php echo do_shortcode($gallery_shortcode); ?>
        </div>
      <?php else : ?>
        <?php
        $gallery_query = new WP_Query(array(
          'post_type'      => 'sdws_exhibition',
          'posts_per_page' => 8,
          'tax_query'      => array(array(
            'taxonomy' => 'exhibition_type',
            'field'    => 'slug',
            'terms'    => 'member-show',
          )),
        ));

        if ($gallery_query->have_posts()) :
          while ($gallery_query->have_posts()) : $gallery_query->the_post();
            if (has_post_thumbnail()) :
        ?>
              <div class="sdws-gallery-strip__item">
                <?php the_post_thumbnail('sc-card-header', array(
                  'class'    => 'sdws-img-crop sdws-img-4-3',
                  'alt'      => get_the_title(),
                  'loading'  => 'lazy',
                  'decoding' => 'async',
                  'sizes'    => '(min-width: 1200px) 320px, (min-width: 768px) 30vw, 50vw',
                )); ?>
              </div>
            <?php
            endif;
          endwhile;
          wp_reset_postdata();
        else :
          for ($i = 1; $i <= 6; $i++) :
            ?>
            <div class="sdws-gallery-strip__item" style="background:var(--color-sand); display:flex; align-items:center; justify-content:center; min-height:210px;">
              <span style="font-size:0.75rem; letter-spacing:0.08em; text-transform:uppercase; opacity:0.4;">Artwork <?php echo $i; ?></span>
            </div>
        <?php
          endfor;
        endif;
        ?>
      <?php endif; ?>
    </div>
  </section> -->

  <!-- ================ I-SHOW PROMO BLOCK ================ -->
  <?php if ($ishow_visible) : ?>
    <section class="sdws-section sdws-section--teal" style="border-bottom: 2px solid #000;">
      <div class="sdws-container">
        <p style="font-size:0.8125rem; letter-spacing:0.12em; text-transform:uppercase; font-weight:500; margin-bottom:1rem; color:#fff; opacity:0.8;">
          <?php echo esc_html($ishow_eyebrow); ?>
        </p>
        <h2 style="font-family:var(--font-display); font-size:clamp(2rem,5vw,3.5rem); color:#fff; margin:0 0 1rem; line-height:1.15;">
          <?php echo esc_html($ishow_headline); ?>
        </h2>
        <?php if ($ishow_dates) : ?>
          <p style="font-size:1.125rem; color:#fff; margin:0 0 0.5rem;">
            <strong><?php echo esc_html($ishow_dates); ?></strong>
          </p>
        <?php endif; ?>
        <?php if ($ishow_meta) : ?>
          <p style="font-size:1rem; color:#fff; margin:0 0 0.5rem;">
            <?php echo wp_kses_post($ishow_meta); ?>
          </p>
        <?php endif; ?>
        <?php if ($ishow_body) : ?>
          <p style="font-size:0.9375rem; color:#fff; margin:0 0 2rem;">
            <?php echo esc_html($ishow_body); ?>
          </p>
        <?php endif; ?>
        <a href="<?php echo esc_url($ishow_cta_url); ?>" class="sdws-btn sdws-btn--white">
          <?php echo esc_html($ishow_cta_text); ?>
        </a>
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

  <!-- ================ UPCOMING WORKSHOPS GRID ================ -->
  <section class="sdws-section" style="border-bottom: var(--border); background: #fff;">
    <div class="sdws-container">
      <div style="display:flex; justify-content:space-between; align-items:baseline; margin-bottom:2.5rem; flex-wrap:wrap; gap:1rem; border-bottom: var(--border); padding-bottom:1.25rem;">
        <h2 style="font-family:var(--font-display); font-size:2.25rem; margin:0;">Upcoming Workshops</h2>
        <a href="<?php echo esc_url(get_post_type_archive_link('sdws_workshop') ?: home_url('/workshops/')); ?>" style="font-size:0.875rem; font-weight:500; letter-spacing:0.06em; text-transform:uppercase; color:#000; text-decoration:none; border-bottom:1px solid #000;">
          View All Workshops →
        </a>
      </div>
      <?php
      $workshops = new WP_Query(array(
        'post_type'      => 'sdws_workshop',
        'posts_per_page' => 3,
        'orderby'        => 'meta_value',
        'meta_key'       => 'workshop_date_start',
        'order'          => 'ASC',
      ));
      ?>
      <?php if ($workshops->have_posts()) : ?>
        <div class="sdws-grid-3">
          <?php while ($workshops->have_posts()) : $workshops->the_post(); ?>
            <?php get_template_part('template-parts/sdws/sdws-card'); ?>
          <?php endwhile; ?>
        </div>
        <?php wp_reset_postdata(); ?>
      <?php else : ?>
        <p style="color:#000; opacity:0.5;">Workshop listings coming soon.</p>
      <?php endif; ?>
    </div>
  </section>

</main>

<?php get_footer(); ?>