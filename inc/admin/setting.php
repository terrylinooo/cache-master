<?php
/**
 * Cache Master - Setting page.
 *
 * @author Terry Lin
 * @link https://terryl.in/
 * @since 1.0.0
 * @version 1.3.0
 */

if ( ! defined( 'SCM_INC' ) ) {
	die;
}

add_action( 'admin_init', 'scm_settings' );

 /**
  * Add settings.
  *
  * @return void
  */
function scm_settings() {

	$register_groups = array(

		// Settings - Basic (Page 1)
		1 => array(
			'caching_status',
			'driver',
			'ttl',
			'visibility_login_user',
			'visibility_guest',
			'uninstall',
		),

		// Expert mode (Page 2)
		2 => array(
			'expert_mode_status',
		),

		// Statistics (Page 3, 4 mixed)
		3 => array(
			'statistics_status',
		),

		4 => array(
			'clear_cache',
		),

		// Benchmark (Page 5)
		5 => array(
			'benchmark_widget',
			'benchmark_footer_text',
			'benchmark_widget_display',
			'benchmark_footer_text_display',
		),

		// Settings - Perferences (Page 6)
		6 => array(
			'post_types',
			'post_homepage',
			'post_archives',
		),

		// Settings - Advanced (Page 7)
		7 => array(
			'advanced_driver_memcached',
			'advanced_driver_redis',
			'advanced_driver_mongodb',
		),

		// Settings - WooCommerce (Page 8)
		8 => array(
			'woocommerce_status',
			'woocommerce_post_types',
			'woocommerce_post_archives',
			'woocommerce_event_payment_complete',
		),

		// Settings - Exclusion (Page 9)
		9 => array(
			'exclusion_status',
			'excluded_list',
		),
	);

	foreach ( $register_groups as $index => $options ) {
		foreach ( $options as $option ) {
			register_setting( 'scm_setting_group_' . $index, 'scm_option_' . $option );
		}
	}

	$register_sections = array(

		// Settings - Basic
		array(
			'title'    => __( 'Driver', 'cache-master' ),
			'callback' => 'scm_cb_setting_section',
			'group_id' => 1,
			'settings' => array(
				array(
					'title'    => __( 'Caching Status', 'cache-master' ),
					'callback' => 'scm_cb_caching_status',
				),
				array(
					'title'    => __( 'Cache Driver', 'cache-master' ),
					'callback' => 'scm_cb_driver',
				),
				array(
					'title'    => __( 'Time to Live', 'cache-master' ),
					'callback' => 'scm_cb_ttl',
				),
			),
		),

		array(
			'title'    => __( 'Visibilty', 'cache-master' ),
			'callback' => 'scm_cb_setting_section',
			'group_id' => 1,
			'settings' => array(
				array(
					'title'    => __( 'Guests', 'cache-master' ),
					'callback' => 'scm_cb_visibility_guest',
				),
				array(
					'title'    => __( 'Logged-in Users', 'cache-master' ),
					'callback' => 'scm_cb_visibility_loggin_user',
				),
			),
		),

		array(
			'title'    => __( 'Others', 'cache-master' ),
			'callback' => 'scm_cb_setting_section',
			'group_id' => 1,
			'settings' => array(
				array(
					'title'    => __( 'Uninstall', 'cache-master' ),
					'callback' => 'scm_cb_uninstall_option',
				),
			),
		),

		// Settings - Perferences

		array(
			'title'    => __( 'Pages', 'cache-master' ),
			'callback' => 'scm_cb_setting_section',
			'group_id' => 6,
			'settings' => array(
				array(
					'title'    => __( 'Post Types', 'cache-master' ),
					'callback' => 'scm_cb_post_types',
				),
				array(
					'title'    => __( 'Homepage', 'cache-master' ),
					'callback' => 'scm_cb_post_homepage',
				),
				array(
					'title'    => __( 'Archive Pages', 'cache-master' ),
					'callback' => 'scm_cb_post_archives',
				),
			),
		),

		// Settings - Advanced
		array(
			'title'    => __( 'Driver', 'cache-master' ),
			'callback' => 'scm_cb_setting_section',
			'group_id' => 7,
			'settings' => array(
				array(
					'title'    => __( 'Redis', 'cache-master' ),
					'callback' => 'scm_cb_advanced_cache_driver_redis',
				),
				array(
					'title'    => __( 'Memcached', 'cache-master' ),
					'callback' => 'scm_cb_advanced_cache_driver_memcached',
				),
				array(
					'title'    => __( 'MongoDB', 'cache-master' ),
					'callback' => 'scm_cb_advanced_cache_driver_mongodb',
				),
			),
		),

		// Settings - WooCommerce
		array(
			'title'    => __( 'Support', 'cache-master' ),
			'callback' => 'scm_cb_setting_section',
			'group_id' => 8,
			'settings' => array(
				array(
					'title'    => __( 'Enable', 'cache-master' ),
					'callback' => 'scm_cb_option_woocommerce_status',
				),
			),
		),

		array(
			'title'    => __( 'Pages', 'cache-master' ),
			'callback' => 'scm_cb_setting_section',
			'group_id' => 8,
			'settings' => array(
				array(
					'title'    => __( 'Post Types', 'cache-master' ),
					'callback' => 'scm_cb_option_woocommerce_post_types',
				),
				array(
					'title'    => __( 'Archive Pages', 'cache-master' ),
					'callback' => 'scm_cb_option_woocommerce_post_archives',
				),
			),
		),

		array(
			'title'    => __( 'Events', 'cache-master' ),
			'callback' => 'scm_cb_setting_section',
			'group_id' => 8,
			'settings' => array(
				array(
					'title'    => __( 'Payment Complete', 'cache-master' ),
					'callback' => 'scm_cb_option_woocommerce_event_payment_complete',
				),
			),
		),

		// Settings - Exclusion
		array(
			'title'    => '',
			'callback' => 'scm_cb_setting_section',
			'group_id' => 9,
			'settings' => array(
				array(
					'title'    => __( 'Enable', 'cache-master' ),
					'callback' => 'scm_cb_option_exclusion_status',
				),
				array(
					'title'    => __( 'Excluded List', 'cache-master' ),
					'callback' => 'scm_cb_option_excluded_list',
				),
			),
		),

		// Expert mode.
		array(
			'title'    => __( 'Expert Mode', 'cache-master' ),
			'callback' => 'scm_cb_setting_section',
			'group_id' => 2,
			'settings' => array(
				array(
					'title'    => __( 'Status', 'cache-master' ),
					'callback' => 'scm_cb_expert_mode_status',
				),
			),
		),

		array(
			'title'    => '',
			'callback' => 'scm_cb_setting_section',
			'group_id' => 2,
			'settings' => array(
				array(
					'title'    => '',
					'callback' => '',
				),
			),
		),

		// Statistics
		array(
			'title'    => __( 'Statistics', 'cache-master' ),
			'callback' => 'scm_cb_setting_section',
			'group_id' => 3,
			'settings' => array(
				array(
					'title'    => __( 'Enable', 'cache-master' ),
					'callback' => 'scm_cb_statistics_status',
				),
			),
		),

		array(
			'title'    => __( 'Clear Cache', 'cache-master' ),
			'callback' => 'scm_cb_setting_section',
			'group_id' => 4,
			'settings' => array(
				array(
					'title'    => '',
					'callback' => 'scm_cb_clear_cache',
				),
			),
		),

		// Benchmark settings.
		array(
			'title'    => __( 'Widget', 'cache-master' ),
			'callback' => 'scm_cb_setting_section',
			'group_id' => 5,
			'settings' => array(
				array(
					'title'    => __( 'Enable', 'cache-master' ),
					'callback' => 'scm_cb_benchmark_widget',
				),
				array(
					'title'    => __( 'Display', 'cache-master' ),
					'callback' => 'scm_cb_benchmark_widget_display',
				),
			),
		),

		array(
			'title'    => __( 'Footer Text', 'cache-master' ),
			'callback' => 'scm_cb_setting_section',
			'group_id' => 5,
			'settings' => array(
				array(
					'title'    => __( 'Enable', 'cache-master' ),
					'callback' => 'scm_cb_benchmark_footer_text',
				),
				array(
					'title'    => __( 'Display', 'cache-master' ),
					'callback' => 'scm_cb_benchmark_footer_text_display',
				),
			),
		),
	);

	$section_id = 0;
	$setting_id = 0;

	foreach ( $register_sections as $section ) {
		$section_id++;
		add_settings_section(
			'scm_setting_section_' . $section_id,
			$section['title'],
			$section['callback'],
			'scm_setting_page_' . $section['group_id']
		);

		foreach ( $section['settings'] as $setting ) {
			$setting_id++;
			add_settings_field(
				'scm_option_id_' . $setting_id,
				$setting['title'],
				$setting['callback'],
				'scm_setting_page_' . $section['group_id'],
				'scm_setting_section_' . $section_id
			);
		}
	}
}

