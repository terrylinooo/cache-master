<?php
/**
 * Class Cache_Master
 *
 * @author Terry Lin
 * @link https://terryl.in/
 *
 * @package Cache Master
 * @since 1.0.0
 * @version 1.3.0
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
	 * Data type.
	 *
	 * @var string
	 */
	public $data_type = '';

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
		add_action( 'wp', array( $this, 'get_post_data' ), 0 );
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

		$post_homepage = get_option( 'scm_option_post_homepage' );
		$post_types    = get_option( 'scm_option_post_types' );
		$post_archives = get_option( 'scm_option_post_archives' );
		$status        = get_option( 'scm_option_caching_status' );

		if ( 'enable' !== $status ) {
			$this->is_cache = false;
			return;
		}

		if ( is_front_page() ) {
			$this->is_cache  = true;
			$this->data_type = 'homepage';

			if ( 'no' === $post_homepage ) {
				$this->is_cache = false;
			}
			return;
		
		} else {

			$types = array(
				'post' => 'is_single',
				'page' => 'is_page',
			);

			foreach( $types as $type => $wp_function ) {
				if ( isset( $post_types[ $type ] ) && $wp_function() ) {
					$this->is_cache  = true;
					$this->data_type = $type;
					return;
				}
			}

			$archives = array(
				'category' => 'is_category',
				'tag'      => 'is_tag',
				'date'     => 'is_date',
				'author'   => 'is_author',
			);

			foreach( $archives as $type => $wp_function ) {
				if ( isset( $post_archives[ $type ] ) && $wp_function() ) {
					$this->is_cache  = true;
					$this->data_type = $type;
					return;
				}
			}
		}

		// Do not cache 404 page.
		if ( is_404() ) {
			$this->is_cache = false;
			return;
		}
	}

    /**
	 * Start output cache if exists.
	 *
	 * @return void
	 */
	public function ob_start() {

		if ( $this->is_cache_visible() ) {
			$cached_content = $this->driver->get( $this->cache_key );

			if ( ! empty( $cached_content ) ) {
				$cached_content .= $this->debug_message( 'ob_start' );
				echo $cached_content;
				exit;
			}
		}

		// Logged-in users will not trigger the cache.
		if ( is_user_logged_in() ) {
			return;
		}

		$this->wp_ob_start();
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

		$this->wp_ob_end_flush_all();

		$content = ob_get_contents();
		$content .= $this->debug_message( 'ob_stop' );

		if ( $this->is_cache ) {
			$ttl = (int) get_option( 'scm_option_ttl' );

			$this->driver->set( $this->cache_key, $content, $ttl );

			$this->log( $this->data_type, $this->cache_key, $content );
		}
	}

	/**
	 * Print debug message.
	 *
	 * @param string $position The position of the hook lifecycle.
	 *
	 * @return string
	 */
	private function debug_message( $position = '' )
	{
		switch ( $position ) {
			case 'ob_start':
				$this->msg();
				$this->msg( '....... ' . __( 'After', 'cache-master' ) . ' .......', 2 );
				$this->msg( sprintf( __( 'Now: %s', 'cache-master' ), $this->get_date() ) );
				$this->msg( sprintf( __( 'Memory usage: %s MB', 'cache-master' ), $this->get_memory_usage() ) );
				$this->msg( sprintf( __( 'Page generated in %s seconds.', 'cache-master' ), $this->wp_timer_stop() ) );
				$this->msg();
				$this->msg( '//-->' );
				break;

			case 'ob_stop':
				$ttl     = (int) get_option( 'scm_option_ttl' );
				$expires = time() + $ttl;

				$this->msg();
				$this->msg( '<!--', 2 );
				$this->msg( __( 'This page is cached by Cache Master plugin.', 'cache-master' ), 2 );
				$this->msg( '....... ' . __( 'Before', 'cache-master' ) . ' .......', 2 );
				$this->msg( sprintf( __( 'Time to cache: %s', 'cache-master' ), $this->get_date() ) );
				$this->msg( sprintf( __( 'Expires at: %s', 'cache-master' ), $this->get_date( $expires ) ) );
				$this->msg( sprintf( __( 'Memory usage: %s MB', 'cache-master' ), $this->get_memory_usage() ) );
				$this->msg( sprintf( __( 'Page generated in %s seconds.', 'cache-master' ), $this->wp_timer_stop() ) );
				break;
		}

		return $this->msg( null );
	}

	/**
	 * Create a message stack.
	 *
	 * @param string|null $msg         The message text body.
	 * @param int         $line_breaks The number of line break.
	 *
	 * @return void|string Return a string and clear the stack if $msg is null.
	 */
	private function msg( $msg = '', $line_breaks = 1 ) {
		static $message = array();

		if ( is_null( $msg ) ) {
			$output  = $message;
			$message = array();

			return implode( '', $output );
		}

		for ( $i = 0; $i < $line_breaks; $i++ ) {
			$msg .= "\n";
		}
		$message[] = $msg;
	}

	/**
	 * Create a clean output buffering for Cahce Master.
	 * This method makes Cache Master become the first level of output 
	 * buffering.
	 *
	 * @return void
	 */
	private function wp_ob_start() {
		$levels = ob_get_level();
		for ( $i = 0; $i < $levels; $i++ ) {
			ob_end_clean();
		}
		ob_start();
	}

	/**
	 * Same as WordPress function wp_ob_end_flush_all, but leave the 
	 * Cache Master level for the final output buffering.
	 *
	 * @return string
	 */
	private function wp_ob_end_flush_all() {
		$levels = ob_get_level();
		for ( $i = 0; $i < $levels - 1; $i++ ) {
			ob_end_flush();
		}
	}

	/**
	 * Return the WordPress timer.
	 *
	 * @return float
	 */
	private function wp_timer_stop() {
		// timer_stop is WordPress function.
		return timer_stop();
	}

	/**
	 * Get the date in format Y-m-d H:i:s.
	 *
	 * @param int $timestamp
	 *
	 * @return string
	 */
	private function get_date( $timestamp = 0 ) {
		if ( ! empty( $timestamp ) ) {
			return date( 'Y-m-d H:i:s', $timestamp );
		}
		return date( 'Y-m-d H:i:s' );
	}

	/**
	 * Return a string that is the memory usage in Megabyte.
	 *
	 * @return string
	 */
	private function get_memory_usage() {
		$memory_usage = memory_get_usage();
		$memory_usage = $memory_usage / ( 1024 * 1024 );
		$memory_usage = round( $memory_usage, 4 );

		return $memory_usage;
	}

	/**
	 * Check if a user can see the cached pages.
	 *
	 * @return bool
	 */
	private function is_cache_visible() {
		if ( is_user_logged_in() ) {
			if ( 'yes' !== get_option( 'scm_option_visibility_login_user' ) ) {
				return false;
			}
		}
		return true;
	}

	/**
	 * Log the chaning processes.
	 *
	 * @param string $type The type of the data source.
	 * @param string $key  The key name of a cache.
	 * @param string $data The string of HTML source code.
	 *
	 * @return void
	 */
	private function log( $type, $key, $data )
	{
		if ( 'enable' === get_option( 'scm_option_statistics_status' ) ) {
			$size = $this->get_string_bytes( $data );
			$file = scm_get_stats_dir( $type ) . '/' . $key . '.json';

			file_put_contents( $file, $size );
		}
	}

	/**
	 * Get the bytes of string.
	 *
	 * @param string $content The string of the page content.
	 *
	 * @return int
	 */
	private function get_string_bytes( $content ) {
		if ( function_exists( 'mb_strlen' ) ) {
			return mb_strlen( $content, '8bit' );
		}
		return strlen( $content );
	}
}
