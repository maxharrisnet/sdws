<?php

/**
 * The template for displaying webinar archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Aera_Technology
 */

get_header();

// Hero section - from ACF Webinars Options
$hero_title = __('Webinars', 'aera');
$hero_title_line_two = '';
$hero_subtitle = '';
$hero_text = __('Register for upcoming webinars or explore our library of past sessions. Filter videos by industry, solution area or job function to find the content most relevant to you.', 'aera');
$hero_button_text = '';
$hero_button_link = '';
$hero_full_height = false;
$hero_variation = 'default';

if (function_exists('get_field')) {
  $acf_title = get_field('webinars_hero_title', 'option');
  $acf_title_line_two = get_field('webinars_hero_title_line_two', 'option');
  $acf_subtitle = get_field('webinars_hero_subtitle', 'option');
  $acf_text = get_field('webinars_hero_text', 'option');
  $acf_button_text = get_field('webinars_hero_button_text', 'option');
  $acf_button_link = get_field('webinars_hero_button_link', 'option');
  $acf_full_height = get_field('webinars_hero_full_height', 'option');
  $acf_variation = get_field('webinars_hero_variation', 'option');

  if (!empty($acf_title)) {
    $hero_title = $acf_title;
  }
  if (!empty($acf_title_line_two)) {
    $hero_title_line_two = $acf_title_line_two;
  }
  if (!empty($acf_subtitle)) {
    $hero_subtitle = $acf_subtitle;
  }
  if (!empty($acf_text)) {
    $hero_text = $acf_text;
  }
  if (!empty($acf_button_text)) {
    $hero_button_text = $acf_button_text;
  }
  if (!empty($acf_button_link)) {
    $hero_button_link = $acf_button_link;
  }
  if ($acf_full_height) {
    $hero_full_height = (bool) $acf_full_height;
  }
  if (!empty($acf_variation)) {
    $hero_variation = $acf_variation;
  }
}

// Get today's date for comparison
$today = current_time('Y-m-d');

// Query for featured webinars (featured = true) - show first 3
// Sort by menu_order (Intuitive CPO) then by date
$featured_args = array(
  'post_type'      => 'webinar',
  'posts_per_page' => 3,
  'post_status'    => 'publish',
  'orderby'        => array(
    'menu_order' => 'ASC',
    'date'       => 'DESC',
  ),
  'meta_query'     => array(
    array(
      'key'     => 'webinar_featured',
      'value'   => '1',
      'compare' => '=',
    ),
  ),
);

$featured_query = new WP_Query($featured_args);

// Esclude featured webinars from main grid
$featured_ids = array();
if ($featured_query->have_posts()) {
  foreach ($featured_query->posts as $featured_post) {
    $featured_ids[] = $featured_post->ID;
  }
}

// Query webinars for the grid (order by ACF webinar_date)
$on_demand_args = array(
  'post_type'      => 'webinar',
  'posts_per_page' => -1, // Show all
  'post_status'    => 'publish',
  // Use the ACF `webinar_date` (format Y-m-d) as the primary ordering key.
  'meta_key'       => 'webinar_date',
  'meta_type'      => 'DATE',
  'orderby'        => array(
    'menu_order' => 'ASC', // Keep featured items at the top within the gridnewsItem__figure
    'meta_value' => 'DESC',
  ),
  'post__not_in'   => $featured_ids,
);

$on_demand_query = new WP_Query($on_demand_args);

// Get taxonomy terms for filters
$industry_terms = get_terms(
  array(
    'taxonomy'   => 'industry',
    'hide_empty' => true,
    'orderby'    => 'name',
    'order'      => 'ASC',
  )
);

$solution_area_terms = get_terms(
  array(
    'taxonomy'   => 'webinar_solution_area',
    'hide_empty' => true,
    'orderby'    => 'name',
    'order'      => 'ASC',
  )
);

$job_function_terms = get_terms(
  array(
    'taxonomy'   => 'webinar_job_function',
    'hide_empty' => true,
    'orderby'    => 'name',
    'order'      => 'ASC',
  )
);
?>

