<?php

/**
 * Single painting template — San Diego Watercolor Society
 *
 * @package Starter_Coat
 */

get_header();

while (have_posts()) : the_post();

  $gf           = function_exists('get_field');
  $artist       = $gf ? get_field('painting_artist')      : get_post_meta(get_the_ID(), 'painting_artist', true);
  $dimensions   = $gf ? get_field('painting_dimensions')  : get_post_meta(get_the_ID(), 'painting_dimensions', true);
  $medium       = $gf ? get_field('painting_medium')      : get_post_meta(get_the_ID(), 'painting_medium', true);
  $price        = $gf ? get_field('painting_price')       : get_post_meta(get_the_ID(), 'painting_price', true);
  $description  = $gf ? get_field('painting_description') : get_post_meta(get_the_ID(), 'painting_description', true);
  $paypal_client_id = $gf ? get_field('sdws_paypal_client_id', 'option') : '';
  $sold             = $gf ? (bool) get_field('painting_sold') : false;

  $gallery_url  = home_url('/gallery/');
?>

  <main id="primary" class="site-main">

    <section class="sdws-section sdws-painting-single">
      <div class="sdws-container">

        <nav class="sdws-breadcrumb" aria-label="Breadcrumb">
          <ol class="sdws-breadcrumb__list">
            <li class="sdws-breadcrumb__item">
              <a href="<?php echo esc_url($gallery_url); ?>">Gallery</a>
            </li>
            <li class="sdws-breadcrumb__item"><?php the_title(); ?></li>
          </ol>
        </nav>

        <div class="sdws-painting-single__layout">

          <!-- Image -->
          <div class="sdws-painting-single__image">
            <?php if (has_post_thumbnail()) : ?>
              <?php the_post_thumbnail('large', array(
                'class'   => 'sdws-img-crop',
                'loading' => 'eager',
                'fetchpriority' => 'high',
                'decoding' => 'async',
                'sizes'   => '(min-width: 1200px) 700px, (min-width: 768px) 55vw, 100vw',
                'alt'     => esc_attr(get_the_title()),
              )); ?>
            <?php endif; ?>
          </div>

          <!-- Details -->
          <div class="sdws-painting-single__details">

            <h1 class="sdws-painting-single__title"><?php the_title(); ?></h1>

            <?php if ($artist) : ?>
              <p class="sdws-painting-single__artist"><?php echo esc_html($artist); ?></p>
            <?php endif; ?>

            <?php if ($dimensions || $medium) : ?>
              <ul class="sdws-painting-single__meta">
                <?php if ($dimensions) : ?>
                  <li><?php echo esc_html($dimensions); ?></li>
                <?php endif; ?>
                <?php if ($medium) : ?>
                  <li><?php echo esc_html($medium); ?></li>
                <?php endif; ?>
              </ul>
            <?php endif; ?>

            <?php if ($description) : ?>
              <p class="sdws-painting-single__description"><?php echo esc_html($description); ?></p>
            <?php endif; ?>

            <?php if ($price) : ?>
              <p class="sdws-painting-price">$<?php echo esc_html(number_format(floatval($price), 0, '.', ',')); ?></p>
            <?php endif; ?>

            <?php get_template_part('template-parts/components/paypal-buy-btn', null, array(
              'price'           => $price,
              'title'           => get_the_title(),
              'artist'          => $artist,
              'paypal_client_id' => $paypal_client_id,
              'sold'            => $sold,
            )); ?>

            <a href="<?php echo esc_url($gallery_url); ?>" class="sdws-painting-single__back">
              &larr; Back to Gallery
            </a>

          </div><!-- .sdws-painting-single__details -->
        </div><!-- .sdws-painting-single__layout -->

      </div><!-- .sdws-container -->
    </section>

  </main>

<?php
endwhile;

get_footer();
