<?php
/**
 * Class Test_Counter
 *
 * @package Wp_Post_Views
 */

/**
 * Tests for WP_Post_Views_Counter_Functions.
 */
class Test_Counter extends WP_UnitTestCase {

	/**
	 * Instance of the counter functions class.
	 *
	 * @var WP_Post_Views_Counter_Functions
	 */
	protected $counter;

	/**
	 * Setup.
	 */
	public function setUp() {
		parent::setUp();
		$this->counter = new WP_Post_Views_Counter_Functions();
	}

	/**
	 * Test validating IP addresses.
	 */
	public function test_validate_ip() {
		$this->assertTrue( $this->counter->validate_ip( '127.0.0.1' ) );
		$this->assertTrue( $this->counter->validate_ip( '192.168.1.1' ) );
		$this->assertFalse( $this->counter->validate_ip( 'invalid-ip' ) );
		$this->assertFalse( $this->counter->validate_ip( '256.256.256.256' ) );
	}

	/**
	 * Test incrementing post views.
	 */
	public function test_counter_increments_views() {
		$post_id = $this->factory->post->create();
		
		// Initial view count should be empty or 0.
		$this->assertEmpty( get_post_meta( $post_id, 'entry_views', true ) );

		// Simulate view.
		$this->counter->counter( $post_id );

		// Check view count is 1.
		$this->assertEquals( '1', get_post_meta( $post_id, 'entry_views', true ) );

		// Simulate another view.
		$this->counter->counter( $post_id );

		// Check view count is 2.
		$this->assertEquals( '2', get_post_meta( $post_id, 'entry_views', true ) );
	}

	/**
	 * Test getting total views.
	 */
	public function test_get_total_views() {
		$post_id_1 = $this->factory->post->create();
		$post_id_2 = $this->factory->post->create();

		update_post_meta( $post_id_1, 'entry_views', 10 );
		update_post_meta( $post_id_2, 'entry_views', 20 );

		// Clear transient to ensure fresh calculation.
		delete_transient( 'wppv_post_total_viewspost' );

		$total = $this->counter->get_total_views( 'post' );
		$this->assertEquals( 30, $total );
	}
}
