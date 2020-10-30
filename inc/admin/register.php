<?php
/**
 * Cache Master - Activating plugin.
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
 * Assign default setting values while activating this plugin.
 *
 * @return void
 */
function scm_activation() {

	$post_types = array(
		'home' => 'yes',
		'post' => 'yes',
		'page' => 'yes',
	);

	$post_archives = array(
		'category' => 'yes',
		'tag'      => 'yes',
		'date'     => 'yes',
		'author'   => 'yes',
	);

	/**
	 * Support to WooCommerce post types and taxonomies.
	 *
	 * @see https://docs.woocommerce.com/document/installed-taxonomies-post-types/
	 */
	$woocommerce_post_types = array(
		'product' => 'no',
		//'shop_order'  => 'no',
		//'shop_coupon' => 'no',
	);

	$woocommerce_taxonomies = array(
		'product_tag' => 'no',
		'product_cat' => 'no',
		//'product_variation'  => 'no',
		//'product_visibility' => 'no',
		//'shop_order_status'  => 'no',
		//'shop_order_refund'  => 'no',
	);

	$options = array(
		'driver'                             => 'file',
		'ttl'                                => '86400',
		'uninstall'                          => 'yes',
		'caching_status'                     => 'disable',
		'expert_mode_status'                 => 'disable',
		'post_homepage'                      => 'yes',
		'visibility_login_user'              => 'no',
		'visibility_guest'                   => 'yes',
		'statistics_status'                  => 'disable',
		'clear_cache'                        => 'no',
		'benchmark_widget'                   => 'no',
		'benchmark_footer_text'              => 'no',
		'benchmark_widget_display'           => 'both',
		'benchmark_footer_text_display'      => 'text',
		'excluded_list'                      => '',
		'excluded_list_filtered'             => '',
		'excluded_get_variables'             => '',
		'excluded_post_variables'            => '',
		'excluded_cookie_variables'          => '',
		'advanced_driver_memcached'          => array(),
		'advanced_driver_redis'              => array(),
		'advanced_driver_mongodb'            => array(),
		'html_debug_comment'                 => 'yes',
		'post_types'                         => $post_types,
		'post_archives'                      => $post_archives,
		'woocommerce_status'                 => 'no',
		'woocommerce_post_types'             => $woocommerce_post_types,
		'woocommerce_taxonomies'             => $woocommerce_taxonomies,
		'woocommerce_event_payment_complete' => 'no',
	);

	foreach ( $options as $key => $value ) {
		add_option( 'scm_option_' . $key, $value );
	}

	scm_setup_security_files();
}

/**
 * Protect the directory from browsing.
 * This function will create an index.html and .htaccess in the plugin's directory.
 *
 * @return void
 */
function scm_setup_security_files() {

	scm_set_blog_id();

	update_option( 'scm_last_reset_time', time() );
	update_option( 'scm_version', SCM_PLUGIN_VERSION );

	// Add default setting. Only execute this action at the first time activation.
	if ( false === scm_is_dir_hash() ) {
		update_option( 'scm_dir_hash', scm_get_dir_hash() );
	}

	if ( ! file_exists( scm_get_upload_dir() ) ) {

		wp_mkdir_p( scm_get_upload_dir() );

		$files = array(
			array(
				'base'    => WP_CONTENT_DIR . '/uploads/' . SCM_PLUGIN_TEXT_DOMAIN,
				'file'    => 'index.html',
				'content' => '',
			),
			array(
				'base'    => WP_CONTENT_DIR . '/uploads/' . SCM_PLUGIN_TEXT_DOMAIN,
				'file'    => '.htaccess',
				'content' => 'deny from all',
			),
		);

		foreach ( $files as $file ) {
			if (
				wp_mkdir_p( $file['base'] ) && 
				! file_exists( trailingslashit( $file['base'] ) . $file['file'] ) 
			) {
				@file_put_contents( trailingslashit( $file['base'] ) . $file['file'], $file['content'] );
			}
		}
	}
}

/**
 * Deactivation.
 *
 * @return void
 */
function scm_deactivation() {

	$option_uninstall = get_option( 'scm_option_uninstall' );

	if ( 'yes' === $option_uninstall ) {

		$options = array(
			'driver',
			'ttl',
			'uninstall',
			'caching_status',
			'expert_mode_status',
			'post_homepage',
			'visibility_login_user',
			'visibility_guest',
			'statistics_status',
			'clear_cache',
			'benchmark_widget',
			'benchmark_footer_text',
			'benchmark_widget_display',
			'benchmark_footer_text_display',
			'excluded_list',
			'excluded_list_filtered',
			'excluded_get_vars',
			'excluded_post_vars',
			'excluded_cookie_vars',
			'advanced_driver_memcached',
			'advanced_driver_redis',
			'advanced_driver_mongodb',
			'html_debug_comment',
			'post_types',
			'post_archives',
			'woocommerce_status',
			'woocommerce_post_types',
			'woocommerce_taxonomies',
			'woocommerce_event_payment_complete',
		);

		foreach ( $options as $option ) {
			delete_option( 'scm_option_' . $option );
		}

		$dir = WP_CONTENT_DIR . '/uploads/cache-master';

		if ( is_dir( $dir ) ) {
			$it = new RecursiveDirectoryIterator( $dir, RecursiveDirectoryIterator::SKIP_DOTS );
			$files = new RecursiveIteratorIterator( $it, RecursiveIteratorIterator::CHILD_FIRST );

			foreach ( $files as $file ) {
				if ( $file->isDir() ){
					rmdir( $file->getRealPath() );
				} else {
					unlink( $file->getRealPath() );
				}
			}
			unset( $it, $files );

			rmdir( $dir );
		}
	}
}