function scm_cb_setting_section() {
	echo __( '', 'cache-master' );
}

/**
 * Setting block - Choose a data driver for cache functionality.
 *
 * @return void
 */
function scm_cb_driver() {
	echo scm_load_view( 'option_driver' );
}

/**
 * Setting block - TTL
 *
 * @return void
 */
function scm_cb_ttl() {
	echo scm_load_view( 'option_ttl' );
}

/**
 * Setting block - Uninstalling option.
 *
 * @return void
 */
function scm_cb_uninstall_option() {
	echo scm_load_view( 'option_uninstall' );
}

/**
 * Setting block - Supported post types.
 *
 * @return void
 */
function scm_cb_post_types() {
	echo scm_load_view( 'option_post_types' );
}

/**
 * Setting block - Cacing status.
 *
 * @return void
 */
function scm_cb_caching_status() {
	echo scm_load_view( 'option_caching_status' );
}

/**
 * Setting block - Expert mode.
 *
 * @return void
 */
function scm_cb_expert_mode_status() {
	echo scm_load_view( 'option_expert_mode_status' );
}

/**
 * Setting block - Homepage
 *
 * @return void
 */
function scm_cb_post_homepage() {
	echo scm_load_view( 'option_post_homepage' );
}

/**
 * Setting block - Archives.
 *
 * @return void
 */
