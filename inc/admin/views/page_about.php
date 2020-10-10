<?php
/**
 * Cache Master - Stats
 *
 * @author Terry Lin
 * @link https://terryl.in/
 * @since 1.4.0
 * @version 1.4.0
 */

if ( ! defined( 'SCM_INC' ) ) {
	die;
}

?>

<div class="about-us-container">
	<div class="shieldon-cover"><img src="<?php echo SCM_PLUGIN_URL; ?>inc/assets/images/banner-772x250.png"></div>
	<div class="shieldon-author">
		<p class="created-by">
			<?php printf( __( 'WP Shieldon is brought to you by <a href="%1$s">Terry L.</a> from <a href="%2$s">Taiwan</a>.', 'cache-master' ), 'https://terryl.in', 'https://www.google.com/maps/@23.4722181,120.9910232,8z'); ?>
		</p>
		<div class="info-links">
			<ul>
				<li><a href="https://github.com/terrylinooo"><img src="<?php echo SCM_PLUGIN_URL; ?>inc/assets/images/icon_github.png"></a></li>
				<li><a href="https://profiles.wordpress.org/terrylin/"><img src="<?php echo SCM_PLUGIN_URL; ?>inc/assets/images/icon_wordpress.png"></a></li>
				<li><a href="https://www.facebook.com/terrylinooo/"><img src="<?php echo SCM_PLUGIN_URL; ?>inc/assets/images/icon_facebook.png"></a></li>
				<li><a href="https://terryl.in"><img src="<?php echo SCM_PLUGIN_URL; ?>inc/assets/images/icon_terryl.png"></a></li>
			</ul>
		</div>
		<p><?php echo __( 'If you have any issues, or found any bugs, please report them in the following URL.', 'cache-master' ); ?></p>
		<div class="report-area">
			<span><a href="https://github.com/terrylinooo/simple-cache" target="_blank"><?php echo __( 'Core', 'cache-master' ); ?></a></span>
			<span><a href="https://github.com/terrylinooo/cache-master" target="_blank"><?php echo __( 'Plugin', 'cache-master' ); ?></a></span>
		</div>
	</div>
</div>