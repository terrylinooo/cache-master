<?php

/**
 * Cache Master helper functions.
 *
 * @author Terry Lin, Yannick Lin
 * @link https://terryl.in/
 *
 * @package   Cache Master
 * @since 2.1.0
 * @version 2.1.3
 */

if (!defined('SCM_INC')) {
	die;
}


/**
 * Load plugin textdomain.
 *
 * @return void
 */
function scm_load_textdomain()
{
	load_plugin_textdomain(SCM_PLUGIN_TEXT_DOMAIN, false, SCM_PLUGIN_LANGUAGE_PACK);
}


/**
 * Get driver hash.
 *
 * @return string
 */
function scm_get_dir_hash()
{
	$hash = get_option('scm_dir_hash');

	if (empty($hash)) {
		return scm_set_dir_hash();
	}
	return $hash;
}


/**
 * Check driver hash exists or not.
 *
 * @return bool
 */
function scm_is_dir_hash()
{
	$hash = get_option('scm_dir_hash');

	if (empty($hash)) {
		return false;
	}
	return true;
}


/**
 * Set driver hash.
 *
 * @return string
 */
function scm_set_dir_hash()
{
	$scm_dir_hash = wp_hash(date('ymdhis') . wp_rand(1, 86400));
	$scm_dir_hash = substr($scm_dir_hash, 0, 8);

	update_option('scm_dir_hash', $scm_dir_hash);

	return $scm_dir_hash;
}


/**
 * Get upload dir.
 *
 * @return string
 */
function scm_get_upload_dir()
{
	return WP_CONTENT_DIR . '/uploads/cache-master/' . scm_get_blog_id() . '_' . scm_get_dir_hash();
}


/**
 * Get configuration file's path.
 *
 * @return string
 */
function scm_get_config_path()
{
	return scm_get_upload_dir() . '/config.json';
}


/**
 * Get configuration data.
 *
 * @return array
 */
function scm_get_config_data()
{
	$file = scm_get_config_path();

	if (file_exists($file)) {
		$content = file_get_contents($file);
		return json_decode($content, true);
	}
	return scm_get_default_config();
}


/**
 * Set channel Id.
 *
 * @return void
 */
function scm_set_blog_id()
{
	update_option('scm_blog_id', get_current_blog_id());
}


/**
 * Get channel Id.
 *
 * @return string
 */
function scm_get_blog_id()
{
	return get_option('scm_blog_id', 1);
}


/**
 * Get the path of statistics directory.
 *
 * @param string $cache_type
 *
 * @return string
 */
function scm_get_stats_dir($cache_type = 'post')
{
	return scm_get_upload_dir() . '/stats/' . $cache_type;
}


/**
 * Get the cache driver instance.
 *
 * @param string $type The type of the driver.
 *
 * @return \Shieldon\SimpleCache\Cache
 */
