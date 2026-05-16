<?php
/**
 * SDWS Content Import
 * Populates exhibitions, workshops, and ACF options from the real copy document.
 *
 * WARNING: Deletes all existing sdws_exhibition and sdws_workshop posts first.
 *
 * Run via:
 *   wp eval-file wp-content/themes/starter-coat/sdws-import-content.php \
 *     --path="/Users/max/Local Sites/san-diego-watercolor-society/app/public"
 */

if (!defined('ABSPATH')) {
    exit;
}

$has_acf = function_exists('update_field');

echo "\n=== SDWS Content Import ===\n\n";

// ── Helper: set post meta, ACF-aware ──────────────────────────────────────────
function sdws_set_meta($post_id, $key, $value) {
    global $has_acf;
    if ($has_acf && function_exists('update_field')) {
        update_field($key, $value, $post_id);
    } else {
        update_post_meta($post_id, $key, $value);
    }
}

// ── Helper: ensure taxonomy term exists, return ID ───────────────────────────
function sdws_ensure_term($name, $slug, $taxonomy) {
    $term = get_term_by('slug', $slug, $taxonomy);
    if (!$term) {
        $result = wp_insert_term($name, $taxonomy, ['slug' => $slug]);
        if (is_wp_error($result)) {
            echo "  ERROR creating term $slug: " . $result->get_error_message() . "\n";
            return 0;
        }
        echo "  Created term: $name ($taxonomy)\n";
        return (int) $result['term_id'];
    }
    return (int) $term->term_id;
}

// ── Helper: create an exhibition post ────────────────────────────────────────
function sdws_exhibition($title, $type_slug, $start, $end, $juror = '', $entry_open = '', $entry_close = '', $jury = '', $reception = '', $notes = '', $prospectus = '') {
    $post_id = wp_insert_post([
        'post_title'  => wp_slash($title),
        'post_type'   => 'sdws_exhibition',
        'post_status' => 'publish',
    ]);

    if (is_wp_error($post_id)) {
        echo "  ERROR: $title — " . $post_id->get_error_message() . "\n";
        return;
    }

    // ACF date_picker stores in Ymd format
    sdws_set_meta($post_id, 'exhibition_show_dates_start',  $start);
    sdws_set_meta($post_id, 'exhibition_show_dates_end',    $end);
    if ($juror)       sdws_set_meta($post_id, 'exhibition_juror',             $juror);
    if ($entry_open)  sdws_set_meta($post_id, 'exhibition_online_entry_date', $entry_open);
    if ($entry_close) sdws_set_meta($post_id, 'exhibition_entry_day',         $entry_close);
    if ($jury)        sdws_set_meta($post_id, 'exhibition_jury_date',         $jury);
    if ($reception)   sdws_set_meta($post_id, 'exhibition_reception_date',    $reception);
    if ($notes)       sdws_set_meta($post_id, 'exhibition_notes',             $notes);
    if ($prospectus)  sdws_set_meta($post_id, 'exhibition_prospectus_link',   $prospectus);

    $term = get_term_by('slug', $type_slug, 'exhibition_type');
    if ($term) {
        wp_set_post_terms($post_id, [$term->term_id], 'exhibition_type');
    }

    echo "  Created exhibition (#$post_id): $title\n";
}

// ── Helper: create a workshop post ───────────────────────────────────────────
function sdws_workshop($title, $format_slug, $instructor, $start, $end = '', $price_mem = 0, $price_non = 0, $description = '', $materials = '') {
    $post_id = wp_insert_post([
        'post_title'   => wp_slash($title),
        'post_type'    => 'sdws_workshop',
        'post_status'  => 'publish',
        'post_content' => wp_slash($description),
    ]);

    if (is_wp_error($post_id)) {
        echo "  ERROR: $title — " . $post_id->get_error_message() . "\n";
        return;
    }

    sdws_set_meta($post_id, 'workshop_instructor', $instructor);
    sdws_set_meta($post_id, 'workshop_date_start', $start);
    if ($end)       sdws_set_meta($post_id, 'workshop_date_end',           $end);
    if ($price_mem) sdws_set_meta($post_id, 'workshop_price_member',       $price_mem);
    if ($price_non) sdws_set_meta($post_id, 'workshop_price_nonmember',    $price_non);
    if ($materials) sdws_set_meta($post_id, 'workshop_materials_link',     $materials);

    $term = get_term_by('slug', $format_slug, 'workshop_format');
    if ($term) {
        wp_set_post_terms($post_id, [$term->term_id], 'workshop_format');
    }

    echo "  Created workshop (#$post_id): $title\n";
}

