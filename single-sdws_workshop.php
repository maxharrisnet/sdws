<?php

/**
 * Single workshop template — San Diego Watercolor Society
 *
 * @package Starter_Coat
 */

get_header();

while (have_posts()) : the_post();

  $gf            = function_exists('get_field');
  $instructor    = $gf ? get_field('workshop_instructor')      : get_post_meta(get_the_ID(), 'workshop_instructor', true);
  $date_start    = $gf ? get_field('workshop_date_start')      : get_post_meta(get_the_ID(), 'workshop_date_start', true);
  $date_end      = $gf ? get_field('workshop_date_end')        : get_post_meta(get_the_ID(), 'workshop_date_end', true);
  $price_mem     = $gf ? get_field('workshop_price_member')    : get_post_meta(get_the_ID(), 'workshop_price_member', true);
  $price_non     = $gf ? get_field('workshop_price_nonmember') : get_post_meta(get_the_ID(), 'workshop_price_nonmember', true);
  $buttons       = $gf ? (get_field('workshop_buttons')   ?: array()) : array();
  $resources     = $gf ? (get_field('workshop_resources') ?: array()) : array();
  $reg_email     = $gf ? (get_field('workshops_email_registrar', 'option') ?: 'registrar@sdws.org') : 'registrar@sdws.org';

  $date_label  = '';
  if ($date_start) {
    $start_fmt  = date('F j', strtotime($date_start));
    $end_fmt    = $date_end ? date('j, Y', strtotime($date_end)) : date('Y', strtotime($date_start));
    $date_label = $start_fmt . '–' . $end_fmt;
  }

  $format_terms  = get_the_terms(get_the_ID(), 'workshop_format');
  $format_term   = ($format_terms && !is_wp_error($format_terms)) ? $format_terms[0] : null;
  $workshops_url = get_post_type_archive_link('sdws_workshop') ?: home_url('/workshops/');
?>

  <main id="primary" class="site-main">

    <!-- Header -->
    <section class="sdws-section sdws-section--bordered-bottom">
      <div class="sdws-container">
        <nav class="sdws-breadcrumb" aria-label="Breadcrumb">
          <ol class="sdws-breadcrumb__list">
            <li class="sdws-breadcrumb__item">
              <a href="<?php echo esc_url($workshops_url); ?>">Workshops</a>
            </li>
            <?php if ($format_term) : ?>
              <li class="sdws-breadcrumb__item">
                <a href="<?php echo esc_url($workshops_url . '#format-' . $format_term->slug); ?>">
                  <?php echo esc_html($format_term->name); ?>
                </a>
              </li>
            <?php endif; ?>
          </ol>
        </nav>
        <h1 class="sdws-page-title"><?php the_title(); ?></h1>
        <?php if ($instructor) : ?>
          <p class="sdws-workshop-instructor">With <?php echo esc_html($instructor); ?></p>
        <?php endif; ?>
        <div class="sdws-workshop-meta">
          <?php if ($date_label) : ?>
            <div class="sdws-workshop-meta__item">
              <span class="sdws-workshop-meta__label">Date</span>
              <?php echo esc_html($date_label); ?>
            </div>
          <?php endif; ?>
          <?php if ($price_mem) : ?>
            <div class="sdws-workshop-meta__item">
              <span class="sdws-workshop-meta__label">Member</span>
              $<?php echo esc_html(number_format((float) $price_mem)); ?>
            </div>
          <?php endif; ?>
          <?php if ($price_non) : ?>
            <div class="sdws-workshop-meta__item">
              <span class="sdws-workshop-meta__label">Non-Member</span>
              $<?php echo esc_html(number_format((float) $price_non)); ?>
            </div>
          <?php endif; ?>
          <a href="#register" class="sdws-btn sdws-btn--teal">Register</a>
        </div>
      </div>
    </section>

    <!-- Content -->
    <section class="sdws-section">
      <div class="sdws-container">
        <div class="sdws-content-2-col">

          <!-- Left: featured image -->
          <?php if (has_post_thumbnail()) : ?>
            <?php the_post_thumbnail('large', array(
              'class'    => 'sdws-workshop-featured-img',
              'loading'  => 'lazy',
              'decoding' => 'async',
              'sizes'    => '(min-width: 1200px) 560px, (min-width: 768px) 45vw, 100vw',
            )); ?>
          <?php endif; ?>

          <!-- Right: description + buttons -->
          <div class="sdws-workshop-content">
            <?php the_content(); ?>
            <?php if (!empty($buttons)) : ?>
              <div class="sdws-workshop-buttons">
                <?php foreach ($buttons as $btn) :
                  if (empty($btn['url']) || empty($btn['label'])) continue; ?>
                  <a href="<?php echo esc_url($btn['url']); ?>" target="_blank" rel="noopener" class="sdws-btn sdws-btn--outline">
                    <?php echo esc_html($btn['label']); ?>
                  </a>
                <?php endforeach; ?>
              </div>
            <?php endif; ?>
          </div>

        </div>
      </div>
    </section>

    <!-- Resources & Materials -->
    <?php if (!empty($resources)) : ?>
      <section class="sdws-section sdws-section--off-white sdws-section--bordered-bottom">
        <div class="sdws-container">
          <h2 class="sdws-section-heading">Resources &amp; Materials</h2>
          <div class="sdws-workshop-resources">
            <?php foreach ($resources as $item) :
              $rtype  = !empty($item['type'])  ? $item['type']  : 'button';
              $rlabel = !empty($item['label']) ? $item['label'] : '';
              $rurl   = !empty($item['url'])   ? $item['url']   : '';
              if (!$rlabel) continue;

              if ('button' === $rtype && $rurl) : ?>
                <a href="<?php echo esc_url($rurl); ?>" target="_blank" rel="noopener" class="sdws-btn sdws-btn--outline">
                  <?php echo esc_html($rlabel); ?>
                </a>
              <?php elseif ('text' === $rtype) : ?>
                <p class="sdws-resource-note"><?php echo esc_html($rlabel); ?></p>
              <?php endif; ?>
            <?php endforeach; ?>
          </div>
        </div>
      </section>
    <?php endif; ?>

    <?php
    $page_cta = function_exists('starter_coat_get_page_cta_override') ? starter_coat_get_page_cta_override(get_the_ID()) : null;
    if ($page_cta === null) :
      $mailto = 'mailto:' . $reg_email . '?subject=' . rawurlencode('Workshop Registration: ' . get_the_title());
    ?>
    <!-- Registration CTA (default — overridden per-page via CTA fields) -->
    <div id="register">
      <?php get_template_part('template-parts/components/cta', null, array(
        'cta' => array(
          'title'               => 'Register for This Workshop',
          'copy'                => 'Questions? Email <a href="mailto:' . esc_attr($reg_email) . '">' . esc_html($reg_email) . '</a>',
          'button_primary'      => array('title' => 'Register by Email', 'url' => $mailto),
          'button_primary_style'=> 'teal',
        ),
      )); ?>
    </div>
    <?php endif; ?>

  </main>

<?php endwhile; ?>
<?php get_footer(); ?>
