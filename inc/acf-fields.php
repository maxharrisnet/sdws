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
            'layout_sc_hero' => array(
              'key'        => 'layout_sc_hero',
              'name'       => 'hero',
              'label'      => __('Hero', 'starter-coat'),
              'display'    => 'block',
              'sub_fields' => array(
                array(
                  'key'   => 'field_sc_hero_title',
                  'label' => __('Title', 'starter-coat'),
                  'name'  => 'title',
                  'type'  => 'text',
                ),
                array(
                  'key'   => 'field_sc_hero_copy',
                  'label' => __('Copy', 'starter-coat'),
                  'name'  => 'copy',
                  'type'  => 'textarea',
                ),
              ),
            ),
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
              ),
            ),
            'layout_sc_feature' => array(
              'key'        => 'layout_sc_feature',
              'name'       => 'feature',
              'label'      => __('2 Col Feature', 'starter-coat'),
              'display'    => 'block',
              'sub_fields' => array(
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
              ),
            ),
            'layout_sc_cards' => array(
              'key'        => 'layout_sc_cards',
              'name'       => 'cards',
              'label'      => __('3 Column Cards', 'starter-coat'),
              'display'    => 'block',
              'sub_fields' => array(
                array(
                  'key'   => 'field_sc_cards_items',
                  'label' => __('Items', 'starter-coat'),
                  'name'  => 'items',
                  'type'  => 'repeater',
                  'sub_fields' => array(
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
                  ),
                ),
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
}
add_action('acf/init', 'starter_coat_register_acf_fields');
