=== Starter Coat ===

Contributors: maxharrisnet
Tags: custom-background, custom-logo, custom-menu, featured-images, threaded-comments, translation-ready, accessibility-ready
Requires at least: 6.0
Tested up to: 6.6
Requires PHP: 7.4
Stable tag: 1.0.0
License: GNU General Public License v2 or later
License URI: LICENSE

ACF-first section and component based starter theme for custom WordPress builds.

== Description ==

Starter Coat is a reusable WordPress theme foundation that uses ACF flexible content for page composition and keeps templates component-driven.

Highlights:
- ACF flexible section architecture (`sc_sections`).
- Reusable section partials in `template-parts/sections/`.
- Reusable UI components in `template-parts/components/`.
- Theme options for navigation, footer, CTA, contact, and social settings.
- Build pipeline using Sass + Vite.

== Installation ==

1. Upload the theme and activate it in Appearance > Themes.
2. Install required plugins (ACF Pro, optional form plugin such as WPForms).
3. Configure options in Theme Settings (ACF options page).
4. Start building page layouts using the Sections flexible content field.

== Frequently Asked Questions ==

= Is this a block-editor-first theme? =

No. Pages and registered custom post types are configured for an ACF-first workflow.

= Which plugins are expected? =

Advanced Custom Fields Pro is expected. A shortcode-based form plugin is recommended for form sections.

= Where are sections defined? =

Sections are registered in `inc/acf-fields.php` and rendered from `template-parts/sections/`.

== Changelog ==

= 1.0.0 =
* Initial Starter Coat base release with ACF-first section architecture.

== Credits ==

* Based on Underscores https://underscores.me/
* normalize.css by Nicolas Gallagher and Jonathan Neal
