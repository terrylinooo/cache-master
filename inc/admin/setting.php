<?php
/**
 * Cache Master - Setting page.
 *
 * @author Terry Lin
 * @link https://terryl.in/
 * @since 1.0.0
 * @version 1.0.0
 */

if ( ! defined( 'SCM_INC' ) ) {
	die;
}

add_action( 'admin_init', 'scm_settings' );

 /**
  * Add settings.
  *
  * @return void
  */
function scm_settings() {

	register_setting( 'scm_setting_group_1', 'scm_option_caching_status' );
	register_setting( 'scm_setting_group_1', 'scm_option_driver' );
	register_setting( 'scm_setting_group_1', 'scm_option_ttl' );
	register_setting( 'scm_setting_group_1', 'scm_option_post_types' );
	register_setting( 'scm_setting_group_1', 'scm_option_uninstall' );

	add_settings_section(
		'scm_setting_section_1',
		__( 'Driver', 'cache-master' ),
		'scm_cb_setting_section',
		'scm_setting_page_1'
	);

	add_settings_section(
		'scm_setting_section_2',
		__( 'Preferences', 'cache-master' ),
		'scm_cb_setting_section',
		'scm_setting_page_1'
	);

	add_settings_section(
		'scm_setting_section_3',
		__( 'Others', 'cache-master' ),
		'scm_cb_setting_section',
		'scm_setting_page_1'
	);

	add_settings_field(
		'scm_option_id_5',
		__( 'Caching Status', 'cache-master' ),
		'scm_cb_caching_status',
		'scm_setting_page_1',
		'scm_setting_section_1'
	);

	add_settings_field(
		'scm_option_id_1',
		__( 'Cache Driver', 'cache-master' ),
		'scm_cb_driver',
		'scm_setting_page_1',
		'scm_setting_section_1'
	);

	add_settings_field(
		'scm_option_id_2',
		__( 'Time to Live', 'cache-master' ),
		'scm_cb_ttl',
		'scm_setting_page_1',
		'scm_setting_section_1'
	);

	add_settings_field(
		'scm_option_id_3',
		__( 'Uninstall', 'cache-master' ),
		'scm_cb_uninstall_option',
		'scm_setting_page_1',
		'scm_setting_section_3'
	);

	add_settings_field(
		'scm_option_id_4',
		__( 'Post Types', 'cache-master' ),
		'scm_cb_post_types',
		'scm_setting_page_1',
		'scm_setting_section_2'
	);
}

function scm_cb_setting_section() {
	echo __( '', 'cache-master' );
}

/**
 * Setting block - Choose a data driver for cache functionality.
 *
 * @return void
 */
function scm_cb_driver() {
	$option_driver_type = get_option( 'scm_option_driver', 'local' );

	$option_list = array(
		'file'      => __( 'File', 'cache-master' ),
		'redis'     => __( 'Redis', 'cache-master' ),
		'memcache'  => __( 'Memcache', 'cache-master' ),
		'memcached' => __( 'Memcached', 'cache-master' ),
		'apc'       => __( 'APC', 'cache-master' ),
		'apcu'      => __( 'APCu', 'cache-master' ),
		'wincache'  => __( 'WinCache', 'cache-master' ),
		'mysql'     => __( 'MySQL', 'cache-master' ),
		'sqlite'    => __( 'SQLite', 'cache-master' ),
	);

	$driver_status = array();

	foreach ( array_keys( $option_list ) as $v ) {
		$driver_status[ $v ] = scm_test_driver( $v );
	}

	?>

	<div>
		<div>
			<select name="scm_option_driver" class="regular">
				<?php foreach ( $option_list as $k => $v ) : ?>
					<?php if ( $driver_status[ $k ] ) : ?>
						<option value="<?php echo $k; ?>" <?php selected( $option_driver_type, $k ); ?>><?php echo  $v; ?></option>
					<?php else: ?>
						<option value="<?php echo $k; ?>" disabled><?php echo  $v; ?></option>
					<?php endif; ?>
				<?php endforeach; ?>
			</select>
		</div>
		<p><em><?php echo __( 'Choose a driver to cache your posts and pages.', 'cache-master' ); ?></em></p>
	</div>
	<div>
		<div class="driver-status-container">
		<?php foreach ( $option_list as $k => $v ) : ?>

			<div class="driver-status-box">
				<table style="border: 0; width: 100%">
					<tr>
						<td style="width: 80%"><?php echo $v; ?></td>
						<td style="width: 20%">
							<?php if ( $driver_status[ $k ] ) : ?>
								<span class="dashicons dashicons-marker" style="color: #23b900"></span>
							<?php else : ?>
								<span class="dashicons dashicons-marker" style="color: #c60900"></span>

							<?php endif; ?>
						</td>
					</tr>
				</table>
			</div>
		<?php endforeach; ?>
		</div>
	</div>
	<?php
}

