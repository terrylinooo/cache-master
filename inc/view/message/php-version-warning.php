<?php

if ( ! defined('SCM_PLUGIN_NAME') ) die;

/**
 * Show PHP version notice.
 *
 * @author Terry Lin
 * @link https://terryl.in/
 *
 * @package Cache Master
 * @since 1.0.0
 * @version 1.0.0
 */
$php_version = phpversion();

?>

<div class="notice notice-error is-dismissible">
	<p>
		<?php printf( __( 'The minimum required PHP version for Cache Master Plugin is PHP <strong>7.1.0</strong>, and yours is <strong>%1s</strong>.', 'cache-master' ), phpversion() ) ?> <br>
		<?php echo __( 'Please remove WP Githuber MD or upgrade your PHP version.', 'cache-master' ); ?>
	</p>
</div>