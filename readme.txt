=== Wp Post Views - Wordpress Post views counter ===
Contributors: vanpariyar, ankitatanti, Brijeshdhanani, piyushmultidots, kajalgohel
Tags: post views, count wordpress site views, show post views, post view counter, WP Post Views
Requires at least: 5.4
Requires PHP: 7.4
Tested up to: 7.0
Stable tag: 1.23.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Donate link: https://paypal.me/vanpariyar

WP Post Views is a lightweight and efficient plugin to track and display post views in WordPress.

== Description ==

WP Post Views counts the views of your built-in post types (Posts, Pages) and Custom Post Types. It provides multiple ways to display these counts, including a modern Gutenberg block, shortcodes, and PHP functions.

### Features And Options:
* **Simple & Easy:** Designed to be simple and easy to understand for everyone.
* **Gutenberg Block:** A dedicated "Post Views" block for easy placement in your layouts.
* **IP Filtering:** Option to filter views by IP address to ensure accurate counts.
* **Post Type Support:** Choose which post types to track in the settings.
* **Admin Column:** View counts directly in your post/page lists in the admin dashboard.
* **Performance:** Optimized queries and transient caching for total view counts.

### How to Display Post Views:

**1. Gutenberg Block**
Search for the "Post Views" block in the editor.

**2. Shortcodes**
- `[WPPV-TOTAL-VIEWS]`: Display the view count for the current post.
- `[WPPV-TOTAL-VIEWS-PER-POST-TYPE post_type="post"]`: Display total views for a specific post type.

**3. PHP Function**
`<?php if ( function_exists( 'get_post_view' ) ) { echo get_post_view(); } ?>`

### Tutorial

[youtube https://youtu.be/11NH5xOBs68]

### Development
* Development happening on GitHub :- [WP Post Views Github](https://github.com/vanpariyar/wp-post-views)
* Create issue on the GitHub OR Pull request for new feature when new tag added it will automatically deployed.

== Installation ==

1. Install the plugin via the WordPress.org plugin directory or by uploading the files to `/wp-content/plugins/`.
2. Activate the plugin through the 'Plugins' menu.
3. Configure settings at **Settings > WP Post Views**.

== Screenshots ==

1. Post Views column in the WordPress admin post list.
2. Main plugin settings page showing post type selection and IP filtering.
3. The "Post Views" Gutenberg block in the block inserter.
4. Customizing the Post Views block in the editor sidebar.
5. Frontend display of post views on a single blog post.
6. Using the shortcode to display total views per post type.
7. Tracking views across different custom post types.

== Changelog ==

= 1.23.0 - 20/05/2026 =
- **New Feature:** Added a modern Gutenberg block to display post views.
- **Documentation:** Launched new documentation site using VitePress.
- **Workflow:** Updated GitHub Actions for automated building and WordPress.org asset deployment.
- **Assets:** Added dedicated assets for the WordPress.org plugin page.
- **Testing:** Expanded PHPUnit test suite to include Gutenberg block rendering.

= 1.22.0 - 15/12/2025 =
- Added PHPUnit testing framework, Composer dependencies, and GitHub Actions for CI.

= 1.21.0 - 26/09/2025 =
- Version updates

= 1.18.0 - 16/12/2024 =
- Removed Home page checks from Ajax.
- Now home page views will be counted

= 1.17.0 - 30/11/2024 =
- Complete architecture Changed on How we count views.
- we are using simple Js insted of AJAX.

== Upgrade Notice ==
Please update for the new Gutenberg block and improved performance.
