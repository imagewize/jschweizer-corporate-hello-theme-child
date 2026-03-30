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

The theme implements a clean, focused approach following Elementor's best practices:

1. **Font Display Swap for Text Fonts** (v2.1.3)
   - **Google Fonts**: via `elementor/frontend/print_google_fonts/font_display` filter → `swap` ✓
   - **Custom Text Fonts (MyriadPro)**: via `elementor_pro/custom_fonts/font_display` filter → `swap` ✓
   - **Icon Fonts (Font Awesome)**: Intentionally use `font-display: block` per Elementor guidance
     - **Why**: Icon fonts should NOT swap (causes visual glitches, accessibility issues)
     - **PageSpeed Warning**: This is a false positive per [Elementor GitHub Issue #33282](https://github.com/elementor/elementor/issues/33282)
     - **Alternative**: Enable "Inline Font Icons" feature to convert to SVG (see `docs/inline-font-icons-test.md`)

2. **Resource Preconnect**: Early connection hints to reduce latency
   - Google Fonts: `fonts.googleapis.com` and `fonts.gstatic.com`
   - YouTube: Multiple domains for video backgrounds (`youtube.com`, `youtube-nocookie.com`, `i.ytimg.com`)
   - Uses both `preconnect` (higher priority) and `dns-prefetch` (fallback)

3. **Load Order**: Child theme stylesheet loads after parent theme (priority 20) to ensure proper cascade

**Philosophy (v2.1.3)**: Follow Elementor's design decisions rather than fighting the framework. Some PageSpeed warnings are false positives for specialized use cases like icon fonts.

## Development Commands

### Version Management

When making changes that affect cached assets or theme functionality, update the version in **THREE places**:

1. **`functions.php:17`** - Version constant for cache busting:
   ```php
   define( 'HELLO_ELEMENTOR_CHILD_VERSION', '2.1.3' );
   ```

2. **`style.css:8`** - Theme header version:
   ```css
   Version: 2.1.3
   ```

3. **`CHANGELOG.md`** - Add new version entry at the top:
   ```markdown
   ## [2.1.3] - 2026-01-29
   ```

**Important**: All three versions must match. The version constant is used for cache busting in stylesheet enqueuing.

### WordPress Integration

This theme requires:
- WordPress 5.9+
- PHP 5.6+
- Hello Elementor parent theme (must be installed)
- Elementor Page Builder (recommended)

No build process, npm, or composer is used. This is a direct WordPress theme deployment.

## Key Implementation Details

### Adding New Performance Optimizations

All performance-related code is contained within the marked section in `functions.php:38-120`. When adding new optimizations:

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

5. **IMPORTANT**: Respect Elementor's design decisions - don't fight the framework
   - Before adding workarounds, check Elementor's official documentation
   - Some PageSpeed warnings are false positives (e.g., icon font display warnings)
   - Prefer using Elementor's built-in features over custom code
   - See `docs/FONT-FACTS.md` for lessons learned

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

To add new preconnect hints, modify `jochen_schweizer_resource_preconnect()` in `functions.php:99-114`. Use:
- `preconnect` with `crossorigin` for CORS resources (fonts, API calls)
- `dns-prefetch` as fallback for browsers without preconnect support
- Priority 1 on `wp_head` hook to ensure earliest possible connection

## Documentation

### Key Documentation Files (v2.1.3)

- **`docs/FONT-FACTS.md`**: Real-world lessons about font optimization, Elementor's stance on icon fonts
- **`docs/inline-font-icons-test.md`**: Testing guide for Elementor's Inline Font Icons feature
- **`docs/performance-optimizations.md`**: General performance optimization strategies
- **`CHANGELOG.md`**: Detailed version history with technical explanations

### Important Lessons Learned

**Icon Fonts vs Text Fonts** (see `docs/FONT-FACTS.md`):
- Text fonts (Google Fonts, MyriadPro): SHOULD use `font-display: swap`
- Icon fonts (Font Awesome): SHOULD NOT use `font-display: swap` (Elementor's official guidance)
- PageSpeed warning for icon fonts: False positive, can be ignored
- Alternative: Enable "Inline Font Icons" to convert icons to SVG

**What Doesn't Work**:
- JavaScript DOM manipulation for font-display (too late, overly complex)
- Automatic cache clearing (unnecessary, potential issues)
- CSS overrides for @font-face (doesn't cascade properly)
- Fighting against framework design decisions

**What Works**:
- Simple WordPress filters for Elementor hooks
- Following official Elementor guidance
- Clean, minimal codebase (~120 lines total)
- Documentation-first approach

## Git Commits and Pull Requests

### Commit Message Guidelines

When creating git commits:
- **Do NOT mention AI tools, assistants, or automation** (e.g., "Claude Code", "AI-generated", "Co-Authored-By: Claude")
- Use imperative tone (e.g., "Add feature" not "Added feature")
- Keep subject line concise and descriptive
- Use commit body for detailed explanations when needed
- Reference issue numbers or GitHub issues when applicable
- **Use atomic commits**: one commit per file or logical file group. Never batch unrelated changes into a single commit. This keeps history clear and makes individual changes easy to revert or review.

**Example commit message**:
```
Align with Elementor icon font guidance (v2.1.3)

Summary of changes and technical details...
References Elementor GitHub Issue #33282
```

### Pull Request Guidelines

When creating pull requests:
- **Do NOT mention AI tools or automation** in the PR description
- Include clear summary of changes
- Document why changes were made (technical reasoning)
- Provide testing steps
- Reference relevant documentation or official guidance
- Call out any performance impact

**Example PR description**:
```markdown
## Summary
This release aligns with Elementor's official guidance...

## Key Changes
- Technical changes listed here

## Testing Steps
1. Verification steps...
```

### Why These Guidelines Matter

This is a professional project repository. Commits and PRs should focus on:
- **What** changed (technical details)
- **Why** it changed (reasoning, references)
- **How** to verify (testing steps)

Attribution to development tools is not necessary in version control history.
