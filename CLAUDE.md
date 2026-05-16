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

## Do Not Do
- Do not use Gutenberg blocks for the primary layout (keep it template-file driven)
- Do not use `@import` in CSS for fonts — use `wp_enqueue_style`
- Do not leave `WP_DEBUG true` in any committed config
- Do not hardcode the siteurl — use `get_template_directory_uri()`
- Do not use the Twenty* themes as a base — use the provided boilerplate
