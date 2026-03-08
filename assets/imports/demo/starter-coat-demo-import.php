<?php

/**
 * Starter Coat demo content importer/seeder.
 *
 * Run with WP-CLI:
 * wp eval-file wp-content/themes/starter-coat/assets/imports/demo/starter-coat-demo-import.php
 */

if (! defined('ABSPATH')) {
  echo "Run this via WP-CLI eval-file from a WordPress install.\n";
  return;
}

function starter_coat_demo_upsert_term($taxonomy, $name, $slug)
{
  $existing = get_term_by('slug', $slug, $taxonomy);
  if ($existing && ! is_wp_error($existing)) {
    return (int) $existing->term_id;
  }

  $created = wp_insert_term(
    $name,
    $taxonomy,
    array(
      'slug' => $slug,
    )
  );

  if (is_wp_error($created) || empty($created['term_id'])) {
    return 0;
  }

  return (int) $created['term_id'];
}

function starter_coat_demo_upsert_post($post_type, $slug, $data)
{
  $existing = get_page_by_path($slug, OBJECT, $post_type);

  $payload = array(
    'post_type'    => $post_type,
    'post_name'    => $slug,
    'post_title'   => isset($data['post_title']) ? $data['post_title'] : ucwords(str_replace('-', ' ', $slug)),
    'post_status'  => isset($data['post_status']) ? $data['post_status'] : 'publish',
    'post_content' => isset($data['post_content']) ? $data['post_content'] : '',
    'post_excerpt' => isset($data['post_excerpt']) ? $data['post_excerpt'] : '',
  );

  if ($existing instanceof WP_Post) {
    $payload['ID'] = (int) $existing->ID;
    $post_id = wp_update_post($payload, true);
  } else {
    $post_id = wp_insert_post($payload, true);
  }

  if (is_wp_error($post_id) || ! $post_id) {
    return 0;
  }

  if (! empty($data['parent_id']) && 'page' === $post_type) {
    wp_update_post(
      array(
        'ID'          => (int) $post_id,
        'post_parent' => (int) $data['parent_id'],
      )
    );
  }

  if (! empty($data['template']) && 'page' === $post_type) {
    update_post_meta((int) $post_id, '_wp_page_template', (string) $data['template']);
  }

  if (! empty($data['meta']) && is_array($data['meta'])) {
    foreach ($data['meta'] as $meta_key => $meta_value) {
      update_post_meta((int) $post_id, (string) $meta_key, $meta_value);
    }
  }

  if (! empty($data['terms']) && is_array($data['terms'])) {
    foreach ($data['terms'] as $taxonomy => $term_slugs) {
      if (! is_array($term_slugs)) {
        continue;
      }
      wp_set_object_terms((int) $post_id, array_values($term_slugs), (string) $taxonomy, false);
    }
  }

  return (int) $post_id;
}

function starter_coat_demo_set_sections($post_id, $rows)
{
  if (! function_exists('update_field')) {
    return;
  }

  update_field('sc_sections', $rows, $post_id);
}

$term_map = array(
  'project_category' => array(
    array('name' => 'CMS Migration', 'slug' => 'cms-migration'),
    array('name' => 'Platform Build', 'slug' => 'platform-build'),
    array('name' => 'Marketing Technology', 'slug' => 'marketing-technology'),
  ),
  'event_type' => array(
    array('name' => 'Workshop', 'slug' => 'workshop'),
    array('name' => 'Community Event', 'slug' => 'community-event'),
    array('name' => 'Webinar', 'slug' => 'webinar'),
  ),
  'faq_topic' => array(
    array('name' => 'Programs', 'slug' => 'programs'),
    array('name' => 'Booking', 'slug' => 'booking'),
    array('name' => 'Support', 'slug' => 'support'),
  ),
  'press_category' => array(
    array('name' => 'Release', 'slug' => 'release'),
    array('name' => 'Feature', 'slug' => 'feature'),
    array('name' => 'Announcement', 'slug' => 'announcement'),
  ),
);

foreach ($term_map as $taxonomy => $terms) {
  if (! taxonomy_exists($taxonomy)) {
    continue;
  }

  foreach ($terms as $term_row) {
    starter_coat_demo_upsert_term($taxonomy, $term_row['name'], $term_row['slug']);
  }
}

$pages = array();
$pages['home_hype'] = starter_coat_demo_upsert_post(
  'page',
  'home-hype-demo',
  array(
    'post_title'   => 'Home - Hype Demo',
    'template'     => 'templates/template-homepage.php',
    'post_excerpt' => 'Homepage test bed using Hype Relations copy and section variations.',
    'post_content' => 'Imported demo homepage content. Flexible sections are seeded via ACF.',
  )
);

