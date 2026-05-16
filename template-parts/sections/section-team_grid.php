<?php

/**
 * Team Grid section.
 *
 * @package Starter_Coat
 */
?>
<?php
$heading         = starter_coat_get_sub_field('heading', '');
$intro           = starter_coat_get_sub_field('intro', '');
$columns         = starter_coat_get_sub_field('columns', '3');
$image_style     = starter_coat_get_sub_field('image_style', 'rounded');
$show_social     = starter_coat_get_sub_field('show_social', false);
$section_classes = starter_coat_get_section_classes('section--team-grid');
$container_class = starter_coat_get_section_container_class();

$layout_class = 'layout--3col';
if ('2' === (string) $columns) {
  $layout_class = 'layout--2col';
} elseif ('4' === (string) $columns) {
  $layout_class = 'layout--4col';
}
?>
<section class="<?php echo esc_attr($section_classes); ?>">
  <div class="<?php echo esc_attr($container_class); ?>">
    <?php if ($heading || $intro) : ?>
      <div class="section__header">
        <?php if ($heading) : ?>
          <h2><?php echo esc_html($heading); ?></h2>
        <?php endif; ?>
        <?php if ($intro) : ?>
          <p class="section__intro"><?php echo esc_html($intro); ?></p>
        <?php endif; ?>
      </div>
    <?php endif; ?>

    <?php if (function_exists('have_rows') && call_user_func('have_rows', 'members')) : ?>
      <div class="layout <?php echo esc_attr($layout_class); ?>">
        <?php
        while (call_user_func('have_rows', 'members')) :
          call_user_func('the_row');
          $photo      = starter_coat_get_sub_field('photo', null);
          $name       = starter_coat_get_sub_field('name', '');
          $title_role = starter_coat_get_sub_field('title_role', '');
          $bio        = starter_coat_get_sub_field('bio', '');
          $linkedin   = starter_coat_get_sub_field('linkedin', '');
          $email      = starter_coat_get_sub_field('email', '');
          $link       = starter_coat_get_sub_field('link', null);

          $photo_url = '';
          $photo_alt = $name;
          if (is_array($photo) && ! empty($photo['sizes']['sc-profile-square-lg'])) {
            $photo_url = $photo['sizes']['sc-profile-square-lg'];
          } elseif (is_array($photo) && ! empty($photo['url'])) {
            $photo_url = $photo['url'];
          }
          if (is_array($photo) && ! empty($photo['alt'])) {
            $photo_alt = $photo['alt'];
          }
        ?>
          <article class="team-member">
            <?php if ($photo_url) : ?>
              <div class="team-member__photo team-member__photo--<?php echo esc_attr($image_style); ?>">
                <img src="<?php echo esc_url($photo_url); ?>" alt="<?php echo esc_attr($photo_alt); ?>" loading="lazy">
              </div>
            <?php endif; ?>

            <div class="team-member__info">
              <?php if ($name) : ?>
                <h3 class="team-member__name"><?php echo esc_html($name); ?></h3>
              <?php endif; ?>
              <?php if ($title_role) : ?>
                <p class="team-member__role"><?php echo esc_html($title_role); ?></p>
              <?php endif; ?>
              <?php if ($bio) : ?>
                <p class="team-member__bio"><?php echo esc_html($bio); ?></p>
              <?php endif; ?>

              <?php if ($show_social && ($linkedin || $email || $link)) : ?>
                <div class="team-member__links">
                  <?php if ($linkedin) : ?>
                    <a href="<?php echo esc_url($linkedin); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php echo esc_attr($name); ?> LinkedIn">
                      <?php starter_coat_the_icon('linkedin', array('width' => 20, 'height' => 20)); ?>
                    </a>
                  <?php endif; ?>
                  <?php if ($email) : ?>
                    <a href="mailto:<?php echo esc_attr($email); ?>" aria-label="<?php printf(esc_attr__('Email %s', 'starter-coat'), esc_attr($name)); ?>">
                      <?php starter_coat_the_icon('email', array('width' => 20, 'height' => 20)); ?>
                    </a>
                  <?php endif; ?>
                  <?php if (is_array($link) && ! empty($link['url'])) : ?>
                    <a href="<?php echo esc_url($link['url']); ?>"<?php echo ! empty($link['target']) ? ' target="' . esc_attr($link['target']) . '" rel="noopener noreferrer"' : ''; ?>>
                      <?php echo esc_html($link['title'] ?: __('View', 'starter-coat')); ?>
                    </a>
                  <?php endif; ?>
                </div>
              <?php endif; ?>
            </div>
          </article>
        <?php endwhile; ?>
      </div>
    <?php else : ?>
      <div class="layout <?php echo esc_attr($layout_class); ?>">
        <?php for ($i = 1; $i <= 3; $i++) : ?>
          <article class="team-member">
            <div class="team-member__photo team-member__photo--<?php echo esc_attr($image_style); ?>">
              <div class="team-member__photo-placeholder"></div>
            </div>
            <div class="team-member__info">
              <h3 class="team-member__name"><?php printf(esc_html__('Team Member %d', 'starter-coat'), $i); ?></h3>
              <p class="team-member__role"><?php esc_html_e('Role / Title', 'starter-coat'); ?></p>
            </div>
          </article>
        <?php endfor; ?>
      </div>
    <?php endif; ?>
  </div>
</section>
