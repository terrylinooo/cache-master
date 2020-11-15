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
			'html_debug_comment',
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
			'advanced_driver_memcached_connection_type',
			'advanced_driver_redis_connection_type',
			'advanced_driver_mongodb_connection_type',
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
			'excluded_get_vars',
			'excluded_post_vars',
			'excluded_cookie_vars',
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
					'callback' => function() {
						echo scm_load_view( 'option_caching_status' );
					},
				),
				array(
					'title'    => __( 'Cache Driver', 'cache-master' ),
					'callback' => function() {
						echo scm_load_view( 'option_driver' );
					},
				),
				array(
					'title'    => __( 'Time to Live', 'cache-master' ),
					'callback' => function() {
						echo scm_load_view( 'option_ttl' );
					},
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
					'callback' => function() {
						echo scm_load_view( 'option_visibility_guest' );
					},
				),
				array(
					'title'    => __( 'Logged-in Users', 'cache-master' ),
					'callback' => function() {
						echo scm_load_view( 'option_visibility_login_user' );
					},
				),
			),
		),

		array(
			'title'    => __( 'Others', 'cache-master' ),
			'callback' => 'scm_cb_setting_section',
			'group_id' => 1,
			'settings' => array(
				array(
					'title'    => __( 'Debug Comment', 'cache-master' ),
					'callback' => function() {
						echo scm_load_view( 'option_html_debug_comment' );
					},
				),
				array(
					'title'    => __( 'Uninstall', 'cache-master' ),
					'callback' => function() {
						echo scm_load_view( 'option_uninstall' );
					},
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
					'callback' => function() {
						echo scm_load_view( 'option_post_types' );
					},
				),
				array(
					'title'    => __( 'Homepage', 'cache-master' ),
					'callback' => function() {
						echo scm_load_view( 'option_post_homepage' );
					},
				),
				array(
					'title'    => __( 'Archive Pages', 'cache-master' ),
					'callback' => function() {
						echo scm_load_view( 'option_post_archives' );
					},
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
					'callback' => function() {
						echo scm_load_view( 'option_advanced_cache_driver_redis' );
					},
				),
				array(
					'title'    => __( 'Memcached', 'cache-master' ),
					'callback' => function() {
						echo scm_load_view( 'option_advanced_cache_driver_memcached' );
					},
				),
				array(
					'title'    => __( 'MongoDB', 'cache-master' ),
					'callback' => function() {
						echo scm_load_view( 'option_advanced_cache_driver_mongodb' );
					},
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
					'callback' => function() {
						echo scm_load_view( 'option_woocommerce_status' );
					},
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
					'callback' => function() {
						echo scm_load_view( 'option_woocommerce_post_types' );
					},
				),
				array(
					'title'    => __( 'Archive Pages', 'cache-master' ),
					'callback' => function() {
						echo scm_load_view( 'option_woocommerce_post_archives' );
					},
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
					'callback' => function() {
						echo scm_load_view( 'option_woocommerce_event_payment_complete' );
					},
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
					'callback' => function() {
						echo scm_load_view( 'option_exclusion_status' );
					},
				),
				array(
					'title'    => __( 'Excluded URL Path List', 'cache-master' ),
					'callback' => function() {
						echo scm_load_view( 'option_excluded_list' );
					},
				),
				array(
					'title'    => __( 'Excluded $_GET Variables', 'cache-master' ),
					'callback' => function() {
						echo scm_load_view( 'option_excluded_get_vars' );
					},
				),
				array(
					'title'    => __( 'Excluded $_POST Variables', 'cache-master' ),
					'callback' => function() {
						echo scm_load_view( 'option_excluded_post_vars' );
					},
				),
				array(
					'title'    => __( 'Excluded $_COOKIE Variables', 'cache-master' ),
					'callback' => function() {
						echo scm_load_view( 'option_excluded_cookie_vars' );
					},
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
					'callback' => function() {
						echo scm_load_view( 'option_expert_mode_status' );
					},
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
					'callback' => function() {
						echo scm_load_view( 'option_statistics_status' );
					},
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
					'callback' => function() {
						echo scm_load_view( 'option_clear_cache' );
					},
				),
			),
		),

		// Benchmark settings.
		array(
			'title'    => __( 'Footer Text', 'cache-master' ),
			'callback' => 'scm_cb_setting_section',
			'group_id' => 5,
			'settings' => array(
				array(
					'title'    => __( 'Enable', 'cache-master' ),
					'callback' => function() {
						echo scm_load_view( 'option_benchmark_footer_text' );
					},
				),
				array(
					'title'    => __( 'Display', 'cache-master' ),
					'callback' => function() {
						echo scm_load_view( 'option_benchmark_footer_text_display' );
					},
				),
			),
		),

		array(
			'title'    => __( 'Widget', 'cache-master' ),
			'callback' => 'scm_cb_setting_section',
			'group_id' => 5,
			'settings' => array(
				array(
					'title'    => __( 'Enable', 'cache-master' ),
					'callback' => function() {
						echo scm_load_view( 'option_benchmark_widget' );
					},
				),
				array(
					'title'    => __( 'Display', 'cache-master' ),
					'callback' => function() {
						echo scm_load_view( 'option_benchmark_widget_display' );
					},
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
