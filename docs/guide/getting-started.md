# Getting Started

WP Post Views is a simple yet powerful plugin to track and display post views in WordPress.

## Installation

1. Upload the `wp-post-views` folder to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Configure the settings under 'Settings' -> 'WP Post Views'.

## Displaying Post Views

### Using Shortcode

You can use the following shortcode to display the view count:

```text
[wp_post_views]
```

### Using PHP Function

Alternatively, you can use the PHP function in your theme files:

```php
<?php if ( function_exists( 'get_post_view' ) ) { echo get_post_view(); } ?>
```
