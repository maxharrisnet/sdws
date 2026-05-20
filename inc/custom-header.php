<?php
/**
 * Sample implementation of the Custom Header feature
 *
 * You can add an optional custom header image to header.php like so ...
 *
	<?php the_header_image_tag(); ?>
 *
 * @link https://developer.wordpress.org/themes/functionality/custom-headers/
 *
 * @package Starter_Coat
 */

/**
 * Set up the WordPress core custom header feature.
 *
 * @uses starter_coat_header_style()
 */
function starter_coat_custom_header_setup() {
	add_theme_support(
		'custom-header',
		apply_filters(
			'starter_coat_custom_header_args',
			array(
				'default-image'      => '',
				'default-text-color' => '000000',
				'width'              => 1000,
				'height'             => 250,
				'flex-height'        => true,
				'wp-head-callback'   => 'starter_coat_header_style',
			)
		)
	);
}
add_action( 'after_setup_theme', 'starter_coat_custom_header_setup' );

if ( ! function_exists( 'starter_coat_header_style' ) ) :
	/**
	 * Styles the header image and text displayed on the blog.
	 *
	 * SDWS does not use the WordPress custom-header image/text-color feature,
	 * so this callback intentionally outputs nothing. The registration above is
	 * kept so that add_theme_support( 'custom-header' ) remains declared,
	 * preventing any plugin compatibility warnings.
	 *
	 * @see starter_coat_custom_header_setup().
	 */
	function starter_coat_header_style() {
		// No output — SDWS header styles live in assets/css/sdws.css.
	}
endif;
