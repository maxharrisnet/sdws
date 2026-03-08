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
