<?php

/**
 * Infinite marquee section.
 *
 * @package Starter_Coat
 */

$heading         = (string) starter_coat_get_sub_field('heading', '');
$speed           = sanitize_html_class((string) starter_coat_get_sub_field('speed', 'normal'));
$direction       = sanitize_html_class((string) starter_coat_get_sub_field('direction', 'rtl'));
$section_classes = starter_coat_get_section_classes('section--marquee');
$container_class = starter_coat_get_section_container_class();

$items = array();
if (function_exists('have_rows') && call_user_func('have_rows', 'items')) {
  while (call_user_func('have_rows', 'items')) {
    call_user_func('the_row');

    $items[] = array(
      'text' => (string) starter_coat_get_sub_field('text', ''),
      'link' => starter_coat_get_sub_field('link', null),
    );
  }
}

$items = array_values(array_filter($items, static function ($item) {
  return ! empty($item['text']);
}));

if (empty($items)) {
  return;
}
?>
<section class="<?php echo esc_attr($section_classes); ?>">
  <div class="<?php echo esc_attr($container_class); ?>">
    <div class="c-marquee c-marquee--<?php echo esc_attr($speed); ?> c-marquee--direction-<?php echo esc_attr($direction); ?>" data-marquee>
      <?php if ($heading) : ?>
        <h2 class="c-marquee__heading"><?php echo esc_html($heading); ?></h2>
      <?php endif; ?>

      <div class="c-marquee__viewport" aria-label="<?php esc_attr_e('Scrolling highlights', 'starter-coat'); ?>">
        <?php foreach (array(0, 1) as $track_index) : ?>
          <ul class="c-marquee__track" <?php echo 1 === $track_index ? 'aria-hidden="true"' : ''; ?>>
            <?php foreach ($items as $item) : ?>
              <?php
              $item_link = isset($item['link']) && is_array($item['link']) ? $item['link'] : array();
              ?>
              <li class="c-marquee__item">
                <?php if (! empty($item_link['url'])) : ?>
                  <a href="<?php echo esc_url((string) $item_link['url']); ?>" <?php echo ! empty($item_link['target']) ? 'target="' . esc_attr((string) $item_link['target']) . '" rel="noopener"' : ''; ?>>
                    <?php echo esc_html((string) $item['text']); ?>
                  </a>
                <?php else : ?>
                  <span><?php echo esc_html((string) $item['text']); ?></span>
                <?php endif; ?>
              </li>
            <?php endforeach; ?>
          </ul>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>
