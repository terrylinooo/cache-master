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

$option_visibility_guest = get_option( 'scm_option_visibility_guest', 'yes' );

?>

<div>
	<div>
		<input type="radio" name="scm_option_visibility_guest" id="cache-master-visibility-guest-option-yes" value="yes" 
			<?php checked( $option_visibility_guest, 'yes' ); ?>>
		<label for="cache-master-visibility-guest-option-yes">
			<?php echo __( 'Yes', 'cache-master' ); ?><br />
		<label>
	</div>
</div>
<p><em><?php echo __( 'Always show cached pages to guests.', 'cache-master' ); ?></em></p>
