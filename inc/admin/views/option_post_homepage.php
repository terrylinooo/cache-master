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

$option_post_homepage = get_option( 'scm_option_post_homepage', 'yes' );

?>

<div>
	<div>
		<input type="radio" name="scm_option_post_homepage" id="cache-master-post-homepage-option-yes" value="yes" 
			<?php checked( $option_post_homepage, 'yes' ); ?>>
		<label for="cache-master-post-homepage-option-yes">
			<?php echo __( 'Yes', 'cache-master' ); ?><br />
		<label>
	</div>
	<div>
		<input type="radio" name="scm_option_post_homepage" id="cache-master-post-homepage-option-no" value="no" 
			<?php checked( $option_post_homepage, 'no' ); ?>>
		<label for="cache-master-post-homepage-option-no">
			<?php echo __( 'No', 'cache-master' ); ?>
		<label>
	</div>	
</div>
<p><em><?php echo __( 'Would you like to cache the homepage of your site?', 'cache-master' ); ?></em></p>
<p><em><?php echo __( 'Once you change this option, all cache data will be cleared.', 'cache-master' ); ?></em></p>