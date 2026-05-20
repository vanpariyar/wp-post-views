![Deploy](https://github.com/vanpariyar/wp-post-views/actions/workflows/main.yml/badge.svg)
![Test and Lint](https://github.com/vanpariyar/wp-post-views/actions/workflows/test.yml/badge.svg)

# WP Post Views

Lightweight and efficient post views counter for WordPress.

## Features
- **Gutenberg Block:** Easily display post views using the dedicated "Post Views" block.
- **Shortcodes:** Support for `[WPPV-TOTAL-VIEWS]` and `[WPPV-TOTAL-VIEWS-PER-POST-TYPE]`.
- **IP Filtering:** Option to filter views by IP address for more accurate counts.
- **Custom Post Types:** Support for tracking views on posts, pages, and custom post types.
- **Admin Column:** View count column in the WordPress admin post list.
- **Performance Optimized:** Uses transients for total counts and efficient database queries.
- **Developer Friendly:** Clean code with PHPUnit tests and GitHub Actions CI.

## Documentation
Full documentation is available at [https://vanpariyar.github.io/wp-post-views/](https://vanpariyar.github.io/wp-post-views/)

## Installation
1. Upload the plugin to your `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Configure settings under **Settings > WP Post Views**.

## Development
This plugin is developed with modern tools:
- **Gutenberg Block:** Built with `@wordpress/scripts`.
- **Testing:** PHPUnit for PHP and Linting for JS/CSS.
- **CI/CD:** GitHub Actions for automated testing and deployment to WordPress.org.

### Local Setup
```bash
git clone https://github.com/vanpariyar/wp-post-views.git
cd wp-post-views
npm install
npm run build
```

## Credits
Originally created by [Ronak J Vanpariya](https://github.com/vanpariyar).
Special thanks to [AnkitaTanti](https://github.com/AnkitaTanti) for original contributions.

## License
GPL-2.0-or-later
