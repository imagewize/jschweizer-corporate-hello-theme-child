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

define( 'HELLO_ELEMENTOR_CHILD_VERSION', '2.1.7' );

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
 */
function jochen_schweizer_elementor_font_display( $font_display ) {
	return 'swap';
}
add_filter( 'elementor/frontend/print_google_fonts/font_display', 'jochen_schweizer_elementor_font_display' );

/**
 * Set font-display: swap for Elementor Pro Custom Fonts (MyriadPro only)
 *
 * NOTE: This only affects custom TEXT fonts uploaded to Elementor Pro.
 * Font Awesome icons are NOT affected by this filter.
 * Requires Elementor cache clear to take effect.
 */
function jochen_schweizer_elementor_custom_fonts_display( $font_display ) {
	return 'swap';
}
add_filter( 'elementor_pro/custom_fonts/font_display', 'jochen_schweizer_elementor_custom_fonts_display' );

/**
 * Elementor Icons font-display filter - COMMENTED OUT
 *
 * WHY DISABLED: Per Elementor's official guidance (GitHub Issue #33282), icon fonts
 * should NOT use font-display: swap. Here's why:
 *
 * 1. Visual Issues: Swapping icon fonts causes random squares/characters to flash
 * 2. Accessibility: Flash of incorrect characters harms users with dyslexia and
 *    cognitive conditions
 * 3. UX Trade-off: Brief wait for correct icons is better than showing wrong characters
 * 4. Intentionally Ignored: Even if this filter is enabled, Elementor's core code
 *    intentionally overrides it for Font Awesome icons by design
 * 5. PageSpeed Warning: The PageSpeed Insights warning for icon fonts is a FALSE POSITIVE
 *    - it applies general rules that don't account for icon font special cases
 *
 * ALTERNATIVES:
 * - Option A (Recommended): Accept the PageSpeed warning as a false positive
 * - Option B (Best Performance): Enable "Inline Font Icons" feature which converts
 *   icons to inline SVG, eliminating font files entirely:
 *   WordPress Admin → Elementor → Settings → Features → Inline Font Icons → Active
 *
 * TESTING: See docs/inline-font-icons-test.md for testing guide
 *
 * @see https://github.com/elementor/elementor/issues/33282
 * @see docs/FONT-FACTS.md
 * @see docs/inline-font-icons-test.md
 */
// function jochen_schweizer_elementor_icons_font_display( $font_display ) {
// 	return 'swap';
// }
// add_filter( 'elementor_icons_font_display', 'jochen_schweizer_elementor_icons_font_display' );

/**
 * Add preconnect hints for external resources
 *
 * NOTE: Google Fonts preconnects have been REMOVED because Elementor's
 * "Load Google Fonts Locally" feature is active - fonts are served from
 * the local server, not Google's CDN. PageSpeed Insights confirmed these
 * preconnects were unused.
 *
 * YouTube domains use dns-prefetch for video background optimization.
 *
 * Usercentrics CMP plugin adds 5-6 preconnects (app.usercentrics.eu,
 * api.usercentrics.eu, privacy-proxy.usercentrics.eu) that we cannot control.
 * These are required for GDPR cookie consent functionality.
 *
 * Total theme preconnects: 0 (Google Fonts are local)
 * Total site preconnects: 5-6 (Usercentrics only, uncontrollable)
 *
 * @see https://web.dev/uses-rel-preconnect/ - Preconnect best practices
 */
function jochen_schweizer_resource_preconnect() {
	?>
	<!-- YouTube domains use dns-prefetch for video background optimization -->
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

/**
 * Allow editing the robots.txt & htaccess data.
 *
 * @param bool Can edit the robots & htacess data.
 */

add_filter( 'rank_math/can_edit_file', '__return_true' );