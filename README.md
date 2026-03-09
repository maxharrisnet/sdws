# Starter Coat Theme

Starter Coat is an ACF-first WordPress theme foundation derived from Underscores, optimized for reusable sections/components and a non-block-editor page-building workflow.

## Quick Start

```sh
npm install
npm run dev
npm run build
```

Build outputs:

- CSS source: `assets/scss/theme.scss`
- CSS output: `assets/css/theme.css`
- JS source: `assets/js/theme.js`
- JS output: `assets/js/dist/theme.js`

## Architecture

- `inc/`: focused theme modules (assets, editor behavior, CPT/taxonomy setup, ACF registration, template helpers, media, ajax).
- `template-parts/components/`: reusable rendering pieces (hero, cards, carousel, testimonials, modal, form, etc.).
- `template-parts/sections/`: ACF flexible-content section partials.
- `templates/`: assignable page templates.
- `assets/scss/`: tokens, theme presets, base, layout, and component styles.
- `assets/js/theme.js`: frontend interactions (nav, carousel, modal, counters, filters, accordions).

## Editor and Content Strategy

- ACF flexible sections drive page composition via `sc_sections`.
- Block editor is disabled for pages and registered CPTs.
- Block editor remains enabled for standard `post` unless changed in `inc/editor.php`.
- Most section templates use shared helper functions:
  - `starter_coat_get_section_classes()`
  - `starter_coat_get_section_container_class()`
  - `starter_coat_get_sub_field()`

## Registered Post Types

Registered in `inc/post-types.php`:

- `project`
- `event`
- `faq`
- `profile`

## Flexible Sections Reference

All layouts are registered in `inc/acf-fields.php` and rendered automatically by `starter_coat_render_sections()` in `inc/template-helpers.php`.

- `content_media`: expressive content + media block with layout variations.
- `card_collection`: configurable multi-card section with pre/post content controls.
- `expressive_text`: typography-forward content section with button support.
- `feature`: two-column feature block.
- `cards`: classic multi-column card grid.
- `feature_list`: two-column capability-style list with image-backed items.
- `logos`: logo/social-proof grid.
- `testimonials`: testimonial grid or carousel.
- `carousel`: mixed card carousel (content/testimonial).
- `html`: generic HTML/shortcode section.
- `breakout_text`: prominent text statement with optional button/modal trigger.
- `video_embed`: inline video embed or modal-triggered video.
- `forms_two_col`: two-column forms section using shortcode forms.
- `hidden_modal`: reusable modal target by unique ID with video/form/html payload.
- `marquee`: infinite horizontal marquee list with speed and direction controls.
- `stats`: count-up stats with optional icon, prefix/suffix, and column controls.
- `bold_list`: large interactive rows; each item can either expand or link out.
- `text_media`: legacy text/media section retained for compatibility.

## Theme Options Reference

Configured in `inc/acf-fields.php` under ACF Options and post-level field groups.

Global options pages and groups:

- Theme preset and branding (favicon fallback, preset class).
- Color scheme selector (independent from preset) so palettes can be tested with any preset variation.
- Navigation settings:
  - layout/style/alignment variants
  - logo source and logo mark behavior
  - CTA button
  - social display
  - announcement/banner controls
- Global CTA settings:
  - content, actions (buttons or form), layout, width, background, styles.
- Contact information.
- Social links.
- Footer settings:
  - layout mode, logo options, social options, legal/main menus, copyright.

Per-post/page field groups:

- CTA override (page/post/CPT level).
- Singular hero settings.
- Archive hero settings.
- Template-specific fields:
  - contact template
  - artist profile
  - archive template

## Templates

Found in `templates/`:

- `template-homepage.php`
- `template-contact.php`
- `template-archive.php`
- `template-generic-container.php`
- `template-generic-full-width.php`
- `template-artist-profile.php`
- `template-artists-directory.php`

## Frontend Behaviors

Implemented in `assets/js/theme.js`:

- Responsive navigation + submenu toggles.
- Fixed-header offset syncing.
- Carousel (centered slide, controls, dots, loop behavior).
- Modal triggers and close behavior.
- AJAX taxonomy filtering.
- Stats count-up on intersection.
- Bold-list accordion behavior.

## AI Agent Notes

Use these rules when extending the codebase:

- Prefer adding new flexible layouts in `inc/acf-fields.php` and matching section partials in `template-parts/sections/`.
- Keep section markup thin and move visual complexity to SCSS component partials.
- Reuse shared helpers (`starter_coat_get_sub_field`, section class/container helpers) instead of direct `get_sub_field` calls when possible.
- Preserve fallback behavior when fields are empty; templates should safely `return` on empty required content.
- For interactive sections, add initialization in `assets/js/theme.js` with defensive checks (`if (!node) return;`).
- For icons, use `starter_coat_the_icon()` with slugs from `assets/icons/*.svg`.
- Keep output escaped unless intentionally rendering trusted shortcode/embed HTML.
- Always run:
  - `php -l` on touched PHP files
  - `npm run build`
  - diagnostics check for edited files

## TODO Backlog

Recommended next hardening steps:

- Build an internal "Section Library" page/template that showcases every section and variant for QA.
- Add global design controls (spacing/radius/motion intensity) to Theme Settings.
- Add per-section enable/schedule controls for campaign timing.
- Add optional dynamic data mode for reusable content sections (query CPTs instead of manual repeaters).
- Add analytics metadata fields for key CTAs and emit `data-analytics-*` attributes.
- Complete an accessibility pass:
  - modal focus trap
  - keyboard interaction checks for all accordions/carousels
  - heading hierarchy validation
- Add SEO/social defaults and schema helpers for FAQ/video/organization contexts.
- Add consistent empty-state messaging where editors leave optional groups blank.
- Define and document image-size usage per section and enforce in templates.
- Add editor help text and copy-ready examples for complex field groups.
- Add section presets to speed authoring (preconfigured layout/style defaults).
- Add release checklist and smoke-test routine for deploy safety.

## Plugins

Required/expected:

- Advanced Custom Fields Pro
- WPForms (or equivalent shortcode form plugin)

Optional:

- Jetpack (responsive video support already enabled)

## Credits

- Based on Underscores by Automattic.
- Licensed GPL-2.0-or-later.
