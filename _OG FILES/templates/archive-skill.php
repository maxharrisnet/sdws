<?php

/**
 * The template for displaying skill archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Aera_Technology
 */

get_header();

// Get hero content - prefer page-level (if present), otherwise use ACF options
$hero_title = function_exists('get_field') ? get_field('skills_archive_title', 'option') : '';
$hero_description = function_exists('get_field') ? get_field('skills_archive_description', 'option') : '';

// Provide sensible defaults if options are empty
if (empty($hero_title)) {
  $hero_title = __('Aera Skills™', 'aera');
}
if (empty($hero_description)) {
  $hero_description = __('Explore our comprehensive suite of business decision skills powered by the Aera Decision Cloud™.', 'aera');
}

// CTA button for archive (options)
$hero_button_text = function_exists('get_field') ? get_field('skills_archive_button_text', 'option') : '';
$hero_button_link = function_exists('get_field') ? get_field('skills_archive_button_link', 'option') : '';

// Get skill functions for filtering
$skill_functions = get_terms(array(
  'taxonomy' => 'skill_function',
  'hide_empty' => true,
  'orderby' => 'name',
  'order' => 'ASC',
));

// Get current filters from URL
$current_search = isset($_GET['skill_search']) ? sanitize_text_field(is_array($_GET['skill_search']) ? $_GET['skill_search'][0] : $_GET['skill_search']) : '';
// Categories: support ?categories=35,39 (comma-separated) or ?categories[]=35&categories[]=39
$current_categories = array();
if (isset($_GET['categories'])) {
  $raw = $_GET['categories'];
  if (is_array($raw)) {
    $current_categories = array_values(array_filter(array_map('intval', $raw)));
  } else {
    $current_categories = array_values(array_filter(array_map('intval', array_map('trim', explode(',', (string) $raw)))));
  }
}
$current_sort = isset($_GET['sort']) ? sanitize_text_field(is_array($_GET['sort']) ? $_GET['sort'][0] : $_GET['sort']) : 'menu_order';

// Query filtering (tax_query, search, sort) is done in functions.php via pre_get_posts
// so it runs before the main query. This template only parses URL params for the form.
?>

