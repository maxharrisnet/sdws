<?php

/**
 * Template Name: Landing Pages
 *
 * @package Aera_Technology
 */

get_header();

$hero_eyebrow = get_field('landing_hero_eyebrow');
$hero_title = get_field('landing_hero_title');
$hero_subtitle = get_field('landing_hero_subtitle');
$hero_button_text = get_field('landing_hero_button_text');
$hero_button_link = get_field('landing_hero_button_link');
$hero_image = get_field('landing_hero_image');
$hero_background_image = get_field('landing_hero_background_image');

$form_title = get_field('landing_form_title');
$form_subtitle = get_field('landing_form_subtitle');
$form_description = get_field('landing_form_description');
$form_feature_list = get_field('landing_form_features');
$form_shortcode = get_field('landing_form_shortcode');
$form_portal_id = get_field('landing_form_portal_id') ?: '4455954';
$form_form_id = get_field('landing_form_id');

$testimonials_title = get_field('landing_testimonials_title');
$testimonials = get_field('landing_testimonials');
$testimonials_link_text = get_field('landing_testimonials_link_text');
$testimonials_link_url = get_field('landing_testimonials_link_url');

$disclaimer = get_field('landing_disclaimer');

$hero_style = '';
if (!empty($hero_background_image) && !empty($hero_background_image['url'])) {
  $hero_style = ' style="background-image: url(' . esc_url($hero_background_image['url']) . ');"';
}
?>

