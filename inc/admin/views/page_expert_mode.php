<?php
/**
 * Cache Master - Expert-mode.
 *
 * @author Terry Lin
 * @link https://terryl.in/
 * @since 1.2.1
 * @version 1.2.1
 */

if ( ! defined( 'SCM_INC' ) ) {
	die;
}
?>

<div id="scm-expert-mode-page">
	<form action="options.php" method="post">
		<?php settings_fields( 'scm_setting_group_2' ); ?>
		<?php do_settings_sections( 'scm_setting_page_2' );  ?>
		<hr />
		<?php submit_button(); ?>
	</form>
	<h2><?php _e( 'Code', 'cache-master' ); ?></h2>
	<p><?php _e( 'This PHP code is generated dynamically depends on your settings.', 'cache-master' ); ?></p>
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
		<img src="<?php echo SCM_PLUGIN_URL; ?>inc/assets/images/screenshot-3.png">	
	</div>
	<p><?php _e( 'You should see the result like this.', 'cache-master' ); ?></p>
</div>