// ════════════════════════════════════════════════════════════════════════════
// STEP 1: Delete placeholder posts
// ════════════════════════════════════════════════════════════════════════════
echo "── Deleting placeholder exhibitions and workshops ──\n";

$existing = get_posts(['post_type' => ['sdws_exhibition', 'sdws_workshop'], 'posts_per_page' => -1, 'post_status' => 'any']);
foreach ($existing as $p) {
    wp_delete_post($p->ID, true);
    echo "  Deleted: {$p->post_title}\n";
}

// ════════════════════════════════════════════════════════════════════════════
// STEP 2: Ensure taxonomy terms exist
// ════════════════════════════════════════════════════════════════════════════
echo "\n── Taxonomy terms ──\n";
sdws_ensure_term('Member Show',     'member-show',    'exhibition_type');
sdws_ensure_term('International',   'international',  'exhibition_type');
sdws_ensure_term('Plein Air',       'plein-air',      'exhibition_type');
sdws_ensure_term('In-Person',       'in-person',      'workshop_format');
sdws_ensure_term('Zoom',            'zoom',           'workshop_format');
sdws_ensure_term('Beginner Series', 'beginner-series','workshop_format');

// ════════════════════════════════════════════════════════════════════════════
// STEP 3: 2026 Exhibitions
// ════════════════════════════════════════════════════════════════════════════
echo "\n── Exhibitions ──\n";

// ── Member Shows ─────────────────────────────────────────────────────────────

sdws_exhibition(
    '2026 May "Nature\'s Echo" Member Exhibition',
    'member-show',
    '20260426', '20260530',
    'Wanda Honeycutt',
    '20260415', '20260425', '20260427', '20260501'
);

sdws_exhibition(
    '2026 June "The Will of the Brush" Member Exhibition',
    'member-show',
    '20260531', '20260627',
    'Chuck McPhearson',
    '20260520', '20260530', '20260601', '20260605'
);

sdws_exhibition(
    '2026 July "Patriotic Sagas" Member Exhibition',
    'member-show',
    '20260628', '20260801',
    'Stephanie Goldman',
    '20260617', '20260627', '20260629', '20260703'
);

sdws_exhibition(
    '2026 August "Figuratively Speaking" Member Exhibition',
    'member-show',
    '20260802', '20260912',
    'Drew Bandish',
    '20260722', '20260801', '20260803', '20260807'
);

sdws_exhibition(
    '2026 September "Urban Rhythms" Virtual Member Exhibition',
    'member-show',
    '20260830', '20260930',
    'Lisa Wang',
    '20260819', '20260829', '20260831', '20260904'
);

sdws_exhibition(
    '2026 November "Wild Wonders" Member Exhibition',
    'member-show',
    '20261101', '20261128',
    'Roberta Dyer',
    '20261021', '20261031', '20261102', '20261106'
);

sdws_exhibition(
    '2026 December "Illuminations and Reflections" Member Exhibition',
    'member-show',
    '20261129', '20261226',
    'Risa Parberry',
    '20261118', '20261128', '20261130', '20261204'
);

// ── Plein Air ─────────────────────────────────────────────────────────────────

sdws_exhibition(
    '2026 Out N About 10th Annual Plein Air Show',
    'plein-air',
    '20260701', '20260801',
    'Ken Goldman',
    '20260322', '20260425', '20260630', '20260705'
);

// ── International ─────────────────────────────────────────────────────────────

$intl_notes = '<p>Read the entire Prospectus prior to entering. The International Exhibition Standards Committee reviews all accepted paintings for compliance. Failed paintings lead to disqualification, without refund.</p>';
$intl_notes .= '<p><a href="https://drive.google.com/file/d/1b7E1MmwQfa9dy2fEcnZxhUICVe2yb-nT/view?usp=drive_link">Download the 2026 Prospectus (PDF)</a></p>';
$intl_notes .= '<p><a href="https://drive.google.com/file/d/12ZrARBIYs7S9F-aX5OxJzjDvR-rHALf0/view?usp=sharing">OJS CFE Online Entry Instructions</a></p>';

