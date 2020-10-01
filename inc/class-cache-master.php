<?php
/**
 * Class Cache_Master
 *
 * @author Terry Lin
 * @link https://terryl.in/
 *
 * @package Cache Master
 * @since 1.0.0
 * @version 1.1.0
 */

if ( ! defined( 'SCM_INC' ) ) {
	die;
}

class Cache_Master {

	/**
	 * Cache insance.
	 *
	 * @var \Shieldon\SimpleCache\Cache
	 */
	public $driver;

	/**
	 * The key of the cached data.
	 *
	 * @var string
	 */
	public $cache_key = '';

	/**
	 * Is current page available to be cached?
	 *
	 * @var bool
	 */
	public $is_cache = false;

	/**
	 * Constructer.
	 */
	public function __construct() {
		$this->driver = scm_driver_factory( get_option( 'scm_option_driver' ) );
		$this->cache_key = md5( $_SERVER['REQUEST_URI'] );
	}
	
	/**
	 * Initialize everything the SCM plugin needs.
	 */
	public function init() {
		add_action( 'init', array( $this, 'ob_start'), 0 );
		add_action( 'shutdown', array( $this, 'ob_stop'), 0 );
		add_action( 'pre_get_posts', array( $this, 'get_post_data' ) );
	}

	/**
	 * Get posts' information.
	 *
	 * @return void
	 */
	public function get_post_data() {

		$post_types = get_option( 'scm_option_post_types' );
		$status = get_option( 'scm_option_caching_status' );

		if ( 'enable' !== $status ) {
			$this->is_cache = false;
			return;
		}

		// Home page.
		if ( 'yes' === $post_types['home'] && is_home() ) {
			$this->is_cache = true;
		
		// Post type: post
		} elseif ( 'yes' === $post_types['post'] && is_single() ) {
			$this->is_cache = true;

		// Post type: page
		} elseif ( 'yes' === $post_types['page'] && is_page() ) {
			$this->is_cache = true;
		}

		// Do not cache 404 page.
		if ( is_404() ) {
			$this->is_cache = false;
		}

		if ( is_user_logged_in() ) {
			$this->is_cache = false;
		}
	}
	
	/**
	 * Start output buffering.
	 *
	 * @return void
	 */
	public function ob_start() {
		$cached_content = $this->driver->get( $this->cache_key );

		if ( ! empty( $cached_content ) ) {
			echo $cached_content;
			exit;
		}
  
		ob_start();
	}

	/**
	 *  Stop output buffering.
	 *
	 * @return void
	 */
	public function ob_stop() {

		if ( $this->is_cache ) {
			$ttl = (int) get_option( 'scm_option_ttl' );
			$expires = time() + $ttl;

			$debug_message = '<!--' . "\n";
			$debug_message .= '  This page is cached by Cache Master plugin.' . "\n";
			$debug_message .= '  Time to cache: ' . date( 'Y-m-d H:i:s' ) . "\n";
			$debug_message .= '  Expires at: ' . date( 'Y-m-d H:i:s', $expires ) . "\n";
			$debug_message .= '//-->';
	
			$content = ob_get_contents();
			$content .= $debug_message;
			ob_end_flush();

			$this->driver->set( $this->cache_key,  $content, $ttl );
		}
	}
}
