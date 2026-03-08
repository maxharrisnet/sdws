<?php

/**
 * Flexible card collection section.
 *
 * @package Starter_Coat
 */

$pre_kicker       = (string) starter_coat_get_sub_field('pre_kicker', '');
$pre_title        = (string) starter_coat_get_sub_field('pre_title', '');
$pre_copy         = (string) starter_coat_get_sub_field('pre_copy', '');
$columns          = (string) starter_coat_get_sub_field('columns', '3');
$card_style       = sanitize_html_class((string) starter_coat_get_sub_field('card_style', 'surface'));
$equal_height     = (bool) starter_coat_get_sub_field('equal_height', true);
$post_copy        = (string) starter_coat_get_sub_field('post_copy', '');
$quote            = (string) starter_coat_get_sub_field('quote', '');
$quote_source     = (string) starter_coat_get_sub_field('quote_source', '');
$section_classes  = starter_coat_get_section_classes('section--card-collection');
$container_class  = starter_coat_get_section_container_class();
$pre_buttons      = array();
$post_buttons     = array();
$items            = array();
$columns_class    = 'layout--3col';
$card_style_class = 'c-card-collection__card--surface';

if ('1' === $columns) {
  $columns_class = 'layout--1col';
} elseif ('2' === $columns) {
  $columns_class = 'layout--2col';
} elseif ('4' === $columns) {
  $columns_class = 'layout--4col';
}

if ('outline' === $card_style) {
  $card_style_class = 'c-card-collection__card--outline';
} elseif ('featured' === $card_style) {
  $card_style_class = 'c-card-collection__card--featured';
}

if (function_exists('have_rows') && call_user_func('have_rows', 'pre_buttons')) {
  while (call_user_func('have_rows', 'pre_buttons')) {
    call_user_func('the_row');
    $button_link  = starter_coat_get_sub_field('button_link', null);
    $button_style = sanitize_html_class((string) starter_coat_get_sub_field('button_style', 'primary'));

    if (! empty($button_link['url']) && ! empty($button_link['title'])) {
      $pre_buttons[] = array(
        'link'  => $button_link,
        'style' => $button_style,
      );
    }
  }
}

if (function_exists('have_rows') && call_user_func('have_rows', 'post_buttons')) {
  while (call_user_func('have_rows', 'post_buttons')) {
    call_user_func('the_row');
    $button_link  = starter_coat_get_sub_field('button_link', null);
    $button_style = sanitize_html_class((string) starter_coat_get_sub_field('button_style', 'primary'));

    if (! empty($button_link['url']) && ! empty($button_link['title'])) {
      $post_buttons[] = array(
        'link'  => $button_link,
        'style' => $button_style,
      );
    }
  }
}

if (function_exists('have_rows') && call_user_func('have_rows', 'items')) {
  while (call_user_func('have_rows', 'items')) {
    call_user_func('the_row');

    $list_items = array();
    if (function_exists('have_rows') && call_user_func('have_rows', 'list_items')) {
      while (call_user_func('have_rows', 'list_items')) {
        call_user_func('the_row');
        $list_text = trim((string) starter_coat_get_sub_field('text', ''));
        if ('' !== $list_text) {
          $list_items[] = $list_text;
        }
      }
    }

    $icon_name = sanitize_title((string) starter_coat_get_sub_field('icon_name', ''));
    $icon_url  = '';
    if ($icon_name) {
      $icon_file = 'icon-card-' . $icon_name . '.svg';
      $icon_path = get_theme_file_path('/assets/icons/cards/' . $icon_file);
      if (file_exists($icon_path)) {
        $icon_url = get_theme_file_uri('/assets/icons/cards/' . $icon_file);
      }
    }

    $items[] = array(
      'title'          => (string) starter_coat_get_sub_field('title', ''),
      'copy'           => (string) starter_coat_get_sub_field('copy', ''),
      'media_type'     => (string) starter_coat_get_sub_field('media_type', 'none'),
      'media_position' => sanitize_html_class((string) starter_coat_get_sub_field('media_position', 'left')),
      'icon_name'      => $icon_name,
      'icon_url'       => $icon_url,
      'image'          => starter_coat_get_sub_field('image', null),
      'card_url'       => (string) starter_coat_get_sub_field('card_url', ''),
      'open_new_tab'   => (bool) starter_coat_get_sub_field('open_new_tab', false),
      'list_items'     => $list_items,
    );
  }
}

if (empty($items) && '' === trim($pre_title) && '' === trim($pre_copy) && '' === trim($post_copy)) {
  return;
}