/**
 * Setting block - TTL
 *
 * @return void
 */
function scm_cb_ttl() {
	$option_ttl = (int) get_option( 'scm_option_ttl', '86400' );

	// 5 minutes.
	if ( $option_ttl < 300 ) {
		$option_ttl = '300';
		update_option( 'scm_option_ttl', $option_ttl );
	}

	// 24 hours.
	if ( $option_ttl > 86400 ) {
		$option_ttl = '86400';
		update_option( 'scm_option_ttl', $option_ttl );
	}
	?>
		<div>
			<div>
				<input type="text" name="scm_option_ttl" value="<?php echo esc_attr( $option_ttl ); ?>">
			</div>
		</div>
		<p><em><?php echo __( 'Please fill in a number between 300-86400. (in seconds)', 'cache-master' ); ?></em></p>
	<?php
}

/**
 * Setting block - Uninstalling option.
 *
 * @return void
 */
function scm_cb_uninstall_option() {
	$option_uninstall = get_option( 'scm_option_uninstall', 'yes' );
	?>
		<div>
			<div>
				<input type="radio" name="scm_option_uninstall" id="cache-master-uninstall-option-yes" value="yes" 
					<?php checked( $option_uninstall, 'yes' ); ?>>
				<label for="cache-master-uninstall-option-yes">
					<?php echo __( 'Remove Cache Master generated data.', 'cache-master' ); ?><br />
				<label>
			</div>
			<div>
				<input type="radio" name="scm_option_uninstall" id="cache-master-uninstall-option-no" value="no" 
					<?php checked( $option_uninstall, 'no' ); ?>>
				<label for="cache-master-uninstall-option-no">
					<?php echo __( 'Keep Cache Master generated data.', 'cache-master' ); ?>
				<label>
			</div>	
		</div>
		<p><em><?php echo __( 'This option only works when you uninstall this plugin.', 'cache-master' ); ?></em></p>
	<?php
}

/**
 * Supported post types.
 *
 * @return void
 */
function scm_cb_post_types() {
	$option_post_types = get_option( 'scm_option_post_types');

	$option_list = array(
		'home' => __( 'Home', 'cache-master' ),
		'post' => __( 'Post', 'cache-master' ),
		'page' => __( 'Page', 'cache-master' ),
	);

	?>
		<div>
			<?php foreach ( $option_list as $k => $v ) : ?>
			<div>
				<input type="checkbox" name="scm_option_post_types[<?php echo $k; ?>]" id="cache-master-post-type-option-<?php echo $k; ?>" value="yes" 
					<?php checked( $option_post_types[ $k ], 'yes' ); ?>>
				<label for="cache-master-post-type-option-<?php echo $k; ?>">
					<?php echo $v; ?><br />
				<label>
			</div>
			<?php endforeach; ?>
		</div>
		<p><em><?php echo __( 'What post type do you like to cache?', 'cache-master' ); ?></em></p>
		<p><em><?php echo __( 'Once you change this option, all cache data will be cleared.', 'cache-master' ); ?></em></p>
	<?php
}

/**
 * Setting block - Cacing status.
 *
 * @return void
 */
function scm_cb_caching_status() {
	$option_caching_status = get_option( 'scm_option_caching_status', 'disable' );
	?>
		<div>
			<div>
				<input type="radio" name="scm_option_caching_status" id="cache-master-caching-status-enable" value="enable" 
					<?php checked( $option_caching_status, 'enable' ); ?>>
				<label for="cache-master-caching-status-enable">
					<?php echo __( 'Enable', 'cache-master' ); ?><br />
				<label>
			</div>
			<div>
				<input type="radio" name="scm_option_caching_status" id="cache-master-caching-status-disable" value="disable" 
					<?php checked( $option_caching_status, 'disable' ); ?>>
				<label for="cache-master-caching-status-disable">
					<?php echo __( 'Disable', 'cache-master' ); ?>
				<label>
			</div>	
		</div>
		<p><em><?php echo __( 'Once you make this option disable, Cache Master will stop working and all cache  will be cleared.', 'cache-master' ); ?></em></p>
	<?php
}