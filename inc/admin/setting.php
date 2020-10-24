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
  * Page ID count: 4
  * Section ID count: 12
  * Option ID count: 16
  *
  * @return void
  */
function scm_settings() {

	// Settings - Basic (Page 1)
	register_setting( 'scm_setting_group_1', 'scm_option_caching_status' );
	register_setting( 'scm_setting_group_1', 'scm_option_driver' );
	register_setting( 'scm_setting_group_1', 'scm_option_ttl' );
	register_setting( 'scm_setting_group_1', 'scm_option_visibility_login_user' );
	register_setting( 'scm_setting_group_1', 'scm_option_visibility_guest' );
	register_setting( 'scm_setting_group_1', 'scm_option_uninstall' );

	// Settings - Perferences (Page 6)
	register_setting( 'scm_setting_group_6', 'scm_option_post_types' );
	register_setting( 'scm_setting_group_6', 'scm_option_post_homepage' );
	register_setting( 'scm_setting_group_6', 'scm_option_post_archives' );

	// Settings - Advanced (Page 7)
	register_setting( 'scm_setting_group_7', 'scm_option_advanced_driver_memcached' );
	register_setting( 'scm_setting_group_7', 'scm_option_advanced_driver_redis' );
	register_setting( 'scm_setting_group_7', 'scm_option_advanced_driver_mongodb' );

	// Settings - WooCommerce (Page 8)
	register_setting( 'scm_setting_group_8', 'scm_option_woocommerce_status' );
	register_setting( 'scm_setting_group_8', 'scm_option_woocommerce_post_types' );
	register_setting( 'scm_setting_group_8', 'scm_option_woocommerce_post_archives' );
	register_setting( 'scm_setting_group_8', 'scm_option_woocommerce_event_payment_complete' );

	// Settings - Exclusion (Page 9)
	register_setting( 'scm_setting_group_9', 'scm_option_exclusion_status' );
	register_setting( 'scm_setting_group_9', 'scm_option_excluded_list' );

	// Expert mode (Page 2)
	register_setting( 'scm_setting_group_2', 'scm_option_expert_mode_status' );

	// Statistics (Page 3, 4 mixed)
	register_setting( 'scm_setting_group_3', 'scm_option_statistics_status' );
	register_setting( 'scm_setting_group_4', 'scm_option_clear_cache' );

	// Benchmark (Page 5)
	register_setting( 'scm_setting_group_5', 'scm_option_benchmark_widget' );
	register_setting( 'scm_setting_group_5', 'scm_option_benchmark_footer_text' );
	register_setting( 'scm_setting_group_5', 'scm_option_benchmark_widget_display' );
	register_setting( 'scm_setting_group_5', 'scm_option_benchmark_footer_text_display' );

	// Options page

	// Settings - Basic

	add_settings_section( // Section 1
		'scm_setting_section_1',
		__( 'Driver', 'cache-master' ),
		'scm_cb_setting_section',
		'scm_setting_page_1'
	);

	add_settings_section( // Section 5
		'scm_setting_section_5',
		__( 'Visibilty', 'cache-master' ),
		'scm_cb_setting_section',
		'scm_setting_page_1'
	);

	add_settings_section( // Section 3
		'scm_setting_section_3',
		__( 'Others', 'cache-master' ),
		'scm_cb_setting_section',
		'scm_setting_page_1'
	);

	add_settings_field(
		'scm_option_id_5',
		__( 'Caching Status', 'cache-master' ),
		'scm_cb_caching_status',
		'scm_setting_page_1',
		'scm_setting_section_1'
	);

	add_settings_field(
		'scm_option_id_1',
		__( 'Cache Driver', 'cache-master' ),
		'scm_cb_driver',
		'scm_setting_page_1',
		'scm_setting_section_1'
	);

	add_settings_field(
		'scm_option_id_2',
		__( 'Time to Live', 'cache-master' ),
		'scm_cb_ttl',
		'scm_setting_page_1',
		'scm_setting_section_1'
	);

	add_settings_field(
		'scm_option_id_3',
		__( 'Uninstall', 'cache-master' ),
		'scm_cb_uninstall_option',
		'scm_setting_page_1',
		'scm_setting_section_3'
	);

	add_settings_field(
		'scm_option_id_9',
		__( 'Guests', 'cache-master' ),
		'scm_cb_visibility_guest',
		'scm_setting_page_1',
		'scm_setting_section_5'
	);

	add_settings_field(
		'scm_option_id_10',
		__( 'Logged-in Users', 'cache-master' ),
		'scm_cb_visibility_loggin_user',
		'scm_setting_page_1',
		'scm_setting_section_5'
	);

	// Settings - Perferences

	add_settings_section( // Section 2
		'scm_setting_section_2',
		__( 'Pages', 'cache-master' ),
		'scm_cb_setting_section',
		'scm_setting_page_6'
	);

	add_settings_field(
		'scm_option_id_4',
		__( 'Post Types', 'cache-master' ),
		'scm_cb_post_types',
		'scm_setting_page_6',
		'scm_setting_section_2'
	);

	add_settings_field(
		'scm_option_id_7',
		__( 'Homepage', 'cache-master' ),
		'scm_cb_post_homepage',
		'scm_setting_page_6',
		'scm_setting_section_2'
	);

	add_settings_field(
		'scm_option_id_8',
		__( 'Archive Pages', 'cache-master' ),
		'scm_cb_post_archives',
		'scm_setting_page_6',
		'scm_setting_section_2'
	);

	// Settings - Advanced

	add_settings_section( // Section 10
		'scm_setting_section_10',
		__( 'Driver', 'cache-master' ),
		'scm_cb_setting_section',
		'scm_setting_page_7'
	);

	add_settings_field(
		'scm_option_id_17',
		__( 'Redis', 'cache-master' ),
		'scm_cb_advanced_cache_driver_redis',
		'scm_setting_page_7',
		'scm_setting_section_10'
	);

	add_settings_field(
		'scm_option_id_18',
		__( 'Memcached', 'cache-master' ),
		'scm_cb_advanced_cache_driver_memcached',
		'scm_setting_page_7',
		'scm_setting_section_10'
	);

	add_settings_field(
		'scm_option_id_19',
		__( 'MongoDB', 'cache-master' ),
		'scm_cb_advanced_cache_driver_mongodb',
		'scm_setting_page_7',
		'scm_setting_section_10'
	);

	// Settings - WooCommerce

	add_settings_section( // Section 11
		'scm_setting_section_11',
		__( 'Support', 'cache-master' ),
		'scm_cb_setting_section',
		'scm_setting_page_8'
	);

	add_settings_section( // Section 12
		'scm_setting_section_12',
		__( 'Pages', 'cache-master' ),
		'scm_cb_setting_section',
		'scm_setting_page_8'
	);

	add_settings_section( // Section 13
		'scm_setting_section_13',
		__( 'Events', 'cache-master' ),
		'scm_cb_setting_section',
		'scm_setting_page_8'
	);

	add_settings_field(
		'scm_option_id_20',
		__( 'Enable', 'cache-master' ),
		'scm_cb_option_woocommerce_status',
		'scm_setting_page_8',
		'scm_setting_section_11'
	);

	add_settings_field(
		'scm_option_id_21',
		__( 'Post Types', 'cache-master' ),
		'scm_cb_option_woocommerce_post_types',
		'scm_setting_page_8',
		'scm_setting_section_12'
	);

	add_settings_field(
		'scm_option_id_22',
		__( 'Archive Pages', 'cache-master' ),
		'scm_cb_option_woocommerce_post_archives',
		'scm_setting_page_8',
		'scm_setting_section_12'
	);

	add_settings_field(
		'scm_option_id_23',
		__( 'Payment Complete', 'cache-master' ),
		'scm_cb_option_woocommerce_event_payment_complete',
		'scm_setting_page_8',
		'scm_setting_section_13'
	);

	// Settings - Exclusion

	add_settings_section( // Section 14
		'scm_setting_section_14',
		'',
		'scm_cb_setting_section',
		'scm_setting_page_9'
	);

	add_settings_field(
		'scm_option_id_25',
		__( 'Enable', 'cache-master' ),
		'scm_cb_option_exclusion_status',
		'scm_setting_page_9',
		'scm_setting_section_14'
	);

	add_settings_field(
		'scm_option_id_26',
		__( 'Excluded List', 'cache-master' ),
		'scm_cb_option_excluded_list',
		'scm_setting_page_9',
		'scm_setting_section_14'
	);

	// Expert mode.

	add_settings_section( // Section 4
		'scm_setting_section_4',
		__( 'Expert Mode', 'cache-master' ),
		'scm_cb_setting_section',
		'scm_setting_page_2'
	);

	add_settings_field(
		'scm_option_id_6',
		__( 'Status', 'cache-master' ),
		'scm_cb_expert_mode_status',
		'scm_setting_page_2',
		'scm_setting_section_4'
	);

	// Statistics

	add_settings_section( // Section 6
		'scm_setting_section_6',
		__( 'Statistics', 'cache-master' ),
		'scm_cb_setting_section',
		'scm_setting_page_3'
	);

	add_settings_field(
		'scm_option_id_11',
		__( 'Statistics', 'cache-master' ),
		'scm_cb_statistics_status',
		'scm_setting_page_3',
		'scm_setting_section_6'
	);

	add_settings_section( // Section 7
		'scm_setting_section_7',
		__( 'Clear Cache', 'cache-master' ),
		'scm_cb_setting_section',
		'scm_setting_page_4'
	);

	add_settings_field(
		'scm_option_id_16',
		'',
		'scm_cb_clear_cache',
		'scm_setting_page_4',
		'scm_setting_section_7'
	);

	// Benchmark settings.

	add_settings_section( // Section 8
		'scm_setting_section_8',
		__( 'Widget', 'cache-master' ),
		'scm_cb_setting_section',
		'scm_setting_page_5'
	);

	add_settings_section( // Section 9
		'scm_setting_section_9',
		__( 'Footer Text', 'cache-master' ),
		'scm_cb_setting_section',
		'scm_setting_page_5'
	);

	add_settings_field(
		'scm_option_id_12',
		__( 'Enable', 'cache-master' ),
		'scm_cb_benchmark_widget',
		'scm_setting_page_5',
		'scm_setting_section_8'
	);

	add_settings_field(
		'scm_option_id_14',
		__( 'Display', 'cache-master' ),
		'scm_cb_benchmark_widget_display',
		'scm_setting_page_5',
		'scm_setting_section_8'
	);

	add_settings_field(
		'scm_option_id_13',
		__( 'Enable', 'cache-master' ),
		'scm_cb_benchmark_footer_text',
		'scm_setting_page_5',
		'scm_setting_section_9'
	);

	add_settings_field(
		'scm_option_id_15',
		__( 'Display', 'cache-master' ),
		'scm_cb_benchmark_footer_text_display',
		'scm_setting_page_5',
		'scm_setting_section_9'
	);

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