function scm_driver_factory($type)
{

	$advanced_settings        = array();
	$advanced_connection_type = 'tcp';
	$setting                  = array();

	switch ($type) {
		case 'mysql':
			$setting = array(
				'host'    => DB_HOST,
				'dbname'  => DB_NAME,
				'user'    => DB_USER,
				'pass'    => DB_PASSWORD,
				'charset' => DB_CHARSET,
			);
			break;

		case 'sqlite':
			$setting = array(
				'storage' => scm_get_upload_dir() . '/sqlite_driver',
			);
			break;

		case 'redis':
			$setting = array(
				'host' => '127.0.0.1',
				'port' =>  6379,
			);

			$advanced_settings = get_option('scm_option_advanced_driver_redis');
			$advanced_connection_type = get_option('scm_option_advanced_driver_redis_connection_type', 'tcp');
			break;

		case 'mongo':
			$setting = array(
				'host' => '127.0.0.1',
				'port' =>  27017,
			);

			$advanced_settings = get_option('scm_option_advanced_driver_mongodb');
			$advanced_connection_type = get_option('scm_option_advanced_driver_mongodb_connection_type', 'tcp');
			break;

		case 'memcache':
		case 'memcached':
			$setting = array(
				'host' => '127.0.0.1',
				'port' =>  11211,
			);

			$advanced_settings = get_option('scm_option_advanced_driver_memcached');
			$advanced_connection_type = get_option('scm_option_advanced_driver_memcached_connection_type', 'tcp');
			break;

		case 'apc':
		case 'apcu':
		case 'wincache':
			$setting = array();
			break;

		case 'file':
		default:
			$type    = 'file';
			$setting = array(
				'storage' => scm_get_upload_dir() . '/file_driver',
			);
			break;
	}

	if (!empty($advanced_settings)) {
		$setting = $advanced_settings;

		foreach ($setting as $k => $v) {
			if (is_numeric($v)) {
				$setting[$k] = (int) $v;
			}
		}

		if ('socket' !== $advanced_connection_type) {
			if (!empty($advanced_settings['unix_socket'])) {
				unset($setting['unix_socket']);
			}
		}
	}

	try {

		$driver = new \Shieldon\SimpleCache\Cache($type, $setting);
	} catch (\Exception $e) {

		if (in_array($type, array('file', 'sqlite')) && !file_exists($setting['storage'])) {
			wp_mkdir_p($setting['storage']);

			// Let's try again.
			$driver = new \Shieldon\SimpleCache\Cache($type, $setting);
		} else {

			error_log('[Cache Master] Driver ' . $type . ' is not supported, fallback to use File driver.');

			$driver = new \Shieldon\SimpleCache\Cache('file', array(
				'storage' => scm_get_upload_dir() . '/file_driver',
			));
		}
	}

	return $driver;
}


/**
 * Get a SVG icon.
 *
 * @param string $type The icon type.
 *
 * Font Awesome Free 5.15.1
 *
 * @return string
 */
function scm_get_svg_icon($type)
{
	switch ($type) {
		case 'status':
			$svg = "<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 520 562'><path d='M504 256c0 136.997-111.043 248-248 248S8 392.997 8 256C8 119.083 119.043 8 256 8s248 111.083 248 248zM262.655 90c-54.497 0-89.255 22.957-116.549 63.758-3.536 5.286-2.353 12.415 2.715 16.258l34.699 26.31c5.205 3.947 12.621 3.008 16.665-2.122 17.864-22.658 30.113-35.797 57.303-35.797 20.429 0 45.698 13.148 45.698 32.958 0 14.976-12.363 22.667-32.534 33.976C247.128 238.528 216 254.941 216 296v4c0 6.627 5.373 12 12 12h56c6.627 0 12-5.373 12-12v-1.333c0-28.462 83.186-29.647 83.186-106.667 0-58.002-60.165-102-116.531-102zM256 338c-25.365 0-46 20.635-46 46 0 25.364 20.635 46 46 46s46-20.636 46-46c0-25.365-20.635-46-46-46z'/></svg>";
			break;

		case 'memory':
			$svg = "<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 582 552'><path d='M640 130.94V96c0-17.67-14.33-32-32-32H32C14.33 64 0 78.33 0 96v34.94c18.6 6.61 32 24.19 32 45.06s-13.4 38.45-32 45.06V320h640v-98.94c-18.6-6.61-32-24.19-32-45.06s13.4-38.45 32-45.06zM224 256h-64V128h64v128zm128 0h-64V128h64v128zm128 0h-64V128h64v128zM0 448h64v-26.67c0-8.84 7.16-16 16-16s16 7.16 16 16V448h128v-26.67c0-8.84 7.16-16 16-16s16 7.16 16 16V448h128v-26.67c0-8.84 7.16-16 16-16s16 7.16 16 16V448h128v-26.67c0-8.84 7.16-16 16-16s16 7.16 16 16V448h64v-96H0v96z'/></svg>";
			break;

		case 'database':
			$svg = "<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 482 572'><path d='M448 73.143v45.714C448 159.143 347.667 192 224 192S0 159.143 0 118.857V73.143C0 32.857 100.333 0 224 0s224 32.857 224 73.143zM448 176v102.857C448 319.143 347.667 352 224 352S0 319.143 0 278.857V176c48.125 33.143 136.208 48.572 224 48.572S399.874 209.143 448 176zm0 160v102.857C448 479.143 347.667 512 224 512S0 479.143 0 438.857V336c48.125 33.143 136.208 48.572 224 48.572S399.874 369.143 448 336z'/></svg>";
			break;

		case 'speed':
			$svg = "<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 320 512'><path d='M296 160H180.6l42.6-129.8C227.2 15 215.7 0 200 0H56C44 0 33.8 8.9 32.2 20.8l-32 240C-1.7 275.2 9.5 288 24 288h118.7L96.6 482.5c-3.6 15.2 8 29.5 23.3 29.5 8.4 0 16.4-4.4 20.8-12l176-304c9.3-15.9-2.2-36-20.7-36z'/></svg>";
			break;
	}

	return $svg;
}


