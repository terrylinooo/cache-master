<?php
/**
 * Cache Master - Update setting.
 *
 * @author Terry Lin
 * @link https://terryl.in/
 * @since 1.0.0
 * @version 1.3.0
 */

if ( ! defined( 'SCM_INC' ) ) {
	die;
}

add_action( 'update_option_scm_option_driver', 'scm_update_scm_option_driver' );
add_action( 'update_option_scm_option_post_types', 'scm_update_scm_option_post_types' );
add_action( 'update_option_scm_option_post_archives', 'scm_update_scm_option_post_archives' );
add_action( 'update_option_scm_option_post_homepage', 'scm_update_scm_option_post_homepage' );
add_action( 'update_option_scm_option_caching_status', 'scm_update_scm_option_caching_status' );
add_action( 'update_option_scm_option_expert_mode_status', 'scm_update_scm_option_expert_mode_status' );

/**
 * Rebuild data schema.
 *
 * @return void
 */
function scm_update_scm_option_driver() {
	$driver_type = get_option( 'scm_option_driver' );

	if ( ! scm_test_driver( $driver_type ) ) {
		set_option( 'scm_option_driver', 'file' );

		// Road back to File driver if the option is not available.
		$driver_type = 'file';
	}

	$driver = scm_driver_factory( $driver_type );
	$driver->rebuild();
}

/**
 * Clear all cache.
 *
 * @return void
 */
function scm_update_scm_option_post_types() {
	$driver_type = get_option( 'scm_option_driver' );
	$driver = scm_driver_factory( $driver_type );
	$driver->clear();

	scm_check_permalink_structure();
}

/**
 * Clear all cahce after changing chaning status.
 *
 * @return void
 */
function scm_update_scm_option_caching_status() {
	scm_update_scm_option_post_types();
}

/**
 * Check permalink structure because only static URL structure is supported.
 *
 * @return void
 */
function scm_check_permalink_structure() {
	if ( '' === get_option( 'permalink_structure') ) {
		set_option( 'option_caching_status', 'disable' );
	}
}

/**
 * Create checkpoint file for Expert Mode.
 *
 * @return void
 */
function scm_update_scm_option_expert_mode_status() {
	$checkpoint = scm_get_upload_dir() . '/expert.lock';

	if ( 'enable' === get_option( 'scm_option_expert_mode_status' ) ) {
		file_put_contents( $checkpoint, 'VOTE!' );
	} else {
		if ( file_exists( $checkpoint ) ) {
			unlink( $checkpoint );
		}
	}
}

/**
 * Clear all cahce after updating homepage option.
 *
 * @return void
 */
function scm_update_scm_option_post_homepage() {
	scm_update_scm_option_post_types();
}

/**
 * Clear all cahce after updating archive page option.
 *
 * @return void
 */
function scm_update_scm_option_post_archives() {
	scm_update_scm_option_post_types();
}