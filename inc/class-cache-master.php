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
		add_action( 'plugins_loaded', array( $this, 'ob_start' ), 5 );
		add_action( 'shutdown', array( $this, 'ob_stop' ), 0 );
		add_action( 'pre_get_posts', array( $this, 'get_post_data' ), 0 );
	}

	/**
	 * Get posts' information.
	 *
	 * @return void
	 */
	public function get_post_data() {

		// Logged-in users will not trigger the cache.
		if ( is_user_logged_in() ) {
			return;
		}

		$post_types = get_option( 'scm_option_post_types' );
		$status     = get_option( 'scm_option_caching_status' );

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
	}

	/**
	 * Start output cache if exists.
	 *
	 * @return void
	 */
	public function ob_start() {

		// Logged-in users will not trigger the cache.
		if ( is_user_logged_in() ) {
			return;
		}

		$cached_content = $this->driver->get( $this->cache_key );

		if ( ! empty( $cached_content ) ) {
			$cached_content .= $this->debug_message( 'ob_start' );
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

		// Logged-in users will not trigger the cache.
		if ( is_user_logged_in() ) {
			return;
		}

		$content = ob_get_contents();
		$content .= $this->debug_message( 'ob_stop' );

		if ( $this->is_cache ) {
			$ttl = (int) get_option( 'scm_option_ttl' );
			$this->driver->set( $this->cache_key,  $content, $ttl );
		}
	}

	/**
	 * Print debug message.
	 *
	 * @param string $position The position of the hook lifecycle.
	 *
	 * @return string
	 */
	private function debug_message( $position )
	{
		$debug_message = '';

		$memory_usage = memory_get_usage();
		$memory_usage = $memory_usage / (1024 * 1024);
		$memory_usage = round($memory_usage, 4);

		// timer_stop is WordPress function.
		$page_speed = timer_stop();

		switch ( $position ) {
			case 'ob_start':
				$debug_message .= "\n\n" . '....... ' . __( 'After', 'cache-master' ) . ' .......' . "\n\n";
				$debug_message .= sprintf( __( 'Now: %s', 'cache-master' ), date( 'Y-m-d H:i:s' ) ) . "\n";
				$debug_message .= sprintf( __( 'Memory usage: %s MB', 'cache-master' ), $memory_usage ) . "\n";
				$debug_message .= sprintf( __( 'Page generated in %s seconds.', 'cache-master' ), $page_speed ) . "\n";
				$debug_message .= "\n\n//-->";
				break;

			case 'ob_stop':
				$ttl     = (int) get_option( 'scm_option_ttl' );
				$expires = time() + $ttl;

				$debug_message .= "<!--\n\n";
				$debug_message .= __( 'This page is cached by Cache Master plugin.', 'cache-master' ) . "\n";
				$debug_message .= "\n\n" . '....... ' . __( 'Before', 'cache-master' ) . ' .......' . "\n\n";
				$debug_message .= sprintf( __( 'Time to cache: %s', 'cache-master' ), date( 'Y-m-d H:i:s' ) ) . "\n";
				$debug_message .= sprintf( __( 'Expires at: %s', 'cache-master' ), date( 'Y-m-d H:i:s', $expires ) ) . "\n";
				$debug_message .= sprintf( __( 'Memory usage: %s MB', 'cache-master' ), $memory_usage ) . "\n";
				$debug_message .= sprintf( __( 'Page generated in %s seconds.', 'cache-master' ), $page_speed ) . "\n";
				break;
		}

		return $debug_message;
	}
}