sdws_exhibition(
    '46th International Exhibition',
    'international',
    '20260927', '20261031',
    'Ana Laura Salazar',
    '20260201', '20260508', '20260608', '20261002',
    $intl_notes,
    'https://drive.google.com/file/d/1b7E1MmwQfa9dy2fEcnZxhUICVe2yb-nT/view?usp=drive_link'
);

// ════════════════════════════════════════════════════════════════════════════
// STEP 4: 2026 Workshops
// ════════════════════════════════════════════════════════════════════════════
echo "\n── Workshops ──\n";

$materials_link = 'https://drive.google.com/file/d/1VCxKV-pnIuYYil-qRs4Gj7gcQuqSpygz/view?usp=drive_link';

// ── In-Person ─────────────────────────────────────────────────────────────────

sdws_workshop(
    'Capturing the Moment in Watercolor',
    'in-person',
    'Geoff Allen',
    '20260608', '20260610',
    300, 325,
    'Keep it lively and spontaneous. Through coastal, landscape, and still-life subjects, you\'ll learn techniques for painting with energy and freshness — indoors and outdoors.'
);

sdws_workshop(
    'Figures Through the Light and Shadow',
    'in-person',
    'Eudes Correia',
    '20260621', '20260623',
    550, 575,
    'Discover how light and shadow can transform your figure paintings. Join Eudes Correia for an inspiring deep dive into expressive, luminous figures that radiate joy and life.'
);

sdws_workshop(
    'Reality and Imagination',
    'in-person',
    'Ana Laura Salazar',
    '20260810', '20260813',
    425, 450,
    'Blend reality with imagination. Learn Ana Laura Salazar\'s unique techniques for developing fantastical concepts, whimsical compositions, and magical animal-and-figure subjects.'
);

sdws_workshop(
    'Line and Watercolor',
    'in-person',
    'Lori Mitchell',
    '20260905', '20260906',
    165, 185,
    'Combine the strength of line with the beauty of watercolor. Experiment with different materials, limited palettes, and creative compositions to make your paintings pop.'
);

// ── Zoom ──────────────────────────────────────────────────────────────────────

sdws_workshop(
    'Wild Birds in the Spirit of Abstract Realism',
    'zoom',
    'Zoe Evamy',
    '20260718', '20260720',
    300, 325,
    'Bring birds to life with a twist in this acrylic workshop. Paint realistic feathered forms while exploring abstract backgrounds for contrast and impact — all from the comfort of your own studio via Zoom.'
);

sdws_workshop(
    'Florals and Fruit: From Real to Really Amazing',
    'zoom',
    'Suzanne Hetzel',
    '20261109', '20261111',
    275, 300,
    'Take your florals and still lifes from traditional to extraordinary. Each day you\'ll explore a new technique — from realistic to expressive to abstract — and leave with fresh approaches for vibrant, eye-catching paintings.'
);

// ── Beginner Series ───────────────────────────────────────────────────────────

sdws_workshop(
    'Beginner Series #6: Beginning Portraiture',
    'beginner-series',
    'Susan Hewitt',
    '20260523', '',
    0, 0, '', $materials_link
);

sdws_workshop(
    'Beginner Series #1: Beginner Basics',
    'beginner-series',
    'Jami Wright',
    '20260620', '',
    0, 0, '', $materials_link
);

sdws_workshop(
    'Beginner Series #2: Color and Value',
    'beginner-series',
    'Julie Anderson',
    '20260815', '',
    0, 0, '', $materials_link
);

sdws_workshop(
    'Beginner Series #3: Drawing for Watercolor',
    'beginner-series',
    'Julie Anderson',
    '20260912', '',
    0, 0, '', $materials_link
);

sdws_workshop(
    'Beginner Series #4: Still Life',
    'beginner-series',
    'Susan Hewitt',
    '20261107', '',
    0, 0, '', $materials_link
);

sdws_workshop(
    'Beginner Series #5: Landscapes',
    'beginner-series',
    'Jami Wright',
    '20261121', '',
    0, 0, '', $materials_link
);

sdws_workshop(
    'Beginner Series #6: Beginning Portraiture',
    'beginner-series',
    'Susan Hewitt',
    '20261212', '',
    0, 0, '', $materials_link
);

// ════════════════════════════════════════════════════════════════════════════
// STEP 5: ACF Options — International Exhibition page
// ════════════════════════════════════════════════════════════════════════════
echo "\n── International page options ──\n";

