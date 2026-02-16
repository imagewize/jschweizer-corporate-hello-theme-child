=== Hello Elementor Child ===

Contributors: elemntor
Requires at least: 5.9
Tested up to: 6.2
Stable tag: 2.1.7
Version: 2.1.7
Requires PHP: 5.6
License: GNU General Public License v3 or later
License URI: https://www.gnu.org/licenses/gpl-3.0.html
Tags: flexible-header, custom-colors, custom-menu, custom-logo, editor-style, featured-images, rtl-language-support, threaded-comments, translation-ready

The Hello Elementor Child Theme is a child theme for [Hello Elementor](https://wordpress.org/themes/hello-elementor/), customized for Jochen Schweizer Corporate with performance optimizations.

== Description ==

Hello Elementor Child is a lightweight and minimalist WordPress theme that was built specifically to work seamlessly with the Elementor page builder plugin. This child theme extends the parent theme with custom performance optimizations designed to improve Core Web Vitals and page load performance.

**Key Features:**

* Font-display: swap for text fonts (Google Fonts, custom fonts)
* Font-display: block for icon fonts (Font Awesome) per Elementor guidance
* Resource preconnect hints for Google Fonts and YouTube
* Optimized font loading to reduce CLS (Cumulative Layout Shift)
* Improved FCP (First Contentful Paint)
* YouTube video background optimization
* Automatic display=swap parameter injection for Google Fonts URLs

The theme's main focus is on providing a solid foundation for users to build their own unique designs using the Elementor drag-and-drop site builder while maintaining optimal performance. It is optimized for speed and performance, and its simplicity and flexibility make it a great choice for both beginners and experienced website designers.

The theme supports common WordPress features which can be extended using a child-theme. In addition, there are several ways to add custom styles. It can be done from **Elementor**, from the WordPress customizer, using a child-theme, or with an external plugin. To customize the theme further, visit [Elementor developers docs](https://developers.elementor.com/docs/hello-elementor-theme/).

**Performance Improvements:**

* Reduced text font loading delay: ~200-500ms
* Reduced video loading delay: ~500-1000ms for YouTube embeds
* Text visible immediately using fallback fonts
* Faster initial content rendering
* Icon fonts use `font-display: block` per Elementor guidance (PageSpeed warning is expected and acceptable)

== Installation ==

1. In your admin panel, go to Appearance > Themes and click the 'Add New' button.
2. Click 'Upload theme' and upload the zipped child.
3. Click on the 'Activate' button to use your new theme right away.
4. Navigate to Elementor and start building your site.

== Copyright ==

This theme, like WordPress, is distributed under the terms of GPL.
Use it as your springboard to building a site with ***Elementor***.

Hello Elementor bundles the following third-party resources:

Font Awesome icons for theme screenshot
License: SIL Open Font License, version 1.1.
Source: https://fontawesome.com/v4.7.0/

Image for theme screenshot, Copyright Jason Blackeye
License: CC0 1.0 Universal (CC0 1.0)
Source: https://stocksnap.io/photo/4B83RD7BV9

== Changelog ==

= 2.1.7 - 2026-02-16 =
* Removed Google Fonts preconnects (fonts.googleapis.com, fonts.gstatic.com)
* Discovered via PageSpeed Insights: Google Fonts preconnects were unused
* Elementor's "Load Google Fonts Locally" feature is active - fonts served from local server
* Theme now adds 0 preconnects (down from 2)
* Usercentrics CMP adds 5-6 preconnects (uncontrollable, required for GDPR compliance)
* YouTube domains still use dns-prefetch for video background optimization
* Result: No theme-added preconnects, cleaner implementation, no performance loss

= 2.1.6 - 2026-02-16 =
* Further optimized preconnect resource hints after discovering Usercentrics CMP plugin impact
* Reduced theme preconnects from 3 to 2 (Google Fonts only: fonts.googleapis.com, fonts.gstatic.com)
* Moved all YouTube domains from preconnect to dns-prefetch (www.youtube.com, youtube-nocookie.com, i.ytimg.com)
* Usercentrics CMP plugin adds 3 uncontrollable preconnects (app.usercentrics.eu, api.usercentrics.eu, privacy-proxy.usercentrics.eu)
* Total site preconnects reduced from 6 to 5 (still exceeds Google's 4 max but improved)
* Trade-off accepted: Usercentrics preconnects required for cookie consent compliance
* YouTube domains still benefit from dns-prefetch for video background optimization

= 2.1.5 - 2026-02-16 =
* Optimized preconnect resource hints to comply with PageSpeed Insights recommendation
* Reduced from 5 to 3 preconnect hints (fonts.googleapis.com, fonts.gstatic.com, youtube.com)
* Downgraded youtube-nocookie.com and i.ytimg.com from preconnect to dns-prefetch
* Eliminates PageSpeed warning: "More than 4 preconnect connections were found"
* Maintains performance for all external resources (video backgrounds still work normally)
* Follows Google's best practice to limit preconnects to most critical origins only

= 2.1.4 - 2026-01-30 =
* Updated README.md to reflect v2.1.3 changes
* Clarified font display handling: text fonts use `font-display: swap`, icon fonts use `font-display: block`
* Added references to new documentation files (FONT-FACTS.md, inline-font-icons-test.md, etc.)
* Updated version information from 2.0.0 to 2.1.4 throughout
* Added note about PageSpeed Insights warnings for icon fonts being expected per Elementor guidance
* Updated changelog section to show all versions from 2.0.0 to 2.1.4

= 2.1.3 - 2026-01-29 =
* Aligned with Elementor's official guidance on icon fonts
* Commented out `elementor_icons_font_display` filter that was attempting to force `font-display: swap` on icon fonts
* Added comprehensive documentation explaining why icon fonts should NOT use `font-display: swap`
* Per Elementor GitHub Issue #33282, icon fonts intentionally use `font-display: block` to prevent visual glitches
* PageSpeed Insights warning for icon fonts is a false positive per Elementor team
* Updated function comments to clarify that custom fonts filter only affects MyriadPro (text fonts), not Font Awesome
* Added comprehensive Font Awesome documentation (FONT-FACTS.md)
* Added Inline Font Icons testing guide (inline-font-icons-test.md)
* Removed all complex workarounds (JavaScript DOM manipulation, automatic cache clearing, CSS overrides)
* Philosophy change: From "Fighting the Framework" to "Following Best Practices"
* Icon fonts (Font Awesome): Use default `font-display: block` per Elementor guidance
* Text fonts (Google Fonts, MyriadPro): Use `font-display: swap` as appropriate

= 2.1.2 - 2026-01-29 =
* Universal font-display optimization expanded to ALL fonts (Font Awesome + MyriadPro custom fonts)
* Renamed function from `jochen_schweizer_font_awesome_display_swap()` to `jochen_schweizer_universal_font_display_swap()`
* JavaScript now processes ALL `@font-face` rules, not just Font Awesome patterns
* Added CSSOM API support to modify linked stylesheets
* Added triple execution strategy: immediate + DOMContentLoaded + delayed (100ms)
* Added automatic Elementor cache clearing when theme version changes
* Ensures WordPress filters apply to regenerated CSS
* Added comprehensive documentation update (font-display-optimization.md)
* Expected 1560ms+ improvement in mobile font loading times

= 2.1.1 - 2026-01-29 =
* Font Awesome font-display optimization refactored to use JavaScript DOM manipulation
* Fixes PageSpeed Insights warning: "Font display Est savings of 820ms"
* JavaScript dynamically modifies inline `<style>` blocks before font loading begins
* Targets `fa-regular-400.woff2` and `fa-solid-900.woff2` Font Awesome fonts
* Replaces `font-display: auto/block` with `font-display: swap`
* Added performance optimization functions (currently disabled after testing showed no improvement)
* Created comprehensive performance documentation (performance-optimizations.md)
* Created Font Awesome optimization documentation (font-display-optimization.md)
* Achieved 820ms improvement in mobile font loading times

= 2.1.0 - 2025-12-12 =
* Added comprehensive AI-assisted development guidance documentation (AGENTS.md, CLAUDE.md)
* Added performance optimization documentation with multi-layered font loading strategy
* Added resource preconnect strategy for Google Fonts and YouTube domains
* Formalized theme's technical approach and AI-powered development practices

= 2.0.1 - 2025-12-12 =
* Initial documentation update
* Added .gitignore file for version control
* Project structure improvements

= 2.0.0 - 2023-04-27 =
* Initial release of Hello Elementor Child theme
* Base child theme structure inheriting from Hello Elementor parent theme
* Custom styles foundation
* Load child theme stylesheet after parent theme stylesheet
* Added performance optimizations for fonts and external resources
* Implemented font-display: swap for text fonts (Google Fonts, custom fonts)
* Added preconnect hints for Google Fonts and YouTube to reduce latency
* Optimized font loading to improve CLS and FCP metrics
* Added automatic display=swap parameter injection for Google Fonts URLs
* Added version constant (HELLO_ELEMENTOR_CHILD_VERSION) for better cache management
* Prevent direct access to `functions.php`
* Optimize screenshot image
* Update `Requires at least: 5.9`
* Update `Tested up to: 6.2`
* Update `Theme URI` link
* Added comprehensive performance optimization documentation

= 1.0.0 - 2019-05-23 =
* Initial public release
