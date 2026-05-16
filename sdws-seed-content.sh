#!/usr/bin/env bash
# ============================================================================
# SDWS Infrastructure Setup Script
# Creates WP pages, taxonomy terms, and installs plugins.
# NOTE: For real exhibition/workshop content, run sdws-import-content.php instead:
#   wp eval-file wp-content/themes/starter-coat/sdws-import-content.php \
#     --path="/Users/max/Local Sites/san-diego-watercolor-society/app/public"
# ============================================================================

WP="wp --path=\"/Users/max/Local Sites/san-diego-watercolor-society/app/public\""

echo "=== Creating required WordPress pages ==="

# Create pages (skip if slug already exists)
create_page() {
  local title="$1" slug="$2"
  if ! eval "$WP post list --post_type=page --post_status=publish --field=post_name" 2>/dev/null | grep -q "^${slug}$"; then
    eval "$WP post create --post_type=page --post_title=\"$title\" --post_name=\"$slug\" --post_status=publish"
    echo "  Created page: $title"
  else
    echo "  Page exists: $title"
  fi
}

create_page "Workshops"                 "workshops"
create_page "Exhibition Schedule"       "schedule"
create_page "International Exhibition"  "international"
create_page "Donate"                    "donate"
create_page "Calendar"                  "calendar"

echo ""
echo "=== Seeding taxonomy terms ==="

eval "$WP term create workshop_format 'In-Person' --slug=in-person" 2>/dev/null || echo "  workshop_format 'In-Person' exists"
eval "$WP term create workshop_format 'Zoom' --slug=zoom" 2>/dev/null || echo "  workshop_format 'Zoom' exists"
eval "$WP term create workshop_format 'Beginner Series' --slug=beginner-series" 2>/dev/null || echo "  workshop_format 'Beginner Series' exists"
eval "$WP term create exhibition_type 'Member Show' --slug=member-show" 2>/dev/null || echo "  exhibition_type 'Member Show' exists"
eval "$WP term create exhibition_type 'International' --slug=international" 2>/dev/null || echo "  exhibition_type 'International' exists"
eval "$WP term create exhibition_type 'Plein Air' --slug=plein-air" 2>/dev/null || echo "  exhibition_type 'Plein Air' exists"

echo ""
echo "=== Seeding 2026 exhibition schedule ==="

seed_exhibition() {
  local title="$1" start="$2" end="$3" juror="$4" reception="$5" entry_open="$6" entry_close="$7" jury="$8" type_slug="$9"

  local post_id
  post_id=$(eval "$WP post create \
    --post_type=sdws_exhibition \
    --post_status=publish \
    --post_title=\"$title\" \
    --porcelain" 2>/dev/null)

  if [[ -z "$post_id" ]]; then
    echo "  FAILED: $title"
    return
  fi

  # Set meta fields
  eval "$WP post meta update $post_id exhibition_show_dates_start '$start'" 2>/dev/null
  eval "$WP post meta update $post_id exhibition_show_dates_end '$end'" 2>/dev/null
  [[ -n "$juror" ]]       && eval "$WP post meta update $post_id exhibition_juror '$juror'" 2>/dev/null
  [[ -n "$reception" ]]   && eval "$WP post meta update $post_id exhibition_reception_date '$reception'" 2>/dev/null
  [[ -n "$entry_open" ]]  && eval "$WP post meta update $post_id exhibition_online_entry_date '$entry_open'" 2>/dev/null
  [[ -n "$entry_close" ]] && eval "$WP post meta update $post_id exhibition_entry_day '$entry_close'" 2>/dev/null
  [[ -n "$jury" ]]        && eval "$WP post meta update $post_id exhibition_jury_date '$jury'" 2>/dev/null

  # Assign taxonomy term
  [[ -n "$type_slug" ]] && eval "$WP post term set $post_id exhibition_type '$type_slug'" 2>/dev/null

  echo "  Created (#$post_id): $title"
}

# ---- 2026 Member / Plein Air / International Exhibitions ----
# Data from SDWS source document — update dates as confirmed

