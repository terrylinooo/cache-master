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

$option_benchmark_widget_display = get_option( 'scm_option_benchmark_widget_display', 'both' );

?>

<div>
	<div class="scm-option-item">
		<input type="radio" name="scm_option_benchmark_widget_display" id="cache-master-benchmark-widget-display-option-text" value="text" 
			<?php checked( $option_benchmark_widget_display, 'text' ); ?>>
		<label for="cache-master-benchmark-widget-option-text">
			<?php _e( 'Text', 'cache-master' ); ?><br />
		<label>
	</div>
	<div class="scm-option-item">
		<input type="radio" name="scm_option_benchmark_widget_display" id="cache-master-benchmark-widget-display-option-icon" value="icon" 
			<?php checked( $option_benchmark_widget_display, 'icon' ); ?>>
		<label for="cache-master-benchmark-widget-display-option-icon">
			<?php _e( 'Icon', 'cache-master' ); ?>
		<label>
	</div>
	<div class="scm-option-item">
		<input type="radio" name="scm_option_benchmark_widget_display" id="cache-master-benchmark-widget-display-option-both" value="both" 
			<?php checked( $option_benchmark_widget_display, 'both' ); ?>>
		<label for="cache-master-benchmark-widget-display-option-both">
			<?php _e( 'Both', 'cache-master' ); ?>
		<label>
	</div>	
</div>
<p><em><?php _e( 'Would you like to use text or icon as the label name when display benchmark results?', 'cache-master' ); ?></em></p>
<p><em><?php _e( 'Example', 'cache-master' ); ?>:</em></p>
<div class="scm-option-example">
	<img src="<?php echo SCM_PLUGIN_URL; ?>inc/assets/images/sample-benchmark-widget.png">
</div>