/* global wp_post_views_ajax_object, XMLHttpRequest */
/* eslint-disable camelcase */

document.addEventListener( 'DOMContentLoaded', function () {
	if (
		document.body.classList.contains( 'archive' ) ||
		document.body.classList.contains( 'blog' )
	) {
		// Do nothing on archive or blog.
	} else {
		if ( ! wp_post_views_ajax_object.post_id ) {
			return;
		}

		const url = wp_post_views_ajax_object.ajaxurl;

		const data = new FormData();
		data.append( 'action', 'wppv_counter' );
		data.append( 'post_id', wp_post_views_ajax_object.post_id );
		data.append( 'nonce', wp_post_views_ajax_object.nonce );
		const xhttp = new XMLHttpRequest();

		xhttp.open( 'POST', url );
		xhttp.send( data );
	}
} );
