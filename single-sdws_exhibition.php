<?php

/**
 * Single exhibition template — San Diego Watercolor Society
 *
 * @package Starter_Coat
 */

get_header();

while (have_posts()) : the_post();

  $gf              = function_exists('get_field');
  $show_start      = $gf ? get_field('exhibition_show_dates_start')  : get_post_meta(get_the_ID(), 'exhibition_show_dates_start', true);
  $show_end        = $gf ? get_field('exhibition_show_dates_end')    : get_post_meta(get_the_ID(), 'exhibition_show_dates_end', true);
  $awards_text     = $gf ? get_field('exhibition_awards_text')       : get_post_meta(get_the_ID(), 'exhibition_awards_text', true);
  $juror           = $gf ? get_field('exhibition_juror')             : get_post_meta(get_the_ID(), 'exhibition_juror', true);
  $juror_role      = $gf ? get_field('exhibition_juror_role')        : get_post_meta(get_the_ID(), 'exhibition_juror_role', true);
  $juror_bio       = $gf ? get_field('exhibition_juror_bio')         : get_post_meta(get_the_ID(), 'exhibition_juror_bio', true);
  $juror_image     = $gf ? get_field('exhibition_juror_image')       : false;
  $entry_open      = $gf ? get_field('exhibition_online_entry_date') : get_post_meta(get_the_ID(), 'exhibition_online_entry_date', true);
  $entry_close     = $gf ? get_field('exhibition_entry_day')         : get_post_meta(get_the_ID(), 'exhibition_entry_day', true);
  $jury_date       = $gf ? get_field('exhibition_jury_date')         : get_post_meta(get_the_ID(), 'exhibition_jury_date', true);
  $notify_date     = $gf ? get_field('exhibition_notification_date') : get_post_meta(get_the_ID(), 'exhibition_notification_date', true);
  $delivery_date   = $gf ? get_field('exhibition_delivery_date')     : get_post_meta(get_the_ID(), 'exhibition_delivery_date', true);
  $reception       = $gf ? get_field('exhibition_reception_date')    : get_post_meta(get_the_ID(), 'exhibition_reception_date', true);
  $notes           = $gf ? get_field('exhibition_notes')             : get_post_meta(get_the_ID(), 'exhibition_notes', true);
  $buttons         = $gf ? (get_field('exhibition_buttons') ?: array()) : array();

  if (!function_exists('sdws_fmt_date')) {
    function sdws_fmt_date($date_str) {
      return $date_str ? date('F j, Y', strtotime($date_str)) : '';
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

  $terms      = get_the_terms(get_the_ID(), 'exhibition_type');
  $type_label = ($terms && !is_wp_error($terms)) ? ucwords(str_replace('-', ' ', $terms[0]->slug)) : 'Exhibition';

  $cta_btn_primary   = !empty($buttons[0]) ? array('title' => $buttons[0]['label'], 'url' => $buttons[0]['url'], 'target' => '_blank') : array();
  $cta_btn_secondary = !empty($buttons[1]) ? array('title' => $buttons[1]['label'], 'url' => $buttons[1]['url'], 'target' => '_blank') : array();
?>

  <main id="primary" class="site-main">

    <!-- Hero -->
    <section class="sdws-section sdws-section--teal sdws-section--bordered-bottom">
      <div class="sdws-container">
        <nav class="sdws-breadcrumb" aria-label="Breadcrumb">
          <ol class="sdws-breadcrumb__list">
            <li class="sdws-breadcrumb__item">
              <a href="<?php echo esc_url(home_url('/schedule/')); ?>">Exhibitions</a>
            </li>
            <?php if ($terms && !is_wp_error($terms)) : ?>
              <li class="sdws-breadcrumb__item">
                <?php echo esc_html($type_label); ?>
              </li>
            <?php endif; ?>
          </ol>
        </nav>
        <h1 class="sdws-page-title"><?php the_title(); ?></h1>
        <?php if ($show_dates_label) : ?>
          <p class="sdws-exhibition-dates"><?php echo esc_html($show_dates_label); ?></p>
        <?php endif; ?>
        <?php if ($awards_text) : ?>
          <p class="sdws-exhibition-awards"><?php echo esc_html($awards_text); ?></p>
        <?php endif; ?>
        <div class="sdws-exhibition-hero__actions">
          <a href="#register" class="sdws-btn sdws-btn--white">Register / Enter</a>
          <?php foreach ($buttons as $btn) :
            if (empty($btn['url']) || empty($btn['label'])) continue; ?>
            <a href="<?php echo esc_url($btn['url']); ?>" target="_blank" rel="noopener" class="sdws-btn sdws-btn--white sdws-btn--white-outline">
              <?php echo esc_html($btn['label']); ?>
            </a>
          <?php endforeach; ?>
        </div>
      </div>
    </section>

    <!-- Content / notes -->
    <?php if (get_the_content() || $notes) : ?>
      <section class="sdws-section sdws-section--bordered-bottom">
        <div class="sdws-container">
          <?php if (get_the_content()) : ?>
            <div class="sdws-exhibition-content">
              <?php the_content(); ?>
            </div>
          <?php endif; ?>
          <?php if ($notes) : ?>
            <div class="sdws-exhibition-content<?php echo get_the_content() ? ' sdws-exhibition-content--spaced' : ''; ?>">
              <?php echo wp_kses_post($notes); ?>
            </div>
          <?php endif; ?>
        </div>
      </section>
    <?php endif; ?>

    <!-- Key dates -->
    <?php if ($key_dates) : ?>
      <section class="sdws-section sdws-section--off-white sdws-section--bordered-bottom">
        <div class="sdws-container">
          <h2 class="sdws-section-heading">Key Dates</h2>
          <table class="sdws-dates-table">
            <tbody>
              <?php foreach ($key_dates as $label => $value) : ?>
                <tr>
                  <td class="sdws-dates-table__label"><?php echo esc_html($label); ?></td>
                  <td><?php echo esc_html($value); ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </section>
    <?php endif; ?>

    <!-- Juror -->
    <?php if ($juror) : ?>
      <section class="sdws-section sdws-section--bordered-bottom">
        <div class="sdws-container">
          <h2 class="sdws-section-heading">Juror</h2>
          <div class="sdws-juror<?php echo $juror_image ? ' sdws-juror--with-image' : ''; ?>">
            <?php if ($juror_image && !empty($juror_image['ID'])) : ?>
              <?php echo wp_get_attachment_image($juror_image['ID'], 'sc-profile-square-lg', false, array(
                'class'    => 'sdws-juror__image',
                'loading'  => 'lazy',
                'decoding' => 'async',
                'sizes'    => '(min-width: 768px) 200px, 40vw',
                'alt'      => $juror_image['alt'] ?: $juror,
              )); ?>
            <?php endif; ?>
            <div>
              <h3 class="sdws-juror__name"><?php echo esc_html($juror); ?></h3>
              <?php if ($juror_role) : ?>
                <p class="sdws-juror__role"><?php echo esc_html($juror_role); ?></p>
              <?php endif; ?>
              <?php if ($juror_bio) : ?>
                <div class="sdws-juror__bio"><?php echo wp_kses_post($juror_bio); ?></div>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </section>
    <?php endif; ?>

    <?php
    $page_cta = function_exists('starter_coat_get_page_cta_override') ? starter_coat_get_page_cta_override(get_the_ID()) : null;
    if ($page_cta === null || empty($page_cta['enabled'])) :
    ?>
    <!-- Register CTA (default — overridden per-page via CTA fields) -->
    <div id="register">
      <?php get_template_part('template-parts/components/cta', null, array(
        'cta' => array(
          'title'                  => 'Enter This Exhibition',
          'copy'                   => !$cta_btn_primary ? 'For registration information, email <a href="mailto:support@sdws.org">support@sdws.org</a>' : '',
          'button_primary'         => $cta_btn_primary,
          'button_primary_style'   => 'teal',
          'button_secondary'       => $cta_btn_secondary,
          'button_secondary_style' => 'outline',
        ),
      )); ?>
    </div>
    <?php endif; ?>

  </main>

<?php
endwhile;
get_footer();
?>
