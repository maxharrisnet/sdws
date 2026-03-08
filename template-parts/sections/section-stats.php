<?php

/**
 * Stats section with optional icon and count-up values.
 *
 * @package Starter_Coat
 */

$heading         = (string) starter_coat_get_sub_field('heading', '');
$intro           = (string) starter_coat_get_sub_field('intro', '');
$columns         = max(2, min(4, (int) starter_coat_get_sub_field('columns', '4')));
$section_classes = starter_coat_get_section_classes('section--stats');
$container_class = starter_coat_get_section_container_class();

$items = array();
if (function_exists('have_rows') && call_user_func('have_rows', 'items')) {
  while (call_user_func('have_rows', 'items')) {
    call_user_func('the_row');

    $items[] = array(
      'icon'   => sanitize_key((string) starter_coat_get_sub_field('icon', '')),
      'value'  => (int) starter_coat_get_sub_field('value', 0),
      'prefix' => (string) starter_coat_get_sub_field('prefix', ''),
      'suffix' => (string) starter_coat_get_sub_field('suffix', ''),
      'label'  => (string) starter_coat_get_sub_field('label', ''),
    );
  }
}

$items = array_values(array_filter($items, static function ($item) {
  return $item['value'] > 0 || '' !== trim((string) $item['label']);
}));

if (empty($items)) {
  return;
}
?>
<section class="<?php echo esc_attr($section_classes); ?>">
  <div class="<?php echo esc_attr($container_class); ?>">
    <div class="c-stats-section">
      <?php if ($heading) : ?>
        <h2 class="c-stats-section__heading"><?php echo esc_html($heading); ?></h2>
      <?php endif; ?>

      <?php if ($intro) : ?>
        <p class="c-stats-section__intro"><?php echo esc_html($intro); ?></p>
      <?php endif; ?>

      <div class="c-stats-section__grid c-stats-section__grid--cols-<?php echo esc_attr((string) $columns); ?>">
        <?php foreach ($items as $item) : ?>
          <article class="c-stat-card">
            <?php if (! empty($item['icon'])) : ?>
              <div class="c-stat-card__icon" aria-hidden="true">
                <?php starter_coat_the_icon($item['icon'], array('class' => 'c-stat-card__icon-svg')); ?>
              </div>
            <?php endif; ?>

            <p class="c-stat-card__value">
              <?php if (! empty($item['prefix'])) : ?>
                <span class="c-stat-card__affix"><?php echo esc_html((string) $item['prefix']); ?></span>
              <?php endif; ?>
              <span class="c-stat-card__number" data-count-up data-count-to="<?php echo esc_attr((string) $item['value']); ?>">0</span>
              <?php if (! empty($item['suffix'])) : ?>
                <span class="c-stat-card__affix"><?php echo esc_html((string) $item['suffix']); ?></span>
              <?php endif; ?>
            </p>

            <?php if (! empty($item['label'])) : ?>
              <p class="c-stat-card__label"><?php echo esc_html((string) $item['label']); ?></p>
            <?php endif; ?>
          </article>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>