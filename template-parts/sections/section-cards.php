<?php

/**
 * Three column cards section.
 *
 * @package Starter_Coat
 */
?>
<?php
$heading         = starter_coat_get_sub_field('heading', '');
$intro           = starter_coat_get_sub_field('intro', '');
$columns         = starter_coat_get_sub_field('columns', '3');
$section_classes = starter_coat_get_section_classes('section--cards');
$container_class = starter_coat_get_section_container_class();
$layout_class    = 'layout--3col';

if ('2' === (string) $columns) {
  $layout_class = 'layout--2col';
} elseif ('4' === (string) $columns) {
  $layout_class = 'layout--4col';
}
?>
<section class="<?php echo esc_attr($section_classes); ?>">
  <div class="<?php echo esc_attr($container_class); ?>">
    <?php if ($heading) : ?>
      <h2><?php echo esc_html($heading); ?></h2>
    <?php endif; ?>
    <?php if ($intro) : ?>
      <p class="section__intro"><?php echo esc_html($intro); ?></p>
    <?php endif; ?>

    <div class="layout <?php echo esc_attr($layout_class); ?>">
      <?php if (function_exists('have_rows') && call_user_func('have_rows', 'items')) : ?>
        <?php
        while (call_user_func('have_rows', 'items')) :
          call_user_func('the_row');
          $pill   = starter_coat_get_sub_field('pill', '');
          $title  = starter_coat_get_sub_field('title', '');
          $copy   = starter_coat_get_sub_field('copy', '');
          $button = starter_coat_get_sub_field('button', null);
        ?>
          <article class="card card--surface">
            <?php if ($pill) : ?>
              <span class="c-flexible-card__pill"><?php echo esc_html($pill); ?></span>
            <?php endif; ?>
            <?php if ($title) : ?>
              <h3 class="card__title"><?php echo esc_html($title); ?></h3>
            <?php endif; ?>
            <?php if ($copy) : ?>
              <p><?php echo esc_html($copy); ?></p>
            <?php endif; ?>
            <?php if (! empty($button['url']) && ! empty($button['title'])) : ?>
              <a class="btn btn--ghost btn--sm" href="<?php echo esc_url($button['url']); ?>" <?php echo ! empty($button['target']) ? 'target="' . esc_attr($button['target']) . '"' : ''; ?>>
                <?php echo esc_html($button['title']); ?>
              </a>
            <?php endif; ?>
          </article>
        <?php endwhile; ?>
      <?php else : ?>
        <?php for ($index = 1; $index <= 3; $index++) : ?>
          <article class="card card--surface">
            <h3 class="card__title"><?php printf(esc_html__('Card %d', 'starter-coat'), $index); ?></h3>
            <p><?php esc_html_e('Add content in the ACF repeater.', 'starter-coat'); ?></p>
          </article>
        <?php endfor; ?>
      <?php endif; ?>
    </div>
  </div>
</section>