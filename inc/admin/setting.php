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

	register_setting( 'scm_setting_group_1', 'scm_option_caching_status' );
	register_setting( 'scm_setting_group_1', 'scm_option_driver' );
	register_setting( 'scm_setting_group_1', 'scm_option_ttl' );
	register_setting( 'scm_setting_group_1', 'scm_option_post_types' );
	register_setting( 'scm_setting_group_1', 'scm_option_uninstall' );
	register_setting( 'scm_setting_group_1', 'scm_option_post_homepage' );
	register_setting( 'scm_setting_group_1', 'scm_option_post_archives' );
	register_setting( 'scm_setting_group_1', 'scm_option_visibility_login_user' );
	register_setting( 'scm_setting_group_1', 'scm_option_visibility_guest' );
	register_setting( 'scm_setting_group_2', 'scm_option_expert_mode_status' );

	// Options page.

	add_settings_section(
		'scm_setting_section_1',
		__( 'Driver', 'cache-master' ),
		'scm_cb_setting_section',
		'scm_setting_page_1'
	);

	add_settings_section(
		'scm_setting_section_5',
		__( 'Visibilty', 'cache-master' ),
		'scm_cb_setting_section',
		'scm_setting_page_1'
	);

	add_settings_section(
		'scm_setting_section_2',
		__( 'Preferences', 'cache-master' ),
		'scm_cb_setting_section',
		'scm_setting_page_1'
	);

	add_settings_section(
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
		'scm_option_id_4',
		__( 'Post Types', 'cache-master' ),
		'scm_cb_post_types',
		'scm_setting_page_1',
		'scm_setting_section_2'
	);

	add_settings_field(
		'scm_option_id_7',
		__( 'Homepage', 'cache-master' ),
		'scm_cb_post_homepage',
		'scm_setting_page_1',
		'scm_setting_section_2'
	);

	add_settings_field(
		'scm_option_id_8',
		__( 'Archive Pages', 'cache-master' ),
		'scm_cb_post_archives',
		'scm_setting_page_1',
		'scm_setting_section_2'
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

	// Expert mode.

	add_settings_section(
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