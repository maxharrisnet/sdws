<?php

/**
 * Single event template — San Diego Watercolor Society
 *
 * Loaded directly (bypassing the default page.php wrapper) via a
 * template_include filter in functions.php so we keep full-bleed section
 * control and avoid the entry-content width wrapper.
 *
 * @package Starter_Coat
 */

get_header();

while (have_posts()) : the_post();

  $event_id    = Tribe__Events__Main::postIdHelper(get_the_ID());
  $events_link = tribe_get_events_link();

  // Plain-text date/time string
  $schedule_txt = strip_tags(tribe_events_event_schedule_details($event_id, '', ''));
  $cost         = tribe_get_formatted_cost($event_id);

  // Notice HTML ("This event has passed", etc.)
  $notice_html = tribe_the_notices(false);

  // Category for breadcrumb
  $cats = get_the_terms(get_the_ID(), Tribe__Events__Main::TAXONOMY);
  $cat  = ($cats && !is_wp_error($cats)) ? $cats[0] : null;

?>

  <main id="primary" class="site-main">

    <!-- Header -->
    <section class="sdws-section sdws-section--bordered-bottom">
      <div class="sdws-container">

        <nav class="sdws-breadcrumb" aria-label="Breadcrumb">
          <ol class="sdws-breadcrumb__list">
            <li class="sdws-breadcrumb__item">
              <a href="<?php echo esc_url(home_url('/calendar/')); ?>">Calendar</a>
            </li>
            <?php if ($cat) : ?>
              <li class="sdws-breadcrumb__item"><?php echo esc_html($cat->name); ?></li>
            <?php endif; ?>
          </ol>
        </nav>

        <h1 class="sdws-page-title"><?php the_title(); ?></h1>

        <div class="sdws-workshop-meta">
          <?php if ($schedule_txt) : ?>
            <div class="sdws-workshop-meta__item">
              <span class="sdws-workshop-meta__label">Date &amp; Time</span>
              <?php echo esc_html($schedule_txt); ?>
            </div>
          <?php endif; ?>
          <?php if ($cost) : ?>
            <div class="sdws-workshop-meta__item">
              <span class="sdws-workshop-meta__label">Cost</span>
              <?php echo esc_html($cost); ?>
            </div>
          <?php endif; ?>
        </div>

        <?php if ($notice_html) : ?>
          <div class="sdws-tribe-notice"><?php echo wp_kses_post($notice_html); ?></div>
        <?php endif; ?>

      </div>
    </section>

    <!-- Content -->
    <section class="sdws-section">
      <div class="sdws-container">
        <div class="sdws-content-2-col<?php echo !has_post_thumbnail() ? ' sdws-content-2-col--no-image' : ''; ?>">

          <?php if (has_post_thumbnail()) : ?>
            <?php the_post_thumbnail('large', array(
              'class'    => 'sdws-workshop-featured-img',
              'loading'  => 'lazy',
              'decoding' => 'async',
              'sizes'    => '(min-width: 1200px) 560px, (min-width: 768px) 45vw, 100vw',
            )); ?>
          <?php endif; ?>

          <div class="sdws-workshop-content">
            <?php echo apply_filters('the_content', get_the_content()); ?>
            <div class="sdws-tribe-cal-widget">
              <?php do_action('tribe_events_single_event_after_the_content'); ?>
            </div>
          </div>

        </div>
      </div>
    </section>

    <!-- Venue / organizer -->
    <?php if (tribe_has_venue() || tribe_has_organizer()) : ?>
    <section class="sdws-section sdws-section--off-white sdws-section--bordered-bottom">
      <div class="sdws-container sdws-tribe-meta">
        <?php tribe_get_template_part('modules/meta'); ?>
      </div>
    </section>
    <?php endif; ?>

    <!-- Prev / Next navigation -->
    <section class="sdws-section sdws-section--bordered-bottom">
      <div class="sdws-container">
        <nav class="sdws-tribe-nav" aria-label="Event Navigation">
          <div class="sdws-tribe-nav__prev">
            <?php tribe_the_prev_event_link('<span class="sdws-tribe-nav__label">&larr; Previous Event</span><span class="sdws-tribe-nav__title">%title%</span>'); ?>
          </div>
          <div class="sdws-tribe-nav__next">
            <?php tribe_the_next_event_link('<span class="sdws-tribe-nav__label">Next Event &rarr;</span><span class="sdws-tribe-nav__title">%title%</span>'); ?>
          </div>
        </nav>
      </div>
    </section>

  </main>

<?php endwhile; ?>
<?php get_footer(); ?>
