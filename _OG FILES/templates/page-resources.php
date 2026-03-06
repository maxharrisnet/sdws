<?php

/**
 * Template Name: Resources
 *
 * @package Aera_Technology
 */

use function Aera\build_resource_query_args;
use function Aera\get_active_resource_type;
use function Aera\get_resource_label_for_post_type;
use function Aera\get_resource_types;

get_header();

$hero = function_exists('get_field') ? (array) get_field('resources_hero') : array();
$hero = wp_parse_args(
  $hero,
  array(
    'title'       => __('Resources', 'aera'),
    'description' => __('Browse the latest decision intelligence stories, research, videos, and news from Aera Technology.', 'aera'),
  )
);

$types = get_resource_types();
// Accept either `type` or `category` in the querystring for compatibility
$requested_type = filter_input(INPUT_GET, 'category', FILTER_SANITIZE_SPECIAL_CHARS);
if (! $requested_type) {
  $requested_type = filter_input(INPUT_GET, 'type', FILTER_SANITIZE_SPECIAL_CHARS);
}
$active_slug = get_active_resource_type($requested_type);
$paged = max(1, get_query_var('paged') ?: get_query_var('page') ?: 1);

// Load resources - use specific query for case studies to respect menu_order
$query_slug = ($active_slug === 'case-study') ? 'case-study' : 'all';
$resource_query = new WP_Query(build_resource_query_args($query_slug, $paged));

$base_url = get_permalink();
?>

<main id="primary" class="site-main site-main--resources">
  <div class="resources__filterWrapper">
    <div class="resources__filterType" id="typeSelector">
      <?php foreach ($types as $slug => $type) : ?>
        <?php
        // Generate links using the actual post type slug (first configured
        // post_type for that resource type). This ensures URLs use the value
        // the server-side query and older links expect (e.g. ?category=report).
        if ('all' === $slug) {
          $url = remove_query_arg('category', $base_url);
          $data_filter = 'all';
          $post_type_for_link = 'all';
        } else {
          $post_type_for_link = !empty($type['post_types'][0]) ? $type['post_types'][0] : $slug;
          $url = add_query_arg('category', $post_type_for_link, $base_url);
          // Use the post_type value for the data-filter so client-side JS
          // updates the URL with the same value that the link points to.
          $data_filter = $post_type_for_link;
        }

        $is_active = $slug === $active_slug;
        $style = $is_active ? 'border-bottom: 1px solid #00578f;' : '';
        ?>
        <a
          href="<?php echo esc_url($url); ?>"
          data-filter="<?php echo esc_attr($data_filter); ?>"
          class="<?php echo $is_active ? 'active' : ''; ?>"
          style="<?php echo esc_attr($style); ?>">
          <?php echo esc_html($type['label']); ?>
        </a>
      <?php endforeach; ?>
    </div>
  </div>

  <div class="resources">
    <div class="resources__container">
      <?php if ($resource_query->have_posts()) : ?>
        <div class="resources__list">
          <div class="resources__col">
            <?php
            while ($resource_query->have_posts()) :
              $resource_query->the_post();
              $post_type = get_post_type();

              // Use case study card template for case-study post type
              if ($post_type === 'case-study') {
                get_template_part('template-parts/content', 'case-study-card');
              } else {
                get_template_part(
                  'template-parts/content',
                  'resource-card',
                  array(
                    'post_id'     => get_the_ID(),
                    'type_label'  => get_resource_label_for_post_type($post_type),
                    'external_url' => function_exists('get_field') ? get_field('resource_external_url') : '',
                    'post_type'   => $post_type,
                  )
                );
              }
            endwhile;
            ?>
          </div>
        </div>

        <?php
        $pagination = paginate_links(
          array(
            'total'   => $resource_query->max_num_pages,
            'current' => $paged,
            'type'    => 'list',
          )
        );
        if ($pagination) :
        ?>
          <nav class="resources__pagination" aria-label="<?php esc_attr_e('Resources pagination', 'aera'); ?>">
            <?php echo wp_kses_post($pagination); ?>
          </nav>
        <?php endif; ?>
      <?php else : ?>
        <div className="resources__no-results-wrapper">
          <p class="resources__no-results"><?php esc_html_e('No resources found.', 'aera'); ?></p>
        </div>
      <?php endif; ?>
    </div>
  </div>
</main>

<?php
wp_reset_postdata();
get_footer();
