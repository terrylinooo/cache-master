<?php
/**
 * Cache Master - Menu.
 *
 * @author Terry Lin
 * @link https://terryl.in/
 * @since 1.0.0
 * @version 1.0.0
 */

if ( ! defined( 'SCM_INC' ) ) {
	die;
}

add_action( 'admin_menu', 'scm_option' );
add_action( 'admin_enqueue_scripts', 'scm_admin_enqueue_scripts' );
add_action( 'admin_enqueue_scripts', 'scm_admin_enqueue_styles' );
add_filter( 'plugin_action_links_' . SCM_PLUGIN_NAME, 'scm_plugin_action_links', 10, 5 );
add_filter( 'plugin_row_meta', 'scm_plugin_extend_links', 10, 2 );

/**
 * Register the plugin setting page.
 *
 * @return void
 */
function scm_option() {

	add_menu_page(
		__( 'Cache Master', 'cache-master' ),
		__( 'Cache Master', 'cache-master' ),
		'manage_options',
		'cache-master-settings',
		'__return_false',
		'dashicons-superhero'
	);

	add_submenu_page(
		'cache-master-settings',
		__( 'Settings', 'cache-master' ),
		__( 'Settings', 'cache-master' ),
		'manage_options',
		'cache-master-settings',
		'scm_options_page'
	);

	add_submenu_page(
		'cache-master-settings',
		__( 'Expert Mode', 'cache-master' ),
		__( 'Expert Mode', 'cache-master' ),
		'manage_options',
		'cache-master-expert-mode',
		'scm_expert_mode_page'
	);
}

/**
 * Output the setting page.
 *
 * @return void
 */
function scm_options_page() {
	scm_show_settings_header();
	?>
	   <form action="options.php" method="post">
		   <?php settings_fields( 'scm_setting_group_1' ); ?>
		   <?php do_settings_sections( 'scm_setting_page_1' );  ?>
		   <hr />
		   <?php submit_button(); ?>
	   </form>
   <?php
   scm_show_settings_footer();
}

/**
 * Output the expert mode page.
 *
 * @return void
 */
function scm_expert_mode_page() {
	scm_show_settings_header();
	?>
	   <div id="scm-expert-mode-page">
			<h2><?php _e( 'Expert Mode', 'cache-master' ); ?></h2>
			<div class="scm-expert-mode-intro">
				<p><?php _e( 'Because Cache Master works after all plguins installed, it can only save a maximum of 20-25 percent memory.', 'cache-master' ); ?> <code>:(</code></p>
				<p><?php echo sprintf( __( 'However, if you modify %s to let Cache Master output cache before everything initialized, it can save up to a maximum of <strong>95</strong> percent memory - even more.', 'cache-master' ), '<code>wp-config.php</code>' ); ?><code>:)</code></p>
			</div>
			<h2><?php _e( 'Code', 'cache-master' ); ?></h2>
			<p><?php _e( 'This PHP code is generated automatically  depends on your settings.', 'cache-master' ); ?></p>
			<p><?php echo sprintf( __( 'Please modify %s and put the following code into %s', 'cache-master' ), '<code>' . ABSPATH . 'wp-config.php</code>', '<code>wp-config.php</code>' ); ?></p>
			<div class="scm-code-block">
				
				<pre>
					<code>
// BEGIN - Cache Master

if ( file_exists( '<?php echo SCM_PLUGIN_DIR; ?>inc/expert-mode.php' ) ) {

    include_once( '<?php echo SCM_PLUGIN_DIR; ?>inc/expert-mode.php' );

    $args = array(
        'plugin_dir'        => '<?php echo rtrim( SCM_PLUGIN_DIR, '/' ); ?>',
        'plugin_upload_dir' => '<?php echo rtrim( scm_get_upload_dir(), '/' ); ?>',
        'site_url'          => '<?php echo rtrim( get_site_url(), '/' ); ?>',
        'cache_driver_type' => '<?php echo get_option( 'scm_option_driver' ); ?>',
    );

    scm_run_expert_mode( $args );
}

// END - Cache Master
					</code>
				</pre>
			</div>
			<h2><?php _e( 'Guide', 'cache-master' ); ?></h2>
			<p><?php _e( 'The position of the PHP code is supposed to put right after the DB constants.', 'cache-master' ); ?> (<code>DB_COLLATE</code>)</p>
			<div>
				<img src="<?php echo SCM_PLUGIN_URL; ?>inc/assets/images/expert-mode-code.png">	
			</div>
			<p><?php echo sprintf( __( 'Once you have done things right, if you are using Chome, %s or right click and select "View Source" to vew the HTML source code.', 'cache-master' ), '<code>Ctrl + U</code>' ); ?></p>
			<div>
				<img src="<?php echo SCM_PLUGIN_URL; ?>inc/assets/images/expert-mode-result.png">	
			</div>
			<p><?php _e( 'You should see the result like this.', 'cache-master' ); ?></p>
		</div>
   <?php
   scm_show_settings_footer();
}


