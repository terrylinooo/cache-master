<?php
/**
 * Cache Master - Caching status.
 *
 * @author Terry Lin
 * @link https://terryl.in/
 * @since 1.0.0
 * @version 1.0.0
 */

if ( ! defined( 'SCM_INC' ) ) {
	die;
}

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

