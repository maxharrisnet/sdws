<?php

/**
 * Template Name: Artist Profile Page
 *
 * @package Starter_Coat
 */

if (! defined('ABSPATH')) {
  exit;
}

get_header();
?>

<main id="primary" class="site-main section section--lg artist-profile-page">
  <?php while (have_posts()) : the_post(); ?>
    <?php
    $post_id       = get_the_ID();
    $parent_id     = wp_get_post_parent_id($post_id);
    $parent_title  = $parent_id ? get_the_title($parent_id) : '';
    $parent_url    = $parent_id ? get_permalink($parent_id) : '';

    $read_inline_meta = static function ($content, $label) {
      $pattern = '/\b' . preg_quote($label, '/') . ':\s*<\/strong>\s*([^<]+)/i';

      if (is_string($content) && preg_match($pattern, $content, $matches)) {
        return trim(wp_strip_all_tags($matches[1]));
      }

      return '';
    };

    $profile_tier     = '';
    $profile_focus    = '';
    $profile_pronouns = '';
    $profile_location = '';
    $profile_cta      = null;
    $gallery_mode     = 'carousel';
    $gallery_columns  = 3;
    $gallery_images   = array();

    if (function_exists('get_field')) {
      $profile_tier     = (string) get_field('sc_artist_tier', $post_id);
      $profile_focus    = (string) get_field('sc_artist_focus', $post_id);
      $profile_pronouns = (string) get_field('sc_artist_pronouns', $post_id);
      $profile_location = (string) get_field('sc_artist_location', $post_id);
      $profile_cta      = get_field('sc_artist_cta_link', $post_id);
      $gallery_mode     = sanitize_key((string) get_field('sc_artist_gallery_mode', $post_id));
      $gallery_columns  = (int) get_field('sc_artist_gallery_columns', $post_id);
      $gallery_images   = get_field('sc_artist_gallery_images', $post_id);

      // Backward compatibility with older local field names.
      if ($profile_focus === '') {
        $profile_focus = (string) get_field('sc_profile_focus', $post_id);
      }
      if ($profile_pronouns === '') {
        $profile_pronouns = (string) get_field('sc_profile_pronouns', $post_id);
      }
      if ($profile_location === '') {
        $profile_location = (string) get_field('sc_profile_location', $post_id);
      }
    }

    if ($profile_tier === '') {
      $profile_tier = (string) get_post_meta($post_id, 'profile_tier', true);
    }

    if ($profile_tier === '') {
      $profile_tier = $read_inline_meta((string) get_post_field('post_content', $post_id), 'Category');
    }

    if ($profile_focus === '') {
      $profile_focus = $read_inline_meta((string) get_post_field('post_content', $post_id), 'Focus');
    }

    if (! in_array($gallery_mode, array('carousel', 'carousel_thumbs', 'inline', 'modal'), true)) {
      $gallery_mode = 'carousel';
    }

    if ($gallery_columns < 2 || $gallery_columns > 4) {
      $gallery_columns = 3;
    }

    if (! is_array($gallery_images)) {
      $gallery_images = array();
    }

    $gallery_image_ids = array();
    foreach ($gallery_images as $gallery_image) {
      if (is_numeric($gallery_image)) {
        $gallery_image_ids[] = (int) $gallery_image;
        continue;
      }

      if (is_array($gallery_image) && isset($gallery_image['ID'])) {
        $gallery_image_ids[] = (int) $gallery_image['ID'];
      }
    }

    $gallery_image_ids = array_values(array_filter(array_unique($gallery_image_ids)));

    $avatar_letter = strtoupper(substr((string) get_the_title($post_id), 0, 1));
    ?>

    <?php starter_coat_render_singular_hero($post_id); ?>

    <div class="container container--narrow">
      <article <?php post_class('artist-profile'); ?>>
        <header class="artist-profile__header artist-profile__header--sticky">
          <div class="artist-profile__head-main">
            <div class="artist-profile__avatar-wrap" aria-hidden="true">
              <?php if (has_post_thumbnail()) : ?>
                <?php echo get_the_post_thumbnail($post_id, 'thumbnail', array('class' => 'artist-profile__avatar')); ?>
              <?php else : ?>
                <span class="artist-profile__avatar artist-profile__avatar--fallback"><?php echo esc_html($avatar_letter); ?></span>
              <?php endif; ?>
            </div>

            <div class="artist-profile__heading">
              <?php if (! empty($parent_url) && ! empty($parent_title)) : ?>
                <a class="artist-profile__back" href="<?php echo esc_url($parent_url); ?>">
                  <?php echo esc_html__('Back to ', 'starter-coat') . esc_html($parent_title); ?>
                </a>
              <?php endif; ?>

              <?php if (! starter_coat_has_singular_hero($post_id)) : ?>
                <h1 class="artist-profile__title"><?php the_title(); ?></h1>
              <?php else : ?>
                <p class="artist-profile__title artist-profile__title--compact"><?php the_title(); ?></p>
              <?php endif; ?>

              <div class="artist-profile__meta" aria-label="<?php esc_attr_e('Profile details', 'starter-coat'); ?>">
                <?php if (! empty($profile_tier)) : ?>
                  <span class="artist-profile__meta-item"><strong><?php esc_html_e('Tier:', 'starter-coat'); ?></strong> <?php echo esc_html($profile_tier); ?></span>
                <?php endif; ?>
                <?php if (! empty($profile_focus)) : ?>
                  <span class="artist-profile__meta-item"><strong><?php esc_html_e('Focus:', 'starter-coat'); ?></strong> <?php echo esc_html($profile_focus); ?></span>
                <?php endif; ?>
                <?php if (! empty($profile_pronouns)) : ?>
                  <span class="artist-profile__meta-item"><strong><?php esc_html_e('Pronouns:', 'starter-coat'); ?></strong> <?php echo esc_html($profile_pronouns); ?></span>
                <?php endif; ?>
                <?php if (! empty($profile_location)) : ?>
                  <span class="artist-profile__meta-item"><strong><?php esc_html_e('Location:', 'starter-coat'); ?></strong> <?php echo esc_html($profile_location); ?></span>
                <?php endif; ?>
              </div>
            </div>
          </div>

          <?php if (is_array($profile_cta) && ! empty($profile_cta['url']) && ! empty($profile_cta['title'])) : ?>
            <div class="artist-profile__actions">
              <a class="btn btn--primary btn--sm" href="<?php echo esc_url((string) $profile_cta['url']); ?>" <?php echo ! empty($profile_cta['target']) ? 'target="' . esc_attr((string) $profile_cta['target']) . '" rel="noopener"' : ''; ?>>
                <?php echo esc_html((string) $profile_cta['title']); ?>
              </a>
            </div>
          <?php endif; ?>
        </header>

        <div class="artist-profile__body">
          <?php if (has_post_thumbnail()) : ?>
            <figure class="artist-profile__image-wrap">
              <?php the_post_thumbnail('large', array('class' => 'artist-profile__image')); ?>
            </figure>
          <?php endif; ?>

          <div class="artist-profile__content entry-content">
            <?php the_content(); ?>
          </div>

          <?php if (! empty($gallery_image_ids)) : ?>
            <section class="artist-gallery artist-gallery--<?php echo esc_attr($gallery_mode); ?>" aria-label="<?php esc_attr_e('Artist gallery', 'starter-coat'); ?>">
              <h2 class="artist-gallery__title"><?php esc_html_e('Gallery', 'starter-coat'); ?></h2>

              <?php if ('carousel' === $gallery_mode || 'carousel_thumbs' === $gallery_mode) : ?>
                <div id="artist-gallery-<?php echo esc_attr((string) $post_id); ?>" class="c-carousel c-carousel--single artist-gallery__carousel" data-carousel style="--slides-per-view-desktop: 1;">
                  <div class="c-carousel__viewport" data-carousel-viewport>
                    <div class="c-carousel__track" data-carousel-track>
                      <?php foreach ($gallery_image_ids as $image_id) : ?>
                        <div class="c-carousel__slide" data-carousel-slide>
                          <figure class="artist-gallery__slide-media">
                            <?php echo wp_get_attachment_image($image_id, 'large'); ?>
                          </figure>
                        </div>
                      <?php endforeach; ?>
                    </div>
                  </div>

                  <?php if (count($gallery_image_ids) > 1) : ?>
                    <div class="c-carousel__controls">
                      <button type="button" class="c-carousel__arrow c-carousel__arrow--prev" data-carousel-prev aria-label="<?php esc_attr_e('Previous slide', 'starter-coat'); ?>">
                        <?php starter_coat_the_icon('icon-chevron-up', array('class' => 'c-carousel__arrow-icon')); ?>
                      </button>
                      <button type="button" class="c-carousel__arrow c-carousel__arrow--next" data-carousel-next aria-label="<?php esc_attr_e('Next slide', 'starter-coat'); ?>">
                        <?php starter_coat_the_icon('icon-chevron-up', array('class' => 'c-carousel__arrow-icon')); ?>
                      </button>
                    </div>

                    <div class="c-carousel__dots" data-carousel-dots aria-label="<?php esc_attr_e('Slide navigation', 'starter-coat'); ?>">
                      <?php foreach ($gallery_image_ids as $index => $unused_gallery_item) : ?>
                        <?php
                        /* translators: %d: Slide number. */
                        $slide_label = sprintf(__('Go to slide %d', 'starter-coat'), $index + 1);
                        ?>
                        <button
                          type="button"
                          class="c-carousel__dot"
                          data-carousel-dot
                          data-slide-index="<?php echo esc_attr((string) $index); ?>"
                          aria-label="<?php echo esc_attr($slide_label); ?>"
                          aria-current="<?php echo 0 === $index ? 'true' : 'false'; ?>"></button>
                      <?php endforeach; ?>
                    </div>
                  <?php endif; ?>

                  <?php if ('carousel_thumbs' === $gallery_mode) : ?>
                    <div class="artist-gallery__thumbs artist-gallery__thumbs--cols-<?php echo esc_attr((string) $gallery_columns); ?>">
                      <?php foreach ($gallery_image_ids as $index => $image_id) : ?>
                        <?php
                        /* translators: %d: Image number. */
                        $thumb_label = sprintf(__('Go to image %d', 'starter-coat'), $index + 1);
                        ?>
                        <button
                          type="button"
                          class="artist-gallery__thumb c-carousel__dot"
                          data-carousel-dot
                          data-slide-index="<?php echo esc_attr((string) $index); ?>"
                          aria-label="<?php echo esc_attr($thumb_label); ?>"
                          aria-current="<?php echo 0 === $index ? 'true' : 'false'; ?>">
                          <?php echo wp_get_attachment_image($image_id, 'thumbnail'); ?>
                        </button>
                      <?php endforeach; ?>
                    </div>
                  <?php endif; ?>
                </div>
              <?php else : ?>
                <div class="artist-gallery__grid artist-gallery__grid--cols-<?php echo esc_attr((string) $gallery_columns); ?>">
                  <?php foreach ($gallery_image_ids as $index => $image_id) : ?>
                    <?php if ('modal' === $gallery_mode) : ?>
                      <?php
                      /* translators: %d: Image number. */
                      $modal_label = sprintf(__('Open image %d', 'starter-coat'), $index + 1);
                      ?>
                      <a
                        href="#"
                        class="artist-gallery__modal-trigger"
                        data-modal-target="#artist-gallery-modal-<?php echo esc_attr((string) $post_id . '-' . $index); ?>"
                        aria-label="<?php echo esc_attr($modal_label); ?>">
                        <?php echo wp_get_attachment_image($image_id, 'medium_large'); ?>
                      </a>
                      <div id="artist-gallery-modal-<?php echo esc_attr((string) $post_id . '-' . $index); ?>" class="modal artist-gallery__modal" role="dialog" aria-modal="true" aria-label="<?php esc_attr_e('Gallery image', 'starter-coat'); ?>">
                        <div class="modal__dialog artist-gallery__modal-dialog">
                          <button type="button" class="modal__close btn btn--ghost btn--sm" data-modal-close><?php esc_html_e('Close', 'starter-coat'); ?></button>
                          <div class="artist-gallery__modal-media">
                            <?php echo wp_get_attachment_image($image_id, 'large'); ?>
                          </div>
                        </div>
                      </div>
                    <?php else : ?>
                      <figure class="artist-gallery__inline-item">
                        <?php echo wp_get_attachment_image($image_id, 'medium_large'); ?>
                      </figure>
                    <?php endif; ?>
                  <?php endforeach; ?>
                </div>
              <?php endif; ?>
            </section>
          <?php endif; ?>
        </div>
      </article>
    </div>
  <?php endwhile; ?>
</main>

<?php
get_footer();
