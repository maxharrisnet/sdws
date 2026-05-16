<?php

/**
 * Single exhibition template — San Diego Watercolor Society
 *
 * @package Starter_Coat
 */

get_header();

while (have_posts()) : the_post();

$show_start  = function_exists('get_field') ? get_field('exhibition_show_dates_start')  : get_post_meta(get_the_ID(), 'exhibition_show_dates_start', true);
$show_end    = function_exists('get_field') ? get_field('exhibition_show_dates_end')    : get_post_meta(get_the_ID(), 'exhibition_show_dates_end', true);
$juror       = function_exists('get_field') ? get_field('exhibition_juror')              : get_post_meta(get_the_ID(), 'exhibition_juror', true);
$entry_open  = function_exists('get_field') ? get_field('exhibition_online_entry_date') : get_post_meta(get_the_ID(), 'exhibition_online_entry_date', true);
$entry_close = function_exists('get_field') ? get_field('exhibition_entry_day')         : get_post_meta(get_the_ID(), 'exhibition_entry_day', true);
$jury_date   = function_exists('get_field') ? get_field('exhibition_jury_date')         : get_post_meta(get_the_ID(), 'exhibition_jury_date', true);
$reception   = function_exists('get_field') ? get_field('exhibition_reception_date')    : get_post_meta(get_the_ID(), 'exhibition_reception_date', true);
$notes       = function_exists('get_field') ? get_field('exhibition_notes')              : get_post_meta(get_the_ID(), 'exhibition_notes', true);
$prospectus  = function_exists('get_field') ? get_field('exhibition_prospectus_link')   : get_post_meta(get_the_ID(), 'exhibition_prospectus_link', true);

if (!function_exists('sdws_fmt_date')) {
  function sdws_fmt_date($date_str) {
    if (!$date_str) return '';
    return date('F j, Y', strtotime($date_str));
  }
}

$show_dates_label = '';
if ($show_start) {
  $show_dates_label = sdws_fmt_date($show_start);
  if ($show_end) $show_dates_label .= ' – ' . sdws_fmt_date($show_end);
}

$key_dates = array();
if ($entry_open)  $key_dates['Online Entry Opens'] = sdws_fmt_date($entry_open);
if ($entry_close) $key_dates['Entry Deadline']     = sdws_fmt_date($entry_close);
if ($jury_date)   $key_dates['Jury Date']          = sdws_fmt_date($jury_date);
if ($show_start)  $key_dates['Exhibition Opens']   = sdws_fmt_date($show_start);
if ($reception)   $key_dates['Opening Reception']  = sdws_fmt_date($reception);
if ($show_end)    $key_dates['Exhibition Closes']  = sdws_fmt_date($show_end);

$terms = get_the_terms(get_the_ID(), 'exhibition_type');
$type_label = ($terms && !is_wp_error($terms)) ? ucwords(str_replace('-', ' ', $terms[0]->slug)) : 'Exhibition';

?>
<main id="primary" class="site-main">

  <!-- Hero -->
  <section class="sdws-section sdws-section--teal" style="border-bottom: 2px solid #000;">
    <div class="sdws-container">
      <p style="font-size:0.8125rem; letter-spacing:0.12em; text-transform:uppercase; font-weight:500; margin-bottom:1rem; color:#fff; opacity:0.8;">
        <?php echo esc_html($type_label); ?>
      </p>
      <h1 style="font-family:var(--font-display); font-size:clamp(2.5rem,5vw,4rem); color:#fff; margin:0 0 1rem; line-height:1.1;">
        <?php the_title(); ?>
      </h1>
      <?php if ($show_dates_label) : ?>
        <p style="font-size:1.25rem; color:#fff; font-weight:500; margin:0 0 2rem;">
          <?php echo esc_html($show_dates_label); ?>
        </p>
      <?php endif; ?>
      <a href="<?php echo esc_url(home_url('/schedule/')); ?>" style="font-size:0.875rem; color:#fff; opacity:0.7; text-decoration:none; border-bottom:1px solid rgba(255,255,255,0.4); padding-bottom:1px;">
        ← All Exhibitions
      </a>
    </div>
  </section>

  <!-- Key dates -->
  <?php if ($key_dates) : ?>
  <section class="sdws-section" style="background:var(--color-off-white); border-bottom:var(--border);">
    <div class="sdws-container">
      <h2 style="font-family:var(--font-display); font-size:2rem; margin:0 0 2rem; color:#000;">Key Dates</h2>
      <table style="width:100%; border-collapse:collapse; font-size:1rem;">
        <tbody>
          <?php foreach ($key_dates as $label => $value) : ?>
            <tr style="border-top:1px solid #000;">
              <td style="padding:0.875rem 1.5rem 0.875rem 0; font-weight:500; white-space:nowrap; vertical-align:top; color:#000; width:12rem;">
                <?php echo esc_html($label); ?>
              </td>
              <td style="padding:0.875rem 0; vertical-align:top; color:#000;">
                <?php echo esc_html($value); ?>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </section>
  <?php endif; ?>

  <!-- Juror -->
  <?php if ($juror) : ?>
  <section class="sdws-section" style="background:#fff; border-bottom:var(--border);">
    <div class="sdws-container">
      <h2 style="font-family:var(--font-display); font-size:2rem; margin:0 0 0.5rem; color:#000;">Juror</h2>
      <p style="font-size:1.125rem; color:#000; margin:0;"><?php echo esc_html($juror); ?></p>
    </div>
  </section>
  <?php endif; ?>

  <!-- Content / notes -->
  <?php if (get_the_content() || $notes) : ?>
  <section class="sdws-section" style="background:#fff; border-bottom:var(--border);">
    <div class="sdws-container">
      <?php if (get_the_content()) : ?>
        <div style="font-size:1.0625rem; line-height:1.8; color:#000;">
          <?php the_content(); ?>
        </div>
      <?php endif; ?>
      <?php if ($notes) : ?>
        <div style="font-size:1.0625rem; line-height:1.8; color:#000; <?php echo get_the_content() ? 'margin-top:1.5rem;' : ''; ?>">
          <?php echo wp_kses_post($notes); ?>
        </div>
      <?php endif; ?>
    </div>
  </section>
  <?php endif; ?>

  <!-- Prospectus -->
  <?php if ($prospectus) : ?>
  <section class="sdws-section" style="background:var(--color-off-white);">
    <div class="sdws-container">
      <a href="<?php echo esc_url($prospectus); ?>" target="_blank" rel="noopener" class="sdws-btn sdws-btn--outline">
        Download Prospectus (PDF)
      </a>
    </div>
  </section>
  <?php endif; ?>

</main>

<?php
endwhile;
get_footer();
?>
