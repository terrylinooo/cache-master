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

$option_benchmark_footer_text_display = get_option( 'scm_option_benchmark_footer_text_display', 'text' );

?>

<div>
	<div class="scm-option-item">
		<input type="radio" name="scm_option_benchmark_footer_text_display" id="cache-master-benchmark-footer-text-display-option-text" value="text" 
			<?php checked( $option_benchmark_footer_text_display, 'text' ); ?>>
		<label for="cache-master-benchmark-footer-text-display-option-text">
			<?php _e( 'Text', 'cache-master' ); ?><br />
		<label>
	</div>
	<div class="scm-option-item">
		<input type="radio" name="scm_option_benchmark_footer_text_display" id="cache-master-benchmark-footer-text-display-option-icon" value="icon" 
			<?php checked( $option_benchmark_footer_text_display, 'icon' ); ?>>
		<label for="cache-master-benchmark-footer-text-display-option-icon">
			<?php _e( 'Icon', 'cache-master' ); ?>
		<label>
	</div>
	<div class="scm-option-item">
		<input type="radio" name="scm_option_benchmark_footer_text_display" id="cache-master-benchmark-footer-text-display-option-icon" value="both" 
			<?php checked( $option_benchmark_footer_text_display, 'both' ); ?>>
		<label for="cache-master-benchmark-footer-text-display-option-both">
			<?php _e( 'Both', 'cache-master' ); ?>
		<label>
	</div>	
</div>
<p><em><?php _e( 'Would you like to use text or icon as the label name when display benchmark results?', 'cache-master' ); ?></em></p>
<p><em><?php _e( 'Example', 'cache-master' ); ?>:</em></p>
<div class="scm-option-example">
	<img id="img-footer-example" src="">
</div>


<script>
	(function($) {
		$(function() {
			var img_footer_example = [];
			img_footer_example['text'] = '<?php echo SCM_PLUGIN_URL; ?>inc/assets/images/sample-benchmark-footer-1.png';
			img_footer_example['icon'] = '<?php echo SCM_PLUGIN_URL; ?>inc/assets/images/sample-benchmark-footer-2.png';
			img_footer_example['both'] = '<?php echo SCM_PLUGIN_URL; ?>inc/assets/images/sample-benchmark-footer-3.png';

			function check_footer_option() {
				var option = $('input[name=scm_option_benchmark_footer_text_display]:checked').val();
				$('#img-footer-example').attr('src', img_footer_example[option]);
			}

			$('input[name=scm_option_benchmark_footer_text_display]').change(function() {
				check_footer_option();
			});

			check_footer_option();
		});
	})(jQuery);
</script>
