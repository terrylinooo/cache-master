<?php
/**
 * Cache Master - TTL.
 *
 * @author Terry Lin
 * @link https://terryl.in/
 * @since 1.0.0
 * @version 1.0.0
 */

if ( ! defined( 'SCM_INC' ) ) {
	die;
}

$option_ttl = (int) get_option( 'scm_option_ttl', '86400' );

// 5 minutes.
if ( $option_ttl < 300 ) {
	$option_ttl = '300';
	update_option( 'scm_option_ttl', $option_ttl );
}

// 24 hours.
if ( $option_ttl > 86400 ) {
	$option_ttl = '86400';
	update_option( 'scm_option_ttl', $option_ttl );
}

?>

<div>
	<div>
		<input type="text" name="scm_option_ttl" value="<?php echo esc_attr( $option_ttl ); ?>">
	</div>
</div>
<p><em><?php _e( 'Please fill in a number between 300-86400. (in seconds)', 'cache-master' ); ?></em></p>

