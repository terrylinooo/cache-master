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
        update_option( 'caching_status', 'enable' );
    }

    public function testHomepage() {
		$this->go_to( '/' );
        $this->assertQueryTrue ( 'is_home', 'is_front_page' );
	}
}
