# SDWS – San Diego Watercolor Society
## Claude Code Project File

---

## Project Overview

Rebuilding the San Diego Watercolor Society website after a hack/data loss event. The goal is a clean, elegant WordPress site that feels like a contemporary art gallery — not a generic nonprofit. Fast turnaround for a board presentation.

**Live target:** `wordpress.sdwatercolor.` (Local by Flywheel for dev)
**Redirect:** `sdws.org` → new site temporarily

---

## Design System

### Aesthetic Direction
- Inspired by woodwardcontemporary.com: editorial, gallery-forward, spacious
- Watercolour color palette — explore muted teals, warm whites, soft ochres, dusty roses
- **Text: black (#000) on white (#fff) ONLY — no exceptions. WCAG AA minimum.**
- NO rounded corners anywhere
- NO tiny text — body minimum 16px
- Large, bold, uppercase-capable headings
- Generous padding and whitespace
- Sans-serif typography throughout
- Color-blocked sections used selectively (not every section)
- Rectangular image crops

### Color Palette (CSS Variables — adjust as needed)
```css
:root {
  --color-primary: #3a9aaa;   /* teal from logo */
  --color-black: #000000;
  --color-white: #ffffff;
  --color-off-white: #f8f6f2;
  --color-block-1: #e8e0d5;   /* warm sand */
  --color-block-2: #d4e8e4;   /* muted aqua */
  --color-accent: #c4703a;    /* warm ochre/rust */
}
```

### Typography
- Display/Headings: `DM Serif Display` or `Cormorant Garamond` (Google Fonts)
- Body: `DM Sans` or `Outfit`
- Load via `wp_enqueue_style` — no inline loading

---

## Image System

### Registered Sizes (`inc/media.php`)

| Slug | Dimensions | Crop | Use |
|------|-----------|------|-----|
| `sc-hero` | 1920 × 1080 | hard | Hero component full-bleed image |
| `sc-hero-md` | 1280 × 720 | hard | Hero component at medium breakpoints |
| `sc-card-header` | 960 × 600 | hard | Workshop cards, gallery strip, gallery component |
| `sc-card-header-featured` | 1440 × 900 | hard | Workshop single featured image |
| `sc-profile-square-sm` | 320 × 320 | hard | Testimonial avatars, small portraits |
| `sc-profile-square-lg` | 640 × 640 | hard | Juror photo, author portraits |
| `sc-logo` | 480 × 180 | soft | Partner/sponsor logos |
| `sc-logo-mark` | 200 × 200 | hard | Square logo marks |

WordPress defaults are also tuned on theme activation: thumbnail 480 × 480, medium 768px wide, large 1920px wide.

### Image Output Rules

**Always use `wp_get_attachment_image()` (or `the_post_thumbnail()`)** — never output a raw `<img src="...url...">` when an attachment ID is available. The ACF image array always includes `['ID']` when the image was uploaded via the media library.

**Required attributes on every image call:**

```php
echo wp_get_attachment_image($id, 'sc-card-header', false, array(
  'loading'  => 'lazy',      // all images below the fold
  'decoding' => 'async',     // all images
  'sizes'    => '...',       // always specify; see per-use values below
  'alt'      => '...',       // explicit; fallback to title or '' for decorative
));
```

**Hero exception — above-the-fold LCP image:**
```php
array(
  'loading'       => 'eager',
  'fetchpriority' => 'high',
  'decoding'      => 'async',
)
```

### Sizes Attribute Reference

| Context | `sizes` value |
|---------|--------------|
| Hero image | `(min-width: 1200px) 560px, (min-width: 768px) 45vw, 100vw` |
| Workshop card | `(min-width: 1200px) 380px, (min-width: 768px) 45vw, 100vw` |
| Gallery strip (front-page) | `(min-width: 1200px) 320px, (min-width: 768px) 30vw, 50vw` |
| Gallery component | `(min-width: 1200px) 400px, (min-width: 768px) 33vw, 100vw` |
| Juror / portrait (200px column) | `(min-width: 768px) 200px, 40vw` |
| Content media (half-width) | `(min-width: 1200px) 640px, (min-width: 768px) 50vw, 100vw` |
| Feature list cards | `(min-width: 1200px) 480px, (min-width: 768px) 33vw, 100vw` |
| Logo grid | `(min-width: 1200px) 180px, (min-width: 768px) 22vw, 40vw` |

### CSS Utilities (`assets/css/sdws.css`)

```css
.sdws-img-crop  { width:100%; object-fit:cover; object-position:center; }
.sdws-img-4-3   { aspect-ratio: 4 / 3; }
.sdws-img-3-2   { aspect-ratio: 3 / 2; }
.sdws-img-16-9  { aspect-ratio: 16 / 9; }
.sdws-img-square { aspect-ratio: 1 / 1; }
```

Pair a size class with `.sdws-img-crop` on the `<img>` to enforce consistent cropping without needing hard-crop regeneration.

---

## Site Architecture

### Pages & Templates
| Page | Template | Notes |
|------|----------|-------|
| Home | `front-page.php` | Hero, gallery teaser, I-show promo, CTA |
| Workshops | `page-workshops.php` | CPT loop |
| Exhibitions > Schedule | `page-schedule.php` | CPT loop |
| Exhibitions > International | `page-international.php` | Static + juror |
| Calendar | `page-calendar.php` | Plugin-powered |
| Donate | `page-donate.php` | PayPal button |

### Navigation
```
Home | Donate | Workshops | Exhibitions ▾ | Calendar
                                ├── Schedule
                                └── International Exhibition
```

---

## Custom Post Types & Taxonomies

### CPT: `sdws_workshop`
**Fields (ACF or register_meta):**
- `workshop_title` (post title)
- `workshop_instructor`
- `workshop_date_start` / `workshop_date_end`
- `workshop_price_member` / `workshop_price_nonmember`
- `workshop_format` (taxonomy: In-Person / Zoom / Beginner Series)
- `workshop_thumbnail` (featured image)
- `workshop_description` (post content)
- `workshop_materials_link` (URL)

**Taxonomy:** `workshop_format`
- in-person
- zoom
- beginner-series

### CPT: `sdws_exhibition`
**Fields:**
- `exhibition_title` (post title)
- `exhibition_show_dates_start` / `_end`
- `exhibition_juror`
- `exhibition_online_entry_date`
- `exhibition_entry_day`
- `exhibition_jury_date`
- `exhibition_reception_date`
- `exhibition_notes` (rich text)
- `exhibition_type` (taxonomy: member-show / international / plein-air)

**Taxonomy:** `exhibition_type`
- member-show
- international
- plein-air

---

## Plugins to Install

### Required
| Plugin | Purpose | Notes |
|--------|---------|-------|
| **Advanced Custom Fields (ACF)** | CPT field management | Free tier sufficient |
| **The Events Calendar** | Calendar page | Free, WP CLI installable |
| **Envira Gallery** or **FooGallery** | Image galleries | FooGallery is lighter |
| **Wordfence Security** | Security/firewall | Essential post-hack |
| **UpdraftPlus** | Backups | Daily offsite backups |
| **Redirection** | sdws.org → new URL | 301 redirects |
| **WP Mail SMTP** | Email reliability | Use for contact forms |
| **Contact Form 7** | Contact/support form | Simple, lightweight |
| **Smush** or **ShortPixel** | Image optimization | Required with gallery |

### Plugin Install Commands (WP-CLI via Local SSH)
```bash
wp plugin install advanced-custom-fields --activate
wp plugin install the-events-calendar --activate
wp plugin install foogallery --activate
wp plugin install wordfence --activate
wp plugin install updraftplus --activate
wp plugin install redirection --activate
wp plugin install wp-mail-smtp --activate
wp plugin install contact-form-7 --activate
wp plugin install shortpixel-image-optimiser --activate
```

---

## WordPress Version Note

As of this build, WordPress 6.x+ introduced the Site Editor (FSE). Confirm the installed version with:
```bash
wp core version
```
Theme should be built as a **classic child theme** (not FSE/block theme) unless you specifically want to use Full Site Editing. The base boilerplate appears to be a classic theme.

---

## Security Checklist (Post-Hack)
- [ ] Change all admin passwords immediately
- [ ] Install Wordfence, run full scan
- [ ] Set `WP_DEBUG` to `false` in production `wp-config.php`
- [ ] Disable XML-RPC if not needed: add to `functions.php`
- [ ] Rename admin username from `admin` if still default
- [ ] Add login attempt limits (Wordfence handles this)
- [ ] Ensure file permissions: dirs 755, files 644
- [ ] Review and remove unused themes and plugins
- [ ] Move `wp-config.php` one level above webroot if host allows
- [ ] Set up UpdraftPlus to backup to Google Drive or Dropbox daily

---

## Cleanup Tasks (Base Boilerplate)

Before building, audit and remove unused boilerplate. See the main prompt for the full cleanup checklist. Run this to see registered CPTs before deleting anything:
```bash
wp post-type list
```

---

## Content Sources

All page content lives in the project doc (tabs):
- Home, Donate, Workshops, Exhibitions/Schedule, International Exhibition
- Workshop images: provided (use as featured images for CPT posts)
- Building image: provided
- Gallery images: ~90 for June Member Show (placeholders OK for now)
- Stock placeholder images: acceptable during build

---

## Key Contacts / Emails Referenced in Content
- Workshops registrar: registrar@sdws.org
- Workshop Director: workshops@sdws.org
- Support: support@sdws.org

---

## Claude Code Design Feature

Use Claude Code's `/design` command to generate UI components and page layouts. Workflow:
1. Open the project in VS Code with the Claude Code extension active
2. Use `/design` to iterate on visual components (hero, card layouts, etc.)
3. Describe the desired component with reference to the design system above
4. Copy output into the appropriate template file

Example prompt for `/design`:
> "Design a workshop card component: rectangular, black text on white, large instructor name, date pill badge in teal, member/non-member price display, no rounded corners. Gallery-minimal aesthetic."

---

## File Structure (Theme)
```
sdws-theme/
├── style.css              # Theme header
├── functions.php          # Enqueues, CPT registration, hooks
├── index.php
├── front-page.php         # Homepage template
├── page.php               # Default page
├── page-workshops.php
├── page-schedule.php
├── page-international.php
├── page-donate.php
├── page-calendar.php
├── header.php
├── footer.php
├── single-sdws_workshop.php
├── single-sdws_exhibition.php
├── template-parts/
│   ├── hero.php
│   ├── workshop-card.php
│   ├── exhibition-card.php
│   └── home-ishow-banner.php
├── assets/
│   ├── css/
│   │   └── main.css
│   ├── js/
│   │   └── main.js
│   └── images/
│       └── sdws-logo.jpg
└── acf-json/              # ACF field group JSON (version control)
```

---

## Styling Rules — No Inline Styles, No !important, Stay DRY

### Never use inline styles in PHP templates
All visual styling must live in `assets/css/sdws.css` (SDWS-specific) or `assets/css/theme.css` (base theme). Inline `style=""` attributes in template files are **forbidden** — no exceptions.

**Wrong:**
```php
<h1 style="font-family:var(--font-display); font-size:clamp(2.5rem,5vw,4rem); color:#000;">
<section class="sdws-section" style="background:#fff; border-bottom: var(--border);">
```

**Right:**
```php
<h1 class="sdws-page-title">
<section class="sdws-section sdws-section--bordered">
```
Add the corresponding rule to `sdws.css`. CSS class names make styles reusable and overridable.

### Never use `!important`
`!important` is a sign that inline styles exist somewhere that need to be beaten. Eliminate the inline style instead of fighting it with `!important`. The only permissible `!important` is the global `border-radius: 0 !important` reset that targets third-party plugin output.

### Reuse existing components — stay DRY
Before writing new markup for any UI pattern, check `template-parts/` for an existing component:

| Need | Component to use |
|------|-----------------|
| CTA / call-to-action section | `template-parts/components/cta.php` |
| Hero banner | `template-parts/components/hero.php` |
| Gallery | `template-parts/components/gallery.php` |
| Card | `template-parts/components/card.php` |
| Section wrappers | `.sdws-section`, `.sdws-section--teal`, `.sdws-section--sand`, `.sdws-section--aqua`, `.sdws-section--off-white` |
| Buttons | `.sdws-btn`, `.sdws-btn--primary`, `.sdws-btn--teal`, `.sdws-btn--outline`, `.sdws-btn--white` |
| Grid layouts | `.sdws-grid-2`, `.sdws-grid-3` |

### CTAs must use the shared CTA component
The donate page, workshop contact block, exhibition pages, and any other call-to-action must all render through `template-parts/components/cta.php`. Pass data via the `$args['cta']` array. Do **not** write one-off CTA markup in page templates — that's how inconsistency creeps in.

```php
get_template_part('template-parts/components/cta', null, array(
  'cta' => array(
    'title'               => 'Donate to SDWS',
    'copy'                => 'Your gift sustains a vibrant watercolor arts community.',
    'background'          => 'teal',   // or 'none', 'sand', 'aqua', 'off-white'
    'layout'              => 'stacked',
    'button_primary'      => array('title' => 'Donate via PayPal', 'url' => $paypal_url, 'target' => '_blank'),
    'button_primary_style'=> 'primary',
  ),
));
```

If the component lacks a needed variant, add a CSS modifier class to `sdws.css` — don't patch it with an inline style.

---

## Do Not Do
- Do not use Gutenberg blocks for the primary layout (keep it template-file driven)
- Do not use `@import` in CSS for fonts — use `wp_enqueue_style`
- Do not leave `WP_DEBUG true` in any committed config
- Do not hardcode the siteurl — use `get_template_directory_uri()`
- Do not use the Twenty* themes as a base — use the provided boilerplate
- Do not write inline `style=""` attributes in any template file — put styles in CSS
- Do not use `!important` (except the global border-radius reset for plugin output)
- Do not duplicate CTA, button, or section markup — use the shared components
