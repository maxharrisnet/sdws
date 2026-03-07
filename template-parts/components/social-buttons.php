<?php

/**
 * Social buttons component.
 *
 * @package Starter_Coat
 */

$links = isset($args['links']) && is_array($args['links']) ? $args['links'] : array();
?>
<div class="c-social-buttons layout">
  <?php foreach ($links as $link) : ?>
    <a class="btn btn--ghost btn--sm" href="<?php echo esc_url($link['url'] ?? '#'); ?>">
      <?php
      $icon_name = isset($link['icon']) ? (string) $link['icon'] : '';
      if ('' !== $icon_name && function_exists('starter_coat_get_icon_svg')) {
        echo starter_coat_get_icon_svg($icon_name, array('class' => 'c-social-buttons__icon', 'decorative' => true)); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
      }
      ?>
      <?php echo esc_html($link['label'] ?? ''); ?>
    </a>
  <?php endforeach; ?>
</div>