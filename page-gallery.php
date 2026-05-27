<?php

/**
 * Gallery page template — San Diego Watercolor Society
 * Applies automatically to any page with slug "gallery".
 *
 * Images are managed at: WP Admin > Pages > Home (front page) > Gallery Strip tab
 *
 * @package Starter_Coat
 */

get_header();

$front_page_id  = (int) get_option('page_on_front');
$has_acf        = function_exists('get_field');

$gallery_label   = $has_acf && $front_page_id ? (get_field('home_gallery_label',   $front_page_id) ?: 'Member Gallery') : 'Member Gallery';
$gallery_caption = $has_acf && $front_page_id ? (get_field('home_gallery_caption', $front_page_id) ?: '') : '';
$gallery_images  = $has_acf && $front_page_id ? (get_field('home_gallery_images',  $front_page_id) ?: array()) : array();
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
      <h1 class="sdws-page-title"><?php echo esc_html($gallery_label); ?></h1>
      <?php if ($gallery_caption) : ?>
        <p class="sdws-gallery-page__caption"><?php echo esc_html($gallery_caption); ?></p>
      <?php endif; ?>
    </div>
  </section>

  <!-- Gallery grid -->
  <section class="sdws-gallery-page-section">
    <?php if (!empty($gallery_images)) : ?>
      <div class="sdws-gallery-page-grid">
        <?php foreach ($gallery_images as $gi => $img_id) :
          $img_id   = (int) $img_id;
          $full_src = wp_get_attachment_image_src($img_id, 'large');
          $full_url = $full_src ? $full_src[0] : '';
          $alt      = get_post_meta($img_id, '_wp_attachment_image_alt', true) ?: '';
        ?>
          <div class="sdws-gallery-grid__item" data-gallery-index="<?php echo (int) $gi; ?>">
            <a class="sdws-gallery-grid__link" href="<?php echo esc_url($full_url); ?>"
               data-lightbox="gallery"
               data-lightbox-alt="<?php echo esc_attr($alt); ?>">
              <?php echo wp_get_attachment_image($img_id, 'sc-profile-square-lg', false, array(
                'class'    => 'sdws-img-crop sdws-img-square',
                'alt'      => $alt,
                'loading'  => $gi < 12 ? 'eager' : 'lazy',
                'decoding' => 'async',
                'sizes'    => '(min-width: 1200px) 14vw, (min-width: 768px) 20vw, 33vw',
              )); ?>
            </a>
          </div>
        <?php endforeach; ?>
      </div>
    <?php else : ?>
      <div class="sdws-container">
        <p class="sdws-empty-state">Gallery images coming soon.</p>
      </div>
    <?php endif; ?>
  </section>

</main>

<?php get_footer(); ?>
