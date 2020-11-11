<?php
/**
 * Class ActivationTest
 *
 * @package Cache_Master
 */

/**
 * Uninstall test case.
 */
class UninstallTest extends WP_UnitTestCase {

	/**
     * Uninstall plugin.
	 *
	 * @return void
	 */
    public function testUninstallPlugin() {

        // Activate plugin again, create folders.
        do_action( 'activate_' . SCM_PLUGIN_NAME );

        update_option( 'scm_option_uninstall', 'yes' );

        $found = uninstall_plugin( 'cache-master/cache-master.php' );

        $this->assertTrue( $found );

        /*
		$this->assertFalse( ( file_exists( scm_get_upload_dir() . '/file_driver' ) ) );
        $this->assertFalse( ( file_exists( scm_get_upload_dir() . '/sqlite_driver' ) ) );
        $this->assertFalse( ( file_exists( scm_get_upload_dir() ) ) );
        */
    }
}
