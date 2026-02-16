# Performance Optimizations - Complete Guide

**Version**: 2.1.1
**Date**: January 29, 2026
**Server**: Nginx (hostpress.me)
**Author**: Performance Optimization Team

## Overview

This document provides a comprehensive guide to all performance optimizations implemented in the Jochen Schweizer Corporate WordPress theme. These optimizations target Core Web Vitals metrics and PageSpeed Insights recommendations.

## Current Performance Status

### ✅ Resolved Issues
- **Font Display** - Font Awesome font-display optimization (820ms improvement)
- Font Awesome fonts now use `font-display: swap` instead of `auto`

### 🔧 Active Optimizations (v2.1.1)

Based on PageSpeed Insights analysis of `https://jochen-schweizer-corporate.hostpress.me`:

| Issue | Impact | Status | Implementation |
|-------|--------|--------|----------------|
| **Cumulative Layout Shift (CLS)** | 0.854 score | In Progress | Footer spacing, image dimensions |
| **Cache Lifetime** | 56 KiB savings | Partial | Server-level (Nginx), PHP fallback |
| **LCP Image Lazy Loading** | LCP score | In Progress | Disable lazy-load for hero images |
| **Unsized Images** | CLS contributor | In Progress | Auto-add width/height attributes |

## Optimization Implementations

### 1. Cache Control Headers

#### Problem
PageSpeed Insights reported:
```
Use efficient cache lifetimes Est savings of 56 KiB

Request                                    Cache TTL    Transfer Size
JS_Corporate_2023-logo-768x384.webp        None         22 KiB
/latest/uc-block.bundle.js                 1h           31 KiB
…latest/loader.js                          1h           11 KiB
```

#### Solution for Nginx Server

**IMPORTANT**: The server uses **Nginx**, not Apache. `.htaccess` files do NOT work.

##### Option A: Server-Level Configuration (Recommended)

Contact your hosting provider (hostpress.me) to add this to the Nginx configuration:

```nginx
# Cache static assets for 1 year
location ~* \.(webp|jpg|jpeg|png|gif|svg|ico)$ {
    expires 1y;
    add_header Cache-Control "public, max-age=31536000, immutable";
}

# Cache fonts for 1 year
location ~* \.(woff2|woff|ttf|eot)$ {
    expires 1y;
    add_header Cache-Control "public, max-age=31536000, immutable";
    add_header Access-Control-Allow-Origin "*";
}

# Cache CSS and JS for 1 week
location ~* \.(css|js)$ {
    expires 7d;
    add_header Cache-Control "public, max-age=604800";
}
```

##### Option B: PHP Fallback (Already Implemented)

If server configuration isn't possible, the theme includes a PHP-based fallback in [functions.php:217-230](../functions.php#L217-L230):

```php
function jochen_schweizer_set_media_cache_headers() {
    if ( is_admin() ) {
        return;
    }

    // Only apply to media files
    if ( ! is_attachment() && ! preg_match( '/\.(webp|jpg|jpeg|png|gif|svg|woff2?|ttf|eot)$/i', $_SERVER['REQUEST_URI'] ) ) {
        return;
    }

    // Set 1 year cache for static assets
    header( 'Cache-Control: public, max-age=31536000, immutable' );
}
add_action( 'template_redirect', 'jochen_schweizer_set_media_cache_headers', 1 );
```

**Note**: PHP headers only work when WordPress serves the file. If Nginx serves static files directly (typical setup), this won't apply. Server configuration is preferred.

#### Expected Impact
- 22 KiB logo won't re-download on repeat visits
- ~200-500ms faster repeat page loads
- Better PageSpeed Insights score

---

### 2. Cumulative Layout Shift (CLS) Fixes

#### Problem
PageSpeed Insights reported:
```
Layout shift culprits
Total CLS: 0.854

Culprits:
1. Footer element: 0.854
2. Unsized image (500x600): Layout shift
3. LCP image without dimensions
```

#### Solution A: Footer Space Reservation

