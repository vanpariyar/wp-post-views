# PHP Functions

For theme developers, WP Post Views provides PHP functions to programmatically retrieve or display view counts within your template files.

## get_post_view()

Retrieves or displays the view count for a specific post.

**Parameters:**
- `$post_id` (int): Optional. The ID of the post. Defaults to the current post ID in the loop.
- `$echo` (bool): Optional. Whether to echo the output. Default: `true`.

**Usage:**
```php
<?php 
if ( function_exists( 'get_post_view' ) ) { 
    echo get_post_view( get_the_ID(), false ); 
} 
?>
```

## Advanced Tracking

The plugin tracks views using a lightweight JavaScript approach to ensure compatibility with most caching plugins.

![Tracking Logic](/screenshot-7.png)
*Tracking views across different custom post types.*
