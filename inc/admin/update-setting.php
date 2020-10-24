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

scm_check_permalink_structure();

// Make changes on those setting options will trigger its action function.
$register_general_action = array(
	'scm_option_driver',
	'scm_option_expert_mode_status',
	'scm_option_clear_cache',
	'scm_option_exclusion_status',
	'scm_option_excluded_list',
);

foreach ( $register_general_action as $option ) {
	add_action( 'update_option_' . $option, 'scm_update_' . $option );
}

// Make changes on those setting options will clear all cache.
$register_clear_cache_action = array(
	'scm_option_caching_status',
	'scm_option_post_homepage',
	'scm_option_post_types',
	'scm_option_post_archives',
	'scm_option_benchmark_widget',
	'scm_option_benchmark_widget_display',
	'scm_option_benchmark_footer_text',
	'scm_option_benchmark_footer_text_display',
	'scm_option_woocommerce_status',
	'scm_option_woocommerce_post_archives',
	'scm_option_woocommerce_post_types',
	'scm_option_woocommerce_status',
);

foreach ( $register_clear_cache_action as $option ) {
	// `scm_clear_all_cache` is defined in functions.php
	add_action( 'update_option_' . $option, 'scm_clear_all_cache' );
}

/**
 * Rebuild data schema.
 *
 * @return void
 */
function scm_update_scm_option_driver() {
	$driver_type = get_option( 'scm_option_driver' );

	if ( ! scm_test_driver( $driver_type ) ) {
		update_option( 'scm_option_driver', 'file' );

		// Road back to File driver if the option is not available.
		$driver_type = 'file';
	}

	$driver = scm_driver_factory( $driver_type );
	$driver->rebuild();
}

/**
 * Check permalink structure because only static URL structure is supported.
 *
 * @return void
 */
function scm_check_permalink_structure() {
	if ( '' === get_option( 'permalink_structure') ) {
		update_option( 'option_caching_status', 'disable' );
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
 * Perform clearing cache by specific option.
 *
 * @return void
 */
function scm_update_scm_option_clear_cache() {
	$cache_type = get_option( 'scm_option_clear_cache' );
	$driver     = scm_driver_factory( get_option( 'scm_option_driver' ) );
	$list       = scm_get_cache_type_list( true );

	update_option( 'scm_option_clear_cache', '' );

	if ( 'all' === $cache_type ) {
		$driver->clear();

		foreach ( $list as $cache_type ) {
			$dir = scm_get_stats_dir( $cache_type );

			if ( is_dir( $dir ) ) {
				foreach ( new DirectoryIterator( $dir ) as $file ) {
					if ( $file->isFile() && $file->getExtension() === 'json' ) {
						$filename = $file->getFilename();
						$key      = strstr( $filename, '.', true );
	
						$driver->delete( $key );
						unlink( $file->getPathname() );
					}
				}
			}
		}
	} else {
		if ( in_array( $cache_type, $list ) ) {
			$dir = scm_get_stats_dir( $cache_type );
	
			if ( is_dir( $dir ) ) {
				foreach ( new DirectoryIterator( $dir ) as $file ) {
					if ( $file->isFile() && $file->getExtension() === 'json' ) {
						$filename = $file->getFilename();
						$key      = strstr( $filename, '.', true );
	
						$driver->delete( $key );
						unlink( $file->getPathname() );
					}
				}
			}
		}
	}
}

/**
 * Delete the JSON file is the exclusion status is not "yes"
 *
 * @return void
 */
function scm_update_scm_option_exclusion_status() {
	$status = get_option( 'scm_option_exclusion_status' );

	$file = rtrim( scm_get_upload_dir(), '/' ) . '/excluded_list.json';
	
	if ( 'no' === $status ) {
		if ( file_exists( $file ) ) {
			@unlink( $file );
		}
	}

	if ( 'yes' === $status ) {
		if ( ! file_exists( $file ) ) {
			scm_update_scm_option_excluded_list();
		}
	}
}

/**
 * Create a exluded list in a JSON file that can be used in Expert Mode.
 *
 * @return void
 */
function scm_update_scm_option_excluded_list() {
	$exluded_list = get_option( 'scm_option_excluded_list' );

	$exluded_list_arr = explode( "\n", $exluded_list );
	$exluded_list_tmp = array();

	foreach ( $exluded_list_arr as $item ) {
		$str = trim( $item );
		$str = parse_url( $str, PHP_URL_PATH );

		$exluded_list_tmp[] = $str;
	}

	$content = implode( "\n", $exluded_list_tmp );

	update_option( 'scm_option_excluded_list_filtered', $content );

	$file = rtrim( scm_get_upload_dir(), '/' ) . '/excluded_list.json';

	@file_put_contents( $file, json_encode( $exluded_list_tmp ) );
}