<main id="primary" class="site-main site-main--skills">
  <?php
  // Prepare hero data
  $hero_args = array(
    'hero_title' => $hero_title,
    'hero_text' => $hero_description,
    'hero_full_height' => false,
    'hero_variation' => 'skillset',
    'hero_button_text' => $hero_button_text,
    'hero_button_link' => $hero_button_link,
  );

  get_template_part('template-parts/components/hero', null, $hero_args);
  ?>

  <!-- Skills Archive Section -->
  <section id="skills-archive-section" class="skills skills--archive">
    <div class="skills__container">
      <div class="skills__row">

        <!-- Sidebar Filter -->
        <aside class="skills-filter">
          <h3 class="skills-filter__title"><?php esc_html_e('All Skills', 'aera'); ?></h3>

          <div class="skills-filter__toggle" id="filterToggle">
            <?php esc_html_e('Filter Skills', 'aera'); ?>
          </div>

          <div class="skills-filter__content" id="filterContent">

            <!-- Search Bar -->
            <div class="skills-filter__search">
              <form role="search" method="get" action="<?php echo esc_url(get_post_type_archive_link('skill')); ?>" id="skillsSearchForm" class="skills-filter__search-form">
                <div class="skills-filter__search-wrapper">
                  <input type="search" name="skill_search" placeholder="<?php esc_attr_e('Search', 'aera'); ?>" value="<?php echo esc_attr($current_search); ?>" class="skills-filter__search-input">
                  <button type="submit" class="skills-filter__search-button" aria-label="<?php esc_attr_e('Search', 'aera'); ?>">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <circle cx="10" cy="10" r="6" stroke="currentColor" stroke-width="2" />
                      <path d="M14.5 14.5L20 20" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                    </svg>
                  </button>
                </div>
              </form>
            </div>

            <!-- Functions Filter -->
            <?php if (!empty($skill_functions) && !is_wp_error($skill_functions)) : ?>
              <form method="get" action="<?php echo esc_url(get_post_type_archive_link('skill')); ?>" id="skillsFilterForm">
                <!-- Comma-separated category IDs (avoids URL bracket issues) -->
                <input type="hidden" name="categories" id="skillsFilterCategories" value="<?php echo esc_attr(implode(',', $current_categories)); ?>">
                <!-- Preserve search parameter -->
                <?php if (!empty($current_search)) : ?>
                  <input type="hidden" name="skill_search" value="<?php echo esc_attr($current_search); ?>">
                <?php endif; ?>

                <!-- Preserve sort parameter -->
                <?php if (!empty($current_sort) && $current_sort !== 'menu_order') : ?>
                  <input type="hidden" name="sort" value="<?php echo esc_attr($current_sort); ?>">
                <?php endif; ?>

                <div class="skills-filter__functions">

                  <?php foreach ($skill_functions as $function) :
                    // Get all categories linked to this function via ACF
                    $all_categories = get_terms(array(
                      'taxonomy' => 'skill_category',
                      'hide_empty' => true,
                    ));

                    $function_categories = array();
                    if (!empty($all_categories) && !is_wp_error($all_categories)) {
                      foreach ($all_categories as $category) {
                        $parent_function_id = function_exists('get_field') ? get_field('parent_function', 'skill_category_' . $category->term_id) : null;
                        if ($parent_function_id == $function->term_id) {
                          $function_categories[] = $category;
                        }
                      }
                    }

                    // Skip functions with no categories
                    if (empty($function_categories)) continue;
                  ?>
                    <div class="skills-filter__function">
                      <div class="skills-filter__function-header" data-function="<?php echo esc_attr($function->slug); ?>">
                        <span class="skills-filter__function-name">
                          <?php echo esc_html($function->name); ?>
                        </span>
                        <span class="skills-filter__function-icon">
                          <svg class="skills-filter__icon-plus" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path d="M8 1V15" stroke="currentColor" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M1 8H15" stroke="currentColor" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                          </svg>
                          <svg class="skills-filter__icon-minus" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path d="M1 8H15" stroke="currentColor" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                          </svg>
                        </span>
                      </div>
                      <div class="skills-filter__function-skills" id="function-<?php echo esc_attr($function->slug); ?>">
                        <?php foreach ($function_categories as $category) :
                          // Only show categories that have skills (hide_empty handles this, but double-check)
                          $category_count = $category->count;
                          if ($category_count == 0) continue;

                          $is_category_checked = in_array($category->term_id, $current_categories);
                        ?>
                          <label class="skills-filter__skill-item">
                            <input type="checkbox" value="<?php echo esc_attr($category->term_id); ?>" class="skills-filter__checkbox skills-filter__category-cb" <?php checked($is_category_checked); ?>>
                            <span><?php echo esc_html($category->name); ?></span>
                          </label>
                        <?php endforeach; ?>
                      </div>
                    </div>
                  <?php endforeach; ?>
                </div>

              </form>
            <?php endif; ?>

          </div>
        </aside>

        <!-- Skills Grid -->
        <div class="skills-grid">
          <?php if (have_posts()) : ?>
            <div class="skills-grid__list">
              <?php
              while (have_posts()) :
                the_post();
                get_template_part('template-parts/content', 'icon-card');
              endwhile;
              ?>
            </div>

            <!-- Pagination -->
            <?php
            $pagination = paginate_links(array(
              'type' => 'array',
              'prev_text' => __('&laquo; Previous', 'aera'),
              'next_text' => __('Next &raquo;', 'aera'),
            ));

            if ($pagination) :
            ?>
              <nav class="skills-pagination" aria-label="<?php esc_attr_e('Skills pagination', 'aera'); ?>">
                <ul class="pagination">
                  <?php foreach ($pagination as $page) : ?>
                    <li><?php echo wp_kses_post($page); ?></li>
                  <?php endforeach; ?>
                </ul>
              </nav>
            <?php endif; ?>

          <?php else : ?>
            <div class="skills-grid__empty">
              <p><?php esc_html_e('No skills found matching your criteria.', 'aera'); ?></p>
            </div>
          <?php endif; ?>
        </div>

      </div>
    </div>
  </section>
</main>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Mobile filter toggle
    const filterToggle = document.getElementById('filterToggle');
    const filterContent = document.getElementById('filterContent');

    if (filterToggle && filterContent) {
      filterToggle.addEventListener('click', function() {
        filterToggle.classList.toggle('active');
        filterContent.classList.toggle('active');
      });
    }

    // Function expand/collapse
    const functionHeaders = document.querySelectorAll('.skills-filter__function-header');
    functionHeaders.forEach(function(header) {
      header.addEventListener('click', function(e) {
        const functionSlug = this.getAttribute('data-function');
        const categoriesList = document.getElementById('function-' + functionSlug);

        if (categoriesList) {
          categoriesList.classList.toggle('active');
          this.classList.toggle('active');
        }
      });
    });

    // Category checkboxes: client-side filtering and URL updates (see js/skills-filter.js)

    // Sort dropdown
    const sortSelect = document.getElementById('skillSort');
    if (sortSelect) {
      sortSelect.addEventListener('change', function() {
        const form = document.createElement('form');
        form.method = 'GET';
        form.action = window.location.pathname;

        // Preserve existing parameters
        const url = new URL(window.location.href);
        url.searchParams.forEach(function(value, key) {
          if (key !== 'sort') {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = key;
            input.value = value;
            form.appendChild(input);
          }
        });

        // Add sort parameter
        const sortInput = document.createElement('input');
        sortInput.type = 'hidden';
        sortInput.name = 'sort';
        sortInput.value = this.value;
        form.appendChild(sortInput);

        document.body.appendChild(form);
        form.submit();
      });
    }
  });
</script>

<?php
get_footer();
