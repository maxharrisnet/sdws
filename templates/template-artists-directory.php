<?php

/**
 * Template Name: Artists Directory Page
 *
 * @package Starter_Coat
 */

if (! defined('ABSPATH')) {
  exit;
}

get_header();
?>

<main id="primary" class="site-main section section--lg artists-directory-page">
  <?php while (have_posts()) : the_post(); ?>
    <?php
    $parent_id = get_the_ID();
    $children  = get_pages(
      array(
        'parent'      => $parent_id,
        'sort_column' => 'menu_order,post_title',
        'sort_order'  => 'ASC',
        'post_status' => 'publish',
      )
    );

    $read_tier_from_content = static function ($content) {
      if (! is_string($content) || $content === '') {
        return '';
      }

      if (preg_match('/Category:\s*<\/strong>\s*([^<]+)/i', $content, $matches)) {
        return trim(wp_strip_all_tags($matches[1]));
      }

      if (preg_match('/Tier:\s*<\/strong>\s*([^<]+)/i', $content, $matches)) {
        return trim(wp_strip_all_tags($matches[1]));
      }

      return '';
    };

    $groups = array(
      'Blossoming' => array(),
      'Seedlings'  => array(),
      'Other'      => array(),
    );

    foreach ($children as $child) {
      $child_tier = '';

      if (function_exists('get_field')) {
        $child_tier = (string) get_field('sc_artist_tier', $child->ID);
      }

      if ($child_tier === '') {
        $child_tier = (string) get_post_meta($child->ID, 'profile_tier', true);
      }

      if ($child_tier === '') {
        $child_tier = $read_tier_from_content((string) $child->post_content);
      }

      if (strcasecmp($child_tier, 'Blossoming') === 0) {
        $groups['Blossoming'][] = $child;
      } elseif (strcasecmp($child_tier, 'Seedlings') === 0) {
        $groups['Seedlings'][] = $child;
      } else {
        $groups['Other'][] = $child;
      }
    }
    ?>

    <?php starter_coat_render_singular_hero($parent_id); ?>

    <div class="container">
      <article <?php post_class('artists-directory'); ?>>
        <?php if (! starter_coat_has_singular_hero($parent_id)) : ?>
          <header class="artists-directory__header">
            <h1 class="artists-directory__title"><?php the_title(); ?></h1>
          </header>
        <?php endif; ?>

        <?php if (trim((string) get_the_content()) !== '') : ?>
          <div class="artists-directory__intro entry-content">
            <?php the_content(); ?>
          </div>
        <?php endif; ?>

        <?php if (! empty($children)) : ?>
          <section class="artists-directory__listing" aria-label="<?php esc_attr_e('Artist pages', 'starter-coat'); ?>">
            <?php foreach ($groups as $group_label => $items) : ?>
              <?php if (empty($items)) {
                continue;
              } ?>

              <div class="artists-directory__group">
                <?php if ('Other' !== $group_label) : ?>
                  <h2 class="artists-directory__group-title"><?php echo esc_html($group_label); ?></h2>
                <?php endif; ?>

                <div class="artists-directory__grid">
                  <?php foreach ($items as $child) : ?>
                    <?php
                    $excerpt = has_excerpt($child->ID)
                      ? get_the_excerpt($child->ID)
                      : wp_trim_words(wp_strip_all_tags((string) $child->post_content), 26);
                    ?>
                    <article class="artists-directory-card">
                      <a class="artists-directory-card__link" href="<?php echo esc_url(get_permalink($child->ID)); ?>">
                        <?php if (has_post_thumbnail($child->ID)) : ?>
                          <figure class="artists-directory-card__media">
                            <?php echo get_the_post_thumbnail($child->ID, 'medium_large'); ?>
                          </figure>
                        <?php endif; ?>
                        <div class="artists-directory-card__body">
                          <?php if ('Other' !== $group_label) : ?>
                            <span class="artists-directory-card__tier"><?php echo esc_html($group_label); ?></span>
                          <?php endif; ?>
                          <h3 class="artists-directory-card__title"><?php echo esc_html(get_the_title($child->ID)); ?></h3>
                          <?php if (! empty($excerpt)) : ?>
                            <p class="artists-directory-card__excerpt"><?php echo esc_html($excerpt); ?></p>
                          <?php endif; ?>
                          <span class="artists-directory-card__cta"><?php esc_html_e('View profile', 'starter-coat'); ?></span>
                        </div>
                      </a>
                    </article>
                  <?php endforeach; ?>
                </div>
              </div>
            <?php endforeach; ?>
          </section>
        <?php else : ?>
          <p><?php esc_html_e('No artist pages were found yet. Add child pages to populate this directory.', 'starter-coat'); ?></p>
        <?php endif; ?>
      </article>
    </div>
  <?php endwhile; ?>
</main>

<?php
get_footer();
