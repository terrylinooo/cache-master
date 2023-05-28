<?php
/**
 * Cache Master - Setting page.
 *
 * @author Terry Lin
 * @link https://terryl.in/
 * @since 1.5.2
 * @version 1.5.2
 */

if ( ! defined( 'SCM_INC' ) ) {
	die;
}

require_once SCM_PLUGIN_DIR . 'inc/helpers.php';
require_once SCM_PLUGIN_DIR . 'inc/admin/functions.php';
require_once SCM_PLUGIN_DIR . 'vendor/autoload.php';

add_action( 'wp_ajax_scm_action_clear_cache', 'scm_ajax_clear_cache_callback' );

/**
 * AJAX callback.
 *
 * @return void
 */
function scm_ajax_clear_cache_callback() {

	if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'scm_clear_cache_' . scm_get_dir_hash() ) ) {
		echo __( 'Token has been rejected.', 'cache-master' );
		wp_die();
	}

	if ( ! current_user_can( 'manage_options' ) ) {
		echo __( 'Access denied.', 'cache-master' );
		wp_die();
	}

	$rows = scm_clear_all_cache();

	if ( $rows > 0 ) {
		// translators: %s is the number of rows.
		echo sprintf( __( '%s rows has been deleted.', 'cache-master' ), $rows );
	} else {
		echo __( 'There is no cache on your site currently.', 'cache-master' );
	}

	wp_die();
}

