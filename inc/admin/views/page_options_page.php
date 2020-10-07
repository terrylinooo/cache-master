<?php
/**
 * Cache Master - Options page.
 *
 * @author Terry Lin
 * @link https://terryl.in/
 * @since 1.2.1
 * @version 1.0.0
 */

if ( ! defined( 'SCM_INC' ) ) {
	die;
}
?>

<form action="options.php" method="post">
    <?php settings_fields( 'scm_setting_group_1' ); ?>
    <?php do_settings_sections( 'scm_setting_page_1' );  ?>
    <hr />
    <?php submit_button(); ?>
</form>