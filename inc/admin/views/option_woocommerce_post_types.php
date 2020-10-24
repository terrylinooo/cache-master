<?php
/**
 * Cache Master - WooCommerce - Post types.
 *
 * @author Terry Lin
 * @link https://terryl.in/
 * @since 1.6.0
 * @version 1.6.0
 */

if ( ! defined( 'SCM_INC' ) ) {
	die;
}

$option_post_types = get_option( 'scm_option_woocommerce_post_types' );

$option_list = array(
	'product' => __( 'Product', 'cache-master' ),
);

?>

<div>
	<?php foreach ( $option_list as $k => $v ) : ?>
	<div class="scm-option-item">
		<input type="checkbox" name="scm_option_woocommerce_post_types[<?php echo $k; ?>]" id="cache-master-post-type-option-<?php echo $k; ?>" value="yes"
			<?php if ( isset( $option_post_types[ $k ] ) ) : ?>
				<?php checked( $option_post_types[ $k ], 'yes' ); ?>
            <?php endif; ?>
        >
		<label for="cache-master-post-type-option-<?php echo $k; ?>">
			<?php echo $v; ?><br />
		<label>
	</div>
	<?php endforeach; ?>
</div>
<p><em><?php _e( 'What post type do you like to cache?', 'cache-master' ); ?></em></p>
