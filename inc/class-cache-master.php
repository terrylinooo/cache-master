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

class Cache_Master {

	/**
	 * Constructer.
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'load_textdomain' ) );
	}
	
	/**
	 * Initialize everything the SCM plugin needs.
	 */
	public function init() {

		
	}

	/*
	 * Load plugin textdomain.
	 */
	public function load_textdomain() {
		load_plugin_textdomain( SCM_PLUGIN_TEXT_DOMAIN, false, SCM_PLUGIN_LANGUAGE_PACK ); 
	}
}