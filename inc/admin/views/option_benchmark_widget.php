<?php
/**
 * Cache Master - Uninstall option.
 *
 * @author Terry Lin
 * @link https://terryl.in/
 * @since 1.3.0
 * @version 1.3.0
 */

if ( ! defined( 'SCM_INC' ) ) {
	die;
}

$option_benchmark_widget = get_option( 'scm_option_benchmark_widget', 'no' );

?>

<div>
	<div class="scm-option-item">
		<input type="radio" name="scm_option_benchmark_widget" id="cache-master-benchmark-widget-option-yes" value="yes" 
			<?php checked( $option_benchmark_widget, 'yes' ); ?>>
		<label for="cache-master-benchmark-widget-option-yes">
			<?php _e( 'Yes', 'cache-master' ); ?><br />
		<label>
	</div>
	<div class="scm-option-item">
		<input type="radio" name="scm_option_benchmark_widget" id="cache-master-benchmark-widget-option-no" value="no" 
			<?php checked( $option_benchmark_widget, 'no' ); ?>>
		<label for="cache-master-benchmark-widget-option-no">
			<?php _e( 'No', 'cache-master' ); ?>
		<label>
	</div>	
</div>
<p><em><?php _e( 'Register a widget that can show the benchmark information.', 'cache-master' ); ?></em></p>
<p><em><?php _e( 'Once you change this option, all cache data will be cleared.', 'cache-master' ); ?></em></p>