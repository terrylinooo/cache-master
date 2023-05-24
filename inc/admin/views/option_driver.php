<?php
/**
 * Cache Master - Driver.
 *
 * @author Terry Lin
 * @link https://terryl.in/
 * @since 1.0.0
 * @version 1.0.0
 */

if ( ! defined( 'SCM_INC' ) ) {
	die;
}

$option_driver_type = get_option( 'scm_option_driver', 'file' );

$option_list = array(
	'file'      => __( 'File', 'cache-master' ),
	'redis'     => __( 'Redis', 'cache-master' ),
	'memcache'  => __( 'Memcache', 'cache-master' ),
	'memcached' => __( 'Memcached', 'cache-master' ),
	'apc'       => __( 'APC', 'cache-master' ),
	'apcu'      => __( 'APCu', 'cache-master' ),
	'wincache'  => __( 'WinCache', 'cache-master' ),
	'mongo'     => __( 'MongoDB', 'cache-master' ),
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
					<option value="<?php echo $k; ?>" <?php selected( $option_driver_type, $k ); ?>><?php echo $v; ?></option>
				<?php else : ?>
					<option value="<?php echo $k; ?>" disabled><?php echo $v; ?></option>
				<?php endif; ?>
			<?php endforeach; ?>
		</select>
	</div>
	<p><em><?php _e( 'Choose a driver to cache your posts and pages.', 'cache-master' ); ?></em></p>
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
							<?php if ( $option_driver_type == $k ) : ?>
 								<span class="dashicons dashicons-yes-alt" style="color: #23b900"></span>
			 				<?php else : ?>
 								<span class="dashicons dashicons-marker" style="color: #23b900"></span>
 							<?php endif; ?>
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
