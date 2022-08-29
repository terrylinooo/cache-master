<?php
/**
 * Cache Master - Menu.
 *
 * @author Terry Lin
 * @link https://terryl.in/
 * @since 1.0.0
 * @version 1.2.1
 */

if ( ! defined( 'SCM_INC' ) ) {
	die;
}

add_action( 'admin_menu', 'scm_option' );
add_action( 'admin_enqueue_scripts', 'scm_admin_enqueue_scripts' );
add_action( 'admin_enqueue_scripts', 'scm_admin_enqueue_styles' );
add_filter( 'plugin_action_links_' . SCM_PLUGIN_NAME, 'scm_plugin_action_links', 10, 5 );
add_filter( 'plugin_row_meta', 'scm_plugin_extend_links', 10, 2 );

/**
 * Register the plugin setting page.
 *
 * @return void
 */
function scm_option() {

	add_menu_page(
		__( 'Cache Master', 'cache-master' ),
		__( 'Cache Master', 'cache-master' ),
		'manage_options',
		'cache-master-settings',
		'__return_false',
		plugins_url( 'cache-master/inc/assets/images/menu_icon.png' )
	);

	add_submenu_page(
		'cache-master-settings',
		__( 'Settings', 'cache-master' ),
		__( 'Settings', 'cache-master' ),
		'manage_options',
		'cache-master-settings',
		'scm_options_page'
	);

	add_submenu_page(
		'cache-master-settings',
		__( 'Expert Mode', 'cache-master' ),
		__( 'Expert Mode', 'cache-master' ),
		'manage_options',
		'cache-master-expert-mode',
		'scm_expert_mode_page'
	);

	add_submenu_page(
		'cache-master-settings',
		__( 'Statistics', 'cache-master' ),
		__( 'Statistics', 'cache-master' ),
		'manage_options',
		'cache-master-statistics',
		'scm_stats_page'
	);

	add_submenu_page(
		'cache-master-settings',
		__( 'About', 'cache-master' ),
		__( 'About', 'cache-master' ),
		'manage_options',
		'cache-master-about',
		'scm_about_page'
	);
}

/**
 * Output the setting page.
 *
 * @return void
 */
function scm_options_page() {
	scm_show_settings_header();
	echo scm_load_view( 'page_settings_page' );
	scm_show_settings_footer();
}

/**
 * Output the expert mode page.
 *
 * @return void
 */
function scm_expert_mode_page() {
	scm_show_settings_header();
	echo scm_load_view( 'page_expert_mode' );
	scm_show_settings_footer();
}

/**
 * Output the stats page.
 *
 * @return void
 */
function scm_stats_page() {
	scm_show_settings_header();
	echo scm_load_view( 'page_statistics' );
	scm_show_settings_footer();
}

/**
 * Output the banchmark setting page.
 *
 * @return void
 */
function scm_benchmark_settings_page() {
	scm_show_settings_header();
	echo scm_load_view( 'page_benchmark_settings' );
	scm_show_settings_footer();
}

/**
 * Output the about page.
 *
 * @return void
 */
function scm_about_page() {
	scm_show_settings_header();
	echo scm_load_view( 'page_about' );
	scm_show_settings_footer();
}

/**
 * Filters the action links displayed for each plugin in the Network Admin Plugins list table.
 *
 * @param array  $links Original links.
 * @param string $file  File position.
 *
 * @return array Combined links.
 */
function scm_plugin_action_links( $links, $file ) {
	if ( ! current_user_can( 'manage_options' ) ) {
		return $links;
	}

	if ( SCM_PLUGIN_NAME === $file ) {
		$links[] = '<a href="' . admin_url( 'admin.php?page=cache-master-settings' ) . '">' . __( 'Settings', 'cache-master' ) . '</a>';
		return $links;
	}
}

/**
 * Add links to plugin meta information on plugin list page.
 *
 * @param array  $links Original links.
 * @param string $file  File position.
 *
 * @return array Combined links.
 */
function scm_plugin_extend_links( $links, $file ) {
	if ( ! current_user_can( 'install_plugins' ) ) {
		return $links;
	}

	if ( SCM_PLUGIN_NAME === $file ) {
		$links[] = '<a href="https://github.com/terrylinooo/cache-master" target="_blank">' . __( 'Source code', 'cache-master' ) . '</a>';
	}
	return $links;
}

/**
 * Load specfic CSS file for the Cache Master setting page.
 */
function scm_admin_enqueue_styles( $hook_suffix ) {

	if ( false === strpos( $hook_suffix, 'cache-master' ) ) {
		return;
	}
	wp_enqueue_style( 'custom-wp-admin-css', SCM_PLUGIN_URL . 'inc/assets/css/admin-style.css', array(), SCM_PLUGIN_VERSION, 'all' );
	wp_enqueue_style( 'code-highlight', SCM_PLUGIN_URL . 'inc/assets/highlight/default.css', array(), SCM_PLUGIN_VERSION, 'all' );
	wp_enqueue_style( 'wp-jquery-ui-dialog' );
}

/**
 * Register JS files.
 */
function scm_admin_enqueue_scripts( $hook_suffix ) {

	if ( false === strpos( $hook_suffix, 'cache-master' ) ) {
		return;
	}
	wp_enqueue_script( 'code-highlight', SCM_PLUGIN_URL . 'inc/assets/highlight/highlight.pack.js', array(), SCM_PLUGIN_VERSION, 'all' );
	wp_enqueue_script( 'jquery-ui-dialog' );
}

/**
 * Show header on setting pages.
 *
 * @return void
 */
function scm_show_settings_header() {
	$git_url_core = 'https://github.com/terrylinooo/simple-cache';
	$git_url_plugin = 'https://github.com/terrylinooo/cache-master';

	echo '<div class="cache-master-info-bar">';
	echo '	<div class="logo-info"><img src="' . SCM_PLUGIN_URL . 'inc/assets/images/logo.png" class="cache-master-logo"></div>';
	echo '	<div class="version-info">';
	echo '    Core: <a href="' . $git_url_core . '" target="_blank">' . SCM_CORE_VERSION . '</a>  ';
	echo '    Plugin: <a href="' . $git_url_plugin . '" target="_blank">' . SCM_PLUGIN_VERSION . '</a>  ';
	echo '  </div>';
	echo '</div>';
	echo '<div class="wrap scm-wrap">';

	if ( '' === get_option( 'permalink_structure' ) ) {
		$url_html = '<a href="' . get_bloginfo( 'url' ) . '/wp-admin/options-permalink.php">' . __( 'Permalink Setting', 'seo-search-permalink' ) . '</a>';
		echo '<div class="notice notice-error is-dismissible"><p>';
		echo __( 'Cache Master supports only static URL structure.', 'cache-master' ) . ' ';
		printf( __( 'You have to go to %s page and change the permalink settings.', 'cache-master' ), $url_html );
		echo '</p></div>';
	}
}

/**
 * Show footer on setting pages.
 *
 * @return void
 */
function scm_show_settings_footer() {
	echo '</div>';
}