<main id="primary" class="site-main site-main--landing-page">
  <div class="landing-page">
    <?php if (!empty($hero_title) || !empty($hero_subtitle) || !empty($hero_image)) : ?>
      <section class="landing-page__hero" <?php echo $hero_style; ?>>
        <div class="landing-page__heroContainer">
          <div class="landing-page__heroLeft">
            <?php if (!empty($hero_eyebrow)) : ?>
              <div class="landing-page__eyebrow"><?php echo esc_html($hero_eyebrow); ?></div>
            <?php endif; ?>

            <?php if (!empty($hero_title)) : ?>
              <h1 class="landing-page__heroTitle"><?php echo wp_kses_post($hero_title); ?></h1>
            <?php endif; ?>

            <?php if (!empty($hero_subtitle)) : ?>
              <p class="landing-page__heroSubtitle"><?php echo wp_kses_post($hero_subtitle); ?></p>
            <?php endif; ?>

            <?php if (!empty($hero_button_text) && !empty($hero_button_link)) : ?>
              <div class="landing-page__heroCTA">
                <a class="button button--solid" href="<?php echo esc_url($hero_button_link); ?>">
                  <?php echo esc_html($hero_button_text); ?>
                </a>
              </div>
            <?php endif; ?>
          </div>

          <?php if (!empty($hero_image) && !empty($hero_image['url'])) : ?>
            <div class="landing-page__heroRight">
              <div class="landing-page__heroImage">
                <img src="<?php echo esc_url($hero_image['url']); ?>" alt="<?php echo esc_attr($hero_image['alt'] ?? __('Landing page hero image', 'aera')); ?>" />
              </div>
            </div>
          <?php endif; ?>
        </div>
      </section>
    <?php endif; ?>

    <?php if (!empty($form_title) || !empty($form_subtitle) || !empty($form_description) || !empty($form_shortcode) || !empty($form_form_id)) : ?>
      <section class="landing-page__formSection" id="landing-form">
        <div class="landing-page__formContainer">
          <div class="landing-page__formLeft">
            <?php if (!empty($form_title)) : ?>
              <h2 class="landing-page__formTitle"><?php echo esc_html($form_title); ?></h2>
            <?php endif; ?>

            <?php if (!empty($form_subtitle)) : ?>
              <h3 class="landing-page__formSubtitle"><?php echo wp_kses_post($form_subtitle); ?></h3>
            <?php endif; ?>

            <?php if (!empty($form_description)) : ?>
              <div class="landing-page__formDescription">
                <?php echo wp_kses_post(wpautop($form_description)); ?>
              </div>
            <?php endif; ?>

            <?php if (!empty($form_feature_list)) : ?>
              <ul class="landing-page__featureList">
                <?php foreach ($form_feature_list as $feature) : ?>
                  <?php if (!empty($feature['text'])) : ?>
                    <li><?php echo esc_html($feature['text']); ?></li>
                  <?php endif; ?>
                <?php endforeach; ?>
              </ul>
            <?php endif; ?>
          </div>

          <?php if (!empty($form_form_id)) : ?>
            <div class="landing-page__formRight">
              <div id="landingHubspotForm" style="width: 100%;"></div>
            </div>
          <?php elseif (!empty($form_shortcode)) : ?>
            <div class="landing-page__formRight">
              <?php echo do_shortcode($form_shortcode); ?>
            </div>
          <?php endif; ?>
        </div>
      </section>

      <?php if (!empty($form_form_id)) : ?>
      <script>
        (function() {
          const portalId = '<?php echo esc_js($form_portal_id); ?>';
          const formId = '<?php echo esc_js($form_form_id); ?>';

          if (!portalId || !formId) return;

          const formCss = `#landingHubspotForm .hs-form { width: 100%; }
#landingHubspotForm .hs-form .hs-form-iframe { width: 100%; }
#landingHubspotForm h3 { font-family: "Gilroy", sans-serif !important; font-weight: 700; font-size: 20px; }
#landingHubspotForm .hs-form .hs-form-iframe fieldset { margin-bottom: 20px; border: none; padding: 0; }
#landingHubspotForm .hs-form .hs-form-field { margin-bottom: 20px; }
#landingHubspotForm .hs-form .hs-form-field label { display: block; margin-bottom: 8px; font-weight: 350; font-size: 20px; color: #3e424c; }
#landingHubspotForm .hs-form .hs-form-field label span.hs-form-required { color: #e74c3c; margin-left: 4px; }
#landingHubspotForm .hs-form .hs-form-field .input { position: relative; }
#landingHubspotForm .hs-form input.hs-input,
#landingHubspotForm .hs-form select.hs-input { width: 100%; padding: 12px 15px; border: none; border-bottom: 1px solid #1a1a1a; border-radius: 0; font-size: 14px; background-color: transparent; color: #1a1a1a; transition: all 0.3s ease; box-sizing: border-box; }
#landingHubspotForm .hs-form input.hs-input:focus,
#landingHubspotForm .hs-form select.hs-input:focus { border-color: #00619e; outline: none; box-shadow: 0 0 0 3px rgba(0, 97, 158, 0.1); }
#landingHubspotForm .hs-form input.hs-input.error,
#landingHubspotForm .hs-form select.hs-input.error { border-color: #e74c3c; background-color: #fef5f5; }
#landingHubspotForm .hs-form input.hs-input::placeholder,
#landingHubspotForm .hs-form select.hs-input::placeholder { color: #999; }
#landingHubspotForm .hs-form .hs-error-msgs { list-style: none; padding: 0; margin: 4px 0 0 0; }
#landingHubspotForm .hs-form .hs-error-msgs .hs-error-msg { color: #e74c3c; font-size: 12px; font-family: "FreightSans Pro", sans-serif; margin: 0; }
#landingHubspotForm .hs-form .hs-richtext p { font-family: "FreightSans Pro", sans-serif; font-weight: 350; font-size: 10px; }
#landingHubspotForm .hs-form .hs_submit { margin-top: 20px; }
#landingHubspotForm .hs-form .hs_submit .actions { display: flex; gap: 10px; }
#landingHubspotForm .hs-form .hs_submit input[type='submit'].hs-button { appearance: none; display: inline-flex; justify-content: center; position: relative; padding: 0 2.85714em; height: 3.57143em; font-family: "Gilroy", sans-serif; font-weight: 600; line-height: 3.57143; letter-spacing: .025em; text-transform: uppercase; text-decoration: none; white-space: nowrap; border-radius: 999px; border: 1px solid #bee9f3; cursor: pointer; background: rgba(255,255,255,.5); transition: 180ms; transition-property: border-color, background-color, color, opacity; color: #1a1a1a; border-color: rgba(138,196,232,.5); }
#landingHubspotForm .hs-form .hs_submit input[type='submit'].hs-button:hover { background-color: #dee8fb; border-color: #dee8fb rgba(255,255,255,0) #e0f9ff; background-image: linear-gradient(rgba(224,249,255,0) 0%, #e0f9ff 90%); }
#landingHubspotForm .hs-form .hs_submit input[type='submit'].hs-button:focus { outline: none; }
#landingHubspotForm .hs-form .legal-consent-container { margin-bottom: 20px; }
#landingHubspotForm .hs-form .legal-consent-container .hs-richtext p { font-family: "FreightSans Pro", sans-serif; font-weight: 350; font-size: 12px; color: #3e424c; line-height: 1.5; margin: 0; }
#landingHubspotForm .hs-form .legal-consent-container .hs-richtext p a { color: #00619e; text-decoration: none; }
#landingHubspotForm .hs-form .legal-consent-container .hs-richtext p a:hover { text-decoration: underline; }
#landingHubspotForm .hs-form .hs_recaptcha { margin-bottom: 20px; }
#landingHubspotForm .hs-form .hs_recaptcha .grecaptcha-badge { opacity: 0.8 !important; }`;

          function createForm() {
            if (window.hbspt && window.hbspt.forms) {
              window.hbspt.forms.create({
                portalId: portalId,
                formId: formId,
                target: '#landingHubspotForm',
                css: formCss,
                onFormReady: function($form) {
                  const el = document.getElementById('landingHubspotForm');
                  if (el) el.style.opacity = '1';
                }
              });
            }
          }

          if (document.querySelector('script[src*="js.hsforms.net"]')) {
            document.readyState === 'loading' ? document.addEventListener('DOMContentLoaded', createForm) : createForm();
            return;
          }

          const script = document.createElement('script');
          script.src = 'https://js.hsforms.net/forms/embed/v2.js';
          script.charset = 'utf-8';
          script.type = 'text/javascript';
          script.async = true;
          script.addEventListener('load', function() {
            if (window.hbspt && window.hbspt.forms) {
              document.readyState === 'loading' ? document.addEventListener('DOMContentLoaded', createForm) : createForm();
            }
          });
          (document.head || document.getElementsByTagName('head')[0]).appendChild(script);
        })();
      </script>
      <?php endif; ?>
    <?php endif; ?>

    <?php if (!empty($testimonials)) : ?>
      <section class="landing-page__testimonialsSection">
        <div class="landing-page__testimonialsContainer">
          <?php if (!empty($testimonials_title)) : ?>
            <h2 class="landing-page__sectionTitle"><?php echo esc_html($testimonials_title); ?></h2>
          <?php endif; ?>

          <div class="landing-page__carouselWrapper" data-carousel-wrapper>
            <div class="landing-page__carousel" data-carousel>
              <?php foreach ($testimonials as $testimonial) : ?>
                <article class="landing-page__testimonialCard">
                  <div class="landing-page__testimonialContent">
                    <header>
                      <?php if (!empty($testimonial['stars'])) : ?>
                        <div class="landing-page__testimonialStars">
                          <?php for ($i = 0; $i < (int) $testimonial['stars']; $i++) : ?>
                            <span class="landing-page__starIcon" aria-hidden="true">
                              <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10 1.0835L12.8975 6.9535L19.375 7.89475L14.6875 12.4635L15.7938 18.916L10 15.8697L4.20625 18.916L5.3125 12.4635L0.625 7.89475L7.1025 6.9535L10 1.0835Z" fill="#FFC861" />
                              </svg>
                            </span>
                          <?php endfor; ?>
                        </div>
                      <?php endif; ?>

                      <?php if (!empty($testimonial['platform'])) : ?>
                        <div class="landing-page__testimonialPlatform"><?php echo esc_html($testimonial['platform']); ?></div>
                      <?php endif; ?>
                    </header>

                    <div class="landing-page__quoteWrapper">
                      <span class="landing-page__quoteIcon" aria-hidden="true">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path d="M24 0V3.70816C22.8122 4.0515 21.8341 4.70386 21.0655 5.66524C20.2969 6.62661 19.7031 7.86266 19.2838 9.37339C18.9345 10.8841 18.7598 12.5322 18.7598 14.3176H22.8472V24H13.9389V15.4506C13.9389 11.5365 14.4978 8.51502 15.6157 6.38627C16.7336 4.18884 18.0611 2.64378 19.5983 1.75107C21.1354 0.789702 22.6026 0.20601 24 0ZM10.0611 0V3.70816C8.80349 4.0515 7.79039 4.70386 7.02183 5.66524C6.32314 6.62661 5.76419 7.86266 5.34498 9.37339C4.99563 10.8841 4.82096 12.5322 4.82096 14.3176H8.9083V24H0V15.4506C0 11.5365 0.558952 8.51502 1.67686 6.38627C2.79476 4.18884 4.12227 2.64378 5.65939 1.75107C7.19651 0.789702 8.66376 0.20601 10.0611 0Z" fill="#BBE1FA" />
                        </svg>
                      </span>

                      <?php if (!empty($testimonial['quote'])) : ?>
                        <blockquote class="landing-page__testimonialQuote">
                          <p><?php echo esc_html($testimonial['quote']); ?></p>
                        </blockquote>
                      <?php endif; ?>

                      <?php if (!empty($testimonial['subquote'])) : ?>
                        <p class="landing-page__testimonialSubquote"><?php echo esc_html($testimonial['subquote']); ?></p>
                      <?php endif; ?>

                      <span class="landing-page__quoteIcon" aria-hidden="true">
                        <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path d="M-1.90735e-06 24.4951L-1.57649e-06 20.7105C1.18777 20.3601 2.16594 19.6943 2.9345 18.7131C3.70306 17.7319 4.29694 16.4703 4.71616 14.9285C5.0655 13.3866 5.24018 11.7045 5.24018 9.88231L1.15284 9.88231L1.15284 0.000268846L10.0611 0.000269625L10.0611 8.7259C10.0611 12.7208 9.50218 15.8045 8.38428 17.9772C7.26637 20.2199 5.93886 21.7968 4.40174 22.7079C2.86463 23.6891 1.39738 24.2849 -1.90735e-06 24.4951ZM13.9389 24.4951L13.9389 20.7105C15.1965 20.3601 16.2096 19.6943 16.9782 18.7131C17.6769 17.7319 18.2358 16.4703 18.655 14.9285C19.0044 13.3866 19.179 11.7045 19.179 9.88231L15.0917 9.88231L15.0917 0.000270065L24 0.000270844L24 8.7259C24 12.7208 23.441 15.8045 22.3231 17.9772C21.2052 20.2199 19.8777 21.7968 18.3406 22.7079C16.8035 23.6891 15.3362 24.2849 13.9389 24.4951Z" fill="#BBE1FA" />
                        </svg>
                      </span>
                    </div>
                  </div>

                  <footer class="landing-page__testimonialAuthor">
                    <?php if (!empty($testimonial['title'])) : ?>
                      <div class="landing-page__authorTitle"><strong><?php echo esc_html($testimonial['title']); ?></strong></div>
                    <?php endif; ?>
                    <?php if (!empty($testimonial['industry'])) : ?>
                      <div class="landing-page__authorMeta"><?php echo esc_html($testimonial['industry']); ?></div>
                    <?php endif; ?>
                    <?php if (!empty($testimonial['company_size'])) : ?>
                      <div class="landing-page__authorMeta"><?php echo esc_html($testimonial['company_size']); ?></div>
                    <?php endif; ?>
                  </footer>
                </article>
              <?php endforeach; ?>
            </div>
          </div>

          <?php if (count($testimonials) > 1) : ?>
            <nav class="landing-page__carouselControls" aria-label="Testimonials navigation">
              <button class="button button--outline landing-page__arrowButton" type="button" data-carousel-prev aria-label="Previous testimonial">
                <svg width="28" height="21" viewBox="0 0 28 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M27.1667 10.5H0.5M0.5 10.5L10.5 20.5M0.5 10.5L10.5 0.5" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
              </button>
              <button class="button button--outline landing-page__arrowButton" type="button" data-carousel-next aria-label="Next testimonial">
                <svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M0.5 12.1667H23.8333M23.8333 12.1667L12.1667 0.5M23.8333 12.1667L12.1667 23.8333" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
              </button>
            </nav>
          <?php endif; ?>

          <?php if (!empty($testimonials_link_text) && !empty($testimonials_link_url)) : ?>
            <div class="landing-page__readAllReviews">
              <a class="button button--outline" href="<?php echo esc_url($testimonials_link_url); ?>" target="_blank" rel="noopener noreferrer">
                <?php echo esc_html($testimonials_link_text); ?>
              </a>
            </div>
          <?php endif; ?>
        </div>
      </section>
    <?php endif; ?>

    <?php get_template_part('template-parts/components/cta'); ?>

    <?php if (!empty($disclaimer)) : ?>
      <section class="landing-page__disclaimerSection">
        <div class="landing-page__disclaimerContainer">
          <div class="landing-page__disclaimerText">
            <?php echo wp_kses_post(wpautop($disclaimer)); ?>
          </div>
        </div>
      </section>
    <?php endif; ?>
  </div>
</main>

<?php
get_footer();
