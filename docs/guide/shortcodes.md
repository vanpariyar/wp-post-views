# Shortcodes

If you are not using the Gutenberg editor, or if you want to display view counts within other areas like widgets or page builders, you can use the provided shortcodes.

## [WPPV-TOTAL-VIEWS]

Displays the total view count for the current post.

**Usage:**
```text
[WPPV-TOTAL-VIEWS]
```

**Output:**
It will display the numeric value of the views.

![Frontend Display](/screenshot-5.png)
*Frontend display of post views on a single blog post.*

## [WPPV-TOTAL-VIEWS-PER-POST-TYPE]

Displays the aggregate view count for all posts within a specific post type.

**Attributes:**
- `post_type`: The slug of the post type (default: `post`).

**Usage:**
```text
[WPPV-TOTAL-VIEWS-PER-POST-TYPE post_type="product"]
```

![Shortcode Usage](/screenshot-7.png)
*Using the shortcode to display total views per post type.*
