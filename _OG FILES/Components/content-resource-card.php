<?php

/**
 * Resource card partial.
 *
 * @package Aera_Technology
 */

use function Aera\get_resource_cta_label;
use function Aera\get_resource_fallback_media;
use function Aera\get_resource_label_for_post_type;

$is_demo = ! empty($args['is_demo']);
$post_id = $args['post_id'] ?? get_the_ID();
$post_type = $args['post_type'] ?? get_post_type($post_id) ?? 'resource';

// Get title: ACF field first, then args, then WordPress title
$title = '';
if (!$is_demo && function_exists('get_field')) {
  $acf_title = get_field('resource_card_title', $post_id);
  if (!empty($acf_title)) {
    $title = $acf_title;
  }
}
if (empty($title) && isset($args['title'])) {
  $title = $args['title'];
}
if (empty($title)) {
  $title = get_the_title($post_id);
}

// Get excerpt: ACF field first, then args, then WordPress excerpt
$excerpt = '';
if (!$is_demo && function_exists('get_field')) {
  $acf_excerpt = get_field('resource_excerpt', $post_id);
  if (!empty($acf_excerpt)) {
    $excerpt = wp_strip_all_tags($acf_excerpt);
  }
}
if (empty($excerpt) && isset($args['excerpt'])) {
  $excerpt = $args['excerpt'];
}
if (empty($excerpt)) {
  $excerpt = wp_strip_all_tags(get_the_excerpt($post_id));
}

$type_label = $args['type_label'] ?? get_resource_label_for_post_type($post_type);
$city = $args['city'] ?? '';

// Check for Coming Soon toggle
$is_coming_soon = false;
if (!$is_demo && function_exists('get_field')) {
  $is_coming_soon = (bool) get_field('resource_coming_soon', $post_id);
}

// Get date value - no date for coming soon items
$date_value = $is_coming_soon ? '' : ($args['date'] ?? get_the_date('Y-m-d', $post_id));
$display_date = $date_value ?: '';

$external_url = $args['external_url'] ?? (function_exists('get_field') ? get_field('resource_external_url', $post_id) : '');
$link = $args['link'] ?? ($external_url ?: get_permalink($post_id));
$is_external = ! empty($external_url) || (isset($args['link']) && str_contains($args['link'], 'http'));

// Get CTA label: ACF field first, then args, then default function
$cta_label = '';
if (!$is_demo && function_exists('get_field')) {
  $acf_cta = get_field('resource_cta_text', $post_id);
  if (!empty($acf_cta)) {
    $cta_label = $acf_cta;
  }
}
if (empty($cta_label) && isset($args['cta_label'])) {
  $cta_label = $args['cta_label'];
}
if (empty($cta_label)) {
  $cta_label = get_resource_cta_label($post_type);
}
$custom_image = $args['image'] ?? '';
$custom_image_alt = $args['image_alt'] ?? $title;

// Get card image from ACF field, fallback to featured image
// TODO: Change default image
$card_image_url = '';
$card_image_data = null;
$card_image_att = null;
if (!$is_demo && function_exists('get_field')) {
  $card_image_data = get_field('resource_card_image', $post_id);
  if ($card_image_data && is_array($card_image_data)) {
    $att = $card_image_data['ID'] ?? $card_image_data['id'] ?? null;
    if ($att) {
      // Keep the attachment ID so we can render a proper <img> (with srcset)
      $card_image_att = (int) $att;
      // Still keep a URL fallback
      $card_image_url = wp_get_attachment_image_url($att, 'resource_card_image') ?: '';
    } else {
      $card_image_url = $card_image_data['url'] ?? '';
    }
  }
}

// If no ACF image ID and no URL, try the featured image
if (empty($card_image_att) && empty($card_image_url)) {
  $thumb_id = get_post_thumbnail_id($post_id);
  if ($thumb_id) {
    $card_image_att = (int) $thumb_id;
    $card_image_url = wp_get_attachment_image_url($thumb_id, 'resource_card_image') ?: '';
  }
}

// Get logo from ACF - check both resource_logo and customer_logo
$logo_url = '';
$logo_att = null;
if (!$is_demo && function_exists('get_field')) {
  // First check for resource_logo (standard resource field)
  $logo_data = get_field('resource_logo', $post_id);
  if ($logo_data && is_array($logo_data)) {
    $att = $logo_data['ID'] ?? $logo_data['id'] ?? null;
    if ($att) {
      $logo_att = (int) $att;
      $logo_url = wp_get_attachment_image_url($att, 'card_logo');
    } else {
      $logo_url = $logo_data['url'] ?? '';
    }
  }
  // If no resource_logo and post type is customer, check customer_logo
  if (empty($logo_url) && empty($logo_att) && $post_type === 'customer') {
    $customer_logo = get_field('customer_logo', $post_id);
    if ($customer_logo && is_array($customer_logo)) {
      $att = $customer_logo['ID'] ?? $customer_logo['id'] ?? null;
      if ($att) {
        $logo_att = (int) $att;
        $logo_url = wp_get_attachment_image_url($att, 'card_logo');
      } else {
        $logo_url = $customer_logo['url'] ?? '';
      }
    }
  }
}

