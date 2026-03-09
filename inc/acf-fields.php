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
      'key'           => 'field_sc_section_content_width',
      'label'         => __('Content Max Width', 'starter-coat'),
      'name'          => 'section_content_width',
      'type'          => 'select',
      'choices'       => array(
        'inherit'   => __('Inherit From Width', 'starter-coat'),
        'container' => __('Container', 'starter-coat'),
        'wide'      => __('Wide', 'starter-coat'),
        'narrow'    => __('Narrow', 'starter-coat'),
      ),
      'default_value' => 'inherit',
      'ui'            => 1,
      'instructions'  => __('Useful with Full Width sections to keep content constrained.', 'starter-coat'),
    ),
    array(
      'key'           => 'field_sc_section_padding',
      'label'         => __('Padding', 'starter-coat'),
      'name'          => 'section_padding',
      'type'          => 'select',
      'choices'       => array(
        'small'  => __('Small', 'starter-coat'),
        'normal' => __('Normal', 'starter-coat'),
        'large'  => __('Large', 'starter-coat'),
        'xl'     => __('Extra Large', 'starter-coat'),
      ),
      'default_value' => 'normal',
      'ui'            => 1,
    ),
    array(
      'key'           => 'field_sc_section_background',
      'label'         => __('Background', 'starter-coat'),
      'name'          => 'section_background',
      'type'          => 'radio',
      'choices'       => array(
        'none'  => __('Default', 'starter-coat'),
        'light' => __('Light', 'starter-coat'),
        'dark'  => __('Dark', 'starter-coat'),
        'brand' => __('Brand', 'starter-coat'),
        'muted' => __('Muted', 'starter-coat'),
      ),
      'default_value' => 'none',
      'layout'        => 'horizontal',
      'wrapper'       => array(
        'class' => 'sc-acf-color-palette',
      ),
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
        array(
          'key'   => 'field_sc_theme_branding_tab',
          'label' => __('Branding', 'starter-coat'),
          'name'  => '',
          'type'  => 'tab',
        ),
        array(
          'key'   => 'field_sc_site_favicon',
          'label' => __('Favicon', 'starter-coat'),
          'name'  => 'sc_site_favicon',
          'type'  => 'image',
          'return_format' => 'array',
          'preview_size'  => 'thumbnail',
          'instructions'  => __('Optional fallback favicon (used when Site Icon is not set in Customizer).', 'starter-coat'),
          'mime_types'    => 'ico,png,svg,webp',
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
      'key'    => 'group_sc_nav_settings',
      'title'  => __('Navigation Settings', 'starter-coat'),
      'fields' => array(
        array(
          'key'   => 'field_sc_nav_layout_tab',
          'label' => __('Layout', 'starter-coat'),
          'name'  => '',
          'type'  => 'tab',
        ),
        array(
          'key'   => 'field_sc_nav_variant',
          'label' => __('Nav Layout', 'starter-coat'),
          'name'  => 'sc_nav_variant',
          'type'  => 'select',
          'choices' => array(
            'inline'   => __('Inline: Brand Left, Menu Right', 'starter-coat'),
            'centered' => __('Centered: Stacked Brand/Menu', 'starter-coat'),
            'split'    => __('Split: Brand Left, Menu Center, CTA Right', 'starter-coat'),
          ),
          'default_value' => 'inline',
          'ui'            => 1,
        ),
        array(
          'key'   => 'field_sc_nav_style',
          'label' => __('Nav Style', 'starter-coat'),
          'name'  => 'sc_nav_style',
          'type'  => 'select',
          'choices' => array(
            'clean'       => __('Clean', 'starter-coat'),
            'outlined'    => __('Outlined', 'starter-coat'),
            'soft'        => __('Soft Surface', 'starter-coat'),
            'transparent' => __('Transparent To Solid', 'starter-coat'),
          ),
          'default_value' => 'clean',
          'ui'            => 1,
        ),
        array(
          'key'   => 'field_sc_nav_alignment',
          'label' => __('Alignment', 'starter-coat'),
          'name'  => 'sc_nav_alignment',
          'type'  => 'select',
          'choices' => array(
            'between' => __('Brand Left / Menu Right', 'starter-coat'),
            'left'    => __('All Left', 'starter-coat'),
            'center'  => __('Centered', 'starter-coat'),
          ),
          'default_value' => 'between',
          'ui'            => 1,
        ),
        array(
          'key'   => 'field_sc_nav_item_style',
          'label' => __('Menu Item Style', 'starter-coat'),
          'name'  => 'sc_nav_item_style',
          'type'  => 'select',
          'choices' => array(
            'text'   => __('Text', 'starter-coat'),
            'button' => __('Button-like', 'starter-coat'),
          ),
          'default_value' => 'text',
          'ui'            => 1,
        ),
        array(
          'key'   => 'field_sc_nav_item_shape',
          'label' => __('Rounding', 'starter-coat'),
          'name'  => 'sc_nav_item_shape',
          'type'  => 'select',
          'choices' => array(
            'none' => __('None', 'starter-coat'),
            'soft' => __('Soft', 'starter-coat'),
            'pill' => __('Pill', 'starter-coat'),
          ),
          'default_value' => 'soft',
          'ui'            => 1,
        ),
        array(
          'key'   => 'field_sc_nav_dropdown_style',
          'label' => __('Dropdown Style', 'starter-coat'),
          'name'  => 'sc_nav_dropdown_style',
          'type'  => 'select',
          'choices' => array(
            'minimal'  => __('Minimal', 'starter-coat'),
            'elevated' => __('Elevated', 'starter-coat'),
          ),
          'default_value' => 'elevated',
          'ui'            => 1,
        ),
        array(
          'key'           => 'field_sc_nav_fixed',
          'label'         => __('Fixed Header', 'starter-coat'),
          'name'          => 'sc_nav_fixed',
          'type'          => 'true_false',
          'ui'            => 1,
          'default_value' => 1,
        ),
        array(
          'key'   => 'field_sc_nav_logo_tab',
          'label' => __('Logo', 'starter-coat'),
          'name'  => '',
          'type'  => 'tab',
        ),
        array(
          'key'           => 'field_sc_nav_show_logo',
          'label'         => __('Show Branding', 'starter-coat'),
          'name'          => 'sc_nav_show_logo',
          'type'          => 'true_false',
          'ui'            => 1,
          'default_value' => 1,
        ),
        array(
          'key'   => 'field_sc_nav_logo_mode',
          'label' => __('Logo Source', 'starter-coat'),
          'name'  => 'sc_nav_logo_mode',
          'type'  => 'select',
          'choices' => array(
            'custom_logo' => __('Custom Logo (Customizer)', 'starter-coat'),
            'image'       => __('Image (Option)', 'starter-coat'),
            'site_name'   => __('Site Name Text', 'starter-coat'),
          ),
          'default_value' => 'custom_logo',
          'ui'            => 1,
          'conditional_logic' => array(
            array(
              array(
                'field'    => 'field_sc_nav_show_logo',
                'operator' => '==',
                'value'    => '1',
              ),
            ),
          ),
        ),
        array(
          'key'   => 'field_sc_nav_logo_image',
          'label' => __('Logo Image', 'starter-coat'),
          'name'  => 'sc_nav_logo_image',
          'type'  => 'image',
          'return_format' => 'array',
          'preview_size'  => 'medium',
          'mime_types'    => 'jpg,jpeg,png,webp,svg',
          'conditional_logic' => array(
            array(
              array(
                'field'    => 'field_sc_nav_logo_mode',
                'operator' => '==',
                'value'    => 'image',
              ),
            ),
          ),
        ),
        array(
          'key'   => 'field_sc_nav_logo_mark_image',
          'label' => __('Mobile Logo Mark (Square)', 'starter-coat'),
          'name'  => 'sc_nav_logo_mark_image',
          'type'  => 'image',
          'return_format' => 'array',
          'preview_size'  => 'thumbnail',
          'mime_types'    => 'jpg,jpeg,png,webp,svg',
          'instructions'  => __('Optional square logo shown on smaller screens.', 'starter-coat'),
          'conditional_logic' => array(
            array(
              array(
                'field'    => 'field_sc_nav_show_logo',
                'operator' => '==',
                'value'    => '1',
              ),
            ),
          ),
        ),
        array(
          'key'           => 'field_sc_nav_logo_max_width',
          'label'         => __('Primary Logo Max Width (Desktop px)', 'starter-coat'),
          'name'          => 'sc_nav_logo_max_width',
          'type'          => 'number',
          'default_value' => 180,
          'min'           => 80,
          'max'           => 360,
          'step'          => 1,
          'conditional_logic' => array(
            array(
              array(
                'field'    => 'field_sc_nav_show_logo',
                'operator' => '==',
                'value'    => '1',
              ),
            ),
          ),
        ),
        array(
          'key'           => 'field_sc_nav_logo_mark_max_width',
          'label'         => __('Mobile Logo Mark Max Width (px)', 'starter-coat'),
          'name'          => 'sc_nav_logo_mark_max_width',
          'type'          => 'number',
          'default_value' => 48,
          'min'           => 24,
          'max'           => 120,
          'step'          => 1,
          'conditional_logic' => array(
            array(
              array(
                'field'    => 'field_sc_nav_show_logo',
                'operator' => '==',
                'value'    => '1',
              ),
              array(
                'field'    => 'field_sc_nav_logo_mark_image',
                'operator' => '!=empty',
              ),
            ),
          ),
        ),
        array(
          'key'           => 'field_sc_nav_logo_mark_breakpoint',
          'label'         => __('Logo Mark Breakpoint (px)', 'starter-coat'),
          'name'          => 'sc_nav_logo_mark_breakpoint',
          'type'          => 'number',
          'default_value' => 1024,
          'min'           => 480,
          'max'           => 1600,
          'step'          => 1,
          'instructions'  => __('Below this width, the square logo mark replaces the primary logo.', 'starter-coat'),
          'conditional_logic' => array(
            array(
              array(
                'field'    => 'field_sc_nav_show_logo',
                'operator' => '==',
                'value'    => '1',
              ),
              array(
                'field'    => 'field_sc_nav_logo_mark_image',
                'operator' => '!=empty',
              ),
            ),
          ),
        ),
        array(
          'key'   => 'field_sc_nav_cta_tab',
          'label' => __('CTA', 'starter-coat'),
          'name'  => '',
          'type'  => 'tab',
        ),
        array(
          'key'           => 'field_sc_nav_show_cta',
          'label'         => __('Show Nav CTA', 'starter-coat'),
          'name'          => 'sc_nav_show_cta',
          'type'          => 'true_false',
          'ui'            => 1,
          'default_value' => 0,
        ),
        array(
          'key'   => 'field_sc_nav_cta_link',
          'label' => __('CTA Link', 'starter-coat'),
          'name'  => 'sc_nav_cta_link',
          'type'  => 'link',
          'conditional_logic' => array(
            array(
              array(
                'field'    => 'field_sc_nav_show_cta',
                'operator' => '==',
                'value'    => '1',
              ),
            ),
          ),
        ),
        array(
          'key'   => 'field_sc_nav_cta_style',
          'label' => __('CTA Style', 'starter-coat'),
          'name'  => 'sc_nav_cta_style',
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
                'field'    => 'field_sc_nav_show_cta',
                'operator' => '==',
                'value'    => '1',
              ),
            ),
          ),
        ),
        array(
          'key'   => 'field_sc_nav_social_tab',
          'label' => __('Social', 'starter-coat'),
          'name'  => '',
          'type'  => 'tab',
        ),
        array(
          'key'           => 'field_sc_nav_show_social',
          'label'         => __('Show Social Links In Header', 'starter-coat'),
          'name'          => 'sc_nav_show_social',
          'type'          => 'true_false',
          'ui'            => 1,
          'default_value' => 0,
          'instructions'  => __('Uses URLs from Theme Settings > Social Media Links.', 'starter-coat'),
        ),
        array(
          'key'   => 'field_sc_nav_social_style',
          'label' => __('Social Links Style', 'starter-coat'),
          'name'  => 'sc_nav_social_style',
          'type'  => 'select',
          'choices' => array(
            'icon' => __('Icon', 'starter-coat'),
            'text' => __('Text', 'starter-coat'),
          ),
          'default_value' => 'icon',
          'ui'            => 1,
          'conditional_logic' => array(
            array(
              array(
                'field'    => 'field_sc_nav_show_social',
                'operator' => '==',
                'value'    => '1',
              ),
            ),
          ),
        ),
        array(
          'key'   => 'field_sc_nav_banner_tab',
          'label' => __('Banner', 'starter-coat'),
          'name'  => '',
          'type'  => 'tab',
        ),
        array(
          'key'           => 'field_sc_nav_banner_enabled',
          'label'         => __('Enable Top Banner', 'starter-coat'),
          'name'          => 'sc_nav_banner_enabled',
          'type'          => 'true_false',
          'ui'            => 1,
          'default_value' => 0,
        ),
        array(
          'key'   => 'field_sc_nav_banner_text',
          'label' => __('Banner Text', 'starter-coat'),
          'name'  => 'sc_nav_banner_text',
          'type'  => 'text',
          'conditional_logic' => array(
            array(
              array(
                'field'    => 'field_sc_nav_banner_enabled',
                'operator' => '==',
                'value'    => '1',
              ),
            ),
          ),
        ),
        array(
          'key'   => 'field_sc_nav_banner_link',
          'label' => __('Banner Link (optional)', 'starter-coat'),
          'name'  => 'sc_nav_banner_link',
          'type'  => 'link',
          'conditional_logic' => array(
            array(
              array(
                'field'    => 'field_sc_nav_banner_enabled',
                'operator' => '==',
                'value'    => '1',
              ),
            ),
          ),
        ),
        array(
          'key'   => 'field_sc_nav_banner_style',
          'label' => __('Banner Style', 'starter-coat'),
          'name'  => 'sc_nav_banner_style',
          'type'  => 'select',
          'choices' => array(
            'dark'  => __('Dark', 'starter-coat'),
            'light' => __('Light', 'starter-coat'),
            'brand' => __('Brand', 'starter-coat'),
          ),
          'default_value' => 'dark',
          'ui'            => 1,
          'conditional_logic' => array(
            array(
              array(
                'field'    => 'field_sc_nav_banner_enabled',
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
      'key'    => 'group_sc_global_cta_settings',
      'title'  => __('Global CTA Settings', 'starter-coat'),
      'fields' => array(
        array(
          'key'   => 'field_sc_global_cta_enabled',
          'label' => __('Enable Global CTA', 'starter-coat'),
          'name'  => 'sc_global_cta_enabled',
          'type'  => 'true_false',
          'ui'    => 1,
        ),
        array(
          'key'   => 'field_sc_global_cta_content_tab',
          'label' => __('Content', 'starter-coat'),
          'name'  => '',
          'type'  => 'tab',
        ),
        array(
          'key'   => 'field_sc_global_cta_eyebrow',
          'label' => __('Eyebrow', 'starter-coat'),
          'name'  => 'sc_global_cta_eyebrow',
          'type'  => 'text',
        ),
        array(
          'key'   => 'field_sc_global_cta_title',
          'label' => __('Title', 'starter-coat'),
          'name'  => 'sc_global_cta_title',
          'type'  => 'text',
        ),
        array(
          'key'   => 'field_sc_global_cta_subheading',
          'label' => __('Subheading', 'starter-coat'),
          'name'  => 'sc_global_cta_subheading',
          'type'  => 'text',
        ),
        array(
          'key'   => 'field_sc_global_cta_paragraph',
          'label' => __('Paragraph', 'starter-coat'),
          'name'  => 'sc_global_cta_paragraph',
          'type'  => 'textarea',
        ),
        array(
          'key'   => 'field_sc_global_cta_buttons_tab',
          'label' => __('Buttons', 'starter-coat'),
          'name'  => '',
          'type'  => 'tab',
        ),
        array(
          'key'   => 'field_sc_global_cta_action_mode',
          'label' => __('Actions Type', 'starter-coat'),
          'name'  => 'sc_global_cta_action_mode',
          'type'  => 'select',
          'choices' => array(
            'buttons' => __('Buttons', 'starter-coat'),
            'form'    => __('Form', 'starter-coat'),
          ),
          'default_value' => 'buttons',
          'ui'            => 1,
        ),
        array(
          'key'   => 'field_sc_global_cta_button_primary',
          'label' => __('Primary Button', 'starter-coat'),
          'name'  => 'sc_global_cta_button_primary',
          'type'  => 'link',
          'conditional_logic' => array(
            array(
              array(
                'field'    => 'field_sc_global_cta_action_mode',
                'operator' => '==',
                'value'    => 'buttons',
              ),
            ),
          ),
        ),
        array(
          'key'   => 'field_sc_global_cta_button_primary_style',
          'label' => __('Primary Button Style', 'starter-coat'),
          'name'  => 'sc_global_cta_button_primary_style',
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
                'field'    => 'field_sc_global_cta_action_mode',
                'operator' => '==',
                'value'    => 'buttons',
              ),
            ),
          ),
        ),
        array(
          'key'   => 'field_sc_global_cta_button_secondary',
          'label' => __('Secondary Button', 'starter-coat'),
          'name'  => 'sc_global_cta_button_secondary',
          'type'  => 'link',
          'conditional_logic' => array(
            array(
              array(
                'field'    => 'field_sc_global_cta_action_mode',
                'operator' => '==',
                'value'    => 'buttons',
              ),
            ),
          ),
        ),
        array(
          'key'   => 'field_sc_global_cta_button_secondary_style',
          'label' => __('Secondary Button Style', 'starter-coat'),
          'name'  => 'sc_global_cta_button_secondary_style',
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
                'field'    => 'field_sc_global_cta_action_mode',
                'operator' => '==',
                'value'    => 'buttons',
              ),
            ),
          ),
        ),
        array(
          'key'   => 'field_sc_global_cta_form_shortcode',
          'label' => __('Form Shortcode', 'starter-coat'),
          'name'  => 'sc_global_cta_form_shortcode',
          'type'  => 'text',
          'instructions' => __('Examples: [gravityform id="1" title="false" description="false" ajax="true"], [fluentform id="1"], [wpforms id="123"]', 'starter-coat'),
          'placeholder' => '[gravityform id="1" title="false" description="false" ajax="true"]',
          'conditional_logic' => array(
            array(
              array(
                'field'    => 'field_sc_global_cta_action_mode',
                'operator' => '==',
                'value'    => 'form',
              ),
            ),
          ),
        ),
        array(
          'key'   => 'field_sc_global_cta_style_tab',
          'label' => __('Style', 'starter-coat'),
          'name'  => '',
          'type'  => 'tab',
        ),
        array(
          'key'   => 'field_sc_global_cta_layout',
          'label' => __('Layout', 'starter-coat'),
          'name'  => 'sc_global_cta_layout',
          'type'  => 'select',
          'choices' => array(
            'stacked' => __('Stacked', 'starter-coat'),
            'split'   => __('Split', 'starter-coat'),
          ),
          'default_value' => 'stacked',
          'ui'            => 1,
        ),
        array(
          'key'   => 'field_sc_global_cta_split_ratio',
          'label' => __('Split Ratio', 'starter-coat'),
          'name'  => 'sc_global_cta_split_ratio',
          'type'  => 'select',
          'choices' => array(
            'two-thirds' => __('2/3 + 1/3', 'starter-coat'),
            'half'       => __('50/50', 'starter-coat'),
          ),
          'default_value' => 'two-thirds',
          'ui'            => 1,
          'conditional_logic' => array(
            array(
              array(
                'field'    => 'field_sc_global_cta_layout',
                'operator' => '==',
                'value'    => 'split',
              ),
            ),
          ),
        ),
        array(
          'key'   => 'field_sc_global_cta_width',
          'label' => __('Width', 'starter-coat'),
          'name'  => 'sc_global_cta_width',
          'type'  => 'select',
          'choices' => array(
            'container' => __('Container', 'starter-coat'),
            'narrow'    => __('Narrow', 'starter-coat'),
            'full'      => __('Full Width', 'starter-coat'),
          ),
          'default_value' => 'container',
          'ui'            => 1,
        ),
        array(
          'key'   => 'field_sc_global_cta_background',
          'label' => __('Background', 'starter-coat'),
          'name'  => 'sc_global_cta_background',
          'type'  => 'radio',
          'choices' => array(
            'none'  => __('Default', 'starter-coat'),
            'light' => __('Light', 'starter-coat'),
            'dark'  => __('Dark', 'starter-coat'),
            'brand' => __('Brand', 'starter-coat'),
            'muted' => __('Muted', 'starter-coat'),
          ),
          'default_value' => 'none',
          'layout'        => 'horizontal',
          'wrapper'       => array(
            'class' => 'sc-acf-color-palette',
          ),
        ),
        array(
          'key'   => 'field_sc_global_cta_text_box_style',
          'label' => __('Text Box Style', 'starter-coat'),
          'name'  => 'sc_global_cta_text_box_style',
          'type'  => 'select',
          'choices' => array(
            'surface' => __('Surface', 'starter-coat'),
            'outline' => __('Outline', 'starter-coat'),
            'none'    => __('None', 'starter-coat'),
          ),
          'default_value' => 'surface',
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
      'key'    => 'group_sc_contact_info',
      'title'  => __('Contact Information', 'starter-coat'),
      'fields' => array(
        array(
          'key'   => 'field_sc_contact_tab',
          'label' => __('Contact', 'starter-coat'),
          'name'  => '',
          'type'  => 'tab',
        ),
        array(
          'key'   => 'field_sc_contact_phone',
          'label' => __('Phone', 'starter-coat'),
          'name'  => 'sc_contact_phone',
          'type'  => 'text',
        ),
        array(
          'key'   => 'field_sc_contact_email',
          'label' => __('Email', 'starter-coat'),
          'name'  => 'sc_contact_email',
          'type'  => 'email',
        ),
        array(
          'key'   => 'field_sc_contact_address',
          'label' => __('Address', 'starter-coat'),
          'name'  => 'sc_contact_address',
          'type'  => 'textarea',
          'rows'  => 3,
        ),
        array(
          'key'   => 'field_sc_contact_hours',
          'label' => __('Business Hours', 'starter-coat'),
          'name'  => 'sc_contact_hours',
          'type'  => 'textarea',
          'rows'  => 3,
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
      'key'    => 'group_sc_social_media',
      'title'  => __('Social Media Links', 'starter-coat'),
      'fields' => array(
        array(
          'key'   => 'field_sc_social_tab',
          'label' => __('Social Media', 'starter-coat'),
          'name'  => '',
          'type'  => 'tab',
        ),
        array(
          'key'   => 'field_sc_social_facebook',
          'label' => __('Facebook URL', 'starter-coat'),
          'name'  => 'sc_social_facebook',
          'type'  => 'url',
        ),
        array(
          'key'   => 'field_sc_social_twitter',
          'label' => __('Twitter/X URL', 'starter-coat'),
          'name'  => 'sc_social_twitter',
          'type'  => 'url',
        ),
        array(
          'key'   => 'field_sc_social_instagram',
          'label' => __('Instagram URL', 'starter-coat'),
          'name'  => 'sc_social_instagram',
          'type'  => 'url',
        ),
        array(
          'key'   => 'field_sc_social_linkedin',
          'label' => __('LinkedIn URL', 'starter-coat'),
          'name'  => 'sc_social_linkedin',
          'type'  => 'url',
        ),
        array(
          'key'   => 'field_sc_social_youtube',
          'label' => __('YouTube URL', 'starter-coat'),
          'name'  => 'sc_social_youtube',
          'type'  => 'url',
        ),
        array(
          'key'   => 'field_sc_social_tiktok',
          'label' => __('TikTok URL', 'starter-coat'),
          'name'  => 'sc_social_tiktok',
          'type'  => 'url',
        ),
        array(
          'key'   => 'field_sc_social_pinterest',
          'label' => __('Pinterest URL', 'starter-coat'),
          'name'  => 'sc_social_pinterest',
          'type'  => 'url',
        ),
        array(
          'key'   => 'field_sc_social_github',
          'label' => __('GitHub URL', 'starter-coat'),
          'name'  => 'sc_social_github',
          'type'  => 'url',
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
      'key'    => 'group_sc_footer_settings',
      'title'  => __('Footer Settings', 'starter-coat'),
      'fields' => array(
        array(
          'key'   => 'field_sc_footer_layout_tab',
          'label' => __('Layout', 'starter-coat'),
          'name'  => '',
          'type'  => 'tab',
        ),
        array(
          'key'   => 'field_sc_footer_layout',
          'label' => __('Footer Layout', 'starter-coat'),
          'name'  => 'sc_footer_layout',
          'type'  => 'select',
          'choices' => array(
            'simple'  => __('Simple', 'starter-coat'),
            'complex' => __('Complex Columns', 'starter-coat'),
          ),
          'default_value' => 'simple',
          'ui'            => 1,
        ),
        array(
          'key'   => 'field_sc_footer_simple_columns',
          'label' => __('Simple Layout Columns', 'starter-coat'),
          'name'  => 'sc_footer_simple_columns',
          'type'  => 'select',
          'choices' => array(
            'one' => __('One Column', 'starter-coat'),
            'two' => __('Two Columns', 'starter-coat'),
          ),
          'default_value' => 'two',
          'ui'            => 1,
          'conditional_logic' => array(
            array(
              array(
                'field'    => 'field_sc_footer_layout',
                'operator' => '==',
                'value'    => 'simple',
              ),
            ),
          ),
        ),
        array(
          'key'   => 'field_sc_footer_complex_columns',
          'label' => __('Complex Menu Columns', 'starter-coat'),
          'name'  => 'sc_footer_complex_columns',
          'type'  => 'select',
          'choices' => array(
            'two'   => __('Two Menu Columns', 'starter-coat'),
            'three' => __('Three Menu Columns', 'starter-coat'),
          ),
          'default_value' => 'three',
          'ui'            => 1,
          'instructions'  => __('Uses Footer Column 1-3 menu locations.', 'starter-coat'),
          'conditional_logic' => array(
            array(
              array(
                'field'    => 'field_sc_footer_layout',
                'operator' => '==',
                'value'    => 'complex',
              ),
            ),
          ),
        ),
        array(
          'key'   => 'field_sc_footer_sections_tab',
          'label' => __('Sections', 'starter-coat'),
          'name'  => '',
          'type'  => 'tab',
        ),
        array(
          'key'           => 'field_sc_footer_show_logo',
          'label'         => __('Show Footer Logo', 'starter-coat'),
          'name'          => 'sc_footer_show_logo',
          'type'          => 'true_false',
          'ui'            => 1,
          'default_value' => 1,
        ),
        array(
          'key'   => 'field_sc_footer_logo_mode',
          'label' => __('Footer Logo Source', 'starter-coat'),
          'name'  => 'sc_footer_logo_mode',
          'type'  => 'select',
          'choices' => array(
            'inherit_nav' => __('Inherit Header Logo Setting', 'starter-coat'),
            'custom_logo' => __('Customizer Logo', 'starter-coat'),
            'image'       => __('Image (Option)', 'starter-coat'),
            'site_name'   => __('Site Name Text', 'starter-coat'),
          ),
          'default_value' => 'inherit_nav',
          'ui'            => 1,
          'conditional_logic' => array(
            array(
              array(
                'field'    => 'field_sc_footer_show_logo',
                'operator' => '==',
                'value'    => '1',
              ),
            ),
          ),
        ),
        array(
          'key'   => 'field_sc_footer_logo_image',
          'label' => __('Footer Logo Image', 'starter-coat'),
          'name'  => 'sc_footer_logo_image',
          'type'  => 'image',
          'return_format' => 'array',
          'preview_size'  => 'medium',
          'mime_types'    => 'jpg,jpeg,png,webp,svg',
          'conditional_logic' => array(
            array(
              array(
                'field'    => 'field_sc_footer_logo_mode',
                'operator' => '==',
                'value'    => 'image',
              ),
            ),
          ),
        ),
        array(
          'key'           => 'field_sc_footer_show_social',
          'label'         => __('Show Social Links', 'starter-coat'),
          'name'          => 'sc_footer_show_social',
          'type'          => 'true_false',
          'ui'            => 1,
          'default_value' => 1,
          'instructions'  => __('Uses URLs from Theme Settings > Social Media Links.', 'starter-coat'),
        ),
        array(
          'key'   => 'field_sc_footer_social_style',
          'label' => __('Footer Social Style', 'starter-coat'),
          'name'  => 'sc_footer_social_style',
          'type'  => 'select',
          'choices' => array(
            'icon' => __('Icon', 'starter-coat'),
            'text' => __('Text', 'starter-coat'),
          ),
          'default_value' => 'icon',
          'ui'            => 1,
          'conditional_logic' => array(
            array(
              array(
                'field'    => 'field_sc_footer_show_social',
                'operator' => '==',
                'value'    => '1',
              ),
            ),
          ),
        ),
        array(
          'key'           => 'field_sc_footer_show_main_menu',
          'label'         => __('Show Main Footer Menu', 'starter-coat'),
          'name'          => 'sc_footer_show_main_menu',
          'type'          => 'true_false',
          'ui'            => 1,
          'default_value' => 1,
          'instructions'  => __('Uses Footer Main menu location (falls back to Footer legacy location).', 'starter-coat'),
        ),
        array(
          'key'           => 'field_sc_footer_show_legal_menu',
          'label'         => __('Show Legal Menu', 'starter-coat'),
          'name'          => 'sc_footer_show_legal_menu',
          'type'          => 'true_false',
          'ui'            => 1,
          'default_value' => 1,
          'instructions'  => __('Uses Footer Legal menu location.', 'starter-coat'),
        ),
        array(
          'key'   => 'field_sc_footer_legal_links',
          'label' => __('Extra Legal Links', 'starter-coat'),
          'name'  => 'sc_footer_legal_links',
          'type'  => 'repeater',
          'button_label' => __('Add Link', 'starter-coat'),
          'layout'       => 'table',
          'sub_fields'   => array(
            array(
              'key'   => 'field_sc_footer_legal_link_item',
              'label' => __('Link', 'starter-coat'),
              'name'  => 'link',
              'type'  => 'link',
            ),
          ),
        ),
        array(
          'key'   => 'field_sc_footer_bottom_tab',
          'label' => __('Bottom Row', 'starter-coat'),
          'name'  => '',
          'type'  => 'tab',
        ),
        array(
          'key'           => 'field_sc_footer_copyright_text',
          'label'         => __('Copyright Text', 'starter-coat'),
          'name'          => 'sc_footer_copyright_text',
          'type'          => 'text',
          'default_value' => __('All rights reserved.', 'starter-coat'),
          'instructions'  => __('Year and site name are added automatically.', 'starter-coat'),
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
      'key'    => 'group_sc_page_cta_override',
      'title'  => __('CTA Override', 'starter-coat'),
      'menu_order' => 30,
      'fields' => array(
        array(
          'key'   => 'field_sc_page_cta_override',
          'label' => __('Override Global CTA', 'starter-coat'),
          'name'  => 'sc_page_cta_override',
          'type'  => 'true_false',
          'ui'    => 1,
        ),
        array(
          'key'   => 'field_sc_page_cta_enabled',
          'label' => __('Enable CTA For This Page', 'starter-coat'),
          'name'  => 'sc_page_cta_enabled',
          'type'  => 'true_false',
          'ui'    => 1,
          'conditional_logic' => array(
            array(
              array(
                'field'    => 'field_sc_page_cta_override',
                'operator' => '==',
                'value'    => '1',
              ),
            ),
          ),
        ),
        array(
          'key'   => 'field_sc_page_cta_content_tab',
          'label' => __('Content', 'starter-coat'),
          'name'  => '',
          'type'  => 'tab',
        ),
        array(
          'key'   => 'field_sc_page_cta_eyebrow',
          'label' => __('Eyebrow', 'starter-coat'),
          'name'  => 'sc_page_cta_eyebrow',
          'type'  => 'text',
        ),
        array(
          'key'   => 'field_sc_page_cta_title',
          'label' => __('Title', 'starter-coat'),
          'name'  => 'sc_page_cta_title',
          'type'  => 'text',
        ),
        array(
          'key'   => 'field_sc_page_cta_subheading',
          'label' => __('Subheading', 'starter-coat'),
          'name'  => 'sc_page_cta_subheading',
          'type'  => 'text',
        ),
        array(
          'key'   => 'field_sc_page_cta_paragraph',
          'label' => __('Paragraph', 'starter-coat'),
          'name'  => 'sc_page_cta_paragraph',
          'type'  => 'textarea',
        ),
        array(
          'key'   => 'field_sc_page_cta_buttons_tab',
          'label' => __('Buttons', 'starter-coat'),
          'name'  => '',
          'type'  => 'tab',
        ),
        array(
          'key'   => 'field_sc_page_cta_action_mode',
          'label' => __('Actions Type', 'starter-coat'),
          'name'  => 'sc_page_cta_action_mode',
          'type'  => 'select',
          'choices' => array(
            'buttons' => __('Buttons', 'starter-coat'),
            'form'    => __('Form', 'starter-coat'),
          ),
          'default_value' => 'buttons',
          'ui'            => 1,
        ),
        array(
          'key'   => 'field_sc_page_cta_button_primary',
          'label' => __('Primary Button', 'starter-coat'),
          'name'  => 'sc_page_cta_button_primary',
          'type'  => 'link',
          'conditional_logic' => array(
            array(
              array(
                'field'    => 'field_sc_page_cta_action_mode',
                'operator' => '==',
                'value'    => 'buttons',
              ),
            ),
          ),
        ),
        array(
          'key'   => 'field_sc_page_cta_button_primary_style',
          'label' => __('Primary Button Style', 'starter-coat'),
          'name'  => 'sc_page_cta_button_primary_style',
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
                'field'    => 'field_sc_page_cta_action_mode',
                'operator' => '==',
                'value'    => 'buttons',
              ),
            ),
          ),
        ),
        array(
          'key'   => 'field_sc_page_cta_button_secondary',
          'label' => __('Secondary Button', 'starter-coat'),
          'name'  => 'sc_page_cta_button_secondary',
          'type'  => 'link',
          'conditional_logic' => array(
            array(
              array(
                'field'    => 'field_sc_page_cta_action_mode',
                'operator' => '==',
                'value'    => 'buttons',
              ),
            ),
          ),
        ),
        array(
          'key'   => 'field_sc_page_cta_button_secondary_style',
          'label' => __('Secondary Button Style', 'starter-coat'),
          'name'  => 'sc_page_cta_button_secondary_style',
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
                'field'    => 'field_sc_page_cta_action_mode',
                'operator' => '==',
                'value'    => 'buttons',
              ),
            ),
          ),
        ),
        array(
          'key'   => 'field_sc_page_cta_form_shortcode',
          'label' => __('Form Shortcode', 'starter-coat'),
          'name'  => 'sc_page_cta_form_shortcode',
          'type'  => 'text',
          'instructions' => __('Examples: [gravityform id="1" title="false" description="false" ajax="true"], [fluentform id="1"], [wpforms id="123"]', 'starter-coat'),
          'placeholder' => '[gravityform id="1" title="false" description="false" ajax="true"]',
          'conditional_logic' => array(
            array(
              array(
                'field'    => 'field_sc_page_cta_action_mode',
                'operator' => '==',
                'value'    => 'form',
              ),
            ),
          ),
        ),
        array(
          'key'   => 'field_sc_page_cta_style_tab',
          'label' => __('Style', 'starter-coat'),
          'name'  => '',
          'type'  => 'tab',
        ),
        array(
          'key'   => 'field_sc_page_cta_layout',
          'label' => __('Layout', 'starter-coat'),
          'name'  => 'sc_page_cta_layout',
          'type'  => 'select',
          'choices' => array(
            'stacked' => __('Stacked', 'starter-coat'),
            'split'   => __('Split', 'starter-coat'),
          ),
          'default_value' => 'stacked',
          'ui'            => 1,
        ),
        array(
          'key'   => 'field_sc_page_cta_split_ratio',
          'label' => __('Split Ratio', 'starter-coat'),
          'name'  => 'sc_page_cta_split_ratio',
          'type'  => 'select',
          'choices' => array(
            'two-thirds' => __('2/3 + 1/3', 'starter-coat'),
            'half'       => __('50/50', 'starter-coat'),
          ),
          'default_value' => 'two-thirds',
          'ui'            => 1,
          'conditional_logic' => array(
            array(
              array(
                'field'    => 'field_sc_page_cta_layout',
                'operator' => '==',
                'value'    => 'split',
              ),
            ),
          ),
        ),
        array(
          'key'   => 'field_sc_page_cta_width',
          'label' => __('Width', 'starter-coat'),
          'name'  => 'sc_page_cta_width',
          'type'  => 'select',
          'choices' => array(
            'container' => __('Container', 'starter-coat'),
            'narrow'    => __('Narrow', 'starter-coat'),
            'full'      => __('Full Width', 'starter-coat'),
          ),
          'default_value' => 'container',
          'ui'            => 1,
        ),
        array(
          'key'   => 'field_sc_page_cta_background',
          'label' => __('Background', 'starter-coat'),
          'name'  => 'sc_page_cta_background',
          'type'  => 'radio',
          'choices' => array(
            'none'  => __('Default', 'starter-coat'),
            'light' => __('Light', 'starter-coat'),
            'dark'  => __('Dark', 'starter-coat'),
            'brand' => __('Brand', 'starter-coat'),
            'muted' => __('Muted', 'starter-coat'),
          ),
          'default_value' => 'none',
          'layout'        => 'horizontal',
          'wrapper'       => array(
            'class' => 'sc-acf-color-palette',
          ),
        ),
        array(
          'key'   => 'field_sc_page_cta_text_box_style',
          'label' => __('Text Box Style', 'starter-coat'),
          'name'  => 'sc_page_cta_text_box_style',
          'type'  => 'select',
          'choices' => array(
            'surface' => __('Surface', 'starter-coat'),
            'outline' => __('Outline', 'starter-coat'),
            'none'    => __('None', 'starter-coat'),
          ),
          'default_value' => 'surface',
          'ui'            => 1,
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
      'key'    => 'group_sc_page_sections',
      'title'  => __('Page Sections', 'starter-coat'),
      'menu_order' => 20,
      'fields' => array(
        array(
          'key'           => 'field_sc_sections',
          'label'         => __('Sections', 'starter-coat'),
          'name'          => 'sc_sections',
          'type'          => 'flexible_content',
          'button_label'  => __('Add Section', 'starter-coat'),
          'layouts'       => array(
            'layout_sc_content_media' => array(
              'key'        => 'layout_sc_content_media',
              'name'       => 'content_media',
              'label'      => __('Content + Media', 'starter-coat'),
              'display'    => 'block',
              'sub_fields' => array(
                array(
                  'key'           => 'field_sc_content_media_mode',
                  'label'         => __('Layout Mode', 'starter-coat'),
                  'name'          => 'layout_mode',
                  'type'          => 'select',
                  'choices'       => array(
                    'split'   => __('Split (2 Column)', 'starter-coat'),
                    'stacked' => __('Stacked (Single Column Flow)', 'starter-coat'),
                  ),
                  'default_value' => 'split',
                  'ui'            => 1,
                ),
                array(
                  'key'   => 'field_sc_content_media_kicker',
                  'label' => __('Kicker', 'starter-coat'),
                  'name'  => 'kicker',
                  'type'  => 'text',
                ),
                array(
                  'key'   => 'field_sc_content_media_title',
                  'label' => __('Title', 'starter-coat'),
                  'name'  => 'title',
                  'type'  => 'text',
                ),
                array(
                  'key'   => 'field_sc_content_media_content',
                  'label' => __('Content', 'starter-coat'),
                  'name'  => 'content',
                  'type'  => 'wysiwyg',
                ),
                array(
                  'key'          => 'field_sc_content_media_cta_buttons',
                  'label'        => __('Buttons', 'starter-coat'),
                  'name'         => 'cta_buttons',
                  'type'         => 'repeater',
                  'layout'       => 'row',
                  'button_label' => __('Add Button', 'starter-coat'),
                  'sub_fields'   => array(
                    array(
                      'key'   => 'field_sc_content_media_cta_button_link',
                      'label' => __('Button Link', 'starter-coat'),
                      'name'  => 'button_link',
                      'type'  => 'link',
                    ),
                    array(
                      'key'           => 'field_sc_content_media_cta_button_style',
                      'label'         => __('Button Style', 'starter-coat'),
                      'name'          => 'button_style',
                      'type'          => 'select',
                      'choices'       => array(
                        'primary' => __('Primary', 'starter-coat'),
                        'ghost'   => __('Ghost', 'starter-coat'),
                      ),
                      'default_value' => 'primary',
                      'ui'            => 1,
                    ),
                  ),
                ),
                array(
                  'key'   => 'field_sc_content_media_media_image',
                  'label' => __('Media Image', 'starter-coat'),
                  'name'  => 'media_image',
                  'type'  => 'image',
                  'return_format' => 'array',
                  'preview_size'  => 'medium',
                  'mime_types'    => 'jpg,jpeg,png,webp,svg',
                ),
                array(
                  'key'           => 'field_sc_content_media_ratio',
                  'label'         => __('Ratio', 'starter-coat'),
                  'name'          => 'ratio',
                  'type'          => 'select',
                  'choices'       => array(
                    '50-50' => '50 / 50',
                    '66-33' => '2 / 3',
                  ),
                  'default_value' => '50-50',
                  'ui'            => 1,
                  'conditional_logic' => array(
                    array(
                      array(
                        'field'    => 'field_sc_content_media_mode',
                        'operator' => '==',
                        'value'    => 'split',
                      ),
                    ),
                  ),
                ),
                array(
                  'key'           => 'field_sc_content_media_media_position',
                  'label'         => __('Media Position', 'starter-coat'),
                  'name'          => 'media_position',
                  'type'          => 'select',
                  'choices'       => array(
                    'left'  => __('Left', 'starter-coat'),
                    'right' => __('Right', 'starter-coat'),
                  ),
                  'default_value' => 'right',
                  'ui'            => 1,
                  'conditional_logic' => array(
                    array(
                      array(
                        'field'    => 'field_sc_content_media_mode',
                        'operator' => '==',
                        'value'    => 'split',
                      ),
                    ),
                  ),
                ),
                array(
                  'key'           => 'field_sc_content_media_stack_order',
                  'label'         => __('Stack Order', 'starter-coat'),
                  'name'          => 'stack_order',
                  'type'          => 'select',
                  'choices'       => array(
                    'text-media' => __('Text then Media', 'starter-coat'),
                    'media-text' => __('Media then Text', 'starter-coat'),
                  ),
                  'default_value' => 'text-media',
                  'ui'            => 1,
                  'conditional_logic' => array(
                    array(
                      array(
                        'field'    => 'field_sc_content_media_mode',
                        'operator' => '==',
                        'value'    => 'stacked',
                      ),
                    ),
                  ),
                ),
                array(
                  'key'           => 'field_sc_content_media_image_style',
                  'label'         => __('Image Style', 'starter-coat'),
                  'name'          => 'image_style',
                  'type'          => 'select',
                  'choices'       => array(
                    'soft'    => __('Soft Radius', 'starter-coat'),
                    'rounded' => __('Rounded', 'starter-coat'),
                    'sharp'   => __('Sharp', 'starter-coat'),
                  ),
                  'default_value' => 'rounded',
                  'ui'            => 1,
                ),
                array(
                  'key'           => 'field_sc_content_media_image_full_bleed',
                  'label'         => __('Image Full Bleed', 'starter-coat'),
                  'name'          => 'image_full_bleed',
                  'type'          => 'true_false',
                  'ui'            => 1,
                  'default_value' => 0,
                  'instructions'  => __('Extends image to page edge when section width is Full Width.', 'starter-coat'),
                ),
                array(
                  'key'   => 'field_sc_content_media_options_tab',
                  'label' => __('Section Options', 'starter-coat'),
                  'name'  => '',
                  'type'  => 'tab',
                ),
                ...$section_options,
              ),
            ),
            'layout_sc_card_collection' => array(
              'key'        => 'layout_sc_card_collection',
              'name'       => 'card_collection',
              'label'      => __('Card Collection (1-4 Columns)', 'starter-coat'),
              'display'    => 'block',
              'sub_fields' => array(
                array(
                  'key'   => 'field_sc_card_collection_intro_tab',
                  'label' => __('Intro (Optional)', 'starter-coat'),
                  'name'  => '',
                  'type'  => 'tab',
                ),
                array(
                  'key'   => 'field_sc_card_collection_pre_kicker',
                  'label' => __('Kicker', 'starter-coat'),
                  'name'  => 'pre_kicker',
                  'type'  => 'text',
                ),
                array(
                  'key'   => 'field_sc_card_collection_pre_title',
                  'label' => __('Heading', 'starter-coat'),
                  'name'  => 'pre_title',
                  'type'  => 'text',
                ),
                array(
                  'key'   => 'field_sc_card_collection_pre_copy',
                  'label' => __('Intro Copy', 'starter-coat'),
                  'name'  => 'pre_copy',
                  'type'  => 'textarea',
                ),
                array(
                  'key'          => 'field_sc_card_collection_pre_buttons',
                  'label'        => __('Intro Buttons', 'starter-coat'),
                  'name'         => 'pre_buttons',
                  'type'         => 'repeater',
                  'layout'       => 'row',
                  'button_label' => __('Add Intro Button', 'starter-coat'),
                  'sub_fields'   => array(
                    array(
                      'key'   => 'field_sc_card_collection_pre_button_link',
                      'label' => __('Button Link', 'starter-coat'),
                      'name'  => 'button_link',
                      'type'  => 'link',
                    ),
                    array(
                      'key'           => 'field_sc_card_collection_pre_button_style',
                      'label'         => __('Button Style', 'starter-coat'),
                      'name'          => 'button_style',
                      'type'          => 'select',
                      'choices'       => array(
                        'primary' => __('Primary', 'starter-coat'),
                        'ghost'   => __('Ghost', 'starter-coat'),
                      ),
                      'default_value' => 'primary',
                      'ui'            => 1,
                    ),
                  ),
                ),
                array(
                  'key'   => 'field_sc_card_collection_layout_tab',
                  'label' => __('Cards', 'starter-coat'),
                  'name'  => '',
                  'type'  => 'tab',
                ),
                array(
                  'key'           => 'field_sc_card_collection_columns',
                  'label'         => __('Columns', 'starter-coat'),
                  'name'          => 'columns',
                  'type'          => 'select',
                  'choices'       => array(
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                  ),
                  'default_value' => '3',
                  'ui'            => 1,
                ),
                array(
                  'key'           => 'field_sc_card_collection_card_style',
                  'label'         => __('Card Style', 'starter-coat'),
                  'name'          => 'card_style',
                  'type'          => 'select',
                  'choices'       => array(
                    'surface'  => __('Surface', 'starter-coat'),
                    'outline'  => __('Outline', 'starter-coat'),
                    'featured' => __('Featured', 'starter-coat'),
                  ),
                  'default_value' => 'surface',
                  'ui'            => 1,
                ),
                array(
                  'key'           => 'field_sc_card_collection_equal_height',
                  'label'         => __('Equal Card Height', 'starter-coat'),
                  'name'          => 'equal_height',
                  'type'          => 'true_false',
                  'ui'            => 1,
                  'default_value' => 1,
                ),
                array(
                  'key'           => 'field_sc_card_collection_items',
                  'label'         => __('Items', 'starter-coat'),
                  'name'          => 'items',
                  'type'          => 'repeater',
                  'layout'        => 'row',
                  'button_label'  => __('Add Card', 'starter-coat'),
                  'min'           => 1,
                  'sub_fields'    => array(
                    array(
                      'key'   => 'field_sc_card_collection_item_title',
                      'label' => __('Title (Optional)', 'starter-coat'),
                      'name'  => 'title',
                      'type'  => 'text',
                    ),
                    array(
                      'key'   => 'field_sc_card_collection_item_copy',
                      'label' => __('Paragraph (Optional)', 'starter-coat'),
                      'name'  => 'copy',
                      'type'  => 'textarea',
                    ),
                    array(
                      'key'          => 'field_sc_card_collection_item_list',
                      'label'        => __('List (Optional)', 'starter-coat'),
                      'name'         => 'list_items',
                      'type'         => 'repeater',
                      'layout'       => 'table',
                      'button_label' => __('Add List Item', 'starter-coat'),
                      'sub_fields'   => array(
                        array(
                          'key'   => 'field_sc_card_collection_item_list_text',
                          'label' => __('List Text', 'starter-coat'),
                          'name'  => 'text',
                          'type'  => 'text',
                        ),
                      ),
                    ),
                    array(
                      'key'           => 'field_sc_card_collection_item_media_type',
                      'label'         => __('Media Type', 'starter-coat'),
                      'name'          => 'media_type',
                      'type'          => 'select',
                      'choices'       => array(
                        'none'  => __('None', 'starter-coat'),
                        'icon'  => __('Icon', 'starter-coat'),
                        'image' => __('Image', 'starter-coat'),
                      ),
                      'default_value' => 'none',
                      'ui'            => 1,
                    ),
                    array(
                      'key'           => 'field_sc_card_collection_item_icon_name',
                      'label'         => __('Icon Name', 'starter-coat'),
                      'name'          => 'icon_name',
                      'type'          => 'select',
                      'choices'       => array(
                        'check-in'     => 'check-in',
                        'tablet'       => 'tablet',
                        'messaging'    => 'messaging',
                        'room-service' => 'room-service',
                        'digital-key'  => 'digital-key',
                        'casting'      => 'casting',
                        'analytics'    => 'analytics',
                        'automation'   => 'automation',
                        'marketing'    => 'marketing',
                        'concierge'    => 'concierge',
                      ),
                      'ui'            => 1,
                      'required'      => 1,
                      'instructions'  => __('Uses files from /assets/icons/cards/ named icon-card-{slug}.svg.', 'starter-coat'),
                      'conditional_logic' => array(
                        array(
                          array(
                            'field'    => 'field_sc_card_collection_item_media_type',
                            'operator' => '==',
                            'value'    => 'icon',
                          ),
                        ),
                      ),
                    ),
                    array(
                      'key'           => 'field_sc_card_collection_item_image',
                      'label'         => __('Image', 'starter-coat'),
                      'name'          => 'image',
                      'type'          => 'image',
                      'return_format' => 'array',
                      'preview_size'  => 'medium',
                      'mime_types'    => 'jpg,jpeg,png,webp,svg',
                      'required'      => 1,
                      'conditional_logic' => array(
                        array(
                          array(
                            'field'    => 'field_sc_card_collection_item_media_type',
                            'operator' => '==',
                            'value'    => 'image',
                          ),
                        ),
                      ),
                    ),
                    array(
                      'key'           => 'field_sc_card_collection_item_media_position',
                      'label'         => __('Media Placement', 'starter-coat'),
                      'name'          => 'media_position',
                      'type'          => 'select',
                      'choices'       => array(
                        'top'   => __('Top', 'starter-coat'),
                        'left'  => __('Left', 'starter-coat'),
                        'right' => __('Right', 'starter-coat'),
                      ),
                      'default_value' => 'left',
                      'ui'            => 1,
                      'conditional_logic' => array(
                        array(
                          array(
                            'field'    => 'field_sc_card_collection_item_media_type',
                            'operator' => '!=',
                            'value'    => 'none',
                          ),
                        ),
                      ),
                    ),
                    array(
                      'key'   => 'field_sc_card_collection_item_url',
                      'label' => __('Card URL (Optional)', 'starter-coat'),
                      'name'  => 'card_url',
                      'type'  => 'url',
                      'instructions' => __('If set, the whole card becomes clickable.', 'starter-coat'),
                    ),
                    array(
                      'key'           => 'field_sc_card_collection_item_open_new_tab',
                      'label'         => __('Open in New Tab', 'starter-coat'),
                      'name'          => 'open_new_tab',
                      'type'          => 'true_false',
                      'ui'            => 1,
                      'default_value' => 0,
                      'conditional_logic' => array(
                        array(
                          array(
                            'field'    => 'field_sc_card_collection_item_url',
                            'operator' => '!=empty',
                            'value'    => '',
                          ),
                        ),
                      ),
                    ),
                  ),
                ),
                array(
                  'key'   => 'field_sc_card_collection_footer_tab',
                  'label' => __('Footer (Optional)', 'starter-coat'),
                  'name'  => '',
                  'type'  => 'tab',
                ),
                array(
                  'key'   => 'field_sc_card_collection_post_copy',
                  'label' => __('Footer Copy', 'starter-coat'),
                  'name'  => 'post_copy',
                  'type'  => 'textarea',
                ),
                array(
                  'key'   => 'field_sc_card_collection_quote',
                  'label' => __('Quote / Statement', 'starter-coat'),
                  'name'  => 'quote',
                  'type'  => 'textarea',
                ),
                array(
                  'key'   => 'field_sc_card_collection_quote_source',
                  'label' => __('Quote Source', 'starter-coat'),
                  'name'  => 'quote_source',
                  'type'  => 'text',
                ),
                array(
                  'key'          => 'field_sc_card_collection_post_buttons',
                  'label'        => __('Footer Buttons', 'starter-coat'),
                  'name'         => 'post_buttons',
                  'type'         => 'repeater',
                  'layout'       => 'row',
                  'button_label' => __('Add Footer Button', 'starter-coat'),
                  'sub_fields'   => array(
                    array(
                      'key'   => 'field_sc_card_collection_post_button_link',
                      'label' => __('Button Link', 'starter-coat'),
                      'name'  => 'button_link',
                      'type'  => 'link',
                    ),
                    array(
                      'key'           => 'field_sc_card_collection_post_button_style',
                      'label'         => __('Button Style', 'starter-coat'),
                      'name'          => 'button_style',
                      'type'          => 'select',
                      'choices'       => array(
                        'primary' => __('Primary', 'starter-coat'),
                        'ghost'   => __('Ghost', 'starter-coat'),
                      ),
                      'default_value' => 'primary',
                      'ui'            => 1,
                    ),
                  ),
                ),
                array(
                  'key'   => 'field_sc_card_collection_options_tab',
                  'label' => __('Section Options', 'starter-coat'),
                  'name'  => '',
                  'type'  => 'tab',
                ),
                ...$section_options,
              ),
            ),
            'layout_sc_expressive_text' => array(
              'key'        => 'layout_sc_expressive_text',
              'name'       => 'expressive_text',
              'label'      => __('Expressive Text', 'starter-coat'),
              'display'    => 'block',
              'sub_fields' => array(
                array(
                  'key'   => 'field_sc_expressive_text_kicker',
                  'label' => __('Kicker', 'starter-coat'),
                  'name'  => 'kicker',
                  'type'  => 'text',
                ),
                array(
                  'key'   => 'field_sc_expressive_text_title',
                  'label' => __('Title (Optional)', 'starter-coat'),
                  'name'  => 'title',
                  'type'  => 'text',
                ),
                array(
                  'key'   => 'field_sc_expressive_text_content',
                  'label' => __('Content', 'starter-coat'),
                  'name'  => 'content',
                  'type'  => 'wysiwyg',
                ),
                array(
                  'key'           => 'field_sc_expressive_text_text_align',
                  'label'         => __('Text Align', 'starter-coat'),
                  'name'          => 'text_align',
                  'type'          => 'select',
                  'choices'       => array(
                    'left'   => __('Left', 'starter-coat'),
                    'center' => __('Center', 'starter-coat'),
                  ),
                  'default_value' => 'left',
                  'ui'            => 1,
                ),
                array(
                  'key'           => 'field_sc_expressive_text_text_size',
                  'label'         => __('Text Scale', 'starter-coat'),
                  'name'          => 'text_size',
                  'type'          => 'select',
                  'choices'       => array(
                    'body'  => __('Body', 'starter-coat'),
                    'large' => __('Large', 'starter-coat'),
                    'xl'    => __('Extra Large', 'starter-coat'),
                  ),
                  'default_value' => 'large',
                  'ui'            => 1,
                ),
                array(
                  'key'           => 'field_sc_expressive_text_content_width',
                  'label'         => __('Content Width', 'starter-coat'),
                  'name'          => 'content_width',
                  'type'          => 'select',
                  'choices'       => array(
                    'narrow'    => __('Narrow', 'starter-coat'),
                    'container' => __('Container', 'starter-coat'),
                    'wide'      => __('Wide', 'starter-coat'),
                  ),
                  'default_value' => 'narrow',
                  'ui'            => 1,
                ),
                array(
                  'key'          => 'field_sc_expressive_text_buttons',
                  'label'        => __('Buttons (Optional)', 'starter-coat'),
                  'name'         => 'buttons',
                  'type'         => 'repeater',
                  'layout'       => 'row',
                  'button_label' => __('Add Button', 'starter-coat'),
                  'sub_fields'   => array(
                    array(
                      'key'   => 'field_sc_expressive_text_button_link',
                      'label' => __('Button Link', 'starter-coat'),
                      'name'  => 'button_link',
                      'type'  => 'link',
                    ),
                    array(
                      'key'           => 'field_sc_expressive_text_button_style',
                      'label'         => __('Button Style', 'starter-coat'),
                      'name'          => 'button_style',
                      'type'          => 'select',
                      'choices'       => array(
                        'primary' => __('Primary', 'starter-coat'),
                        'ghost'   => __('Ghost', 'starter-coat'),
                      ),
                      'default_value' => 'primary',
                      'ui'            => 1,
                    ),
                  ),
                ),
                array(
                  'key'   => 'field_sc_expressive_text_options_tab',
                  'label' => __('Section Options', 'starter-coat'),
                  'name'  => '',
                  'type'  => 'tab',
                ),
                ...$section_options,
              ),
            ),
            'layout_sc_marquee' => array(
              'key'        => 'layout_sc_marquee',
              'name'       => 'marquee',
              'label'      => __('Horizontal Marquee', 'starter-coat'),
              'display'    => 'block',
              'sub_fields' => array(
                array(
                  'key'   => 'field_sc_marquee_heading',
                  'label' => __('Heading (Optional)', 'starter-coat'),
                  'name'  => 'heading',
                  'type'  => 'text',
                ),
                array(
                  'key'   => 'field_sc_marquee_speed',
                  'label' => __('Scroll Speed', 'starter-coat'),
                  'name'  => 'speed',
                  'type'  => 'select',
                  'choices' => array(
                    'slow'   => __('Slow', 'starter-coat'),
                    'normal' => __('Normal', 'starter-coat'),
                    'fast'   => __('Fast', 'starter-coat'),
                  ),
                  'default_value' => 'normal',
                  'ui'            => 1,
                ),
                array(
                  'key'   => 'field_sc_marquee_direction',
                  'label' => __('Scroll Direction', 'starter-coat'),
                  'name'  => 'direction',
                  'type'  => 'select',
                  'choices' => array(
                    'rtl' => __('Right to Left', 'starter-coat'),
                    'ltr' => __('Left to Right', 'starter-coat'),
                  ),
                  'default_value' => 'rtl',
                  'ui'            => 1,
                ),
                array(
                  'key'   => 'field_sc_marquee_items',
                  'label' => __('Items', 'starter-coat'),
                  'name'  => 'items',
                  'type'  => 'repeater',
                  'layout' => 'row',
                  'button_label' => __('Add Item', 'starter-coat'),
                  'sub_fields' => array(
                    array(
                      'key'   => 'field_sc_marquee_item_text',
                      'label' => __('Text', 'starter-coat'),
                      'name'  => 'text',
                      'type'  => 'text',
                      'required' => 1,
                    ),
                    array(
                      'key'   => 'field_sc_marquee_item_link',
                      'label' => __('Link (Optional)', 'starter-coat'),
                      'name'  => 'link',
                      'type'  => 'link',
                    ),
                  ),
                ),
                array(
                  'key'   => 'field_sc_marquee_options_tab',
                  'label' => __('Section Options', 'starter-coat'),
                  'name'  => '',
                  'type'  => 'tab',
                ),
                ...$section_options,
              ),
            ),
            'layout_sc_stats' => array(
              'key'        => 'layout_sc_stats',
              'name'       => 'stats',
              'label'      => __('Stats (Count Up)', 'starter-coat'),
              'display'    => 'block',
              'sub_fields' => array(
                array(
                  'key'   => 'field_sc_stats_heading',
                  'label' => __('Heading (Optional)', 'starter-coat'),
                  'name'  => 'heading',
                  'type'  => 'text',
                ),
                array(
                  'key'   => 'field_sc_stats_intro',
                  'label' => __('Intro (Optional)', 'starter-coat'),
                  'name'  => 'intro',
                  'type'  => 'textarea',
                ),
                array(
                  'key'   => 'field_sc_stats_columns',
                  'label' => __('Columns', 'starter-coat'),
                  'name'  => 'columns',
                  'type'  => 'select',
                  'choices' => array(
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                  ),
                  'default_value' => '4',
                  'ui'            => 1,
                ),
                array(
                  'key'   => 'field_sc_stats_items',
                  'label' => __('Stats', 'starter-coat'),
                  'name'  => 'items',
                  'type'  => 'repeater',
                  'layout' => 'row',
                  'button_label' => __('Add Stat', 'starter-coat'),
                  'sub_fields' => array(
                    array(
                      'key'   => 'field_sc_stats_item_icon',
                      'label' => __('Icon Slug (Optional)', 'starter-coat'),
                      'name'  => 'icon',
                      'type'  => 'text',
                      'instructions' => __('Use icon file name from assets/icons without .svg, e.g. icon-quote', 'starter-coat'),
                    ),
                    array(
                      'key'   => 'field_sc_stats_item_value',
                      'label' => __('Value', 'starter-coat'),
                      'name'  => 'value',
                      'type'  => 'number',
                      'required' => 1,
                      'step'  => 1,
                      'min'   => 0,
                    ),
                    array(
                      'key'   => 'field_sc_stats_item_prefix',
                      'label' => __('Prefix (Optional)', 'starter-coat'),
                      'name'  => 'prefix',
                      'type'  => 'text',
                      'placeholder' => '$',
                    ),
                    array(
                      'key'   => 'field_sc_stats_item_suffix',
                      'label' => __('Suffix (Optional)', 'starter-coat'),
                      'name'  => 'suffix',
                      'type'  => 'text',
                      'placeholder' => '%',
                    ),
                    array(
                      'key'   => 'field_sc_stats_item_label',
                      'label' => __('Label', 'starter-coat'),
                      'name'  => 'label',
                      'type'  => 'text',
                    ),
                  ),
                ),
                array(
                  'key'   => 'field_sc_stats_options_tab',
                  'label' => __('Section Options', 'starter-coat'),
                  'name'  => '',
                  'type'  => 'tab',
                ),
                ...$section_options,
              ),
            ),
            'layout_sc_bold_list' => array(
              'key'        => 'layout_sc_bold_list',
              'name'       => 'bold_list',
              'label'      => __('Bold List (Expand or Link)', 'starter-coat'),
              'display'    => 'block',
              'sub_fields' => array(
                array(
                  'key'   => 'field_sc_bold_list_heading',
                  'label' => __('Heading', 'starter-coat'),
                  'name'  => 'heading',
                  'type'  => 'text',
                ),
                array(
                  'key'   => 'field_sc_bold_list_intro',
                  'label' => __('Intro (Optional)', 'starter-coat'),
                  'name'  => 'intro',
                  'type'  => 'textarea',
                ),
                array(
                  'key'   => 'field_sc_bold_list_style_variant',
                  'label' => __('Style Variant', 'starter-coat'),
                  'name'  => 'style_variant',
                  'type'  => 'select',
                  'choices' => array(
                    'brand-glow' => __('Brand Glow', 'starter-coat'),
                    'dark'       => __('Dark', 'starter-coat'),
                    'minimal'    => __('Minimal', 'starter-coat'),
                  ),
                  'default_value' => 'brand-glow',
                  'ui'            => 1,
                ),
                array(
                  'key'   => 'field_sc_bold_list_items',
                  'label' => __('Items', 'starter-coat'),
                  'name'  => 'items',
                  'type'  => 'repeater',
                  'layout' => 'block',
                  'button_label' => __('Add Item', 'starter-coat'),
                  'sub_fields' => array(
                    array(
                      'key'   => 'field_sc_bold_list_item_eyebrow',
                      'label' => __('Eyebrow / Value (Optional)', 'starter-coat'),
                      'name'  => 'eyebrow',
                      'type'  => 'text',
                      'placeholder' => '15',
                    ),
                    array(
                      'key'   => 'field_sc_bold_list_item_title',
                      'label' => __('Title', 'starter-coat'),
                      'name'  => 'title',
                      'type'  => 'text',
                      'required' => 1,
                    ),
                    array(
                      'key'   => 'field_sc_bold_list_item_mode',
                      'label' => __('Interaction', 'starter-coat'),
                      'name'  => 'item_mode',
                      'type'  => 'select',
                      'choices' => array(
                        'expand' => __('Expand', 'starter-coat'),
                        'link'   => __('Link Out', 'starter-coat'),
                      ),
                      'default_value' => 'expand',
                      'ui'            => 1,
                    ),
                    array(
                      'key'   => 'field_sc_bold_list_item_content',
                      'label' => __('Expanded Content', 'starter-coat'),
                      'name'  => 'content',
                      'type'  => 'textarea',
                      'rows'  => 4,
                      'conditional_logic' => array(
                        array(
                          array(
                            'field'    => 'field_sc_bold_list_item_mode',
                            'operator' => '==',
                            'value'    => 'expand',
                          ),
                        ),
                      ),
                    ),
                    array(
                      'key'   => 'field_sc_bold_list_item_link',
                      'label' => __('Link', 'starter-coat'),
                      'name'  => 'link',
                      'type'  => 'link',
                      'conditional_logic' => array(
                        array(
                          array(
                            'field'    => 'field_sc_bold_list_item_mode',
                            'operator' => '==',
                            'value'    => 'link',
                          ),
                        ),
                      ),
                    ),
                  ),
                ),
                array(
                  'key'   => 'field_sc_bold_list_options_tab',
                  'label' => __('Section Options', 'starter-coat'),
                  'name'  => '',
                  'type'  => 'tab',
                ),
                ...$section_options,
              ),
            ),
            'layout_sc_testimonials' => array(
              'key'        => 'layout_sc_testimonials',
              'name'       => 'testimonials',
              'label'      => __('Testimonials', 'starter-coat'),
              'display'    => 'block',
              'sub_fields' => array(
                array(
                  'key'   => 'field_sc_testimonials_heading',
                  'label' => __('Heading', 'starter-coat'),
                  'name'  => 'heading',
                  'type'  => 'text',
                ),
                array(
                  'key'   => 'field_sc_testimonials_subtext',
                  'label' => __('Subtext', 'starter-coat'),
                  'name'  => 'subtext',
                  'type'  => 'textarea',
                ),
                array(
                  'key'   => 'field_sc_testimonials_style',
                  'label' => __('Card Style', 'starter-coat'),
                  'name'  => 'style',
                  'type'  => 'select',
                  'choices' => array(
                    'simple'  => __('Simple', 'starter-coat'),
                    'feature' => __('Feature', 'starter-coat'),
                  ),
                  'default_value' => 'simple',
                  'ui'            => 1,
                ),
                array(
                  'key'   => 'field_sc_testimonials_display_mode',
                  'label' => __('Display Mode', 'starter-coat'),
                  'name'  => 'display_mode',
                  'type'  => 'select',
                  'choices' => array(
                    'grid'     => __('Grid', 'starter-coat'),
                    'carousel' => __('Carousel', 'starter-coat'),
                  ),
                  'default_value' => 'grid',
                  'ui'            => 1,
                ),
                array(
                  'key'   => 'field_sc_testimonials_columns',
                  'label' => __('Grid Columns', 'starter-coat'),
                  'name'  => 'columns',
                  'type'  => 'select',
                  'choices' => array(
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                  ),
                  'default_value' => '3',
                  'ui'            => 1,
                  'conditional_logic' => array(
                    array(
                      array(
                        'field'    => 'field_sc_testimonials_display_mode',
                        'operator' => '==',
                        'value'    => 'grid',
                      ),
                    ),
                  ),
                ),
                array(
                  'key'   => 'field_sc_testimonials_slides_per_view',
                  'label' => __('Slides Per View (Desktop)', 'starter-coat'),
                  'name'  => 'slides_per_view',
                  'type'  => 'select',
                  'choices' => array(
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                  ),
                  'default_value' => '1',
                  'ui'            => 1,
                  'conditional_logic' => array(
                    array(
                      array(
                        'field'    => 'field_sc_testimonials_display_mode',
                        'operator' => '==',
                        'value'    => 'carousel',
                      ),
                    ),
                  ),
                ),
                array(
                  'key'   => 'field_sc_testimonials_show_controls',
                  'label' => __('Show Carousel Controls', 'starter-coat'),
                  'name'  => 'show_controls',
                  'type'  => 'true_false',
                  'ui'    => 1,
                  'default_value' => 1,
                  'conditional_logic' => array(
                    array(
                      array(
                        'field'    => 'field_sc_testimonials_display_mode',
                        'operator' => '==',
                        'value'    => 'carousel',
                      ),
                    ),
                  ),
                ),
                array(
                  'key'          => 'field_sc_testimonials_items',
                  'label'        => __('Testimonials', 'starter-coat'),
                  'name'         => 'items',
                  'type'         => 'repeater',
                  'layout'       => 'row',
                  'button_label' => __('Add Testimonial', 'starter-coat'),
                  'sub_fields'   => array(
                    array(
                      'key'   => 'field_sc_testimonial_quote',
                      'label' => __('Quote', 'starter-coat'),
                      'name'  => 'quote',
                      'type'  => 'textarea',
                    ),
                    array(
                      'key'   => 'field_sc_testimonial_name',
                      'label' => __('Name', 'starter-coat'),
                      'name'  => 'name',
                      'type'  => 'text',
                    ),
                    array(
                      'key'   => 'field_sc_testimonial_info_line_one',
                      'label' => __('Info Line 1', 'starter-coat'),
                      'name'  => 'info_line_one',
                      'type'  => 'text',
                    ),
                    array(
                      'key'   => 'field_sc_testimonial_info_line_two',
                      'label' => __('Info Line 2', 'starter-coat'),
                      'name'  => 'info_line_two',
                      'type'  => 'text',
                    ),
                    array(
                      'key'           => 'field_sc_testimonial_photo',
                      'label'         => __('Photo (Optional)', 'starter-coat'),
                      'name'          => 'photo',
                      'type'          => 'image',
                      'return_format' => 'array',
                      'preview_size'  => 'thumbnail',
                      'mime_types'    => 'svg,png,jpg,jpeg,webp',
                    ),
                  ),
                ),
                array(
                  'key'   => 'field_sc_testimonials_options_tab',
                  'label' => __('Section Options', 'starter-coat'),
                  'name'  => '',
                  'type'  => 'tab',
                ),
                ...$section_options,
              ),
            ),
            'layout_sc_carousel' => array(
              'key'        => 'layout_sc_carousel',
              'name'       => 'carousel',
              'label'      => __('Carousel', 'starter-coat'),
              'display'    => 'block',
              'sub_fields' => array(
                array(
                  'key'   => 'field_sc_carousel_heading',
                  'label' => __('Heading', 'starter-coat'),
                  'name'  => 'heading',
                  'type'  => 'text',
                ),
                array(
                  'key'   => 'field_sc_carousel_subtext',
                  'label' => __('Subtext', 'starter-coat'),
                  'name'  => 'subtext',
                  'type'  => 'textarea',
                ),
                array(
                  'key'   => 'field_sc_carousel_slides_per_view',
                  'label' => __('Slides Per View (Desktop)', 'starter-coat'),
                  'name'  => 'slides_per_view',
                  'type'  => 'select',
                  'choices' => array(
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                  ),
                  'default_value' => '1',
                  'ui'            => 1,
                ),
                array(
                  'key'   => 'field_sc_carousel_show_controls',
                  'label' => __('Show Carousel Controls', 'starter-coat'),
                  'name'  => 'show_controls',
                  'type'  => 'true_false',
                  'ui'    => 1,
                  'default_value' => 1,
                ),
                array(
                  'key'          => 'field_sc_carousel_items',
                  'label'        => __('Slides', 'starter-coat'),
                  'name'         => 'items',
                  'type'         => 'repeater',
                  'layout'       => 'block',
                  'button_label' => __('Add Slide', 'starter-coat'),
                  'sub_fields'   => array(
                    array(
                      'key'   => 'field_sc_carousel_item_type',
                      'label' => __('Card Type', 'starter-coat'),
                      'name'  => 'card_type',
                      'type'  => 'select',
                      'choices' => array(
                        'testimonial' => __('Testimonial', 'starter-coat'),
                        'content'     => __('Content Card', 'starter-coat'),
                      ),
                      'default_value' => 'testimonial',
                      'ui'            => 1,
                    ),
                    array(
                      'key'   => 'field_sc_carousel_item_testimonial_style',
                      'label' => __('Testimonial Style', 'starter-coat'),
                      'name'  => 'testimonial_style',
                      'type'  => 'select',
                      'choices' => array(
                        'simple'  => __('Simple', 'starter-coat'),
                        'feature' => __('Feature', 'starter-coat'),
                      ),
                      'default_value' => 'feature',
                      'ui'            => 1,
                      'conditional_logic' => array(
                        array(
                          array(
                            'field'    => 'field_sc_carousel_item_type',
                            'operator' => '==',
                            'value'    => 'testimonial',
                          ),
                        ),
                      ),
                    ),
                    array(
                      'key'   => 'field_sc_carousel_item_quote',
                      'label' => __('Quote', 'starter-coat'),
                      'name'  => 'quote',
                      'type'  => 'textarea',
                      'conditional_logic' => array(
                        array(
                          array(
                            'field'    => 'field_sc_carousel_item_type',
                            'operator' => '==',
                            'value'    => 'testimonial',
                          ),
                        ),
                      ),
                    ),
                    array(
                      'key'   => 'field_sc_carousel_item_name',
                      'label' => __('Name', 'starter-coat'),
                      'name'  => 'name',
                      'type'  => 'text',
                      'conditional_logic' => array(
                        array(
                          array(
                            'field'    => 'field_sc_carousel_item_type',
                            'operator' => '==',
                            'value'    => 'testimonial',
                          ),
                        ),
                      ),
                    ),
                    array(
                      'key'   => 'field_sc_carousel_item_info_line_one',
                      'label' => __('Info Line 1', 'starter-coat'),
                      'name'  => 'info_line_one',
                      'type'  => 'text',
                      'conditional_logic' => array(
                        array(
                          array(
                            'field'    => 'field_sc_carousel_item_type',
                            'operator' => '==',
                            'value'    => 'testimonial',
                          ),
                        ),
                      ),
                    ),
                    array(
                      'key'   => 'field_sc_carousel_item_info_line_two',
                      'label' => __('Info Line 2', 'starter-coat'),
                      'name'  => 'info_line_two',
                      'type'  => 'text',
                      'conditional_logic' => array(
                        array(
                          array(
                            'field'    => 'field_sc_carousel_item_type',
                            'operator' => '==',
                            'value'    => 'testimonial',
                          ),
                        ),
                      ),
                    ),
                    array(
                      'key'           => 'field_sc_carousel_item_photo',
                      'label'         => __('Photo (Optional)', 'starter-coat'),
                      'name'          => 'photo',
                      'type'          => 'image',
                      'return_format' => 'array',
                      'preview_size'  => 'thumbnail',
                      'mime_types'    => 'svg,png,jpg,jpeg,webp',
                      'conditional_logic' => array(
                        array(
                          array(
                            'field'    => 'field_sc_carousel_item_type',
                            'operator' => '==',
                            'value'    => 'testimonial',
                          ),
                        ),
                      ),
                    ),
                    array(
                      'key'   => 'field_sc_carousel_item_eyebrow',
                      'label' => __('Eyebrow', 'starter-coat'),
                      'name'  => 'eyebrow',
                      'type'  => 'text',
                      'conditional_logic' => array(
                        array(
                          array(
                            'field'    => 'field_sc_carousel_item_type',
                            'operator' => '==',
                            'value'    => 'content',
                          ),
                        ),
                      ),
                    ),
                    array(
                      'key'   => 'field_sc_carousel_item_title',
                      'label' => __('Title', 'starter-coat'),
                      'name'  => 'title',
                      'type'  => 'text',
                      'conditional_logic' => array(
                        array(
                          array(
                            'field'    => 'field_sc_carousel_item_type',
                            'operator' => '==',
                            'value'    => 'content',
                          ),
                        ),
                      ),
                    ),
                    array(
                      'key'   => 'field_sc_carousel_item_copy',
                      'label' => __('Copy', 'starter-coat'),
                      'name'  => 'copy',
                      'type'  => 'textarea',
                      'conditional_logic' => array(
                        array(
                          array(
                            'field'    => 'field_sc_carousel_item_type',
                            'operator' => '==',
                            'value'    => 'content',
                          ),
                        ),
                      ),
                    ),
                    array(
                      'key'           => 'field_sc_carousel_item_image',
                      'label'         => __('Image (Optional)', 'starter-coat'),
                      'name'          => 'image',
                      'type'          => 'image',
                      'return_format' => 'array',
                      'preview_size'  => 'medium',
                      'mime_types'    => 'svg,png,jpg,jpeg,webp',
                      'conditional_logic' => array(
                        array(
                          array(
                            'field'    => 'field_sc_carousel_item_type',
                            'operator' => '==',
                            'value'    => 'content',
                          ),
                        ),
                      ),
                    ),
                    array(
                      'key'   => 'field_sc_carousel_item_button',
                      'label' => __('Button (Optional)', 'starter-coat'),
                      'name'  => 'button',
                      'type'  => 'link',
                      'conditional_logic' => array(
                        array(
                          array(
                            'field'    => 'field_sc_carousel_item_type',
                            'operator' => '==',
                            'value'    => 'content',
                          ),
                        ),
                      ),
                    ),
                  ),
                ),
                array(
                  'key'   => 'field_sc_carousel_options_tab',
                  'label' => __('Section Options', 'starter-coat'),
                  'name'  => '',
                  'type'  => 'tab',
                ),
                ...$section_options,
              ),
            ),
            'layout_sc_logos' => array(
              'key'        => 'layout_sc_logos',
              'name'       => 'logos',
              'label'      => __('Logo Grid', 'starter-coat'),
              'display'    => 'block',
              'sub_fields' => array(
                array(
                  'key'   => 'field_sc_logos_heading',
                  'label' => __('Heading', 'starter-coat'),
                  'name'  => 'heading',
                  'type'  => 'text',
                ),
                array(
                  'key'   => 'field_sc_logos_subtext',
                  'label' => __('Subtext', 'starter-coat'),
                  'name'  => 'subtext',
                  'type'  => 'textarea',
                ),
                array(
                  'key'           => 'field_sc_logos_columns',
                  'label'         => __('Columns (Desktop)', 'starter-coat'),
                  'name'          => 'columns',
                  'type'          => 'select',
                  'choices'       => array(
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                    '5' => '5',
                    '6' => '6',
                  ),
                  'default_value' => '4',
                  'ui'            => 1,
                ),
                array(
                  'key'          => 'field_sc_logos_items',
                  'label'        => __('Logos', 'starter-coat'),
                  'name'         => 'logos',
                  'type'         => 'repeater',
                  'button_label' => __('Add Logo', 'starter-coat'),
                  'layout'       => 'row',
                  'sub_fields'   => array(
                    array(
                      'key'           => 'field_sc_logos_item_image',
                      'label'         => __('Logo Image', 'starter-coat'),
                      'name'          => 'image',
                      'type'          => 'image',
                      'return_format' => 'array',
                      'preview_size'  => 'medium',
                      'mime_types'    => 'svg,png,jpg,jpeg,webp',
                    ),
                    array(
                      'key'   => 'field_sc_logos_item_link',
                      'label' => __('Optional Link', 'starter-coat'),
                      'name'  => 'link',
                      'type'  => 'link',
                    ),
                  ),
                ),
                array(
                  'key'   => 'field_sc_logos_options_tab',
                  'label' => __('Section Options', 'starter-coat'),
                  'name'  => '',
                  'type'  => 'tab',
                ),
                ...$section_options,
              ),
            ),
            'layout_sc_html' => array(
              'key'        => 'layout_sc_html',
              'name'       => 'html',
              'label'      => __('Generic HTML', 'starter-coat'),
              'display'    => 'block',
              'sub_fields' => array(
                array(
                  'key'   => 'field_sc_html_heading',
                  'label' => __('Admin Label (Optional)', 'starter-coat'),
                  'name'  => 'heading',
                  'type'  => 'text',
                  'instructions' => __('Optional internal label to help identify this section in the editor.', 'starter-coat'),
                ),
                array(
                  'key'   => 'field_sc_html_content',
                  'label' => __('HTML Content', 'starter-coat'),
                  'name'  => 'html_content',
                  'type'  => 'textarea',
                  'rows'  => 12,
                  'new_lines' => '',
                  'instructions' => __('Paste custom HTML (shortcodes are supported).', 'starter-coat'),
                ),
                array(
                  'key'   => 'field_sc_html_options_tab',
                  'label' => __('Section Options', 'starter-coat'),
                  'name'  => '',
                  'type'  => 'tab',
                ),
                ...$section_options,
              ),
            ),
            'layout_sc_breakout_text' => array(
              'key'        => 'layout_sc_breakout_text',
              'name'       => 'breakout_text',
              'label'      => __('Breakout Text', 'starter-coat'),
              'display'    => 'block',
              'sub_fields' => array(
                array(
                  'key'   => 'field_sc_breakout_text_content',
                  'label' => __('Content', 'starter-coat'),
                  'name'  => 'content',
                  'type'  => 'wysiwyg',
                ),
                array(
                  'key'           => 'field_sc_breakout_text_align',
                  'label'         => __('Alignment', 'starter-coat'),
                  'name'          => 'text_align',
                  'type'          => 'select',
                  'choices'       => array(
                    'left'   => __('Left', 'starter-coat'),
                    'center' => __('Center', 'starter-coat'),
                    'right'  => __('Right', 'starter-coat'),
                  ),
                  'default_value' => 'center',
                  'ui'            => 1,
                ),
                array(
                  'key'           => 'field_sc_breakout_text_size',
                  'label'         => __('Text Size', 'starter-coat'),
                  'name'          => 'text_size',
                  'type'          => 'select',
                  'choices'       => array(
                    'md' => __('Medium', 'starter-coat'),
                    'lg' => __('Large', 'starter-coat'),
                    'xl' => __('Extra Large', 'starter-coat'),
                  ),
                  'default_value' => 'lg',
                  'ui'            => 1,
                ),
                array(
                  'key'   => 'field_sc_breakout_text_button_tab',
                  'label' => __('Button (Optional)', 'starter-coat'),
                  'name'  => '',
                  'type'  => 'tab',
                ),
                array(
                  'key'   => 'field_sc_breakout_text_button_label',
                  'label' => __('Button Label', 'starter-coat'),
                  'name'  => 'button_label',
                  'type'  => 'text',
                ),
                array(
                  'key'   => 'field_sc_breakout_text_button_link',
                  'label' => __('Button Link (Optional)', 'starter-coat'),
                  'name'  => 'button_link',
                  'type'  => 'link',
                ),
                array(
                  'key'   => 'field_sc_breakout_text_modal_target',
                  'label' => __('Modal Target ID (Optional)', 'starter-coat'),
                  'name'  => 'modal_target_id',
                  'type'  => 'text',
                  'instructions' => __('Enter a hidden modal unique ID to open it from this button.', 'starter-coat'),
                ),
                array(
                  'key'   => 'field_sc_breakout_text_options_tab',
                  'label' => __('Section Options', 'starter-coat'),
                  'name'  => '',
                  'type'  => 'tab',
                ),
                ...$section_options,
              ),
            ),
            'layout_sc_video_embed' => array(
              'key'        => 'layout_sc_video_embed',
              'name'       => 'video_embed',
              'label'      => __('Video Embed', 'starter-coat'),
              'display'    => 'block',
              'sub_fields' => array(
                array(
                  'key'   => 'field_sc_video_embed_heading',
                  'label' => __('Heading', 'starter-coat'),
                  'name'  => 'heading',
                  'type'  => 'text',
                ),
                array(
                  'key'   => 'field_sc_video_embed_intro',
                  'label' => __('Intro', 'starter-coat'),
                  'name'  => 'intro',
                  'type'  => 'textarea',
                ),
                array(
                  'key'   => 'field_sc_video_embed_code',
                  'label' => __('Video Embed Code', 'starter-coat'),
                  'name'  => 'video_embed_code',
                  'type'  => 'textarea',
                  'instructions' => __('Paste iframe embed code (YouTube/Vimeo/etc).', 'starter-coat'),
                ),
                array(
                  'key'   => 'field_sc_video_embed_url',
                  'label' => __('Video URL (fallback)', 'starter-coat'),
                  'name'  => 'video_url',
                  'type'  => 'url',
                ),
                array(
                  'key'           => 'field_sc_video_embed_open_modal',
                  'label'         => __('Open In Modal', 'starter-coat'),
                  'name'          => 'open_in_modal',
                  'type'          => 'true_false',
                  'ui'            => 1,
                  'default_value' => 0,
                ),
                array(
                  'key'   => 'field_sc_video_embed_modal_id',
                  'label' => __('Modal Unique ID', 'starter-coat'),
                  'name'  => 'modal_id',
                  'type'  => 'text',
                  'instructions' => __('Used for trigger target (letters, numbers, hyphens only).', 'starter-coat'),
                  'conditional_logic' => array(
                    array(
                      array(
                        'field'    => 'field_sc_video_embed_open_modal',
                        'operator' => '==',
                        'value'    => '1',
                      ),
                    ),
                  ),
                ),
                array(
                  'key'   => 'field_sc_video_embed_button_label',
                  'label' => __('Modal Button Label', 'starter-coat'),
                  'name'  => 'button_label',
                  'type'  => 'text',
                  'default_value' => __('Watch Video', 'starter-coat'),
                  'conditional_logic' => array(
                    array(
                      array(
                        'field'    => 'field_sc_video_embed_open_modal',
                        'operator' => '==',
                        'value'    => '1',
                      ),
                    ),
                  ),
                ),
                array(
                  'key'   => 'field_sc_video_embed_options_tab',
                  'label' => __('Section Options', 'starter-coat'),
                  'name'  => '',
                  'type'  => 'tab',
                ),
                ...$section_options,
              ),
            ),
            'layout_sc_map_embed' => array(
              'key'        => 'layout_sc_map_embed',
              'name'       => 'map_embed',
              'label'      => __('Map Embed (Google)', 'starter-coat'),
              'display'    => 'block',
              'sub_fields' => array(
                array(
                  'key'   => 'field_sc_map_embed_layout',
                  'label' => __('Layout', 'starter-coat'),
                  'name'  => 'layout_mode',
                  'type'  => 'select',
                  'choices' => array(
                    'one-col' => __('One Column', 'starter-coat'),
                    'two-col' => __('Two Column', 'starter-coat'),
                  ),
                  'default_value' => 'two-col',
                  'ui'            => 1,
                ),
                array(
                  'key'   => 'field_sc_map_embed_address',
                  'label' => __('Address', 'starter-coat'),
                  'name'  => 'address',
                  'type'  => 'text',
                  'instructions' => __('Used to generate a Google Maps embed when custom embed HTML is empty.', 'starter-coat'),
                ),
                array(
                  'key'   => 'field_sc_map_embed_custom_embed',
                  'label' => __('Custom Embed HTML (Optional)', 'starter-coat'),
                  'name'  => 'custom_embed_html',
                  'type'  => 'textarea',
                  'rows'  => 5,
                  'instructions' => __('Optional iframe embed code. If provided, this overrides address-generated embed.', 'starter-coat'),
                ),
                array(
                  'key'           => 'field_sc_map_embed_height',
                  'label'         => __('Map Height (px)', 'starter-coat'),
                  'name'          => 'map_height',
                  'type'          => 'number',
                  'default_value' => 420,
                  'min'           => 240,
                  'max'           => 900,
                  'step'          => 10,
                ),
                array(
                  'key'   => 'field_sc_map_embed_width',
                  'label' => __('Map Width', 'starter-coat'),
                  'name'  => 'map_width',
                  'type'  => 'select',
                  'choices' => array(
                    'narrow' => __('Narrow', 'starter-coat'),
                    'normal' => __('Normal', 'starter-coat'),
                    'wide'   => __('Wide', 'starter-coat'),
                    'full'   => __('Full', 'starter-coat'),
                  ),
                  'default_value' => 'normal',
                  'ui'            => 1,
                ),
                array(
                  'key'   => 'field_sc_map_embed_ratio',
                  'label' => __('Two Column Ratio', 'starter-coat'),
                  'name'  => 'ratio',
                  'type'  => 'select',
                  'choices' => array(
                    '50-50' => '50 / 50',
                    '66-33' => '2 / 3',
                  ),
                  'default_value' => '50-50',
                  'ui'            => 1,
                  'conditional_logic' => array(
                    array(
                      array(
                        'field'    => 'field_sc_map_embed_layout',
                        'operator' => '==',
                        'value'    => 'two-col',
                      ),
                    ),
                  ),
                ),
                array(
                  'key'   => 'field_sc_map_embed_position',
                  'label' => __('Map Position', 'starter-coat'),
                  'name'  => 'map_position',
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
                        'field'    => 'field_sc_map_embed_layout',
                        'operator' => '==',
                        'value'    => 'two-col',
                      ),
                    ),
                  ),
                ),
                array(
                  'key'   => 'field_sc_map_embed_content_type',
                  'label' => __('Content Type', 'starter-coat'),
                  'name'  => 'content_type',
                  'type'  => 'select',
                  'choices' => array(
                    'text' => __('Text Fields', 'starter-coat'),
                    'html' => __('Custom HTML', 'starter-coat'),
                  ),
                  'default_value' => 'text',
                  'ui'            => 1,
                ),
                array(
                  'key'   => 'field_sc_map_embed_kicker',
                  'label' => __('Kicker', 'starter-coat'),
                  'name'  => 'kicker',
                  'type'  => 'text',
                  'conditional_logic' => array(
                    array(
                      array(
                        'field'    => 'field_sc_map_embed_content_type',
                        'operator' => '==',
                        'value'    => 'text',
                      ),
                    ),
                  ),
                ),
                array(
                  'key'   => 'field_sc_map_embed_heading',
                  'label' => __('Heading', 'starter-coat'),
                  'name'  => 'heading',
                  'type'  => 'text',
                  'conditional_logic' => array(
                    array(
                      array(
                        'field'    => 'field_sc_map_embed_content_type',
                        'operator' => '==',
                        'value'    => 'text',
                      ),
                    ),
                  ),
                ),
                array(
                  'key'   => 'field_sc_map_embed_text_content',
                  'label' => __('Text Content', 'starter-coat'),
                  'name'  => 'text_content',
                  'type'  => 'wysiwyg',
                  'conditional_logic' => array(
                    array(
                      array(
                        'field'    => 'field_sc_map_embed_content_type',
                        'operator' => '==',
                        'value'    => 'text',
                      ),
                    ),
                  ),
                ),
                array(
                  'key'   => 'field_sc_map_embed_custom_html_content',
                  'label' => __('Custom HTML Content', 'starter-coat'),
                  'name'  => 'custom_html_content',
                  'type'  => 'textarea',
                  'rows'  => 6,
                  'instructions' => __('Optional HTML shown beside the map.', 'starter-coat'),
                  'conditional_logic' => array(
                    array(
                      array(
                        'field'    => 'field_sc_map_embed_content_type',
                        'operator' => '==',
                        'value'    => 'html',
                      ),
                    ),
                  ),
                ),
                array(
                  'key'   => 'field_sc_map_embed_options_tab',
                  'label' => __('Section Options', 'starter-coat'),
                  'name'  => '',
                  'type'  => 'tab',
                ),
                ...$section_options,
              ),
            ),
            'layout_sc_forms_two_col' => array(
              'key'        => 'layout_sc_forms_two_col',
              'name'       => 'forms_two_col',
              'label'      => __('Forms: Two Column', 'starter-coat'),
              'display'    => 'block',
              'sub_fields' => array(
                array(
                  'key'   => 'field_sc_forms_two_col_heading',
                  'label' => __('Heading', 'starter-coat'),
                  'name'  => 'heading',
                  'type'  => 'text',
                ),
                array(
                  'key'   => 'field_sc_forms_two_col_subtext',
                  'label' => __('Subtext', 'starter-coat'),
                  'name'  => 'subtext',
                  'type'  => 'textarea',
                ),
                array(
                  'key'   => 'field_sc_forms_two_col_left_intro',
                  'label' => __('Left Column Intro', 'starter-coat'),
                  'name'  => 'left_intro',
                  'type'  => 'wysiwyg',
                ),
                array(
                  'key'   => 'field_sc_forms_two_col_left_shortcode',
                  'label' => __('Left Form Shortcode', 'starter-coat'),
                  'name'  => 'left_form_shortcode',
                  'type'  => 'text',
                  'placeholder' => '[wpforms id="123"]',
                ),
                array(
                  'key'   => 'field_sc_forms_two_col_right_intro',
                  'label' => __('Right Column Intro', 'starter-coat'),
                  'name'  => 'right_intro',
                  'type'  => 'wysiwyg',
                ),
                array(
                  'key'   => 'field_sc_forms_two_col_right_shortcode',
                  'label' => __('Right Form Shortcode', 'starter-coat'),
                  'name'  => 'right_form_shortcode',
                  'type'  => 'text',
                  'placeholder' => '[gravityform id="1" title="false" description="false"]',
                ),
                array(
                  'key'   => 'field_sc_forms_two_col_options_tab',
                  'label' => __('Section Options', 'starter-coat'),
                  'name'  => '',
                  'type'  => 'tab',
                ),
                ...$section_options,
              ),
            ),
            'layout_sc_hidden_modal' => array(
              'key'        => 'layout_sc_hidden_modal',
              'name'       => 'hidden_modal',
              'label'      => __('Hidden Modal', 'starter-coat'),
              'display'    => 'block',
              'sub_fields' => array(
                array(
                  'key'   => 'field_sc_hidden_modal_unique_id',
                  'label' => __('Unique ID', 'starter-coat'),
                  'name'  => 'modal_id',
                  'type'  => 'text',
                  'required' => 1,
                  'instructions' => __('Example: demo-video-modal. Use this ID in modal trigger buttons.', 'starter-coat'),
                ),
                array(
                  'key'   => 'field_sc_hidden_modal_content_type',
                  'label' => __('Content Type', 'starter-coat'),
                  'name'  => 'content_type',
                  'type'  => 'select',
                  'choices' => array(
                    'video' => __('Video', 'starter-coat'),
                    'form'  => __('Form', 'starter-coat'),
                    'html'  => __('Custom HTML', 'starter-coat'),
                  ),
                  'default_value' => 'video',
                  'ui'            => 1,
                ),
                array(
                  'key'   => 'field_sc_hidden_modal_video_embed',
                  'label' => __('Video Embed Code', 'starter-coat'),
                  'name'  => 'video_embed_code',
                  'type'  => 'textarea',
                  'conditional_logic' => array(
                    array(
                      array(
                        'field'    => 'field_sc_hidden_modal_content_type',
                        'operator' => '==',
                        'value'    => 'video',
                      ),
                    ),
                  ),
                ),
                array(
                  'key'   => 'field_sc_hidden_modal_video_url',
                  'label' => __('Video URL (fallback)', 'starter-coat'),
                  'name'  => 'video_url',
                  'type'  => 'url',
                  'conditional_logic' => array(
                    array(
                      array(
                        'field'    => 'field_sc_hidden_modal_content_type',
                        'operator' => '==',
                        'value'    => 'video',
                      ),
                    ),
                  ),
                ),
                array(
                  'key'   => 'field_sc_hidden_modal_form_shortcode',
                  'label' => __('Form Shortcode', 'starter-coat'),
                  'name'  => 'form_shortcode',
                  'type'  => 'text',
                  'conditional_logic' => array(
                    array(
                      array(
                        'field'    => 'field_sc_hidden_modal_content_type',
                        'operator' => '==',
                        'value'    => 'form',
                      ),
                    ),
                  ),
                ),
                array(
                  'key'   => 'field_sc_hidden_modal_html_content',
                  'label' => __('HTML Content', 'starter-coat'),
                  'name'  => 'html_content',
                  'type'  => 'wysiwyg',
                  'conditional_logic' => array(
                    array(
                      array(
                        'field'    => 'field_sc_hidden_modal_content_type',
                        'operator' => '==',
                        'value'    => 'html',
                      ),
                    ),
                  ),
                ),
                array(
                  'key'   => 'field_sc_hidden_modal_trigger_tab',
                  'label' => __('Optional Trigger Button', 'starter-coat'),
                  'name'  => '',
                  'type'  => 'tab',
                ),
                array(
                  'key'           => 'field_sc_hidden_modal_render_trigger',
                  'label'         => __('Render Trigger Button In Flow', 'starter-coat'),
                  'name'          => 'render_trigger',
                  'type'          => 'true_false',
                  'ui'            => 1,
                  'default_value' => 0,
                ),
                array(
                  'key'   => 'field_sc_hidden_modal_trigger_label',
                  'label' => __('Trigger Button Label', 'starter-coat'),
                  'name'  => 'trigger_label',
                  'type'  => 'text',
                  'default_value' => __('Open Modal', 'starter-coat'),
                  'conditional_logic' => array(
                    array(
                      array(
                        'field'    => 'field_sc_hidden_modal_render_trigger',
                        'operator' => '==',
                        'value'    => '1',
                      ),
                    ),
                  ),
                ),
                array(
                  'key'   => 'field_sc_hidden_modal_trigger_snippet',
                  'label' => __('Trigger Snippet (Copy)', 'starter-coat'),
                  'name'  => 'trigger_snippet',
                  'type'  => 'textarea',
                  'rows'  => 3,
                  'readonly' => 1,
                  'instructions' => __('Auto-generated from Unique ID. Copy and paste into Generic HTML, Breakout Text, or custom templates.', 'starter-coat'),
                  'conditional_logic' => array(
                    array(
                      array(
                        'field'    => 'field_sc_hidden_modal_render_trigger',
                        'operator' => '==',
                        'value'    => '0',
                      ),
                    ),
                  ),
                ),
                array(
                  'key'   => 'field_sc_hidden_modal_options_tab',
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
      'menu_order' => 10,
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
          'type'  => 'radio',
          'choices' => array(
            'none'  => __('Default', 'starter-coat'),
            'light' => __('Light', 'starter-coat'),
            'dark'  => __('Dark', 'starter-coat'),
            'brand' => __('Brand', 'starter-coat'),
            'muted' => __('Muted', 'starter-coat'),
          ),
          'default_value' => 'none',
          'layout'        => 'horizontal',
          'wrapper'       => array(
            'class' => 'sc-acf-color-palette',
          ),
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
                'press'   => __('Press', 'starter-coat'),
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
              'type'  => 'radio',
              'choices' => array(
                'none'  => __('Default', 'starter-coat'),
                'light' => __('Light', 'starter-coat'),
                'dark'  => __('Dark', 'starter-coat'),
                'brand' => __('Brand', 'starter-coat'),
                'muted' => __('Muted', 'starter-coat'),
              ),
              'default_value' => 'none',
              'layout'        => 'horizontal',
              'wrapper'       => array(
                'class' => 'sc-acf-color-palette',
              ),
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
      'key'    => 'group_sc_artist_page_fields',
      'title'  => __('Artist Profile Fields', 'starter-coat'),
      'fields' => array(
        array(
          'key'   => 'field_sc_artist_tier',
          'label' => __('Tier', 'starter-coat'),
          'name'  => 'sc_artist_tier',
          'type'  => 'select',
          'choices' => array(
            'Blossoming' => __('Blossoming', 'starter-coat'),
            'Seedlings'  => __('Seedlings', 'starter-coat'),
          ),
          'allow_null'    => 1,
          'default_value' => 'Seedlings',
          'ui'            => 1,
        ),
        array(
          'key'   => 'field_sc_artist_focus',
          'label' => __('Focus', 'starter-coat'),
          'name'  => 'sc_artist_focus',
          'type'  => 'text',
          'placeholder' => __('Makeup and Hair', 'starter-coat'),
        ),
        array(
          'key'   => 'field_sc_artist_pronouns',
          'label' => __('Pronouns', 'starter-coat'),
          'name'  => 'sc_artist_pronouns',
          'type'  => 'text',
          'placeholder' => __('she/her', 'starter-coat'),
        ),
        array(
          'key'   => 'field_sc_artist_location',
          'label' => __('Location', 'starter-coat'),
          'name'  => 'sc_artist_location',
          'type'  => 'text',
          'placeholder' => __('Vancouver, BC', 'starter-coat'),
        ),
        array(
          'key'   => 'field_sc_artist_cta_link',
          'label' => __('CTA Button', 'starter-coat'),
          'name'  => 'sc_artist_cta_link',
          'type'  => 'link',
          'instructions' => __('Example: Book Now button for booking links.', 'starter-coat'),
        ),
        array(
          'key'   => 'field_sc_artist_gallery_images',
          'label' => __('Gallery Images', 'starter-coat'),
          'name'  => 'sc_artist_gallery_images',
          'type'  => 'gallery',
          'return_format' => 'id',
          'preview_size'  => 'thumbnail',
          'insert'        => 'append',
          'library'       => 'all',
          'mime_types'    => 'jpg,jpeg,png,webp',
        ),
        array(
          'key'   => 'field_sc_artist_gallery_mode',
          'label' => __('Gallery Display Mode', 'starter-coat'),
          'name'  => 'sc_artist_gallery_mode',
          'type'  => 'select',
          'choices' => array(
            'carousel'        => __('Carousel', 'starter-coat'),
            'carousel_thumbs' => __('Carousel + Thumbnails', 'starter-coat'),
            'inline'          => __('Inline Grid', 'starter-coat'),
            'modal'           => __('Grid + Modal', 'starter-coat'),
          ),
          'default_value' => 'carousel',
          'ui'            => 1,
        ),
        array(
          'key'   => 'field_sc_artist_gallery_columns',
          'label' => __('Gallery Columns', 'starter-coat'),
          'name'  => 'sc_artist_gallery_columns',
          'type'  => 'select',
          'choices' => array(
            '2' => __('2 Columns', 'starter-coat'),
            '3' => __('3 Columns', 'starter-coat'),
            '4' => __('4 Columns', 'starter-coat'),
          ),
          'default_value' => '3',
          'ui'            => 1,
        ),
      ),
      'location' => array(
        array(
          array(
            'param'    => 'page_template',
            'operator' => '==',
            'value'    => 'templates/template-artist-profile.php',
          ),
        ),
      ),
    )
  );

  call_user_func(
    'acf_add_local_field_group',
    array(
      'key'    => 'group_sc_press_fields',
      'title'  => __('Press Fields', 'starter-coat'),
      'fields' => array(
        array(
          'key'   => 'field_sc_press_external_url',
          'label' => __('External URL', 'starter-coat'),
          'name'  => 'sc_press_external_url',
          'type'  => 'url',
          'required' => 1,
          'instructions' => __('Destination URL for this press item card.', 'starter-coat'),
        ),
        array(
          'key'           => 'field_sc_press_open_new_tab',
          'label'         => __('Open In New Tab', 'starter-coat'),
          'name'          => 'sc_press_open_new_tab',
          'type'          => 'true_false',
          'ui'            => 1,
          'default_value' => 1,
        ),
        array(
          'key'   => 'field_sc_press_publication',
          'label' => __('Publication', 'starter-coat'),
          'name'  => 'sc_press_publication',
          'type'  => 'text',
        ),
        array(
          'key'   => 'field_sc_press_published_on',
          'label' => __('Published On', 'starter-coat'),
          'name'  => 'sc_press_published_on',
          'type'  => 'date_picker',
          'display_format' => 'F j, Y',
          'return_format'  => 'Ymd',
          'first_day'      => 0,
        ),
      ),
      'location' => array(
        array(
          array(
            'param'    => 'post_type',
            'operator' => '==',
            'value'    => 'press',
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
            'press'   => __('Press', 'starter-coat'),
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

/**
 * Validate card collection rows to prevent empty cards.
 *
 * @param bool|string $valid Existing validation state.
 * @param mixed       $value Repeater value.
 * @return bool|string
 */
function starter_coat_validate_card_collection_items($valid, $value)
{
  if (true !== $valid) {
    return $valid;
  }

  if (! is_array($value) || empty($value)) {
    return __('Add at least one card item.', 'starter-coat');
  }

  foreach ($value as $row) {
    if (! is_array($row)) {
      continue;
    }

    $title = isset($row['title']) ? trim((string) $row['title']) : '';
    $copy  = isset($row['copy']) ? trim((string) $row['copy']) : '';
    $url   = isset($row['card_url']) ? trim((string) $row['card_url']) : '';

    if ('' !== $title || '' !== $copy || '' !== $url) {
      continue;
    }

    $media_type = isset($row['media_type']) ? (string) $row['media_type'] : 'none';
    $icon_name  = isset($row['icon_name']) ? trim((string) $row['icon_name']) : '';
    $image      = isset($row['image']) ? $row['image'] : null;
    $has_image  = is_array($image) && (! empty($image['ID']) || ! empty($image['url']));

    $list_items = isset($row['list_items']) && is_array($row['list_items']) ? $row['list_items'] : array();
    $has_list   = false;
    foreach ($list_items as $list_row) {
      $list_text = isset($list_row['text']) ? trim((string) $list_row['text']) : '';
      if ('' !== $list_text) {
        $has_list = true;
        break;
      }
    }

    if ('icon' === $media_type && '' !== $icon_name) {
      continue;
    }

    if ('image' === $media_type && $has_image) {
      continue;
    }

    if ($has_list) {
      continue;
    }

    return __('Each card needs at least one piece of content (title, paragraph, list, icon/image, or URL).', 'starter-coat');
  }

  return $valid;
}
add_filter('acf/validate_value/key=field_sc_card_collection_items', 'starter_coat_validate_card_collection_items', 10, 2);

/**
 * Add visual swatches to background color radio fields in ACF.
 */
function starter_coat_acf_palette_admin_styles()
{
  if (! is_admin()) {
    return;
  }
?>
  <style>
    :root {
      --sc-palette-default: #ffffff;
      --sc-palette-light: #f8fafc;
      --sc-palette-dark: #0f172a;
      --sc-palette-brand: #335cfa;
      --sc-palette-muted: #f1f5f9;
      --sc-palette-border: #cbd5e1;
    }

    .acf-field.sc-acf-color-palette .acf-radio-list {
      display: flex;
      flex-wrap: wrap;
      gap: 0.5rem;
    }

    .acf-field.sc-acf-color-palette .acf-radio-list label {
      display: inline-flex;
      align-items: center;
      gap: 0.45rem;
      padding: 0.35rem 0.65rem;
      border: 1px solid var(--sc-palette-border);
      border-radius: 999px;
      background: #fff;
      line-height: 1.2;
    }

    .acf-field.sc-acf-color-palette .acf-radio-list input {
      margin-right: 0.2rem;
    }

    .acf-field.sc-acf-color-palette .acf-radio-list label::after {
      content: '';
      width: 0.8rem;
      height: 0.8rem;
      border-radius: 999px;
      border: 1px solid rgba(15, 23, 42, 0.2);
      background: var(--sc-palette-default);
      flex: 0 0 auto;
    }

    .acf-field.sc-acf-color-palette .acf-radio-list label:has(input[value="none"])::after {
      background: var(--sc-palette-default);
    }

    .acf-field.sc-acf-color-palette .acf-radio-list label:has(input[value="light"])::after {
      background: var(--sc-palette-light);
    }

    .acf-field.sc-acf-color-palette .acf-radio-list label:has(input[value="dark"])::after {
      background: var(--sc-palette-dark);
    }

    .acf-field.sc-acf-color-palette .acf-radio-list label:has(input[value="brand"])::after {
      background: var(--sc-palette-brand);
    }

    .acf-field.sc-acf-color-palette .acf-radio-list label:has(input[value="muted"])::after {
      background: var(--sc-palette-muted);
    }
  </style>
<?php
}
add_action('admin_head', 'starter_coat_acf_palette_admin_styles');

/**
 * Populate Hidden Modal trigger snippet helper fields in ACF editor.
 */
function starter_coat_acf_modal_trigger_helper_script()
{
  if (! is_admin()) {
    return;
  }
?>
  <script>
    (function() {
      function slugify(value) {
        return String(value || '')
          .trim()
          .toLowerCase()
          .replace(/[^a-z0-9\-_]+/g, '-')
          .replace(/^-+|-+$/g, '');
      }

      function updateModalTriggerSnippets() {
        document.querySelectorAll('.layout[data-layout="layout_sc_hidden_modal"]').forEach(function(layout) {
          var idInput = layout.querySelector('.acf-field[data-name="modal_id"] input[type="text"]');
          var snippetField = layout.querySelector('.acf-field[data-name="trigger_snippet"] textarea');

          if (!idInput || !snippetField) {
            return;
          }

          var modalId = slugify(idInput.value);

          if (!modalId) {
            snippetField.value = '<!-- Enter a Unique ID above to generate this snippet -->';
            return;
          }

          snippetField.value = '<button type="button" class="btn btn--primary btn--md" data-modal-target="#' + modalId + '">Open Modal</button>';
        });
      }

      document.addEventListener('input', function(event) {
        if (event.target && event.target.closest('.acf-field[data-name="modal_id"], .acf-field[data-name="trigger_snippet"]')) {
          updateModalTriggerSnippets();
        }
      });

      document.addEventListener('DOMContentLoaded', updateModalTriggerSnippets);

      if (window.acf && typeof window.acf.addAction === 'function') {
        window.acf.addAction('append', updateModalTriggerSnippets);
        window.acf.addAction('sortstop', updateModalTriggerSnippets);
      }
    })();
  </script>
<?php
}
add_action('admin_footer', 'starter_coat_acf_modal_trigger_helper_script');
