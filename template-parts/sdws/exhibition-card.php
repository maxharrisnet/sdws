<?php

/**
 * SDWS Exhibition card template part.
 * Used in: page-schedule.php, archive-sdws_exhibition.php
 *
 * @package Starter_Coat
 */

$show_start   = function_exists('get_field') ? get_field('exhibition_show_dates_start') : get_post_meta(get_the_ID(), 'exhibition_show_dates_start', true);
$show_end     = function_exists('get_field') ? get_field('exhibition_show_dates_end')   : get_post_meta(get_the_ID(), 'exhibition_show_dates_end', true);
$juror        = function_exists('get_field') ? get_field('exhibition_juror')             : get_post_meta(get_the_ID(), 'exhibition_juror', true);
$entry_open   = function_exists('get_field') ? get_field('exhibition_online_entry_date') : get_post_meta(get_the_ID(), 'exhibition_online_entry_date', true);
$entry_close  = function_exists('get_field') ? get_field('exhibition_entry_day')         : get_post_meta(get_the_ID(), 'exhibition_entry_day', true);
$jury_date    = function_exists('get_field') ? get_field('exhibition_jury_date')         : get_post_meta(get_the_ID(), 'exhibition_jury_date', true);
$reception    = function_exists('get_field') ? get_field('exhibition_reception_date')    : get_post_meta(get_the_ID(), 'exhibition_reception_date', true);
$notes        = function_exists('get_field') ? get_field('exhibition_notes')             : get_post_meta(get_the_ID(), 'exhibition_notes', true);
$prospectus   = function_exists('get_field') ? get_field('exhibition_prospectus_link')   : get_post_meta(get_the_ID(), 'exhibition_prospectus_link', true);

// Format date display
function sdws_fmt_date($date_str) {
  if (!$date_str) return '';
  return date('F j, Y', strtotime($date_str));
}

$show_dates_label = '';
if ($show_start) {
  $show_dates_label = sdws_fmt_date($show_start);
  if ($show_end) {
    $show_dates_label .= ' – ' . sdws_fmt_date($show_end);
  }
}
?>

<div class="sdws-exhibition-card">
  <h2 class="sdws-exhibition-card__title">
    <a href="<?php the_permalink(); ?>" style="text-decoration:none; color:#000;"><?php the_title(); ?></a>
  </h2>

  <?php if ($show_dates_label) : ?>
    <p class="sdws-exhibition-card__dates"><?php echo esc_html($show_dates_label); ?></p>
  <?php endif; ?>

  <?php
  // Build key dates list — only rows where we have a value
  $key_dates = array();
  if ($juror)       $key_dates['Juror']              = $juror;
  if ($entry_open)  $key_dates['Online Entry Opens']  = sdws_fmt_date($entry_open);
  if ($entry_close) $key_dates['Entry Deadline']      = sdws_fmt_date($entry_close);
  if ($jury_date)   $key_dates['Jury Date']           = sdws_fmt_date($jury_date);
  if ($reception)   $key_dates['Opening Reception']   = sdws_fmt_date($reception);

  if ($key_dates) :
  ?>
    <dl class="sdws-exhibition-card__key-dates">
      <?php foreach ($key_dates as $label => $value) : ?>
        <dt><?php echo esc_html($label); ?></dt>
        <dd style="margin:0;"><?php echo esc_html($value); ?></dd>
      <?php endforeach; ?>
    </dl>
  <?php endif; ?>

  <?php if ($notes) : ?>
    <div class="sdws-exhibition-card__notes">
      <?php echo wp_kses_post($notes); ?>
    </div>
  <?php endif; ?>

  <?php if ($prospectus) : ?>
    <p style="margin-top:1rem;">
      <a href="<?php echo esc_url($prospectus); ?>" target="_blank" rel="noopener" class="sdws-btn sdws-btn--outline" style="font-size:0.875rem; padding:0.625rem 1.25rem;">
        Download Prospectus (PDF)
      </a>
    </p>
  <?php endif; ?>
</div>
