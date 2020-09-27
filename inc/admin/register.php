<?php
/**
 * Cache Master - Activating plugin.
 *
 * @author Terry Lin
 * @link https://terryl.in/
 * @since 1.0.0
 * @version 1.0.0
 */

register_activation_hook( __FILE__, 'scm_activation' );
register_uninstall_hook( __FILE__, 'scm_uninstall' );

/**
 * Assign default setting values while activating this plugin.
 *
 * @return void
 */
function scm_activation() {
	add_option( 'scm_option_driver', 'file' );
	add_option( 'scm_option_ttl', '86400' );
	add_option( 'scm_option_uninstall', 'yes' );
}

/**
 * Remove setting values while uninstalling this plugin.
 *
 * @return void
 */
function scm_uninstall() {
	$option_uninstall = get_option( 'scm_uninstall_option' );

	if ( 'yes' === $option_uninstall ) {
		delete_option( 'scm_option_driver' );
		delete_option( 'scm_option_ttl' );
		delete_option( 'scm_option_uninstall' );
	}
}
