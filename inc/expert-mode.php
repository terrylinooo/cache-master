<?php

/**
 * Cache Master helper functions.
 *
 * @package   Cache Master
 * @author    Terry Lin <terrylinooo>
 * @license   GPLv3 (or later)
 * @link      https://terryl.in
 * @copyright 2020 Terry Lin
 * @since 2.1.0
 * @version 2.1.3
 */

if (!defined('ABSPATH')) {
	die;
}

define('SCM_INC', true);

/**
 * Use the "Expert Mode", see explanation in setting page.
 *
 * @param array $args
 *
 * @return void
 */
function scm_run_expert_mode($args)
{

	$microtime_before = microtime(true);
	$sql_queries      = 0;

	// Prevent CLI conficts
	if (!isset($_SERVER['REQUEST_URI'])) {
		return;
	}

	$plugin_dir        = rtrim($args['plugin_dir'], '/');
	$plugin_upload_dir = rtrim($args['plugin_upload_dir'], '/');

	// Make sure that Cache Master exists.
	if (!file_exists($plugin_dir . '/cache-master.php')) {
		return;
	}

	// Make the "expert mode" is enabled.
	if (!file_exists($plugin_upload_dir . '/expert.lock')) {
		return;
	}

	if (!file_exists($plugin_upload_dir . '/config.json')) {
		return;
	}

	// Read configuration data.
	$content = file_get_contents($plugin_upload_dir . '/config.json');
	$config  = json_decode($content, true);

	$site_path = '/';

	if (!empty($config['site_url'])) {
		$site_url  = rtrim($config['site_url'], '/') . '/';
		$site_path = parse_url($site_url, PHP_URL_PATH);
	}

	$request_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

	$driver_type          = $config['cache_driver']                      ?? 'file';
	$is_woocommerce       = $config['woocommerce']['enable']             ?? false;
	$advanced_settings    = $config['driver_advanced_settings']          ?? array();
	$debug_comment        = $config['html_debug_comment']                ?? true;
	$is_exclusion         = $config['exclusion']['enable']               ?? false;
	$excluded_list        = $config['exclusion']['excluded_list']        ?? array();
	$excluded_get_vars    = $config['exclusion']['excluded_get_vars']    ?? array();
	$excluded_post_vars   = $config['exclusion']['excluded_post_vars']   ?? array();
	$excluded_cookie_vars = $config['exclusion']['excluded_cookie_vars'] ?? array();

	// Ignore excluded list...
	if ($is_exclusion) {
		foreach ($excluded_list as $ignored_url) {
			if (strpos($request_path, $ignored_url) === 0) {
				return;
			}
		}

		foreach ($excluded_get_vars as $var) {
			if (isset($_GET[$var])) {
				return true;
			}
		}
		foreach ($excluded_post_vars as $var) {
			if (isset($_POST[$var])) {
				return true;
			}
		}
		foreach ($excluded_cookie_vars as $var) {
			if (isset($_COOKIE[$var])) {
				return true;
			}
		}
	}

	// Check if WooCommerce support is enabled.
	if ($is_woocommerce) {
		if (isset($_POST['add-to-cart']) && is_numeric($_POST['add-to-cart'])) {
			return;
		}
		if (!empty($_COOKIE['woocommerce_items_in_cart'])) {
			return;
		}
		if (isset($_GET['wc-ajax'])) {
			return;
		}
	}

	// The cache key.
	$key = md5($request_path);

	// Start "reading-cache" procedure.
	if (strpos($request_path, $site_path) === 0) {

		// Composer autoloader.
		include_once($plugin_dir . '/vendor/autoload.php');
		include_once($plugin_dir . '/inc/helpers.php');

		switch ($driver_type) {
			case 'mysql':
				$setting = array(
					'host'    => DB_HOST,
					'dbname'  => DB_NAME,
					'user'    => DB_USER,
					'pass'    => DB_PASSWORD,
					'charset' => DB_CHARSET,
				);

				$sql_queries++;
				break;

			case 'sqlite':
			case 'file':
				$setting = array(
					'storage' => $plugin_upload_dir . '/' . $driver_type . '_driver',
				);
				break;

			case 'redis':
				$setting = array(
					'host' => '127.0.0.1',
					'port' =>  6379,
				);

				break;

			case 'memcache':
			case 'memcached':
				$setting = array(
					'host' => '127.0.0.1',
					'port' =>  11211,
				);
				break;

			default:
				// apc, apcu, wincache
				$setting = array();
		}

		if (!empty($advanced_settings)) {
			$setting = $advanced_settings;

			foreach ($setting as $k => $v) {
				if (is_numeric($v)) {
					$setting[$k] = (int) $v;
				}
			}
		}

		$driver = new \Shieldon\SimpleCache\Cache($driver_type, $setting);

		$cached_content = $driver->get($key);

		$memory_usage = memory_get_usage();
		$memory_usage = $memory_usage / (1024 * 1024);
		$memory_usage = round($memory_usage, 4);

		if (!empty($cached_content) && $debug_comment) {
			$date            = date('Y-m-d H:i:s');
			$microtime_after = microtime(true);
			$page_speed      = round($microtime_after - $microtime_before, 3);

			$debug_message  = '';
			$debug_message .= "\n" . '....... ' . 'After' . ' .......' . "\n\n";
			$debug_message .= sprintf('Now: %s', $date) . "\n";
			$debug_message .= sprintf('Memory usage: %s MB', $memory_usage) . "\n";
			$debug_message .= sprintf('SQL queries: %s', $sql_queries) . "\n";
			$debug_message .= sprintf('Page generated in %s seconds.', $page_speed) . "\n\n";
			$debug_message .= '(Running as Expert Mode)' . "\n";
			$debug_message .= "\n//-->";

			$cached_content .= $debug_message;

			scm_variable_stack('now',  $date, 'after');
			scm_variable_stack('memory_usage',  $memory_usage, 'after');
			scm_variable_stack('sql_queries',  $sql_queries, 'after');
			scm_variable_stack('page_generation_time',  $page_speed, 'after');

			// This line must be at after scm_variable_stack.
			$cached_content = str_replace(
				'</body>',
				"\n" . scm_javascript() . "\n" . '</body>',
				$cached_content
			);

			// Outpue cache.
			echo $cached_content;
			exit;
		}
	}
}
