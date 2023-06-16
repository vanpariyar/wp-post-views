<?php

add_action( 'init', 'wppv_add_custom_shortcode' );
function wppv_add_custom_shortcode() {
	/**
	 * @param $post which is Post id ( Optional )
	 * @author Ronak Vanpariya.
	 * @desc Get Post Count For the Blog.
	 */

	function wppv_current_post_view_callback($atts = array() , $content = ''){ 
		$meta_key         = 'entry_views';
		$view_post_meta   = get_post_meta(get_the_ID(), $meta_key, true);
		return $view_post_meta;
	}
	if( ! shortcode_exists( 'WPPV-TOTAL-VIEWS' )){
		add_shortcode( 'WPPV-TOTAL-VIEWS', 'wppv_current_post_view_callback' );
	}

	/**
	 * @param $post_type which is post ( Default )
	 * @author Ronak Vanpariya.
	 * @desc Get Post Total Count For the Blog.
	 */

	function wppv_current_post_view_per_post_type_callback($atts = array() , $content = ''){ 
		global $wp_post_views;

		$parsed = wp_parse_args(
			$atts,
			array(
				'post_type' => 'post',
			)
		);
		return $wp_post_views->get_total_views( $parsed['post_type'] );
	}
	if( ! shortcode_exists( 'WPPV-TOTAL-VIEWS-PER-POST-TYPE' )){
		add_shortcode( 'WPPV-TOTAL-VIEWS-PER-POST-TYPE', 'wppv_current_post_view_per_post_type_callback' );
	}
}
