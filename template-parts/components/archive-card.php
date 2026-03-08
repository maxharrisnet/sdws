<?php

/**
 * Archive card component.
 *
 * @package Starter_Coat
 */

$style = isset($args['style']) ? sanitize_html_class($args['style']) : 'post';
$thumbnail_size = 'featured' === $style ? 'sc-card-header-featured' : 'sc-card-header';

$link_url    = get_permalink();
$link_target = '';
$link_rel    = '';

if ('press' === get_post_type() && function_exists('get_field')) {
  $external_url = (string) call_user_func('get_field', 'sc_press_external_url');
  if ('' !== $external_url) {
    $link_url = $external_url;
    if ((bool) call_user_func('get_field', 'sc_press_open_new_tab')) {
      $link_target = ' target="_blank"';
      $link_rel    = ' rel="noopener noreferrer"';
    }
  }
}
?>
<article <?php post_class('c-archive-card c-archive-card--' . $style); ?>>
  <a class="c-archive-card__link" href="<?php echo esc_url($link_url); ?>" <?php echo $link_target; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
                                                                            ?><?php echo $link_rel; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
                                                                                                                                                                        ?>>
    <?php if (has_post_thumbnail()) : ?>
      <div class="c-archive-card__media"><?php the_post_thumbnail($thumbnail_size); ?></div>
    <?php endif; ?>
    <div class="c-archive-card__body">
      <?php if ('press' === get_post_type() && function_exists('get_field')) : ?>
        <?php
        $publication = (string) call_user_func('get_field', 'sc_press_publication');
        $published_on = (string) call_user_func('get_field', 'sc_press_published_on');
        $published_timestamp = '';

        if ('' !== $published_on) {
          $published_date = DateTime::createFromFormat('Ymd', $published_on);
          if ($published_date instanceof DateTime) {
            $published_timestamp = (string) $published_date->getTimestamp();
          }
        }
        ?>
        <?php if ('' !== $publication || '' !== $published_timestamp) : ?>
          <p class="c-archive-card__meta">
            <?php if ('' !== $publication) : ?>
              <span class="c-archive-card__publication"><?php echo esc_html($publication); ?></span>
            <?php endif; ?>
            <?php if ('' !== $published_timestamp) : ?>
              <span class="c-archive-card__date"><?php echo esc_html(date_i18n(get_option('date_format'), (int) $published_timestamp)); ?></span>
            <?php endif; ?>
          </p>
        <?php endif; ?>
      <?php endif; ?>
      <h3 class="c-archive-card__title"><?php the_title(); ?></h3>
      <div class="c-archive-card__excerpt"><?php the_excerpt(); ?></div>
    </div>
  </a>
</article>