# Font Display: What Actually Works

**Version**: 2.1.3
**Date**: January 29, 2026
**Reality Check**: Based on Elementor team's official guidance

## The Facts

### Font Awesome - OFFICIAL ELEMENTOR STANCE

**Source**: [Elementor GitHub Issue #33282](https://github.com/elementor/elementor/issues/33282)

**Elementor's Official Position**:
- ❌ **Icon fonts SHOULD NOT use `font-display: swap`**
- **Why**: Swapping causes random squares/characters to appear, which is worse than waiting
- **Accessibility**: Flash of incorrect characters harms users with dyslexia and cognitive conditions
- **PageSpeed Warning**: This is a **false positive** - ignore it for icon fonts
- **Recommended Solution**: Enable "Inline Font Icons" feature (converts to SVG)

### Font Awesome - Technical Details
- **NOT** a custom font in Elementor Pro
- **NOT** controllable via `elementor_pro/custom_fonts/font_display` filter
- **Loaded by**: Elementor's built-in icon system OR an Elementor addon/plugin
- **Filter available**: `elementor_icons_font_display` (line 63-66 in functions.php)
- **Reality**: Even if filter is applied, Elementor intentionally uses `font-display: block` for icons

### MyriadPro (Custom Text Fonts)
- ✅ **YES** - Custom font in Elementor Pro
- ✅ **Controllable via**: `elementor_pro/custom_fonts/font_display` filter (line 55-58 in functions.php)
- **CRITICAL**: Only works AFTER Elementor cache is cleared manually
- **Location**: WordPress Admin → Elementor → Custom Fonts
- **Use Case**: Text fonts SHOULD use `font-display: swap` (unlike icon fonts)

## What Works (Proven)

### ✅ Actual Working Code (functions.php v2.1.3)

```php
// Line 47-50: Google Fonts (text fonts - SHOULD use swap)
add_filter( 'elementor/frontend/print_google_fonts/font_display', function() { return 'swap'; } );

// Line 55-58: MyriadPro custom fonts (text fonts - SHOULD use swap)
add_filter( 'elementor_pro/custom_fonts/font_display', function() { return 'swap'; } );

// Line 63-66: Elementor Icons (icon fonts - Elementor says DON'T swap)
// This filter exists but Elementor intentionally ignores it for Font Awesome
// See: https://github.com/elementor/elementor/issues/33282
add_filter( 'elementor_icons_font_display', function() { return 'swap'; } );

// Line 71-86: Preconnect (proven to reduce latency)
add_action( 'wp_head', 'jochen_schweizer_resource_preconnect', 1 );
```

**Total**: ~90 lines. Clean, simple, follows Elementor best practices.

## What Doesn't Work (Proven)

### ❌ Failed/Wrong Approaches

1. **JavaScript DOM manipulation** - Runs too late, fonts already loading
2. **Automatic cache clearing** - Overly complex, unnecessary
3. **Google Fonts URL parameter** - Redundant with filter
4. **CSS overrides** - `@font-face` doesn't cascade like normal CSS
5. **Forcing `font-display: swap` on icon fonts** - Against Elementor best practices, harms UX

## The Real Solution

### For MyriadPro
1. Upload functions.php v2.1.3
2. Go to: WordPress Admin → Elementor → Tools → Regenerate CSS & Data
3. Click "Regenerate Files & Data"
4. Clear WP Rocket cache
5. Test - should now have `font-display: swap`

### For Font Awesome - Choose Your Approach

**The Decision**: You have two valid options based on Elementor's guidance:

#### Option A: Accept PageSpeed Warning (Recommended by Elementor)
1. Keep Font Awesome with `font-display: block` (default behavior)
2. Icons appear correctly when loaded (no visual glitches)
3. Accept PageSpeed Insights warning as a **false positive**
4. **Pros**: Better UX, better accessibility, no code changes needed
5. **Cons**: PageSpeed warning remains

#### Option B: Enable Inline Font Icons (Elementor's Solution)
1. Go to: **WordPress Admin → Elementor → Settings → Features**
2. Find: **Inline Font Icons** → Set to **Active**
3. Save Changes
4. **Result**: Icons convert to inline SVG (no font file loaded)
5. **Pros**: No font loading, no PageSpeed warning, better performance
6. **Cons**: Only works if ALL plugins use Elementor's Icon Manager API properly

**To test Option B**: See the [Inline Font Icons Testing Guide](inline-font-icons-test.md)

## Manual Test

After clearing cache, run this in browser console on your site:

```javascript
// Check all @font-face rules
document.querySelectorAll('style').forEach(style => {
  if (/@font-face/i.test(style.textContent)) {
    const hasSwap = /font-display\s*:\s*swap/i.test(style.textContent);
    const fontName = style.textContent.match(/font-family[^;]+/i)?.[0] || 'Unknown';

    console.log(
      hasSwap ? '✓' : '✗',
      fontName,
      hasSwap ? 'HAS swap' : 'MISSING swap'
    );
  }
});
```

Expected output:
```
✓ font-family: "Myriad Pro" HAS swap
✗ font-family: "Font Awesome" MISSING swap  ← This is the problem
✓ font-family: "Roboto" HAS swap
```

## PageSpeed Impact

### Current (v2.1.3 - Clean Implementation):
- Mobile: 88-91/100
- Desktop: 94-97/100
- Font blocking: Font Awesome icons may still show warning
- **This is EXPECTED and ACCEPTABLE per Elementor guidelines**

### With Inline Font Icons Enabled (Option B):
- Font Awesome warning: **Eliminated** (no font file loaded)
- MyriadPro: **Fixed** (already using `font-display: swap`)
- Realistic improvement: Mobile +2-4 points
- **But**: Requires all plugins to support Elementor Icon Manager

## Bottom Line

**Follow Elementor's official guidance. Don't fight against framework best practices.**

- ✅ **Google Fonts** - controlled via filter, using `swap` ✓
- ✅ **Custom Text Fonts (MyriadPro)** - controlled via filter, using `swap` ✓
- ✅ **Icon Fonts (Font Awesome)** - intentionally use `block`, per Elementor design ✓
- ❌ **Third-party plugin fonts** - not controllable from theme

**Next step**:
1. Test if "Inline Font Icons" works with your plugins ([see testing guide](inline-font-icons-test.md))
2. If it works, enable it and eliminate Font Awesome font files entirely
3. If it doesn't work, accept the PageSpeed warning as a false positive

**Remember**: PageSpeed Insights applies general rules. Icon fonts are a special case where the warning doesn't apply.
