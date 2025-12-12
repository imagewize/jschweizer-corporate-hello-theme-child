# Hello Elementor Child Theme

A child theme for the [Hello Elementor](https://wordpress.org/themes/hello-elementor/) WordPress theme, customized for Jochen Schweizer Corporate with performance optimizations.

## Description

This child theme extends the Hello Elementor theme with custom functionality and performance enhancements specifically tailored for the Jochen Schweizer Corporate website. It maintains the lightweight and minimalist approach of the parent theme while adding optimizations for improved Core Web Vitals scores.

## Features

### Performance Optimizations

- **Font Display Swap**: All fonts (Google Fonts, custom fonts, and icon fonts) use `font-display: swap` to prevent invisible text during font loading
- **Resource Preconnect**: Early connection hints for Google Fonts and YouTube servers to reduce latency
- **Optimized Font Loading**: Reduces Cumulative Layout Shift (CLS) and improves First Contentful Paint (FCP)
- **YouTube Optimization**: Preconnect hints for video backgrounds to reduce loading delays

### Custom Enhancements

- Font loading optimizations for Elementor Google Fonts
- Font display configuration for Elementor Pro custom fonts
- Automatic `display=swap` parameter injection for Google Fonts URLs
- Icon font optimization to prevent layout shifts

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

- **Reduced Font Loading Delay**: ~200-500ms improvement
- **Reduced Video Loading Delay**: ~500-1000ms improvement for YouTube embeds
- **Improved CLS**: Text is visible immediately using fallback fonts
- **Better FCP**: Faster initial content rendering

## Development

### Version Management

The theme version is defined in [functions.php:17](functions.php#L17):

```php
define( 'HELLO_ELEMENTOR_CHILD_VERSION', '2.0.0' );
```

Update this constant when making changes to ensure proper cache busting.

### Documentation

For more information about customizing the Hello Elementor theme:
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

### Version 2.0.0
- Load child theme stylesheet after parent theme stylesheet
- Added performance optimizations for fonts and external resources
- Implemented font-display: swap for all font types
- Added preconnect hints for Google Fonts and YouTube
- Added version constant for better cache management
- Prevented direct access to functions.php
- Updated compatibility requirements

---

**Note**: This child theme is specifically customized for Jochen Schweizer Corporate. The performance optimizations are designed to improve Core Web Vitals and page load performance for sites using Elementor with Google Fonts and YouTube video backgrounds.
