<?php

/**
 * Expressive text section.
 *
 * @package Starter_Coat
 */

$kicker          = (string) starter_coat_get_sub_field('kicker', '');
$title           = (string) starter_coat_get_sub_field('title', '');
$content         = (string) starter_coat_get_sub_field('content', '');
$text_align      = sanitize_html_class((string) starter_coat_get_sub_field('text_align', 'left'));
$text_size       = sanitize_html_class((string) starter_coat_get_sub_field('text_size', 'large'));
$content_width   = sanitize_html_class((string) starter_coat_get_sub_field('content_width', 'narrow'));
$section_classes = starter_coat_get_section_classes('section--expressive-text');
$container_class = starter_coat_get_section_container_class();
$buttons         = array();

if (function_exists('have_rows') && call_user_func('have_rows', 'buttons')) {
  while (call_user_func('have_rows', 'buttons')) {
    call_user_func('the_row');

    $button_link  = starter_coat_get_sub_field('button_link', null);
    $button_style = sanitize_html_class((string) starter_coat_get_sub_field('button_style', 'primary'));

    if (! empty($button_link['url']) && ! empty($button_link['title'])) {
      $buttons[] = array(
        'link'  => $button_link,
        'style' => $button_style,
      );
    }
  }
}

if ('' === trim(wp_strip_all_tags($content)) && '' === trim($title) && '' === trim($kicker)) {
  return;
}
?>
<section class="<?php echo esc_attr($section_classes); ?>">
  <div class="<?php echo esc_attr($container_class); ?>">
    <div class="c-expressive-text c-expressive-text--<?php echo esc_attr($text_align); ?> c-expressive-text--<?php echo esc_attr($text_size); ?> c-expressive-text--width-<?php echo esc_attr($content_width); ?>">
      <?php if ($kicker) : ?>
        <p class="eyebrow"><?php echo esc_html($kicker); ?></p>
      <?php endif; ?>

      <?php if ($title) : ?>
        <h2><?php echo esc_html($title); ?></h2>
      <?php endif; ?>

      <?php if ($content) : ?>
        <div class="richtext">
          <?php echo wp_kses_post($content); ?>
        </div>
      <?php endif; ?>

      <?php if (! empty($buttons)) : ?>
        <div class="c-expressive-text__buttons">
          <?php foreach ($buttons as $button) : ?>
            <?php $style = 'ghost' === $button['style'] ? 'ghost' : 'primary'; ?>
            <a class="btn btn--<?php echo esc_attr($style); ?> btn--md" href="<?php echo esc_url((string) $button['link']['url']); ?>" <?php echo ! empty($button['link']['target']) ? 'target="' . esc_attr((string) $button['link']['target']) . '" rel="noopener"' : ''; ?>>
              <?php echo esc_html((string) $button['link']['title']); ?>
            </a>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>
  </div>
</section>