<?php

/**
 * Bold list section with expandable or link rows.
 *
 * @package Starter_Coat
 */

$heading         = (string) starter_coat_get_sub_field('heading', '');
$intro           = (string) starter_coat_get_sub_field('intro', '');
$style_variant   = sanitize_html_class((string) starter_coat_get_sub_field('style_variant', 'brand-glow'));
$section_classes = starter_coat_get_section_classes('section--bold-list');
$container_class = starter_coat_get_section_container_class();

$items = array();
if (function_exists('have_rows') && call_user_func('have_rows', 'items')) {
  while (call_user_func('have_rows', 'items')) {
    call_user_func('the_row');

    $items[] = array(
      'eyebrow' => (string) starter_coat_get_sub_field('eyebrow', ''),
      'title'   => (string) starter_coat_get_sub_field('title', ''),
      'mode'    => sanitize_key((string) starter_coat_get_sub_field('item_mode', 'expand')),
      'content' => (string) starter_coat_get_sub_field('content', ''),
      'link'    => starter_coat_get_sub_field('link', null),
    );
  }
}

$items = array_values(array_filter($items, static function ($item) {
  return '' !== trim((string) $item['title']);
}));

if (empty($items)) {
  return;
}
?>
<section class="<?php echo esc_attr($section_classes); ?>">
  <div class="<?php echo esc_attr($container_class); ?>">
    <div class="c-bold-list c-bold-list--<?php echo esc_attr($style_variant); ?>">
      <?php if ($heading) : ?>
        <h2 class="c-bold-list__heading"><?php echo esc_html($heading); ?></h2>
      <?php endif; ?>

      <?php if ($intro) : ?>
        <p class="c-bold-list__intro"><?php echo esc_html($intro); ?></p>
      <?php endif; ?>

      <div class="c-bold-list__items" data-bold-list>
        <?php foreach ($items as $index => $item) : ?>
          <?php
          $mode = 'link' === $item['mode'] ? 'link' : 'expand';
          $row_id = 'bold-list-row-' . wp_unique_id() . '-' . ($index + 1);
          $item_link = isset($item['link']) && is_array($item['link']) ? $item['link'] : array();
          ?>

          <?php if ('link' === $mode && ! empty($item_link['url'])) : ?>
            <a class="c-bold-list__item c-bold-list__item--link" href="<?php echo esc_url((string) $item_link['url']); ?>" <?php echo ! empty($item_link['target']) ? 'target="' . esc_attr((string) $item_link['target']) . '" rel="noopener"' : ''; ?>>
              <span class="c-bold-list__item-main">
                <?php if ('' !== $item['eyebrow']) : ?>
                  <strong class="c-bold-list__eyebrow"><?php echo esc_html($item['eyebrow']); ?></strong>
                <?php endif; ?>
                <span class="c-bold-list__title"><?php echo esc_html($item['title']); ?></span>
              </span>
              <span class="c-bold-list__icon" aria-hidden="true">
                <?php starter_coat_the_icon('icon-chevron-up', array('class' => 'c-bold-list__icon-svg')); ?>
              </span>
            </a>
          <?php else : ?>
            <article class="c-bold-list__item c-bold-list__item--expand" data-bold-list-item>
              <button
                type="button"
                class="c-bold-list__toggle"
                data-bold-list-toggle
                aria-expanded="false"
                aria-controls="<?php echo esc_attr($row_id); ?>">
                <span class="c-bold-list__item-main">
                  <?php if ('' !== $item['eyebrow']) : ?>
                    <strong class="c-bold-list__eyebrow"><?php echo esc_html($item['eyebrow']); ?></strong>
                  <?php endif; ?>
                  <span class="c-bold-list__title"><?php echo esc_html($item['title']); ?></span>
                </span>
                <span class="c-bold-list__icon" aria-hidden="true">
                  <?php starter_coat_the_icon('icon-chevron-up', array('class' => 'c-bold-list__icon-svg')); ?>
                </span>
              </button>
              <div id="<?php echo esc_attr($row_id); ?>" class="c-bold-list__panel" data-bold-list-panel hidden>
                <?php if ('' !== trim((string) $item['content'])) : ?>
                  <p class="c-bold-list__content"><?php echo esc_html((string) $item['content']); ?></p>
                <?php endif; ?>
              </div>
            </article>
          <?php endif; ?>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>