$pages['home_bav'] = starter_coat_demo_upsert_post(
  'page',
  'home-bav-demo',
  array(
    'post_title'   => 'Home - BAV Demo',
    'template'     => 'templates/template-homepage.php',
    'post_excerpt' => 'Homepage test bed using Black Arts Vancouver copy and alternate section styles.',
    'post_content' => 'Imported demo homepage content. Flexible sections are seeded via ACF.',
  )
);

$pages['about_hype'] = starter_coat_demo_upsert_post(
  'page',
  'about-hype-demo',
  array(
    'post_title'   => 'About - Hype Demo',
    'template'     => 'templates/template-generic-container.php',
    'post_excerpt' => 'Long-form About page variant for Hype Relations.',
    'post_content' => '<h2>Building Bridges Between Creativity and Opportunity</h2><p>Hype Relations is more than a creative collective. We are an Indigenous-led community where artists at different growth stages build sustainable, meaningful careers. Founded by Marlayna Pincott, the collective combines mentorship, practical opportunities, and cultural values to support artists holistically.</p><p>What started as support for emerging creatives has evolved into a full ecosystem: artist development, booking support, collaborations, and community storytelling. We are not here to take ownership of an artist\'s growth. We are here to equip artists with tools, confidence, and relationships that help them thrive.</p><h3>Core Principles</h3><ul><li>Community over competition</li><li>Traditional wisdom with modern execution</li><li>Whole-human support, not just portfolio output</li><li>Real pathways to sustainable creative careers</li></ul><p>Questions about programs or partnerships? Reach out through the contact page to connect with the team.</p>',
  )
);

$pages['about_bav'] = starter_coat_demo_upsert_post(
  'page',
  'about-bav-demo',
  array(
    'post_title'   => 'About - BAV Demo',
    'template'     => 'templates/template-generic-container.php',
    'post_excerpt' => 'Mission-focused About page variant for Black Arts Vancouver.',
    'post_content' => '<h2>Furthering the Arts Expression of Pan-African Youth in Vancouver</h2><p>Black Arts Vancouver is a registered non-profit society creating free, community-led arts programming for Pan-African youth and families. Since 2018, BAV has centered Black artistic expression, oral history, and intergenerational learning through workshops, exhibitions, and mentorship.</p><p>The organization is rooted in care, access, and long-term impact. Programs are offered at no cost, with intentional pathways from early arts exposure to leadership opportunities for emerging artists and facilitators.</p><h3>What This Work Makes Possible</h3><ul><li>No-cost workshops and hands-on programs for youth and families</li><li>Artist facilitation rooted in lived experience</li><li>Community storytelling that preserves and uplifts Black histories in BC</li><li>Sustainable opportunities for Black artists and cultural workers</li></ul><p>BAV continues to grow with partnerships, new spaces, and year-round programming designed by and for community.</p>',
  )
);

$pages['projects_archive'] = starter_coat_demo_upsert_post(
  'page',
  'projects-demo',
  array(
    'post_title' => 'Projects Demo Archive',
    'template'   => 'templates/template-archive.php',
    'meta'       => array(
      'sc_archive_post_type'      => 'project',
      'sc_archive_taxonomy'       => 'project_category',
      'sc_archive_items_per_page' => 12,
    ),
    'post_content' => 'Auto archive page for project CPT testing.',
  )
);

$pages['blog_archive'] = starter_coat_demo_upsert_post(
  'page',
  'updates-demo',
  array(
    'post_title' => 'Updates Demo Archive',
    'template'   => 'templates/template-archive.php',
    'meta'       => array(
      'sc_archive_post_type'      => 'post',
      'sc_archive_taxonomy'       => 'category',
      'sc_archive_items_per_page' => 9,
    ),
    'post_content' => 'Auto archive page for blog/testing content.',
  )
);

$pages['contact'] = starter_coat_demo_upsert_post(
  'page',
  'contact-demo',
  array(
    'post_title' => 'Contact Demo',
    'template'   => 'templates/template-contact.php',
    'meta'       => array(
      'sc_contact_intro'          => '<p>Use this contact page to validate global contact details, form rendering, and map embed behavior.</p>',
      'sc_contact_form_shortcode' => '[wpforms id="2"]',
      'sc_contact_map_embed'      => '<iframe title="Map Placeholder" src="https://www.openstreetmap.org/export/embed.html" width="600" height="320"></iframe>',
    ),
    'post_content' => 'Contact demo page.',
  )
);

$pages['booking'] = starter_coat_demo_upsert_post(
  'page',
  'booking-demo',
  array(
    'post_title' => 'Booking Demo',
    'template'   => 'templates/template-generic-full-width.php',
    'post_content' => '<h2>Booking Overview</h2><p>Use this page to test long-form booking copy, form sections, and section-level CTA placement.</p>',
  )
);