// Determine if we have an image or logo
$has_image = !empty($card_image_url) || !empty($custom_image);
$has_logo = !empty($logo_url);
$image_url = $card_image_url ?: $custom_image;

// Fallback media
$fallback_media = (!$has_image && !$has_logo) ? get_resource_fallback_media($post_type) : array();

$card_classes = array('resource-card');
$card_classes[] = 'resource-card--' . esc_attr($post_type);

$link_attrs = array();
if (!$is_coming_soon) {
  $link_attrs['href'] = esc_url($link);
  if ($is_external) {
    $link_attrs['target'] = '_blank';
    $link_attrs['rel'] = 'noopener noreferrer';
  }
}

$link_attr_string = '';
foreach ($link_attrs as $attr => $value) {
  $link_attr_string .= sprintf(' %1$s="%2$s"', $attr, $value);
}
?>

<article class="<?php echo esc_attr(implode(' ', $card_classes)); ?>" data-resource-type="<?php echo esc_attr($post_type); ?>" data-resource-class="resources">
  <div class="resource-card__wrapper">
    <?php if ($has_image || $has_logo || !empty($fallback_media['url'])) : ?>
      <div class="resource-card__figure">
        <a<?php echo $link_attr_string; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
          ?>>
          <?php if ($has_image && !$has_logo) : ?>
            <div class="resource-card__bgImage resource-card__imageBorder">
              <?php
              if (! empty($card_image_att)) {
                echo wp_get_attachment_image((int) $card_image_att, 'resource_card_image', false, array(
                  'class'    => 'resource-card__img resource-card__bgImage',
                  'alt'      => esc_attr($title),
                  'loading'  => 'lazy',
                  'decoding' => 'async',
                ));
              } else {
                echo '<img class="resource-card__img resource-card__bgImage" src="' . esc_url($image_url) . '" alt="' . esc_attr($title) . '" loading="lazy" decoding="async" />';
              }
              ?>
            </div>
          <?php elseif ($has_logo) : ?>
            <div class="resource-card__logoImage resource-card__imageBorder">
              <?php
              if ($logo_att) {
                echo wp_get_attachment_image($logo_att, 'card_logo', false, array(
                  'class'    => 'resource-card__logo',
                  'alt'      => esc_attr($title),
                  'loading'  => 'lazy',
                  'decoding' => 'async',
                ));
              } else {
                echo '<img class="resource-card__logo" src="' . esc_url($logo_url) . '" alt="' . esc_attr($title) . '" loading="lazy" decoding="async" />';
              }
              ?>
            </div>
          <?php elseif (!empty($fallback_media['url'])) : ?>
            <?php if (!empty($fallback_media['is_logo'])) : ?>
              <div class="resource-card__logoImage resource-card__imageBorder">
                <img class="resource-card__logo" src="<?php echo esc_url($fallback_media['url']); ?>" alt="<?php echo esc_attr($title); ?>" loading="lazy" decoding="async" />
              </div>
            <?php else : ?>
              <div class="resource-card__bgImage resource-card__imageBorder" style="background-image: url(<?php echo esc_url($fallback_media['url']); ?>);"></div>
            <?php endif; ?>
          <?php endif; ?>
          </a>
      </div>
    <?php endif; ?>

    <a<?php echo $link_attr_string; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
      ?> class="resource-card__link-wrapper<?php echo $is_coming_soon ? ' resource-card__link-wrapper--coming-soon' : ''; ?>">
      <div class="resource-card__row">
        <?php if ($type_label) : ?>
          <div class="resource-card__type">
            <?php
            $label = strtolower($type_label) === 'news' ? $type_label : rtrim($type_label, 's');
            echo esc_html($label);
            ?>
          </div>
        <?php endif; ?>
        <?php if ($city && $post_type === 'event') : ?>
          <div class="resource-card__city"><?php echo esc_html($city); ?></div>
        <?php endif; ?>
      </div>

      <div class="resource-card__row">
        <div class="resource-card__content">
          <h2 class="resource-card__title"><?php echo esc_html($title); ?></h2>
          <?php if ($excerpt) : ?>
            <p class="resource-card__text"><?php echo esc_html($excerpt); ?></p>
          <?php endif; ?>
        </div>
      </div>

      <div class="resource-card__lastRow">
        <div class="resource-card__row resource-card__row--last">
          <?php if ($is_coming_soon) : ?>
            <div class="resource-card__line"></div>
            <span class="resource-card__coming-soon"><?php esc_html_e('Coming Soon', 'aera'); ?></span>
          <?php else : ?>
            <?php if ($display_date) : ?>
              <div class="resource-card__date"><?php echo esc_html($display_date); ?></div>
            <?php endif; ?>
            <div class="resource-card__line"></div>
            <?php
            $hide_cta = in_array($post_type, array('news', 'blog', 'whitepaper', 'press-release', 'report'));
            if ($cta_label && !$hide_cta) :
            ?>
              <span class="resource-card__link"><?php echo esc_html($cta_label); ?></span>
            <?php endif; ?>
          <?php endif; ?>
        </div>
      </div>
      </a>
  </div>
</article>