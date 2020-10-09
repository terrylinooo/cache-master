<?php
/**
 * Uninstall Cache Master plugin.
 *
 * @author Terry Lin
 * @link https://terryl.in/
 *
 * @package Cache Master
 * @since 1.0.0
 * @version 1.3.0
 */

// if uninstall.php is not called by WordPress, die.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	die;
}

$option_uninstall = get_option( 'scm_option_uninstall' );

if ( 'yes' === $option_uninstall ) {

	delete_option( 'scm_option_driver' );
	delete_option( 'scm_option_ttl' );
	delete_option( 'scm_option_post_types' );
	delete_option( 'scm_option_uninstall' );
	delete_option( 'scm_option_caching_status' );
	delete_option( 'scm_option_expert_mode_status' );
	delete_option( 'scm_option_post_homepage' );
	delete_option( 'scm_option_post_archives' );
	delete_option( 'scm_option_visibility_login_user');
	delete_option( 'scm_option_visibility_guest');
	delete_option( 'scm_option_statistics_status' );
	delete_option( 'scm_option_clear_cache' );

	delete_option( 'scm_last_reset_time' );
	delete_option( 'scm_version' );
	delete_option( 'scm_dir_hash' );
	delete_option( 'scm_blog_id' );

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
}