$pages['privacy'] = starter_coat_demo_upsert_post(
  'page',
  'privacy-demo',
  array(
    'post_title' => 'Privacy Demo',
    'post_content' => '<h2>Privacy Policy</h2><p>This is placeholder privacy content for testing legal-page layouts, typography, and long-form readability.</p>',
  )
);

$projects = array(
  array(
    'slug'   => 'aera-migration-demo',
    'title'  => 'Aera Technology Website Migration',
    'excerpt' => 'Enterprise migration from Contentful to WordPress with SEO continuity and performance gains.',
    'terms'  => array('project_category' => array('cms-migration', 'platform-build')),
    'content' => '<h2>Overview</h2><p>Led an enterprise migration from Contentful to WordPress, including 644 content items, 1,371 media assets, and 600+ redirects. Built a custom theme architecture and editor workflows for a large marketing team.</p><h3>Outcomes</h3><ul><li>PageSpeed 90+ across key templates</li><li>Zero 404s for mapped URLs</li><li>Faster publishing and reduced developer dependency</li></ul><p>This project is ideal for testing long-form project pages, archive cards, and taxonomy filtering.</p>',
  ),
  array(
    'slug'   => 'nulogy-platform-demo',
    'title'  => 'Nulogy Marketing Platform Build',
    'excerpt' => 'Custom Gutenberg and integration-oriented architecture for scalable campaign publishing.',
    'terms'  => array('project_category' => array('platform-build', 'marketing-technology')),
    'content' => '<h2>Overview</h2><p>Implemented a flexible publishing model using reusable blocks and pattern-driven page composition. Focused on editor speed, consistency, and campaign iteration.</p><h3>Highlights</h3><ul><li>Reusable conversion-focused sections</li><li>HubSpot and analytics integration support</li><li>Clean handoff documentation for marketing teams</li></ul>',
  ),
  array(
    'slug'   => 'intelity-conversion-demo',
    'title'  => 'Intelity Conversion and UX Optimization',
    'excerpt' => 'Template-level optimization for conversion flow, content architecture, and visual consistency.',
    'terms'  => array('project_category' => array('marketing-technology')),
    'content' => '<h2>Overview</h2><p>Refined information hierarchy and conversion pathways across hospitality-focused product pages. Introduced clearer CTAs and modular content sections to support rapid updates.</p><h3>What To Test</h3><ul><li>Before/after style narrative sections</li><li>Feature callout layouts</li><li>CTA performance placement in long pages</li></ul>',
  ),
  array(
    'slug'   => 'black-arts-directory-demo',
    'title'  => 'Black Arts Vancouver Directory Experience',
    'excerpt' => 'Community-first artist discovery flow with profile pathways and mission-driven donation prompts.',
    'terms'  => array('project_category' => array('platform-build')),
    'content' => '<h2>Overview</h2><p>Designed a directory and storytelling structure that balances artist visibility, community context, and support pathways. Content strategy emphasized accessibility and emotional clarity.</p><h3>Testing Focus</h3><ul><li>Directory and profile navigation</li><li>Program/event cross-linking</li><li>Donation and volunteer CTA combinations</li></ul>',
  ),
);

foreach ($projects as $project) {
  starter_coat_demo_upsert_post(
    'project',
    $project['slug'],
    array(
      'post_title'   => $project['title'],
      'post_excerpt' => $project['excerpt'],
      'post_content' => $project['content'],
      'terms'        => $project['terms'],
    )
  );
}

$events = array(
  array(
    'slug' => 'hype-artist-mixer-demo',
    'title' => 'Hype Artist Mixer',
    'terms' => array('event_type' => array('community-event')),
    'content' => '<p>An evening of networking, mini portfolio reviews, and collaboration matching for Indigenous creatives and partner brands.</p>',
  ),
  array(
    'slug' => 'bav-portrait-workshop-demo',
    'title' => 'Historical Black Portraiture Workshop',
    'terms' => array('event_type' => array('workshop')),
    'content' => '<p>A youth-centered workshop exploring portraiture, storytelling, and Black histories in BC through accessible art-making techniques.</p>',
  ),
  array(
    'slug' => 'cms-migration-webinar-demo',
    'title' => 'CMS Migration Lessons Webinar',
    'terms' => array('event_type' => array('webinar')),
    'content' => '<p>A practical walkthrough of migration planning, redirect mapping, and editorial onboarding for modern marketing sites.</p>',
  ),
  array(
    'slug' => 'community-showcase-night-demo',
    'title' => 'Community Showcase Night',
    'terms' => array('event_type' => array('community-event')),
    'content' => '<p>A live showcase of artists, facilitators, and youth project outcomes with a focus on cultural storytelling and celebration.</p>',
  ),
);

foreach ($events as $event) {
  starter_coat_demo_upsert_post(
    'event',
    $event['slug'],
    array(
      'post_title'   => $event['title'],
      'post_content' => $event['content'],
      'terms'        => $event['terms'],
    )
  );
}

