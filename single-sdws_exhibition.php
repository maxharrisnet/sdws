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
  $awards_text      = function_exists('get_field') ? get_field('exhibition_awards_text')        : get_post_meta(get_the_ID(), 'exhibition_awards_text', true);
  $juror            = function_exists('get_field') ? get_field('exhibition_juror')              : get_post_meta(get_the_ID(), 'exhibition_juror', true);
  $juror_role       = function_exists('get_field') ? get_field('exhibition_juror_role')         : get_post_meta(get_the_ID(), 'exhibition_juror_role', true);
  $juror_bio        = function_exists('get_field') ? get_field('exhibition_juror_bio')          : get_post_meta(get_the_ID(), 'exhibition_juror_bio', true);
  $juror_image      = function_exists('get_field') ? get_field('exhibition_juror_image')        : false;
  $entry_open       = function_exists('get_field') ? get_field('exhibition_online_entry_date')  : get_post_meta(get_the_ID(), 'exhibition_online_entry_date', true);
  $entry_close      = function_exists('get_field') ? get_field('exhibition_entry_day')          : get_post_meta(get_the_ID(), 'exhibition_entry_day', true);
  $jury_date        = function_exists('get_field') ? get_field('exhibition_jury_date')          : get_post_meta(get_the_ID(), 'exhibition_jury_date', true);
  $notify_date      = function_exists('get_field') ? get_field('exhibition_notification_date')  : get_post_meta(get_the_ID(), 'exhibition_notification_date', true);
  $delivery_date    = function_exists('get_field') ? get_field('exhibition_delivery_date')      : get_post_meta(get_the_ID(), 'exhibition_delivery_date', true);
  $reception        = function_exists('get_field') ? get_field('exhibition_reception_date')     : get_post_meta(get_the_ID(), 'exhibition_reception_date', true);
  $notes            = function_exists('get_field') ? get_field('exhibition_notes')              : get_post_meta(get_the_ID(), 'exhibition_notes', true);
  $buttons          = function_exists('get_field') ? get_field('exhibition_buttons')            : array();

  if (!function_exists('sdws_fmt_date')) {
    function sdws_fmt_date($date_str)
    {
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
  if ($entry_open)    $key_dates['Online Entry Opens']        = sdws_fmt_date($entry_open);
  if ($entry_close)   $key_dates['Entry Deadline']            = sdws_fmt_date($entry_close);
  if ($jury_date)     $key_dates['Jury Date']                 = sdws_fmt_date($jury_date);
  if ($notify_date)   $key_dates['Notification of Results']   = sdws_fmt_date($notify_date);
  if ($delivery_date) $key_dates['Delivery of Accepted Work'] = sdws_fmt_date($delivery_date);
  if ($show_start)    $key_dates['Exhibition Opens']          = sdws_fmt_date($show_start);
  if ($reception)     $key_dates['Opening Reception']         = sdws_fmt_date($reception);
  if ($show_end)      $key_dates['Exhibition Closes']         = sdws_fmt_date($show_end);

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
          <p style="font-size:1.25rem; color:#fff; font-weight:500; margin:0 0 0.5rem;">
            <?php echo esc_html($show_dates_label); ?>
          </p>
        <?php endif; ?>
        <?php if ($awards_text) : ?>
          <p style="font-size:1rem; color:#fff; margin:0 0 2rem;">
            <?php echo esc_html($awards_text); ?>
          </p>
        <?php elseif ($show_dates_label) : ?>
          <div style="margin-bottom:2rem;"></div>
        <?php endif; ?>
        <?php if (!empty($buttons)) : ?>
          <div style="display:flex; gap:1rem; flex-wrap:wrap; margin-bottom:2rem;">
            <?php foreach ($buttons as $btn) :
              if (empty($btn['url']) || empty($btn['label'])) continue; ?>
              <a href="<?php echo esc_url($btn['url']); ?>" target="_blank" rel="noopener" class="sdws-btn sdws-btn--white">
                <?php echo esc_html($btn['label']); ?>
              </a>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
        <a href="<?php echo esc_url(home_url('/schedule/')); ?>" style="font-size:0.875rem; color:#fff; opacity:0.7; text-decoration:none; border-bottom:1px solid rgba(255,255,255,0.4); padding-bottom:1px;">
          ← All Exhibitions
        </a>
      </div>
    </section>


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
          <h2 style="font-family:var(--font-display); font-size:2rem; margin:0 0 2rem; color:#000;">Juror</h2>
          <div style="display:grid; grid-template-columns:<?php echo $juror_image ? '200px 1fr' : '1fr'; ?>; gap:2.5rem; align-items:start;">
            <?php if ($juror_image) : ?>
              <img src="<?php echo esc_url($juror_image['url']); ?>"
                alt="<?php echo esc_attr($juror_image['alt'] ?: $juror); ?>"
                style="width:100%; display:block; object-fit:cover;">
            <?php endif; ?>
            <div>
              <h3 style="font-size:1.75rem; margin:0 0 0.25rem; color:#000;"><?php echo esc_html($juror); ?></h3>
              <?php if ($juror_role) : ?>
                <p style="font-size:0.875rem; letter-spacing:0.08em; text-transform:uppercase; font-weight:500; margin:0 0 1.25rem; color:#000;"><?php echo esc_html($juror_role); ?></p>
              <?php endif; ?>
              <?php if ($juror_bio) : ?>
                <div style="font-size:1rem; line-height:1.75; color:#000;"><?php echo wp_kses_post($juror_bio); ?></div>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </section>
    <?php endif; ?>

  </main>

<?php
endwhile;
get_footer();
?>