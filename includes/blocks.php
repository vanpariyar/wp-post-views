<?php
/**
 * Gutenberg Blocks registration.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class WP_Post_Views_Blocks
 */
class WP_Post_Views_Blocks {

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'register_blocks' ) );
	}

	/**
	 * Register Gutenberg blocks.
	 */
	public function register_blocks() {
		if ( ! function_exists( 'register_block_type' ) ) {
			return;
		}

		$block_dir = WP_POST_VIEW_PLUGIN_PATH . 'build/blocks/post-views';

		if ( file_exists( $block_dir . '/block.json' ) ) {
			register_block_type(
				$block_dir,
				array(
					'render_callback' => array( $this, 'render_post_views_block' ),
				)
			);
		}
	}

	/**
	 * Render callback for the Post Views block.
	 *
	 * @param array $attributes Block attributes.
	 * @param string $content Block content.
	 * @return string
	 */
	public function render_post_views_block( $attributes, $content ) {
		$post_id = get_the_ID();
		if ( ! $post_id ) {
			return '';
		}

		$meta_key       = 'entry_views';
		$view_post_meta = get_post_meta( $post_id, $meta_key, true );
		$views          = ! empty( $view_post_meta ) ? $view_post_meta : 0;

		$wrapper_attributes = get_block_wrapper_attributes();

		return sprintf(
			'<div %1$s><span class="wp-post-views-count">%2$s</span></div>',
			$wrapper_attributes,
			esc_html( number_format_i18n( $views ) )
		);
	}
}

new WP_Post_Views_Blocks();
