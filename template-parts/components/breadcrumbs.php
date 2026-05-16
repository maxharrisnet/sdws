<?php

/**
 * Breadcrumbs component with Schema.org BreadcrumbList markup.
 *
 * @package Starter_Coat
 */

if (is_front_page()) {
  return;
}

$crumbs = array();
$crumbs[] = array(
  'label' => __('Home', 'starter-coat'),
  'url'   => home_url('/'),
);

if (is_singular()) {
  $post_type = get_post_type();
  $post_obj  = get_post_type_object($post_type);

  if ($post_obj && $post_obj->has_archive) {
    $archive_url = get_post_type_archive_link($post_type);
    if ($archive_url) {
      $crumbs[] = array(
        'label' => $post_obj->labels->name,
        'url'   => $archive_url,
      );
    }
  } elseif ('post' === $post_type) {
    $blog_page = get_option('page_for_posts');
    if ($blog_page) {
      $crumbs[] = array(
        'label' => get_the_title($blog_page),
        'url'   => get_permalink($blog_page),
      );
    }
  }

  // Parent pages.
  if (is_page()) {
    $ancestors = get_post_ancestors(get_the_ID());
    $ancestors = array_reverse($ancestors);
    foreach ($ancestors as $ancestor_id) {
      $crumbs[] = array(
        'label' => get_the_title($ancestor_id),
        'url'   => get_permalink($ancestor_id),
      );
    }
  }

  $crumbs[] = array(
    'label' => get_the_title(),
    'url'   => '',
  );
} elseif (is_post_type_archive()) {
  $post_obj = get_queried_object();
  $crumbs[] = array(
    'label' => $post_obj->labels->name,
    'url'   => '',
  );
} elseif (is_category() || is_tag() || is_tax()) {
  $term = get_queried_object();
  $taxonomy = get_taxonomy($term->taxonomy);
  if ($taxonomy && ! empty($taxonomy->object_type)) {
    $cpt = $taxonomy->object_type[0];
    $cpt_obj = get_post_type_object($cpt);
    if ($cpt_obj && $cpt_obj->has_archive) {
      $crumbs[] = array(
        'label' => $cpt_obj->labels->name,
        'url'   => get_post_type_archive_link($cpt),
      );
    }
  }
  $crumbs[] = array(
    'label' => $term->name,
    'url'   => '',
  );
} elseif (is_search()) {
  $crumbs[] = array(
    'label' => sprintf(__('Search: %s', 'starter-coat'), get_search_query()),
    'url'   => '',
  );
} elseif (is_archive()) {
  $crumbs[] = array(
    'label' => get_the_archive_title(),
    'url'   => '',
  );
}

if (count($crumbs) < 2) {
  return;
}
?>
<nav class="breadcrumbs" aria-label="<?php esc_attr_e('Breadcrumb', 'starter-coat'); ?>">
  <div class="container">
    <ol class="breadcrumbs__list" itemscope itemtype="https://schema.org/BreadcrumbList">
      <?php foreach ($crumbs as $i => $crumb) : ?>
        <li class="breadcrumbs__item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
          <?php if ($crumb['url'] && $i < count($crumbs) - 1) : ?>
            <a href="<?php echo esc_url($crumb['url']); ?>" itemprop="item">
              <span itemprop="name"><?php echo esc_html($crumb['label']); ?></span>
            </a>
          <?php else : ?>
            <span itemprop="name" aria-current="page"><?php echo esc_html($crumb['label']); ?></span>
          <?php endif; ?>
          <meta itemprop="position" content="<?php echo esc_attr($i + 1); ?>">
        </li>
      <?php endforeach; ?>
    </ol>
  </div>
</nav>
