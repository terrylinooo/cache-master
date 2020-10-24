<?php
/**
 * Cache Master - Update post.
 *
 * @author Terry Lin
 * @link https://terryl.in/
 * @since 1.0.0
 * @version 1.0.0
 */

if ( ! defined( 'SCM_INC' ) ) {
	die;
}

add_action( 'post_updated', 'scm_update_post', 10, 3 );
add_filter( 'post_updated_messages', 'scm_notice_after_update_post' );

/**
 * Delete the cache of the post that is just updated.
 *
 * @return void
 */
function scm_update_post( $post_ID, $post_after, $post_before ) {

	$option_caching_status = get_option( 'scm_option_caching_status', 'disable' );

	if ( 'enable' === $option_caching_status ) {
		$post_url    = get_permalink( $post_ID );
		$cache_key   = md5( parse_url( $post_url, PHP_URL_PATH ) );
		$driver_type = get_option( 'scm_option_driver' );
		$driver      = scm_driver_factory( $driver_type );

		$driver->delete( $cache_key );
	}
}

/**
 * Display message after updating post.
 *
 * @param array $messages The messages.
 * @return void
 */
function scm_notice_after_update_post( $messages ) {

	$option_caching_status = get_option( 'scm_option_caching_status', 'disable' );

	if ( 'enable' === $option_caching_status ) {
		$custom = '</div>';
		$custom .= '<div class="notice notice-warning is-dismissible"><p>';
		$custom .= '<strong>' . __( 'Cache Master', 'cache-master' ) . '</strong>: ' . __( 'Cache has been cleared.', 'cache-master' );
		$custom .= '</p></div>';
		$custom .= '<div>';
	
		$messages['post'][1] = $messages['post'][1] . $custom;
		$messages['page'][1] = $messages['page'][1] . $custom;
	}

	return $messages;
}
