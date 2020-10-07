<?php
/**
 * Cache Master - Post types.
 *
 * @author Terry Lin
 * @link https://terryl.in/
 * @since 1.2.1
 * @version 1.0.0
 */

if ( ! defined( 'SCM_INC' ) ) {
	die;
}


$option_post_types = get_option( 'scm_option_post_types');

$option_list = array(
	'home' => __( 'Home', 'cache-master' ),
	'post' => __( 'Post', 'cache-master' ),
	'page' => __( 'Page', 'cache-master' ),
);

?>

<div>
	<?php foreach ( $option_list as $k => $v ) : ?>
	<div>
		<input type="checkbox" name="scm_option_post_types[<?php echo $k; ?>]" id="cache-master-post-type-option-<?php echo $k; ?>" value="yes" 
			<?php checked( $option_post_types[ $k ], 'yes' ); ?>>
		<label for="cache-master-post-type-option-<?php echo $k; ?>">
			<?php echo $v; ?><br />
		<label>
	</div>
	<?php endforeach; ?>
</div>
<p><em><?php echo __( 'What post type do you like to cache?', 'cache-master' ); ?></em></p>
<p><em><?php echo __( 'Once you change this option, all cache data will be cleared.', 'cache-master' ); ?></em></p>

