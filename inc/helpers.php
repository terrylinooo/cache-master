<?php
/**
 * Cache Master helper functions.
 *
 * @package   Cache Master
 * @author    Terry Lin <terrylinooo>
 * @license   GPLv3 (or later)
 * @link      https://terryl.in
 * @copyright 2020 Terry Lin
 */

if ( ! defined( 'SCM_INC' ) ) {
	die;
}

 /**
 * Load plugin textdomain.
 *
 * @return void
 */
function scm_load_textdomain() {
	load_plugin_textdomain( SCM_PLUGIN_TEXT_DOMAIN, false, SCM_PLUGIN_LANGUAGE_PACK ); 
}

/**
 * Get driver hash.
 *
 * @return string
 */
function scm_get_dir_hash() {
	$hash = get_option( 'scm_dir_hash' );

	if ( empty( $hash ) ) {
		return scm_set_dir_hash();
	}
	return $hash;
}

/**
 * Check driver hash exists or not.
 *
 * @return bool
 */
function scm_is_dir_hash() {
	$hash = get_option( 'scm_dir_hash' );

	if ( empty( $hash ) ) {
		return false;
	}
	return true;
}

/**
 * Set driver hash.
 *
 * @return string
 */
function scm_set_dir_hash() {
	$scm_dir_hash = wp_hash( date( 'ymdhis' ) . wp_rand( 1, 86400 ) );
	$scm_dir_hash = substr( $scm_dir_hash, 0, 8);

	update_option( 'scm_dir_hash', $scm_dir_hash );

	return $scm_dir_hash;
}

/**
 * Get upload dir.
 *
 * @return string
 */
function scm_get_upload_dir() {
	return WP_CONTENT_DIR . '/uploads/cache-master/' . scm_get_blog_id() . '_' . scm_get_dir_hash();
}

/**
 * Set channel Id.
 *
 * @return void
 */
function scm_set_blog_id() {
	update_option( 'scm_blog_id', get_current_blog_id() );
}

/**
 * Get channel Id.
 *
 * @return string
 */
function scm_get_blog_id() {
	return get_option( 'scm_blog_id' );
}

/**
 * Get the path of statistics directory.
 *
 * @param string $cache_type
 *
 * @return string
 */
function scm_get_stats_dir( $cache_type = 'post' ) {
	return scm_get_upload_dir() . '/stats/' . $cache_type;
}

/**
 * Get the cache driver instance.
 *
 * @param string $type The type of the driver.
 *
 * @return \Shieldon\SimpleCache\Cache
 */
function scm_driver_factory( $type ) {
	if ( 'mysql' === $type ) {
		
		$setting = array(
			'host'    => DB_HOST,
			'dbname'  => DB_NAME,
			'user'    => DB_USER,
			'pass'    => DB_PASSWORD,
			'charset' => DB_CHARSET,
		);

	} elseif ( 'sqlite' === $type || 'file' === $type ) {

		$setting = array(
			'storage' => scm_get_upload_dir() . '/' . $type . '_driver',
		);

	} elseif ( 'redis' === $type ) {

		$setting = array(
			'host' => '127.0.0.1',
			'port' =>  6379,
		);

	} elseif ( 'memcache' === $type || 'memcached' === $type ) {

		$setting = array(
			'host' => '127.0.0.1',
			'port' =>  11211,
		);
	} else {
		// apc, apcu, wincache
		$setting = array();
	}

	$driver = new \Shieldon\SimpleCache\Cache( $type, $setting );

	return $driver;
}
