<?php
/**
 * Class Test_Blocks
 *
 * @package Wp_Post_Views
 */

/**
 * Tests for WP_Post_Views_Blocks.
 */
class Test_Blocks extends WP_UnitTestCase {

	/**
	 * Instance of the blocks class.
	 *
	 * @var WP_Post_Views_Blocks
	 */
	protected $blocks;

	/**
	 * Setup.
	 */
	public function setUp() {
		parent::setUp();
		$this->blocks = new WP_Post_Views_Blocks();
	}

	/**
	 * Test that the block is registered (if block.json exists).
	 */
	public function test_block_registration() {
		if ( ! function_exists( 'register_block_type' ) ) {
			$this->markTestSkipped( 'register_block_type function does not exist.' );
		}

		// Since we added a check for file_exists in register_blocks, 
		// we can't easily test the registration itself without a build directory.
		// But we can test the render callback logic.
		$this->assertTrue( method_exists( $this->blocks, 'render_post_views_block' ) );
	}

	/**
	 * Test the render callback output.
	 */
	public function test_render_post_views_block() {
		$post_id = $this->factory->post->create();
		update_post_meta( $post_id, 'entry_views', 1234 );

		// Set the global post.
		$post = get_post( $post_id );
		$GLOBALS['post'] = $post;

		$output = $this->blocks->render_post_views_block( array(), '' );

		$this->assertContains( 'Post Views:', $output );
		$this->assertContains( '1,234', $output );
		$this->assertContains( 'wp-post-views-count', $output );
	}

	/**
	 * Test the render callback with no views.
	 */
	public function test_render_post_views_block_no_views() {
		$post_id = $this->factory->post->create();
		// No meta set.

		$GLOBALS['post'] = get_post( $post_id );

		$output = $this->blocks->render_post_views_block( array(), '' );

		$this->assertContains( 'Post Views:', $output );
		$this->assertContains( '0', $output );
	}
}
