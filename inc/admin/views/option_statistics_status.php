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
			<?php echo __( 'Enable', 'cache-master' ); ?><br />
		<label>
	</div>
	<div class="scm-option-item">
		<input type="radio" name="scm_option_statistics_status" id="cache-master-statistics-option-disable" value="disable" 
			<?php checked( $option_statistics_status, 'disable' ); ?>>
		<label for="cache-master-statistics-option-disable">
			<?php echo __( 'Disable', 'cache-master' ); ?>
		<label>
	</div>	
</div>
<p><em><?php echo __( 'Record the caching information.', 'cache-master' ); ?></em></p>