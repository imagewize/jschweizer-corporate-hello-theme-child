<?php
/**
 * Theme functions and definitions.
 *
 * For additional information on potential customization options,
 * read the developers' documentation:
 *
 * https://developers.elementor.com/docs/hello-elementor-theme/
 *
 * @package HelloElementorChild
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

define( 'HELLO_ELEMENTOR_CHILD_VERSION', '2.0.0' );

/**
 * Load child theme scripts & styles.
 *
 * @return void
 */
function hello_elementor_child_scripts_styles() {

	wp_enqueue_style(
		'hello-elementor-child-style',
		get_stylesheet_directory_uri() . '/style.css',
		[
			'hello-elementor-theme-style',
		],
		HELLO_ELEMENTOR_CHILD_VERSION
	);

}
add_action( 'wp_enqueue_scripts', 'hello_elementor_child_scripts_styles', 20 );

/**
 * ============================================================================
 * JOCHEN SCHWEIZER CORPORATE - PERFORMANCE OPTIMIZATIONS
 * ============================================================================
 */

/**
 * Set font-display: swap for Elementor Google Fonts
 *
 * This ensures text is visible immediately using fallback fonts,
 * then swaps to custom fonts when loaded. Reduces CLS and improves FCP.
 *
 * @see https://developers.elementor.com/docs/hooks/font-display/
 */
function jochen_schweizer_elementor_font_display( $font_display ) {
	return 'swap';
}
add_filter( 'elementor/frontend/print_google_fonts/font_display', 'jochen_schweizer_elementor_font_display' );

/**
 * Set font-display: swap for Elementor Pro Custom Fonts
 *
 * This applies to custom fonts uploaded directly to Elementor Pro.
 *
 * @see https://developers.elementor.com/docs/hooks/font-display/
 */
function jochen_schweizer_elementor_custom_fonts_display( $font_display ) {
	return 'swap';
}
add_filter( 'elementor_pro/custom_fonts/font_display', 'jochen_schweizer_elementor_custom_fonts_display' );

/**
 * Modify Google Fonts URLs to add display=swap parameter
 *
 * This catches any Google Fonts loaded via <link> tags and adds
 * the display=swap parameter to the URL.
 *
 * @param string $src The original stylesheet URL
 * @return string Modified URL with display=swap parameter
 */
function jochen_schweizer_google_fonts_swap( $src ) {
	if ( strpos( $src, 'fonts.googleapis.com' ) !== false ) {
		// Check if display parameter already exists
		if ( strpos( $src, 'display=' ) === false ) {
			// Add display=swap parameter
			$src = add_query_arg( 'display', 'swap', $src );
		}
	}
	return $src;
}
add_filter( 'style_loader_src', 'jochen_schweizer_google_fonts_swap', 10, 1 );

/**
 * Set font-display: swap for Elementor Icons
 *
 * This applies to Elementor's icon font (eicons.woff2).
 * Ensures icons don't cause layout shifts during loading.
 */
function jochen_schweizer_elementor_icons_font_display( $font_display ) {
	return 'swap';
}
add_filter( 'elementor_icons_font_display', 'jochen_schweizer_elementor_icons_font_display' );

/**
 * Add preconnect hints for external resources
 *
 * This establishes early connections to Google Fonts and YouTube servers,
 * reducing latency when resources are requested.
 *
 * Font preconnect: Reduces font loading delay by ~200-500ms
 * YouTube preconnect: Reduces video loading delay by ~500-1000ms
 */
function jochen_schweizer_resource_preconnect() {
	?>
	<!-- Google Fonts preconnect -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

	<!-- YouTube preconnect for video backgrounds -->
	<link rel="preconnect" href="https://www.youtube.com" crossorigin>
	<link rel="preconnect" href="https://www.youtube-nocookie.com" crossorigin>
	<link rel="preconnect" href="https://i.ytimg.com" crossorigin>
	<link rel="dns-prefetch" href="https://www.youtube.com">
	<link rel="dns-prefetch" href="https://www.youtube-nocookie.com">
	<link rel="dns-prefetch" href="https://i.ytimg.com">
	<?php
}
add_action( 'wp_head', 'jochen_schweizer_resource_preconnect', 1 );

/**
 * ============================================================================
 * END PERFORMANCE OPTIMIZATIONS
 * ============================================================================
 */
