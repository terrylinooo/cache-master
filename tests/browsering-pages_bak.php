<?php
/**
 * Class BroseringPages
 *
 * @package Cache_Master
 */

/**
 * BroseringPages test case.
 */
class BroseringPagesTest extends WP_UnitTestCase {

	public function setUp()
	{
		parent::setUp();

		do_action( 'activate_' . SCM_PLUGIN_NAME );
		update_option( 'scm_option_caching_status', 'enable' );
		update_option( 'template', 'twentytwenty' );
		update_option( 'stylesheet', 'twentytwenty' );
	}

	public function testHomepage() {

		$this->go_to( '/' );

		$post_id = $this->factory->post->create( 
			array( 
				'post_title'   => 'Test Post',
				'post_content' => 'This is a test post.',
			) 
		);

		mock_post_output( $post_id );

		$cm = new Cache_Master();
		$cm->init();

		$this->assertQueryTrue ( 'is_home', 'is_front_page' );
	}
}
