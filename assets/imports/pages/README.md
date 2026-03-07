# Artist Page Import Files

This folder contains native WordPress import files for regular `page` content.

## Primary File

- `wordpress-import-artist-pages.xml`
  - Use with WordPress importer: `Tools -> Import -> WordPress`.
  - Imports one parent page (`Artists`) and seven child artist pages.
  - Child pages are nested under the `Artists` page via page parent relationships.

## After Import

- Set featured images manually on each artist page.
- Optional: Add `Artists` page to your primary navigation menu.
- Optional: Set page templates and hero fields in ACF for each page.
