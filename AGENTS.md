# Repository Guidelines

## Project Structure & Modules
- `functions.php`: child-theme hooks and performance tweaks (font-display swap, Google Fonts URL injection, preconnect hints). Update `HELLO_ELEMENTOR_CHILD_VERSION` when changing assets.
- `style.css`: theme header metadata and custom styles; enqueue follows parent theme.
- `readme.txt`/`README.md`: theme description and install notes; keep in sync.
- `screenshot.png`: WordPress theme preview; replace if visual identity changes.

## Local Development & Checks
- Place this folder in `wp-content/themes/hello-theme-child` within a WordPress install that has the Hello Elementor parent theme.
- Activate via WP Admin (`Appearance > Themes`) or CLI: `wp theme activate hello-theme-child`.
- Quick sanity checks before committing:
  - `php -l functions.php` for syntax.
  - Load a representative page and verify fonts/icons swap without layout shift and YouTube/video backgrounds still render.

## Coding Style & Naming
- Follow WordPress PHP standards: tabs for indentation, strict comparisons where applicable, escape outputs, and guard direct access (`ABSPATH` check already present).
- Prefix new functions/filters/actions with `jochen_schweizer_` (or a clear variation) to avoid collisions.
- Keep filters/actions grouped by purpose with short docblocks; prefer early returns over nested conditionals.
- CSS: be minimal, leverage parent/Elementor styles; document non-obvious rules with brief comments.

## Testing Guidelines
- No automated tests are present; rely on manual verification in a staging site.
- When adding hooks that affect assets, test:
  - Logged-in and logged-out views.
  - Pages using Elementor Google Fonts and custom fonts to confirm `font-display: swap` for **text fonts only**.
  - **NOTE**: Icon fonts (Font Awesome) should NOT use `font-display: swap` per Elementor guidance (see `docs/FONT-FACTS.md`).
  - Pages with YouTube backgrounds to ensure preconnect hints remain in `<head>`.
  - After Elementor cache clearing: WordPress Admin → Elementor → Tools → Regenerate CSS & Data.

## Versioning, Assets & Cache
- When bumping version, update **THREE files** to keep versions in sync:
  1. `functions.php:17` → `HELLO_ELEMENTOR_CHILD_VERSION` constant (e.g., `'2.1.3'`)
  2. `style.css:8` → `Version:` in theme header (e.g., `Version: 2.1.3`)
  3. `CHANGELOG.md` → Add new version entry at top (e.g., `## [2.1.3] - 2026-01-29`)
- Version changes force cache busting for WordPress asset loading
- If adding new assets, enqueue through `functions.php` after the parent theme and keep handles consistent.

## Commits & Pull Requests
- Commit messages: imperative tone, concise scope (e.g., `Align with Elementor icon font guidance`).
- PRs should include: summary of changes, linked issue/task, screenshots for UI-affecting tweaks, and steps to validate (pages checked, browsers used).
- Call out any performance-impacting changes or new external resources in the PR description.
- If changing optimization approach, reference Elementor documentation or official guidance.

## Philosophy & Best Practices (v2.1.3)
- **Follow the framework**: Respect Elementor's design decisions rather than fighting them.
- **Text fonts vs Icon fonts**: Different rules apply (see `docs/FONT-FACTS.md` for details).
  - Text fonts (Google Fonts, MyriadPro): Use `font-display: swap` ✓
  - Icon fonts (Font Awesome): Use `font-display: block` per Elementor ✓
- **PageSpeed warnings**: Not all warnings are actionable; some are false positives for specialized cases.
- **Simplicity over complexity**: Clean filters > complex workarounds (JavaScript, cache manipulation).
- **Documentation matters**: When something doesn't work as expected, document why in `docs/` folder.
