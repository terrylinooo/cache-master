<?php

/**
 * Cache Master - Update setting.
 *
 * @author Terry Lin
 * @link https://terryl.in/
 * @since 1.0.0
 * @version 1.3.0
 */

if (!defined('SCM_INC')) {
	die;
}

scm_check_permalink_structure();

// Make changes on those setting options will trigger its action function.
$register_general_action = array(
	'scm_option_driver',
	'scm_option_expert_mode_status',
	'scm_option_clear_cache',
	'scm_option_html_debug_comment',
);



foreach ($register_general_action as $option) {
	add_action('update_option_' . $option, 'scm_update_' . $option);
}

// Make changes on those setting options will clear all cache.
$register_clear_cache_action = array(
	'scm_option_caching_status',
	'scm_option_post_homepage',
	'scm_option_post_types',
	'scm_option_post_archives',
	'scm_option_benchmark_widget',
	'scm_option_benchmark_widget_display',
	'scm_option_benchmark_footer_text',
	'scm_option_benchmark_footer_text_display',
);

foreach ($register_clear_cache_action as $option) {
	// `scm_clear_all_cache` is defined in functions.php
	add_action('update_option_' . $option, 'scm_clear_all_cache');
}

// Update WooCommerce settings.
$register_woocommerce_action = array(
	'scm_option_woocommerce_status',
	'scm_option_woocommerce_post_archives',
	'scm_option_woocommerce_post_types',
);

foreach ($register_woocommerce_action as $option) {
	add_action('update_option_' . $option, 'scm_update_woocommerce');
}

// Update exclusion settings.
$register_exclusion_action = array(
	'scm_option_exclusion_status',
	'scm_option_excluded_list',
	'scm_option_excluded_get_vars',
	'scm_option_excluded_post_vars',
	'scm_option_excluded_cookie_vars',
);

foreach ($register_exclusion_action as $option) {
	add_action('update_option_' . $option, 'scm_update_exclusion');
}

/**
 * Rebuild data schema.
 *
 * @return void
 */
function scm_update_scm_option_driver()
{
	$driver_type = get_option('scm_option_driver');

	if (!scm_test_driver($driver_type)) {
		update_option('scm_option_driver', 'file');

		// Road back to File driver if the option is not available.
		$driver_type = 'file';
	}

	$rebuld_list = array(
		'mysql',
		'sqlite',
	);

	foreach ($rebuld_list as $db) {
		$db_driver = scm_driver_factory($db);

		if ($db_driver) {
			$db_driver->rebuild();
		}
	}

	$advanced_settings = array();

	if ('memcached' === $driver_type) {
		$advanced_settings = get_option('scm_option_advanced_driver_memcached');
	} elseif ('redis' === $driver_type) {
		$advanced_settings = get_option('scm_option_advanced_driver_redis');
	} elseif ('mongo' === $driver_type) {
		$advanced_settings = get_option('scm_option_advanced_driver_mongodb');
	}

	$setting['cache_driver']             = $driver_type;
	$setting['driver_advanced_settings'] = $advanced_settings;

	scm_update_config($setting);
}

/**
 * Check permalink structure because only static URL structure is supported.
 *
 * @return void
 */
function scm_check_permalink_structure()
{
	if ('' === get_option('permalink_structure')) {
		update_option('option_caching_status', 'disable');
	}
}

/**
 * Create checkpoint file for Expert Mode.
 *
 * @return void
 */
function scm_update_scm_option_expert_mode_status()
{
	$checkpoint = scm_get_upload_dir() . '/expert.lock';

	if ('enable' === get_option('scm_option_expert_mode_status')) {
		file_put_contents($checkpoint, 'VOTE!');
	} else {
		if (file_exists($checkpoint)) {
			unlink($checkpoint);
		}
	}
}

/**
 * Update configuration file when changing Debug Comment option.
 *
 * @return void
 */
function scm_update_scm_option_html_debug_comment()
{
	$status = get_option('scm_option_html_debug_comment', true);

	if ('no' === $status) {
		$setting['html_debug_comment'] = false;
	}

	if ('yes' === $status) {
		$setting['html_debug_comment'] = true;
	}

	scm_update_config($setting);
	scm_clear_all_cache();
}