if ($has_acf) {
    update_field('intl_headline',     '46th International Exhibition',          'option');
    update_field('intl_eyebrow',      'San Diego Watercolor Society',           'option');
    update_field('intl_dates_text',   'September 27 – October 31, 2026',        'option');
    update_field('intl_awards_text',  'Awards: $30,000+',                       'option');
    update_field('intl_prospectus_url',
        'https://drive.google.com/file/d/1b7E1MmwQfa9dy2fEcnZxhUICVe2yb-nT/view?usp=drive_link',
        'option'
    );

    $about = '<p>Thank you for considering entering the San Diego Watercolor Society\'s 46th International Exhibition.</p>'
           . '<p>SDWS was established in 1965 and is one of the largest and most active watercolor societies in the United States. The International Exhibition is widely recognized for its high standard of excellence in water media art.</p>'
           . '<p>For over four decades, the International Exhibition has been an annual highlight for SDWS. The event attracts entries from hundreds of water media artists worldwide and features over $30,000 in cash and awards.</p>'
           . '<p>The International Show is the best-selling show of the year. The exhibition is free and open to the public at the SDWS Gallery in Balboa Park, San Diego, California.</p>';
    update_field('intl_about_content', $about, 'option');

    $juror_bio = '<p>Master Artist, Ana Laura Salazar comes from a family of artists, inheriting her talent from her mother, Martha Orozco. Her artistic training, complemented by various workshops, prepared her to excel in the field of painting, particularly in the watercolor technique. She has been a member of the Mexican Society of Watercolorists since 1987.</p>'
               . '<p>Throughout her career she has showcased her work in numerous solo and group exhibitions in Mexico, Bulgaria, India, China, and the US. Her paintings have earned national and international awards — including the Premio Tlacuilo multiple times at the National Watercolor Salon and the Premio Tláloc, awarded by the Watercolor Museum of the State of Mexico.</p>'
               . '<p>Internationally, she has served as a juror of the III International Youth Watercolor Festival in Plovdiv, Bulgaria (2025), as a judge for the 2nd Kipus Bolivia Exhibition (2024), and attended the 1st Qingdao International Watercolor Festival in China (2023). She won first place in the SDWS International Exhibition for two consecutive years, 2018 and 2019.</p>'
               . '<p>Ana Laura is currently fully dedicated to the visual arts, teaching painting techniques in her private studio. She is thrilled to serve as the 2026 SDWS 46th International Exhibition Juror.</p>';

    update_field('intl_juror_name', 'Ana Laura Salazar',              'option');
    update_field('intl_juror_role', 'Juror, 46th International Exhibition', 'option');
    update_field('intl_juror_bio',  $juror_bio,                       'option');

    // Key dates repeater
    update_field('intl_key_dates', [
        ['label' => 'Online Entry Opens',        'date_value' => 'February 1, 2026'],
        ['label' => 'Entry Deadline',             'date_value' => 'May 8, 2026 — 11:59 PM Pacific'],
        ['label' => 'Acceptance Notifications',   'date_value' => 'June 8, 2026'],
        ['label' => 'Framing Deadline (Shipped)', 'date_value' => 'July 13, 2026'],
        ['label' => 'Hand-Delivered Paintings',   'date_value' => 'August 1–2, 2026'],
        ['label' => 'Artist Gala & Awards',       'date_value' => 'September 26, 2026 (Invite Only)'],
        ['label' => 'Exhibition Opens',           'date_value' => 'September 27, 2026'],
        ['label' => 'Opening Reception',          'date_value' => 'October 2, 2026'],
        ['label' => 'Exhibition Closes',          'date_value' => 'October 31, 2026'],
    ], 'option');

    // Resources repeater
    update_field('intl_resources', [
        [
            'label' => '2026 Prospectus (PDF)',
            'url'   => 'https://drive.google.com/file/d/1b7E1MmwQfa9dy2fEcnZxhUICVe2yb-nT/view?usp=drive_link',
        ],
        [
            'label' => 'OJS CFE Online Entry Instructions',
            'url'   => 'https://drive.google.com/file/d/12ZrARBIYs7S9F-aX5OxJzjDvR-rHALf0/view?usp=sharing',
        ],
    ], 'option');

    echo "  International page options set.\n";
} else {
    // Fallback: write directly to wp_options (without ACF field key references)
    update_option('options_intl_headline',    '46th International Exhibition');
    update_option('options_intl_dates_text',  'September 27 – October 31, 2026');
    update_option('options_intl_awards_text', 'Awards: $30,000+');
    update_option('options_intl_juror_name',  'Ana Laura Salazar');
    update_option('options_intl_juror_role',  'Juror, 46th International Exhibition');
    echo "  International page options set (no ACF — basic fallback).\n";
}