**Implementation**: [functions.php:322-337](../functions.php#L322-L337)

```php
function jochen_schweizer_footer_reserve_space() {
    ?>
    <style id="js-footer-cls-fix">
        /* Reserve minimum space for footer to prevent layout shift */
        footer.elementor-location-footer {
            min-height: 400px; /* Adjust based on actual footer height */
        }

        /* Ensure images have dimensions to prevent CLS */
        img:not([width]):not([height]) {
            aspect-ratio: attr(width) / attr(height);
        }
    </style>
    <?php
}
add_action( 'wp_head', 'jochen_schweizer_footer_reserve_space', 10 );
```

**Adjustment Required**:
1. Measure actual footer height on the live site
2. Update `min-height: 400px` to match (e.g., `min-height: 450px`)
3. Too small = still causes shift; too large = wasted space

#### Solution B: Automatic Image Dimensions

**Implementation**: [functions.php:296-312](../functions.php#L296-L312)

```php
function jochen_schweizer_add_image_dimensions( $attr, $attachment ) {
    // Get image metadata
    $metadata = wp_get_attachment_metadata( $attachment->ID );

    if ( ! empty( $metadata['width'] ) && ! empty( $metadata['height'] ) ) {
        // Only set if not already present
        if ( empty( $attr['width'] ) ) {
            $attr['width'] = $metadata['width'];
        }
        if ( empty( $attr['height'] ) ) {
            $attr['height'] = $metadata['height'];
        }
    }

    return $attr;
}
add_filter( 'wp_get_attachment_image_attributes', 'jochen_schweizer_add_image_dimensions', 5, 2 );
```

**What it does**:
- Automatically adds `width` and `height` attributes to all images
- Uses WordPress metadata to get actual dimensions
- Prevents browser from needing to recalculate layout when image loads

#### Expected Impact
- CLS score reduction from 0.854 to <0.1 (target)
- Smoother page loading experience
- Better mobile performance scores

---

### 3. LCP (Largest Contentful Paint) Optimization

#### Problem
PageSpeed Insights reported:
```
LCP request discovery
- lazy load not applied ❌ (should NOT be lazy loaded)
- fetchpriority=high should be applied
- Request is discoverable in initial document
```

The **hero/LCP image should NOT be lazy-loaded** because it's the largest visible element and needs to load immediately.

#### Solution A: Disable WordPress Lazy Loading for Large Images

**Implementation**: [functions.php:241-250](../functions.php#L241-L250)

```php
function jochen_schweizer_disable_lazyload_lcp_images( $attr, $attachment, $size ) {
    // Disable lazy loading for large images (typically hero images)
    if ( in_array( $size, array( 'large', 'full', 'medium_large' ), true ) ) {
        $attr['loading'] = 'eager';
        $attr['fetchpriority'] = 'high';
    }

    return $attr;
}
add_filter( 'wp_get_attachment_image_attributes', 'jochen_schweizer_disable_lazyload_lcp_images', 10, 3 );
```

#### Solution B: Disable Elementor/WP Rocket Lazy Loading for First Section

**Implementation**: [functions.php:258-285](../functions.php#L258-L285)

```php
function jochen_schweizer_elementor_disable_lazyload() {
    ?>
    <script>
    (function() {
        if (window.elementorFrontend) {
            // Disable lazy loading for first section images
            elementorFrontend.on('components:init', function() {
                var firstSection = document.querySelector('.elementor-section');
                if (firstSection) {
                    var images = firstSection.querySelectorAll('img[loading="lazy"]');
                    images.forEach(function(img) {
                        img.loading = 'eager';
                        img.fetchPriority = 'high';

                        // Remove data-lazy-src if present (for WP Rocket, etc.)
                        if (img.dataset.lazySrc) {
                            img.src = img.dataset.lazySrc;
                            delete img.dataset.lazySrc;
                        }
                    });
                }
            });
        }
    })();
    </script>
    <?php
}
add_action( 'wp_footer', 'jochen_schweizer_elementor_disable_lazyload', 1 );
```

**What it does**:
- Finds the first Elementor section (typically the hero)
- Removes `loading="lazy"` from images
- Adds `fetchpriority="high"` to prioritize loading
- Handles WP Rocket's `data-lazy-src` attribute

#### Expected Impact
- LCP loads immediately instead of waiting for lazy-load script
- ~500-1000ms improvement on LCP metric
- Better mobile performance scores

---

### 4. Third-Party Resource Optimization

#### Problem
```
Usercentrics CMP: 42 KiB with 1h cache
- /latest/uc-block.bundle.js (31 KiB, 1h)
- …latest/loader.js (11 KiB, 1h)
```

#### Reality Check
**Third-party resources are outside our control.** Usercentrics sets their own cache headers (1 hour), which is reasonable for a cookie consent management platform that needs to update frequently.

#### Recommended Actions
1. **Accept the limitation** - 1h cache is actually good for compliance scripts that change
2. **Async loading** - Ensure Usercentrics loads asynchronously (likely already done)
3. **Monitor impact** - Track if it affects Core Web Vitals meaningfully

**No code changes needed** - this is expected behavior for third-party compliance tools.

---

## Testing & Validation

### After Deploying These Optimizations

1. **Clear All Caches**
   ```bash
   # WordPress cache (if using WP Rocket, W3TC, etc.)
   # CDN cache (Cloudflare, etc.)
   # Browser cache (Cmd+Shift+R / Ctrl+Shift+R)
   ```

2. **Run PageSpeed Insights**
   ```
   URL: https://pagespeed.web.dev/
   Test: https://jochen-schweizer-corporate.hostpress.me

   Expected improvements:
   ✓ CLS score < 0.1 (from 0.854)
   ✓ LCP improved (hero image loads faster)
   ✓ Cache warnings reduced
   ```

3. **Manual Testing**
   - Load page on slow 3G connection
   - Observe if footer "jumps" (should not)
   - Check if hero image appears immediately
   - Verify no unsized images cause layout shifts

### Measurement Tools

```javascript
// Check CLS score in browser console
new PerformanceObserver((list) => {
  for (const entry of list.getEntries()) {
    if (!entry.hadRecentInput) {
      console.log('Layout shift:', entry.value, entry);
    }
  }
}).observe({type: 'layout-shift', buffered: true});

// Check LCP element
new PerformanceObserver((list) => {
  const entries = list.getEntries();
  const lastEntry = entries[entries.length - 1];
  console.log('LCP element:', lastEntry.element, 'Time:', lastEntry.renderTime);
}).observe({type: 'largest-contentful-paint', buffered: true});
```

---

## Configuration Adjustments

### Footer Min-Height Adjustment

The footer reservation height may need tuning:

1. Open your site in browser
2. Open DevTools (F12)
3. Run in console:
   ```javascript
   document.querySelector('footer.elementor-location-footer').offsetHeight
   ```
4. Update [functions.php:327](../functions.php#L327) with actual height:
   ```php
   min-height: 450px; /* Replace 400px with measured height */
   ```

### Disable Optimizations If Needed

If any optimization causes issues, comment out the relevant function:

```php
// Disable footer space reservation
// add_action( 'wp_head', 'jochen_schweizer_footer_reserve_space', 10 );

// Disable LCP lazy-load removal
// add_action( 'wp_footer', 'jochen_schweizer_elementor_disable_lazyload', 1 );
```

---

## Server Configuration (Nginx)

### Contact Hosting Provider

Send this to hostpress.me support:

```
Subject: Request for Nginx Cache Headers Configuration

Hello,

Please add the following cache header configuration to our Nginx server
for improved performance:

# Static images - 1 year cache
location ~* \.(webp|jpg|jpeg|png|gif|svg|ico)$ {
    expires 1y;
    add_header Cache-Control "public, max-age=31536000, immutable";
}

# Fonts - 1 year cache with CORS
location ~* \.(woff2|woff|ttf|eot)$ {
    expires 1y;
    add_header Cache-Control "public, max-age=31536000, immutable";
    add_header Access-Control-Allow-Origin "*";
}

# CSS/JS - 1 week cache
location ~* \.(css|js)$ {
    expires 7d;
    add_header Cache-Control "public, max-age=604800";
}

This will improve PageSpeed Insights scores by enabling proper browser caching.

Thank you!
```

### Why Server-Level is Better

| Aspect | PHP Headers | Nginx Config |
|--------|------------|--------------|
| **Performance** | Requires PHP execution | Served directly by Nginx |
| **Reliability** | Only when WP serves file | Works for all static files |
| **Efficiency** | Slower | Faster |
| **Recommended** | Fallback only | Primary method |

---

## Related Documentation

- [Font Display Optimization](font-display-optimization.md) - Font Awesome specific fixes
- [CLAUDE.md](../CLAUDE.md) - Development patterns and conventions
- [CHANGELOG.md](../CHANGELOG.md) - Version history

## Performance Optimization Checklist

- [x] Font-display: swap for all fonts
- [x] Resource preconnect hints (Google Fonts, YouTube)
- [x] Footer space reservation for CLS
- [x] Automatic image dimensions
- [x] Disable lazy-load for LCP images
- [x] PHP cache header fallback
- [ ] Server-level Nginx cache headers (contact hosting)
- [ ] Measure and adjust footer min-height
- [ ] Monitor Core Web Vitals after deployment

## Support

For issues or questions:

1. Check PageSpeed Insights for current metrics
2. Review browser console for JavaScript errors
3. Verify all caches cleared after deployment
4. Contact development team with specific PageSpeed report URL

---

**Last Updated**: January 29, 2026
**Next Review**: After server-level cache configuration is applied
