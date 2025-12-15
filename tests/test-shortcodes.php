<?php
/**
 * Class Test_Shortcodes
 *
 * @package Wp_Post_Views
 */

/**
 * Tests for plugin shortcodes.
 */
class Test_Shortcodes extends WP_UnitTestCase {

	/**
	 * Test [WPPV-TOTAL-VIEWS] shortcode.
	 */
	public function test_shortcode_total_views() {
		$post_id = $this->factory->post->create();
		update_post_meta( $post_id, 'entry_views', 123 );

		// Set global post object to verify shortcode uses get_the_ID().
		global $post;
		$post = get_post( $post_id );
		setup_postdata( $post );

		$output = do_shortcode( '[WPPV-TOTAL-VIEWS]' );
		$this->assertEquals( '123', $output );

		wp_reset_postdata();
	}

	/**
	 * Test [WPPV-TOTAL-VIEWS-PER-POST-TYPE] shortcode.
	 */
	public function test_shortcode_total_views_per_type() {
		$defaults = array( 'post_type' => 'post' );
		
		// Create posts with views.
		$post_id_1 = $this->factory->post->create( $defaults );
		update_post_meta( $post_id_1, 'entry_views', 50 );
		
		$post_id_2 = $this->factory->post->create( $defaults );
		update_post_meta( $post_id_2, 'entry_views', 50 );

		// Clear transient.
		delete_transient( 'wppv_post_total_viewspost' );

		$output = do_shortcode( '[WPPV-TOTAL-VIEWS-PER-POST-TYPE post_type="post"]' );
		$this->assertEquals( '100', $output );
	}
}
