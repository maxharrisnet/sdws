<?php

/**
 * Social media links component (uses global options).
 *
 * @package Starter_Coat
 */

$social_links = starter_coat_get_social_links();
$style        = isset($args['style']) ? sanitize_html_class($args['style']) : 'icon'; // 'icon' or 'text'
$size         = isset($args['size']) ? sanitize_html_class($args['size']) : 'md'; // 'sm', 'md', 'lg'

if (empty($social_links)) {
  return;
}

$platform_labels = array(
  'facebook'  => __('Facebook', 'starter-coat'),
  'twitter'   => __('Twitter', 'starter-coat'),
  'instagram' => __('Instagram', 'starter-coat'),
  'linkedin'  => __('LinkedIn', 'starter-coat'),
  'youtube'   => __('YouTube', 'starter-coat'),
  'tiktok'    => __('TikTok', 'starter-coat'),
  'pinterest' => __('Pinterest', 'starter-coat'),
  'github'    => __('GitHub', 'starter-coat'),
  'bluesky'   => __('BlueSky', 'starter-coat'),
);

$platform_icons = array(
  'facebook'  => 'facebook',
  'twitter'   => 'twitter',
  'instagram' => 'instagram',
  'linkedin'  => 'linkedin',
  'youtube'   => 'youtube',
  'tiktok'    => 'tiktok',
  'pinterest' => 'pinterest',
  'github'    => 'github',
  'bluesky'   => 'icon-social-bluesky',
);
?>
<div class="c-social-links c-social-links--<?php echo esc_attr($style); ?> c-social-links--<?php echo esc_attr($size); ?>">
  <?php foreach ($social_links as $platform => $url) : ?>
    <?php
    $label = isset($platform_labels[$platform]) ? $platform_labels[$platform] : ucfirst($platform);
    $icon  = isset($platform_icons[$platform]) ? $platform_icons[$platform] : $platform;
    ?>
    <a
      href="<?php echo esc_url($url); ?>"
      target="_blank"
      rel="noopener noreferrer"
      class="c-social-links__link c-social-links__link--<?php echo esc_attr($platform); ?>"
      aria-label="<?php echo esc_attr($label); ?>">
      <?php if ('icon' === $style && function_exists('starter_coat_get_icon_svg')) : ?>
        <?php echo starter_coat_get_icon_svg($icon, array('class' => 'c-social-links__icon', 'decorative' => true)); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
        ?>
      <?php elseif ('text' === $style) : ?>
        <span><?php echo esc_html($label); ?></span>
      <?php endif; ?>
    </a>
  <?php endforeach; ?>
</div>