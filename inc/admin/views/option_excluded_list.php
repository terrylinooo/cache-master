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

$option_excluded_list = get_option( 'scm_option_excluded_list_filtered', '' );

?>

<div>
	<div class="scm-option-item">
		<textarea name="scm_option_excluded_list" class="scm-texatrea" rows="15" cols="70"><?php echo $option_excluded_list; ?></textarea>
	</div>	
</div>
<p><em><?php _e( 'Please enter the <strong>begin with</strong> URLs you want them excluded from Cache Master.', 'cache-master' ); ?></em></p>
<p><em><?php _e( 'An URL per line.', 'cache-master' ); ?></em></p>
<p><em><?php _e( 'For example, use <code>/custom-type/</code> instead of <code>www.example.com/custom-type/1/</code> for a web page.', 'cache-master' ); ?></em></p>




