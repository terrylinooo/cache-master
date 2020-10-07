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
 * Test if specific data driver is available or not.
 *
 * @param string $type Data driver.
 *
 * @return bool
 */
function scm_test_driver( $type = '' ) {

	if ( 'mysql' === $type ) {
		if ( class_exists( 'PDO' ) ) {
			$db = array(
				'host'    => DB_HOST,
				'dbname'  => DB_NAME,
				'user'    => DB_USER,
				'pass'    => DB_PASSWORD,
				'charset' => DB_CHARSET,
			);

			try {
				new \PDO(
					'mysql:host=' . $db['host'] . ';dbname=' . $db['dbname'] . ';charset=' . $db['charset'],
					$db['user'],
					$db['pass']
				);
				return true;
			} catch( \PDOException $e ) {

			}
		}
	} elseif ( 'sqlite' === $type ) {

		$sqlite_dir = scm_get_upload_dir() . '/sqlite_driver';
		$sqlite_file_path = $sqlite_dir . '/cache_data.sqlite3';

		if ( ! file_exists( $sqlite_file_path ) ) {
			if ( ! is_dir( $sqlite_dir ) ) {
				wp_mkdir_p( $sqlite_dir );
			}
		}

		if ( class_exists( 'PDO' ) ) {
			try {
				new \PDO( 'sqlite:' . $sqlite_file_path );
				return true;
			} catch( \PDOException $e ) {

			}
		}

	} elseif ( 'file' === $type ) {

		$file_dir = scm_get_upload_dir() . '/file_driver';

		if ( ! is_dir( $file_dir ) ) {
			wp_mkdir_p( $file_dir );
		}

		if ( wp_is_writable( $file_dir ) ) {
			return true;
		}

	} elseif ( 'redis' === $type ) {
		if ( extension_loaded( 'redis' ) ) {
			try {
				$redis = new \Redis();
				$redis->connect( '127.0.0.1', 6379 );
				return true;
			} catch( \RedisException $e ) {

			}
		}

	} elseif ( 'apc' === $type ) {
		if ( function_exists( 'apc_fetch' ) ) {
			return true;
		}

	} elseif ( 'apcu' === $type ) {
		if ( function_exists( 'apcu_fetch' ) ) {
			return true;
		}

	} elseif ( 'memcache' === $type ) {
		if ( extension_loaded( 'memcache' ) ) {
			try {
				$memcache = new \Memcache();
				$memcache->addServer(
					'127.0.0.1',
					11211,
					true,
					1
				);
				return true;
			} catch ( \Exception $e ) {
				
			}
		}

	} elseif ( 'memcached' === $type ) {
		if (extension_loaded('memcached')) {
			try {
				$memcached = new \Memcached();
				$memcached->addServer(
					'127.0.0.1',
					11211,
					1
				);
				return true;
			} catch ( \Exception $e ) {
				
			}
		}

	} elseif ( 'wincache' === $type ) {
		if ( function_exists( 'wincache_ucache_get' ) ) {
			return true;
		}
	}

	return false;
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
 * Load view files.
 *
 * @param string $template_path The specific template's path.
 * @param array  $data          Data is being passed to.
 * @return string
 */
function scm_load_view( $template_path, $data = array() ) {
	$view_file_path = SCM_PLUGIN_DIR . 'inc/admin/views/' . $template_path . '.php';

	if ( ! empty( $data ) ) {
		extract( $data );
	}

	if ( file_exists( $view_file_path ) ) {
		ob_start();
		require $view_file_path;
		$result = ob_get_contents();
		ob_end_clean();
		return $result;
	}
	return null;
}
