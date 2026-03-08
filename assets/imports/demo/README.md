# Starter Coat Demo Import Pack

This import pack seeds realistic test content across pages, posts, and CPTs, then populates flexible ACF sections with many layout/variation combinations.

## File

- `starter-coat-demo-import.php`
  - Run with WP-CLI from your WordPress install root:
  - `wp eval-file wp-content/themes/starter-coat/assets/imports/demo/starter-coat-demo-import.php`

## What It Creates/Updates

- Demo pages:
  - `Home - Hype Demo` (`template-homepage.php`)
  - `Home - BAV Demo` (`template-homepage.php`)
  - `About - Hype Demo`
  - `About - BAV Demo`
  - `Projects Demo Archive` (`template-archive.php` for `project`)
  - `Updates Demo Archive` (`template-archive.php` for `post`)
  - `Contact Demo` (`template-contact.php`)
  - `Booking Demo`
  - `Privacy Demo`
- Sets front page/posts page:
  - Front page -> `Home - Hype Demo`
  - Posts page -> `Updates Demo Archive`
- CPT entries:
  - `project` (4)
  - `event` (4)
  - `faq` (6)
  - `press` (3)
  - `post` (5)
- Taxonomy terms and assignments:
  - `project_category`, `event_type`
  - `faq_topic`, `press_category`
- ACF flexible sections (if ACF is active):
  - Seeds broad coverage of section layouts and variations on both demo homepages.

## Section Coverage

The seeded rows cover most section layouts and key variations, including:

- `feature`, `content_media`, `text_media`
- `cards`, `card_collection`
- `testimonials` (grid and carousel)
- `carousel` (testimonial + content card types)
- `bold_list`, `feature_list`, `stats`
- `marquee`, `breakout_text`, `video_embed`
- `forms_two_col`, `hidden_modal`, `html`, `logos`

## Notes

- Script is idempotent by slug/post type (safe to rerun; it updates existing demo items).
- Placeholder logo/image URLs are used where no local media is guaranteed.
- Form shortcodes are placeholders (`[wpforms id="1"]`, etc.) and can be swapped after import.
- For best visual QA, set featured images on key posts/CPT entries after seeding.