/**
 * Get default configuation.
 *
 * This function is also used in expert mode.
 *
 * @return array
 */
function scm_get_default_config()
{

	return array(
		'cache_driver'             => 'file',
		'html_debug_comment'       => true,
		'driver_advanced_settings' => array(),
		'site_url'                 => '',

		'woocommerce' => array(
			'enable' => false,
		),

		'exclusion' => array(
			'enable'             => false,
			'excluded_list'      => array(),
			'excluded_get_vars'  => array(),
			'excluded_post_vars' => array(),
			'excluded_cookie'    => array(),
		),
	);
}


/**
 * The variable stack for JavaScript snippet.
 *
 * This function is also used in expert mode.
 *
 * @param string      $key      The key of the field.
 * @param string|int  $value    The value of the field.
 * @param string      $poistion The position.
 *
 * @return void
 */
function scm_variable_stack($key, $value = '', $poistion = 'before')
{
	static $vars = array();

	if (is_null($key)) {
		$output = $vars;
		$vars   = array();

		return json_encode($output);
	}

	$vars[$poistion][$key] = $value;
}


/**
 * Create JavaScript snippet used for performance report.
 *
 * This function is also used in expert mode.
 *
 * @return void
 */
function scm_javascript()
{
	$script = '
		<script id="cache-master-plugin">
			var cache_master = \'' . scm_variable_stack(null) . '\';
			var scm_report   = JSON.parse(cache_master);

			var scm_text_cache_status = "";
			var scm_text_memory_usage = "";
			var scm_text_sql_queries  = "";
			var scm_text_page_generation_time = "";

			if ("before" in scm_report) {
				scm_text_cache_status = "No";
				scm_text_memory_usage = scm_report["before"]["memory_usage"];
				scm_text_sql_queries = scm_report["before"]["sql_queries"];
				scm_text_page_generation_time = scm_report["before"]["page_generation_time"];
			}
			if ("after" in scm_report) {
				scm_text_cache_status = "Yes";
				scm_text_memory_usage = scm_report["after"]["memory_usage"];
				scm_text_sql_queries = scm_report["after"]["sql_queries"];
				scm_text_page_generation_time = scm_report["after"]["page_generation_time"];
			}

			document.querySelector(".scm-field-cache-status").textContent = scm_text_cache_status;
			document.querySelector(".scm-field-memory-usage").textContent = scm_text_memory_usage;
			document.querySelector(".scm-field-sql-queries").textContent = scm_text_sql_queries;
			document.querySelector(".scm-field-page-generation-time").textContent = scm_text_page_generation_time;
			document.querySelector(".cache-master-benchmark-report").setAttribute("style", "");
			document.querySelector(".cache-master-plugin-widget-wrapper").setAttribute("style", "");
		</script>
	';

	return preg_replace('/\s+/', ' ', $script);
}
