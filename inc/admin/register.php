<?php
/**
 * Cache Master - Activating plugin.
 *
 * @author Terry Lin
 * @link https://terryl.in/
 * @since 1.0.0
 * @version 1.0.0
 */

if ( ! defined( 'SCM_INC' ) ) {
	die;
}

/**
 * Assign default setting values while activating this plugin.
 *
 * @return void
 */
function scm_activation() {
	add_option( 'scm_option_driver', 'file' );
	add_option( 'scm_option_ttl', '86400' );
	add_option( 'scm_option_uninstall', 'yes' );
	add_option( 'scm_option_caching_status', 'disable' );

	$post_types = array(
		'home' => 'yes',
		'post' => 'yes',
		'page' => 'yes',
	);

	add_option( 'scm_option_post_types', $post_types );

	scm_setup_security_files();
}

/**
 * Protect the directory from browsing.
 * This function will create an index.html and .htaccess in the plugin's directory.
 *
 * @return void
 */
function scm_setup_security_files() {

	scm_set_blog_id();

	update_option( 'scm_last_reset_time', time() );
	update_option( 'scm_version', SCM_PLUGIN_VERSION );

	// Add default setting. Only execute this action at the first time activation.
	if ( false === scm_is_dir_hash() ) {
		update_option( 'scm_dir_hash', scm_get_dir_hash() );
	}

	if ( ! file_exists( scm_get_upload_dir() ) ) {

		wp_mkdir_p( scm_get_upload_dir() );

		$files = array(
			array(
				'base'    => WP_CONTENT_DIR . '/uploads/' . SCM_PLUGIN_TEXT_DOMAIN,
				'file'    => 'index.html',
				'content' => '',
			),
			array(
				'base'    => WP_CONTENT_DIR . '/uploads/' . SCM_PLUGIN_TEXT_DOMAIN,
				'file'    => '.htaccess',
				'content' => 'deny from all',
			),
		);

		foreach ( $files as $file ) {
			if (
				wp_mkdir_p( $file['base'] ) && 
				! file_exists( trailingslashit( $file['base'] ) . $file['file'] ) 
			) {
				@file_put_contents( trailingslashit( $file['base'] ) . $file['file'], $file['content'] );
			}
		}
	}
}

/**
 * Only use on testing.
 *
 * @return void
 */

/*
function scm_deactivation() {
	delete_option( 'scm_option_driver' );
	delete_option( 'scm_option_ttl' );
	delete_option( 'scm_option_post_types' );
	delete_option( 'scm_option_uninstall' );
	delete_option( 'scm_last_reset_time' );
	delete_option( 'scm_version' );
	delete_option( 'scm_dir_hash' );
	delete_option( 'scm_blog_id' );
}
*/