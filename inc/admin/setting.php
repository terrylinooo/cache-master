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
			<?php foreach ( $option_list as $k => $v ) : ?>
				<div>
					<?php if ( $driver_status[ $k ] ) : ?>
						<input type="radio" name="scm_option_driver" id="scm-cache-driver-<?php echo $k; ?>" value="<?php echo $k; ?>" <?php checked( $option_driver_type, $k ); ?>>
					<?php else: ?>
						<input type="radio" name="scm_option_driver" id="scm-cache-driver-<?php echo $k; ?>" value="<?php echo $k; ?>" disabled>
					<?php endif; ?>
					<label for="scm-cache-driver-<?php echo $k; ?>">
						<?php if ( $driver_status[ $k ] ) : ?>
							<?php echo $v; ?>
						<?php else: ?>
							<span style="color: #aaa"><?php echo $v; ?></span>
						<?php endif; ?>
						<?php if ( 'file' === $k ) : ?>
							(<?php echo __( 'default', 'cache-master' ); ?>)
						<?php endif; ?>
					<label>
				</div>
			<?php endforeach; ?>
			<p><em><?php echo __( 'Choose a driver to cache your posts and pages.', 'cache-master' ); ?></em></p>
		</div>
	<?php
}

/**
 * Setting block - TTL
 *
 * @return void
 */
function scm_cb_ttl() {
	$option_ttl = get_option( 'scm_option_ttl', 'yes' );
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
		<p><em><?php echo __( 'What post types do you like to cache?', 'cache-master' ); ?></em></p>
		<p><em><?php echo __( 'Once you change this option, all cache data will be cleared.', 'cache-master' ); ?></em></p>
	<?php
}
