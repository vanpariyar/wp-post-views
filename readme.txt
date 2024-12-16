=== Wp Post Views - Wordpress Post views counter ===
Contributors: vanpariyar, ankitatanti, Brijeshdhanani, piyushmultidots, kajalgohel
Tags: post views, count wordpress site views, show post views, post view counter, WP Post Views
Requires at least: 5.4
Requires PHP: 7.4
Tested up to: 6.7
Stable tag: 1.18
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Donate link: https://paypal.me/vanpariyar

Wordpress Post views counter

== Description ==

Wordpress post views counter counts the view of your Built in post type and Custom post type.

### Features And Options:
* Simple, and easy to understand.
* Option to filter views on IP address to get accurate post count.
* Option to select the custom post type.

### How to Get Post Count in Frontend

Use this shortcode.

[WPPV-TOTAL-VIEWS] 


TO get site wide count of your post type ( Refresh Hourly due to performance reason ).
[WPPV-TOTAL-VIEWS-PER-POST-TYPE post_type="post"]
The total view shortcode not working well with large sites.


### Tutorial

[youtube https://youtu.be/11NH5xOBs68]

### Development
* Development happening on GitHub :- [WP Post Views Github](https://github.com/vanpariyar/wp-post-views)
* Create issue on the GitHub OR Pull request for new feature when new tag added it will automatically deployed.

== Installation ==

1. Install the plugin either via the WordPress.org plugin directory, or by uploading the files to your server (in the /wp-content/plugins/ directory).
2. Activate the  plugin through the 'Plugins' menu in WordPress.
3. TO make settings Go to User Admin panel Settings->WP Post views
4. You can select your custom post type as per requirement. 


== Screenshots ==

1. screenshot-1
2. screenshot-2
3. screenshot-3
4. screenshot-4

== Changelog ==

= 1.18 - 16/12/2024 =
- Removed Home page checks from Ajax.
- Now home page views will be counted

= 1.17 - 30/11/2024 =
- Complete architecture Changed on How we count views.
- we are using simple Js insted of AJAX thanks to https://github.com/vanpariyar/wp-post-views/pull/33

= 1.15 - 12/03/2024 =
- Complete architecture Changed on How we count views.
- We are now using ajax to count views. This will ensure the views getting logged even on the caching set. Please while using cache allow ajax function to run. 
- code changes can be viewed in GitHub -: https://github.com/vanpariyar/wp-post-views/compare/master...28-it-is-sowing-php-errors

= 1.14 - 21/09/2023 =
- Version Bump to 1.14

= 1.13 - 16/06/2023 =
- Version Bump to 1.13
- Merged new changes for PHPCS and PHPCBF. Thanks @kajalgohel for Contributions

= 1.12 - 23/01/2023 =
- Version Bump to support 6.2

= 1.11 - 19/10/2022 =
- Introduction of the new shortcode
- [WPPV-TOTAL-VIEWS-PER-POST-TYPE post_type="post"]

= 1.10 - 18/07/2022 =
- Version Bump to support 6.0
- Added ru_RU ( Russian Translation )
- fixed https://github.com/vanpariyar/wp-post-views/issues/17
- https://github.com/vanpariyar/wp-post-views/issues/16

= 1.9 - 23/01/2022 =
- Version Bump to support 5.9

= 1.8 - 19/12/2021 =
- Fix `validate_ip()` function creates error.

= 1.6 & 1.7 - 14/07/2020 =
- Version bump to 5.8

= 1.5 - 15/12/2020 =
- Enhancement: Fixed IP Related Issue.

= 1.4 - 15/12/2020 =
- Enhancement: Text Domain Change.

= 1.3 - 26/04/2020 =
- Enhancement: Text Domain Change.

= 1.2 - 26/04/2020 =
- Enhancement: Fix the Views Count.
- Features: Added The Shortcode For Frontend Users.  

= 1.1 - 23/02/2020 =
- Enhancement: Fix the error when WP_DEBUG is true.

= 1.0 =
- Innitial: First Version

== Upgrade Notice ==
Please update Your plugin for better performance and new features.