/**
 * Perform clearing cache by specific option.
 *
 * @return void
 */
function scm_update_scm_option_clear_cache()
{
	$cache_type = get_option('scm_option_clear_cache');
	$driver     = scm_driver_factory(get_option('scm_option_driver'));

	if (!$driver) {
		return;
	}

	$list = scm_get_cache_type_list(true);

	update_option('scm_option_clear_cache', '');

	if ('all' === $cache_type) {
		$driver->clear();

		foreach ($list as $cache_type) {
			$dir = scm_get_stats_dir($cache_type);

			if (is_dir($dir)) {
				foreach (new DirectoryIterator($dir) as $file) {
					if ($file->isFile() && $file->getExtension() === 'json') {
						$filename = $file->getFilename();
						$key      = strstr($filename, '.', true);

						$driver->delete($key);
						unlink($file->getPathname());
					}
				}
			}
		}
	} else {
		if (in_array($cache_type, $list)) {
			$dir = scm_get_stats_dir($cache_type);

			if (is_dir($dir)) {
				foreach (new DirectoryIterator($dir) as $file) {
					if ($file->isFile() && $file->getExtension() === 'json') {
						$filename = $file->getFilename();
						$key      = strstr($filename, '.', true);

						$driver->delete($key);
						unlink($file->getPathname());
					}
				}
			}
		}
	}
}

/**
 * The update for:
 * - scm_option_exclusion_status
 * - scm_option_excluded_list
 *
 * @return void
 */
function scm_update_exclusion()
{
	$status = get_option('scm_option_exclusion_status');

	if ('no' === $status) {
		$setting['exclusion']['enable'] = false;
	}

	if ('yes' === $status) {
		$setting['exclusion']['enable'] = true;
	}

	// Excluded list.
	$exluded_list = get_option('scm_option_excluded_list');
	$exluded_list_filtered = get_option('scm_option_excluded_list_filtered');

	$exluded_list_arr = explode("\n", $exluded_list);
	$exluded_list_tmp = array();

	// check the users input are valid URL
	foreach ($exluded_list_arr as $item) {
		$str = trim($item);
		$str = parse_url($str, PHP_URL_PATH);

		$exluded_list_tmp[] = $str;
	}

	if (1 < count($exluded_list_tmp)) {
		$content = implode("\n", $exluded_list_tmp);
	} else {
		$content = implode("", $exluded_list_tmp);
	}

	if ($exluded_list_filtered !== $content) {
		update_option('scm_option_excluded_list_filtered', $content);
	}

	$setting['exclusion']['excluded_list'] = $exluded_list_tmp;

	// Excluded GET, POST and COOKIE variables.
	$check_list = array(
		'get',
		'post',
		'cookie',
	);

	foreach ($check_list as $list) {
		$exluded_variables = get_option('scm_option_excluded_' . $list . '_vars', '');

		$exluded_variables_arr = explode("\n", $exluded_variables);
		$exluded_variables_tmp = array();

		foreach ($exluded_variables_arr as $item) {
			$str = trim($item);
			if (preg_match('/^[a-zA-Z0-9_\-]+$/', $str)) {
				$exluded_variables_tmp[] = $str;
			}
		}

		$setting['exclusion']['excluded_' . $list . '_vars'] = array();

		if (!empty($exluded_variables_tmp)) {
			$setting['exclusion']['excluded_' . $list . '_vars'] = $exluded_variables_tmp;
		}
	}

	scm_update_config($setting);
}

/**
 * The update for:
 * - scm_option_woocommerce_status
 * - scm_option_woocommerce_post_archives
 * - scm_option_woocommerce_post_types
 *
 * @return void
 */
function scm_update_woocommerce()
{
	$status = get_option('scm_option_woocommerce_status');

	if ('no' === $status) {
		$setting['woocommerce']['enable'] = false;
	}

	if ('yes' === $status) {
		$setting['woocommerce']['enable'] = true;
	}

	scm_update_config($setting);
	scm_clear_all_cache();
}
