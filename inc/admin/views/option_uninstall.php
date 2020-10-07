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

$option_uninstall = get_option( 'scm_option_uninstall', 'yes' );

?>

<div>
	<div>
		<input type="radio" name="scm_option_uninstall" id="cache-master-uninstall-option-yes" value="yes" 
			<?php checked( $option_uninstall, 'yes' ); ?>>
		<label for="cache-master-uninstall-option-yes">
			<?php echo __( 'Remove Cache Master generated data.', 'cache-master' ); ?><br />
		<label>
	</div>
	<div>
		<input type="radio" name="scm_option_uninstall" id="cache-master-uninstall-option-no" value="no" 
			<?php checked( $option_uninstall, 'no' ); ?>>
		<label for="cache-master-uninstall-option-no">
			<?php echo __( 'Keep Cache Master generated data.', 'cache-master' ); ?>
		<label>
	</div>	
</div>
<p><em><?php echo __( 'This option only works when you uninstall this plugin.', 'cache-master' ); ?></em></p>