$grid_classes = array('layout', $columns_class, 'c-card-collection__grid');
if ($equal_height) {
  $grid_classes[] = 'c-card-collection__grid--equal';
}
?>
<section class="<?php echo esc_attr($section_classes); ?>">
  <div class="<?php echo esc_attr($container_class); ?>">
    <div class="c-card-collection">
      <?php if ($pre_kicker || $pre_title || $pre_copy || ! empty($pre_buttons)) : ?>
        <header class="c-card-collection__intro">
          <?php if ($pre_kicker) : ?>
            <p class="eyebrow"><?php echo esc_html($pre_kicker); ?></p>
          <?php endif; ?>

          <?php if ($pre_title) : ?>
            <h2><?php echo esc_html($pre_title); ?></h2>
          <?php endif; ?>

          <?php if ($pre_copy) : ?>
            <p class="section__intro"><?php echo esc_html($pre_copy); ?></p>
          <?php endif; ?>

          <?php if (! empty($pre_buttons)) : ?>
            <div class="c-card-collection__buttons">
              <?php foreach ($pre_buttons as $button) : ?>
                <?php $style = 'ghost' === $button['style'] ? 'ghost' : 'primary'; ?>
                <a class="btn btn--<?php echo esc_attr($style); ?> btn--md" href="<?php echo esc_url((string) $button['link']['url']); ?>" <?php echo ! empty($button['link']['target']) ? 'target="' . esc_attr((string) $button['link']['target']) . '" rel="noopener"' : ''; ?>>
                  <?php echo esc_html((string) $button['link']['title']); ?>
                </a>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>
        </header>
      <?php endif; ?>

      <?php if (! empty($items)) : ?>
        <div class="<?php echo esc_attr(implode(' ', $grid_classes)); ?>">
          <?php foreach ($items as $item) : ?>
            <?php
            $tag         = '' !== trim($item['card_url']) ? 'a' : 'article';
            $card_class  = 'c-card-collection__card card ' . $card_style_class . ' c-card-collection__card--media-' . $item['media_position'];
            $target_attr = $item['open_new_tab'] ? ' target="_blank" rel="noopener"' : '';
            $has_media   = ('icon' === $item['media_type'] && '' !== $item['icon_url']) || ('image' === $item['media_type'] && is_array($item['image']) && (! empty($item['image']['ID']) || ! empty($item['image']['url'])));
            ?>
            <<?php echo $tag; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
              ?>
              class="<?php echo esc_attr($card_class); ?>"
              <?php if ('a' === $tag) : ?>
              href="<?php echo esc_url($item['card_url']); ?>" <?php echo $target_attr; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
                                                                ?>
              <?php endif; ?>>
              <?php if ($has_media) : ?>
                <div class="c-card-collection__media">
                  <?php if ('icon' === $item['media_type'] && '' !== $item['icon_url']) : ?>
                    <img class="c-card-collection__icon" src="<?php echo esc_url($item['icon_url']); ?>" alt="" aria-hidden="true" loading="lazy" />
                  <?php elseif ('image' === $item['media_type']) : ?>
                    <?php if (! empty($item['image']['ID'])) : ?>
                      <?php
                      echo wp_get_attachment_image(
                        (int) $item['image']['ID'],
                        'medium',
                        false,
                        array(
                          'class'   => 'c-card-collection__image',
                          'loading' => 'lazy',
                          'alt'     => isset($item['image']['alt']) ? (string) $item['image']['alt'] : '',
                        )
                      );
                      ?>
                    <?php elseif (! empty($item['image']['url'])) : ?>
                      <img class="c-card-collection__image" src="<?php echo esc_url((string) $item['image']['url']); ?>" alt="<?php echo esc_attr(isset($item['image']['alt']) ? (string) $item['image']['alt'] : ''); ?>" loading="lazy" />
                    <?php endif; ?>
                  <?php endif; ?>
                </div>
              <?php endif; ?>

              <div class="c-card-collection__body">
                <?php if ($item['title']) : ?>
                  <h3 class="card__title"><?php echo esc_html($item['title']); ?></h3>
                <?php endif; ?>

                <?php if ($item['copy']) : ?>
                  <p><?php echo esc_html($item['copy']); ?></p>
                <?php endif; ?>

                <?php if (! empty($item['list_items'])) : ?>
                  <ul class="c-card-collection__list">
                    <?php foreach ($item['list_items'] as $list_item) : ?>
                      <li><?php echo esc_html($list_item); ?></li>
                    <?php endforeach; ?>
                  </ul>
                <?php endif; ?>
              </div>
            </<?php echo $tag; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
              ?>>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>

      <?php if ($post_copy || $quote || $quote_source || ! empty($post_buttons)) : ?>
        <footer class="c-card-collection__footer">
          <?php if ($post_copy) : ?>
            <p class="section__intro"><?php echo esc_html($post_copy); ?></p>
          <?php endif; ?>

          <?php if ($quote) : ?>
            <h4 class="c-card-collection__quote">&ldquo;<?php echo esc_html($quote); ?>&rdquo;</h4>
          <?php endif; ?>

          <?php if ($quote_source) : ?>
            <p class="c-card-collection__quote-source"><?php echo esc_html($quote_source); ?></p>
          <?php endif; ?>

          <?php if (! empty($post_buttons)) : ?>
            <div class="c-card-collection__buttons">
              <?php foreach ($post_buttons as $button) : ?>
                <?php $style = 'ghost' === $button['style'] ? 'ghost' : 'primary'; ?>
                <a class="btn btn--<?php echo esc_attr($style); ?> btn--md" href="<?php echo esc_url((string) $button['link']['url']); ?>" <?php echo ! empty($button['link']['target']) ? 'target="' . esc_attr((string) $button['link']['target']) . '" rel="noopener"' : ''; ?>>
                  <?php echo esc_html((string) $button['link']['title']); ?>
                </a>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>
        </footer>
      <?php endif; ?>
    </div>
  </div>
</section>