<main id="primary" class="site-main site-main--webinars">
  <?php
  // Prepare hero data
  $hero_args = array(
    'hero_title'          => $hero_title,
    'hero_title_line_two' => $hero_title_line_two,
    'hero_subtitle'       => $hero_subtitle,
    'hero_text'           => $hero_text,
    'hero_button_text'    => $hero_button_text,
    'hero_button_link'    => $hero_button_link,
    'hero_full_height'    => $hero_full_height,
    'hero_variation'      => $hero_variation,
  );

  get_template_part('template-parts/components/hero', null, $hero_args);
  ?>

  <!-- Featured Events Section -->
  <?php if ($featured_query->have_posts()) : ?>
    <section class="news news--featured">
      <div class="news__container">
        <div class="news__list">
          <div class="news__col" id="featEvent">
            <?php
            $featured_count = 0;
            while ($featured_query->have_posts() && $featured_count < 3) :
              $featured_query->the_post();
              get_template_part('template-parts/content', 'webinar-featured-item');
              $featured_count++;
            endwhile;
            ?>
          </div>
        </div>
      </div>
    </section>
  <?php endif; ?>
  <?php wp_reset_postdata(); ?>

  <!-- Form Section -->
  <section class="news__formSection">
    <div class="news__container">
      <div class="news__col">
        <div class="news__formRow">
          <div class="news__formText">
            <h3><?php esc_html_e('Get the latest resources, blog posts, and updates from Aera Technology.', 'aera'); ?></h3>
            <p><?php esc_html_e('Sign up for updates in your inbox.', 'aera'); ?></p>
          </div>
          <div class="news__formWrapper">
            <div id="webinarForm" class="webinar-form"></div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- All Resources Section -->
  <?php if ($on_demand_query->have_posts()) : ?>
    <section class="news news--all-resources">
      <div class="news__container">
        <div class="news__col">
          <h2 class="news__subheading"><?php esc_html_e('Want to learn more?', 'aera'); ?></h2>
          <p class="news__para"><?php esc_html_e('Catch up on our previous webinars.', 'aera'); ?></p>

          <div class="news__filterRow">
            <div>
              <select id="industryFilter" class="news__filter">
                <option value=""><?php esc_html_e('All Industries', 'aera'); ?></option>
              </select>
            </div>
            <div>
              <select id="solutionAreaFilter" class="news__filter">
                <option value=""><?php esc_html_e('All Solution Areas', 'aera'); ?></option>
              </select>
            </div>
            <div>
              <select id="jobFunctionFilter" class="news__filter">
                <option value=""><?php esc_html_e('All Job Functions', 'aera'); ?></option>
              </select>
            </div>
          </div>

          <div class="news__list news__list--grid" id="webinarGrid">
            <?php
            while ($on_demand_query->have_posts()) :
              $on_demand_query->the_post();
              get_template_part('template-parts/content', 'webinar-item');
            endwhile;
            ?>
          </div>

          <div id="webinarNoResults" class="news__noResults" style="display: none;">
            <?php esc_html_e('No webinars match your filters.', 'aera'); ?>
          </div>
        </div>
      </div>
    </section>
  <?php endif; ?>
  <?php wp_reset_postdata(); ?>
</main>

<?php
// Build a simplified options array for the front-end filter
$taxonomy_options = array(
  'industry'      => array(),
  'solutionAreas' => array(),
  'jobFunctions'  => array(),
);

if (!is_wp_error($industry_terms)) {
  foreach ($industry_terms as $term) {
    $taxonomy_options['industry'][] = array(
      'slug' => $term->slug,
      'name' => html_entity_decode($term->name, ENT_QUOTES | ENT_HTML5, 'UTF-8'),
    );
  }
}

if (!is_wp_error($solution_area_terms)) {
  foreach ($solution_area_terms as $term) {
    $taxonomy_options['solutionAreas'][] = array(
      'slug' => $term->slug,
      'name' => html_entity_decode($term->name, ENT_QUOTES | ENT_HTML5, 'UTF-8'),
    );
  }
}

if (!is_wp_error($job_function_terms)) {
  foreach ($job_function_terms as $term) {
    $taxonomy_options['jobFunctions'][] = array(
      'slug' => $term->slug,
      'name' => html_entity_decode($term->name, ENT_QUOTES | ENT_HTML5, 'UTF-8'),
    );
  }
}
?>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const taxonomyOptions = <?php echo wp_json_encode($taxonomy_options); ?>;

    const industrySelect = document.getElementById('industryFilter');
    const solutionAreaSelect = document.getElementById('solutionAreaFilter');
    const jobFunctionSelect = document.getElementById('jobFunctionFilter');
    const gridItems = Array.from(document.querySelectorAll('#webinarGrid .newsItem'));
    const noResults = document.getElementById('webinarNoResults');

    function populateSelect(selectEl, items) {
      if (!selectEl || !Array.isArray(items)) return;
      items.forEach(function(item) {
        const option = document.createElement('option');
        option.value = item.slug;
        option.textContent = item.name;
        selectEl.appendChild(option);
      });
    }

    populateSelect(industrySelect, taxonomyOptions.industry);
    populateSelect(solutionAreaSelect, taxonomyOptions.solutionAreas);
    populateSelect(jobFunctionSelect, taxonomyOptions.jobFunctions);

    function itemMatches(item) {
      const industryValue = industrySelect ? industrySelect.value : '';
      const solutionValue = solutionAreaSelect ? solutionAreaSelect.value : '';
      const jobValue = jobFunctionSelect ? jobFunctionSelect.value : '';

      const industries = (item.dataset.industries || '').split(',').filter(Boolean);
      const solutionAreas = (item.dataset.solutionAreas || '').split(',').filter(Boolean);
      const jobFunctions = (item.dataset.jobFunctions || '').split(',').filter(Boolean);

      const matchesIndustry = !industryValue || industries.includes(industryValue);
      const matchesSolution = !solutionValue || solutionAreas.includes(solutionValue);
      const matchesJob = !jobValue || jobFunctions.includes(jobValue);

      return matchesIndustry && matchesSolution && matchesJob;
    }

    function applyFilters() {
      let visibleCount = 0;

      gridItems.forEach(function(item) {
        if (itemMatches(item)) {
          item.style.display = '';
          visibleCount += 1;
        } else {
          item.style.display = 'none';
        }
      });

      if (noResults) {
        noResults.style.display = visibleCount === 0 ? '' : 'none';
      }
    }

    [industrySelect, solutionAreaSelect, jobFunctionSelect].forEach(function(selectEl) {
      if (selectEl) {
        selectEl.addEventListener('change', applyFilters);
      }
    });

    applyFilters();
  });
</script>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Load HubSpot forms script
    const script = document.createElement('script');
    script.src = 'https://js.hsforms.net/forms/embed/v2.js';
    document.body.appendChild(script);

    script.addEventListener('load', function() {
      if (window.hbspt) {
        window.hbspt.forms.create({
          portalId: '4455954',
          formId: '23724f92-30b8-4f38-b984-70383520619d',
          target: '#webinarForm'
        });
      }
    });
  });
</script>

<?php
get_footer();
