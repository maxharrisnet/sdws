<?php

/**
 * ACF field registration.
 *
 * @package Starter_Coat
 */

if (! defined('ABSPATH')) {
  exit;
}

/**
 * Register ACF options pages and fields.
 */
function starter_coat_register_acf_fields()
{
  if (! function_exists('acf_add_local_field_group')) {
    return;
  }

  $section_options = array(
    array(
      'key'           => 'field_sc_section_width',
      'label'         => __('Width', 'starter-coat'),
      'name'          => 'section_width',
      'type'          => 'select',
      'choices'       => array(
        'container' => __('Container', 'starter-coat'),
        'narrow'    => __('Narrow', 'starter-coat'),
        'full'      => __('Full Width', 'starter-coat'),
      ),
      'default_value' => 'container',
      'ui'            => 1,
    ),
    array(
      'key'           => 'field_sc_section_padding',
      'label'         => __('Padding', 'starter-coat'),
      'name'          => 'section_padding',
      'type'          => 'select',
      'choices'       => array(
        'sm' => __('Small', 'starter-coat'),
        'md' => __('Medium', 'starter-coat'),
        'lg' => __('Large', 'starter-coat'),
        'xl' => __('Extra Large', 'starter-coat'),
      ),
      'default_value' => 'lg',
      'ui'            => 1,
    ),
    array(
      'key'           => 'field_sc_section_background',
      'label'         => __('Background', 'starter-coat'),
      'name'          => 'section_background',
      'type'          => 'select',
      'choices'       => array(
        'none'  => __('Default', 'starter-coat'),
        'light' => __('Light', 'starter-coat'),
        'dark'  => __('Dark', 'starter-coat'),
        'brand' => __('Brand', 'starter-coat'),
        'muted' => __('Muted', 'starter-coat'),
      ),
      'default_value' => 'none',
      'ui'            => 1,
    ),
    array(
      'key'   => 'field_sc_section_class',
      'label' => __('Extra Class', 'starter-coat'),
      'name'  => 'section_class',
      'type'  => 'text',
      'instructions' => __('Optional utility class for this section.', 'starter-coat'),
    ),
  );

  if (function_exists('acf_add_options_page')) {
    call_user_func(
      'acf_add_options_page',
      array(
        'page_title' => __('Theme Settings', 'starter-coat'),
        'menu_title' => __('Theme Settings', 'starter-coat'),
        'menu_slug'  => 'starter-coat-theme-settings',
        'capability' => 'edit_posts',
        'redirect'   => false,
      )
    );
  }

  call_user_func(
    'acf_add_local_field_group',
    array(
      'key'    => 'group_sc_theme_settings',
      'title'  => __('Theme Preset', 'starter-coat'),
      'fields' => array(
        array(
          'key'           => 'field_sc_theme_preset',
          'label'         => __('Theme Preset', 'starter-coat'),
          'name'          => 'sc_theme_preset',
          'type'          => 'select',
          'choices'       => array(
            'jill'  => 'Jill',
            'yeezy' => 'Yeezy',
          ),
          'default_value' => 'jill',
          'ui'            => 1,
        ),
      ),
      'location' => array(
        array(
          array(
            'param'    => 'options_page',
            'operator' => '==',
            'value'    => 'starter-coat-theme-settings',
          ),
        ),
      ),
    )
  );

  call_user_func(
    'acf_add_local_field_group',
    array(
      'key'    => 'group_sc_page_sections',
      'title'  => __('Page Sections', 'starter-coat'),
      'fields' => array(
        array(
          'key'           => 'field_sc_sections',
          'label'         => __('Sections', 'starter-coat'),
          'name'          => 'sc_sections',
          'type'          => 'flexible_content',
          'button_label'  => __('Add Section', 'starter-coat'),
          'layouts'       => array(
            'layout_sc_text_media' => array(
              'key'        => 'layout_sc_text_media',
              'name'       => 'text_media',
              'label'      => __('1 Col Text / Media', 'starter-coat'),
              'display'    => 'block',
              'sub_fields' => array(
                array(
                  'key'   => 'field_sc_text_media_content',
                  'label' => __('Content', 'starter-coat'),
                  'name'  => 'content',
                  'type'  => 'wysiwyg',
                ),
                array(
                  'key'   => 'field_sc_text_media_media',
                  'label' => __('Media Image', 'starter-coat'),
                  'name'  => 'media_image',
                  'type'  => 'image',
                  'return_format' => 'array',
                  'preview_size'  => 'medium',
                ),
                array(
                  'key'           => 'field_sc_text_media_image_style',
                  'label'         => __('Image Style', 'starter-coat'),
                  'name'          => 'image_style',
                  'type'          => 'select',
                  'choices'       => array(
                    'soft'    => __('Soft Radius', 'starter-coat'),
                    'rounded' => __('Rounded', 'starter-coat'),
                    'sharp'   => __('Sharp', 'starter-coat'),
                  ),
                  'default_value' => 'soft',
                  'ui'            => 1,
                ),
                array(
                  'key'           => 'field_sc_text_media_media_position',
                  'label'         => __('Media Position', 'starter-coat'),
                  'name'          => 'media_position',
                  'type'          => 'select',
                  'choices'       => array(
                    'right' => __('Right', 'starter-coat'),
                    'left'  => __('Left', 'starter-coat'),
                  ),
                  'default_value' => 'right',
                  'ui'            => 1,
                ),
                array(
                  'key'   => 'field_sc_text_media_options_tab',
                  'label' => __('Section Options', 'starter-coat'),
                  'name'  => '',
                  'type'  => 'tab',
                ),
                ...$section_options,
              ),
            ),
            'layout_sc_feature' => array(
              'key'        => 'layout_sc_feature',
              'name'       => 'feature',
              'label'      => __('2 Col Feature', 'starter-coat'),
              'display'    => 'block',
              'sub_fields' => array(
                array(
                  'key'   => 'field_sc_feature_kicker',
                  'label' => __('Kicker', 'starter-coat'),
                  'name'  => 'kicker',
                  'type'  => 'text',
                ),
                array(
                  'key'   => 'field_sc_feature_title',
                  'label' => __('Title', 'starter-coat'),
                  'name'  => 'title',
                  'type'  => 'text',
                ),
                array(
                  'key'   => 'field_sc_feature_copy',
                  'label' => __('Copy', 'starter-coat'),
                  'name'  => 'copy',
                  'type'  => 'textarea',
                ),
                array(
                  'key'   => 'field_sc_feature_media_image',
                  'label' => __('Media Image', 'starter-coat'),
                  'name'  => 'media_image',
                  'type'  => 'image',
                  'return_format' => 'array',
                  'preview_size'  => 'medium',
                ),
                array(
                  'key'   => 'field_sc_feature_ratio',
                  'label' => __('Ratio', 'starter-coat'),
                  'name'  => 'ratio',
                  'type'  => 'select',
                  'choices' => array(
                    '50-50' => '50 / 50',
                    '66-33' => '2 / 3',
                  ),
                  'default_value' => '50-50',
                ),
                array(
                  'key'           => 'field_sc_feature_media_position',
                  'label'         => __('Media Position', 'starter-coat'),
                  'name'          => 'media_position',
                  'type'          => 'select',
                  'choices'       => array(
                    'left'  => __('Left', 'starter-coat'),
                    'right' => __('Right', 'starter-coat'),
                  ),
                  'default_value' => 'left',
                  'ui'            => 1,
                ),
                array(
                  'key'   => 'field_sc_feature_button',
                  'label' => __('Button', 'starter-coat'),
                  'name'  => 'button',
                  'type'  => 'link',
                ),
                array(
                  'key'   => 'field_sc_feature_options_tab',
                  'label' => __('Section Options', 'starter-coat'),
                  'name'  => '',
                  'type'  => 'tab',
                ),
                ...$section_options,
              ),
            ),
            'layout_sc_cards' => array(
              'key'        => 'layout_sc_cards',
              'name'       => 'cards',
              'label'      => __('3 Column Cards', 'starter-coat'),
              'display'    => 'block',
              'sub_fields' => array(
                array(
                  'key'   => 'field_sc_cards_heading',
                  'label' => __('Heading', 'starter-coat'),
                  'name'  => 'heading',
                  'type'  => 'text',
                ),
                array(
                  'key'   => 'field_sc_cards_intro',
                  'label' => __('Intro Copy', 'starter-coat'),
                  'name'  => 'intro',
                  'type'  => 'textarea',
                ),
                array(
                  'key'           => 'field_sc_cards_columns',
                  'label'         => __('Columns', 'starter-coat'),
                  'name'          => 'columns',
                  'type'          => 'select',
                  'choices'       => array(
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                  ),
                  'default_value' => '3',
                  'ui'            => 1,
                ),
                array(
                  'key'   => 'field_sc_cards_items',
                  'label' => __('Items', 'starter-coat'),
                  'name'  => 'items',
                  'type'  => 'repeater',
                  'sub_fields' => array(
                    array(
                      'key' => 'field_sc_card_pill',
                      'label' => __('Pill', 'starter-coat'),
                      'name' => 'pill',
                      'type' => 'text',
                    ),
                    array(
                      'key' => 'field_sc_card_title',
                      'label' => __('Title', 'starter-coat'),
                      'name' => 'title',
                      'type' => 'text',
                    ),
                    array(
                      'key' => 'field_sc_card_copy',
                      'label' => __('Copy', 'starter-coat'),
                      'name' => 'copy',
                      'type' => 'textarea',
                    ),
                    array(
                      'key' => 'field_sc_card_button',
                      'label' => __('Button', 'starter-coat'),
                      'name' => 'button',
                      'type' => 'link',
                    ),
                  ),
                ),
                array(
                  'key'   => 'field_sc_cards_options_tab',
                  'label' => __('Section Options', 'starter-coat'),
                  'name'  => '',
                  'type'  => 'tab',
                ),
                ...$section_options,
              ),
            ),
          ),
        ),
      ),
      'location' => array(
        array(
          array(
            'param'    => 'post_type',
            'operator' => '==',
            'value'    => 'page',
          ),
        ),
      ),
    )
  );

  call_user_func(
    'acf_add_local_field_group',
    array(
      'key'    => 'group_sc_singular_hero',
      'title'  => __('Hero - Singular', 'starter-coat'),
      'fields' => array(
        array(
          'key'   => 'field_sc_hero_enabled',
          'label' => __('Enable Hero', 'starter-coat'),
          'name'  => 'sc_hero_enabled',
          'type'  => 'true_false',
          'ui'    => 1,
        ),
        array(
          'key'   => 'field_sc_hero_content_tab',
          'label' => __('Content', 'starter-coat'),
          'name'  => '',
          'type'  => 'tab',
        ),
        array(
          'key'   => 'field_sc_hero_eyebrow_single',
          'label' => __('Eyebrow', 'starter-coat'),
          'name'  => 'sc_hero_eyebrow',
          'type'  => 'text',
          'conditional_logic' => array(
            array(
              array(
                'field'    => 'field_sc_hero_enabled',
                'operator' => '==',
                'value'    => '1',
              ),
            ),
          ),
        ),
        array(
          'key'   => 'field_sc_hero_title_single',
          'label' => __('Title (H1)', 'starter-coat'),
          'name'  => 'sc_hero_title',
          'type'  => 'text',
          'instructions' => __('If blank, the post/page title is used.', 'starter-coat'),
          'conditional_logic' => array(
            array(
              array(
                'field'    => 'field_sc_hero_enabled',
                'operator' => '==',
                'value'    => '1',
              ),
            ),
          ),
        ),
        array(
          'key'   => 'field_sc_hero_subheading',
          'label' => __('Subheading', 'starter-coat'),
          'name'  => 'sc_hero_subheading',
          'type'  => 'text',
          'conditional_logic' => array(
            array(
              array(
                'field'    => 'field_sc_hero_enabled',
                'operator' => '==',
                'value'    => '1',
              ),
            ),
          ),
        ),
        array(
          'key'   => 'field_sc_hero_paragraph',
          'label' => __('Paragraph', 'starter-coat'),
          'name'  => 'sc_hero_paragraph',
          'type'  => 'textarea',
          'conditional_logic' => array(
            array(
              array(
                'field'    => 'field_sc_hero_enabled',
                'operator' => '==',
                'value'    => '1',
              ),
            ),
          ),
        ),
        array(
          'key'   => 'field_sc_hero_buttons_tab',
          'label' => __('Buttons', 'starter-coat'),
          'name'  => '',
          'type'  => 'tab',
        ),
        array(
          'key'   => 'field_sc_hero_button_primary',
          'label' => __('Primary Button', 'starter-coat'),
          'name'  => 'sc_hero_button_primary',
          'type'  => 'link',
          'conditional_logic' => array(
            array(
              array(
                'field'    => 'field_sc_hero_enabled',
                'operator' => '==',
                'value'    => '1',
              ),
            ),
          ),
        ),
        array(
          'key'   => 'field_sc_hero_button_primary_style',
          'label' => __('Primary Button Style', 'starter-coat'),
          'name'  => 'sc_hero_button_primary_style',
          'type'  => 'select',
          'choices' => array(
            'primary'   => __('Primary', 'starter-coat'),
            'secondary' => __('Secondary', 'starter-coat'),
            'ghost'     => __('Ghost', 'starter-coat'),
          ),
          'default_value' => 'primary',
          'ui'            => 1,
          'conditional_logic' => array(
            array(
              array(
                'field'    => 'field_sc_hero_enabled',
                'operator' => '==',
                'value'    => '1',
              ),
            ),
          ),
        ),
        array(
          'key'   => 'field_sc_hero_button_secondary',
          'label' => __('Secondary Button', 'starter-coat'),
          'name'  => 'sc_hero_button_secondary',
          'type'  => 'link',
          'conditional_logic' => array(
            array(
              array(
                'field'    => 'field_sc_hero_enabled',
                'operator' => '==',
                'value'    => '1',
              ),
            ),
          ),
        ),
        array(
          'key'   => 'field_sc_hero_button_secondary_style',
          'label' => __('Secondary Button Style', 'starter-coat'),
          'name'  => 'sc_hero_button_secondary_style',
          'type'  => 'select',
          'choices' => array(
            'primary'   => __('Primary', 'starter-coat'),
            'secondary' => __('Secondary', 'starter-coat'),
            'ghost'     => __('Ghost', 'starter-coat'),
          ),
          'default_value' => 'ghost',
          'ui'            => 1,
          'conditional_logic' => array(
            array(
              array(
                'field'    => 'field_sc_hero_enabled',
                'operator' => '==',
                'value'    => '1',
              ),
            ),
          ),
        ),
        array(
          'key'   => 'field_sc_hero_media_tab',
          'label' => __('Media / Form', 'starter-coat'),
          'name'  => '',
          'type'  => 'tab',
        ),
        array(
          'key'   => 'field_sc_hero_media_type',
          'label' => __('Media Type', 'starter-coat'),
          'name'  => 'sc_hero_media_type',
          'type'  => 'select',
          'choices' => array(
            'none'  => __('None', 'starter-coat'),
            'image' => __('Image', 'starter-coat'),
            'video' => __('Video', 'starter-coat'),
            'form'  => __('Form', 'starter-coat'),
          ),
          'default_value' => 'none',
          'ui'            => 1,
          'conditional_logic' => array(
            array(
              array(
                'field'    => 'field_sc_hero_enabled',
                'operator' => '==',
                'value'    => '1',
              ),
            ),
          ),
        ),
        array(
          'key'   => 'field_sc_hero_media_position',
          'label' => __('Media Position', 'starter-coat'),
          'name'  => 'sc_hero_media_position',
          'type'  => 'select',
          'choices' => array(
            'right' => __('Right', 'starter-coat'),
            'left'  => __('Left', 'starter-coat'),
          ),
          'default_value' => 'right',
          'ui'            => 1,
          'conditional_logic' => array(
            array(
              array(
                'field'    => 'field_sc_hero_enabled',
                'operator' => '==',
                'value'    => '1',
              ),
            ),
          ),
        ),
        array(
          'key'   => 'field_sc_hero_image_single',
          'label' => __('Image', 'starter-coat'),
          'name'  => 'sc_hero_image',
          'type'  => 'image',
          'return_format' => 'array',
          'preview_size'  => 'medium',
          'conditional_logic' => array(
            array(
              array(
                'field'    => 'field_sc_hero_media_type',
                'operator' => '==',
                'value'    => 'image',
              ),
            ),
          ),
        ),
        array(
          'key'   => 'field_sc_hero_image_style',
          'label' => __('Image Style', 'starter-coat'),
          'name'  => 'sc_hero_image_style',
          'type'  => 'select',
          'choices' => array(
            'soft'    => __('Soft Radius', 'starter-coat'),
            'rounded' => __('Rounded', 'starter-coat'),
            'sharp'   => __('Sharp', 'starter-coat'),
          ),
          'default_value' => 'rounded',
          'ui'            => 1,
          'conditional_logic' => array(
            array(
              array(
                'field'    => 'field_sc_hero_media_type',
                'operator' => '==',
                'value'    => 'image',
              ),
            ),
          ),
        ),
        array(
          'key'   => 'field_sc_hero_video_embed',
          'label' => __('Video Embed', 'starter-coat'),
          'name'  => 'sc_hero_video_embed',
          'type'  => 'textarea',
          'instructions' => __('Paste iframe embed code for YouTube/Vimeo/etc.', 'starter-coat'),
          'conditional_logic' => array(
            array(
              array(
                'field'    => 'field_sc_hero_media_type',
                'operator' => '==',
                'value'    => 'video',
              ),
            ),
          ),
        ),
        array(
          'key'   => 'field_sc_hero_video_url',
          'label' => __('Video URL (MP4)', 'starter-coat'),
          'name'  => 'sc_hero_video_url',
          'type'  => 'url',
          'conditional_logic' => array(
            array(
              array(
                'field'    => 'field_sc_hero_media_type',
                'operator' => '==',
                'value'    => 'video',
              ),
            ),
          ),
        ),
        array(
          'key'   => 'field_sc_hero_form_shortcode',
          'label' => __('Form Shortcode', 'starter-coat'),
          'name'  => 'sc_hero_form_shortcode',
          'type'  => 'text',
          'instructions' => __('Preferred: paste plugin shortcode.', 'starter-coat'),
          'conditional_logic' => array(
            array(
              array(
                'field'    => 'field_sc_hero_media_type',
                'operator' => '==',
                'value'    => 'form',
              ),
            ),
          ),
        ),
        array(
          'key'   => 'field_sc_hero_form_provider',
          'label' => __('Form Provider', 'starter-coat'),
          'name'  => 'sc_hero_form_provider',
          'type'  => 'select',
          'choices' => array(
            'generic' => __('Generic', 'starter-coat'),
            'wpforms' => __('WPForms', 'starter-coat'),
            'hubspot' => __('HubSpot', 'starter-coat'),
          ),
          'default_value' => 'generic',
          'ui'            => 1,
          'conditional_logic' => array(
            array(
              array(
                'field'    => 'field_sc_hero_media_type',
                'operator' => '==',
                'value'    => 'form',
              ),
            ),
          ),
        ),
        array(
          'key'   => 'field_sc_hero_form_id',
          'label' => __('Form ID', 'starter-coat'),
          'name'  => 'sc_hero_form_id',
          'type'  => 'text',
          'instructions' => __('Fallback if shortcode is not used.', 'starter-coat'),
          'conditional_logic' => array(
            array(
              array(
                'field'    => 'field_sc_hero_media_type',
                'operator' => '==',
                'value'    => 'form',
              ),
            ),
          ),
        ),
        array(
          'key'   => 'field_sc_hero_style_tab',
          'label' => __('Style', 'starter-coat'),
          'name'  => '',
          'type'  => 'tab',
        ),
        array(
          'key'   => 'field_sc_hero_variant',
          'label' => __('Hero Variation', 'starter-coat'),
          'name'  => 'sc_hero_variant',
          'type'  => 'select',
          'choices' => array(
            'page-centered'  => __('Page: Centered', 'starter-coat'),
            'page-split'     => __('Page: Two Column', 'starter-coat'),
            'page-fullheight' => __('Page: Full Height (100vh)', 'starter-coat'),
            'entry-centered' => __('Single/CPT: Centered', 'starter-coat'),
            'entry-split'    => __('Single/CPT: Two Column', 'starter-coat'),
          ),
          'default_value' => 'page-centered',
          'ui'            => 1,
          'conditional_logic' => array(
            array(
              array(
                'field'    => 'field_sc_hero_enabled',
                'operator' => '==',
                'value'    => '1',
              ),
            ),
          ),
        ),
        array(
          'key'   => 'field_sc_hero_text_box_style',
          'label' => __('Text Box Style', 'starter-coat'),
          'name'  => 'sc_hero_text_box_style',
          'type'  => 'select',
          'choices' => array(
            'none'    => __('None', 'starter-coat'),
            'surface' => __('Surface', 'starter-coat'),
            'outline' => __('Outline', 'starter-coat'),
          ),
          'default_value' => 'none',
          'ui'            => 1,
          'conditional_logic' => array(
            array(
              array(
                'field'    => 'field_sc_hero_enabled',
                'operator' => '==',
                'value'    => '1',
              ),
            ),
          ),
        ),
        array(
          'key'   => 'field_sc_hero_background',
          'label' => __('Background', 'starter-coat'),
          'name'  => 'sc_hero_background',
          'type'  => 'select',
          'choices' => array(
            'none'  => __('Default', 'starter-coat'),
            'light' => __('Light', 'starter-coat'),
            'dark'  => __('Dark', 'starter-coat'),
            'brand' => __('Brand', 'starter-coat'),
            'muted' => __('Muted', 'starter-coat'),
          ),
          'default_value' => 'none',
          'ui'            => 1,
          'conditional_logic' => array(
            array(
              array(
                'field'    => 'field_sc_hero_enabled',
                'operator' => '==',
                'value'    => '1',
              ),
            ),
          ),
        ),
        array(
          'key'   => 'field_sc_hero_full_height',
          'label' => __('Force 100vh', 'starter-coat'),
          'name'  => 'sc_hero_full_height',
          'type'  => 'true_false',
          'ui'    => 1,
          'conditional_logic' => array(
            array(
              array(
                'field'    => 'field_sc_hero_enabled',
                'operator' => '==',
                'value'    => '1',
              ),
            ),
          ),
        ),
      ),
      'location' => array(
        array(
          array(
            'param'    => 'post_type',
            'operator' => '==',
            'value'    => 'page',
          ),
        ),
        array(
          array(
            'param'    => 'post_type',
            'operator' => '==',
            'value'    => 'post',
          ),
        ),
        array(
          array(
            'param'    => 'post_type',
            'operator' => '==',
            'value'    => 'project',
          ),
        ),
        array(
          array(
            'param'    => 'post_type',
            'operator' => '==',
            'value'    => 'event',
          ),
        ),
        array(
          array(
            'param'    => 'post_type',
            'operator' => '==',
            'value'    => 'faq',
          ),
        ),
        array(
          array(
            'param'    => 'post_type',
            'operator' => '==',
            'value'    => 'profile',
          ),
        ),
      ),
    )
  );

  call_user_func(
    'acf_add_local_field_group',
    array(
      'key'    => 'group_sc_archive_hero_options',
      'title'  => __('Archive Hero Variations', 'starter-coat'),
      'fields' => array(
        array(
          'key'   => 'field_sc_archive_hero_items',
          'label' => __('Archive Hero Items', 'starter-coat'),
          'name'  => 'sc_archive_hero_items',
          'type'  => 'repeater',
          'button_label' => __('Add Archive Hero', 'starter-coat'),
          'layout' => 'block',
          'sub_fields' => array(
            array(
              'key'   => 'field_sc_archive_hero_post_type',
              'label' => __('Post Type', 'starter-coat'),
              'name'  => 'post_type',
              'type'  => 'select',
              'choices' => array(
                'post'    => __('Post', 'starter-coat'),
                'project' => __('Project', 'starter-coat'),
                'event'   => __('Event', 'starter-coat'),
                'faq'     => __('FAQ', 'starter-coat'),
                'profile' => __('Profile', 'starter-coat'),
              ),
              'ui' => 1,
            ),
            array(
              'key'   => 'field_sc_archive_hero_enabled',
              'label' => __('Enable Hero', 'starter-coat'),
              'name'  => 'enabled',
              'type'  => 'true_false',
              'ui'    => 1,
            ),
            array(
              'key'   => 'field_sc_archive_hero_variant',
              'label' => __('Hero Variation', 'starter-coat'),
              'name'  => 'variant',
              'type'  => 'select',
              'choices' => array(
                'archive-centered' => __('Archive: Centered', 'starter-coat'),
                'archive-split'    => __('Archive: Two Column', 'starter-coat'),
              ),
              'default_value' => 'archive-centered',
              'ui'            => 1,
            ),
            array(
              'key'   => 'field_sc_archive_hero_eyebrow',
              'label' => __('Eyebrow', 'starter-coat'),
              'name'  => 'eyebrow',
              'type'  => 'text',
            ),
            array(
              'key'   => 'field_sc_archive_hero_title',
              'label' => __('Title (H1)', 'starter-coat'),
              'name'  => 'title',
              'type'  => 'text',
            ),
            array(
              'key'   => 'field_sc_archive_hero_subheading',
              'label' => __('Subheading', 'starter-coat'),
              'name'  => 'subheading',
              'type'  => 'text',
            ),
            array(
              'key'   => 'field_sc_archive_hero_paragraph',
              'label' => __('Paragraph', 'starter-coat'),
              'name'  => 'paragraph',
              'type'  => 'textarea',
            ),
            array(
              'key'   => 'field_sc_archive_hero_button_primary',
              'label' => __('Primary Button', 'starter-coat'),
              'name'  => 'button_primary',
              'type'  => 'link',
            ),
            array(
              'key'   => 'field_sc_archive_hero_button_primary_style',
              'label' => __('Primary Button Style', 'starter-coat'),
              'name'  => 'button_primary_style',
              'type'  => 'select',
              'choices' => array(
                'primary'   => __('Primary', 'starter-coat'),
                'secondary' => __('Secondary', 'starter-coat'),
                'ghost'     => __('Ghost', 'starter-coat'),
              ),
              'default_value' => 'primary',
              'ui'            => 1,
            ),
            array(
              'key'   => 'field_sc_archive_hero_button_secondary',
              'label' => __('Secondary Button', 'starter-coat'),
              'name'  => 'button_secondary',
              'type'  => 'link',
            ),
            array(
              'key'   => 'field_sc_archive_hero_button_secondary_style',
              'label' => __('Secondary Button Style', 'starter-coat'),
              'name'  => 'button_secondary_style',
              'type'  => 'select',
              'choices' => array(
                'primary'   => __('Primary', 'starter-coat'),
                'secondary' => __('Secondary', 'starter-coat'),
                'ghost'     => __('Ghost', 'starter-coat'),
              ),
              'default_value' => 'ghost',
              'ui'            => 1,
            ),
            array(
              'key'   => 'field_sc_archive_hero_media_type',
              'label' => __('Media Type', 'starter-coat'),
              'name'  => 'media_type',
              'type'  => 'select',
              'choices' => array(
                'none'  => __('None', 'starter-coat'),
                'image' => __('Image', 'starter-coat'),
                'video' => __('Video', 'starter-coat'),
                'form'  => __('Form', 'starter-coat'),
              ),
              'default_value' => 'none',
              'ui'            => 1,
            ),
            array(
              'key'   => 'field_sc_archive_hero_media_position',
              'label' => __('Media Position', 'starter-coat'),
              'name'  => 'media_position',
              'type'  => 'select',
              'choices' => array(
                'right' => __('Right', 'starter-coat'),
                'left'  => __('Left', 'starter-coat'),
              ),
              'default_value' => 'right',
              'ui'            => 1,
            ),
            array(
              'key'   => 'field_sc_archive_hero_image',
              'label' => __('Image', 'starter-coat'),
              'name'  => 'image',
              'type'  => 'image',
              'return_format' => 'array',
              'preview_size'  => 'medium',
            ),
            array(
              'key'   => 'field_sc_archive_hero_image_style',
              'label' => __('Image Style', 'starter-coat'),
              'name'  => 'image_style',
              'type'  => 'select',
              'choices' => array(
                'soft'    => __('Soft Radius', 'starter-coat'),
                'rounded' => __('Rounded', 'starter-coat'),
                'sharp'   => __('Sharp', 'starter-coat'),
              ),
              'default_value' => 'rounded',
              'ui'            => 1,
            ),
            array(
              'key'   => 'field_sc_archive_hero_video_embed',
              'label' => __('Video Embed', 'starter-coat'),
              'name'  => 'video_embed',
              'type'  => 'textarea',
            ),
            array(
              'key'   => 'field_sc_archive_hero_video_url',
              'label' => __('Video URL (MP4)', 'starter-coat'),
              'name'  => 'video_url',
              'type'  => 'url',
            ),
            array(
              'key'   => 'field_sc_archive_hero_form_shortcode',
              'label' => __('Form Shortcode', 'starter-coat'),
              'name'  => 'form_shortcode',
              'type'  => 'text',
            ),
            array(
              'key'   => 'field_sc_archive_hero_form_provider',
              'label' => __('Form Provider', 'starter-coat'),
              'name'  => 'form_provider',
              'type'  => 'select',
              'choices' => array(
                'generic' => __('Generic', 'starter-coat'),
                'wpforms' => __('WPForms', 'starter-coat'),
                'hubspot' => __('HubSpot', 'starter-coat'),
              ),
              'default_value' => 'generic',
              'ui'            => 1,
            ),
            array(
              'key'   => 'field_sc_archive_hero_form_id',
              'label' => __('Form ID', 'starter-coat'),
              'name'  => 'form_id',
              'type'  => 'text',
            ),
            array(
              'key'   => 'field_sc_archive_hero_text_box_style',
              'label' => __('Text Box Style', 'starter-coat'),
              'name'  => 'text_box_style',
              'type'  => 'select',
              'choices' => array(
                'none'    => __('None', 'starter-coat'),
                'surface' => __('Surface', 'starter-coat'),
                'outline' => __('Outline', 'starter-coat'),
              ),
              'default_value' => 'none',
              'ui'            => 1,
            ),
            array(
              'key'   => 'field_sc_archive_hero_background',
              'label' => __('Background', 'starter-coat'),
              'name'  => 'background',
              'type'  => 'select',
              'choices' => array(
                'none'  => __('Default', 'starter-coat'),
                'light' => __('Light', 'starter-coat'),
                'dark'  => __('Dark', 'starter-coat'),
                'brand' => __('Brand', 'starter-coat'),
                'muted' => __('Muted', 'starter-coat'),
              ),
              'default_value' => 'none',
              'ui'            => 1,
            ),
            array(
              'key'   => 'field_sc_archive_hero_full_height',
              'label' => __('Force 100vh', 'starter-coat'),
              'name'  => 'full_height',
              'type'  => 'true_false',
              'ui'    => 1,
            ),
          ),
        ),
      ),
      'location' => array(
        array(
          array(
            'param'    => 'options_page',
            'operator' => '==',
            'value'    => 'starter-coat-theme-settings',
          ),
        ),
      ),
    )
  );

  call_user_func(
    'acf_add_local_field_group',
    array(
      'key'    => 'group_sc_contact_template',
      'title'  => __('Contact Template Fields', 'starter-coat'),
      'fields' => array(
        array(
          'key'   => 'field_sc_contact_intro',
          'label' => __('Intro Content', 'starter-coat'),
          'name'  => 'sc_contact_intro',
          'type'  => 'wysiwyg',
        ),
        array(
          'key'   => 'field_sc_contact_form_shortcode',
          'label' => __('Form Shortcode', 'starter-coat'),
          'name'  => 'sc_contact_form_shortcode',
          'type'  => 'text',
        ),
        array(
          'key'   => 'field_sc_contact_map_embed',
          'label' => __('Map Embed', 'starter-coat'),
          'name'  => 'sc_contact_map_embed',
          'type'  => 'textarea',
        ),
      ),
      'location' => array(
        array(
          array(
            'param'    => 'page_template',
            'operator' => '==',
            'value'    => 'templates/template-contact.php',
          ),
        ),
      ),
    )
  );

  call_user_func(
    'acf_add_local_field_group',
    array(
      'key'    => 'group_sc_archive_template',
      'title'  => __('Archive Template Fields', 'starter-coat'),
      'fields' => array(
        array(
          'key'   => 'field_sc_archive_post_type',
          'label' => __('Archive Post Type', 'starter-coat'),
          'name'  => 'sc_archive_post_type',
          'type'  => 'select',
          'choices' => array(
            'post'    => __('Post', 'starter-coat'),
            'project' => __('Project', 'starter-coat'),
            'event'   => __('Event', 'starter-coat'),
            'faq'     => __('FAQ', 'starter-coat'),
            'profile' => __('Profile', 'starter-coat'),
          ),
          'default_value' => 'post',
          'ui'            => 1,
        ),
        array(
          'key'   => 'field_sc_archive_featured_item',
          'label' => __('Featured Item', 'starter-coat'),
          'name'  => 'sc_archive_featured_item',
          'type'  => 'post_object',
          'return_format' => 'id',
          'allow_null'    => 1,
        ),
        array(
          'key'   => 'field_sc_archive_taxonomy',
          'label' => __('Filter Taxonomy', 'starter-coat'),
          'name'  => 'sc_archive_taxonomy',
          'type'  => 'text',
          'instructions' => __('Example: category, project_category, event_type', 'starter-coat'),
        ),
        array(
          'key'           => 'field_sc_archive_items_per_page',
          'label'         => __('Items Per Page', 'starter-coat'),
          'name'          => 'sc_archive_items_per_page',
          'type'          => 'number',
          'default_value' => 12,
          'min'           => 1,
          'max'           => 48,
        ),
      ),
      'location' => array(
        array(
          array(
            'param'    => 'page_template',
            'operator' => '==',
            'value'    => 'templates/template-archive.php',
          ),
        ),
      ),
    )
  );
}
add_action('acf/init', 'starter_coat_register_acf_fields');
