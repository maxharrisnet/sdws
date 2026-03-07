# Profile Import Files

This folder contains import-ready content based on `_OG_CONTENT/Hype Relations Artist Profiles.md`.

## Files

- `wordpress-import-profiles.xml`
  - Preferred file for now.
  - Use with native WordPress importer: `Tools -> Import -> WordPress`.
  - Imports directly into `profile` custom post type.
  - Includes a `profile_tier` post meta value for each entry.

- `profile-posts-wp-all-import.csv`
  - Best for: WP All Import or similar CSV import plugins.
  - Contains columns: `post_type`, `post_status`, `post_title`, `post_content`, `profile_tier`, `profile_focus`.

- `profile-posts-wxr.xml`
  - Same content as `wordpress-import-profiles.xml` (legacy filename).
  - Imports directly into `profile` custom post type.
  - Includes a `profile_tier` post meta value for each entry.

## Notes

- `Kirsten` is imported as `draft` because bio is pending.
- Images were not included and can be set later as featured images.
- Source artifact `4o mini` from the original document was intentionally excluded.
