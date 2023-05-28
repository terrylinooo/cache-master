<?php
/**
 * Plugin Name: Cache Master
 * Plugin URI:  https://github.com/terrylinooo/cache-master
 * Description: A WordPress cache plugin.
 * Version:     2.1.3
 * Author:      Terry Lin
 * Author URI:  https://terryl.in/
 * License:     GPL 3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.txt
 * Text Domain: cache-master
 * Domain Path: /languages
 */

if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Cache Master plugin uses "scm" as the prefix on its functions.
 * Cache Master plugin uses "SCM" as the prefix on its constants.
 */

if ( ! defined( 'SCM_INC' ) ) {
	define( 'SCM_INC', true );
}

/**
 * CONSTANTS - SCM stands for Shieldon Cache Master ^_^
 *
 * SCM_PLUGIN_NAME          : Plugin's name.
 * SCM_PLUGIN_DIR           : The absolute path of the SCM plugin directory.
 * SCM_PLUGIN_URL           : The URL of the SCM plugin directory.
 * SCM_PLUGIN_PATH          : The absolute path of the SCM plugin launcher.
 * SCM_PLUGIN_LANGUAGE_PACK : Translation Language pack.
 * SCM_PLUGIN_VERSION       : SCM plugin version number
 * SCM_PLUGIN_TEXT_DOMAIN   : SCM plugin text domain
 *
 * Expected values:
 *
 * SCM_PLUGIN_DIR           : {absolute_path}/wp-content/plugins/cache-master/
 * SCM_PLUGIN_URL           : {protocal}://{domain_name}/wp-content/plugins/cache-master/
 * SCM_PLUGIN_PATH          : {absolute_path}/wp-content/plugins/cache-master/cache-master.php
 * SCM_PLUGIN_LANGUAGE_PACK : cache-master/languages
 */

define( 'SCM_PLUGIN_NAME', plugin_basename( __FILE__ ) );
define( 'SCM_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'SCM_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'SCM_PLUGIN_PATH', __FILE__ );
define( 'SCM_PLUGIN_LANGUAGE_PACK', dirname( plugin_basename( __FILE__ ) ) . '/languages' );
define( 'SCM_PLUGIN_VERSION', '2.1.3' );
define( 'SCM_CORE_VERSION', '1.3.2' );
define( 'SCM_PLUGIN_TEXT_DOMAIN', 'cache-master' );

/**
 * Start to run SCM plugin cores.
 */

// The minimum supported version of PHP.
if ( version_compare( phpversion(), '7.1.0', '>=' ) ) {

	// This section is for unit testing.
	if ( defined( 'SCM_PLUGIN_UNIT_TEST' ) ) {
		$required_files = array(
			'register',
			'setting',
			'menu',
			'update-setting',
			'update-post',
			'functions',
			'admin-bar',
			'ajax-action',
			'update-woocommerce',
			'widgets',
		);

		require_once SCM_PLUGIN_DIR . 'inc/helpers.php';
		require_once SCM_PLUGIN_DIR . 'vendor/autoload.php';
		require_once SCM_PLUGIN_DIR . 'inc/autoload.php';

		foreach ( $required_files as $file ) {
			require_once SCM_PLUGIN_DIR . 'inc/admin/' . $file . '.php';
		}

		register_activation_hook( __FILE__, 'scm_activation' );
		register_deactivation_hook( __FILE__, 'scm_deactivation' );

		scm_load_textdomain();

		$cm = new Cache_Master();
		$cm->init();

	} else {

		// No need to load Cache Master's files when AJAX calls.
		if ( ! wp_doing_ajax() ) {

			require_once SCM_PLUGIN_DIR . 'inc/helpers.php';
			require_once SCM_PLUGIN_DIR . 'vendor/autoload.php';

			register_activation_hook( __FILE__, 'scm_activation' );
			register_deactivation_hook( __FILE__, 'scm_deactivation' );

			scm_load_textdomain();

			if ( is_admin() || ( defined( 'WP_CLI' ) && WP_CLI ) ) {

				$required_files = array(
					'register',       // Event: activate and uninstall plugin.
					'setting',        // Plugin settings.
					'menu',           // Display menu link and render setting page.
					'update-setting', // Event: update settings.
					'update-post',    // Event: update posts.
					'functions',      // Helper functions used in admin scope.
					'admin-bar',      // Add a "Clear Cache" button in admin bar.
				);

				if ( 'yes' === get_option( 'scm_option_woocommerce_status' ) ) {
					$required_files[] = 'update-woocommerce';
				}

				foreach ( $required_files as $file ) {
					require_once SCM_PLUGIN_DIR . 'inc/admin/' . $file . '.php';
				}
			} else {

				require_once SCM_PLUGIN_DIR . 'inc/autoload.php';
				$cm = new Cache_Master();
				$cm->init();
			}
		} else {
			if ( is_admin() ) {
				require_once SCM_PLUGIN_DIR . 'inc/admin/ajax-action.php';
			}
		}
	}
}

/**
 * Cache Master is open sourced at:
 * https://github.com/terrylinooo/cache-master
 *
 * If you have found any bug or have any suggestion, please let me know.
 */