/**
 * Filters the action links displayed for each plugin in the Network Admin Plugins list table.
 *
 * @param array  $links Original links.
 * @param string $file  File position.
 *
 * @return array Combined links.
 */
function scm_plugin_action_links( $links, $file ) {
	if ( ! current_user_can( 'manage_options' ) ) {
		return $links;
	}

	if ( $file === SCM_PLUGIN_NAME ) {
		$links[] = '<a href="' . admin_url( "admin.php?page=" . SCM_PLUGIN_TEXT_DOMAIN ) . '">' . __( 'Settings', 'cache-master' ) . '</a>';
		return $links;
	}
}

/**
 * Add links to plugin meta information on plugin list page.
 *
 * @param array  $links Original links.
 * @param string $file  File position.
 *
 * @return array Combined links.
 */
function scm_plugin_extend_links( $links, $file ) {
	if ( ! current_user_can( 'install_plugins' ) ) {
		return $links;
	}

	if ( $file === SCM_PLUGIN_NAME ) {
		$links[] = '<a href="https://github.com/terrylinooo/cache-master" target="_blank">' . __( 'Source code', 'cache-master' ) . '</a>';
	}
	return $links;
}

/**
 * Load specfic CSS file for the Cache Master setting page.
 */
function scm_admin_enqueue_styles( $hook_suffix ) {

	if ( false === strpos( $hook_suffix, 'cache-master' ) ) {
		return;
	}
	wp_enqueue_style( 'custom_wp_admin_css', SCM_PLUGIN_URL . 'inc/assets/css/admin-style.css', array(), SCM_PLUGIN_VERSION, 'all' );
	wp_enqueue_style (  'wp-jquery-ui-dialog' );
}

/**
 * Register JS files.
 */
function scm_admin_enqueue_scripts( $hook_suffix ) {

	if ( false === strpos( $hook_suffix, 'cache-master' ) ) {
		return;
	}
	wp_enqueue_script( 'jquery-ui-dialog' );
}


/**
 * Show header on setting pages.
 *
 * @return void
 */
function scm_show_settings_header() {
	$git_url_core = 'https://github.com/terrylinooo/simple-cache';
	$git_url_plugin = 'https://github.com/terrylinooo/cache-master';

	echo '<div class="cache-master-info-bar">';
	echo '	<div class="logo-info"><img src="' . SCM_PLUGIN_URL . 'inc/assets/images/logo.png" class="cache-master-logo"></div>';
	echo '	<div class="version-info">';
	echo '    Core: <a href="' . $git_url_core . '" target="_blank">' . SCM_CORE_VERSION . '</a>  ';
	echo '    Plugin: <a href="' . $git_url_plugin . '" target="_blank">' . SCM_PLUGIN_VERSION . '</a>  ';
	echo '  </div>';
	echo '</div>';
	echo '<div class="wrap scm-wrap">';

	if ( '' === get_option( 'permalink_structure') ) {
		$url_html = '<a href="' . get_bloginfo( 'url' ) . '/wp-admin/options-permalink.php">' . __( 'Permalink Setting', 'seo-search-permalink' ) . '</a>';
		echo '<div class="notice notice-error is-dismissible"><p>';
		echo __( 'Cache Master supports only static URL structure.', 'cache-master' ) . ' ';
		printf( __( 'You have to go to %s page and change the permalink settings.', 'cache-master' ), $url_html );
		echo '</p></div>';
	}
}

/**
 * Show footer on setting pages.
 *
 * @return void
 */
function scm_show_settings_footer() {
	echo '</div>';
}