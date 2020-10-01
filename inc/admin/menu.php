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

/**
 * Register the plugin setting page.
 *
 * @return void
 */
function scm_option() {
	
	if ( function_exists( 'add_options_page' ) ) {
		add_options_page(
			__( 'Cache Master', 'cache-master' ),
			__( 'Cache Master', 'cache-master' ),
			'manage_options',
			'cache-master.php',
			'scm_options_page'
		);
	}
}

/**
 * Output the setting page.
 *
 * @return void
 */
function scm_options_page() {
	?>

   <div class="wrap">
	   <h1>Cache Master 
			<small style="font-size: 12px;">
				<a href="https://github.com/terrylinooo/cache-master" target="_blank" style="text-decoration: none"><?php echo SCM_PLUGIN_VERSION; ?></a>
				by <a href="https://github.com/terrylinooo" target="_blank" style="text-decoration: none">TerryL</a>
			</small>
			<small style="font-size: 12px; float: right; border: 1px #dddddd solid; padding: 3px 5px; margin-top: 3px; background-color: #ffffff;">
				<a href="https://github.com/terrylinooo/simple-cache" target="_blank" style="text-decoration: none">Core <?php echo SCM_PLUGIN_CORE_VERSION; ?></a> 
			</small>
		</h1>
	   <hr />
	   <form action="options.php" method="post">
		   <?php settings_fields( 'scm_setting_group_1' ); ?>
		   <?php do_settings_sections( 'scm_setting_page_1' );  ?>
		   <hr />
		   <?php submit_button(); ?>
	   </form>
   </div>

   <?php
}
