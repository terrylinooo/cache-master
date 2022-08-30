<?php
/**
 * Cache Master - Exclusion status.
 *
 * @author Terry Lin
 * @link https://terryl.in/
 * @since 1.6.0
 * @version 1.6.0
 */

if ( ! defined( 'SCM_INC' ) ) {
	die;
}

$option_exclusion_status = get_option( 'scm_option_exclusion_status', 'no' );

?>

<div>
	<div class="scm-option-item">
		<input type="radio" name="scm_option_exclusion_status" id="cache-master-exclusion-status-option-yes" value="yes" 
			<?php checked( $option_exclusion_status, 'yes' ); ?>>
		<label for="cache-master-exclusion-status-option-yes">
			<?php _e( 'Yes', 'cache-master' ); ?><br />
		<label>
	</div>
	<div class="scm-option-item">
		<input type="radio" name="scm_option_exclusion_status" id="cache-master-exclusion-status-option-no" value="no" 
			<?php checked( $option_exclusion_status, 'no' ); ?>>
		<label for="cache-master-exclusion-status-option-no">
			<?php _e( 'No', 'cache-master' ); ?>
		<label>
	</div>	
</div>
<p><em><?php _e( 'The following settings work only when this option is enabled.', 'cache-master' ); ?></em></p>
