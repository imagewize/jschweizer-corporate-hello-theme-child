# Hello Elementor Child Theme

A child theme for the [Hello Elementor](https://wordpress.org/themes/hello-elementor/) WordPress theme, customized for Jochen Schweizer Corporate with performance optimizations.

## Description

This child theme extends the Hello Elementor theme with custom functionality and performance enhancements specifically tailored for the Jochen Schweizer Corporate website. It maintains the lightweight and minimalist approach of the parent theme while adding optimizations for improved Core Web Vitals scores.

## Features

### Performance Optimizations

- **Font Display Swap**: Text fonts (Google Fonts and Elementor Pro custom fonts) use `font-display: swap` to prevent invisible text during font loading
- **Icon Font Handling**: Icon fonts (Font Awesome) intentionally use `font-display: block` per Elementor's official guidance to prevent visual glitches
- **Resource Preconnect**: Early connection hints for Google Fonts and YouTube servers to reduce latency
- **Optimized Font Loading**: Reduces Cumulative Layout Shift (CLS) and improves First Contentful Paint (FCP)
- **YouTube Optimization**: Preconnect hints for video backgrounds to reduce loading delays

### Custom Enhancements

- Font loading optimizations for Elementor Google Fonts
- Font display configuration for Elementor Pro custom fonts (MyriadPro)
- Automatic `display=swap` parameter injection for Google Fonts URLs
- Clean, minimal implementation following Elementor best practices

## Requirements

- **WordPress**: 5.9 or higher
- **PHP**: 5.6 or higher
- **Parent Theme**: [Hello Elementor](https://wordpress.org/themes/hello-elementor/)
- **Recommended**: [Elementor Page Builder](https://wordpress.org/plugins/elementor/)

## Installation

1. Ensure the Hello Elementor parent theme is installed and activated in your WordPress installation
2. Upload the `hello-theme-child` folder to `/wp-content/themes/`
3. Activate the child theme through the WordPress admin panel:
   - Navigate to **Appearance > Themes**
   - Click **Activate** on the Hello Elementor Child theme

## File Structure

```
hello-theme-child/
├── functions.php       # Theme functions and customizations
├── style.css          # Child theme stylesheet
├── screenshot.png     # Theme screenshot
├── readme.txt         # WordPress theme readme
├── README.md          # This file
└── LICENSE.md         # License information
```

## Customization

### Adding Custom Styles

Add your custom CSS styles to [style.css](style.css) after line 15.

### Adding Custom Functions

Add your custom PHP functions to [functions.php](functions.php). The theme already includes performance optimization hooks that you can extend or modify.

### Performance Optimization Hooks

The theme includes several filters and actions for performance optimization:

- `elementor/frontend/print_google_fonts/font_display` - Google Fonts display mode
- `elementor_pro/custom_fonts/font_display` - Custom fonts display mode
- `elementor_icons_font_display` - Icon fonts display mode
- `style_loader_src` - Google Fonts URL modification
- `wp_head` (priority 1) - Resource preconnect hints

## Performance Impact

The optimizations in this child theme provide:

- **Reduced Font Loading Delay**: ~200-500ms improvement for text fonts
- **Reduced Video Loading Delay**: ~500-1000ms improvement for YouTube embeds
- **Improved CLS**: Text is visible immediately using fallback fonts
- **Better FCP**: Faster initial content rendering
- **Note**: PageSpeed Insights may warn about icon fonts not using `font-display: swap`. This is expected and acceptable per Elementor's official guidance. See [docs/FONT-FACTS.md](docs/FONT-FACTS.md) for details.

## Development

### Version Management

The theme version is defined in [functions.php:17](functions.php#L17):

```php
define( 'HELLO_ELEMENTOR_CHILD_VERSION', '2.1.3' );
```

Update this constant when making changes to ensure proper cache busting.

### Documentation

### Theme Documentation

- **[docs/FONT-FACTS.md](docs/FONT-FACTS.md)**: Comprehensive guide explaining the difference between text fonts and icon fonts, and why icon fonts intentionally use `font-display: block`
- **[docs/inline-font-icons-test.md](docs/inline-font-icons-test.md)**: Step-by-step guide to test Elementor's "Inline Font Icons" feature for eliminating PageSpeed warnings
- **[docs/performance-optimizations.md](docs/performance-optimizations.md)**: Detailed performance optimization strategies and testing procedures
- **[docs/font-display-optimization.md](docs/font-display-optimization.md)**: Font display optimization architecture and implementation details

### External Resources

- [Hello Elementor Documentation](https://developers.elementor.com/docs/hello-elementor-theme/)
- [Elementor Developers Documentation](https://developers.elementor.com/)

## License

This theme is licensed under the GNU General Public License v3.0 or later. See [LICENSE.md](LICENSE.md) for details.

## Credits

- **Based on**: [Hello Elementor Theme](https://wordpress.org/themes/hello-elementor/) by Elementor Team
- **Child Theme Customization**: Jochen Schweizer Corporate
- **Parent Theme Author**: [Elementor](https://elementor.com/)

## Support

For issues related to:
- **Parent theme**: Visit [Hello Elementor support](https://wordpress.org/support/theme/hello-elementor/)
- **Elementor plugin**: Visit [Elementor support](https://wordpress.org/support/plugin/elementor/)
- **Custom modifications**: Contact your development team

## Changelog

### Version 2.1.3 - 2026-01-29
- **Aligned with Elementor's official guidance on icon fonts**: Icon fonts now use `font-display: block` per Elementor's design to prevent visual glitches
- **Removed complex workarounds**: Clean, minimal codebase following Elementor best practices
- **Added comprehensive documentation**: Font handling guides and testing procedures
- **Philosophy change**: Following framework best practices instead of fighting them
- **Performance maintained**: Same performance as v2.1.2 with cleaner implementation

### Version 2.1.2 - 2026-01-29
- **Universal font-display optimization**: Expanded to ALL fonts (Font Awesome + MyriadPro custom fonts)
- **Automatic Elementor cache clearing**: Ensures WordPress filters apply to regenerated CSS
- **Enhanced documentation**: Comprehensive guides for performance optimizations

### Version 2.1.1 - 2026-01-29
- **Font Awesome font-display optimization**: JavaScript DOM manipulation for proper font loading
- **Performance impact**: 820ms improvement in mobile font loading times
- **Added documentation**: Performance optimization and font display optimization guides

### Version 2.1.0 - 2025-12-12
- **Added AI development guidance**: Documentation for AI-assisted development
- **Performance optimization documentation**: Multi-layered strategies for font loading and resource preconnect
- **Developer conventions**: Function naming, security, and code organization patterns

### Version 2.0.0 - 2025-12-12
- **Initial release**: Base child theme structure inheriting from Hello Elementor
- **Custom styles foundation**: Initial styling setup

---

**Note**: This child theme is specifically customized for Jochen Schweizer Corporate. The performance optimizations are designed to improve Core Web Vitals and page load performance for sites using Elementor with Google Fonts and YouTube video backgrounds.
