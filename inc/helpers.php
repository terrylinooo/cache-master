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

/**
 * Get a SVG icon.
 *
 * @param string $type The icon type.
 * 
 * Font Awesome Free 5.15.1
 *
 * @return string
 */
function scm_get_svg_icon( $type ) {
	switch ( $type ) {
		case 'status':
			$svg = "<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 320 512'><path d='M296 160H180.6l42.6-129.8C227.2 15 215.7 0 200 0H56C44 0 33.8 8.9 32.2 20.8l-32 240C-1.7 275.2 9.5 288 24 288h118.7L96.6 482.5c-3.6 15.2 8 29.5 23.3 29.5 8.4 0 16.4-4.4 20.8-12l176-304c9.3-15.9-2.2-36-20.7-36z'/></svg>";
			break;

		case 'memory':
			$svg = "<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 352 542'><path d='M205.22 22.09c-7.94-28.78-49.44-30.12-58.44 0C100.01 179.85 0 222.72 0 333.91 0 432.35 78.72 512 176 512s176-79.65 176-178.09c0-111.75-99.79-153.34-146.78-311.82zM176 448c-61.75 0-112-50.25-112-112 0-8.84 7.16-16 16-16s16 7.16 16 16c0 44.11 35.89 80 80 80 8.84 0 16 7.16 16 16s-7.16 16-16 16z'/></svg>";
			break;

		case 'database':
			$svg = "<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 572 572'><path d='M505 442.7L405.3 343c-4.5-4.5-10.6-7-17-7H372c27.6-35.3 44-79.7 44-128C416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c48.3 0 92.7-16.4 128-44v16.3c0 6.4 2.5 12.5 7 17l99.7 99.7c9.4 9.4 24.6 9.4 33.9 0l28.3-28.3c9.4-9.4 9.4-24.6.1-34zM208 336c-70.7 0-128-57.2-128-128 0-70.7 57.2-128 128-128 70.7 0 128 57.2 128 128 0 70.7-57.2 128-128 128z'/></svg>";
			break;

		case 'speed':
			$svg = "<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 400 512'><path d='M192 0C79.7 101.3 0 220.9 0 300.5 0 425 79 512 192 512s192-87 192-211.5c0-79.9-80.2-199.6-192-300.5zm0 448c-56.5 0-96-39-96-94.8 0-13.5 4.6-61.5 96-161.2 91.4 99.7 96 147.7 96 161.2 0 55.8-39.5 94.8-96 94.8z'/></svg>";
			break;
	}

	return $svg;
}