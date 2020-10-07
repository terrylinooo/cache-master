<?php
/**
 * Cache Master helper functions.
 *
 * @package   Cache Master
 * @author    Terry Lin <terrylinooo>
 * @license   GPLv3 (or later)
 * @link      https://terryl.in
 * @copyright 2020 Terry Lin
 */

if ( ! defined( 'ABSPATH' ) ) {
	die;
}

/**
 * Use the "Expert Mode", see explanation in setting page.
 *
 * @param array $args
 * 
 * @return void
 */
function scm_run_expert_mode( $args ) {

    // Prevent CLI conficts
    if ( ! isset( $_SERVER['REQUEST_URI' ] ) ) {
        return;
    }

    $plugin_dir        = rtrim( $args['plugin_dir'], '/' );
    $plugin_upload_dir = rtrim( $args['plugin_upload_dir'], '/' );
    $site_url          = rtrim( $args['site_url'], '/' ) . '/';
    $site_path         = parse_url( $site_url, PHP_URL_PATH );
    $request_uri       = $_SERVER['REQUEST_URI'];

    // The cache type.
    $type = $args['cache_driver_type'];

    // The cache key.
    $key = md5( $request_uri );

    // Make sure that Cache Master exists.
    if ( ! file_exists( $plugin_dir . '/cache-master.php' ) ) {
        return;
    }

    // Make the "expert mode" is enable.
    if ( ! file_exists( $plugin_upload_dir . '/expert_mode.lock') ) {
        return;
    }

    // Start "reading-cache" procedure.
    if ( strpos( $request_uri, $site_path ) === 0 ) {
        
        // Composer autoloader.
        include_once( $plugin_dir . '/vendor/autoload.php' );

        switch ( $type )  {
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
            case 'file':
                $setting = array(
                    'storage' => $plugin_upload_dir . '/' . $type . '_driver',
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
        
        $driver = new \Shieldon\SimpleCache\Cache( $type, $setting );
       
        $cached_content = $driver->get( $key );

        $memory_usage = memory_get_usage();
		$memory_usage = $memory_usage / ( 1024 * 1024 );
		$memory_usage = round( $memory_usage, 4 );
        
		if ( ! empty( $cached_content ) ) {
           
            $debug_message = '';
            $debug_message .= sprintf( 'Current memory usage: %s MB', $memory_usage ) . ' (' . date( 'Y-m-d H:i:s' ). ")\n";
            $debug_message .= "\n";
            $debug_message .= 'Running as Expert mode, even logged-in users will see cache as well.' . "\n";
            $debug_message .= "\n";
            $debug_message .= "\n//-->";
            $cached_content .= $debug_message;

            // Outpue cache.
			echo $cached_content;
			exit;
        }  
    }
}

