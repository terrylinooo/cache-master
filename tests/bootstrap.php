<?php
/**
 * PHPUnit bootstrap file
 *
 * @package Sample_Plugin
 */

if ( ! defined( 'WP_CLI' ) ) {
	define( 'WP_CLI', true );
}

$_tests_dir = getenv( 'WP_TESTS_DIR' );

if ( ! defined( 'WP_CLI' ) ) {
	define( 'WP_CLI', true );
}

if ( ! $_tests_dir ) {
	$_tests_dir = rtrim( sys_get_temp_dir(), '/\\' ) . '/wordpress-tests-lib';
}

if ( ! file_exists( $_tests_dir . '/includes/functions.php' ) ) {
	echo "Could not find $_tests_dir/includes/functions.php, have you run bin/install-wp-tests.sh ?";
	exit( 1 );
}

// Give access to tests_add_filter() function.
require_once $_tests_dir . '/includes/functions.php';
require_once $_tests_dir . '/../wordpress/wp-includes/pluggable.php';

/**
 * Manually load the plugin being tested.
 */
function _manually_load_plugin() {
	require dirname( dirname( __FILE__ ) ) . '/cache-master.php';
}
tests_add_filter( 'muplugins_loaded', '_manually_load_plugin' );

// Start up the WP testing environment.
require $_tests_dir . '/includes/bootstrap.php';

// Remove previous tests.
$dir = WP_CONTENT_DIR . '/uploads/cache-master';

if ( is_dir( $dir ) ) {
	$it = new RecursiveDirectoryIterator( $dir, RecursiveDirectoryIterator::SKIP_DOTS );
	$files = new RecursiveIteratorIterator( $it, RecursiveIteratorIterator::CHILD_FIRST );
	foreach ( $files as $file ) {
		if ( $file->isDir() ){
			rmdir( $file->getRealPath() );
		} else {
			unlink( $file->getRealPath() );
		}
	}
	unset( $it, $files );
	rmdir( $dir );
}