function scm_cb_post_archives() {
	echo scm_load_view( 'option_post_archives' );
}

/**
 * Setting block - The visibility of cache for guests
 *
 * @return void
 */
function scm_cb_visibility_guest() {
	echo scm_load_view( 'option_visibility_guest' );
}

/**
 * Setting block - The visibility of cache for logged-in users.
 *
 * @return void
 */
function scm_cb_visibility_loggin_user() {
	echo scm_load_view( 'option_visibility_login_user' );
}

/**
 * Setting block - Statistic status.
 *
 * @return void
 */
function scm_cb_statistics_status() {
	echo scm_load_view( 'option_statistics_status' );
}

/**
 * Setting block - Clear cache
 *
 * @return void
 */
function scm_cb_clear_cache() {
	echo scm_load_view( 'option_clear_cache' );
}

/**
 * Setting block - Widget
 *
 * @return void
 */
function scm_cb_benchmark_widget() {
	echo scm_load_view( 'option_benchmark_widget' );
}

/**
 * Setting block -Footer text
 *
 * @return void
 */
function scm_cb_benchmark_footer_text() {
	echo scm_load_view( 'option_benchmark_footer_text' );
}

/**
 * Setting block - Widget
 *
 * @return void
 */
function scm_cb_benchmark_widget_display() {
	echo scm_load_view( 'option_benchmark_widget_display' );
}

/**
 * Setting block -Footer text
 *
 * @return void
 */
function scm_cb_benchmark_footer_text_display() {
	echo scm_load_view( 'option_benchmark_footer_text_display' );
}

/**
 * Setting block - Redis drver advanced settings.
 *
 * @return void
 */
function scm_cb_advanced_cache_driver_redis() {
	echo scm_load_view( 'option_advanced_cache_driver_redis' );
}

/**
 * Setting block - Memcached drver advanced settings.
 *
 * @return void
 */
function scm_cb_advanced_cache_driver_memcached() {
	echo scm_load_view( 'option_advanced_cache_driver_memcached' );
}

/**
 * Setting block - MongoDB drver advanced settings.
 *
 * @return void
 */
function scm_cb_advanced_cache_driver_mongodb() {
	echo scm_load_view( 'option_advanced_cache_driver_mongodb' );
}

/**
 * Setting block - WooCommerce - Status
 *
 * @return void
 */
function scm_cb_option_woocommerce_status() {
	echo scm_load_view( 'option_woocommerce_status' );
}

/**
 * Setting block - WooCommerce - Post types.
 *
 * @return void
 */
function scm_cb_option_woocommerce_post_types() {
	echo scm_load_view( 'option_woocommerce_post_types' );
}

/**
 * Setting block - WooCommerce - Post archives.
 *
 * @return void
 */
function scm_cb_option_woocommerce_post_archives() {
	echo scm_load_view( 'option_woocommerce_post_archives' );
}

/**
 * Setting block - WooCommerce - Event - Purchase completed.
 *
 * @return void
 */
function scm_cb_option_woocommerce_event_payment_complete() {
	echo scm_load_view( 'option_woocommerce_event_payment_complete' );
}

/**
 * Setting block - Exclusion - Status
 *
 * @return void
 */
function scm_cb_option_exclusion_status() {
	echo scm_load_view( 'option_exclusion_status' );
}

/**
 * Setting block - WooCommerce - Event - Excluded list.
 *
 * @return void
 */
function scm_cb_option_excluded_list() {
	echo scm_load_view( 'option_excluded_list' );
}
