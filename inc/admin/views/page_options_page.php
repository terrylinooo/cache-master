<?php
/**
 * Cache Master - Options page.
 *
 * @author Terry Lin
 * @link https://terryl.in/
 * @since 1.2.1
 * @version 1.2.1
 */

if ( ! defined( 'SCM_INC' ) ) {
	die;
}

$conflict_plugins = array(
    'clearfy/clearfy.php',
);

foreach ( $conflict_plugins as $plugin ) {
    if ( is_plugin_active( $plugin ) ) {
        ?>

        <div class="notice notice-warning is-dismissible">
            <p>
                <?php  echo sprintf( __( 'Cache Master cannot work with the plugin "%s" becasue of output buffer conflicts.', 'cache-master' ), $plugin ); ?>
            </p>
        </div>

        <?php
    }
}
?>

<form action="options.php" method="post">
    <?php settings_fields( 'scm_setting_group_1' ); ?>
    <?php do_settings_sections( 'scm_setting_page_1' );  ?>
    <hr />
    <?php submit_button(); ?>
</form>