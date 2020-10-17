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

$option_benchmark_footer_text = get_option( 'scm_option_benchmark_footer_text', 'no' );

?>

<div>
	<div class="scm-option-item">
		<input type="radio" name="scm_option_benchmark_footer_text" id="cache-master-benchmark-footer-text-option-yes" value="yes" 
			<?php checked( $option_benchmark_footer_text, 'yes' ); ?>>
		<label for="cache-master-benchmark-footer-text-option-yes">
			<?php _e( 'Yes', 'cache-master' ); ?><br />
		<label>
	</div>
	<div class="scm-option-item">
		<input type="radio" name="scm_option_benchmark_footer_text" id="cache-master-benchmark-footer-text-option-no" value="no" 
			<?php checked( $option_benchmark_footer_text, 'no' ); ?>>
		<label for="cache-master-benchmark-footer-text-option-no">
			<?php _e( 'No', 'cache-master' ); ?>
		<label>
	</div>	
</div>
<p><em><?php _e( 'Display the benchmark information in the footer area.', 'cache-master' ); ?></em></p>
<p><em><?php _e( 'Once you change this option, all cache data will be cleared.', 'cache-master' ); ?></em></p>