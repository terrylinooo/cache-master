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

$option_ttl           = (int) get_option( 'scm_option_ttl', '86400' );
$option_ttl_mechanism = get_option( 'scm_option_ttl_mechanism', 'enable' );

// 5 minutes.
if ( $option_ttl < 300 ) {
	$option_ttl = '300';
	update_option( 'scm_option_ttl', $option_ttl );
}

// 1 month.
if ( $option_ttl > 2592000 ) {
	$option_ttl = '2592000';
	update_option( 'scm_option_ttl', $option_ttl );
}

?>

<div>
	<div class="scm-option-item">
		<input type="radio" name="scm_option_ttl_mechanism" id="cache-master-ttl-mechanisum-enable" value="enable" 
			<?php checked( $option_ttl_mechanism, 'enable' ); ?>>
		<label for="cache-master-ttl-mechanisum-enable">
			<?php _e( 'Enable', 'cache-master' ); ?><br />
		<label>
	</div>
	<div class="scm-option-item">
		<input type="radio" name="scm_option_ttl_mechanism" id="cache-master-ttl-mechanisum-disable" value="disable" 
			<?php checked( $option_ttl_mechanism, 'disable' ); ?>>
		<label for="cache-master-ttl-mechanisum-disable">
			<?php _e( 'Disable', 'cache-master' ); ?>
		<label>
	</div>	
</div>
<p><em><?php _e( 'Once you disable this option, Cache Master will not automatically clear and update the cache.', 'cache-master' ); ?></em></p>

<div style="margin-top: 30px">
	<div>
		<input type="text" name="scm_option_ttl" value="<?php echo esc_attr( $option_ttl ); ?>">
	</div>
</div>
<p><em><?php _e( 'Please fill in a number between 300-2592000. (in seconds)', 'cache-master' ); ?></em></p>
<h4><?php _e( 'Examples', 'cache-master' ); ?></h3>
<table class="scm-table-ttl-example">
	<tr>
		<th><?php _e( 'Time', 'cache-master' ); ?></th>
		<th><?php _e( 'Description', 'cache-master' ); ?></th>
	</tr>
	<tr>
		<td>300</td>
		<td><?php _e( '5 minutes', 'cache-master' ); ?></td>
	</tr>
	<tr>
		<td>3600</td>
		<td><?php _e( '1 hour', 'cache-master' ); ?></td>
	</tr>
	<tr>
		<td>86400</td>
		<td><?php _e( '24 hours', 'cache-master' ); ?></td>
	</tr>
	<tr>
		<td>2592000</td>
		<td><?php _e( '30 days', 'cache-master' ); ?></td>
	</tr>
</table>
