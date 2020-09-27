<?php
/**
 * Cache Master Class autoloader.
 *
 * @package   Cache Master
 * @author    Terry Lin <terrylinooo>
 * @license   GPLv3 (or later)
 * @link      https://terryl.in
 * @copyright 2020 Terry Lin
 */

/**
 * Class autoloader
 */
spl_autoload_register( function( $class_name ) {

	$include_path = '';

	$class_name = ltrim( $class_name, '\\' );

	$class_mapping = array(         
		'Cache_Master' => './class-cache-master',
	);

	if ( array_key_exists( $class_name, $class_mapping ) ) {
		$include_path = SCM_PLUGIN_DIR . 'inc/' . $class_mapping[ $class_name ] . '.php';

		if ( ! empty( $include_path ) && is_readable( $include_path ) ) {
			require $include_path;
		}
	}
});
