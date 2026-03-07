# Contact Information & Social Media Links

## Overview

Global contact information and social media links are managed through **Theme Settings** in the WordPress admin.

## ACF Fields Added

### Contact Information

- Phone
- Email
- Address
- Business Hours

### Social Media Links

- Facebook
- Twitter/X
- Instagram
- LinkedIn
- YouTube
- TikTok
- Pinterest
- GitHub

## Helper Functions

### Get Contact Information

```php
$contact = starter_coat_get_contact_info();
// Returns array with keys: phone, email, address, hours
```

### Get Social Media Links

```php
$social_links = starter_coat_get_social_links();
// Returns array of platform => URL (only platforms with values)
```

## Components

### Social Links Component

Display social media icons with links from global options.

**Usage:**

```php
get_template_part(
  'template-parts/components/social-links',
  null,
  array(
    'style' => 'icon', // 'icon' or 'text'
    'size'  => 'md',   // 'sm', 'md', 'lg'
  )
);
```

### Contact Info Component

Display contact information from global options.

**Usage:**

```php
get_template_part(
  'template-parts/components/contact-info',
  null,
  array(
    'fields'      => array('phone', 'email', 'address', 'hours'), // Which fields to show
    'layout'      => 'stacked', // 'stacked' or 'inline'
    'show_labels' => true,      // Whether to show field labels
  )
);
```

## Example: Adding to Footer

```php
// In footer.php or template-parts/components/footer.php

// Contact info
get_template_part(
  'template-parts/components/contact-info',
  null,
  array(
    'fields'      => array('phone', 'email'),
    'layout'      => 'inline',
    'show_labels' => false,
  )
);

// Social links
get_template_part(
  'template-parts/components/social-links',
  null,
  array(
    'style' => 'icon',
    'size'  => 'md',
  )
);
```

## Manual Access

You can also access individual fields directly:

```php
// Get a single contact field
$phone = get_field('sc_contact_phone', 'option');
$email = get_field('sc_contact_email', 'option');

// Get a single social link
$facebook = get_field('sc_social_facebook', 'option');
$twitter = get_field('sc_social_twitter', 'option');
```
