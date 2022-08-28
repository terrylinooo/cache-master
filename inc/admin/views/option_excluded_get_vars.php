<?php
/**
 * Cache Master - Exluded List
 *
 * @author Terry Lin
 * @link https://terryl.in/
 * @since 1.6.0
 * @version 1.6.0
 */

if ( ! defined( 'SCM_INC' ) ) {
	die;
}

$option_excluded_get_vars = get_option( 'scm_option_excluded_get_vars', '' );

?>

<div>
	<div class="scm-option-item">
		<textarea name="scm_option_excluded_get_vars" class="scm-texatrea" rows="3" cols="30"><?php echo $option_excluded_get_vars; ?></textarea>
	</div>	
</div>
<p><em><?php _e( 'Any request contains those variables, even its value is empty, Caster Master will ignore.', 'cache-master' ); ?></em></p>
<p><em><?php _e( 'A variable key per line.', 'cache-master' ); ?></em></p>
