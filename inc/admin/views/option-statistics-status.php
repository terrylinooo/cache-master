<?php
/**
 * Cache Master - Statistic status
 *
 * @author Terry Lin
 * @link https://terryl.in/
 * @since 1.4.0
 * @version 1.4.0
 */

if ( ! defined( 'SCM_INC' ) ) {
	die;
}

$option_statistics_status = get_option( 'scm_option_statistics_status', 'disable' );

?>

<div>
	<div class="scm-option-item">
		<input type="radio" name="scm_option_statistics_status" id="cache-master-statistics-option-enable" value="enable" 
			<?php checked( $option_statistics_status, 'enable' ); ?>>
		<label for="cache-master-statistics-option-enable">
			<?php _e( 'Enable', 'cache-master' ); ?><br />
		<label>
	</div>
	<div class="scm-option-item">
		<input type="radio" name="scm_option_statistics_status" id="cache-master-statistics-option-disable" value="disable" 
			<?php checked( $option_statistics_status, 'disable' ); ?>>
		<label for="cache-master-statistics-option-disable">
			<?php _e( 'Disable', 'cache-master' ); ?>
		<label>
	</div>	
</div>
<p><em><?php _e( 'Record the caching information.', 'cache-master' ); ?></em></p>