$faqs = array(
  array('slug' => 'how-to-book-an-artist-demo', 'title' => 'How do I book an artist?', 'topic' => 'booking', 'content' => '<p>Submit a booking request with project details, budget range, and timeline. The team will match you with suitable creatives within 2-3 business days.</p>'),
  array('slug' => 'what-growth-stages-mean-demo', 'title' => 'What do Seedling and Blossoming stages mean?', 'topic' => 'programs', 'content' => '<p>These stages represent development pathways in the incubator model, from emerging creatives through experienced mentors.</p>'),
  array('slug' => 'are-workshops-free-demo', 'title' => 'Are workshops free?', 'topic' => 'programs', 'content' => '<p>Many youth and community workshops are no-cost. Some advanced sessions may have limited registration fees depending on delivery format.</p>'),
  array('slug' => 'form-not-submitting-demo', 'title' => 'My form is not submitting, what should I check?', 'topic' => 'support', 'content' => '<p>Confirm required fields, anti-spam settings, and shortcode IDs. Then test with browser extensions disabled to rule out script blockers.</p>'),
  array('slug' => 'can-i-volunteer-demo', 'title' => 'Can I volunteer or partner?', 'topic' => 'programs', 'content' => '<p>Yes. Use the contact page and include your skills, availability, and interest area (events, mentoring, logistics, or fundraising support).</p>'),
  array('slug' => 'how-fast-do-you-respond-demo', 'title' => 'How quickly do you respond to inquiries?', 'topic' => 'support', 'content' => '<p>Most requests receive a response within 2-3 business days. Urgent production requests should include event date in the subject line.</p>'),
);

foreach ($faqs as $faq) {
  starter_coat_demo_upsert_post(
    'faq',
    $faq['slug'],
    array(
      'post_title'   => $faq['title'],
      'post_content' => $faq['content'],
      'terms'        => array('faq_topic' => array($faq['topic'])),
    )
  );
}

$press_items = array(
  array('slug' => 'hype-program-expansion-demo', 'title' => 'Hype Relations Expands Incubator Cohorts', 'excerpt' => 'New mentorship cohorts and partner pathways launched for 2026.', 'term' => 'announcement'),
  array('slug' => 'bav-downtown-program-space-demo', 'title' => 'Black Arts Vancouver Announces New Program Space', 'excerpt' => 'Expanded programming footprint to support youth workshops and exhibitions.', 'term' => 'release'),
  array('slug' => 'aera-migration-feature-demo', 'title' => 'Aera Migration Featured in Portfolio Spotlight', 'excerpt' => 'Enterprise CMS modernization case study highlights process and results.', 'term' => 'feature'),
);

foreach ($press_items as $press) {
  starter_coat_demo_upsert_post(
    'press',
    $press['slug'],
    array(
      'post_title'   => $press['title'],
      'post_excerpt' => $press['excerpt'],
      'terms'        => array('press_category' => array($press['term'])),
    )
  );
}

$posts = array(
  array('slug' => 'welcome-to-our-new-look-demo', 'title' => 'Welcome to Our New Look', 'content' => '<p>We refreshed the site to make discovery easier and workflows smoother for artists, partners, and community members. This update focuses on clarity, accessibility, and editorial speed.</p>'),
  array('slug' => 'our-journey-since-2018-demo', 'title' => 'Our Journey Since 2018', 'content' => '<p>From an initial group of families to province-wide programming, the community has grown through collaboration, practical support, and youth-led creativity.</p>'),
  array('slug' => 'inside-a-cms-migration-demo', 'title' => 'Inside a CMS Migration: What Actually Matters', 'content' => '<p>Migrations are not just about moving content. They are about preserving SEO, empowering editors, and building systems teams can maintain.</p>'),
  array('slug' => 'artist-spotlight-jay-lee-demo', 'title' => 'Artist Spotlight: Jay-Lee', 'content' => '<p>A look at bold makeup artistry, mentorship pathways, and the role of confidence-building in creative practice.</p>'),
  array('slug' => 'programming-at-the-duncan-building-demo', 'title' => 'Programming at the Duncan Building', 'content' => '<p>Our new downtown footprint gives us more room for workshops, teaching labs, and intergenerational arts programming.</p>'),
);

foreach ($posts as $post_row) {
  starter_coat_demo_upsert_post(
    'post',
    $post_row['slug'],
    array(
      'post_title'   => $post_row['title'],
      'post_content' => $post_row['content'],
    )
  );
}

if (! empty($pages['home_hype']) && ! empty($pages['blog_archive'])) {
  update_option('show_on_front', 'page');
  update_option('page_on_front', (int) $pages['home_hype']);
  update_option('page_for_posts', (int) $pages['blog_archive']);
}

