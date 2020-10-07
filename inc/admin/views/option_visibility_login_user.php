<?php
/**
 * Cache Master - The visibility of cache for logged-in users.
 *
 * @author Terry Lin
 * @link https://terryl.in/
 * @since 1.2.1
 * @version 1.0.0
 */

if ( ! defined( 'SCM_INC' ) ) {
	die;
}

$option_visibility_login_user = get_option( 'scm_option_visibility_login_user', 'no' );

?>

<div>
	<div>
		<input type="radio" name="scm_option_visibility_login_user" id="cache-master-visibility-login-user-option-yes" value="yes" 
			<?php checked( $option_visibility_login_user, 'yes' ); ?>>
		<label for="cache-master-visibility-login-user-option-yes">
			<?php echo __( 'Yes', 'cache-master' ); ?><br />
		<label>
	</div>
	<div>
		<input type="radio" name="scm_option_visibility_login_user" id="cache-master-visibility-login-user-option-no" value="no" 
			<?php checked( $option_visibility_login_user, 'no' ); ?>>
		<label for="cache-master-visibility-login-user-option-no">
			<?php echo __( 'No', 'cache-master' ); ?>
		<label>
	</div>	
</div>
<p><em><?php echo __( 'Would you like to show cached pages to logged-in users as well?', 'cache-master' ); ?></em></p>
<br />
<p><strong><?php echo __( 'Note', 'cache-master' ); ?></strong></p>
<p><em><?php echo __( 'Logged-in users will not trigger the caching processes to avoid displaying admin bar to everyone.', 'cache-master' ); ?></em></p>
<p><em><?php echo __( 'Logged-in users always see cached page when Expert Mode is working, because of outputting cache at a very early stage when running as Expert Mode.', 'cache-master' ); ?></em></p>