// ════════════════════════════════════════════════════════════════════════════
// STEP 6: ACF Options — Homepage
// ════════════════════════════════════════════════════════════════════════════
echo "\n── Homepage options ──\n";

if ($has_acf) {
    update_field('home_hero_eyebrow',     'San Diego Watercolor Society — Est. 1965', 'option');
    update_field('home_hero_headline',    'Watercolor art, community, and excellence in San Diego.', 'option');
    update_field('home_hero_subheadline', 'The San Diego Watercolor Society has championed watercolor painting for over 40 years — offering gallery exhibitions, workshops, and a vibrant community for artists at every level.', 'option');
    update_field('home_hero_cta1_text',   'View Exhibitions',    'option');
    update_field('home_hero_cta1_url',    '/schedule/',          'option');
    update_field('home_hero_cta2_text',   'Learn About the I-Show', 'option');
    update_field('home_hero_cta2_url',    '/international/',     'option');
    update_field('home_gallery_label',    'June Member Show',    'option');
    update_field('home_gallery_caption',  '90+ works on display','option');
    update_field('home_ishow_visible',    1,                     'option');
    update_field('home_ishow_eyebrow',    'Now Accepting Entries', 'option');
    update_field('home_ishow_headline',   '46th International Exhibition', 'option');
    update_field('home_ishow_dates',      'September 27 – October 31, 2026', 'option');
    update_field('home_ishow_meta',       'Awards: $30,000+ &nbsp;|&nbsp; Juror: Ana Laura Salazar', 'option');
    update_field('home_ishow_body',       'Open to watercolor artists worldwide. Submit via online entry.', 'option');
    update_field('home_ishow_cta_text',   'View Exhibition Details', 'option');
    update_field('home_ishow_cta_url',    '/international/',     'option');
    echo "  Homepage options set.\n";
}

// ════════════════════════════════════════════════════════════════════════════
// STEP 7: ACF Options — Workshops page
// ════════════════════════════════════════════════════════════════════════════
echo "\n── Workshops page options ──\n";

if ($has_acf) {
    update_field('workshops_intro',
        'SDWS workshops are led by nationally recognized instructors and open to all skill levels. Members receive discounted rates on all sessions. Workshops are held in our beautifully light-filled education center at the SDWS Gallery in Liberty Station, or live via Zoom from the comfort of your home studio.',
        'option'
    );
    update_field('workshops_email_registrar', 'registrar@sdws.org',  'option');
    update_field('workshops_email_director',  'workshops@sdws.org',  'option');
    echo "  Workshops page options set.\n";
}

// ════════════════════════════════════════════════════════════════════════════
// STEP 8: ACF Options — Donate page
// ════════════════════════════════════════════════════════════════════════════
echo "\n── Donate page options ──\n";

if ($has_acf) {
    update_field('donate_headline', 'Support SDWS', 'option');
    update_field('donate_intro',    'Your gift sustains a vibrant watercolor arts community in San Diego. Every contribution directly supports:', 'option');
    update_field('donate_bullets', [
        ['bullet_text' => 'The <strong>SDWS Gallery</strong> in Balboa Park — free and open to the public year-round, showcasing member and international exhibitions.'],
        ['bullet_text' => '<strong>Classes, workshops, and mentorships</strong> — from beginner Zoom sessions to master workshops with nationally recognized instructors.'],
        ['bullet_text' => '<strong>Plein air painting events</strong> and community programs that bring watercolor into public spaces across San Diego.'],
    ], 'option');
    update_field('donate_paypal_url', 'https://www.paypal.com/ncp/payment/KSDUHVURSRZSJ', 'option');
    update_field('donate_tax_note',   "SDWS is a 501(c)(3) nonprofit. Tax ID: 95-3153264.\nAll donations are tax-deductible to the extent allowed by law.", 'option');
    echo "  Donate page options set.\n";
}

// ════════════════════════════════════════════════════════════════════════════
// Done
// ════════════════════════════════════════════════════════════════════════════
echo "\n=== Import complete ===\n";
echo "Next: flush rewrite rules from WP Admin > Settings > Permalinks\n\n";
