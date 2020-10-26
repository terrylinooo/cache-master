<?php
/**
 * Class Cache_Master
 *
 * @author Terry Lin
 * @link https://terryl.in/
 *
 * @package Cache Master
 * @since 1.0.0
 * @version 1.5.0
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
	 * Configuation from JSON file.
	 *
	 * @var array
	 */
	public $config = array();

	/**
	 * Is ignored or not?
	 *
	 * @var boolean
	 */
	public $ignore = true;

	/**
	 * Constructer.
	 */
	public function __construct() {
		$this->driver = scm_driver_factory( get_option( 'scm_option_driver' ) );
		$this->config = scm_get_config_data();
	}

	/**
	 * Initialize everything the SCM plugin needs.
	 * 
	 * @return void
	 */
	public function init() {

		$uri = $this->get_request_uri();

		// Ignore all .php files.
		if ( '.php' === substr( $uri, -4 ) ) {
			return;
		}

		$uri = $this->get_request_uri();

		$this->cache_key = md5( $uri );

		add_action( 'plugins_loaded', array( $this, 'ob_start' ), 5 );
		add_action( 'shutdown', array( $this, 'ob_stop' ), 0 );
		add_action( 'wp', array( $this, 'get_post_data' ), 0 );
		add_action( 'wp_enqueue_scripts', array( $this, 'front_enqueue_styles' ) );
		add_action( 'login_enqueue_scripts', array( $this, 'front_enqueue_styles' ) );
	}

	/**
	 * Register CSS style files for frontend use.
	 * 
	 * @return void
	 */
	public function front_enqueue_styles() {
		wp_register_style( 'scm-style', false );
		wp_enqueue_style( 'scm-style' );
		wp_add_inline_style( 'scm-style', $this->get_front_enqueue_styles() );
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

		$is_singular = false;
		$is_archive  = false;

		if ( is_front_page() ) {
			$this->is_cache  = true;
			$this->data_type = 'homepage';

			if ( 'no' === $post_homepage ) {
				$this->is_cache = false;
			}
			return;
		
		} else {

			$is_singular = is_singular();
			$is_archive  = is_archive();

			if ( $is_singular ) {
				$types = array(
					'post',
					'page',
				);
	
				foreach( $types as $type ) {
					if ( isset( $post_types[ $type ] ) && is_singular( $type ) ) {
						
						$this->is_cache  = true;
						$this->data_type = $type;
						return;
					}
				}
			} elseif ( $is_archive ) {
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
		}

		// Support to WooCommerce plugin.
		$woocommerce_support       = get_option( 'scm_option_woocommerce_status' );
		$woocommerce_post_types    = get_option( 'scm_option_woocommerce_post_types' );
		$woocommerce_post_archives = get_option( 'scm_option_woocommerce_post_archives' );

		if ( 'yes' === $woocommerce_support ) {

			if ( $is_singular ) {
				if ( isset( $woocommerce_post_types[ 'product' ] ) && is_singular( 'product' ) ) {
					$this->is_cache  = true;
					$this->data_type = 'product';
					return;
				}
			} elseif ( $is_archive ) {
				$woocommerce_archives = array(
					'product_cat',
					'product_tag',
				);
	
				foreach( $woocommerce_archives as $type ) {
					if ( isset( $woocommerce_post_archives[ $type ] ) && is_tax( $type ) ) {
						$this->is_cache  = true;
						$this->data_type = $type;
						return;
					}
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

		if ( $this->is_cache_visible() && ! $this->is_ignore() ) {

			$cached_content = $this->driver->get( $this->cache_key );

			if ( ! empty( $cached_content ) ) {

				$cached_content .= $this->debug_message( 'ob_start' );

				// This line must be at after debug_message.
				$cached_content = str_replace(
					'</body>',
					"\n" . scm_javascript() . "\n" . '</body>',
					$cached_content
				);

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
	
		$this->wp_ob_end_flush_all();

		$content = ob_get_contents();

		if ( 'yes' === get_option( 'scm_option_benchmark_footer_text') ) {
			$content = str_replace(
				'</body>',
				"\n" . $this->footer_html() . "\n" . '</body>',
				$content
			);
		}

		$cache_content = $content;
		$debug_message = $this->debug_message( 'ob_stop' );

		if ( $this->is_cache && ! $this->is_ignore() ) {
			$ttl = (int) get_option( 'scm_option_ttl' );

			$cache_content .= $debug_message;

			$this->driver->set( $this->cache_key, $cache_content, $ttl );
			$this->log( $this->data_type, $this->cache_key, $cache_content );
		}

		$content = str_replace(
			'</body>',
			"\n" . scm_javascript() . "\n" . '</body>',
			$content
		);

		echo $content;
		
	}

	/**
	 * Add inline CSS.
	 *
	 * @return string
	 */
	public function get_front_enqueue_styles() {
		$custom_css = '';

		$is_widget = ( 'yes' === get_option( 'scm_option_benchmark_widget' ) );
		$is_footer = ( 'yes' === get_option( 'scm_option_benchmark_footer_text' ) );

		$display_widget = get_option( 'scm_option_benchmark_widget_display' );
		$display_footer = get_option( 'scm_option_benchmark_footer_text_display' );

		if ( $is_widget || $is_footer ) {
			$custom_css .= '
				.scm-tr .scm-td:first-child {
					width: 60%;
				}
				.scm-tr .scm-td:last-child {
					width: 40%;
				}
				.scm-td svg {
					width: 17px;
					height: 17px;
				}
				.scm-text {
					vertical-align: middle;
					padding-left: 5px;
				}
				.scm-img {
					background-color: #ffffff;
					border: 2px #cccccc solid;
					border-radius: 50%;
					width: 27px;
					height: 27px;
					line-height: 32px;
					display: inline-block;
					vertical-align: middle;
					overflow: hidden;
					text-align: center;
					cursor: pointer;
				}
				.scm-img-1 path {
					fill: #999999;
				}
				.scm-img-2 path {
					fill: #999999;
				}
				.scm-img-3 path {
					fill: #999999;
				}
				.scm-img-4 path {
					fill: #999999;
				}
			';
		}

		if ( $is_widget ) {
			$custom_css .= '
				.cache-master-plugin-widget {
					
				}
				.cache-master-plugin-widget .scm-table {
					display: table;                       
					padding: 5px;
					width: 100%;
				}
				.cache-master-plugin-widget .scm-tr {
					display: table-row;
					clear: both;
				}
				.cache-master-plugin-widget .scm-td {
					font-size: 14px;
					padding: 3px 10px;
					display: table-cell;         
				}
			';

			if ( 'text' === $display_widget ) {
				$custom_css .= '
					.cache-master-plugin-widget .scm-img  {
						display: none;
					}
				';
			}

			if ( 'icon' === $display_widget ) {
				$custom_css .= '
					.cache-master-plugin-widget .scm-text  {
						display: none;
					}
					.cache-master-plugin-widget .scm-tr .scm-td:first-child {
						width: 15%;
					}
					.cache-master-plugin-widget .scm-tr .scm-td:last-child {
						width: 85%;
					}
				';
			}
		}

		if ( $is_footer ) {
			$custom_css .= '
				.cache-master-benchmark-report {
					clear: both;
					display: block;
					width: 100%;
					text-align: center;
					font-size: 12px;
					margin: 10px 0;
				}
				.cache-master-benchmark-report .scm-td {
					font-size: 13px;
					display: inline-block;
					position: relative;        
				}
				.cache-master-benchmark-report .scm-value {
					display: inline-block;
					margin-right: 5px;
					vertical-align: middle;
					font-weight: 600;
				}
				.cache-master-benchmark-report .scm-img {
					width: 22px;
					height: 22px;
				}
				.cache-master-benchmark-report .scm-td svg {
					width: 14px;
					height: 14px;
					position: relative;
					top: -4px;
				}
			';

			if ( 'text' === $display_footer ) {
				$custom_css .= '
					.cache-master-benchmark-report .scm-img  {
						display: none;
					}
				';
			}

			if ( 'icon' === $display_footer ) {
				$custom_css .= '
					.cache-master-benchmark-report .scm-text  {
						display: none;
					}
					.cache-master-benchmark-report .scm-value {
						padding-left: 2px;
					}
				';
			}
		}

		if ( ! empty( $custom_css ) ) {
			return preg_replace( '/\s+/', ' ', $custom_css );
		}

		return '';
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
		$sql_queries  = get_num_queries();
		$timer_stop   = $this->wp_timer_stop();
		$memory_usage = $this->get_memory_usage();
		$date         = $this->get_date();
		$stage        = ( $position === 'ob_start' ) ? 'after' : 'before';

		scm_variable_stack( 'now',  $date, $stage );
		scm_variable_stack( 'memory_usage',  $memory_usage, $stage );
		scm_variable_stack( 'sql_queries',  $sql_queries, $stage );
		scm_variable_stack( 'page_generation_time',  $timer_stop, $stage );

		if ( 'no' === get_option( 'scm_option_html_debug_comment' ) ) {
			return '';
		}

		switch ( $position ) {
			case 'ob_start':
				$this->msg();
				$this->msg( '....... ' . __( 'After', 'cache-master' ) . ' .......', 2 );
				$this->msg( sprintf( __( 'Now: %s', 'cache-master' ), $date ) );
				$this->msg( sprintf( __( 'Memory usage: %s MB', 'cache-master' ), $memory_usage ) );
				$this->msg( sprintf( __( 'SQL queries: %s', 'cache-master' ), $sql_queries ) );
				$this->msg( sprintf( __( 'Page generated in %s seconds.', 'cache-master' ), $timer_stop ) );
				$this->msg();
				$this->msg( '//-->' );
				break;

			case 'ob_stop':
				$ttl          = (int) get_option( 'scm_option_ttl' );
				$expires      = time() + $ttl;
				$date_expires = $this->get_date( $expires );

				$this->msg();
				$this->msg( '<!--', 2 );
				$this->msg( __( 'This page is cached by Cache Master plugin.', 'cache-master' ), 2 );
				$this->msg( '....... ' . __( 'Before', 'cache-master' ) . ' .......', 2 );
				$this->msg( sprintf( __( 'Time to cache: %s', 'cache-master' ), $date ) );
				$this->msg( sprintf( __( 'Expires at: %s', 'cache-master' ), $date_expires ) );
				$this->msg( sprintf( __( 'Memory usage: %s MB', 'cache-master' ), $memory_usage ) );
				$this->msg( sprintf( __( 'SQL queries: %s', 'cache-master' ), $sql_queries ) );
				$this->msg( sprintf( __( 'Page generated in %s seconds.', 'cache-master' ), $timer_stop ) );
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

	/**
	 * Get request URI.
	 *
	 * @return string
	 */
	private function get_request_uri()
	{
		static $path;

		if ( isset( $path) ) {
			return $path;
		}

		if ( isset( $_SERVER['REQUEST_URI'] ) ) {
			$path = parse_url( $_SERVER['REQUEST_URI'], PHP_URL_PATH );
		}

		return $path;
	}

	/**
	 * The footer HTML.
	 *
	 * @return void
	 */
	private function footer_html() {
		
		$html = '
			<div class="cache-master-benchmark-report" style="display: none">
				<div class="scm-td">
					<span class="scm-img scm-img-1" title="' . esc_attr( __( 'Cache status powered by Cache Master plugin', 'cache-master' ) ) . '">' . scm_get_svg_icon( 'status' ) . '</span>
					<span class="scm-text">' .  __( 'Cache status', 'cache-master' ) . ': </span>
					<span class="scm-value">';

					if ( $this->ignore ) {
						$html .= '<span>' . __( 'Ignore', 'cache-master' ) . '</span>';
					} else {
						$html .= '<span class="scm-field-cache-status">-</span>';
					}
		$html .= '
					</span>
				</div>
				<div class="scm-td">
					<span class="scm-img scm-img-2" title="' . esc_attr( __( 'Memory usage', 'cache-master' ) ) . '">' . scm_get_svg_icon( 'memory' ) . '</span>
					<span class="scm-text">' .  __( 'Memory usage', 'cache-master' ) . ': </span>
					<span class="scm-value">
						<span class="scm-field-memory-usage">-</span> MB
					</span>
				</div>
				<div class="scm-td">
					<span class="scm-img scm-img-3" title="' . esc_attr( __( 'SQL queries', 'cache-master' ) ) . '">' . scm_get_svg_icon( 'database' ) . '</span>
					<span class="scm-text">' .  __( 'SQL queries', 'cache-master' ) . ': </span>
					<span class="scm-value">
						<span class="scm-field-sql-queries">-</span>
					</span>
				</div>
				<div class="scm-td">
					<span class="scm-img scm-img-4" title="' . esc_attr( __( 'Page generation time', 'cache-master' ) ) . '">' . scm_get_svg_icon( 'speed' ) . '</span>
					<span class="scm-text">' .  __( 'Page generation time', 'cache-master' ) . ': </span>
					<span class="scm-value">
						<span class="scm-field-page-generation-time">-</span> (' .  __( 'sec', 'cache-master' ) . ')
					</span>
				</div>
			</div>';
		
		return $html;
	}

	/**
	 * Check if current page should be ignored or not.
	 *
	 * @return bool
	 */
	private function is_ignore() {
		$uri = $this->get_request_uri();

		if ( true === $this->config['exclusion']['enable'] ) {
			foreach ( $this->config['exclusion']['excluded_list'] as $ignored_url ) {
				if ( strpos( $uri, $ignored_url ) === 0 ) {
					return true;
				}
			}
		}

		if ( true === $this->config['woocommerce']['enable'] ) {	
			if ( isset( $_POST['add-to-cart'] ) && is_numeric( $_POST['add-to-cart'] ) ) {
				return true;
			}
			if ( ! empty( $_COOKIE['woocommerce_items_in_cart'] ) ) {
				return true;
			}
			if ( isset( $_GET['wc-ajax'] ) ) {
				return true;
			}
		}

		$this->ignore = false;

		return false;
	}
}
