<?php
/**
 * Cache Master - functions used in admin scope.
 *
 * @author Terry Lin
 * @link https://terryl.in/
 * @since 1.0.0
 * @version 1.3.0
 */

if ( ! defined( 'SCM_INC' ) ) {
	die;
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

/**
 * Get the cache type list.
 *
 * @return array
 */
function scm_get_cache_type_list( $get_key = false ) {
	$list = array(
		'homepage'         => __( 'Homepage', 'cache-master' ),
		'post'             => __( 'Post', 'cache-master' ),
		'page'             => __( 'Page', 'cache-master' ),
		'product'          => __( 'Product', 'cache-master' )   . ' <small class="scm-badge">WooCommerce</small>',
		'category'         => __( 'Category', 'cache-master' ) . ' <small class="scm-badge">' . __( 'Archive', 'cache-master' ) . '</small>',
		'tag'              => __( 'Tag', 'cache-master' ) . ' <small class="scm-badge">' . __( 'Archive', 'cache-master' ) . '</small>',
		'date'             => __( 'Date', 'cache-master' ) . ' <small class="scm-badge">' . __( 'Archive', 'cache-master' ) . '</small>',
		'author'           => __( 'Author', 'cache-master' ) . ' <small class="scm-badge">' . __( 'Archive', 'cache-master' ) . '</small>',
		'custom_post_type' => __( 'Custom post type', 'cache-master' ),
		'custom_taxonomy'  => __( 'Custom taxonomy', 'cache-master' ) . ' <small class="scm-badge">' . __( 'Archive', 'cache-master' ) . '</small>',
		'uncategorised'    => __( 'Uncategorised', 'cache-master' ),
	);

	if ( $get_key ) {
		return array_keys( $list );
	}

	return $list;
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

	} elseif ( 'mongo' === $type ) {
		if ( extension_loaded( 'mongodb' ) ) {
			try {
				$command = 'mongodb://127.0.0.1:27017/test';

				$mongo = new \MongoDB\Driver\Manager( $command );

				$filter = ['_id' => 'test_key',];
				$option = [];
		
				$query = new \MongoDB\Driver\Query( $filter, $option );
				$cursor = $mongo->executeQuery( 'test.cache_data', $query );
		
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
 * Get the Expert Mode code snippet.
 *
 * @return string
 */
function scm_expert_mode_code_template() {
	ob_start();

	?>
// BEGIN - Cache Master

if ( file_exists( '<?php echo SCM_PLUGIN_DIR; ?>inc/expert-mode.php' ) ) {

    include_once( '<?php echo SCM_PLUGIN_DIR; ?>inc/expert-mode.php' );

    /* BEGIN - Blog ID: <?php echo get_current_blog_id(); ?> */

    scm_run_expert_mode( array(
        'plugin_dir'        => '<?php echo rtrim( SCM_PLUGIN_DIR, '/' ); ?>',
        'plugin_upload_dir' => '<?php echo rtrim( scm_get_upload_dir(), '/' ); ?>',
        'site_url'          => '<?php echo rtrim( get_site_url(), '/' ); ?>',
        'cache_driver_type' => '<?php echo get_option( 'scm_option_driver' ); ?>',
    ) );

    /* END - Blog ID: <?php echo get_current_blog_id(); ?> */
}

// END - Cache Master
<?php

	return ob_get_clean();
}

/**
 * Check if the Expert Mode code snippet exists or not.
 *
 * @param string $string The string that must be found.
 *
 * @return array
 */
function scm_search_expert_mode_code_snippet( $string ) {
 
	$wp_config_file = ABSPATH . 'wp-config.php';

	$file    = fopen( $wp_config_file, 'r' );
	$found1  = false;
	$target1 = 'expert-mode.php';
	$found2  = false;
	$target2 = $string;

	while ( $line = fgets( $file ) ) { 
		if ( strpos( $line, $target1 ) !== false ) { 
			$found1 = true;
		}
		if ( strpos( $line, $target2 ) !== false ) { 
			$found2 = true;
		}
	}
	fclose($file);

	$result = array( $found1, $found2 );

    return $result;
}

/**
 * Check if can inject Expert Mode code block automatically.
 *
 * @return bool
 */
function scm_is_available_inject_code() {
    $result = scm_search_expert_mode_code_snippet( scm_get_upload_dir() );
    if ( ! $result[0] && ! $result[1] ) {
        if ( is_writable( ABSPATH . 'wp-config.php' ) ) {
            return true;
        }
    }
    return false;
}

/**
 * Clear all cache.
 *
 * @return int
 */
function scm_clear_all_cache() {
	$driver = scm_driver_factory( get_option( 'scm_option_driver' ) );
	$list   = scm_get_cache_type_list( true );

	$driver->clear();

	$i = 0;

	foreach ( $list as $cache_type ) {
		$dir = scm_get_stats_dir( $cache_type );

		if ( is_dir( $dir ) ) {
			foreach ( new DirectoryIterator( $dir ) as $file ) {
				if ( $file->isFile() && $file->getExtension() === 'json' ) {
					$filename = $file->getFilename();
					$key      = strstr( $filename, '.', true );

					$driver->delete( $key );
					unlink( $file->getPathname() );
					$i++;
				}
			}
		}
	}

	return $i;
}