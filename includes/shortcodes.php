<?php

add_action( 'wp', 'wppv_add_custom_shortcode' );
function wppv_add_custom_shortcode() {
	/**
	 * @param $post which is Post id ( Optional )
	 * @author of shortcode Ronak Vanpariya.
	 * @desc Get Post Count For the Blog.
	 */

	function wppv_current_post_view_callback($atts = array() , $content = ''){ 
		$meta_key         = 'entry_views';
		$view_post_meta   = get_post_meta(get_the_ID(), $meta_key, true);
		return $view_post_meta;
	}
	if(!shortcode_exists( 'WPPV-TOTAL-VIEWS' )){
		add_shortcode( 'WPPV-TOTAL-VIEWS', 'wppv_current_post_view_callback' );
	}	
}