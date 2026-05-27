<?php
/*
 * Template Name: Gallery
 */

/**
 * Gallery page template — San Diego Watercolor Society
 * Assign via WP Admin → Pages → [page] → Page Attributes → Template: Gallery
 *
 * Paintings are managed at: WP Admin → Paintings → Add New
 *
 * @package Starter_Coat
 */

get_header();

$has_acf = function_exists('get_field');

$content_above  = $has_acf ? (get_field('gallery_content_above') ?: '') : '';
$content_below  = $has_acf ? (get_field('gallery_content_below') ?: '') : '';
$page_title     = $has_acf ? (get_field('gallery_page_title')    ?: 'Gallery') : 'Gallery';
$page_caption   = $has_acf ? (get_field('gallery_page_caption')  ?: 'Works by SDWS members') : 'Works by SDWS members';
$paypal_email   = $has_acf ? (get_field('sdws_paypal_email', 'option') ?: '') : '';

$paintings = new WP_Query(array(
  'post_type'      => 'sdws_painting',
  'posts_per_page' => -1,
  'orderby'        => 'menu_order',
  'order'          => 'ASC',
  'post_status'    => 'publish',
));
?>

<main id="primary" class="site-main">

  <!-- Header -->
  <section class="sdws-section sdws-section--teal sdws-section--bordered-bottom">
    <div class="sdws-container">
      <nav class="sdws-breadcrumb" aria-label="Breadcrumb">
        <ol class="sdws-breadcrumb__list">
          <li class="sdws-breadcrumb__item">
            <a href="<?php echo esc_url(home_url('/')); ?>">Home</a>
          </li>
        </ol>
      </nav>
      <h1 class="sdws-page-title"><?php echo esc_html($page_title); ?></h1>
      <?php if ($page_caption) : ?>
        <p class="sdws-gallery-page__caption"><?php echo esc_html($page_caption); ?></p>
      <?php endif; ?>
    </div>
  </section>

  <!-- Content above -->
  <?php if ($content_above) : ?>
    <section class="sdws-section sdws-section--bordered-bottom">
      <div class="sdws-container">
        <div class="sdws-prose">
          <?php echo apply_filters('the_content', $content_above); ?>
        </div>
      </div>
    </section>
  <?php endif; ?>

  <!-- Gallery grid -->
  <section class="sdws-gallery-page-section sdws-section--bordered-bottom">
    <?php if ($paintings->have_posts()) : ?>
      <div class="sdws-container">
        <div class="sdws-gallery-page-grid" role="list" aria-label="<?php echo esc_attr($page_title); ?>">
          <?php
          $gi = 0;
          while ($paintings->have_posts()) : $paintings->the_post();
            $painting_id   = get_the_ID();
            $painting_title = get_the_title();
            $artist        = $has_acf ? (get_field('painting_artist',      $painting_id) ?: '') : '';
            $dimensions    = $has_acf ? (get_field('painting_dimensions',  $painting_id) ?: '') : '';
            $medium        = $has_acf ? (get_field('painting_medium',      $painting_id) ?: '') : '';
            $price         = $has_acf ? (get_field('painting_price',       $painting_id) ?: 0)  : 0;
            $description   = $has_acf ? (get_field('painting_description', $painting_id) ?: '') : '';
            $painting_url  = get_permalink($painting_id);
            $full_src      = get_the_post_thumbnail_url($painting_id, 'large');
            $full_url      = $full_src ?: '';
            $price_display = $price ? '$' . number_format(floatval($price), 0, '.', ',') : '';
          ?>
            <div class="sdws-gallery-grid__item" data-gallery-index="<?php echo (int) $gi; ?>" role="listitem">
              <a class="sdws-gallery-grid__link sdws-painting-card"
                 href="<?php echo esc_url($full_url ?: $painting_url); ?>"
                 data-lightbox="gallery"
                 data-lightbox-alt="<?php echo esc_attr($painting_title); ?>"
                 data-painting-title="<?php echo esc_attr($painting_title); ?>"
                 data-painting-artist="<?php echo esc_attr($artist); ?>"
                 data-painting-dimensions="<?php echo esc_attr($dimensions); ?>"
                 data-painting-medium="<?php echo esc_attr($medium); ?>"
                 data-painting-price="<?php echo esc_attr($price); ?>"
                 data-painting-description="<?php echo esc_attr($description); ?>"
                 data-painting-paypal-email="<?php echo esc_attr($paypal_email); ?>"
                 data-painting-url="<?php echo esc_url($painting_url); ?>"
                 aria-label="<?php echo esc_attr(sprintf('View %s', $painting_title)); ?>">

                <div class="sdws-painting-card__thumb">
                  <?php if (has_post_thumbnail($painting_id)) :
                    echo get_the_post_thumbnail($painting_id, 'sc-profile-square-lg', array(
                      'class'    => 'sdws-img-crop sdws-img-square',
                      'alt'      => '',
                      'loading'  => $gi < 14 ? 'eager' : 'lazy',
                      'decoding' => 'async',
                      'sizes'    => '(min-width: 1200px) 14vw, (min-width: 768px) 20vw, 33vw',
                    ));
                  else : ?>
                    <div class="sdws-painting-card__placeholder sdws-img-square"></div>
                  <?php endif; ?>

                  <div class="sdws-painting-overlay" aria-hidden="true">
                    <span class="sdws-painting-overlay__title"><?php echo esc_html($painting_title); ?></span>
                    <?php if ($price_display) : ?>
                      <span class="sdws-painting-overlay__price"><?php echo esc_html($price_display); ?></span>
                    <?php else : ?>
                      <span class="sdws-painting-overlay__price sdws-painting-overlay__price--contact">Contact for pricing</span>
                    <?php endif; ?>
                    <span class="sdws-painting-overlay__icon" aria-hidden="true">
                      <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="square" stroke-linejoin="miter" aria-hidden="true">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                        <circle cx="12" cy="12" r="3"/>
                      </svg>
                    </span>
                  </div>
                </div>

              </a>
            </div>
          <?php
            $gi++;
          endwhile;
          wp_reset_postdata();
          ?>
        </div>
      </div>
    <?php else : ?>
      <div class="sdws-container">
        <p class="sdws-empty-state">Gallery images coming soon.</p>
      </div>
    <?php endif; ?>
  </section>

  <!-- Content below -->
  <?php if ($content_below) : ?>
    <section class="sdws-section">
      <div class="sdws-container">
        <div class="sdws-prose">
          <?php echo wp_kses_post($content_below); ?>
        </div>
      </div>
    </section>
  <?php endif; ?>

</main>

<?php get_footer(); ?>
