<?php

/**
 * SDWS Workshop card template part.
 * Used in: front-page.php, page-workshops.php, archive-sdws_workshop.php
 *
 * @package Starter_Coat
 */

$instructor = function_exists('get_field') ? get_field('workshop_instructor') : get_post_meta(get_the_ID(), 'workshop_instructor', true);
$date_start = function_exists('get_field') ? get_field('workshop_date_start') : get_post_meta(get_the_ID(), 'workshop_date_start', true);
$date_end   = function_exists('get_field') ? get_field('workshop_date_end')   : get_post_meta(get_the_ID(), 'workshop_date_end', true);
$price_mem  = function_exists('get_field') ? get_field('workshop_price_member')    : get_post_meta(get_the_ID(), 'workshop_price_member', true);
$price_non  = function_exists('get_field') ? get_field('workshop_price_nonmember') : get_post_meta(get_the_ID(), 'workshop_price_nonmember', true);

// Format date display
$date_label = '';
if ($date_start) {
  $start_fmt = date('F j', strtotime($date_start));
  $end_fmt   = $date_end ? date('j, Y', strtotime($date_end)) : date('Y', strtotime($date_start));
  $date_label = $start_fmt . '–' . $end_fmt;
}
?>

<article class="sdws-workshop-card">
  <?php if (has_post_thumbnail()) : ?>
    <?php the_post_thumbnail('medium_large', array('class' => 'sdws-workshop-card__image', 'alt' => get_the_title())); ?>
  <?php else : ?>
    <div class="sdws-workshop-card__image" style="background:var(--color-sand); display:flex; align-items:center; justify-content:center; min-height:200px;">
      <span style="font-size:0.75rem; letter-spacing:0.08em; text-transform:uppercase; opacity:0.4;">Image Placeholder</span>
    </div>
  <?php endif; ?>

  <div class="sdws-workshop-card__body">
    <?php if ($instructor) : ?>
      <p class="sdws-workshop-card__instructor"><?php echo esc_html($instructor); ?></p>
    <?php endif; ?>

    <h3 class="sdws-workshop-card__title">
      <a href="<?php the_permalink(); ?>" style="text-decoration:none; color:#000;">
        <?php the_title(); ?>
      </a>
    </h3>

    <?php if ($date_label) : ?>
      <p class="sdws-workshop-card__date"><?php echo esc_html($date_label); ?></p>
    <?php endif; ?>

    <?php if ($price_mem || $price_non) : ?>
      <div class="sdws-workshop-card__prices">
        <?php if ($price_mem) : ?>
          <p style="margin:0 0 0.25rem; font-size:0.875rem;">
            <strong>Member:</strong> $<?php echo esc_html(number_format((float)$price_mem)); ?>
          </p>
        <?php endif; ?>
        <?php if ($price_non) : ?>
          <p style="margin:0; font-size:0.875rem;">
            <strong>Non-Member:</strong> $<?php echo esc_html(number_format((float)$price_non)); ?>
          </p>
        <?php endif; ?>
      </div>
    <?php endif; ?>
  </div>
</article>
