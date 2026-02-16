# Performance Test Results Summary

## PageSpeed Scores

**Test Server** (jochen-schweizer-corporate.hostpress.me) — **WITH child theme**:
- Mobile: [87/100](https://pagespeed.web.dev/analysis/https-jochen-schweizer-corporate-hostpress-me/nx1a8irxlo?form_factor=mobile)
- Desktop: [97/100](https://pagespeed.web.dev/analysis/https-jochen-schweizer-corporate-hostpress-me/nx1a8irxlo?form_factor=desktop)

**Live Website** (www.jochen-schweizer-corporate.de) — **WITHOUT child theme**:
- Mobile: [64/100](https://pagespeed.web.dev/analysis/https-www-jochen-schweizer-corporate-de/0zup5bd573?form_factor=mobile)
- Desktop: [96/100](https://pagespeed.web.dev/analysis/https-www-jochen-schweizer-corporate-de/0zup5bd573?form_factor=desktop)

## Why the Mobile Performance Gap?

The 23-point mobile difference (87 vs 64) breaks down approximately as:

1. **Child theme optimizations** → ~5-8 points (font-display swap, preconnect, WebP support)
2. **Better server specifications** (faster CPU/RAM) → ~8-10 points (reduces render blocking)
3. **Redis object caching** → ~8-10 points (eliminates database query overhead)
4. **No YouTube video on test server** → ~2-3 points (live site plays video even on mobile)

## Child Theme Impact

The child theme provides significant optimization value through:
- Font-display swap for text fonts (Google Fonts, MyriadPro)
- Resource preconnect for Google Fonts and YouTube
- WebP image support with proper TTL configuration

**Expected improvement when deployed to live**: 64 → **~69-72/100** mobile (with current infrastructure)

## Identified Issues on Live Mobile Site

From PageSpeed Insights analysis:

1. **Render blocking requests** — Est savings of 3,160 ms
2. **Font display** — Est savings of 850 ms
   *(Note: Icon font warning is a false positive per Elementor guidance - see docs/FONT-FACTS.md)*
3. **Use efficient cache lifetimes** — Est savings of 33 KiB
4. **Improve image delivery** — Est savings of 22 KiB
5. **Warning**: More than 4 preconnect connections found
   *(Currently preconnecting to Google Fonts + YouTube domains for video)*

## Recommendations to Improve Live Site

### Phase 1: Deploy Child Theme (Quick Win)
**Expected: 64 → ~69-72/100 mobile**

1. **Deploy child theme to live site** — Immediate 5-8 point improvement
   - Font-display swap reduces font loading delay
   - Preconnect reduces external resource latency
   - WebP support ensures optimal image loading

### Phase 2: Infrastructure Upgrades (Biggest Impact)
**Expected: ~69-72 → ~85-87/100 mobile**

2. **Upgrade hosting/server specs** — Faster CPU/RAM reduces render blocking time (~8-10 points)
3. **Enable Redis object caching** — Eliminates database query overhead (~8-10 points)

### Phase 3: Content Optimization (Polish)
**Expected: ~85-87 → ~88-90/100 mobile**

4. **Disable autoplay video on mobile** — Set Elementor's "Play On Mobile" to "No" (~2-3 points)
   - Alternative: Use static image background on mobile, video on desktop only
   - Eliminates YouTube player API and video chunk downloads
5. **Image optimization** — WebP compression (22 KiB savings, ~1 point)

**Final Expected Result:** ~88-90/100 mobile with all optimizations

---

*Test Date: 2026-02-13*
