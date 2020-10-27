<?php
/**
 * Cache Master - WooCommerce - Status.
 *
 * @author Terry Lin
 * @link https://terryl.in/
 * @since 1.6.0
 * @version 1.6.0
 */

if ( ! defined( 'SCM_INC' ) ) {
	die;
}

$option_woocommerce_status = get_option( 'scm_option_woocommerce_status', 'no' );

?>

<div>
	<div class="scm-option-item">
		<input type="radio" name="scm_option_woocommerce_status" id="cache-master-woocommerce-status-option-yes" value="yes" 
			<?php checked( $option_woocommerce_status, 'yes' ); ?>>
		<label for="cache-master-woocommerce-status-option-yes">
			<?php _e( 'Yes', 'cache-master' ); ?><br />
		<label>
	</div>
	<div class="scm-option-item">
		<input type="radio" name="scm_option_woocommerce_status" id="cache-master-woocommerce-status-option-no" value="no" 
			<?php checked( $option_woocommerce_status, 'no' ); ?>>
		<label for="cache-master-woocommerce-status-option-no">
			<?php _e( 'No', 'cache-master' ); ?>
		<label>
	</div>	
</div>
<p><em><?php _e( 'Support to WooCommerce plugin.', 'cache-master' ); ?></em></p>
<p><em><?php _e( 'The following settings work only when this option is enabled.', 'cache-master' ); ?></em></p>
<p><em class="scm-msg scm-msg-notice"><?php _e( "When a user's shopping cart is not empty, Cache Master will stop outputting cache.", 'cache-master' ); ?></em></p>