if (function_exists('update_field')) {
  $sections_home_hype = array(
    array(
      'acf_fc_layout'       => 'feature',
      'kicker'              => 'HOME HERO',
      'title'               => 'Nurturing Indigenous Creativity. Building Dreams. Creating Community.',
      'copy'                => 'Welcome to Hype Relations, an Indigenous-led creative collective connecting artists, organizations, and opportunities through mentorship and collaboration.',
      'ratio'               => '66-33',
      'media_position'      => 'right',
      'button'              => array('title' => 'Explore Our Artists', 'url' => '/artists/', 'target' => ''),
      'section_width'       => 'full',
      'section_padding'     => 'xl',
      'section_background'  => 'dark',
      'image_full_bleed'    => true,
      'section_class'       => 'demo-feature-hero',
    ),
    array(
      'acf_fc_layout'      => 'cards',
      'heading'            => 'Creative Services Rooted in Community',
      'intro'              => 'Our collective spans artistry, storytelling, and production support for campaigns, events, and editorial work.',
      'columns'            => '3',
      'items'              => array(
        array('pill' => 'Service', 'title' => 'Hair and Makeup Artistry', 'copy' => 'Editorial, bridal, cultural styling, and on-set support.', 'button' => array('title' => 'View Artists', 'url' => '/artists/', 'target' => '')),
        array('pill' => 'Service', 'title' => 'Photography and Videography', 'copy' => 'Portraits, events, commercial storytelling, and social content.', 'button' => array('title' => 'Book Creative', 'url' => '/booking-demo/', 'target' => '')),
        array('pill' => 'Service', 'title' => 'Design and Digital Content', 'copy' => 'Brand design, campaign graphics, and ongoing content support.', 'button' => array('title' => 'Start Project', 'url' => '/contact-demo/', 'target' => '')),
      ),
      'section_padding'    => 'large',
      'section_background' => 'light',
    ),
    array(
      'acf_fc_layout'      => 'bold_list',
      'heading'            => 'The Hype Relations Growth Path',
      'intro'              => 'A four-stage incubator model inspired by Medicine Wheel teachings and real-world creative development.',
      'style_variant'      => 'brand-glow',
      'items'              => array(
        array('eyebrow' => 'Stage 1', 'title' => 'Seedling', 'item_mode' => 'expand', 'content' => 'For students and emerging creatives building foundational skills.'),
        array('eyebrow' => 'Stage 2', 'title' => 'Sapling', 'item_mode' => 'expand', 'content' => 'For developing artists building visibility, confidence, and networks.'),
        array('eyebrow' => 'Stage 3', 'title' => 'Rooting', 'item_mode' => 'expand', 'content' => 'For creatives establishing sustainable practice and client relationships.'),
        array('eyebrow' => 'Stage 4', 'title' => 'Blossoming', 'item_mode' => 'link', 'content' => '', 'link' => array('title' => 'Meet Blossoming Artists', 'url' => '/artists/', 'target' => '')),
      ),
      'section_background' => 'brand',
      'section_padding'    => 'large',
    ),
    array(
      'acf_fc_layout'      => 'testimonials',
      'heading'            => 'What Partners Are Saying',
      'subtext'            => 'A mix of campaign and community outcomes from organizations we collaborate with.',
      'style'              => 'feature',
      'display_mode'       => 'grid',
      'columns'            => '3',
      'items'              => array(
        array('quote' => 'The team brought authenticity and production quality from brief to final delivery.', 'name' => 'Campaign Director', 'info_line_one' => 'National Consumer Brand', 'info_line_two' => 'Partnership 2025'),
        array('quote' => 'Their mentorship model is practical, grounded, and genuinely community-first.', 'name' => 'Program Manager', 'info_line_one' => 'Community Organization', 'info_line_two' => 'Youth Arts Initiative'),
        array('quote' => 'We found exactly the right creative talent and the process was smooth end-to-end.', 'name' => 'Marketing Lead', 'info_line_one' => 'Hospitality Group', 'info_line_two' => 'Regional Campaign'),
      ),
      'section_background' => 'none',
      'section_padding'    => 'large',
    ),
    array(
      'acf_fc_layout'      => 'carousel',
      'heading'            => 'Featured Voices',
      'subtext'            => 'A carousel variant for validating controls, dots, and slide behavior.',
      'slides_per_view'    => '1',
      'show_controls'      => 1,
      'items'              => array(
        array('card_type' => 'testimonial', 'testimonial_style' => 'simple', 'quote' => 'Working with Hype felt collaborative and values-aligned from day one.', 'name' => 'Brand Partner', 'info_line_one' => 'Creative Lead', 'info_line_two' => 'Vancouver'),
        array('card_type' => 'content', 'eyebrow' => 'Community', 'title' => 'Join the Creative Circle', 'copy' => 'Sign up for updates, artist spotlights, and workshop announcements.', 'button' => array('title' => 'Subscribe', 'url' => '/updates-demo/', 'target' => '')),
        array('card_type' => 'testimonial', 'testimonial_style' => 'feature', 'quote' => 'The quality of craft and communication exceeded expectations.', 'name' => 'Production Manager', 'info_line_one' => 'Agency Partner', 'info_line_two' => 'Campaign Delivery'),
      ),
      'section_background' => 'light',
      'section_padding'    => 'normal',
    ),
    array(
      'acf_fc_layout'      => 'marquee',
      'heading'            => 'Specialties',
      'speed'              => 'normal',
      'direction'          => 'rtl',
      'items'              => array(
        array('text' => 'Hair and Makeup'),
        array('text' => 'Photography'),
        array('text' => 'Graphic Design'),
        array('text' => 'Fashion and Styling'),
        array('text' => 'Music and Sound'),
        array('text' => 'Digital Content'),
      ),
      'section_background' => 'muted',
      'section_padding'    => 'small',
    ),
    array(
      'acf_fc_layout'      => 'breakout_text',
      'content'            => '<p>Looking for authentic creativity that goes deeper than aesthetics? Let\'s build something meaningful together.</p>',
      'text_align'         => 'center',
      'text_size'          => 'lg',
      'button_label'       => 'Open Booking Modal',
      'button_link'        => array('title' => 'Booking Page', 'url' => '/booking-demo/', 'target' => ''),
      'modal_target_id'    => 'hype-program-modal',
      'section_background' => 'brand',
      'section_padding'    => 'large',
    ),
    array(
      'acf_fc_layout'      => 'hidden_modal',
      'modal_id'           => 'hype-program-modal',
      'content_type'       => 'html',
      'html_content'       => '<h3>Booking Intake</h3><p>Share your timeline, deliverables, and budget range. We will connect you with matching artists in 2-3 business days.</p><p><a class="btn btn--primary btn--sm" href="/contact-demo/">Open Contact Form</a></p>',
      'render_trigger'     => 0,
      'section_padding'    => 'small',
      'section_background' => 'none',
    ),
    array(
      'acf_fc_layout'         => 'forms_two_col',
      'heading'               => 'Request or Subscribe',
      'subtext'               => 'Use this section to test shortcode rendering and side-by-side form composition.',
      'left_intro'            => 'Booking Request',
      'left_form_shortcode'   => '[wpforms id="3"]',
      'right_intro'           => 'Newsletter Signup',
      'right_form_shortcode'  => '[wpforms id="1"]',
      'section_background'    => 'light',
      'section_padding'       => 'large',
    ),
    array(
      'acf_fc_layout'      => 'video_embed',
      'heading'            => 'Watch: Remember Her',
      'intro'              => 'Video embed section with modal behavior enabled for testing.',
      'video_url'          => 'https://www.youtube.com/watch?v=hqY5Kqn3M6M',
      'open_in_modal'      => 1,
      'modal_id'           => 'hype-reel-modal',
      'button_label'       => 'Play Video',
      'section_background' => 'dark',
      'section_padding'    => 'large',
    ),
    array(
      'acf_fc_layout'      => 'logos',
      'heading'            => 'Trusted by Partners',
      'subtext'            => 'Use placeholder marks until final brand assets are uploaded.',
      'columns'            => 4,
      'logos'              => array(
        array('image' => array('url' => 'https://via.placeholder.com/220x80?text=Partner+One', 'alt' => 'Partner One')),
        array('image' => array('url' => 'https://via.placeholder.com/220x80?text=Partner+Two', 'alt' => 'Partner Two')),
        array('image' => array('url' => 'https://via.placeholder.com/220x80?text=Partner+Three', 'alt' => 'Partner Three')),
        array('image' => array('url' => 'https://via.placeholder.com/220x80?text=Partner+Four', 'alt' => 'Partner Four')),
      ),
      'section_background' => 'none',
      'section_padding'    => 'normal',
    ),
    array(
      'acf_fc_layout'      => 'html',
      'html_content'       => '<div class="container"><p class="eyebrow">FOLLOW THE JOURNEY</p><h2>@hyperelations</h2><p>Instagram feed placeholder for testing embed wrappers and spacing.</p></div>',
      'section_background' => 'muted',
      'section_padding'    => 'large',
    ),
  );

  $sections_home_bav = array(
    array(
      'acf_fc_layout'      => 'content_media',
      'layout_mode'        => 'split',
      'kicker'             => 'WELCOME',
      'title'              => 'Furthering the Arts Expression of Pan-African Youth in Vancouver',
      'content'            => '<p>Since 2018, Black Arts Vancouver has created free, community-led spaces for Black artistic expression, youth empowerment, and cultural learning.</p><p>Programming is designed for long-term growth and meaningful participation.</p>',
      'ratio'              => '66-33',
      'media_position'     => 'right',
      'cta_buttons'        => array(
        array('button_link' => array('title' => 'Explore Upcoming Workshops', 'url' => '/events/', 'target' => ''), 'button_style' => 'primary'),
        array('button_link' => array('title' => 'Donate Today', 'url' => '/contact-demo/', 'target' => ''), 'button_style' => 'ghost'),
      ),
      'section_width'      => 'container',
      'section_background' => 'none',
      'section_padding'    => 'xl',
    ),
    array(
      'acf_fc_layout'      => 'card_collection',
      'pre_kicker'         => 'PROGRAMS',
      'pre_title'          => 'Community Programming Pillars',
      'pre_copy'           => 'A flexible card collection validating icon, list, and link-based card behaviors.',
      'columns'            => '3',
      'card_style'         => 'surface',
      'equal_height'       => 1,
      'items'              => array(
        array('title' => 'Digital Fluency', 'copy' => 'Education programs for practical digital confidence.', 'media_type' => 'none', 'card_url' => '/about-bav-demo/'),
        array('title' => 'Community Engagement', 'copy' => 'Intergenerational events and cultural storytelling.', 'media_type' => 'none', 'card_url' => '/events/'),
        array('title' => 'Technology Programs', 'copy' => 'Hands-on skill-building workshops for youth.', 'media_type' => 'none', 'card_url' => '/events/'),
      ),
      'post_copy'          => 'Each program stream supports creative expression, practical skills, and long-term community impact.',
      'quote'              => 'Creative access should be a right, not a privilege.',
      'quote_source'       => 'Black Arts Vancouver',
      'post_buttons'       => array(
        array('button_link' => array('title' => 'Join the Directory', 'url' => '/artists/', 'target' => ''), 'button_style' => 'primary'),
      ),
      'section_background' => 'light',
      'section_padding'    => 'large',
    ),
    array(
      'acf_fc_layout'      => 'feature_list',
      'heading'            => 'Key Capabilities',
      'intro'              => 'Grid-based feature list with dual-column cards and footer CTA.',
      'left_items'         => array(
        array('title' => 'Mobile Check-In', 'description' => 'Reduce queue times with guided guest intake.'),
        array('title' => 'Digital Keys', 'description' => 'Secure room access with fewer front-desk bottlenecks.'),
        array('title' => 'Guest Messaging', 'description' => 'Real-time communication for service requests.'),
      ),
      'right_items'        => array(
        array('title' => 'Smart Room Tablets', 'description' => 'Route requests to teams with less manual tracking.'),
        array('title' => 'In-Room Dining', 'description' => 'Simplify service workflows with digital ordering.'),
        array('title' => 'Business Insights', 'description' => 'Turn operational data into actionable decisions.'),
      ),
      'quote'              => 'We reimagined service to be invisible to guests and indispensable to teams.',
      'quote_source'       => 'Demo CEO Quote',
      'cta_button'         => array('title' => 'Request a Demo', 'url' => '/contact-demo/', 'target' => ''),
      'section_background' => 'muted',
      'section_padding'    => 'large',
    ),
    array(
      'acf_fc_layout'      => 'stats',
      'heading'            => 'Community Impact Snapshot',
      'intro'              => 'Stats section for icon/value rendering and responsive columns.',
      'columns'            => 4,
      'items'              => array(
        array('value' => 2018, 'label' => 'Founded', 'suffix' => ''),
        array('value' => 100, 'label' => 'Families Served', 'suffix' => '+'),
        array('value' => 40, 'label' => 'Workshops Delivered', 'suffix' => '+'),
        array('value' => 0, 'label' => 'Cost to Youth Programs', 'prefix' => '$'),
      ),
      'section_background' => 'brand',
      'section_padding'    => 'normal',
    ),
    array(
      'acf_fc_layout'      => 'testimonials',
      'heading'            => 'Carousel Testimonial Variant',
      'subtext'            => 'Designed to test arrows, dots, and active state transitions.',
      'style'              => 'simple',
      'display_mode'       => 'carousel',
      'slides_per_view'    => '1',
      'show_controls'      => 1,
      'items'              => array(
        array('quote' => 'This platform creates seamless communication for our teams and guests.', 'name' => 'Christopher Wylie', 'info_line_one' => 'The Ranch at Laguna Beach', 'info_line_two' => 'Hospitality'),
        array('quote' => 'Editorial updates are now fast, consistent, and easy for non-technical staff.', 'name' => 'Marketing Manager', 'info_line_one' => 'Enterprise SaaS', 'info_line_two' => 'B2B'),
      ),
      'section_background' => 'none',
      'section_padding'    => 'large',
    ),
    array(
      'acf_fc_layout'      => 'text_media',
      'content'            => '<h2>Donate and Volunteer</h2><p>Monthly donations help keep workshops free and accessible. If you cannot commit monthly, one-time support still makes a direct impact.</p><p><a class="btn btn--primary btn--md" href="/contact-demo/">Donate Now</a></p>',
      'media_position'     => 'right',
      'image_style'        => 'rounded',
      'section_width'      => 'full',
      'image_full_bleed'   => false,
      'section_background' => 'none',
      'section_padding'    => 'large',
    ),
    array(
      'acf_fc_layout'      => 'video_embed',
      'heading'            => 'Community Reel',
      'intro'              => 'Inline video section variant for playback and embed fallback testing.',
      'video_url'          => 'https://www.youtube.com/watch?v=wGTqXZrH374',
      'open_in_modal'      => 0,
      'section_background' => 'dark',
      'section_padding'    => 'normal',
    ),
    array(
      'acf_fc_layout'      => 'breakout_text',
      'content'            => '<p>Become an advocate for a more inclusive future through arts education and community programs.</p>',
      'text_align'         => 'left',
      'text_size'          => 'lg',
      'button_label'       => 'Volunteer with Us',
      'button_link'        => array('title' => 'Volunteer', 'url' => '/contact-demo/', 'target' => ''),
      'section_background' => 'light',
      'section_padding'    => 'large',
    ),
    array(
      'acf_fc_layout'      => 'carousel',
      'heading'            => 'Program Spotlights',
      'subtext'            => 'Content-card carousel variant with two-up desktop layout.',
      'slides_per_view'    => '2',
      'show_controls'      => 1,
      'items'              => array(
        array('card_type' => 'content', 'eyebrow' => 'Program', 'title' => 'Nexus AI Concierge', 'copy' => 'Give every guest a personal assistant with multilingual support.', 'button' => array('title' => 'Learn More', 'url' => '/projects-demo/', 'target' => '')),
        array('card_type' => 'content', 'eyebrow' => 'Program', 'title' => 'Nexus Smart Service', 'copy' => 'Automate routing and maintenance with customizable workflows.', 'button' => array('title' => 'Explore', 'url' => '/projects-demo/', 'target' => '')),
        array('card_type' => 'content', 'eyebrow' => 'Program', 'title' => 'Nexus Smart Insights', 'copy' => 'Spot trends early and equip teams with data confidence.', 'button' => array('title' => 'View Insights', 'url' => '/projects-demo/', 'target' => '')),
      ),
      'section_background' => 'muted',
      'section_padding'    => 'large',
    ),
    array(
      'acf_fc_layout'      => 'logos',
      'heading'            => 'Community and Brand Partners',
      'subtext'            => 'Placeholder logos for layout and spacing validation.',
      'columns'            => 3,
      'logos'              => array(
        array('image' => array('url' => 'https://via.placeholder.com/220x80?text=BAV+Partner+A', 'alt' => 'Partner A')),
        array('image' => array('url' => 'https://via.placeholder.com/220x80?text=BAV+Partner+B', 'alt' => 'Partner B')),
        array('image' => array('url' => 'https://via.placeholder.com/220x80?text=BAV+Partner+C', 'alt' => 'Partner C')),
      ),
      'section_background' => 'none',
      'section_padding'    => 'normal',
    ),
    array(
      'acf_fc_layout'      => 'html',
      'html_content'       => '<div class="container"><h2>Custom HTML Section</h2><p>Use this section to validate raw embed support, custom wrappers, and utility classes.</p><div class="modal is-open" style="position:static;display:block;background:none;padding:0;"><div class="modal__dialog"><p>Static modal-style card preview for visual QA.</p></div></div></div>',
      'section_background' => 'none',
      'section_padding'    => 'normal',
    ),
  );

  if (! empty($pages['home_hype'])) {
    starter_coat_demo_set_sections((int) $pages['home_hype'], $sections_home_hype);
  }

  if (! empty($pages['home_bav'])) {
    starter_coat_demo_set_sections((int) $pages['home_bav'], $sections_home_bav);
  }
}

$summary = array(
  'home_hype'       => $pages['home_hype'],
  'home_bav'        => $pages['home_bav'],
  'about_hype'      => $pages['about_hype'],
  'about_bav'       => $pages['about_bav'],
  'projects_archive' => $pages['projects_archive'],
  'blog_archive'    => $pages['blog_archive'],
  'contact'         => $pages['contact'],
  'booking'         => $pages['booking'],
);

echo "Starter Coat demo import complete.\n";
echo "Created/updated page IDs:\n";
foreach ($summary as $label => $id) {
  echo '- ' . $label . ': ' . (int) $id . "\n";
}

echo "\nNext: verify templates, menus, featured images, and forms in wp-admin.\n";
