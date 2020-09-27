<?php
/**
 * Plugin Name: Cache Master
 * Plugin URI:  https://github.com/terrylinooo/cache-master
 * Description: A wordpress cache plugin.
 * Version:     1.0.0
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
define( 'SCM_PLUGIN_VERSION', '1.0.0' );
define( 'SCM_PLUGIN_TEXT_DOMAIN', 'cache-master' );

/**
 * Start to run SCM plugin cores.
 */

// Support WordPress version 4.7 and below.
if ( ! function_exists( 'wp_doing_ajax' ) ) {
	function wp_doing_ajax() {
		return false;
	}
}

// The minimum supported version of PHP.
if ( version_compare( phpversion(), '7.1.0', '>=' ) ) {

	if ( ! wp_doing_ajax() ) {

		// PHP composer autoloader.
		require_once SCM_PLUGIN_DIR . 'vendor/autoload.php';

		if ( is_admin() ) {
			require_once SCM_PLUGIN_DIR . 'inc/admin/register.php';
			require_once SCM_PLUGIN_DIR . 'inc/admin/setting.php';
			require_once SCM_PLUGIN_DIR . 'inc/admin/menu.php';
		} else {
			// Todo
		}
	}

} else {
	/**
	 * Prompt a warning message while PHP version does not meet the minimum requirement.
	 * And, nothing to do.
	 */
	function scm_plugin_warning() {
		?>
			<div class="notice notice-error is-dismissible">
				<p>
					<?php printf( __( 'The minimum required PHP version for Cache Master Plugin is PHP <strong>7.1.0</strong>, and yours is <strong>%1s</strong>.', 'cache-master' ), phpversion() ) ?> <br>
					<?php echo __( 'Please remove WP Githuber MD or upgrade your PHP version.', 'cache-master' ); ?>
				</p>
			</div>
		<?php
	}

	add_action( 'admin_notices', 'scm_plugin_warning' );
}
