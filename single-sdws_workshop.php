<?php

/**
 * Single workshop template — San Diego Watercolor Society
 *
 * @package Starter_Coat
 */

get_header();

while (have_posts()) : the_post();

$instructor    = function_exists('get_field') ? get_field('workshop_instructor')      : get_post_meta(get_the_ID(), 'workshop_instructor', true);
$date_start    = function_exists('get_field') ? get_field('workshop_date_start')      : get_post_meta(get_the_ID(), 'workshop_date_start', true);
$date_end      = function_exists('get_field') ? get_field('workshop_date_end')        : get_post_meta(get_the_ID(), 'workshop_date_end', true);
$price_mem     = function_exists('get_field') ? get_field('workshop_price_member')    : get_post_meta(get_the_ID(), 'workshop_price_member', true);
$price_non     = function_exists('get_field') ? get_field('workshop_price_nonmember') : get_post_meta(get_the_ID(), 'workshop_price_nonmember', true);
$materials     = function_exists('get_field') ? get_field('workshop_materials_link')  : get_post_meta(get_the_ID(), 'workshop_materials_link', true);

$date_label = '';
if ($date_start) {
  $start_fmt  = date('F j', strtotime($date_start));
  $end_fmt    = $date_end ? date('j, Y', strtotime($date_end)) : date('Y', strtotime($date_start));
  $date_label = $start_fmt . '–' . $end_fmt;
}
?>

<main id="primary" class="site-main">
  <article style="max-width:var(--max-width); margin:0 auto; padding:0 2rem;">

    <!-- Header -->
    <section class="sdws-section" style="border-bottom: var(--border);">
      <?php if ($instructor) : ?>
        <p style="font-size:0.8125rem; letter-spacing:0.12em; text-transform:uppercase; font-weight:500; margin:0 0 0.75rem; color:#000;">
          <?php echo esc_html($instructor); ?>
        </p>
      <?php endif; ?>
      <h1 style="font-family:var(--font-display); font-size:clamp(2.25rem,5vw,3.75rem); margin:0 0 1rem; color:#000; max-width:820px;">
        <?php the_title(); ?>
      </h1>
      <div style="display:flex; gap:2.5rem; flex-wrap:wrap; font-size:0.9375rem; color:#000;">
        <?php if ($date_label) : ?>
          <span><strong>Date:</strong> <?php echo esc_html($date_label); ?></span>
        <?php endif; ?>
        <?php if ($price_mem) : ?>
          <span><strong>Member:</strong> $<?php echo esc_html(number_format((float)$price_mem)); ?></span>
        <?php endif; ?>
        <?php if ($price_non) : ?>
          <span><strong>Non-Member:</strong> $<?php echo esc_html(number_format((float)$price_non)); ?></span>
        <?php endif; ?>
      </div>
    </section>

    <!-- Featured image -->
    <?php if (has_post_thumbnail()) : ?>
      <div style="margin-bottom:2rem;">
        <?php the_post_thumbnail('large', array('class' => 'sdws-img-crop sdws-img-16-9', 'style' => 'width:100%;')); ?>
      </div>
    <?php endif; ?>

    <!-- Content -->
    <section class="sdws-section" style="max-width:720px;">
      <div style="font-size:1.0625rem; line-height:1.8; color:#000;">
        <?php the_content(); ?>
      </div>
      <?php if ($materials) : ?>
        <p style="margin-top:2rem;">
          <a href="<?php echo esc_url($materials); ?>" target="_blank" rel="noopener" class="sdws-btn sdws-btn--outline">
            Download Materials List
          </a>
        </p>
      <?php endif; ?>
    </section>

    <!-- Registration CTA -->
    <section class="sdws-section" style="background:var(--color-off-white); margin-bottom:var(--space-section);">
      <div class="sdws-container" style="text-align:center;">
        <h2 style="font-family:var(--font-display); font-size:2rem; margin:0 0 0.75rem;">Register for This Workshop</h2>
        <p style="margin:0 0 1.5rem; font-size:1rem; color:#000;">
          Questions? Email <a href="mailto:registrar@sdws.org" style="color:#000; font-weight:500;">registrar@sdws.org</a>
        </p>
        <a href="mailto:registrar@sdws.org?subject=Workshop Registration: <?php echo rawurlencode(get_the_title()); ?>" class="sdws-btn sdws-btn--teal">
          Register by Email
        </a>
      </div>
    </section>

  </article>
</main>

<?php endwhile; ?>
<?php get_footer(); ?>
