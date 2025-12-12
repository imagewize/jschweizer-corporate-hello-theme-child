# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Overview

This is a WordPress child theme for Hello Elementor, specifically customized for Jochen Schweizer Corporate. The primary focus is **performance optimization** for Core Web Vitals, particularly around font loading and external resource handling.

## Architecture

### Theme Structure

This is a WordPress child theme that extends the Hello Elementor parent theme. All customizations are done through:
- `functions.php` - PHP hooks and filters for performance optimizations
- `style.css` - Theme metadata and custom CSS (minimal by design)

### Performance Optimization Strategy

The theme implements a multi-layered approach to optimize font loading and reduce Core Web Vitals metrics (CLS, FCP):

1. **Font Display Swap**: All fonts use `font-display: swap` to prevent invisible text
   - Elementor Google Fonts: via `elementor/frontend/print_google_fonts/font_display` filter
   - Elementor Pro Custom Fonts: via `elementor_pro/custom_fonts/font_display` filter
   - Elementor Icons: via `elementor_icons_font_display` filter
   - Google Fonts URLs: via `style_loader_src` filter to inject `display=swap` parameter

2. **Resource Preconnect**: Early connection hints to reduce latency
   - Google Fonts: `fonts.googleapis.com` and `fonts.gstatic.com`
   - YouTube: Multiple domains for video backgrounds (`youtube.com`, `youtube-nocookie.com`, `i.ytimg.com`)
   - Uses both `preconnect` (higher priority) and `dns-prefetch` (fallback)

3. **Load Order**: Child theme stylesheet loads after parent theme (priority 20) to ensure proper cascade

## Development Commands

### Version Management

When making changes that affect cached assets, update the version constant in `functions.php:17`:

```php
define( 'HELLO_ELEMENTOR_CHILD_VERSION', '2.0.0' );
```

This version constant is used for cache busting in stylesheet enqueuing.

### WordPress Integration

This theme requires:
- WordPress 5.9+
- PHP 5.6+
- Hello Elementor parent theme (must be installed)
- Elementor Page Builder (recommended)

No build process, npm, or composer is used. This is a direct WordPress theme deployment.

## Key Implementation Details

### Adding New Performance Optimizations

All performance-related code is contained within the marked section in `functions.php:38-131`. When adding new optimizations:

1. Add functions between the comment markers:
   ```php
   /**
    * ============================================================================
    * JOCHEN SCHWEIZER CORPORATE - PERFORMANCE OPTIMIZATIONS
    * ============================================================================
    */
   ```

2. Use descriptive function names prefixed with `jochen_schweizer_`

3. Document the performance impact (e.g., "Reduces font loading delay by ~200-500ms")

4. Reference official Elementor documentation URLs where applicable

### Hook Priority

- Resource preconnect: Priority 1 (`wp_head`, earliest possible)
- Stylesheet enqueue: Priority 20 (after parent theme at default priority 10)

### Security Pattern

All PHP files must start with:
```php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}
```

This prevents direct file access outside of WordPress context.

## Customization Areas

### Custom CSS
Add custom styles to `style.css` after line 15. Keep styles minimal as this is a child theme.

### Custom PHP Functions
Add to `functions.php`. Follow the existing pattern:
- Prefix functions with `jochen_schweizer_` or `hello_elementor_child_`
- Add documentation blocks explaining purpose and performance impact
- Keep performance optimizations in the marked section

### Font Loading Modifications

The theme modifies Google Fonts URLs via the `style_loader_src` filter. If modifying this:
- Check if parameter already exists before adding
- Use `add_query_arg()` for URL manipulation
- Only target `fonts.googleapis.com` URLs

### Preconnect Resources

To add new preconnect hints, modify `jochen_schweizer_resource_preconnect()` in `functions.php:110-125`. Use:
- `preconnect` with `crossorigin` for CORS resources (fonts, API calls)
- `dns-prefetch` as fallback for browsers without preconnect support
- Priority 1 on `wp_head` hook to ensure earliest possible connection
