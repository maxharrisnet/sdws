<?php

/**
 * Unified SDWS card template.
 * Auto-populates fields from the current post in the loop based on post type.
 * All values can be overridden via $args.
 *
 * Args:
 *   layout       (string)       — 'stacked' (default) or 'horizontal' (image left, body right)
 *   image_size   (string|false) — thumbnail size key, or false to skip image
 *   eyebrow      (string)
 *   title        (string)
 *   url          (string)
 *   meta         (string[])     — lines shown below the title
 *   excerpt      (string)
 *   buttons      (array[])      — each: ['label' => '', 'url' => '']
 *
 * @package Starter_Coat
 */

if (!function_exists('sdws_fmt_date')) {
  function sdws_fmt_date($date_str) {
    return $date_str ? date('F j, Y', strtotime($date_str)) : '';
  }
}

$post_type = get_post_type();

$layout     = isset($args['layout']) ? $args['layout'] : 'stacked';
$is_horiz   = 'horizontal' === $layout;

$image_size = array_key_exists('image_size', (array) $args) ? $args['image_size'] : ($is_horiz ? 'sc-profile-square-lg' : 'sc-card-header');
$eyebrow    = isset($args['eyebrow'])  ? $args['eyebrow']  : null;
$title      = isset($args['title'])    ? $args['title']    : get_the_title();
$url        = isset($args['url'])      ? $args['url']      : get_permalink();
$meta       = isset($args['meta'])     ? (array) $args['meta']    : null;
$excerpt    = isset($args['excerpt'])  ? $args['excerpt']  : null;
$buttons    = isset($args['buttons'])  ? (array) $args['buttons'] : null;

// Auto-populate workshop fields
if ('sdws_workshop' === $post_type) {
  if (null === $eyebrow) {
    $eyebrow = function_exists('get_field')
      ? get_field('workshop_instructor')
      : get_post_meta(get_the_ID(), 'workshop_instructor', true);
  }

  if (null === $meta) {
    $date_start = function_exists('get_field')
      ? get_field('workshop_date_start')
      : get_post_meta(get_the_ID(), 'workshop_date_start', true);
    $date_end   = function_exists('get_field')
      ? get_field('workshop_date_end')
      : get_post_meta(get_the_ID(), 'workshop_date_end', true);
    $price_mem  = function_exists('get_field')
      ? get_field('workshop_price_member')
      : get_post_meta(get_the_ID(), 'workshop_price_member', true);
    $price_non  = function_exists('get_field')
      ? get_field('workshop_price_nonmember')
      : get_post_meta(get_the_ID(), 'workshop_price_nonmember', true);

    $meta = array();
    if ($date_start) {
      $start_fmt = date('F j', strtotime($date_start));
      $end_fmt   = $date_end ? date('j, Y', strtotime($date_end)) : date('Y', strtotime($date_start));
      $meta[]    = $start_fmt . '–' . $end_fmt;
    }
    $prices = array();
    if ($price_mem) $prices[] = 'Member: $' . number_format((float) $price_mem);
    if ($price_non) $prices[] = 'Non-Member: $' . number_format((float) $price_non);
    if ($prices) $meta[] = implode('  ·  ', $prices);
  }

  if (null === $buttons) {
    $buttons = function_exists('get_field')
      ? (get_field('workshop_buttons') ?: array())
      : array();
  }
}

// Auto-populate exhibition fields
if ('sdws_exhibition' === $post_type) {
  if (null === $eyebrow) {
    $terms   = get_the_terms(get_the_ID(), 'exhibition_type');
    $eyebrow = ($terms && !is_wp_error($terms))
      ? ucwords(str_replace('-', ' ', $terms[0]->slug))
      : '';
  }

  if (null === $meta) {
    $show_start = function_exists('get_field')
      ? get_field('exhibition_show_dates_start')
      : get_post_meta(get_the_ID(), 'exhibition_show_dates_start', true);
    $show_end   = function_exists('get_field')
      ? get_field('exhibition_show_dates_end')
      : get_post_meta(get_the_ID(), 'exhibition_show_dates_end', true);
    $juror      = function_exists('get_field')
      ? get_field('exhibition_juror')
      : get_post_meta(get_the_ID(), 'exhibition_juror', true);

    $meta = array();
    if ($show_start) {
      $meta[] = sdws_fmt_date($show_start) . ($show_end ? ' – ' . sdws_fmt_date($show_end) : '');
    }
    if ($juror) $meta[] = 'Juror: ' . $juror;
  }

  if (null === $buttons) {
    $buttons = function_exists('get_field')
      ? (get_field('exhibition_buttons') ?: array())
      : array();
  }

  // Always show excerpt for exhibitions (auto-generates from content if no manual excerpt)
  if (null === $excerpt) {
    $excerpt = get_the_excerpt();
  }
}

// Fallback excerpt for other post types
if (null === $excerpt) {
  $excerpt = has_excerpt() ? get_the_excerpt() : '';
}

if (!$title) return;

$has_image   = false !== $image_size && has_post_thumbnail();
$has_ph      = false !== $image_size && !has_post_thumbnail();
$has_buttons = !empty($buttons);

$img_sizes = $is_horiz
  ? '(min-width: 768px) 240px, 100vw'
  : '(min-width: 1200px) 380px, (min-width: 768px) 45vw, 100vw';

$article_class = 'sdws-card' . ($is_horiz ? ' sdws-card--horizontal' : '');
?>
<article class="<?php echo esc_attr($article_class); ?>">

  <?php if ($is_horiz && ($has_image || $has_ph)) : ?>
    <div class="sdws-card__image-col">
      <?php if ($has_image) : ?>
        <?php the_post_thumbnail($image_size, array(
          'class'    => 'sdws-card__image',
          'loading'  => 'lazy',
          'decoding' => 'async',
          'sizes'    => $img_sizes,
        )); ?>
      <?php else : ?>
        <div class="sdws-card__placeholder"><span>Image Placeholder</span></div>
      <?php endif; ?>
    </div>
  <?php elseif ($has_image) : ?>
    <?php the_post_thumbnail($image_size, array(
      'class'    => 'sdws-card__image',
      'loading'  => 'lazy',
      'decoding' => 'async',
      'sizes'    => $img_sizes,
    )); ?>
  <?php elseif ($has_ph) : ?>
    <div class="sdws-card__image sdws-card__placeholder">
      <span>Image Placeholder</span>
    </div>
  <?php endif; ?>

  <div class="sdws-card__body">

    <?php if ($eyebrow) : ?>
      <p class="sdws-card__eyebrow"><?php echo esc_html($eyebrow); ?></p>
    <?php endif; ?>

    <h3 class="sdws-card__title">
      <a href="<?php echo esc_url($url); ?>"><?php echo esc_html($title); ?></a>
    </h3>

    <?php if (!empty($meta)) : ?>
      <ul class="sdws-card__meta">
        <?php foreach ($meta as $line) : if (!$line) continue; ?>
          <li><?php echo esc_html($line); ?></li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>

    <?php if ($excerpt) : ?>
      <div class="sdws-card__excerpt"><?php echo wp_kses_post($excerpt); ?></div>
    <?php endif; ?>

    <?php if ($has_buttons) : ?>
      <div class="sdws-card__buttons">
        <?php foreach ($buttons as $btn) :
          if (empty($btn['url']) || empty($btn['label'])) continue; ?>
          <a href="<?php echo esc_url($btn['url']); ?>" target="_blank" rel="noopener"
             class="sdws-btn sdws-btn--outline sdws-card__btn">
            <?php echo esc_html($btn['label']); ?>
          </a>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

  </div>
</article>
