<?php

/**
 * Homepage template — San Diego Watercolor Society
 *
 * @package Starter_Coat
 */

get_header();
?>

<main id="primary" class="site-main">

  <!-- ======================== HERO ======================== -->
  <section class="sdws-section sdws-section--lg" style="background:#fff; border-bottom: var(--border);">
    <div class="sdws-container" style="max-width:860px;">
      <p style="font-size:0.8125rem; letter-spacing:0.12em; text-transform:uppercase; font-weight:500; margin-bottom:1.25rem;">
        San Diego Watercolor Society — Est. 1980
      </p>
      <h1 style="font-family:var(--font-display); font-size:clamp(2.5rem,6vw,4.5rem); line-height:1.1; margin:0 0 1.5rem; color:#000;">
        Watercolor art, community, and excellence in San Diego.
      </h1>
      <p style="font-size:1.125rem; max-width:600px; margin:0 0 2.5rem; line-height:1.7; color:#000;">
        The San Diego Watercolor Society has championed watercolor painting for over 40 years — offering gallery exhibitions, workshops, and a vibrant community for artists at every level.
      </p>
      <div style="display:flex; gap:1rem; flex-wrap:wrap;">
        <a href="<?php echo esc_url( get_permalink( get_page_by_path('exhibitions') ) ?: home_url('/exhibitions/') ); ?>" class="sdws-btn sdws-btn--teal">
          Visit the Gallery
        </a>
        <a href="<?php echo esc_url( get_permalink( get_page_by_path('international') ) ?: home_url('/international/') ); ?>" class="sdws-btn sdws-btn--outline">
          Learn About the I-Show
        </a>
      </div>
    </div>
  </section>

  <!-- ================== JUNE MEMBER SHOW GALLERY STRIP ================== -->
  <section style="border-bottom: var(--border); overflow:hidden;">
    <div style="padding:2rem 2rem 0; max-width:var(--max-width); margin:0 auto; display:flex; justify-content:space-between; align-items:baseline;">
      <p style="font-size:0.8125rem; letter-spacing:0.1em; text-transform:uppercase; font-weight:500; margin:0;">
        June Member Show
      </p>
      <p style="font-size:0.875rem; margin:0; color:#000;">90+ works on display</p>
    </div>
    <div class="sdws-gallery-strip" style="margin-top:1.5rem;">
      <?php
      // Show featured images from member-show exhibitions, or placeholders
      $gallery_query = new WP_Query( array(
        'post_type'      => 'sdws_exhibition',
        'posts_per_page' => 8,
        'tax_query'      => array( array(
          'taxonomy' => 'exhibition_type',
          'field'    => 'slug',
          'terms'    => 'member-show',
        ) ),
      ) );

      if ( $gallery_query->have_posts() ) :
        while ( $gallery_query->have_posts() ) : $gallery_query->the_post();
          if ( has_post_thumbnail() ) :
      ?>
            <div class="sdws-gallery-strip__item">
              <?php the_post_thumbnail( 'medium', array( 'class' => 'sdws-img-crop sdws-img-4-3', 'alt' => get_the_title() ) ); ?>
            </div>
      <?php
          endif;
        endwhile;
        wp_reset_postdata();
      else :
        // Placeholder tiles until images are uploaded
        for ( $i = 1; $i <= 6; $i++ ) :
      ?>
          <div class="sdws-gallery-strip__item" style="background:var(--color-sand); display:flex; align-items:center; justify-content:center; min-height:210px;">
            <span style="font-size:0.75rem; letter-spacing:0.08em; text-transform:uppercase; opacity:0.4;">Artwork <?php echo $i; ?></span>
          </div>
      <?php
        endfor;
      endif;
      ?>
    </div>
  </section>

  <!-- ================ 46TH I-SHOW PROMO BLOCK ================ -->
  <section class="sdws-section sdws-section--teal" style="border-bottom: 2px solid #000;">
    <div class="sdws-container" style="max-width:900px;">
      <p style="font-size:0.8125rem; letter-spacing:0.12em; text-transform:uppercase; font-weight:500; margin-bottom:1rem; color:#fff; opacity:0.8;">
        Now Accepting Entries
      </p>
      <h2 style="font-family:var(--font-display); font-size:clamp(2rem,5vw,3.5rem); color:#fff; margin:0 0 1rem; line-height:1.15;">
        46th International Exhibition
      </h2>
      <p style="font-size:1.125rem; color:#fff; margin:0 0 0.5rem;">
        <strong>September 27 – October 31, 2026</strong>
      </p>
      <p style="font-size:1rem; color:#fff; margin:0 0 0.5rem;">
        Awards: $30,000+ &nbsp;|&nbsp; Juror: Ana Laura Salazar
      </p>
      <p style="font-size:0.9375rem; color:#fff; margin:0 0 2rem;">
        Open to watercolor artists worldwide. Submit via online entry.
      </p>
      <a href="<?php echo esc_url( get_permalink( get_page_by_path('international') ) ?: home_url('/international/') ); ?>" class="sdws-btn sdws-btn--white">
        View Exhibition Details
      </a>
    </div>
  </section>

  <!-- ================ UPCOMING WORKSHOPS GRID ================ -->
  <section class="sdws-section" style="border-bottom: var(--border); background: #fff;">
    <div class="sdws-container">
      <div style="display:flex; justify-content:space-between; align-items:baseline; margin-bottom:2.5rem; flex-wrap:wrap; gap:1rem; border-bottom: var(--border); padding-bottom:1.25rem;">
        <h2 style="font-family:var(--font-display); font-size:2.25rem; margin:0;">Upcoming Workshops</h2>
        <a href="<?php echo esc_url( get_post_type_archive_link('sdws_workshop') ?: home_url('/workshops/') ); ?>" style="font-size:0.875rem; font-weight:500; letter-spacing:0.06em; text-transform:uppercase; color:#000; text-decoration:none; border-bottom:1px solid #000;">
          View All Workshops →
        </a>
      </div>
      <?php
      $workshops = new WP_Query( array(
        'post_type'      => 'sdws_workshop',
        'posts_per_page' => 3,
        'orderby'        => 'meta_value',
        'meta_key'       => 'workshop_date_start',
        'order'          => 'ASC',
      ) );
      ?>
      <?php if ( $workshops->have_posts() ) : ?>
        <div class="sdws-grid-3">
          <?php while ( $workshops->have_posts() ) : $workshops->the_post(); ?>
            <?php get_template_part( 'template-parts/sdws/workshop-card' ); ?>
          <?php endwhile; ?>
        </div>
        <?php wp_reset_postdata(); ?>
      <?php else : ?>
        <p style="color:#000; opacity:0.5;">Workshop listings coming soon.</p>
      <?php endif; ?>
    </div>
  </section>

</main>

<?php get_footer(); ?>
