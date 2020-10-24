<?php
/**
 * Cache Master - WooCommerce - Post archives.
 *
 * @author Terry Lin
 * @link https://terryl.in/
 * @since 1.6.0
 * @version 1.6.0
 */

if ( ! defined( 'SCM_INC' ) ) {
	die;
}


$option_post_archives = get_option( 'scm_option_woocommerce_post_archives' );

$option_list = array(
	'product_category' => __( 'Product category', 'cache-master' ),
    'product_tag'      => __( 'Product tag', 'cache-master' ),
);

?>

<div>
	<?php foreach ( $option_list as $k => $v ) : ?>
	<div class="scm-option-item">
		<input type="checkbox" name="scm_option_woocommerce_post_archives[<?php echo $k; ?>]" id="cache-master-post-archive-option-<?php echo $k; ?>" value="yes" 
			<?php if ( isset( $option_post_archives[ $k ] ) ) : ?>
				<?php checked( $option_post_archives[ $k ], 'yes' ); ?>
            <?php endif; ?>
        >
		<label for="cache-master-post-archive-option-<?php echo $k; ?>">
			<?php echo $v; ?><br />
		<label>
	</div>
	<?php endforeach; ?>
</div>
<p><em><?php _e( 'What type of archive page do you like to cache?', 'cache-master' ); ?></em></p>

