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
	$archive_note     = ' <small class="scm-badge">' . __( 'Archive', 'cache-master' ) . '</small>';
	$woocommerce_note = ' <small class="scm-badge">' . __( 'WooCommerce', 'cache-master' ) . '</small>';

	$list = array(
		'homepage'         => __( 'Homepage', 'cache-master' ),
		'post'             => __( 'Post', 'cache-master' ),
		'page'             => __( 'Page', 'cache-master' ),
		'category'         => __( 'Category', 'cache-master' )         . $archive_note,
		'tag'              => __( 'Tag', 'cache-master' )              . $archive_note,
		'date'             => __( 'Date', 'cache-master' )             . $archive_note,
		'author'           => __( 'Author', 'cache-master' )           . $archive_note,
		'product'          => __( 'Product', 'cache-master' )          . $woocommerce_note,
		'product_tag'      => __( 'Product tag', 'cache-master' )      . $woocommerce_note . $archive_note,
		'product_cat'      => __( 'Product category', 'cache-master' ) . $woocommerce_note . $archive_note,
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

	$advanced_settings = array();

	switch ( $type ) {
		case 'mysql':
			$setting = array(
				'host'    => DB_HOST,
				'dbname'  => DB_NAME,
				'user'    => DB_USER,
				'pass'    => DB_PASSWORD,
				'charset' => DB_CHARSET,
			);
			break;

		case 'file':
		case 'sqlite':
			$setting = array(
				'storage' => scm_get_upload_dir() . '/' . $type . '_driver',
			);
			break;

		case 'redis':
			$setting = array(
				'host' => '127.0.0.1',
				'port' =>  6379,
			);

			$advanced_settings = get_option( 'scm_option_advanced_driver_redis' );
			break;

		case 'mongo':
			$setting = array(
				'host' => '127.0.0.1',
				'port' =>  27017,
			);

			$advanced_settings = get_option( 'scm_option_advanced_driver_mongodb' );
			break;

		case 'memcache':
		case 'memcached':
			$setting = array(
				'host' => '127.0.0.1',
				'port' =>  11211,
			);

			$advanced_settings = get_option( 'scm_option_advanced_driver_memcached' );
			break;

		case 'apc':
		case 'apcu':
		case 'wincache':
			$setting = array();
			break;
	}

	if ( ! empty( $advanced_settings ) ) {
		$setting = $advanced_settings;

		foreach ( $setting as $k => $v ) {
			if ( is_numeric( $v ) ) {
				$setting[ $k ] = (int) $v;
			}
		}
	}

	try {
		$driver = new \Shieldon\SimpleCache\Cache( $type, $setting );
		$driver->set( 'foo', 'bar', 300 );
		if ( 'bar' === $driver->get( 'foo' ) ) {
			$driver->delete( 'foo' );
			return true;
		}
	} catch( \Exception $e ) {}

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
 * Check if PHP code for Expert Mode is ready or not.
 *
 * @return bool
 */
function scm_is_expert_mode_code_ready() {
    $result = scm_search_expert_mode_code_snippet( scm_get_upload_dir() );
    if ( $result[0] && $result[1] ) {
        return true;
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

/**
 * Save the settings into a JSON file.
 *
 * @param array $settings The setting.
 *
 * @return void
 */
function scm_update_config( $setting ) {

	$config  = get_option( 'scm_config', array() );
	$default = scm_get_default_config();

	foreach ( $default as $key => $value ) {
		if ( isset( $setting[ $key ] ) ) {
			$config[ $key ] = $setting[ $key ];
		}

		if ( ! isset( $config[ $key ] ) ) {
			$config[ $key ] = $value;
		}
	}

	if ( empty( $config['site_url'] ) ) {
		$config['site_url'] = rtrim( get_site_url(), '/' );
	}

	update_option( 'scm_config', $config );

	$file = scm_get_config_path();
	$content = json_encode( $config, JSON_PRETTY_PRINT );

    @file_put_contents( $file, $content );
}