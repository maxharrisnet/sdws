<?php

/**
 * Feature list section.
 *
 * @package Starter_Coat
 */

$heading         = (string) starter_coat_get_sub_field('heading', '');
$intro           = (string) starter_coat_get_sub_field('intro', '');
$quote           = (string) starter_coat_get_sub_field('quote', '');
$quote_source    = (string) starter_coat_get_sub_field('quote_source', '');
$cta_button      = starter_coat_get_sub_field('cta_button', null);
$section_classes = starter_coat_get_section_classes('section--feature-list');
$container_class = starter_coat_get_section_container_class();

$left_items = array();
if (function_exists('have_rows') && call_user_func('have_rows', 'left_items')) {
  while (call_user_func('have_rows', 'left_items')) {
    call_user_func('the_row');

    $left_items[] = array(
      'image'       => starter_coat_get_sub_field('image', null),
      'title'       => (string) starter_coat_get_sub_field('title', ''),
      'description' => (string) starter_coat_get_sub_field('description', ''),
      'link'        => starter_coat_get_sub_field('link', null),
    );
  }
}

$right_items = array();
if (function_exists('have_rows') && call_user_func('have_rows', 'right_items')) {
  while (call_user_func('have_rows', 'right_items')) {
    call_user_func('the_row');

    $right_items[] = array(
      'image'       => starter_coat_get_sub_field('image', null),
      'title'       => (string) starter_coat_get_sub_field('title', ''),
      'description' => (string) starter_coat_get_sub_field('description', ''),
      'link'        => starter_coat_get_sub_field('link', null),
    );
  }
}

if (empty($left_items) && empty($right_items)) {
  return;
}
?>
<section class="<?php echo esc_attr($section_classes); ?>">
  <div class="<?php echo esc_attr($container_class); ?>">
    <div class="c-feature-list">
      <?php if ($heading || $intro) : ?>
        <div class="c-feature-list__hero">
          <?php if ($heading) : ?>
            <h2 class="c-feature-list__heading"><?php echo esc_html($heading); ?></h2>
          <?php endif; ?>

          <?php if ($intro) : ?>
            <p class="c-feature-list__intro"><?php echo esc_html($intro); ?></p>
          <?php endif; ?>
        </div>
      <?php endif; ?>

      <div class="c-feature-list__grid">
        <?php foreach (array($left_items, $right_items) as $col_index => $column_items) : ?>
          <div class="c-feature-list__column c-feature-list__column--<?php echo esc_attr((string) ($col_index + 1)); ?>">
            <?php foreach ($column_items as $item) : ?>
              <?php
              $item_image = isset($item['image']) && is_array($item['image']) ? $item['image'] : array();
              $item_link  = isset($item['link']) && is_array($item['link']) ? $item['link'] : array();
              $tag        = ! empty($item_link['url']) ? 'a' : 'div';
              ?>
              <<?php echo $tag; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
                ?>
                class="c-feature-list-card"
                <?php if ('a' === $tag) : ?>
                href="<?php echo esc_url((string) $item_link['url']); ?>"
                <?php echo ! empty($item_link['target']) ? 'target="' . esc_attr((string) $item_link['target']) . '" rel="noopener"' : ''; ?>
                <?php endif; ?>>
                <div class="c-feature-list-card__media">
                  <?php if (! empty($item_image['ID'])) : ?>
                    <?php
                    echo wp_get_attachment_image(
                      (int) $item_image['ID'],
                      'sc-card-header',
                      false,
                      array(
                        'class'   => 'c-feature-list-card__image',
                        'loading' => 'lazy',
                        'alt'     => isset($item_image['alt']) ? (string) $item_image['alt'] : '',
                      )
                    );
                    ?>
                  <?php elseif (! empty($item_image['url'])) : ?>
                    <img class="c-feature-list-card__image" src="<?php echo esc_url((string) $item_image['url']); ?>" alt="<?php echo esc_attr(isset($item_image['alt']) ? (string) $item_image['alt'] : ''); ?>" loading="lazy" />
                  <?php endif; ?>
                  <span class="c-feature-list-card__overlay" aria-hidden="true"></span>
                </div>
                <div class="c-feature-list-card__body">
                  <?php if (! empty($item['title'])) : ?>
                    <h3 class="c-feature-list-card__title"><?php echo esc_html((string) $item['title']); ?></h3>
                  <?php endif; ?>
                  <?php if (! empty($item['description'])) : ?>
                    <p class="c-feature-list-card__description"><?php echo esc_html((string) $item['description']); ?></p>
                  <?php endif; ?>
                </div>
              </<?php echo $tag; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
                ?>>
            <?php endforeach; ?>
          </div>
        <?php endforeach; ?>
      </div>

      <?php if ($quote || $quote_source || ! empty($cta_button['url'])) : ?>
        <div class="c-feature-list__footer">
          <?php if ($quote) : ?>
            <h4 class="c-feature-list__quote">&ldquo;<?php echo esc_html($quote); ?>&rdquo;</h4>
          <?php endif; ?>
          <?php if ($quote_source) : ?>
            <p class="c-feature-list__quote-source"><?php echo esc_html($quote_source); ?></p>
          <?php endif; ?>
          <?php if (! empty($cta_button['url']) && ! empty($cta_button['title'])) : ?>
            <a class="btn btn--primary btn--md" href="<?php echo esc_url((string) $cta_button['url']); ?>" <?php echo ! empty($cta_button['target']) ? 'target="' . esc_attr((string) $cta_button['target']) . '" rel="noopener"' : ''; ?>>
              <?php echo esc_html((string) $cta_button['title']); ?>
            </a>
          <?php endif; ?>
        </div>
      <?php endif; ?>
    </div>
  </div>
</section>