seed_exhibition \
  "2026 April Plein Air Exhibition" \
  "2026-04-05" "2026-04-25" \
  "" "2026-04-09" \
  "2026-03-01" "2026-03-20" "2026-03-25" \
  "plein-air"

seed_exhibition \
  "2026 May 'The Will of the Brush' Member Exhibition" \
  "2026-04-26" "2026-05-29" \
  "Chuck McPhearson" "2026-05-07" \
  "2026-03-15" "2026-04-03" "2026-04-10" \
  "member-show"

seed_exhibition \
  "2026 June Member Exhibition" \
  "2026-05-31" "2026-06-27" \
  "" "2026-06-05" \
  "2026-04-01" "2026-05-01" "2026-05-08" \
  "member-show"

seed_exhibition \
  "2026 Summer Plein Air Exhibition" \
  "2026-06-28" "2026-07-25" \
  "" "2026-07-02" \
  "2026-05-15" "2026-06-05" "2026-06-12" \
  "plein-air"

seed_exhibition \
  "2026 August Member Exhibition" \
  "2026-07-26" "2026-08-29" \
  "" "2026-08-06" \
  "2026-06-01" "2026-07-03" "2026-07-10" \
  "member-show"

seed_exhibition \
  "2026 September Member Exhibition" \
  "2026-08-30" "2026-09-26" \
  "" "2026-09-03" \
  "2026-07-01" "2026-08-07" "2026-08-14" \
  "member-show"

seed_exhibition \
  "46th International Exhibition" \
  "2026-09-27" "2026-10-31" \
  "Ana Laura Salazar" "2026-10-01" \
  "2026-05-01" "2026-06-15" "2026-06-30" \
  "international"

seed_exhibition \
  "2026 November Member Exhibition" \
  "2026-11-01" "2026-11-28" \
  "" "2026-11-05" \
  "2026-09-01" "2026-10-02" "2026-10-09" \
  "member-show"

seed_exhibition \
  "2026 Holiday Member Exhibition" \
  "2026-11-29" "2026-12-31" \
  "" "2026-12-03" \
  "2026-10-01" "2026-11-06" "2026-11-13" \
  "member-show"

echo ""
echo "=== Setting homepage ==="
# Set front page to 'Home' if a static front page is needed
# (Leave as blog posts if preferred — remove comments to activate)
# front_id=$(eval "$WP post list --post_type=page --name=home --field=ID" 2>/dev/null | head -1)
# if [[ -n "$front_id" ]]; then
#   eval "$WP option update show_on_front page"
#   eval "$WP option update page_on_front $front_id"
# fi

echo ""
echo "=== Flushing rewrite rules ==="
eval "$WP rewrite flush --hard" 2>/dev/null && echo "  Rewrite rules flushed." || echo "  Could not flush rewrites — do it from WP Admin > Settings > Permalinks."

echo ""
echo "=== Installing required plugins ==="
eval "$WP plugin install the-events-calendar --activate" 2>/dev/null
eval "$WP plugin install foogallery --activate" 2>/dev/null
eval "$WP plugin install wordfence --activate" 2>/dev/null
eval "$WP plugin install updraftplus --activate" 2>/dev/null
eval "$WP plugin install redirection --activate" 2>/dev/null
eval "$WP plugin install wp-mail-smtp --activate" 2>/dev/null
eval "$WP plugin install contact-form-7 --activate" 2>/dev/null
eval "$WP plugin install shortpixel-image-optimiser --activate" 2>/dev/null

echo ""
echo "=== Done! ==="
echo "Next steps:"
echo "  1. Visit WP Admin > Appearance > Menus and assign the primary menu"
echo "  2. Upload sdws-logo.jpg to /assets/images/ in the theme"
echo "  3. Go to Settings > Permalinks and save to ensure rewrite rules are active"
echo "  4. Configure Wordfence from WP Admin > Wordfence"
echo "  5. Add exhibition images and workshop instructor images via Media Library"
