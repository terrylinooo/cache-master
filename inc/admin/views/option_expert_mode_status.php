<?php
/**
 * Cache Master - Uninstall option.
 *
 * @author Terry Lin
 * @link https://terryl.in/
 * @since 1.2.1
 * @version 1.0.0
 */

if ( ! defined( 'SCM_INC' ) ) {
	die;
}

$option_expert_mode = get_option( 'scm_option_expert_mode_status', 'enable' );

?>

<div class="scm-expert-mode-intro">
	<p><?php _e( 'Because Cache Master works after all plguins installed, it can only save a maximum of 20-25 percent memory.', 'cache-master' ); ?> <code>:(</code></p><br />
	<p><?php echo sprintf( __( 'However, if you modify %s to let Cache Master output cache before everything initialized, it can save up to a maximum of <strong>95</strong> percent memory - even more.', 'cache-master' ), '<strong>wp-config.php</strong>' ); ?><code>:)</code></p>
</div>
<br /><br />
<div>
	<div>
		<input type="radio" name="scm_option_expert_mode_status" id="cache-master-uninstall-option-enable" value="enable" 
			<?php checked( $option_expert_mode, 'enable' ); ?>>
		<label for="cache-master-expert-mode-option-enable">
			<?php echo __( 'Enable', 'cache-master' ); ?><br />
		<label>
	</div>
	<div>
		<input type="radio" name="scm_option_expert_mode_status" id="cache-master-uninstall-option-disable" value="disable" 
			<?php checked( $option_expert_mode, 'disable' ); ?>>
		<label for="cache-master-expert-mode-option-disable">
			<?php echo __( 'Disable', 'cache-master' ); ?>
		<label>
	</div>	
</div>
<p><em><?php echo __( 'This option only works when you have put the custom PHP code in wp-config.php', 'cache-master' ); ?></em></p>
